<?php
session_start();
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