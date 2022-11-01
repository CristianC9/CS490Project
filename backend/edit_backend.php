<?php

// look up tabbing in textarea
require("../functions.php");

if (checkSet()) {
    session_start();
    $question = $_POST["question"];
    $case1 = $_POST["case1"];
    $output1 = $_POST["output1"];
    $functionname = $_POST["functionname"];
    $topic = $_POST['topic'];
    $difficulty = $_POST['difficulty'];
    $case2 = $_POST["case2"];
    $output2 = $_POST["output2"];
    $tcid1 = $_POST["tcid1"];
    $tcid2 = $_POST["tcid2"];
    $qid = $_POST["qid"];
    
    if(!($case1=="") && !($question=="")){
    $url = 'https://afsaccess4.njit.edu/~cec44/middle_edit_question.php';
        
        // Create a new cURL resource
        $ch = curl_init($url);
        
        // Setup request to send json via POST
        $data = array(
            'question' => $question,
            'case1' => $case1,
            'output1' => $output1,
            'functionname' => $functionname,
            'topic' => $topic,
            'difficulty' => $difficulty,
            'case2' => $case2,
            'output2' => $output2,
            'tcid1' => $tcid1,
            'tcid2' => $tcid2,
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
        var_dump($result);
        

        // var_export outputs data as php code, testing functionality

        //var_dump($result);
        $status = "Success";
        $_SESSION["submitted"] = $status;
        echo $_SESSION['submitted'];

        echo '<script>window.location=("https://afsaccess4.njit.edu/~jl2237/teacher/questionbank.php") </script>';
    }else{
    $status = "Failed";
    $_SESSION['submitted'] = $status;
    echo $_SESSION['submitted'];
    echo '<script>window.location="https://afsaccess4.njit.edu/~jl2237/teacher/questionbank.php" </script>';
    
}
}
    // Invalid Credentials 
   

    //echo '<script>window.open("https://afsaccess4.njit.edu/~jl2237/login.php")</script>';
    

?>

