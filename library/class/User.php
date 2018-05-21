<?php class User
{
    public $username = null;
    public $password = null;
    public $name = null;

    public function __construct($data = array())
    {
        if (isset($data['username'])) $this->username = stripslashes(strip_tags($data['username']));
        if (isset($data['password'])) $this->password = stripslashes(strip_tags($data['password']));
    }

    public function storeFormValues($params)
    {
        $this->__construct($params);
    }

    public function Login()
    {
        $success = false;
        $db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $this->username = mysqli_real_escape_string($db, $_POST['username']);
        $this->password = hash('sha256', mysqli_real_escape_string($db, $_POST['password']));
        $sql = "select name from user where email = '$this->username' and password = '$this->password'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        $this->name = $row;
        if ($count == 1) {
            $success = true;
            session_start();
            session_regenerate_id();
            $_SESSION['login'] = $this;
            //session_write_close();
            echo('success');
            exit();
        } else {
            echo "Your Login Name or Password is invalid";
        }
        return $success;
    }
}