<?php class Book extends Entity
{
    public $owner;
    public $author;
    public $title;
    public $page;
    public $category;
    public $isbn;
    public $is_read;
    public $db;

    public function __construct($data = array())
    {
        parent::__construct($data);
    }


}