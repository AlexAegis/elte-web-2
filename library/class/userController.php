<?php require_once '../resources/rb-mysql.php';
session_start();

if (isset($_POST['action'])) {
    if ($_POST['action'] == "login") {
        $usersByUsername = R::count('user', ' username = :username ', [':username' => $_POST['username']]);
        $user = R::findOne('user', ' username = :username and password = :password ',
            [':username' => $_POST['username'], ':password' => hash('sha256', $_POST['password'])]);
        $result = "loginSuccess";
        $errors = array();
        if ($usersByUsername > 1) {
            array_push($errors, "invalidUsername");
        }
        if ($user == null) {
            array_push($errors, "invalidPassword");
            $result = "loginError";
        } else {
            session_start();
            session_regenerate_id();
            $_SESSION['login'] = $user;
        }
        echo json_encode(array(
            'result' => $result,
            'errors' => $errors,
            'name' => $user->name,
            'username' => $user->username,
            'password' => $user->password));
    } else if ($_POST['action'] == "register") {
        $usersByUsername = R::count('user', ' username = :username ', [':username' => $_POST['username']]);
        $usersByName = R::count('user', ' name = :name ', [':name' => $_POST['name']]);
        $errors = array();
        $result = 'registrationError';
        if ($usersByUsername > 0) {
            array_push($errors, "emailAlreadyTaken");
        }

        if ($usersByName > 0) {
            array_push($errors, "nameAlreadyTaken");
        }

        if ($usersByUsername == 0 && $usersByName == 0) {
            $result = 'registrationSuccess';
            $user = R::dispense('user');
            $user->username = $_POST['username'];
            $user->name = $_POST['name'];
            $user->password = hash('sha256', $_POST['password']);
            R::store($user);
        }
        echo json_encode(array('result' => $result,
            'errors' => $errors,
            'username' => $_POST['username'],
            'password' => $_POST['password']));
    } else if ($_POST['action'] == "registrationStart") {
        echo json_encode(
            array("result" => "navigateRegistration"));
    }
}