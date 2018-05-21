<?php
require_once 'config.php';
require_once 'User.php';

$user = new User(array("username" => $_POST['username'], "password" => $_POST['password']));
$user->Login();
