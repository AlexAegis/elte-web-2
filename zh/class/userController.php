<?php require_once '../resources/php/rb-mysql.php';
require_once '../class/sessionController.php';
$emailRegex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
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
            } else {
                if (!preg_match($emailRegex, $_POST['email'])) {
                    array_push($errors, error('email', 'Enter valid e-mail'));
                }

                if ($countUsersByEmail == 0) {
                    array_push($errors, error('email', 'Not registered'));
                }
            }

            if ($_POST['password'] == null || $_POST['password'] == '') {
                array_push($errors, error('password'));
            }

            if ($user == null) {
                if ($_POST['password'] != null && $_POST['password'] != '') {
                    array_push($errors, error('password', 'Invalid password'));
                }
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
            $result = 'error';

            if ($countUsersByEmail > 0) {
                array_push($errors, error('email', 'Already taken'));
            }
            if ($countUsersByName > 0) {
                array_push($errors, error('name', 'Already taken'));
            }

            if ($_POST['email'] == null || $_POST['email'] == '') {
                array_push($errors, error('email'));
            }
            if ($_POST['name'] == null || $_POST['name'] == '') {
                array_push($errors, error('name'));
            }
            if ($_POST['password'] == null || $_POST['password'] == '') {
                array_push($errors, error('password'));
            }

            if(!preg_match($emailRegex, $_POST['email'])) {
                array_push($errors, error('email', 'Enter valid e-mail'));
            }

            if ($countUsersByEmail == 0 && $countUsersByName == 0) {
                $result = 'success';
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
    }
}