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
set_include_path(getcwd() . "/lib");
include_once('lib/Crypt/Base.php');
include_once('lib/Crypt/RSA.php');
include_once('lib/Crypt/AES.php');
include_once('lib/Math/BigInteger.php');
include_once('lib/Net/SFTP/Stream.php');
include_once('lib/Net/SCP.php');
include_once('lib/Net/SFTP.php');
include_once('lib/Net/SSH1.php');
include_once('lib/Net/SSH2.php');
include_once('lib/System/SSH/Agent.php');
include_once('lib/System/SSH_Agent.php');
include_once('lib/bootstrap.php');

$key = new Crypt_RSA();
$key->setPassword('elte-web-2');
$key->loadKey(file_get_contents('/home/hallgatok/alexaegis/.ssh/id_rsa'));

$ssh = new Net_SSH2('caesar.elte.hu');
if (!$ssh->login('alexaegis', $key)) {
    exit('Login Failed');
}


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
echo "Connected successfully";

?>

    <?php
        echo "<h1>Hello, PHP-7!</h1>";
    ?>


</body>
</html>