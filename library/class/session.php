<?php require_once '../resources/rb-mysql.php';
define('DB_KEY', 'library');
try {
    if(!R::testConnection()) {
        R::addDatabase(DB_KEY, 'mysql:host=localhost;dbname=wf2_aqv5ak', 'aqv5ak', 'aqv5ak');
        R::selectDatabase(DB_KEY);
    }
} catch (\RedBeanPHP\RedException $e) {
    echo $e;
}
session_start();

if(isset($_POST["action"])) {
    if($_POST["action"] === 'logout') {
        unset($_SESSION['login']);
        echo 'success';
    } else if($_POST['action'] === 'login') {
        if (isset($_SESSION['login'])) {
            echo 'logged';
        } else {
            echo 'not logged';
        }
    }
}

if (isset($_GET["action"])) {
    if ($_GET["action"] === 'loggedInUser') {
        echo json_encode(array(
            'result' => $_SESSION['login']->username,
            'reason' => ""),
            JSON_FORCE_OBJECT);
    } else if ($_GET["action"] === 'count') {
        echo json_encode(array(
            'result' => R::count($_GET["parameter"]),
            'reason' => $_GET["parameter"]),
            JSON_FORCE_OBJECT);
    }
}

