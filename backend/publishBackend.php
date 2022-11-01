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

    $exam_id = $_POST['exam_id'];
    $isPublished = $_POST['isPublished'];

    if(isset($exam_id) && isset($isPublished)){
    $url = 'https://afsaccess4.njit.edu/~cec44/middle_publish_exam.php';
            
            // Create a new cURL resource
            $ch = curl_init($url);
            
            // Setup request to send json via POST
            $data = array(
                'exam_id' => $exam_id,
                'isPublished' => $isPublished
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

            echo '<script>window.location=("https://afsaccess4.njit.edu/~jl2237/teacher/examView.php") </script>';
        }else{
        $status = "Failed";
        $_SESSION['submitted'] = $status;
        echo $_SESSION['submitted'];
        echo '<script>window.location=("https://afsaccess4.njit.edu/~jl2237/teacher/examView.php") </script>';
        }
?>