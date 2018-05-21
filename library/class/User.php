<?php class User
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
        $success = false;
        $result = mysqli_query($this->db,
            "select name from user where email = '$this->username' and password = '$this->password'");
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        $this->name = $row;
        if ($count == 1) {
            $success = true;
            session_start();
            session_regenerate_id();
            $_SESSION['login'] = $this;
            echo('success');
            exit();
        } else {
            echo 'loginError';
        }
        return $success;
    }

    public function register() {
        $result = mysqli_query($this->db,
            "select name from user where email = '$this->username' or name = '$this->name'");
        $count = mysqli_num_rows($result);
        if($count == 0) {
            mysqli_query($this->db,
                "insert into user (email, password, name) value ('$this->username', '$this->password', '$this->name')");
            $this->login();
        } else {
            echo "registrationError";
        }
    }
}