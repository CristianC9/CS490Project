<?php
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $sid = $data['student_id'];
    $eid = $data['exam_id'];
    
    $dbuser = 'mem63';
    $dbpass = 'CS490:data-base';
    
    $db = new PDO('mysql:host=sql1.njit.edu;dbname=mem63', $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  	if(!$db){
  		  die("Fatal Error: Connection Failed!");
  	}
    
    $data = [];
    
    $stmt = $db->prepare("SELECT exam_title, exam_description, total_points FROM exams WHERE exam_id = :eid;");
        try {
            $r = $stmt->execute([":eid" => $eid]);
            if ($r) {
                $exam_data = $stmt->fetchALL(PDO::FETCH_ASSOC);
            } else {
                echo "FAIL1";
            }
        } catch (Exception $e) {
            echo "DOUBLE FAIL";
        }
        
        $stmt = $db->prepare("SELECT * FROM exam_questions as eq INNER JOIN question_bank ON eq.question_id = question_bank.qid INNER JOIN student_answers AS sa ON eqid = sa.exam_qid INNER JOIN comments AS c ON c.exam_qid = eq.eqid WHERE eq.exam_id = :eid;");
        try {
            $r = $stmt->execute([":eid" => $eid]);
            if ($r) {
                $questions = $stmt->fetchALL(PDO::FETCH_ASSOC);
            } else {
                echo "FAIL2";
            }
        } catch (Exception $e) {
            echo "DOUBLE FAIL";
        }
        
        $stmt = $db->prepare("SELECT eqid, eq.exam_id, points, question, test_case_id, input, output, passed, score, student_output FROM exam_questions AS eq INNER JOIN question_bank AS qb ON eq.question_id = qb.qid INNER JOIN student_test_cases AS stc ON eq.eqid = stc.exam_qid INNER JOIN test_cases AS tc ON test_case_id = tc.tcid WHERE eq.exam_id = :eid AND stc.student_id = :sid");
        try {
            $r = $stmt->execute([":eid" => $eid, ":sid" => $sid]);
            if ($r) {
                $test_cases = $stmt->fetchALL(PDO::FETCH_ASSOC);
            } else {
                echo "FAIL3";
            }
        } catch (Exception $e) {
            echo "DOUBLE FAIL";
        }
        
        $stmt = $db->prepare("SELECT score FROM student_exams WHERE exam_id = :eid AND student_id = :sid;");
        try {
            $r = $stmt->execute([":eid" => $eid, ":sid" => $sid]);
            if ($r) {
                $student_score = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                echo "FAIL2";
            }
        } catch (Exception $e) {
            echo "DOUBLE FAIL";
        }
    
    $exam_title = $exam_data[0]['exam_title'];
    $description = $exam_data[0]['exam_description'];
    $total_points = $exam_data[0]['total_points'];
    
    
    $data = array(
        'exam_id' => $eid,
        'student_id' => $sid,
        'exam_title' => $exam_title,
        'description' => $description,
        'total_points' => $total_points,
        'student_score' => $student_score['score'],
        'questions' => $questions,
        'test_cases' => $test_cases
    );
    echo json_encode($data);
?>