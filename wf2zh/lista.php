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

    <link rel="stylesheet" type="text/css" href="./resources/css/_shape.css">

    <script type="text/javascript" src="resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="resources/js/_utility.js"></script>
    <script type="text/javascript" src="resources/js/_zh.js"></script>
</head>
<body>


<table id="table">
</table>
<a href="uj.php">Új alakzat</a>

<script>
$(document).ready(
    $('#table').set('shape', 'list', {kedvenc: getParam('kedvenc'), header: ['Név', 'Méret', 'Kedvenc', 'Funkciók']}, null, null, function(e) {
        let tr = $('<tr>')
        tr.attr('data-id', e.id)

        let td1 = $('<td>')
        td1.html(e.nev)
        tr.append(td1)

        let td2 = $('<td>')
        td2.html(e.szelesseg + ' + ' + e.magassag)
        tr.append(td2)

        let td3 = $('<td>')
        td3.html(e.kedvenc === '1' ? '♥' : '♡')
        tr.append(td3)

        let td4 = $('<td>')
        td4.append($('<a href="./megjelenit.php?id=' + e.id + '">').html('Megjelenít'))
        tr.append(td4)

        console.log(e)
		return tr
    })
)
</script>
</body>
</html>