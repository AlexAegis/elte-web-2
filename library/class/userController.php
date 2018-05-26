<?php require_once '/home/hallgatok/alexaegis/www/library/resources/php/rb-mysql.php';
require_once '/home/hallgatok/alexaegis/www/library/class/sessionController.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'login':
            $countUsersByEmail = R::count('user', ' email = :email ', [':email' => $_POST['email']]);
            $user = R::findOne('user', ' email = :email and password = :password ',
                [':email' => $_POST['email'], ':password' => hash('sha256', $_POST['password'])]);
            $result = 'error';
            $errors = array();

            if ($_POST['email'] == null || $_POST['email'] == '') {
                array_push($errors, error('email'));
            }

            if ($_POST['password'] == null || $_POST['password'] == '') {
                array_push($errors, error('password'));
            }

            if ($countUsersByEmail == 0) {
                array_push($errors, error('email', 'Not registered'));
            }

            if ($user == null) {
                array_push($errors,  error('password', 'Invalid password'));
            } else {
                $result = "success";
                session_regenerate_id();
                $_SESSION['login'] = $user;
            }

            echo jsonResponse($result, $_POST['action'], $errors, array(
                'name' => $user != null ? $user->name : null,
                'email' => $user != null ? $user->email : null,
                'password' => $user != null ? $user->password : null));
            break;
        case 'register':
            $countUsersByEmail = R::count('user', ' email = :email ', [':email' => $_POST['email']]);
            $countUsersByName = R::count('user', ' name = :name ', [':name' => $_POST['name']]);
            $errors = array();
            $result = 'registrationError';

            if ($_POST['email'] == null || $_POST['email'] == '') {
                array_push($errors, error('email'));
            }
            if ($_POST['name'] == null || $_POST['name'] == '') {
                array_push($errors, error('name'));
            }
            if ($countUsersByEmail > 0) {
                array_push($errors, error('email', 'Already taken'));
            }
            if ($countUsersByName > 0) {
                array_push($errors, error('name', 'Already taken'));
            }
            if ($countUsersByEmail == 0 && $countUsersByName == 0) {
                $result = 'registrationSuccess';
                R::transaction(function () { // do it with or without the transaction, it works without it too
                    $user = R::dispense('user');
                    $user->email = $_POST['email'];
                    $user->name = $_POST['name'];
                    $user->password = hash('sha256', $_POST['password']);
                    R::store($user);
                });
            }
            echo jsonResponse($result, $_POST['action'], $errors, array('email' => $_POST['email'], 'password' => $_POST['password']));
            break;
        case 'registrationStart':
            echo jsonResponse("navigateRegistration", $_POST['action']);
            break;
    }
}