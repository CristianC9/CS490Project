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
    $stmt = $db->prepare("SELECT * FROM question_bank;");
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
    $stmt = $db->prepare("SELECT * FROM test_cases;");
    try {
        $r = $stmt->execute();
        if ($r) {
            $test_cases = $stmt->fetchALL(PDO::FETCH_ASSOC);
        } else {
            echo "FAIL 2";
        }
    } catch (Exception $e) {
        echo "DOUBLE FAIL 2";
    }
    $data = array(
        'questions' => $questions,
        'test_cases' => $test_cases
    );
    echo json_encode($data);
    
?>