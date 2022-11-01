<?php


  $data = json_decode(file_get_contents('php://input'), true);
    
    
  /*$url = 'https://afsaccess4.njit.edu/~mem63/back_student_answers.php';
        
  $ch = curl_init($url);
  $JSON_data = json_encode($data);
  #echo $JSON_data;
   
  curl_setopt($ch, CURLOPT_POSTFIELDS, $JSON_data);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $result = curl_exec($ch);
   curl_close($ch);
        
   echo $result;  
  */

  // question was created
    // send the question and test cases to backend(Matt) to get stored
    
  
  // exam was created
    // take the questions from the back end and send it to front end (Juan)
  
  
  
  //check if the student's answer code script is similar with one from the DB test case ->input
    // get the Question test case -> input from DB (string)
    // get student's input from DB (string)
    // compare them

  //get the student's answer code and store it in a py file
  $script = 'def sum(a, b):\n\treturn a+b\nprint(sum(2, 2))';
    // be able to insert a and b for test cases or wrote the test case with specific numbers
  $filename = 'sum2.py';
  
  $create_py_file = 'echo -e "'.$script.'" > '.$filename;
  
  shell_exec($create_py_file);
  $command = escapeshellcmd('python sum2.py');
  $output = shell_exec($command);
  
  echo $output;
  // check if $output is the same with the one from DB test case ->output
  
  
?>
