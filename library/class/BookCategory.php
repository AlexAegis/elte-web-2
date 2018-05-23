<?php class BookCategory extends Entity {
    public $category = null;

    public function __construct($data = array())
    {
        parent::__construct($data);
        if (isset($data['category'])) $this->category = mysqli_real_escape_string($this->db, stripslashes(strip_tags($data['category'])));
    }

}