<?php
    $data = json_decode(file_get_contents('php://input'), true);
    if (true) {
        $question = $data['question'];
        $function_name = $data['functionname'];
        $topic = $data['topic'];
        $difficulty = $data['difficulty'];
        $cases = $data['case'];
        $outputs = $data['output'];
        $tcids = $data['tcid'];
        $qid = $data['qid'];
        $constraint = $data['constraint'];
        
        $dbuser = 'mem63';
        $dbpass = 'CS490:data-base';
        
        $db = new PDO('mysql:host=sql1.njit.edu;dbname=mem63', $dbuser, $dbpass);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      	if(!$db){
      		  die("Fatal Error: Connection Failed!");
      	}
       
        $data = [];
        $stmt = $db->prepare("UPDATE question_bank SET question = :ques, function_name = :fname, topic = :topic, difficulty = :diff, qconstraint = :cons WHERE qid = :id;");
        try {
            $r = $stmt->execute([":ques" => $question, ":fname" => $function_name, ":topic" => $topic, ":diff" => $difficulty, ":cons" => $constraint, ":id" => $qid]);
            if ($r) {
                echo "TRUE";
            }
        } catch (Exception $e) {
            echo "FAIL";
        }        
        $stmt = $db->prepare("UPDATE test_cases SET input = :in, output = :out WHERE tcid = :id;");
        for ($i = 0; $i < count($tcids); $i++) {
            try {
                $r = $stmt->execute([":in" => $cases[$i], ":out" => $outputs[$i], ":id" => $tcids[$i]]);
                if ($r) {
                    echo "TRUE";
                }
            } catch (Exception $e) {
                echo "FAIL";
            }
        }
    }
?>