<?php
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $answers = $data['answer'];
    $user_id = $data['user_id'];
    $exam_id = $data['exam_id'];
    
    $dbuser = 'mem63';
    $dbpass = 'CS490:data-base';
    
    $db = new PDO('mysql:host=sql1.njit.edu;dbname=mem63', $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  	if(!$db){
  		  die("Fatal Error: Connection Failed!");
  	}
    
    $data = [];
    
    $stmt = $db->prepare("SELECT eqid FROM exam_questions WHERE exam_id = :eid;");
    try {
        $r = $stmt->execute([":eid" => $exam_id]);
        if ($r) {
            $eqids = $stmt->fetchALL(PDO::FETCH_ASSOC);
        }
    } catch (Exception $e) {
        echo "FAIL";
    }
    
    $i = 0;
    
    foreach($answers as $answer) {
        $current_eqid = $eqids[$i]['eqid'];
        $stmt = $db->prepare("INSERT INTO student_answers (exam_id, student_id, exam_qid, student_answer) VALUES (:eid, :sid, :eqid, :answer)");
        
        
        try {
            $r = $stmt->execute([":eid" => $exam_id, ":sid" => $user_id, ":eqid" => $current_eqid, ":answer" => $answers[$i]]);
            if ($r) {
                echo "TRUE";
            }
        } catch (Exception $e) {
            echo "FAIL";
        } 
        $i++;
    } 
    
    $stmt = $db->prepare("UPDATE student_exams SET submitted = 1 WHERE exam_id = :eid AND student_id = :sid;");
    try {
        $r = $stmt->execute([":eid" => $exam_id, ":sid" => $user_id]);
        if ($r) {
            $eqids = $stmt->fetchALL(PDO::FETCH_ASSOC);
        }
    } catch (Exception $e) {
        echo "FAIL";
    }
    //echo json_encode($data);
    
?>