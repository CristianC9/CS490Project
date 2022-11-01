<?php
    require("../functions.php");
    session_start();
    $role = $_SESSION['role'];
    if(is_logged_in()){ 
        if (!($role == "teacher")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));
   
    }
    if(isset($_POST['question'])){
        if($_POST['question'] != '' || !(empty($_POST['question']))){
        $_SESSION['message'] = "Success";
        }
    }
    
}
        
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<style>
    body{
        padding: 20px;
        background: #EEEEEE;
    }
</style>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Create Questions
        </title>
    </head>
    <body>
    <?php
            if(isset($_SESSION['submitted'])){
                $status = $_SESSION['submitted'];
                echo "<span>Submission Status: $status</span><br><br>";
            }
            unset($_SESSION['submitted']);
        ?>
    
    <h1>Create Question Page</h1>
    <a class="btn btn-primary mb-2" href="https://afsaccess4.njit.edu/~jl2237/teacher/teacher.php">HOME</a>
        <form class="form" method="POST" action="https://afsaccess4.njit.edu/~jl2237/backend/backendCreate.php"> 
            <!-- <div class="col-5"> -->
                <h3>Enter Function Name</h3>
                <div>
                    <textarea class="form-control-sm mb-2" rows="2" id="functionname" name="functionname"  placeholder="Function Name"></textarea>
                    <h3><label for="question">Insert Question:</label></h3>
                    <textarea class="form-control-sm mb-2" id="question" name="question" rows="4" cols="50" placeholder="Insert Question Here"></textarea>
                </div>
                    <h3>Question Topic</h3>
                    <br>
                    <select class="form-select-sm mb-1" name="topic" id="topic">
                        <option value="" disabled selected>Select Topic</option>
                        <option value="variables">Variables</option>
                        <option value="forLoops">For Loops</option>
                        <option value="whileLoops">While Loops</option>
                        <option value="conditional">Conditional</option>
                        <option value="lists">Lists</option>
                    </select>

                    <select class="form-select-sm mb-1" name="difficulty" id="difficulty">
                        <option value="" disabled selected>Select Difficulty</option>
                        <option value=1>Easy    (1)</option>
                        <option value=2>Medium  (2)</option>
                        <option value=3>Hard    (3)</option>
                    </select>
                    <br><br>
                    <h3>Test Cases</h3>
                    <h6>Strings must be in quotes and parameters should be separated by a comma and a space</h6>
                    
                    <div>
                        <textarea id="case1" class="form-control-sm mb-2" name="case1" placeholder="Test Case 1"></textarea>
                        <textarea id="output1" class="form-control-sm mb-2" name="output1" placeholder="Expected Output 1"></textarea>
                    </div>
                    <div>
                        <textarea id="case2" class="form-control-sm mb-3" name="case2"  placeholder="Test Case 2"></textarea>
                        <textarea id="output2" class="form-control-sm mb-3" name="output2" placeholder="Expected Output 2"></textarea>
                    </div>
                    <!-- <div>
                        <textarea id="case3" name="case3" rows="2" cols="25" placeholder="Test Case 3"></textarea>
                        <textarea id="output3" name="output3" rows="2" cols="25" placeholder="Expected Output 3"></textarea>
                    </div>
                    <div>                    
                        <textarea id="case4" name="case4" rows="2" cols="25" placeholder="Test Case 4"></textarea>
                        <textarea id="output4" name="output4" rows="2" cols="25" placeholder="Expected Output 4"></textarea>
                    </div>
                    <div>
                        <textarea id="case5" name="case5" rows="2" cols="25" placeholder="Test Case 5"></textarea>
                        <textarea id="output5" name="output5" rows="2" cols="25" placeholder="Expected Output 5"></textarea>                </div> -->

                    
                    <input type="submit" value="SUBMIT" />
            <!-- </div> -->
        </form>

        
    </body>


</html>
<?php
    unset($_SESSION['question']);
?>