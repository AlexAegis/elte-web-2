<?php
require_once 'class/login.php';
/*
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = hash('sha256', mysqli_real_escape_string($db, $_POST['password']));
    echo 'pass in sha: ' . $password;

    $sql = "select name from user where email = '$username' and password = '$password'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if($count == 1) {
        $_SESSION['login'] = $username;
        echo 'LOGIN SUCC';
        //header("location: welcome.php");
    } else {
        echo 'LOGIN FAIL';
        $error = "Your Login Name or Password is invalid";
    }
}*/

?>

<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-grid.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
</head>
<body>
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
    <script src="js/plugins.js"></script>
    <script src="js/utility.js"></script>
    <form id="loginForm" action="" method="post">
        <h1>Personal Library</h1>
        <label id="label" for="email">E-mail:</label>
        <input id="email" name="username" type="email" placeholder="Enter email" required/>
        <label id="label" for="password">Password:</label>
        <input id="password" name="password" type="password" placeholder="Enter password" required/>
        <button id="login" type="submit" onclick="login(document.getElementsByName(''))">Login</button>

    </form>
</body>