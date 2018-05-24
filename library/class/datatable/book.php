<?php require_once '/home/hallgatok/alexaegis/www/library/class/session.php';
require_once '/home/hallgatok/alexaegis/www/library/resources/datatables/ssp.rb.php';

$columns = array(
    array( 'db' => '`b`.`author`', 'dt' => 0 ,'field' => 'author'),
    array( 'db' => '`b`.`title`',  'dt' => 1 , 'field' => 'title'),
    array( 'db' => '`bc`.`name`',  'dt' => 2, 'field' => 'name')
);

$table = 'book';
$primaryKey = 'id';

$joinQuery = "FROM `book` AS `b` JOIN `bookcategory` AS `bc` ON (`bc`.`id` = `b`.`category`)";
$extraWhere = NULL;
$groupBy = NULL;
$having = NULL;

echo json_encode(
    SSP::simple( $_GET, R::getPDO(), $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
);