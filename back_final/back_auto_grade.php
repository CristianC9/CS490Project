<?php

    $data = json_decode(file_get_contents('php://input'), true);
    $student_id = $data['student_id'];
    $exam_id = $data['exam_id'];
    
    $dbuser = 'mem63';
    $dbpass = 'CS490:data-base';
    
    $db = new PDO('mysql:host=sql1.njit.edu;dbname=mem63', $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  	if(!$db){
  		  die("Fatal Error: Connection Failed!");
  	}
   
    $data = [];
    $stmt = $db->prepare("SELECT tcid, eqid, qid, input, output, student_answer, student_id, exams.exam_id, qb.function_name, qb.qconstraint FROM test_cases AS tc INNER JOIN question_bank AS qb ON tc.question_id = qb.qid INNER JOIN exam_questions AS eq on qb.qid = eq.question_id INNER JOIN exams ON eq.exam_id = exams.exam_id INNER JOIN student_answers AS sa ON eqid = sa.exam_qid WHERE exams.exam_id = :eid AND student_id = :sid");
    try {
        $r = $stmt->execute([":eid" => $exam_id, ":sid" => $student_id]);
        if ($r) {
            $test_cases = $stmt->fetchALL(PDO::FETCH_ASSOC);
        } else {
            echo "FAIL";
        }
    } catch (Exception $e) {
        echo "DOUBLE FAIL";
    }
    $data = array(
        'test_cases' => $test_cases
    );
    echo json_encode($data);
?>