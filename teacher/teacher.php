<?php
    require("../functions.php");
    session_start();
    $role = $_SESSION['role'];
     if(is_logged_in()){ 
        if (!($role == "teacher")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));
   
    }
}
        
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<style>
    body{
        background: #EEEEEE;
    }
    h1{
        padding-top:15px;
    }
    .row, h1 {
        padding-right: 30px;
        padding-left:30px;

    }
    .btn:hover,.btn:active,.btn:focus {
    background: lightgreen;
    }
</style>

<!DOCTYPE html>

<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            Teacher Page
        </title>
   
    </head>
    <body>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

        <h1>Welcome to the Teacher Page</h1>
        <a class="btn btn-primary" style="float:right; padding-right:10px;" href="https://afsaccess4.njit.edu/~jl2237/login.php">Back To Login</a>

        <br><br>

        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create a Question</h5>
                        <p class="card-text">Create an Exam Question Here.</p>
                        <a class="btn btn-primary" href="https://afsaccess4.njit.edu/~jl2237/teacher/createquestion.php">Create Question</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create an Exam</h5>
                        <p class="card-text">Create an Exam Here.</p>
                        <a class="btn btn-primary" href="https://afsaccess4.njit.edu/~jl2237/teacher/createtest.php">Create Test</a>
                    </div>
                </div>
            </div>
            
           
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View the Question Bank</h5>
                        <p class="card-text">View Previously Created Questions Here</p>
                        <a class="btn btn-primary" href="https://afsaccess4.njit.edu/~jl2237/teacher/questionbank.php" class="card-link">View Now</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Created Exams</h5>
                        <p class="card-text">You Can View Previously Created Exams Here.</p>
                        <a href="https://afsaccess4.njit.edu/~jl2237/teacher/examView.php" class="btn btn-primary" class="card-link">View Now</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grade the Taken Exams</h5>
                        <p class="card-text">Grade Exams Taken By Students Here</p>
                        <a class="btn btn-primary" href="https://afsaccess4.njit.edu/~jl2237/teacher/grade.php" class="card-link">Grade Now</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>