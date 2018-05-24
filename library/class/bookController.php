<?php require_once '../resources/rb-mysql.php';
require_once '../class/session.php';
require_once '../resources/datatables/ssp.rb.php';
/*
if (isset($_GET["action"])) {
    if ($_GET["action"] === 'listBooks') {
        $books = R::find('book', ' owner = :owner ', [':owner' => $_SESSION['login']->id]);
        echo jsonResponse(json_encode(array_values($books)), $_SESSION['login']->id);
    }
}*/

$table = 'user';
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'email',  'dt' => 1 ),
    array( 'db' => 'name',   'dt' => 2 )
);

echo json_encode(
    SSP::simple($_GET, $table, $primaryKey, $columns )
);
