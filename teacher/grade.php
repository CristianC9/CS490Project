<?php
    require("../functions.php");
    session_start();
    $role = $_SESSION['role'];
     if(is_logged_in()){ 
        if (!($role == "teacher")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));
   
    }
    $url = 'https://afsaccess4.njit.edu/~cec44/middle_show_grades.php';
        
        // Create a new cURL resource
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $test = "TESTING GRADING";
    
    // $student_id
    // $exam_id
    // $submitted
    // $graded
    // $total_score

    $data = array(
        'question' => $test
    );
    $json_data = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    // Attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    // Execute the POST request
    $result = curl_exec($ch);
    $response = json_decode($result, true);

    // Close cURL resource
    curl_close($ch);
    
  
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
        .thead{
            background: darkgray;
            color: white;
        }
        .btn{
            background: blue;
            color:white;
        }
        
    </style>
    <head>
        <title>
            Grade Exam Page
        </title>
    </head>
    <body>
        <h1>Grade Exam Page</h1>
        <a class="btn btn-primary mb-2" href="https://afsaccess4.njit.edu/~jl2237/teacher/teacher.php">HOME</a>
        <br><br>
        
        <table class="table table-striped table-bordered" id="myTable">
        <thead class="thead text-center">
            <tr>
                <th scope="col">Student Name</th>
                <th scope="col">Exam Name</th>
                <th scope="col">Grade</th>
                <th scope="col">Submitted</th>
                <th scope="col">Auto-Grade</th>
                <th scope="col">Manually Grade</th>

            </tr> 
        </thead>
        <tbody>
            <?php foreach ($response['student_exams'] as $exam):?>
            <tr>
           
                <td><?php echo $exam['username'];
                    
                ?>
                </td>
                <td>
                <?php 
                    echo $exam['exam_title'];
                ?>
                </td>
                <td>
                <?php 
                    echo $exam['score'];
                ?>
                </td>
                <td>
                <?php 
                    if($exam['submitted']== 0){
                        echo "No";
                    }else{
                        echo "Yes";
                    }
                ?>
                </td>

                <td>
                <form action="https://afsaccess4.njit.edu/~jl2237/backend/autogradeBack.php" method="post">
                    <input type="submit" class="btn btn-primary" value="Auto Grade" />
                                
                    <input type="hidden" name="user_id" value="<?php echo $exam['student_id']?>">
                    <input type="hidden" name="exam_id" value="<?php echo $exam['exam_id']?>">

                </form>
                <!-- https://afsaccess4.njit.edu/~jl2237/teacher/editQuestion.php -->
                </td>
                
                <td>
                <form action="https://afsaccess4.njit.edu/~jl2237/backend/manual_redirect.php" method="post">
                    <input type="submit" class="btn btn-primary" value="Manually Grade" />

                    <input type="hidden" name="user_id" value="<?php echo $exam['student_id']?>">
                    <input type="hidden" name="exam_id" value="<?php echo $exam['exam_id']?>">
                   
                </form>
                </td>


            </tr>
        <?php endforeach;?>
        </tbody>
        </table>
        
        
        
    </body>
</html>