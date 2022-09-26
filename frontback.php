<?php
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        // Sanitizing Credentials

        $pattern = "/[^\w\d\@\.]+/i";
        if(preg_match($pattern, $email)){
            echo '<script type="text/javascript">alert("Invalid Username, Try Again");</script>' ;
            echo '<script>window.location = "https://afsaccess4.njit.edu/~jl2237/login.php" </script>';
            exit();
        }else if(preg_match($pattern, $password)){
            echo '<script type="text/javascript">alert("Invalid Password, Try Again");</script>' ;
            echo '<script>window.location = "https://afsaccess4.njit.edu/~jl2237/login.php" </script>';
            exit();
        }

        $url = 'https://afsaccess4.njit.edu/~cec44/middle.php';
        
        // Create a new cURL resource
        $ch = curl_init($url);
        
        // Setup request to send json via POST
        $data = array(
            'username' => $email,
            'password' => $password
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
        

        // var_export outputs data as php code, testing functionality

        //var_dump($result);
        var_export($response);
        
        

        $var = $response['success'];

        if(isset($response['role'])){
            $role = $response['role'];
        }else{
            $role = false;
        }

        
        if($var == 1 && $role == 'teacher'){
            // Teacher page
            //echo '<script>window.open("https://afsaccess4.njit.edu/~jl2237/teacher.php")</script>';
            echo '<script>window.location = "https://afsaccess4.njit.edu/~jl2237/teacher.php" </script>';
        }
        else if ($var == 1 && $role == 'student'){
            //Student Page
            //echo '<script>window.open("https://afsaccess4.njit.edu/~jl2237/student.php")</script>';
            echo '<script>window.location = "https://afsaccess4.njit.edu/~jl2237/student.php" </script>';
        }else{
            // Invalid Credentials 
            echo '<script type="text/javascript">alert("Invalid Credentials, Try Again");</script>' ;
            echo '<script>window.location = "https://afsaccess4.njit.edu/~jl2237/login.php" </script>';
        }
      
    }
 
   
?>
