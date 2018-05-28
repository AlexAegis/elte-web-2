<?php 
?>

<!doctype html>
<html lang="en">
<head>
    <title>wf2zh</title>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="wf2zh application">
    <meta name="author" content="AlexAegis">
    <link rel="icon" href="wf2zh/resources/icon/book.png">

    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="wf2zh/resources/css/datatables.css"/>
    <link rel="stylesheet" type="text/css" href="wf2zh/resources/css/material.min.css"/>
    <link rel="stylesheet" type="text/css" href="wf2zh/resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="wf2zh/resources/css/_shape.css">

    <script type="text/javascript" src="wf2zh/resources/js/modernizr-3.5.0.min.js"></script>
    <script type="text/javascript" src="wf2zh/resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="wf2zh/resources/js/plugins.js"></script>
    <script type="text/javascript" src="wf2zh/resources/js/material.min.js"></script>
    <script type="text/javascript" src="wf2zh/resources/js/datatables.js"></script>
    <script type="text/javascript" src="wf2zh/resources/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="wf2zh/resources/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="wf2zh/resources/js/_utility.js"></script>
    <script type="text/javascript" src="wf2zh/resources/js/_zh.js"></script>
</head>
<body>
<table id="table">
<?php
 require_once '/home/hallgatok/alexaegis/www/wf2zh/resources/php/rb-mysql.php';
 require_once '/home/hallgatok/alexaegis/www/wf2zh/class/sessionController.php';
 
 
 $shapes = array();
if(isset($_GET['kedvenc'])) {
    $shapes = R::findAll('alakzatok', ' kedvenc = :fav ', [ 'fav' => $_GET['kedvenc'] == 'true' ? '1' : '0');
} else {
    $shapes = R::findAll('alakzatok');
}
echo '<a href="./uj.php">Új alakzat<a>';
echo '<thead>';
echo '<th>Név</th>';
echo '<th>Méret</th>';
echo '<th>Kedvenc</th>';
echo '<th>Funkciók</th>';
echo '</thead>';
echo '<tbody>';
foreach ($shapes as &$shape) {
    echo '<tr>';
    echo '<td data-id="'.$shape->id.'">'.$shape['nev'].'</td>';
    echo '<td data-id="'.$shape->id.'">'.$shape['szelesseg'].'</td>';
    echo '<td data-id="'.$shape->id.'">'.($shape['kedvenc']=='1' ? '♥' : '♡').'</td>';
    echo '<td data-id="'.$shape->id.'">'.'<a href="./megjelenit.php?id='.$shape->id.'">Megjelenít<a></td>';
    echo '</tr>';
}
echo '</tbody>';
?>

</table>
lola
</body>
</html>