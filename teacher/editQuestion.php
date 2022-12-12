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
    
    //echo $_POST['constraint'];

}
        
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">


<!DOCTYPE html>
<html>
<style>
    body{
        padding: 20px;
        background: #EEEEEE;
    }
</style>
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
    <a href="https://afsaccess4.njit.edu/~jl2237/teacher/teacher.php" class="btn btn-primary">HOME</a>
        <form method="POST" action="https://afsaccess4.njit.edu/~jl2237/backend/edit_backend.php"> 
            
            <h3>Function Name</h3>
            <textarea class="form-control-sm mb-2" id="functionname" name="functionname" rows="2" cols="25" placeholder="Function Name"><?php echo $_POST['function_name'] ?></textarea>
            <h3><label for="question">Insert Question:</label></h3>

                <div>
                    <textarea class="form-control-sm mb-2" id="question" name="question" rows="4" cols="50" ><?php echo $_POST['question'] ?></textarea>
                </div>
                <h3>Question Topic</h3>
                <br>
                <select class="form-select-sm mb-1" name="topic" id="topic">
                    <option value="<?php echo $_POST['topic'] ?>" selected><?php echo $_POST['topic'] ?></option>
                    <option value="variables">Variables</option>
                    <option value="forLoops">For Loops</option>
                    <option value="whileLoops">While Loops</option>
                    <option value="conditional">Conditional</option>
                    <option value="lists">Lists</option>
                </select>

                <select class="form-select-sm mb-1" name="difficulty" id="difficulty">
                    <option value="<?php echo $_POST['difficulty'] ?>" selected><?php echo $_POST['difficulty'] ?></option>
                    <option value=1>Easy    (1)</option>
                    <option value=2>Medium  (2)</option>
                    <option value=3>Hard    (3)</option>
                    
                </select>
                
                <select class="form-select-sm mb-1" name="constraint" id="constraint">
                    <option value="<?php echo $_POST['constraint'] ?>" selected><?php echo $_POST['constraint'] ?></option>
                    <option value="forLoops">For Loops</option>
                    <option value="whileLoops">While Loops</option>
                    <option value="recursion">Recursion</option>
                </select>
                
                
                <br><br>
                <h3>Test Cases</h3>
                
                <?php for($i = 0; $i < count($_POST['case']); $i++){
                    ?>
                <div>
                    <input type="hidden" name="tcid[]" value="<?php echo $_POST['tcid'][$i]?>">
                    <textarea id="case" class="form-control-sm mb-2" name="case[]" rows="2" cols="25" placeholder="Test Case 1"><?php echo $_POST['case'][$i] ?></textarea>
                    <textarea id="output" class="form-control-sm mb-2" name="output[]" rows="2" cols="25" placeholder="Expected Output 1"><?php echo $_POST['output'][$i] ?></textarea>
                </div>
                <?php }?>

                <input type="hidden" name="qid" value="<?php echo $_POST['qid']?>">
                <input type="submit" class="btn btn-primary" value="SUBMIT" />
        </form>

        <br><br><br><br>
    </body>


</html>
<?php
    unset($_SESSION['question']);
?>
