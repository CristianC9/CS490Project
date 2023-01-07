<?php
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $eid = $data['exam_id'];
    $isPublished = $data['isPublished'];
    
    $dbuser = 'mem63';
    $dbpass = 'CS490:data-base';
    
    $db = new PDO('mysql:host=sql1.njit.edu;dbname=mem63', $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  	if(!$db){
  		  die("Fatal Error: Connection Failed!");
  	}
   
    $data = [];
    if ($isPublished == "Publish") {
        $stmt = $db->prepare("UPDATE exams SET published = 1 WHERE exam_id = :eid;");
    } else {
        $stmt = $db->prepare("UPDATE exams SET published = 0 WHERE exam_id = :eid;");
    }
    try {
        $r = $stmt->execute([":eid" => $eid]);
        if ($r) {
            $data = array(
                'success' => 1,
                'message' => "Exam updated successfully"
            );
        } else {
            echo "FAIL";
        }
    } catch (Exception $e) {
        echo "DOUBLE FAIL";
    }
    echo json_encode($data);
    
?>