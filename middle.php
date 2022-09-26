<?php
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data["username"]) && isset($data["password"])){ 
        $url = 'https://afsaccess4.njit.edu/~mem63/back.php';
        
        $ch = curl_init($url);
        $JSON_data = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $JSON_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        
        echo $result;
    } else {
        echo "Invalid Login";
    }
        
?>
