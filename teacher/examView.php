<?php
    require("../functions.php");
    session_start();
    $role = $_SESSION['role'];
     if(is_logged_in()){ 
        if (!($role == "teacher")){
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
            Exam Page
        </title>
    </head>
    <body>
        <h2>Exam View Page</h2>
        <a class="btn btn-primary mb-2" href="https://afsaccess4.njit.edu/~jl2237/teacher/teacher.php">HOME</a>
        <table class="table table-striped table-bordered">
            <thead class="thead text-center">
                <tr>
                <th scope="col">Exam Name</th>
                <th scope="col">Description</th>
                <th scope="col">Points</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($response['exams'] as $exam):?>
                <tr>
                    <td>
                        <?php echo $exam['exam_title'];?>
                    </td>
                    <td>
                        <?php echo $exam['exam_description'];?>
                    </td>
                    <td>
                        <?php echo $exam['total_points'];?>
                    </td>
                    <td> <?php if($exam['published'] == 0):?>
                        <form action="https://afsaccess4.njit.edu/~jl2237/backend/publishBackend.php" method="post">
                            <input type="hidden" name="exam_id" value="<?php echo $exam['exam_id']?>">
                            <input name="isPublished" type="submit" value="Publish" class="btn btn-block">
                        </form>
                            
                    <?php else:?>
                        <form action="https://afsaccess4.njit.edu/~jl2237/backend/publishBackend.php" method="post">
                            <input type="hidden" name="exam_id" value="<?php echo $exam['exam_id']?>">
                            <input name="isPublished" type="submit" value="Unpublish" class="btn btn-block">
                        </form>
                        
                    <?php endif;?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
                


    </body>
    </html>