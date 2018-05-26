<?php require_once '/home/hallgatok/alexaegis/www/library/class/session.php';
require_once '/home/hallgatok/alexaegis/www/library/resources/datatables/ssp.rb.php';
$table = 'book';
$joinTable = 'bookcategory';

$primaryKey = 'id';

// when using join
$columns = array(
    array( 'db' => '`'.$table.'`.`id`', 'dt' => 0 ,'field' => 'id'),
    array( 'db' => '`'.$table.'`.`author`', 'dt' => 1 ,'field' => 'author'),
    array( 'db' => '`'.$table.'`.`title`',  'dt' => 2 , 'field' => 'title'),
    array( 'db' => '`'.$joinTable.'`.name',  'dt' => 3, 'field' => 'name'),
    array( 'db' => '`'.$table.'`.is_read',  'dt' => 4, 'field' => 'is_read','formatter' => function( $d, $row ) {
        return $d;
    })
);

// When using regular just make joinquery and extrawhere null
/*
$columns = array(
    array( 'db' => 'author', 'dt' => 0),
    array( 'db' => 'title',  'dt' => 1 ),
    array( 'db' => 'category',  'dt' => 2)
);
*/

$joinQuery = "FROM `$table` AS `$table` LEFT OUTER JOIN `$joinTable` AS `$joinTable` ON (`$joinTable`.`id` = `$table`.`category`)";
$extraWhere = " `$table`.`owner` = ".$_SESSION['login']->id;
$groupBy = NULL;
$having = NULL;

echo json_encode(
    SSP::simple( $_GET, R::getPDO(), $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
);