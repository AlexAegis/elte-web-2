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

include('lib/Crypt/AES.php');
include('lib/Crypt/Base.php');
include('lib/Crypt/Blowfish.php');
include('lib/Crypt/DES.php');
include('lib/Crypt/Hash.php');
include('lib/Crypt/Random.php');
include('lib/Crypt/RC2.php');
include('lib/Crypt/RC4.php');
include('lib/Crypt/Rijndael.php');
include('lib/Crypt/RSA.php');
include('lib/Crypt/TripleDES.php');
include('lib/Crypt/Twofish.php');
include('lib/File/ANSI.php');
include('lib/File/ASN1.php');
include('lib/File/X509.php');
include('lib/Math/BigInteger.php');
include('lib/Net/SFTP/Stream.php');
include('lib/Net/SCP.php');
include('lib/Net/SFTP.php');
include('lib/Net/SSH1.php');
include('lib/Net/SSH2.php');
include('lib/System');
include('lib/System/SSH');
include('lib/System/SSH/Agent.php');
include('lib/System/SSH_Agent.php');
include('lib/bootstrap.php');

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