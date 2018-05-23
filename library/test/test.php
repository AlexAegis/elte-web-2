<!doctype html>
<html lang="en">
<?php
require_once '../resources/rb-mysql.php';
require_once '../class/session.php';
$countUsersByEmail = R::count('user', ' email = :email ', [':email' => 'admin@admin.com']);
echo $countUsersByEmail;
echo "<br/>";
?>
</html>