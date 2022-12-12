<?php 

    require("../functions.php");
    session_start();
    $role = $_SESSION['role'];
    if(is_logged_in()){ 
        if (!($role == "student")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));

    }       
    $url = 'https://afsaccess4.njit.edu/~cec44/middle_student_answers.php';
        
        // Create a new cURL resource
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $test = "TESTING Student Answers";
    $answer = $_POST['answer'];
    $user_id = $_POST['user_id'];
    $exam_id = $_POST['exam_id'];
    // $answer1 = $_POST['answer1'];
    // $answer2 = $_POST['answer2'];
    // $answer3 = $_POST['answer3'];
    // if (isset($_POST['answer4'])){
    //     $answer4 = $_POST['answer4'];
    // } else{
    //     $answer4 = "";
    // }
    // if(isset($_POST['answer5'])){
    //     $answer5 = $_POST['answer5'];
    // }else{
    //     $answer5 = "";
    // }

    $data = array(
        'answer' => $answer,
        'user_id' => $user_id,
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
//    var_dump($result);

    //***********

    $_SESSION['exam'] = $response;
    //var_dump($_SESSION['exam']);
    echo '<script>window.location=("https://afsaccess4.njit.edu/~jl2237/student/student.php") </script>';
    }

    
?>
