<?php abstract class Entity
{
    public $db = null;

    public $id;

    public function __construct($data = array())
    {
        $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
    }

}