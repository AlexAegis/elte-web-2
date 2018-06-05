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

    <link rel="stylesheet" type="text/css" href="http://webprogramozas.inf.elte.hu/webfejl2/gyak/style.css">

    <script type="text/javascript" src="resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="resources/js/_utility.js"></script>
    <script type="text/javascript" src="resources/js/_zh.js"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col">
            <h2>Aktív ügynökök</h2>
            <!-- Aktív ügynökök táblázata -->
            <table id="activeTable" class="table table-sm aktiv">
            </table>
            <h2>Inaktív ügynökök</h2>
            <!-- Inaktív ügynökök táblázata -->
            <table id="inactiveTable" class="table table-sm inaktiv">
            </table>
          
        </div>
        <div class="col">
            <h2>Térkép</h2>
            <!-- Ügynöktérkép -->
            <div id="map" class="terkep">
            </div>

            <h2>Fizikai állapot</h2>
            <ul class="allapot list-group">
                <li class="pulzus list-group-item d-flex justify-content-between align-items-center">
                    Pulzus
                    <span class="badge badge-primary badge-pill">-</span>
                </li>
                <li class="vernyomas list-group-item d-flex justify-content-between align-items-center">
                    Vérnyomás
                    <span class="badge badge-primary badge-pill">-</span>
                </li>
                <li class="faradtsag list-group-item d-flex justify-content-between align-items-center">
                    Fáradtság
                    <span class="badge badge-primary badge-pill">-</span>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
$(document).ready($('#activeTable').set('agent', 'list', {active: true, header: ['Név', 'Koordináták', 'Projekt', 'Feladat', ''], headerClass: 'thead-dark'}, null, null, agentFiller))
$(document).ready($('#inactiveTable').set('agent', 'list', {active: false, header: ['Név', 'Koordináták', 'Projekt', 'Feladat', ''], headerClass: 'thead-dark'}, null, null, agentFiller))
$(document).ready($('#map').set('agent', 'map'))

function agentFiller(e) {
    let tr = $('<tr>')
        tr.attr('data-id', e.id)

        let td1 = $('<td>')
        td1.html('<a href="modosit.php?id=' + e.id + '">' + e.nev + '</a>')
        tr.append(td1)

        let td2 = $('<td>')
        td2.html(e.szelesseg + ',' + e.hosszusag)
        tr.append(td2)

        let td3 = $('<td>')
        td3.html(e.projekt)
        tr.append(td3)

        let td4 = $('<td>')
        td4.html(e.feladat)
        tr.append(td4)

        let td5 = $('<td>')
        td5.append('<a>' + (e.aktiv === '1' ? 'On' : 'Off') + '</a>')
        tr.append(td5)
		return tr
}
</script>
</body>
</html>