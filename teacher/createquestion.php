<?php
    require("../functions.php");
    session_start();
    $role = $_SESSION['role'];
    if(is_logged_in()){ 
        if (!($role == "teacher")){
        $_SESSION['error']= "Invalid Access";
        die(header('Location: https://afsaccess4.njit.edu/~jl2237/login.php'));
   
    }
    if(isset($_POST['question'])){
        if($_POST['question'] != '' || !(empty($_POST['question']))){
        $_SESSION['message'] = "Success";
        }
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
<style>
    body{
        padding: 20px;
        background: #EEEEEE;
    }
</style>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Create Questions
        </title>
    </head>
    <body>
    <?php
            if(isset($_SESSION['submitted'])){
                $status = $_SESSION['submitted'];
                echo "<span>Submission Status: $status</span><br><br>";
            }
            unset($_SESSION['submitted']);
        ?>
    
    <h1>Create Question Page</h1>
    <a class="btn btn-primary mb-2" href="https://afsaccess4.njit.edu/~jl2237/teacher/teacher.php">HOME</a>
        <form class="form" method="POST" action="https://afsaccess4.njit.edu/~jl2237/backend/backendCreate.php"> 
            <div class="row" >
            <div class="col-6">
                <h3>Enter Function Name</h3>
                <div>
                    <textarea class="form-control-sm mb-2" rows="2" id="functionname" name="functionname"  placeholder="Function Name"></textarea>
                    <h3><label for="question">Insert Question:</label></h3>
                    <textarea class="form-control-sm mb-2" id="question" name="question" rows="4" cols="50" placeholder="Insert Question Here"></textarea>
                </div>
                    <h3>Question Options</h3>
                    <br>
                    <select class="form-select-sm mb-1" name="topic" id="topic">
                        <option value="" disabled selected>Select Topic</option>
                        <option value="variables">Variables</option>
                        <option value="forLoops">For Loops</option>
                        <option value="whileLoops">While Loops</option>
                        <option value="conditional">Conditional</option>
                        <option value="lists">Lists</option>
                        <option value="recursion">Recursion</option>
                    </select>

                    <select class="form-select-sm mb-1" name="difficulty" id="difficulty">
                        <option value="" disabled selected>Select Difficulty</option>
                        <option value=1>Easy    (1)</option>
                        <option value=2>Medium  (2)</option>
                        <option value=3>Hard    (3)</option>
                    </select>
                    
                    <select class="form-select-sm mb-1" name="constraint" id="constraint">
                        <option value="" disabled selected>Select Constraint</option>
                        <option value="forLoops">For Loops</option>
                        <option value="whileLoops">While Loops</option>
                        <option value="recursion">Recursion</option>
                    </select>
                    
                    <br><br>
                    <h3>Test Cases</h3>
                    <h6>Strings must be in quotes and parameters should be separated by a comma and a space</h6>
                    
                    <script>
                        var counter= 2;
                        function addTestCase(){
                            if(counter < 5){
                                counter++;

                                const div = document.createElement("div");
                                div.id="test_case"+counter;

                                const input = document.createElement("textarea");
                                input.name = "case[]";
                                input.className = "form-control-sm mb-2";
                                input.id = "case"+counter;
                                input.placeholder = "Test Case " + counter;
                                input.style = "margin-right: 0.3em;";

                                const output = document.createElement("textarea");
                                output.name = "output[]";
                                output.className = "form-control-sm mb-2";
                                output.id = "output"+counter;
                                output.placeholder = "Expected Output " + counter;
                                output.style = "margin-right: 0.3em;";
                                
                                const parent = document.getElementById("test_cases");
                                div.appendChild(input);
                                div.appendChild(output);
                                parent.appendChild(div);
                                console.log(input);
                            }

                            if(counter == 5){
                                var addButtons = document.getElementsByClassName("add");
                                for(const addButton of addButtons){
                                    addButton.disabled = true;
                                }
                            }else{
                                var addButtons = document.getElementsByClassName("remove");
                                for(const addButton of addButtons){
                                    addButton.disabled = false;
                                }
                            
                            }
                            
                        }

                        function removeTestCase(){
                            if(counter > 2){
                                
                                var addButtons = document.getElementsByClassName("add");
                                for(const addButton of addButtons){
                                    addButton.disabled = false;
                                }
                                
                                const div = document.getElementById("test_case"+counter);

                                div.remove();
                                
                                counter--;

                            }

                            if(counter == 2){
                                var addButtons = document.getElementsByClassName("remove");
                                for(const addButton of addButtons){
                                    addButton.disabled = true;
                                }
                            }
                            
                        }
                    </script>


                    <div id='test_cases'>
                    <div>
                        <textarea id="case1" class="form-control-sm mb-2" name="case[]" placeholder="Test Case 1"></textarea>
                        <textarea id="output1" class="form-control-sm mb-2" name="output[]" placeholder="Expected Output 1"></textarea>
                    </div>
                    <div>
                        <textarea id="case2" class="form-control-sm mb-2" name="case[]"  placeholder="Test Case 2"></textarea>
                        <textarea id="output2" class="form-control-sm mb-2" name="output[]" placeholder="Expected Output 2"></textarea>
                    </div>

                    </div>
                    <button type="button" class="btn btn-primary add" onclick="addTestCase();">Add</button>
                    <button type="button" class="btn btn-primary remove" onclick="removeTestCase();" disabled>Remove</button>
                    
                    

                    <br><br>
                    <input type="submit" value="SUBMIT" />
           
        </form>
         </div>
         
         <div class="col-6">
         <div class="row">
         <div class="col-6">
           <h3>Question Bank</h3>
           </div>
<div class="col-6">
           <input onclick="resetFilters();" style="float:right;" type="button" value="Reset Filters"/><br><br>
           </div>
</div>           
           <table class="table table-striped table-bordered" id="questionTable">
            <tr>
           
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
                  <th>
                  Constraint
                  </th>
                

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
                
                <td>
                    <?php echo $question['question'];?>
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
    </body>
 

</html>
<?php
    unset($_SESSION['question']);
?>
