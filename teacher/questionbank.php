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
            Question Bank
        </title>
    </head>
    <body>
        <h1>Question Bank Page</h1>
        <a class="btn btn-primary mb-2" href="https://afsaccess4.njit.edu/~jl2237/teacher/teacher.php">HOME</a><br>
        <input onclick="resetFilters();" style="float:right;" type="button" value="Reset Filters"/><br><br>



        <table class="table table-striped table-bordered" id="questionTable">
        <thead class="thead text-center">
            <tr>
            <th>
                <input class="search input form-control" type="text" id="questionSearch" onkeyup="CombinedFunction()" placeholder="Search Questions...">
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
                <th scope="col">Edit</th>
       
                
                <script>
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
                            td1 = tr[i].getElementsByTagName("td")[0];
                            td2 = tr[i].getElementsByTagName("td")[1];
                            td3 = tr[i].getElementsByTagName("td")[2];
                            
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
                            td1 = tr[i].getElementsByTagName("td")[0];
                            td2 = tr[i].getElementsByTagName("td")[1];
                            
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
                            td1 = tr[i].getElementsByTagName("td")[0];
                            td3 = tr[i].getElementsByTagName("td")[2];
                            
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
                            td2 = tr[i].getElementsByTagName("td")[1];
                            td3 = tr[i].getElementsByTagName("td")[2];
                            
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
                            td1 = tr[i].getElementsByTagName("td")[0];
                            
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
                            td2 = tr[i].getElementsByTagName("td")[1];
                            
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
                            td3 = tr[i].getElementsByTagName("td")[2];
                        
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
                    <?php echo $question['qconstraint'];?>
                </td>
                <td>
                <form action="https://afsaccess4.njit.edu/~jl2237/teacher/editQuestion.php" method="post">
                    
                    <input type="hidden" name="question" value="<?php echo $question['question']?>">
                    <input type="hidden" name="function_name" value="<?php echo $question['function_name']?>">
                    <input type="hidden" name="topic" value="<?php echo $question['topic']?>">
                    <input type="hidden" name="difficulty" value="<?php echo $question['difficulty']?>">
                     <input type="hidden" name="constraint" value="<?php echo $question['qconstraint']?>">

                    <?php foreach($test_cases as $test_case){ ?>
                        <input type="hidden" name="case[]" value="<?php echo $test_case['input']?>">
                        <input type="hidden" name="output[]" value="<?php echo $test_case['output']?>">
                        <input type="hidden" name="tcid[]" value="<?php echo $test_case['tcid']?>">
                    <?php } ?>

                    <input type="hidden" name="qid" value="<?php echo $question['qid']?>">
                   

                    <input type="submit" class="btn btn-primary" value="EDIT" />
                </form>
 
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
        </table>
        
        
        
    </body>
</html>
