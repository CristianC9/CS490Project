<?php
    require("../functions.php");
    session_start();
    $role = $_SESSION['role'];
     if(is_logged_in()){ 
        if (!($role == "teacher")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));
   
    }
    $url = 'https://afsaccess4.njit.edu/~cec44/middle_auto_grade.php';
        
        // Create a new cURL resource
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $test = "TESTING Auto GRADING";
    
    $student_id = $_POST['user_id'];
    $exam_id = $_POST['exam_id'];

    $data = array(
        'student_id' => $student_id,
        'exam_id' => $exam_id
    );
    $json_data = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    // Attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    // Execute the POST request
    $result = curl_exec($ch);
    $response = json_decode($result, true);

    // Close cURL resource
    curl_close($ch);
    //var_export($result);


    echo '<script>window.location=("https://afsaccess4.njit.edu/~jl2237/teacher/grade.php") </script>';

  
}
