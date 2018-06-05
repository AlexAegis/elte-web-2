<!doctype html>
<html lang="en">
<head>
    <title>wf2zh</title>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="wf2potzh application">
    <meta name="author" content="AlexAegis">

    <link rel="stylesheet" type="text/css" href="http://webprogramozas.inf.elte.hu/webfejl2/gyak/style.css">

    <script type="text/javascript" src="./resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="./resources/js/_utility.js"></script>
    <script type="text/javascript" src="./resources/js/_zh.js"></script>
</head>
<body>
<label id="hibak"></label><br/><br/>
<h1 id="name">lol</h1>
<form id="agent" method="post" type="submit">
<input id="id" name="id" type="hidden" class="hidden"/><br/>

<label id="szelessegLabel" for="szelesseg">Szélesség:</label>
<input id="szelesseg" name="szelesseg" type="text"/><br/>
<label id="hosszusagLabel" for="hosszusag">Hosszúság:</label>
<input id="hosszusag" name="hosszusag" type="text"/><br/>
<label id="aktivLabel" for="aktiv">Aktív:</label>
<input id="aktiv" name="aktiv" type="checkbox"/><br/>
<label id="projektLabel" for="projekt">Projekt:</label>
<input id="projekt" name="projekt" type="text"/><br/>
<label id="feladatLabel" for="feladat">Feladat:</label>
<input id="feladat" name="feladat" type="text"></input><br/>
<button id="submit" type="submit">Submit</input>
</form>
<script>
$(document).ready(function () {
    $('#id').html(getParam('id'))
    let form = $('#agent')
    form.set('agent', 'retrieve', getParam('id'))
    let name = $('#name')
    name.set('agent', 'retrieveName', getParam('id'))
    form.controller('agent', 'create', 
        function (response) {
            $('#hibak').html('')
            window.location.replace("lista.php");
        },
        function (response) {
            //window.location.replace("modosit.php?id=" + e.id);
            $('#hibak').html(response.errors.map(e => e.reason))
        })
})
</script>
</body>
</html>