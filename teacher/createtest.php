<?php
    require("../functions.php");
    session_start();
    $role = $_SESSION['role'];
     if(is_logged_in()){ 
        if (!($role == "teacher")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));
   
    }
}
    $url = 'https://afsaccess4.njit.edu/~cec44/middle_question_bank.php';
        
        // Create a new cURL resource
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $test = "TESTING QBANK";
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
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

<!DOCTYPE html>
<html>
    <head>
        <title>
            Create Exam
        </title>
    <style>
        body{
        padding: 20px;
        background: #eeeeee;
        }

        .btn-block{
            font-weight:bold;
            color:black;
        }

        
    </style>
    </head>
        <body>
            <h1>Create Exam Page</h1>
            <a class="btn btn-primary mb-2" href="https://afsaccess4.njit.edu/~jl2237/teacher/teacher.php">HOME</a>
        <section>
            <div>
                <div class="row">
                    <div class="col-6">
                        <h2>Exam View</h2>

                </div>
            <div class="col-6">
                    <h2>Question Bank</h2>
                </div>
            </div>
                <form class="form" id="examForm" action="https://afsaccess4.njit.edu/~jl2237/backend/createExamBackend.php" method="post">
                <br>
                    <textarea class="form-control-sm mb-2" rows="2" id="examName" name="examName" placeholder="Exam Name"></textarea>
                    <textarea class="form-control-sm mb-2" rows="2" id="description" name="description" placeholder= "Exam Description"></textarea>
                <div class="row">
                    <div class='col-6'>
                <table class="table table-striped table-bordered"id ="examTable">
                    <tr>
                        <th>Remove</th>
                        <th>Question</th>
                        <th>Points</th>
                    </tr>
                   
                <script>
                    var i = 1;
                    
                    function addFunction(qid, question) {
                        var form = document.getElementById("examForm");
                        var input = document.createElement("input");

                        input.id = "qid"+i;
                        input.type = "hidden";
                        input.name = "qid"+i;
                        input.value = qid;
                        input.className = "qidInput";
                        form.appendChild(input);

                        var table = document.getElementById("examTable");
                        var row = table.insertRow(-1);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);

                        cell1.innerHTML = "<button class='btn btn-primary' type='button' id='remove' onclick='removeFunction(this)'>Remove</button>";
                        cell2.innerHTML = question;
                        cell3.innerHTML = "<input class='points' id='points" + i + "' name='points" + i + "'>";

                        i++;

                        if(i > 5){
                            var addButtons = document.getElementsByClassName("add");
                            for(const addButton of addButtons){
                                addButton.disabled = true;
                            }
                            
                        }
                    }
                    function removeFunction(elem) {
                        var row= elem.parentNode.parentNode.rowIndex;
                        document.getElementById("examTable").deleteRow(row);
                        var form = document.getElementById("examForm");

                        var input = document.getElementById("qid"+row);

                        form.removeChild(input);

                        var qidInputs = document.getElementsByClassName("qidInput");
                        var points = document.getElementsByClassName("points");
                        var j =1;

                        for(const qidInput of qidInputs){
                            qidInput.name = "qid" + j;
                            qidInput.id = "qid" + j;

                            j++;
                        } 
                        j = 1;
                        for(const point of points){
                            point.name = "points" + j;
                            point.id = "points" + j;

                            j++;
                        }

                        i--;
                        if(i <= 5){
                            var addButtons = document.getElementsByClassName("add");
                            for(const addButton of addButtons){
                                addButton.disabled = false;
                            }
                            
                        }
                    }
                </script>
                </div>
                </table>
                <input type="submit" class="btn btn-primary" value="SUBMIT" />

                </form>
            </div>
            <div class="col-6">
            
       
            <table class="table table-striped table-bordered" id="questionTable">
            <tr>
                <th></th>
                <th>Question</th>
                <th onclick="sortTable(2)" style="color:blue;">                    
                 <button type="button" class="btn btn-block">Difficulty&#8693</button>
                </th>
                <th onclick="sortTable(3)" style="color:blue;">
                    <button type="button" class="btn btn-block">Topic&#8693</button>
                </th>

                <script>
                
                    // function addFunction() {
                    //     var x = document.getElementById("add");

                    //     //if remove is clicked, this is true
                    //     //x.disabled = true;
                    // }

                    function sortTable(n) {
                    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                    table = document.getElementById("questionTable");
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
            <?php foreach ($response['questions'] as $question):?>
            
            <tr>
                <td style= "border:none">
                    <button type="button" class="btn btn-primary add" onclick="addFunction(<?php echo $question['qid']?>, '<?php echo $question['question']?>')">Add</button>
                </td>
                <td>
                    <?php echo $question['question'];
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
                </tr>

        <?php endforeach;?>
            </table>
                </div>
            </div>
        </section>
        </body>
</html> 