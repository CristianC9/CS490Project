<?php
    require("../functions.php");
   
    session_start();
    //var_export($_SESSION);
    $role = $_SESSION['role'];
     if(is_logged_in()){ 
        if (!($role == "student")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));
   
    }

    $url = 'https://afsaccess4.njit.edu/~cec44/middle_exam_view.php';
            
    // Create a new cURL resource
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $test = "TESTING ExamVIEW";
    $data = array(
    'question' => $question
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
    //var_dump($response);


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
            Student Page
        </title>
    </head>
    <body>
        <h1>Welcome to the Student Page</h1>
        
        <div class="row">
        <?php foreach($response['exams'] as $exam){
            if($exam['published']==1){
        ?>
            <div class="col">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $exam['exam_title']?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $exam['total_points']?> Points</h6>
                    <p class="card-text"><?php echo $exam['exam_description']?></p>
                    <?php if($exam['submitted'] == 0 && $exam['released'] == 0){ ?>
                    <form class="form" action="https://afsaccess4.njit.edu/~jl2237/backend/takeExamBackend.php" method="post">
                        <input class="btn btn-primary" type="submit" value="Begin">
                        <input name="exam_id" type="hidden" value="<?php echo $exam['exam_id']?>">
                    </form>
                    <?php }
                    elseif($exam['submitted'] == 1 && $exam['released'] ==1){ ?>
                    <form class="form" action="https://afsaccess4.njit.edu/~jl2237/backend/student_view_grade.php" method="post">
                        <input class="btn btn-primary" type="submit" value="Show Grade">
                        <input name="exam_id" type="hidden" value="<?php echo $exam['exam_id']?>">
                        <input name="student_id" type="hidden" value="<?php echo $exam['student_id']?>">
                    </form>
                    <?php }
                    else{
                        echo "test taken";
                        } 
                    ?>
                    

                </div>
            </div>
        </div>
        <?php 
            }
        }
        ?>
        </div>
    </body>
</html>