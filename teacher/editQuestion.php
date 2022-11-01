<?php
    require("../functions.php");
    session_start();
    $role = $_SESSION['role'];
    if(is_logged_in()){ 
        if (!($role == "teacher")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));
   
    }
    if(isset($_POST['qid'])){
        if($_POST['qid'] != '' || !(empty($_POST['qid']))){
            $_SESSION['message'] = "Success";
        }
    }
    
}
        
?>


<!DOCTYPE html>
<html>
    <head>
        <title>
            Edit Question
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
    
    <h1>Edit Question Page</h1>
    <a href="https://afsaccess4.njit.edu/~jl2237/teacher/teacher.php">HOME</a>
        <form method="POST" action="https://afsaccess4.njit.edu/~jl2237/backend/edit_backend.php"> 
            
            <h3>Function Name</h3>
            <textarea id="functionname" name="functionname" rows="2" cols="25" placeholder="Function Name"><?php echo $_POST['function_name'] ?></textarea>
            <h3><label for="question">Insert Question:</label></h3>

                <div>
                    <textarea id="question" name="question" rows="4" cols="50" ><?php echo $_POST['question'] ?></textarea>
                </div>
                <h3>Question Topic</h3>
                <br>
                <select name="topic" id="topic">
                    <option value="<?php echo $_POST['topic'] ?>" selected><?php echo $_POST['topic'] ?></option>
                    <option value="variables">Variables</option>
                    <option value="forLoops">For Loops</option>
                    <option value="whileLoops">While Loops</option>
                    <option value="conditional">Conditional</option>
                    <option value="lists">Lists</option>
                </select>

                <select name="difficulty" id="difficulty">
                    <option value="<?php echo $_POST['difficulty'] ?>" selected><?php echo $_POST['difficulty'] ?></option>
                    <option value=1>Easy    (1)</option>
                    <option value=2>Medium  (2)</option>
                    <option value=3>Hard    (3)</option>
                    
                </select>
                <br><br>
                <h3>Test Cases</h3>
                <div>
                    <textarea id="case1" name="case1" rows="2" cols="25" placeholder="Test Case 1"><?php echo $_POST['case1'] ?></textarea>
                    <textarea id="output1" name="output1" rows="2" cols="25" placeholder="Expected Output 1"><?php echo $_POST['output1'] ?></textarea>
                </div>
                
               <div>
                    <textarea id="case2" name="case2" rows="2" cols="25" placeholder="Test Case 2"><?php echo $_POST['case2'] ?></textarea>
                    <textarea id="output2" name="output2" rows="2" cols="25" placeholder="Expected Output 2"><?php echo $_POST['output2'] ?></textarea>
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

                <input type="hidden" name="tcid1" value="<?php echo $_POST['tcid1']?>">
                <input type="hidden" name="tcid2" value="<?php echo $_POST['tcid2']?>">
                <input type="hidden" name="qid" value="<?php echo $_POST['qid']?>">

                <input type="submit" class="mt-3 btn btn-dark" value="SUBMIT" />
        </form>

        <br><br><br><br>
    </body>


</html>
<?php
    unset($_SESSION['question']);
?>