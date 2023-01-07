<?php
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $eid = $data['exam_id'];
    $sid = $data['student_id'];
    $test_case_scores = $data['test_case_scores'];
    $function_scores = $data['function_scores'];
    $constraint_scores = $data['constraint_scores'];
    $comments = $data['comments'];
    
    $dbuser = 'mem63';
    $dbpass = 'CS490:data-base';
    
    $db = new PDO('mysql:host=sql1.njit.edu;dbname=mem63', $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  	if(!$db){
  		  die("Fatal Error: Connection Failed!");
  	}
    $data = [];
    
    $stmt = $db->prepare("SELECT stc.id, eqid FROM student_test_cases AS stc INNER JOIN exam_questions AS eq ON stc.exam_qid = eq.eqid WHERE exam_id = :eid AND student_id = :sid;");
    try {
        $r = $stmt->execute([":eid" => $eid, ":sid" => $sid]);
        if ($r) {
            $stc_ids = $stmt->fetchALL(PDO::FETCH_ASSOC);
        } else {
            array_push($data, "FAIL1");
        }
    } catch (Exception $e) {
        array_push($data, "DOUBLE FAIL1");
    }
    
    $i = 0;
    foreach($test_case_scores as $tc) {
        $stmt = $db->prepare("UPDATE student_test_cases SET score = :score WHERE id = :stcid;");
        try {
            $r = $stmt->execute([":score" => $tc, ":stcid" => $stc_ids[$i]['id']]);
            if ($r) {
                //array_push($data, "TRUE");
            } else {
                array_push($data, "FAIL2");
            }
        } catch (Exception $e) {
            array_push($data, "DOUBLE FAIL2");
        }
        $i++;
    }
    
    $stmt = $db->prepare("SELECT exam_qid, sum(stc.score) AS t_score FROM `student_test_cases` AS stc INNER JOIN exam_questions ON exam_qid = eqid WHERE exam_id = :eid GROUP BY exam_qid;");
    try {
        $r = $stmt->execute([":eid" => $eid]);
        if ($r) {
            $qpoint_values = $stmt->fetchALL(PDO::FETCH_ASSOC);
            //array_push($data, "TRUE2");
        } else {
            array_push($data, "FALSE2");
        }
    } catch (Exception $e) {
        array_push($data, "Failed to execute2.");
    } 
    
    $i = 0;
    for($j = 0; $j < count($function_scores); $j++) {
        foreach($qpoint_values as $qpv) {
            if ($qpv['exam_qid'] == $stc_ids[$i]['eqid']) {
                $score = $qpv['t_score'];
            }
        }
        $current = $stc_ids[$i]['eqid'];
        $stmt = $db->prepare("UPDATE student_answers SET correct_name = :cn, constraint_score = :cs, score = :sc WHERE exam_qid = :eqid;");
        try {
            //echo $stc_ids[$i]['eqid'];
            $fs = $function_scores[$j];
            $cs = $constraint_scores[$j];
            $r = $stmt->execute([":cn" => $fs, ":cs" => $cs, ":sc" => $score + $fs + $cs,":eqid" => $stc_ids[$i]['eqid']]);
            if ($r) {
                array_push($data, $stc_ids[$i]['eqid']);
                array_push($data, $fs);
                array_push($data, $cs);
            } else {
                array_push($data, "FAIL3");
            }
        } catch (Exception $e) {
            array_push($data, "DOUBLE FAIL3");
        }
        while ($current == $stc_ids[$i]['eqid']){
            $i++;
        }
    }
    
    $i = 0;
    foreach($comments as $comment) {
        $current = $stc_ids[$i]['eqid'];
        $stmt = $db->prepare("INSERT INTO comments (exam_id, exam_qid, student_id, comment) VALUES (:eid, :eqid, :sid, :comment);");
        try {
            
            $r = $stmt->execute([":eid" => $eid, ":eqid" => $stc_ids[$i]['eqid'], ":sid" => $sid, ":comment" => $comment]);
            if ($r) {
                //array_push($data, "TRUE");
            } else {
                array_push($data, "FAIL2");
            }
        } catch (Exception $e) {
            array_push($data, "DOUBLE FAIL2");
        }
        while ($current == $stc_ids[$i]['eqid']){
            $i++;
        }
    }
    
    $stmt = $db->prepare("SELECT sum(score) AS t_score FROM `student_answers` WHERE exam_id = :eid;");
    try {
        $r = $stmt->execute([":eid" => $eid]);
        if ($r) {
            $total = $stmt->fetch(PDO::FETCH_ASSOC);
            //array_push($data, $total);
        } else {
            array_push($data, "FALSE4");
        }
    } catch (Exception $e) {
        array_push($data, "Failed to execute2.");
    } 
    
    $stmt = $db->prepare("UPDATE student_exams SET released = 1, score = :sc WHERE student_id = :sid AND exam_id = :eid;");
    try {
        
        $r = $stmt->execute([":sc" => $total['t_score'], ":sid" => $sid, ":eid" => $eid]);
        if ($r) {
            //array_push($data, "TRUE5");
        } else {
            array_push($data, "FAIL5");
        }
    } catch (Exception $e) {
        array_push($data, "DOUBLE FAIL2");
    }
    
    echo json_encode($data);
    
?>