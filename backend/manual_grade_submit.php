<?php
    require("../functions.php");


    session_start();



    $url = 'https://afsaccess4.njit.edu/~cec44/middle_grade_submit.php';
        
        // Create a new cURL resource
        $ch = curl_init($url);
        $comments = $_POST['comments'];
        $function_scores = $_POST['function_scores'];
        $test_case_scores= $_POST['test_case_scores'];
        $student_id= $_POST['student_id'];
        $exam_id = $_POST['exam_id'];
        // Setup request to send json via POST
        $data = array(
            'test_case_scores' => $test_case_scores,
            'comments' => $comments,
            'function_scores' => $function_scores,
            'exam_id' => $exam_id,
            'student_id'=> $student_id
        );
        $json_data = json_encode($data);

        
        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        
        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        
        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Execute the POST request
        $result = curl_exec($ch);
        $response = json_decode($result, true);

        // Close cURL resource
        curl_close($ch);
        var_dump($result);
        

        echo '<script>window.location=("https://afsaccess4.njit.edu/~jl2237/teacher/grade.php") </script>';
?>

