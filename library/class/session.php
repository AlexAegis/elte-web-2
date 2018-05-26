<?php
require_once '/home/hallgatok/alexaegis/www/library/resources/rb-mysql.php';
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
    if(isset($_SESSION['login']) and $_POST["action"] === 'logout') {
        unset($_SESSION['login']);
        R::close();
        echo jsonResponse('logout', $_POST["action"]);
    }
}

if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case 'loggedInUser':
            echo jsonResponse($_SESSION['login']->email);
            break;
        case 'count':
            echo jsonResponse(R::count($_GET["parameter"]), $_GET["parameter"]);
            break;
        case 'session':
            if (isset($_SESSION['login'])) {
                echo jsonResponse('logged', $_SESSION['login']->email);
            } else {
                echo jsonResponse('not logged', 'no logged in user');
            }
            break;
    }
}

function jsonResponse($result, $reason = "", $errors = array(), $parameters = array()) {
    return json_encode(array_merge(array(
        'result' => $result,
        'reason' => $reason,
        'errors' => $errors),
        $parameters));
}