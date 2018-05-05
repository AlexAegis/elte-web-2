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

// ssh
/*
 * ssh-keygen -t dsa
    cat ~/.ssh/id_dsa.pub >> ~/.ssh/authorized_keys
    chmod 700 ~/.ssh/
    chmod -R 600 ~/.ssh/*
 */
include('lib/Math/BigInteger.php');
include('lib/Crypt/RSA.php');
include('lib/Net/SSH2.php');

$key = new Crypt_RSA();
//$key->setPassword('whatever');
$key->loadKey(file_get_contents('privatekey'));

$ssh = new Net_SSH2('www.domain.tld');
if (!$ssh->login('username', $key)) {
    exit('Login Failed');
}

echo $ssh->read('username@username:~$');
$ssh->write("ls -la\n");
echo $ssh->read('username@username:~$');


/*
$dbServerName = "mysql.caesar.elte.hu";
$dbUsername = "alexaegis";
$dbPassword = "1NGYbU67ILtxsVgF";
$dbName = "alexaegis";

// create connection
$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";*/
?>

    <?php
        echo "<h1>Hello, PHP-7!</h1>";
    ?>


</body>
</html>