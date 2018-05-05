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
$methods = array(
    'kex' => 'diffie-hellman-group1-sha1',
    'hostkey' => 'ssh-dss',
    'client_to_server' => array(
        'crypt' => '3des-cbc',
        'mac' => 'hmac-md5',
        'comp' => 'none'),
    'server_to_client' => array(
        'crypt' => '3des-cbc',
        'mac' => 'hmac-md5',
        'comp' => 'none'));

$connection = ssh2_connect('caesar.elte.hu', 22, $methods);
if(ssh2_auth_pubkey_file($connect, 'alexaegis', '~/.ssh/id_dsa.pub', '~/.ssh/id_dsa')) {
    echo "Public Key Authentication Successful\n";
} else {
    echo "Public Key Authentication Failed\n";
}

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