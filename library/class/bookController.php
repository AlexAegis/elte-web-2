<?php require_once '../resources/rb-mysql.php';
require_once '../class/session.php';
require_once '../resources/datatables/ssp.rb.php';

$table = 'book';
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'author', 'dt' => 0 ),
    array( 'db' => 'title',  'dt' => 1 )
);

echo json_encode(
    SSP::complex($_GET, R::getPDO(), $table, $primaryKey, $columns, 'owner = '.$_SESSION['login']->id)
);
