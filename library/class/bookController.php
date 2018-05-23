<?php require_once '../resources/rb-mysql.php';
session_start();

if(isset($_POST['action'])) {
    if ($_POST['action'] == "login") {
        echo 'lol';
    }
}