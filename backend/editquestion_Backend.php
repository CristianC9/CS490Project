<?php
// look up tabbing in textarea
require("../functions.php");

    session_start();

    $qid = $_POST['qid'];
    
    $url = 'https://afsaccess4.njit.edu/~cec44/middle_edit_question.php';
        
    // Create a new cURL resource
    $ch = curl_init($url);
    
    // Setup request to send json via POST
    $data = array(
        'qid' => $qid
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
    //var_dump($result);
    
    $status = "Success";
    $_SESSION["submitted"] = $status;
    echo $_SESSION['submitted'];

    echo '<script>window.location=("https://afsaccess4.njit.edu/~jl2237/teacher/editQuestion.php") </script>';


?>