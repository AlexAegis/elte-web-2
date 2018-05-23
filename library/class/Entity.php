<?php

abstract class Entity
{
    public $db = null;

    public function __construct($data = array())
    {
        $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (isset($data['id'])) {
            echo "QUERY ME!";
        }
    }

    public function persist() {
        echo get_object_vars($this); // array
    }

    public static function loadAll($class = null) {
        echo "yy";
    }

}