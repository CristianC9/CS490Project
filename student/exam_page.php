<?php
    session_start();
    //var_dump($_SESSION['exam']);
    $data = $_SESSION['exam'];
    $title = $data['exam_title'];
    $description = $data['description'];
    $exam_id = $data['exam_id'];
    $user_id = $_SESSION['user_id'];
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
            Take Exam Page
        </title>
    </head>
    <body>
        <h1>GOODLUCK!!!!!</h1>
        <?php echo "Exam Name: ".$title."<br>Test Description: ".$description."<br>" ?>
        <form class="form" method="post" action="https://afsaccess4.njit.edu/~jl2237/backend/student_answers.php">
        
            <?php foreach($data['questions'] as $exam){?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $exam['question']?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $exam['points']?> Points</h6>
                    <textarea onkeydown="if(event.keyCode===9){
                        var v=this.value, s=this.selectionStart, e=this.selectionEnd;
                        this.value=v.substring(0, s)+'\t'+v.substring(e);
                        this.selectionStart=this.selectionEnd=s+1;
                        return false;}" 
                        class="textarea form-control mb-2" name="answer[]"></textarea>
                </div>
            
        </div>
    <?php 
        echo "<br>";
    }
        ?>
        <input type="submit" value="Submit"/>
        <input type="hidden" name="exam_id" value="<?php echo $exam_id?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id?>">


    </form>
    </body>
</html>