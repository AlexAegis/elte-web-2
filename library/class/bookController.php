<?php require_once '/home/hallgatok/alexaegis/www/library/resources/rb-mysql.php';
require_once '/home/hallgatok/alexaegis/www/library/class/session.php';

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'retrieve':
            $book = R::findOne('book', ' id = :id ', [':id' => $_GET['parameter']]);
            $result = "success";
            $errors = array();
            if ($book == null) {
                array_push($errors, "invalidId");
            }
            echo jsonResponse($result, $_GET['action'], $errors, array(
                'id' => $book != null ? $book->id : null,
                'author' => $book != null ? $book->author : null,
                'title' => $book != null ? $book->title : null,
                'page' => $book != null ? $book->page : null,
                'category' => $book != null ? $book->category : null,
                'isbn' => $book != null ? $book->isbn : null,
                'is_read' => $book != null ? $book->is_read : null));
            break;
    }
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'create':
            $book = R::findOne('book', ' id = :id ', [':id' => $_POST['parameter']]);
            $result = "createSuccess";
            $errors = array();/*
            if ($book == null) {
                array_push($errors, "invalidId");
            }
            echo jsonResponse($result, $_GET['action'], $errors);*/
            break;
    }
}