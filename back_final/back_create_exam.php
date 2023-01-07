<?php
    $data = json_decode(file_get_contents('php://input'), true);
    if (true) {
        //echo json_encode($data);
        $exam_title = $data['exam'];
        $description = $data['description'];
        $qid1 = $data['qid1'];
        $qid2 = $data['qid2'];
        $qid3 = $data['qid3'];
        if (isset($data['qid4']))
            $qid4 = $data['qid4'];
        if (isset($data['qid5']))
            $qid5 = $data['qid5'];
        $points1 = $data['points1'];
        $points2 = $data['points2'];
        $points3 = $data['points3'];
        if (isset($data['points4']))
            $points4 = $data['points4'];
        else $points4 = 0;
        if (isset($data['points4']))
            $points5 = $data['points5'];
        else $points5 = 0;
        
        $total_points = $points1 + $points2 + $points3 + $points4 + $points5;
        
        $dbuser = 'mem63';
        $dbpass = 'CS490:data-base';
        
        $db = new PDO('mysql:host=sql1.njit.edu;dbname=mem63', $dbuser, $dbpass);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      	if(!$db){
      		  die("Fatal Error: Connection Failed!");
      	}
       
        $data = [];
        $stmt = $db->prepare("INSERT INTO exams (exam_title, exam_description, total_points) VALUES (:title, :desc, :tp);");
        try {
            $r = $stmt->execute([":title" => $exam_title, ":desc" => $description, ":tp" => $total_points]);
            if ($r) {
                // Question Inserted Successfully
                $stmt = $db->prepare("SELECT exam_id FROM exams ORDER BY created DESC;");
                try {
                    $r = $stmt->execute();
                    if ($r) {
                        // ID Selected Successfully
                        $id = $stmt->fetch(PDO::FETCH_ASSOC);
                        $eid = $id['exam_id'];
                        $stmt = $db->prepare("INSERT INTO exam_questions (question_id, exam_id, points) VALUES (:qid, :eid, :p);");
                        try {
                            $r = $stmt->execute([":qid" => $qid1, ":eid" => $eid, ":p" => $points1]);
                            $s = $stmt->execute([":qid" => $qid2, ":eid" => $eid, ":p" => $points2]);
                            $t = $stmt->execute([":qid" => $qid3, ":eid" => $eid, ":p" => $points3]);
                            if (isset($qid4))
                                $u = $stmt->execute([":qid" => $qid4, ":eid" => $eid, ":p" => $points4]);
                            if (isset($qid5))
                                $v = $stmt->execute([":qid" => $qid5, ":eid" => $eid, ":p" => $points5]);
                            if ($r and $s and $t) {
                                $stmt = $db->prepare("SELECT id FROM users WHERE role = 'student';");
                                try {
                                    $r = $stmt->execute();
                                    if ($r) {
                                        $students = $stmt->fetchALL(PDO::FETCH_ASSOC);
                                        $stmt = $db->prepare("INSERT INTO student_exams (student_id, exam_id) VALUES (:sid, :eid);");
                                        try {
                                            $data = [];
                                            foreach ($students as $student) {
                                                $r = $stmt->execute([":sid" => $student['id'], ":eid" => $eid]);
                                            }
                                            $data = array(
                                                'success' => 1,
                                                'message' => "Exam created successfully",
                                                'students' => $students
                                            );
                                        } catch (Exception $e) {
                                            // Error creating exam for each student
                                            $data = array(
                                                'success' => 0,
                                                'message' => "Error creating exam for each student"
                                            );
                                        }
                                    }
                                } catch (Exception $e) {
                                    // Error getting users
                                    $data = array(
                                        'success' => 0,
                                        'message' => "Error getting users"
                                    );
                                }
                                
                            } else {
                                $data = array(
                                    'success' => 0,
                                    'message' => "Error inserting questions",
                                    'qid1' => $r,
                                    'qid2' => $s,
                                    'qid3' => $t,
                                    'qid4' => $u
                                );
                            }
                            
                        } catch (Exception $e) {
                            // Error inserting questions
                            $data = array(
                                'success' => 0,
                                'message' => "Error inserting questions"
                            );
                        }
                    }
                } catch (Exception $e) {
                    // Error getting exam ID
                    $data = array(
                        'success' => 0,
                        'message' => "Error getting exam ID"
                    );
                }
            }
        } catch (Exception $e) {
            // Error creating exam
            $data = array(
                'success' => 0,
                'message' => "Error creating exam"
            );
        }
    }
    
    echo json_encode($data);
?>