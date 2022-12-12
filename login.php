<?php

function roles($response){

    if($response == 'teacher'){

        return "teacher";
    }if($response == 'student'){
        return "student";
    }else{
        return false;
    }
}
function is_logged_in(){
    $loggedIn = isset($_SESSION['role']);
    if($loggedIn === true){
        return true;
    }else{
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));    
        return false;
    }
}
function displayMessage(){
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}
function checkSet(){
    if(isset($_POST["question"]) && isset($_POST["case"]) && isset($_POST["output"]) 
    && isset($_POST["functionname"])){
        return TRUE;
    }
    return FALSE;
}
function checkExam(){
    if(isset($_POST["qid1"]) && isset($_POST["qid2"]) && isset($_POST["qid3"]) && isset($_POST["examName"]) && isset($_POST["description"])){
        return TRUE;
    }
    return FALSE;
}
?>
