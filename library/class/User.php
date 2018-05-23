<?php
require_once ("config.php");
class User
{
    public $username = null;
    public $password = null;
    public $name = null;
    public $db = null;

    public function __construct($data = array())
    {
        $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (isset($data['name'])) $this->name = stripslashes(strip_tags($data['name']));
        if (isset($data['username'])) $this->username = mysqli_real_escape_string($this->db, stripslashes(strip_tags($data['username'])));
        if (isset($data['password'])) $this->password = hash('sha256', mysqli_real_escape_string($this->db, stripslashes(strip_tags($data['password']))));
    }

    public function storeFormValues($params)
    {
        $this->__construct($params);
    }

    public function login()
    {
        $result = mysqli_query($this->db,
            "select name from user where email = '$this->username' and password = '$this->password'");
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        $this->name = $row;
        $result = "loginSuccess";
        $errors = array();
        if ($count == 1) {
            session_start();
            session_regenerate_id();
            $_SESSION['login'] = $this;
        } else {
            $result = "loginError";
            $userQuery = mysqli_query($this->db,
                "select name from user where email = '$this->username'");
            $userNoPassCount = mysqli_num_rows($userQuery);
            if($userNoPassCount == 1) {
                array_push($errors,"invalidPassword");
            } else {
                array_push($errors,"invalidUsername");
            }
        }
        echo json_encode(array(
            'result' => $result,
            'errors' => $errors,
            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password));
    }

    public function register() {
        $emailResult = mysqli_query($this->db,
            "select name from user where email = '$this->username'");

        $nameResult = mysqli_query($this->db,
            "select name from user where name = '$this->name'");

        $emailCount = mysqli_num_rows($emailResult);
        $nameCount = mysqli_num_rows($nameResult);

        $errors = array();
        if($emailCount > 0) {
            array_push($errors, "emailAlreadyTaken");
        }

        if($nameCount > 0) {
            array_push($errors, "nameAlreadyTaken");
        }

        if($emailCount == 0 && $nameCount == 0) {
            mysqli_query($this->db,
                "insert into user (email, password, name) value ('$this->username', '$this->password', '$this->name')");
            $this->login();
        }

        if(count($errors) > 0) {
            echo json_encode(array('result' => 'registrationError', 'errors' => $errors));
        }
    }
}