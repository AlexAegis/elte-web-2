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

    <script type="text/javascript" src="./resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="./resources/js/_utility.js"></script>
    <script type="text/javascript" src="./resources/js/_zh.js"></script>
</head>
<body>
<label id="hibak"></label><br/><br/>
<form id="shape" method="post" type="submit">

<label id="idLabel" for="id">Id:</label>
<input id="id" name="id" type="text"/><br/>
<label id="nevLabel" for="nev">Név:</label>
<input id="nev" name="nev" type="text"/><br/>
<label id="magassagLabel" for="magassag">Magasság:</label>
<input id="magassag" name="magassag" type="text"/><button id="generate" type="button">Generál</button><br/>
<label id="szelessegLabel" for="szelesseg">Szélesség:</label>
<input id="szelesseg" name="szelesseg" type="text"/><br/>
<label id="kedvencLabel" for="kedvenc">Kedvenc:</label>
<input id="kedvenc" name="kedvenc" type="checkbox"/><br/>
<label id="alakzatLabel" for="alakzat">Alakzat:</label>
<textarea id="alakzat" name="alakzat" type="text"></textarea><br/>
<button id="submit" type="submit">Ment</input>
</form>
<script>
$(document).ready(function () {
    let form = $('#shape')
    
    form.controller('shape', 'create', 
        function (response) {
            $('#hibak').html('')
            console.log("SUCC " + response)
            window.location.replace("lista.php");
			// succ	
        },
        function (response) {
            console.log("ERRS: " + response)
           
            console.log(response.errors.map(e => e.reason))
            $('#hibak').html(response.errors.map(e => e.reason))
        })
})

</script>
</body>
</html>