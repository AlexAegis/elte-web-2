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

<?php

$dbServerName = "webprogramozas.inf.elte.hu";
$dbUsername = "aqv5ak";
$dbPassword = "aqv5ak";
$dbName = "wf2_aqv5ak";

// create connection
$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>

    <?php
        echo "<h1>Hello, PHP-7!</h1>";
    ?>


</body>
</html>