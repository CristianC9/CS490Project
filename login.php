<!DOCTYPE HTML>
<html>

<head>
    <title>
        Login Page
    </title>
</head>

<body>
    <div class="container-fluid">
        <h1>Login</h1>
        <form method="POST" action="https://afsaccess4.njit.edu/~jl2237/frontback.php">
            <div class="mb-3">
                <label class="form-label" for="email">Username/Email:   </label>
                <input class="form-control" type="text" id="email" name="email" required />
            </div>
            <div class="mb-3">
                <label class="form-label" for="pw">Password:    </label>
                <input class="form-control" type="password" id="pw" name="password" required minlength="8" />
            </div><br>
            <input type="submit" class="mt-3 btn btn-dark" value="Login" />

        </form>
    </div>

</body>

</html>

