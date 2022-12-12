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

                    <textarea class="form-control-sm mb-2" rows="2" id="examName" name="examName" placeholder="Exam Name"></textarea>
                    <textarea class="form-control-sm mb-2" rows="2" id="description" name="description" placeholder= "Exam Description"></textarea>

                    <input onclick="resetFilters();" style="float:right;" type="button" value="Reset Filters"/>
                    
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
        


                    function resetFilters(){
                    var elements = document.getElementsByClassName("filters");
                    for(var i = 0; i < elements.length; i++){
                        elements[i].selectedIndex = 0;
                    }
                    document.getElementById('questionSearch').value = '';

                    CombinedFunction();
                    
                    }
                    
                    function CombinedFunction() {
                        var input1, input2, input3, filter1, filter2, filter3, table, tr, td, i, txtValue;
                        input1 = document.getElementById("questionSearch");
                        input2 = document.getElementById("difficultyFilter");
                        input3 = document.getElementById("topicFilter");
                        
                        filter1 = input1.value.toUpperCase();
                        filter2 = input2.value;
                        filter3 = input3.value.toUpperCase();
                        
                        table = document.getElementById("questionTable");
                        tr = table.getElementsByTagName("tr");
                        
                        console.log(filter1);
                        console.log(filter2);
                        console.log(filter3);
                        
                    
                        
                        
                        if(filter1 && filter2 && filter3){
                        for (i = 1; i < tr.length; i++) {
                            td1 = tr[i].getElementsByTagName("td")[1];
                            td2 = tr[i].getElementsByTagName("td")[2];
                            td3 = tr[i].getElementsByTagName("td")[3];
                            
                            if (td1 && td2 && td3) {
                            txtValue1 = td1.textContent || td1.innerText;
                            txtValue2 = td2.textContent || td2.innerText;
                            txtValue3 = td3.textContent || td3.innerText;
                            
                            if ((txtValue1.toUpperCase().indexOf(filter1) > -1) && (txtValue2.toUpperCase().indexOf(filter2) > -1) && (txtValue3.toUpperCase().indexOf(filter3)> -1) ) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                            }
                        }
                        }
                        
                        else if (filter1 && filter2){
                        for (i = 1; i < tr.length; i++) {
                            td1 = tr[i].getElementsByTagName("td")[1];
                            td2 = tr[i].getElementsByTagName("td")[2];
                            
                            if (td1 && td2) {
                            txtValue1 = td1.textContent || td1.innerText;
                            txtValue2 = td2.textContent || td2.innerText;
                            
                            
                            if ((txtValue1.toUpperCase().indexOf(filter1) > -1) && (txtValue2.toUpperCase().indexOf(filter2) > -1) ) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                            }
                        }
                        }
                        
                        
                        else if (filter1 && filter3){
                        for (i = 1; i < tr.length; i++) {
                            td1 = tr[i].getElementsByTagName("td")[1];
                            td3 = tr[i].getElementsByTagName("td")[3];
                            
                            if (td1 && td3) {
                            txtValue1 = td1.textContent || td1.innerText;
                            txtValue3 = td3.textContent || td3.innerText;
                            
                            
                            if ((txtValue1.toUpperCase().indexOf(filter1) > -1) && (txtValue3.toUpperCase().indexOf(filter3) > -1) ) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                            }
                        }
                        }
                        
                        else if (filter2 && filter3){
                        for (i = 1; i < tr.length; i++) {
                            td2 = tr[i].getElementsByTagName("td")[2];
                            td3 = tr[i].getElementsByTagName("td")[3];
                            
                            if (td2 && td3) {
                            txtValue2 = td2.textContent || td2.innerText;
                            txtValue3 = td3.textContent || td3.innerText;
                            
                            
                            if ((txtValue2.toUpperCase().indexOf(filter2) > -1) && (txtValue3.toUpperCase().indexOf(filter3) > -1) ) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                            }
                        }
                        }
                        
                        
                        else if(filter1){
                        for (i = 1; i < tr.length; i++) {
                            td1 = tr[i].getElementsByTagName("td")[1];
                            
                            if (td1) {
                            txtValue1 = td1.textContent || td1.innerText;
                            
                            if ((txtValue1.toUpperCase().indexOf(filter1) > -1)) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                            }
                        }
                        }
                        
                        else if(filter2){
                        for (i = 1; i < tr.length; i++) {
                            td2 = tr[i].getElementsByTagName("td")[2];
                            
                            if (td2) {
                            txtValue2 = td2.textContent || td2.innerText;
                            
                            if ((txtValue2.toUpperCase().indexOf(filter2) > -1)) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                            }
                        }
                        }
                        
                        else if(filter3){
                        for (i = 1; i < tr.length; i++) {
                            td3 = tr[i].getElementsByTagName("td")[3];
                        
                            if (td3) {
                            txtValue3 = td3.textContent || td3.innerText;
                            
                            if ((txtValue3.toUpperCase().indexOf(filter3) > -1)) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                            }
                        }
                        }
                        else{
                        
                        for (i = 1; i < tr.length; i++) {
                            tr[i].style.display = "";
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
                <th>
                <input class="search" type="text" id="questionSearch" onkeyup="CombinedFunction()" placeholder="Search Questions...">
                </th>
         
                
                <th >
                     <select class="form-select-sm mb-1 filters" id="difficultyFilter" onchange="CombinedFunction()">
                        <option value="" disabled selected>Select Difficulty</option>
                        <option value=1>Easy    (1)</option>
                        <option value=2>Medium  (2)</option>
                        <option value=3>Hard    (3)</option>
                    </select>
                </th>
                
                
                <th >                    
                   <select class="form-select-sm mb-1 filters" id="topicFilter" onchange="CombinedFunction()">
                        <option value="" disabled selected>Select Topic</option>
                        <option value="variables">Variables</option>
                        <option value="forLoops">For Loops</option>
                        <option value="whileLoops">While Loops</option>
                        <option value="conditional">Conditional</option>
                        <option value="lists">Lists</option>
                        <option value="recursion">Recursion</option>
                    </select>
                  </th>
                <th>Constraint</th>

                <script>

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
                <td>
                    <?php echo $question['qconstraint'];?>
                </td>
                </tr>

        <?php endforeach;?>
            </table>
                </div>
            </div>
        </section>
        </body>
</html> 
