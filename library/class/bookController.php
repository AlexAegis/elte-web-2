<?php require_once '../resources/rb-mysql.php';
require_once '../class/session.php';
require_once '../resources/datatables/ssp.rb.php';
/*

$columns = array(
    array( 'db' => 'author', 'dt' => 0 ),
    array( 'db' => 'title',  'dt' => 1 ),
    array( 'db' => 'category',  'dt' => 2, 'formatter' => function( $d, $row ) {
        return R::findOne('bookcategory', ' id = :id ', [':id' => $d])->name;
    })
);

$table = "book";
$primaryKey = 'id';

echo json_encode(
    SSP::complex($_GET, R::getPDO(), $table, $primaryKey, $columns, 'owner = '.$_SESSION['login']->id)
);

*/
$columns = array(
    array( 'db' => '`b`.`author`', 'dt' => 0 ,'field' => 'author'),
    array( 'db' => '`b`.`title`',  'dt' => 1 , 'field' => 'title'),
    array( 'db' => '`bc`.`name`',  'dt' => 2, 'field' => 'name')
);
/*
echo json_encode(
    SSP::simple($_GET, R::getPDO(), 'book', $primaryKey, $columns, 'owner = '.$_SESSION['login']->id)
);
*/
$table = 'book';
$primaryKey = 'id';

//$joinQuery = "FROM `user` AS `u` JOIN `user_details` AS `ud` ON (`ud`.`user_id` = `u`.`id`)";
//$extraWhere = "`u`.`salary` >= 90000";
//$groupBy = "`u`.`office`";
//$having = "`u`.`salary` >= 140000";


$joinQuery = "FROM `book` AS `b` JOIN `bookcategory` AS `bc` ON (`bc`.`id` = `b`.`category`)";
$extraWhere = NULL;
$groupBy = NULL;
$having = NULL;


echo json_encode(
    SSP::simple( $_GET, R::getPDO(), $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
);