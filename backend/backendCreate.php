<?php
// look up tabbing in textarea
require("../functions.php");

if (checkSet()) {
    session_start();
    $question = $_POST["question"];
    $case = $_POST["case"];
    $output = $_POST["output"];
    $functionname = $_POST["functionname"];
    $topic = $_POST['topic'];
    $difficulty = $_POST['difficulty'];
    
    if (isset($_POST['constraint'])){
       $constraint = $_POST['constraint'];
    }
    else{
      $constraint = NULL;
    }
    
    
    if(!($question=="")){
    $url = 'https://afsaccess4.njit.edu/~cec44/middle_create_question.php';
        
        // Create a new cURL resource
        $ch = curl_init($url);
        
        // Setup request to send json via POST
        $data = array(
            'question' => $question,
            'case' => $case,
            'output' => $output,
            'functionname' => $functionname,
            'topic' => $topic,
            'difficulty' => $difficulty,
            'constraint' => $constraint
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
        //var_dump($response);
        echo '<br><br>';
        //var_dump($data);

        // var_export outputs data as php code, testing functionality

        //var_dump($result);
        $status = "Success";
        $_SESSION["submitted"] = $status;
        echo $_SESSION['submitted'];

        echo '<script>window.location=("https://afsaccess4.njit.edu/~jl2237/teacher/createquestion.php") </script>';
    }else{
    $status = "Failed";
    $_SESSION['submitted'] = $status;
    echo $_SESSION['submitted'];
    echo '<script>window.location=("https://afsaccess4.njit.edu/~jl2237/teacher/createquestion.php") </script>';
    
}
}
    // Invalid Credentials 
   

    //echo '<script>window.open("https://afsaccess4.njit.edu/~jl2237/login.php")</script>';
    

?>
