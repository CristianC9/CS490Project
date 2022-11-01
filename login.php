<?php 
session_start();
require(__DIR__ . "/functions.php");

?>
<html>

<head>
    <title>
        Login Page
    </title>
</head>

    <div class="login-page">
        <div class="form">
        
        <h1>Login</h1>
            <?php
                if(isset($_SESSION["error"])){
                    $error = $_SESSION["error"];
                    echo "<span>$error</span><br><br>";
                }
            ?> 
        <form class="login-form" method="POST" action="https://afsaccess4.njit.edu/~jl2237/backend/frontback.php">
                
                <input type="text" id="email" name="email" placeholder="Username" required />
                
                <input type="password" id="password" name="password" placeholder="Password" required minlength="8" />
        <br>
            <button type="submit" value="Login">Login</button>
            
        </form>
        </div>
    </div>


</html>
<?php
    unset($_SESSION["error"]);
    
?>

<!-- stylying -->

<style>

    .login-page {
    width: 360px;
    padding: 8% 0 0;
    margin: auto;
    }
    .form {
    position: relative;
    z-index: 1;
    background: #FFFFFF;
    max-width: 360px;
    margin: 0 auto 100px;
    padding: 45px;
    text-align: center;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
    }
    .form input {
    outline: 0;
    background: #f2f2f2;
    width: 100%;
    border: 0;
    margin: 0 0 15px;
    padding: 15px;
    box-sizing: border-box;
    font-size: 14px;
    }
    .form button {
    text-transform: uppercase;
    outline: 0;
    background: lightblue;
    width: 100%;
    border: 0;
    padding: 15px;
    color: #FFFFFF;
    font-size: 14px;
    -webkit-transition: all 0.3 ease;
    transition: all 0.3 ease;
    cursor: pointer;
    }
    .form button:hover,.form button:active,.form button:focus {
    background: lightgreen;
    }
    .form .message {
    margin: 15px 0 0;
    color: #b3b3b3;
    font-size: 12px;
    }
    .form .register-form {
    display: none;
    }
    .container {
    position: relative;
    z-index: 1;
    max-width: 300px;
    margin: 0 auto;
    }
    .container:before, .container:after {
    content: "";
    display: block;
    clear: both;
    }
    .container .info {
    margin: 50px auto;
    text-align: center;
    }
    .container .info h1 {
    margin: 0 0 15px;
    padding: 0;
    font-size: 36px;
    font-weight: 300;
    color: #1a1a1a;
    }
    .container .info span {
    color: red;
    font-size: 12px;
    }
    .container .info span a {
    color: #000000;
    text-decoration: none;
    }
    .container .info span .fa {
    color: #EF3B3A;
    }
    body {
    background: #EEEEEE;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;      
    }
</style>