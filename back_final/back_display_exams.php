<?php
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $dbuser = 'mem63';
    $dbpass = 'CS490:data-base';
    
    $db = new PDO('mysql:host=sql1.njit.edu;dbname=mem63', $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  	if(!$db){
  		  die("Fatal Error: Connection Failed!");
  	}
   
    $data = [];
    $stmt = $db->prepare("SELECT * FROM exams INNER JOIN student_exams AS se ON exams.exam_id = se.exam_id WHERE published = 1;");
    try {
        $r = $stmt->execute();
        if ($r) {
            $questions = $stmt->fetchALL(PDO::FETCH_ASSOC);
        } else {
            echo "FAIL";
        }
    } catch (Exception $e) {
        echo "DOUBLE FAIL";
    }
    
    $data = array(
        'exams' => $questions
    );
    echo json_encode($data);
?>