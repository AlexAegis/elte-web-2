<?php
session_start();
require_once ("config.php");

if(isset($_POST["action"])) {
    if($_POST["action"] === 'logout') {
        unset($_SESSION['login']);
        unset($_SESSION['db']);
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
