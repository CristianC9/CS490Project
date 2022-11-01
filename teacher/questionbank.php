<?php
    require("../functions.php");
    session_start();
    $role = $_SESSION['role'];
     if(is_logged_in()){ 
        if (!($role == "teacher")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));
   
    }
    $url = 'https://afsaccess4.njit.edu/~cec44/middle_question_bank.php';
        
        // Create a new cURL resource
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $test = "TESTING QBANK";
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
            Question Bank
        </title>
    </head>
    <body>
        <h1>Question Bank Page</h1>
        <a class="btn btn-primary mb-2" href="https://afsaccess4.njit.edu/~jl2237/teacher/teacher.php">HOME</a>
        <br><br>
        <table class="table table-striped table-bordered" id="myTable">
        <thead class="thead text-center">
            <tr>
                <th scope="col">Question</th>
                <th onclick="sortTable(1)"> 
                    <button type="button" class="btn btn-block">Difficulty&#8693</button>
                </th>
                <th onclick="sortTable(2)">
                    <button type="button" class="btn btn-block">Topic&#8693</button>
                </th>
                <th scope="col">Edit</th>
       
                <script>
                    function sortTable(n) {
                    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                    table = document.getElementById("myTable");
                    switching = true;
                    dir = "asc";
                   
                    while (switching) {
                        switching = false;
                        rows = table.rows;
                        
                        for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;
                        x = rows[i].getElementsByTagName("TD")[n];
                        y = rows[i + 1].getElementsByTagName("TD")[n];
                        
                        if (dir == "asc") {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                            }
                        } else if (dir == "desc") {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                            }
                        }
                        }
                        if (shouldSwitch) {
                      
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        switchcount ++;
                        } else {
                        if (switchcount == 0 && dir == "asc") {
                            dir = "desc";
                            switching = true;
                        }
                        }
                    }
                    }
                    </script>

            </tr> 
        </thead>
        <tbody>
            <?php foreach ($response['questions'] as $question):?>
            <tr>
           
                <td><?php echo $question['question'];
                    $test_cases = [];
                    foreach ($response['test_cases'] as $test) {
                        if ($test['question_id'] == $question['qid']) {
                            array_push($test_cases, $test);
                            
                        }
                    }
                    
                ?>
                </td>
                <td>
                <?php 
                    echo $question['difficulty'];
                    switch($question['difficulty']){
                        case 1:
                            echo "- Easy";
                            break;
                        case 2:
                            echo "- Medium";
                            break;
                        case 3:
                            echo "- Hard";
                            break;
                        default:
                            echo "ERROR: Not Set";
                            break;
                    }
                ?>
                </td>
                <td>
                <?php 
                    echo $question['topic'];
                ?>
                </td>

                <td>
                <form action="https://afsaccess4.njit.edu/~jl2237/teacher/editQuestion.php" method="post">
                    
                    <input type="hidden" name="question" value="<?php echo $question['question']?>">
                    <input type="hidden" name="function_name" value="<?php echo $question['function_name']?>">
                    <input type="hidden" name="topic" value="<?php echo $question['topic']?>">
                    <input type="hidden" name="difficulty" value="<?php echo $question['difficulty']?>">
                    <input type="hidden" name="case1" value="<?php echo $test_cases[0]['input']?>">
                    <input type="hidden" name="output1" value="<?php echo $test_cases[0]['output']?>">
                    <input type="hidden" name="case2" value="<?php echo $test_cases[1]['input']?>">
                    <input type="hidden" name="output2" value="<?php echo $test_cases[1]['output']?>">
                    <input type="hidden" name="qid" value="<?php echo $question['qid']?>">
                    <input type="hidden" name="tcid1" value="<?php echo $test_cases[0]['tcid']?>">
                    <input type="hidden" name="tcid2" value="<?php echo $test_cases[1]['tcid']?>">

                    <input type="submit" class="btn btn-primary" value="EDIT" />
                </form>
 
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
        </table>
        
        
        
    </body>
</html>