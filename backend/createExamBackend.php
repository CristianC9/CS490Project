<?php
// look up tabbing in textarea
session_start();
require("../functions.php");
$role = $_SESSION['role'];
if(is_logged_in()){ 
    if (!($role == "teacher")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));
    }
}


if (checkExam()) {
    $qid1 = $_POST['qid1'];
    $qid2 = $_POST['qid2'];
    $qid3 = $_POST['qid3'];
    if(isset($_POST['qid4'])){
        $qid4 = $_POST['qid4'];
        $points4 = $_POST['points4'];
    }
    if(isset($_POST['qid5'])){
        $qid5 = $_POST['qid5'];
        $points5 = $_POST['points5'];
    }
    $exam = $_POST['examName'];
    $description = $_POST['description'];
    $points1 = $_POST['points1'];
    $points2 = $_POST['points2'];
    $points3 = $_POST['points3'];
    

    
    if(!($exam=="")){ //exam needs a name
    $url = 'https://afsaccess4.njit.edu/~cec44/middle_create_exam.php';
        
        // Create a new cURL resource
        $ch = curl_init($url);
        
        // Setup request to send json via POST
        $data = array(
            'qid1' => $qid1,
            'qid2' => $qid2,
            'qid3' => $qid3,
            'exam' => $exam,
            'description' => $description,
            'points1' => $points1,
            'points2' => $points2,
            'points3' => $points3
        );

        if(isset($_POST['qid4'])){
            $data['qid4'] = $qid4;
            $data['points4'] = $points4;
     
        }
        if(isset($_POST['qid5'])){
            
            $data['qid5'] = $qid5;
            $data['points5'] = $points5;
        }

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

        echo '<script>window.location=("https://afsaccess4.njit.edu/~jl2237/teacher/createtest.php") </script>';
    }else{
    $status = "Failed";
    $_SESSION['submitted'] = $status;
    echo $_SESSION['submitted'];
    echo '<script>window.location=("https://afsaccess4.njit.edu/~jl2237/teacher/createtest.php") </script>';
    
}
}else
    echo '<script>window.location=("https://afsaccess4.njit.edu/~jl2237/teacher/createtest.php") </script>';
?>