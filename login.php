<!DOCTYPE HTML>

<html>

<head>    

</head>

<body>
  <script>
    function checkAnswer(){ //function will be used to determine where to redirect
      location = "http://localhost/test.php" //location is a dummy variable
      return false;
    }
  </script>
  <h1>Login Page</h1>
  <form onSubmit="return checkAnswer();" method="POST">
    <div class="form-body">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email">
    </div>
    <br><br>
    <div class="form-body">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <br><br>
    <button type="submit" name="login" value="login">Log In</button>
  </form>
  <br>
  E-mail: <?php echo $_POST["email"]; ?><br>
  Password: <?php echo $_POST["password"]; ?>

</body>

</html>
