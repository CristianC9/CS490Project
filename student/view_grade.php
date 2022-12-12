<?php
    require("../functions.php");
    session_start();
    $role = $_SESSION['role'];
    if(is_logged_in()){ 
        if (!($role == "student")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));
   
    }
    $data = $_SESSION['exam'];
    $title = $data['exam_title'];
    $description = $data['description'];
    $exam_id = $data['exam_id'];
    $user_id = $data['student_id'];
    $student_score = $data['student_score'];
    $constraint = $data[''];
    
    //var_dump($data);
    
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


    
    <h1>Graded Exam</h1>
    <a class="btn btn-primary"href="https://afsaccess4.njit.edu/~jl2237/student/student.php">HOME</a>
    <br>
    <?php echo "Exam Title: ".$title."<br>Description: ".$description?>
            <br>
            <p style="float:right;">GRADE: <?php echo $student_score." / ".$data['total_points']?></p>
            <br><br>
            
            <style>
                body{
        
                    padding: 20px;
                    background: #EEEEEE;
                    }
            
            </style>    
            <?php foreach($data['questions'] as $question){?>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $question['question']?></h5>
                    
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $question['score']?>
                    <?php echo "/ ".$question['points']?> Points</h6>

                    <h6 class="card-subtitle mb-2 text-muted">Student Answer</h6>
                    <textarea class="textarea form-control" style="height: 10em;"disabled><?php echo $question['student_answer']?></textarea>
                    
                    <table class="table table-striped table-bordered">
                        <thead class="thead text-center" style="font-weight:bold;">
                            <tr>
                                <td>Expected</td>
                                <td>Run</td>
                                <td>Check</td>
                                <td>Expected Points</td>
                                <td>Points</td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                                <td>
                                    <?php echo $question['function_name']?>
                                </td>
                                <td>


                                    <?php 
                                    echo substr(explode(":", $question['student_answer'], 2)[0],4);
                                    ?>
                                </td>
                                <td> <?php if($question['correct_name'] != 0){
                                        echo "True";
                                        }else
                                        echo "False";
                                    ?>
                                </td>
                                <td class="col-2">
                                    <?php 
                                        $points = $question['points'];
                                        $divisors = 1;
                                        
                                        foreach($data['test_cases'] as $tc){
                                            if ($tc['eqid']==$question['eqid'] ){
                                                $divisors += 1;
                                            }
                                        }

                                        if ($question['qconstraint'] != null){
                                            $divisors += 1; 
                                            echo round(($points / $divisors), 2);
                                        }else{
                                            echo round(($points / $divisors), 2);
                                        }

                                    ?>
                                </td>
                                <td class="col-1"id='points'>
                                    <text><?php echo $question['correct_name'];?></text>
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
                                        echo $test_case['student_output'];}
                                    else {echo "Error in Student Code";}?>
                                </td>
                                <td><?php if($test_case['passed'] == 1){
                                        
                                        echo "True";
                                        }else
                                        echo "False";
                                    ?>
                                </td>
                                <td class="col-2">
                                    <?php 
                                        $points = $question['points'];
                                        $divisors = 1;
                                        
                                        foreach($data['test_cases'] as $tc){
                                            if ($tc['eqid']==$question['eqid'] ){
                                                $divisors += 1;
                                            }
                                        }

                                        if ($question['qconstraint'] != null){
                                            $divisors += 1; 
                                            echo round(($points / $divisors), 2);
                                        }else{
                                            echo round(($points / $divisors), 2);
                                        }
                                    ?>
                                    </td>
                                
                                <td class="col-1">
                                    <text><?php echo $test_case['score']?></text>
                                </td> 
                            </tr>  
                            
                      <?php
                          }
                        }
                      ?>
                      

                      <tr>
                        <td>
                        Constraint: <?php echo $question['qconstraint']?>
                    </td>
                    <td>
                       
                    </td>
                    <td>
                    <?php if($question['constraint_score'] > 3){
                            echo "True";
                        }else if(!$question['qconstraint']){
                            echo "";
                        }
                        else{
                            echo "False";
                        }?>
                    </td>
                    <td class="col-2">
                        <?php 
                            $points = $question['points'];
                            $divisors = 1;
                            if ($question['qconstraint'] != null){
                                $divisors += 1; 
                            }
                            foreach($data['test_cases'] as $tc){
                                if ($tc['eqid']==$question['eqid'] ){
                                    $divisors += 1;
                                }
                            }

                            if ($question['qconstraint'] != null){
                                 echo round(($points / $divisors), 2);
                            }else{
                                echo 0;
                            }
                           

                        ?>
                       
                    </td>
                    <td>
                        <?php echo $question['constraint_score']?>
                    </td>
                    </tr>  
                    </tbody>
                    </table>
                    <br> 
                    <h5> Comments: </h5>
                    <text><?php echo $question['comment'];?></text>
                </div>
        
        </div>
 <?php }?>
        




        <br><br><br><br>
    </body>


</html>
<?php
    unset($_SESSION['question']);
?>
