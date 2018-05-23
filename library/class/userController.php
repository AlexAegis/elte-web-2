<?php require_once '../resources/rb-mysql.php';
require_once '../class/session.php';

if (isset($_POST['action'])) {
    if ($_POST['action'] == "login") {
        $countUsersByEmail = R::count('user', ' email = :email ', [':email' => $_POST['email'] ]);
        $user = R::findOne('user', ' email = :email and password = :password ',
            [':email' => $_POST['email'], ':password' => hash('sha256', $_POST['password'])]);
        $result = "loginSuccess";
        $errors = array();
        if ($countUsersByEmail > 1) {
            array_push($errors, "invalidEmail");
        }
        if ($user == null) {
            array_push($errors, "invalidPassword");
            $result = "loginError";
        } else {
            $_SESSION['login'] = $user;
        }
        echo jsonResponse($result, '', $errors, array(
            'name' => $user != null ? $user->name : null,
            'email' => $user != null ? $user->email : null,
            'password' => $user != null ? $user->password : null));
    } else if ($_POST['action'] == "register") {
        $countUsersByEmail = R::count('user', ' email = :email ', [':email' => $_POST['email']]);
        $countUsersByName = R::count('user', ' name = :name ', [':name' => $_POST['name']]);
        $errors = array();
        $result = 'registrationError';
        if ($countUsersByEmail > 0) {
            array_push($errors, "emailAlreadyTaken");
        }
        if ($countUsersByName > 0) {
            array_push($errors, "nameAlreadyTaken");
        }
        if ($countUsersByEmail == 0 && $countUsersByName == 0) {
            $result = 'registrationSuccess';
            R::transaction(function() { // do it with or without the transaction, it works without it too
                $user = R::dispense('user');
                $user->email = $_POST['email'];
                $user->name = $_POST['name'];
                $user->password = hash('sha256', $_POST['password']);
                R::store($user);
            });
        }
        echo json_encode(array('result' => $result,
            'errors' => $errors,
            'email' => $_POST['email'],
            'password' => $_POST['password']));
    } else if ($_POST['action'] == "registrationStart") {
        echo json_encode(
            array("result" => "navigateRegistration"));
    }
}