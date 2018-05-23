<?php
session_start();
require_once ("config.php");

if(isset($_POST["action"])) {
    if($_POST["action"] === 'logout') {
        unset($_SESSION['login']);
        echo 'success';
    }

    if($_POST['action'] === 'login') {
        if (isset($_SESSION['login'])) {
            echo 'logged';
        } else {
            echo 'not logged';
        }
    }
}

if (isset($_GET["action"])) {
    $db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($_GET["action"] === 'userCount') {
        $result = mysqli_query($db, "select name from user");
        $count = mysqli_num_rows($result);
        echo json_encode(array(
            'result' => $count,
            'reason' => ""),
            JSON_FORCE_OBJECT);
    }

    if ($_GET["action"] === 'bookCount') {
        $result = mysqli_query($db, "select * from book");
        $count = mysqli_num_rows($result);
        echo json_encode(array(
            'result' => $count,
            'reason' => ""),
            JSON_FORCE_OBJECT);
    }
}

