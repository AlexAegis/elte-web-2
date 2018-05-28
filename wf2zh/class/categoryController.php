<?php require_once '../resources/php/rb-mysql.php';
require_once '../class/sessionController.php';

// if your form for your object contains a select, always have a get with an action called the name of that select
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'retrieveAll':
            $categories = array_values(R::find('category', ' owner = :owner ORDER BY name ', ['owner' => $_SESSION['login']->id]));
            $errors = array();
            echo jsonResponse('success', $_GET['action'], $errors,
                array('options' => $categories));
            break;
        case 'name':
            $errors = array();
            $category = R::findOne('category', ' id = id: ', [['id' => $_GET['id']]]);
            echo jsonResponse('success', $_GET['action'], $errors,
                array('result' => $category->name));
            break;
        case 'canDelete':
            $booksInCategory = array_values(R::find('book', ' category = :category and id != :id'
                , ['category' => $_GET['parameter']['category'], 'id' => $_GET['parameter']['book']]));
            $errors = array();
            $result = 'success';
            if (count($booksInCategory) > 0) {
                array_push($errors, error("delete", "Warning, other books use this category"));
                $result = 'error';
            }
            echo jsonResponse($result, $_GET['action'], $errors,
                array('books' => $booksInCategory));
            break;
    }
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'create':
            $category = R::dispense('category');
            if (isset($_POST['id']) && $_POST['id'] !== '') {
                $category = R::findOne('category', ' id = :id ', ['id' => $_POST['id']]);
            }
            $errors = array();
            if ($_POST['name'] == null) {
                array_push($errors, error('name'));
            }
            if ($_POST['name'] != null
                && (!(isset($_POST['id']) && $_POST['id'] !== '') || isset($_POST['id']) && $_POST['name'] != $category->name)) {
                $categoryUnique = R::count('category', ' owner = :owner and name = :name '
                    , [':owner' => $_SESSION['login']->id, ':name' => $_POST['name']]);
                if ($categoryUnique > 0) {
                    array_push($errors, error("name", "Must be unique"));
                }
            }
            $result = "success";
            $other = array();
            if (count($errors) > 0) {
                $result = "error";
            } else {
                $category->owner = $_SESSION['login']->id;
                $category->name = $_POST['name'];
                R::store($category);
                $other['id'] = $category->id;
            }
            echo jsonResponse($result, $_POST['action'], $errors, $other);
            break;
        case 'remove':
            $result = 'error';
            $errors = array();
            $other = array();
            if (isset($_POST['value']) && $_POST['value'] !== '') {
                $category = R::findOne('category', ' id = :id ', ['id' => $_POST['value']]);
                $booksForCategory = R::find('book', 'category = :category', ['category' => $category->id]);
                foreach ($booksForCategory as &$book) {
                    $book->category = null;
                    R::store($book);
                }
                R::trash($category);
                $result = 'success';
                $other['id'] = '';
            } else {
                array_push($errors, error('noId'));
            }
            echo jsonResponse($result, $_POST['action'], $errors, $other);
            break;
    }
}