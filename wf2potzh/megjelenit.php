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
    <link rel="icon" href="./resources/icon/book.png">

    <link rel="stylesheet" type="text/css" href="./resources/css/_shape.css">

    <script type="text/javascript" src="./resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="./resources/js/_utility.js"></script>
    <script type="text/javascript" src="./resources/js/_zh.js"></script>
</head>
<body>
<?php
 require_once 'resources/php/shapeController.php';
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
                    <?php parseTop($shape);?>        
                    </table>
                </td>
                <td>
                    <div class="vetulet" id="oldal">
                    <?php parseSide($shape);?> 
                    </div>
                </td>
                <td>
                    <div class="vetulet" id="elol">
                    <?php parseFront($shape);?> 
                    </div>
                </td>
            </tr>
        </table>
    </dd>
</dl>


lolb
</body>
</html>