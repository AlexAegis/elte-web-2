<?php require_once '../resources/rb-mysql.php';
require_once '../class/session.php';

if (isset($_GET["action"])) {
    if ($_GET["action"] === 'listBooks') {
        $books = R::find('book', ' owner = :owner ', [':owner' => $_SESSION['login']->id]);
        echo jsonResponse(json_encode(array_values($books)), $_SESSION['login']->id);
    }
}