<?php
session_start();
if($_POST["action"] === 'logout') {
    //session_destroy();
    unset($_SESSION['login']);
    echo 'success';
    //header('Location: http://webprogramozas.inf.elte.hu/hallgatok/alexaegis/library/');

}

if($_POST['action'] === 'login') {

    if (isset($_SESSION['login'])) {
        echo 'logged';
    } else {
        echo 'not logged';
    }
}