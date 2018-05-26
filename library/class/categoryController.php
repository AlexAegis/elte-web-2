<?php require_once '/home/hallgatok/alexaegis/www/library/resources/rb-mysql.php';
require_once '/home/hallgatok/alexaegis/www/library/class/sessionController.php';

// if your form for your object contains a select, always have a get with an action called the name of that select
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'retrieveAll':
            $categories = array_values(R::findAll('category',' ORDER BY name '));
            $errors = array();
            echo jsonResponse('success', $_GET['action'], $errors,
                array('options' => $categories));
            break;
        case 'name':
            $category = R::findOne('category', ' id = id: ', [['id' => $_GET['id']]]);
            echo jsonResponse('success', $_GET['action'], $errors,
                array('result' => $category->name));
            break;
    }
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'create':
            $category = R::dispense('category');
            if(isset($_POST['id']) && $_POST['id'] !== '') {
                $category = R::findOne('category', ' id = :id ', [ 'id' => $_POST['id']]);
            }
            $errors = array();
            if ($_POST['name'] == null) {
                array_push($errors, error('name'));
            }
            if($_POST['name'] != null
                && (!(isset($_POST['id']) && $_POST['id'] !== '') || isset($_POST['id']) && $_POST['name'] != $category->name)) {
                $categoryUnique = R::count('category', ' owner = :owner and name = :name '
                    , [':owner' => $_SESSION['login']->id, ':name' => $_POST['name']]);
                if($categoryUnique > 0) {
                    array_push($errors, error("name", "Must be unique"));
                }
            }
            $result = "createSuccess";
            $other = array();
            if(count($errors) > 0) {
                $result = "createError";
            } else {
                $category->owner = $_SESSION['login']->id;
                $category->name = $_POST['name'];
                R::store($category);
                $other['id'] = $category->id;
            }
            echo jsonResponse($result, $_POST['action'], $errors, $other);
            break;

    }
}