<?php
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $test_cases = $data;
    $eid = $data[0]["exam_id"];
    $sid = $data[0]["student_id"];
    
    
    $dbuser = 'mem63';
    $dbpass = 'CS490:data-base';
    
    $db = new PDO('mysql:host=sql1.njit.edu;dbname=mem63', $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  	if(!$db){
  		  die("Fatal Error: Connection Failed!");
  	}
   
    $data = [];
    
    $stmt = $db->prepare("SELECT eqid, points, num_tests FROM exam_questions INNER JOIN question_bank ON question_id = qid WHERE exam_id = :eid;");
    try {
        $r = $stmt->execute([":eid" => $eid]);
        if ($r) {
            $point_values = $stmt->fetchALL(PDO::FETCH_ASSOC);
            array_push($data, "TRUEA");
        } else {
            array_push($data, "FALSE");
        }
    } catch (Exception $e) {
        array_push($data, "Failed to execute.");
    }
    
    $stmt = $db->prepare("INSERT INTO student_test_cases (student_id, test_case_id, exam_qid, passed, student_output, score) VALUES (:sid, :tcid, :eqid, :passed, :sto, :p);");
    try {
        foreach ($test_cases as $test_case) {
            foreach($point_values as $pv) {
                if ($pv['eqid'] == $test_case['eqid']) {
                    if ($test_case['passed']) {
                        $points = $pv['points']/$pv['num_tests'];
                    } else {
                        $points = 0;
                    }
                }
            }
            $r = $stmt->execute([":sid" => $test_case['student_id'], ":tcid" => $test_case['tcid'], ":eqid" => $test_case['eqid'], "passed" => $test_case['passed'], ":sto" => $test_case['student_output'], ":p" => $points]);
            if ($r) {
                array_push($data, "TRUE");
            } else {
                array_push($data, "FALSE");
            }
        }
    } catch (Exception $e) {
        array_push($data, "Failed to execute.");
    }
    
    $stmt = $db->prepare("SELECT exam_qid, sum(score) AS t_score FROM `student_test_cases` INNER JOIN exam_questions ON exam_qid = eqid WHERE exam_id = :eid GROUP BY exam_qid;");
    try {
        $r = $stmt->execute([":eid" => $eid]);
        if ($r) {
            $qpoint_values = $stmt->fetchALL(PDO::FETCH_ASSOC);
            array_push($data, "TRUE2");
        } else {
            array_push($data, "FALSE2");
        }
    } catch (Exception $e) {
        array_push($data, "Failed to execute2.");
    } 
    
    $stmt = $db->prepare("UPDATE student_answers SET correct_name = :cn, constraint_score = :qcon, score = :sc WHERE student_id = :sid AND exam_qid = :eqid;");
    try {
        foreach ($test_cases as $test_case) {
            foreach($qpoint_values as $qpv) {
                if ($qpv['exam_qid'] == $test_case['eqid']) {
                    $score = $qpv['t_score'];
                }
            }
            foreach($point_values as $pv) {
                if ($pv['eqid'] == $test_case['eqid']) {
                    $mult = $pv['points']/$pv['num_tests'];
                }
            }
            $cn = $test_case['passed_func']*$mult;
            $qcon = $test_case['passed_constraint']*$mult;
            
            $r = $stmt->execute([":cn" => $cn, ":qcon" => $qcon, ":sc" => $score + $cn + $qcon, ":sid" => $test_case['student_id'], ":eqid" => $test_case['eqid']]);
            if ($r) {
                array_push($data, $test_case['passed_constraint']);
            } else {
                array_push($data, "FALSE2");
            }
        }
    } catch (Exception $e) {
        array_push($data, "Failed to execute2.");
    } 
    
    $stmt = $db->prepare("SELECT sum(score) AS t_score FROM `student_answers` WHERE exam_id = :eid;");
    try {
        $r = $stmt->execute([":eid" => $eid]);
        if ($r) {
            $total = $stmt->fetch(PDO::FETCH_ASSOC);
            array_push($data, "TRUE2");
        } else {
            array_push($data, "FALSE2");
        }
    } catch (Exception $e) {
        array_push($data, "Failed to execute2.");
    } 
    
    $stmt = $db->prepare("UPDATE student_exams SET graded = 1, score = :sc WHERE student_id = :sid AND exam_id = :eid;");
    try {
        $r = $stmt->execute([":sc" => $total['t_score'],":sid" => $sid, ":eid" => $eid]);
        if ($r) {
            array_push($data, "TRUE2");
        } else {
            array_push($data, "FALSE2");
        }
    } catch (Exception $e) {
        array_push($data, "Failed to execute2.");
    } 
    
    echo json_encode($data);
    
?>