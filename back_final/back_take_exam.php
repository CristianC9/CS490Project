<?php
    $data = json_decode(file_get_contents('php://input'), true);
    if (true) {
        $eid = $data['exam_id'];
        
        $dbuser = 'mem63';
        $dbpass = 'CS490:data-base';
        
        $db = new PDO('mysql:host=sql1.njit.edu;dbname=mem63', $dbuser, $dbpass);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      	if(!$db){
      		  die("Fatal Error: Connection Failed!");
      	}
       
        $data = [];
        $stmt = $db->prepare("SELECT * FROM exam_questions INNER JOIN question_bank ON exam_questions.question_id = question_bank.qid WHERE exam_id = :eid ORDER BY eqid;");
        try {
            $r = $stmt->execute([":eid" => $eid]);
            if ($r) {
                $questions = $stmt->fetchALL(PDO::FETCH_ASSOC);
            } else {
                echo "FAIL";
            }
        } catch (Exception $e) {
            echo "DOUBLE FAIL";
        }
        $stmt = $db->prepare("SELECT * FROM exams WHERE exam_id = :eid;");
        try {
            $r = $stmt->execute([":eid" => $eid]);
            if ($r) {
                $exam_data = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                echo "FAIL";
            }
        } catch (Exception $e) {
            echo "DOUBLE FAIL";
        }
    }
    $exam_title = $exam_data['exam_title'];
    $description = $exam_data['exam_description'];
    
    
    $data = array(
        'exam_id' => $eid,
        'exam_title' => $exam_title,
        'description' => $description,
        'questions' => $questions
    );
    echo json_encode($data);
?>