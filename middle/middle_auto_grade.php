<?php
  $data = json_decode(file_get_contents('php://input'), true);
  
  $url = 'https://afsaccess4.njit.edu/~mem63/back_auto_grade.php';

  $ch = curl_init($url);
  $JSON_data = json_encode($data);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $JSON_data);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  $response = json_decode($result, true);
  curl_close($ch);   
  //var_dump($response);

  $answer_data = [];
  foreach($response['test_cases'] as $test_case){
  
  $student_answer = $test_case['student_answer'];
  $input = $test_case['input']; 
  $output = $test_case['output']; 
  $correct_function = $test_case['function_name'];
  $student_function = substr($student_answer, 4, strlen($correct_function));
  
  $passed_func = '1';
  if (strcmp($student_function, $correct_function) !== 0) {
    //
    $student_answer= substr($student_answer, 0, 4).$correct_function.':'.substr($student_answer, strlen($student_function)+5);
    $passed_func = '0';
  }

  $func = strtok($correct_function, '(');
  $filename = $func.'.py';


  if (strpos($student_answer, "print")==False){
    $student_answer = $student_answer.'\nprint('.$func.'('.$input.'))';
  }else{
    $student_answer = $student_answer.'\n'.$func.'('.$input.')';
  }
 
  $create_py_file = "echo -e '". $student_answer."   ' > ".$filename;
  
  shell_exec($create_py_file);

  $command = escapeshellcmd('python '.$filename);
  $student_output = shell_exec($command);
  

  if(strcmp(trim(strval($output)), trim(strval($student_output)))==0){
    $passed = '1';
  }
  else{
    $passed = '0';
  }
  

  array_push($answer_data, array(
    'tcid' => $test_case['tcid'],
    'eqid' => $test_case['eqid'],
    'student_id'  => $test_case['student_id'],
    'passed' => $passed,
    'passed_func' => $passed_func,
    'student_output' => $student_output,
    'exam_id' => $test_case['exam_id']
  )); 
  
  //shell_exec('rm '.$filename);

  }  
   
  $url = 'https://afsaccess4.njit.edu/~mem63/back_grade_cases.php';
  
  $ch = curl_init($url);
  $JSON_data = json_encode($answer_data);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $JSON_data);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  $response = json_decode($result, true);
  curl_close($ch);

  echo $result;
   
?>
