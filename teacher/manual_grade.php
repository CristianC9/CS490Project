<?php
    require("../functions.php");
    session_start();
    $role = $_SESSION['role'];
    if(is_logged_in()){ 
        if (!($role == "teacher")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));
   
    }
    $data = $_SESSION['exam'];
    $title = $data['exam_title'];
    $description = $data['description'];
    $exam_id = $data['exam_id'];
    $user_id = $data['student_id'];

    
}
        
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">


<!DOCTYPE html>
<html>
    <head>
        <title>
            Manual Grade
        </title>
    </head>
    <body>


    
    <h1>Manually Grade Exam</h1>
    <a class="btn btn-primary" href="https://afsaccess4.njit.edu/~jl2237/teacher/teacher.php">HOME</a>
    <br>
    <?php echo "Exam Title: ".$title."<br>Description: ".$description?>
        <form class="form" action="https://afsaccess4.njit.edu/~jl2237/backend/manual_grade_submit.php" method="post">
            <br><br>
            <script>     
            var tp1Cell = document.getElementsByClassName("color");
            for(const cell of tp1Cell){
                if(cell.innerHTML == "True") {
                cell.style.backgroundColor = 'green';
            } else {
                cell.style.backgroundColor = 'red';
            }
            }

            
      
            </script>
            
            <style>
                body{
                   
                    padding: 20px;
                    background: #EEEEEE;
                    }
                
                .success { background:green; }
                .danger { background:red; }
            </style>    
            <?php foreach($data['questions'] as $question){?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $question['question']?></h5>
                    
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $question['score']?>
                    <?php echo "/ ".$question['points']?> Points</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Student Answer</h6>
                    <table class="table table-striped table-bordered">
                        <thead class="thead text-center" style="font-weight:bold;">
                            <tr>
                                <td>Expected</td>
                                <td>Run</td>
                                <td>Check</td>
                                <td>Points</td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                                <td>
                                    <?php echo $question['function_name']?>
                                </td>
                                <td>
                                    <?php echo substr($question['student_answer'], 4, strlen($question['function_name']))?>
                                </td>
                                <td> <?php if($question['correct_name'] != 0){
                                        echo "True";
                                        }else
                                        echo "False";
                                    ?>
                                </td>
                                
                                <td class="col-1"id='points'>
                                    <textarea class="textarea form-control" name="function_scores[]"><?php echo $question['correct_name'];?></textarea>
                                </td>
                            </tr>
                            <tr>

                            </tr>
                            <tr>

                            </tr>   
                        
                        
                        
                        <?php
                          foreach($data['test_cases'] as $test_case){
                          if ($test_case['eqid']==$question['eqid'] ){
                        
                          ?>
                            <tr>
                                <td>
                                    <?php echo strtok($question['function_name'], '(')."(".$test_case['input'].")"
                                    ." -> ".$test_case['output']
                                    ?>
                                </td>
                                <td>
                                <?php 
                                    if($test_case['student_output'] != null){
                                        echo $test_case['student_output'];
                                    }
                                    else {
                                        echo "Error in Student Code";
                                        }?>  
                                </td>
                                <td><?php if($test_case['passed'] == 1){
                                        echo "True";
                                        }else
                                        echo "False";
                                    ?>
                                </td>
                                
                                <td class="col-1">
                                    <textarea class="textarea form-control" name="test_case_scores[]"><?php echo $test_case['score']?></textarea>
                                </td> 
                            </tr>  
                            
                      <?php
                          }
                        }
                      ?>
                      
                    </tbody>
                    </table>
                    <br> 
                    <h5> Comments: </h5>
                    <textarea class="textarea form-control" name="comments[]" placeholder="Add Comments Here" ></textarea>
                </div>
        
        </div>
 <?php }?>
        <input type="submit" value="Submit"/>
        <input type="hidden" name="exam_id" value="<?php echo $exam_id?>">
        <input type="hidden" name="student_id" value="<?php echo $user_id?>">


    </form>

        <br><br><br><br>
    </body>


</html>
<?php
    unset($_SESSION['question']);
?>