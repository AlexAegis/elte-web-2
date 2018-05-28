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
<?php
 require_once '/home/hallgatok/alexaegis/www/wf2zh/resources/php/rb-mysql.php';
 require_once '/home/hallgatok/alexaegis/www/wf2zh/class/sessionController.php';
$shape = R::findOne('alakzatok', ' id = :id ', [ 'id' => $_GET['id'] ]);
?>


<dl>
    <dt>Azonosító</dt>
    <dd><?php echo $shape->id;?></dd>

    <dt>Név</dt>
    <dd><?php echo $shape['nev'];?></dd>

    <dt>Méret</dt>
    <dd><?php echo $shape['szelesseg'].' x '.$shape['magassag']; ?></dd>

    <dt>Kedvenc</dt>
    <dd><?php echo ($shape['kedvenc']=='1' ? '♥' : '♡'); ?></dd>

    <dt>Vetületek</dt>
    <dd>
        <table>
            <tr>
                <th>Felülnézet</th>
                <th>Oldalnézet</th>
                <th>Elölnézet</th>
            </tr>
            <tr>
                <td>
                    <table class="vetulet" id="felul">
                    <?php parseFront($shape);


                    
                    ?>
                    
                    
                    </table>
                </td>
                <td>
                    <div class="vetulet" id="oldal"></div>
                </td>
                <td>
                    <div class="vetulet" id="elol"></div>
                </td>
            </tr>
        </table>
    </dd>
</dl>


lolb
</body>
</html>