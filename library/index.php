<?php
include("config.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = hash('sha256', mysqli_real_escape_string($db, $_POST['password']));
    echo 'pass in sha: ' . $password;

    $sql = "select name from user where email = '$username' and password = '$password'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $active = $row['active'];
    $count = mysqli_num_rows($result);

    if($count == 1) {
        $_SESSION['user'] = $username;
        echo 'LOGIN SUCC';
        //header("location: welcome.php");
    } else {
        echo 'LOGIN FAIL';
        $error = "Your Login Name or Password is invalid";
    }
}
?>

<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


<form action="" method="post">
    <h1>Personal Library</h1>
    <label id="label" for="email">E-mail:</label>
    <input id="email" name="username" type="email" placeholder="Enter email" required/>
    <label id="label" for="password">Password:</label>
    <input id="password" name="password" type="password" placeholder="Enter password" required/>
    <button id="login" type="submit">Login</button>

</form>


</body>
</html>