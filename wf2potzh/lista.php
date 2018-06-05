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
            <input id="szuro" name="szuro" type="text"/>
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
$(document).ready(function () {
    clearSelection()
    resetStatus()
})
$('#szuro').on('keyup', function (e) {
    let rows = $( $('#activeTable').children()[1]).children().add($( $('#inactiveTable').children()[1]).children())
    for (let index = 0; index < rows.length; index++) {
        const element = rows[index];
        $(element).removeClass('table-warning')
        
    }
    if($('#szuro').val() !== null && $('#szuro').val() !== '') {
        for (let index = 0; index < rows.length; index++) {
            const element = rows[index];          
            if($(element).children()[2].innerHTML.toLowerCase().search($('#szuro').val().toLowerCase()) != -1) {
                $(element).addClass('table-warning')
            }
        }
    }

})

let selection = null
$(document).on('keydown', function(event) {
    let rows = $( $('#activeTable').children()[1]).children().add($( $('#inactiveTable').children()[1]).children())
    switch(event.key) {
        case 'ArrowDown':
            event.preventDefault()
            resetStatus()
            if(selection === null) {
                selection = 0
            } else {
                $(rows[selection]).removeClass('table-active')
                $('span[data-id=' + $(rows[selection]).attr('data-id') + ']').removeClass('aktiv')
                selection = (selection + 1) % rows.length;
            }
            $(rows[selection]).addClass('table-active')
            $('span[data-id=' + $(rows[selection]).attr('data-id') + ']').addClass('aktiv')
            break;
        case 'ArrowUp':
            event.preventDefault()
            resetStatus()
            if(selection === null) {
            } else if (selection === 0) {
                $(rows[selection]).removeClass('table-active')
                $('span[data-id=' + $(rows[selection]).attr('data-id') + ']').removeClass('aktiv')
                selection = null
            } else {
                $(rows[selection]).removeClass('table-active')
                $('span[data-id=' + $(rows[selection]).attr('data-id') + ']').removeClass('aktiv')
                selection = (selection - 1);
            }
            $(rows[selection]).addClass('table-active')
            $('span[data-id=' + $(rows[selection]).attr('data-id') + ']').addClass('aktiv')
            break;
        case 'Enter':
            event.preventDefault()
            if(selection !== null) {
                $.ajax({
                    type: 'GET',
                    url: 'http://webprogramozas.inf.elte.hu/webfejl2/gyak/allapot.php',
                    data: {id: $(rows[selection]).attr('data-id')},
                    success: function (response) {
                        let jsonResponse = JSON.parse(response)
                        $('ul.allapot').show()
                        $('li.pulzus>span').html(jsonResponse.pulzus)
                        $('li.vernyomas>span').html(jsonResponse.vernyomas)
                        $('li.faradtsag>span').html(jsonResponse.faradtsag)
                    }
                })
            } else {
                resetStatus()
            }
            
            break;

    }
})

function resetStatus() {
    $('ul.allapot').hide()/*
    $('li.pulzus>span').html('-')
    $('li.vernyomas>span').html('-')
    $('li.faradtsag>span').html('-')*/
}
function clearSelection() {
    let rows = $( $('#activeTable').children()[1]).children().add($( $('#inactiveTable').children()[1]).children())
    for(row in rows) {
        $(row).removeClass('table-active')
    }
}
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
        td5.append('<a href="" onclick="activate(' + e.id + ')">' + (e.aktiv === '1' ? 'Off' : 'On') + '</a>')
        tr.append(td5)
		return tr
}

function activate(id) {
    $('').controller('agent', 'active&id=' + id)
}
</script>
</body>
</html>