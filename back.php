<?php
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['username']) && isset($data['password'])) {
        
        $username = $data['username'];
        $password = $data['password'];
        
        $dbuser = 'mem63';
        $dbpass = 'CS490:data-base';
        
        $db = new PDO('mysql:host=sql1.njit.edu;dbname=mem63', $dbuser, $dbpass);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      	if(!$db){
      		  die("Fatal Error: Connection Failed!");
      	}
       
        $data = [];
        $stmt = $db->prepare("SELECT * from Users where username = :username");
        try {
            $r = $stmt->execute([":username" => $username]);
            if ($r) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $hash = $user["password"];
                    unset($user["password"]);
                    if (password_verify($password, $hash)) {
                        // Successful login
                        $data = array(
                            'success' => 1,
                            'message' => "Login Successful.",
                            'username' => $user['username'],
                            'role' => $user['role']
                        );
                    } else {
                        // Invalid password
                        $data = array(
                            'success' => 0,
                            'message' => "Invalid credentials."
                        );
                    }
                } else {
                    // Invalid username
                    $data = array(
                        'success' => 0,
                        'message' => "Invalid credentials."
                    );
                }
            } else {
                // Database execute error
                $data = array(
                    'success' => 0,
                    'message' => "An unexpected error occurred."
                ); 
            }
        } catch (Exception $e) {
            // Database connection error
            $data = array(
                'success' => 0,
                'message' => "An unexpected error occurred."
            );
        }
    } else {
        // CURL error
        $data = array(
            'success' => 0,
            'message' => "An unexpected error occurred."
        );
    }
    
    echo json_encode($data);
    
?>
