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
    $stmt = $db->prepare("SELECT student_id, username, student_exams.exam_id, submitted, graded, exams.exam_title, score FROM student_exams INNER JOIN users ON student_exams.student_id = users.id INNER JOIN exams ON student_exams.exam_id = exams.exam_id;");
    try {
        $r = $stmt->execute();
        if ($r) {
            $student_exams = $stmt->fetchALL(PDO::FETCH_ASSOC);
        } else {
            echo "FAIL";
        }
    } catch (Exception $e) {
        echo "DOUBLE FAIL";
    }
    $data = array(
        'student_exams' => $student_exams
    );
    echo json_encode($data);
    
?>