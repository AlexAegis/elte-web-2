<?php require_once '/home/hallgatok/alexaegis/www/library/resources/rb-mysql.php';
require_once '/home/hallgatok/alexaegis/www/library/class/sessionController.php';

// if your form for your object contains a select, always have a get with an action called the name of that select
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
            $book = R::dispense('book');
            if(isset($_POST['id'])) {
                $book = R::findOne('book', ' id = :id ', [ 'id' => $_POST['id']]);
            }

            $errors = array();
            if ($_POST['author'] == null) {
                array_push($errors, error('author'));
            }
            if ($_POST['title'] == null) {
                array_push($errors, error('title'));
            }
            if($_POST['author'] != null && $_POST['title'] != null
                && (!isset($_POST['id']) || isset($_POST['id']) && $_POST['title'] != $book->title && $_POST['author'] != $book->author)) {
                $bookUnique = R::count('book', ' owner = :owner and author = :author and title = :title '
                    , [':owner' => $_SESSION['login']->id, ':author' => $_POST['author'], ':title' => $_POST['title']]);
                if($bookUnique > 0) {
                    array_push($errors, error("author", "Must be unique"));
                    array_push($errors, error("title", "Must be unique"));
                }
            }
            $result = "createSuccess";
            $other = array();
            if(count($errors) > 0) {
                $result = "createError";
            } else {
                $book->owner = $_SESSION['login']->id;
                $book->author = $_POST['author'];
                $book->title = $_POST['title'];
                $book->page = $_POST['page'] == null ? null : $_POST['page'];
                $book->category = isset($_POST['category']) ? $_POST['category'] : null;
                $book->isbn = $_POST['isbn'] == null ? null : $_POST['isbn'];
                $book->is_read = isset($_POST['is_read']) ? '1' : '0';
                R::store($book);
                $other['id'] = $book->id;
                $newBooks = R::find('book', 'owner = :owner order by title asc ' , [':owner' => $_SESSION['login']->id]);
                $bookPos = 0;
                foreach ($newBooks as &$b) {
                    if($b->id == $book->id) {
                        break;
                    } else {
                        $bookPos++;
                    }
                }
                $bookOrderedNumber = R::count('book', ' owner = :owner and id <= :id '
                    , [':owner' => $_SESSION['login']->id, ':id' => $book->id]);
                $other['truePage'] = intdiv ($bookPos + 1, 5); // default page size
                $other['page'] = intdiv ($bookPos + 1, 5) * 5; // default page size
                $other['globPos'] = $bookPos + 1;
                $other['id'] = $book->id;
            }
            echo jsonResponse($result, $_POST['action'], $errors, $other);
            break;

    }
}