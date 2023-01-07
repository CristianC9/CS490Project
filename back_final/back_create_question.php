<?php
    $data = json_decode(file_get_contents('php://input'), true);
    if (true) {
        $question = $data['question'];
        $function_name = $data['functionname'];
        $topic = $data['topic'];
        $difficulty = $data['difficulty'];
        $constraint = $data['constraint'];
        $cases = $data['case'];
        $outputs = $data['output'];
        
        $dbuser = 'mem63';
        $dbpass = 'CS490:data-base';
        
        $db = new PDO('mysql:host=sql1.njit.edu;dbname=mem63', $dbuser, $dbpass);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      	if(!$db){
      		  die("Fatal Error: Connection Failed!");
      	}
        
        $num_tests = 1 + count($cases);
        if ($constraint) {
            $num_tests += 1;
        }
       
        $data = [];
        $stmt = $db->prepare("INSERT INTO question_bank (question, function_name, topic, difficulty, qconstraint, num_tests) VALUES (:ques, :fname, :topic, :diff, :cons, :num);");
        try {
            $r = $stmt->execute([":ques" => $question, ":fname" => $function_name, ":topic" => $topic, ":diff" => $difficulty, ":cons" => $constraint, ":num" => $num_tests]);
            if ($r) {
                // Question Inserted Successfully
                $stmt = $db->prepare("SELECT qid FROM question_bank ORDER BY created DESC;");
                try {
                    $r = $stmt->execute();
                    if ($r) {
                        // ID Selected Successfully
                        $id = $stmt->fetch(PDO::FETCH_ASSOC);
                        $qid = $id['qid'];
                        $stmt = $db->prepare("INSERT INTO test_cases (question_id, input, output) VALUES (:qid, :input, :output);");
                        try {
                            for ($i = 0; $i < count($cases); $i++) {
                                $r = $stmt->execute([":qid" => $qid, ":input" => $cases[$i], ":output" => $outputs[$i]]);
                            }
                            if ($r) {
                                // Test cases Inserted Successfully
                                $data = array(
                                    'success' => 1,
                                    'message' => "Question added successfully"
                                );
                            }
                        } catch (Exception $e) {
                            // Test Cases not inserted successfully
                            $data = array(
                                'success' => 0,
                                'message' => "Test Cases not inserted successfully"
                            );
                        }
                    }
                } catch (Exception $e) {
                    // ID Not selected successfully
                    $data = array(
                        'success' => 0,
                        'message' => "An unexpected error occurred."
                    );
                }
            } else {
                // Question not inserted successfully
                $data = array(
                    'success' => 0,
                    'message' => "Question not inserted successfully"
                );
            }
        } catch (Exception $e) {
            // Database connection error
            $data = array(
                'success' => 0,
                'message' => "An unexpected error occurred."
            );
        }
    }
    echo json_encode($data);
?>