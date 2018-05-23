<?php
require_once 'config.php';
require_once 'User.php';

if(isset($_POST['action'])) {
    $user = new User(array(
        "username" => $_POST['username'],
        "password" => $_POST['password'],
        "name" => isset($_POST['name']) ? $_POST['name'] : ""));
    if ($_POST['action'] == "login") {
        $user->login();
    } else if ($_POST['action'] == "register") {
        $user->register();
    } else if ($_POST['action'] == "registrationStart") {
        echo json_encode(
            array("result" => "navigateRegistration"));
    }
}