<?php
require_once './rb-mysql.php';
define('DB_KEY', 'zh');
try {
    if (!R::testConnection()) {
        R::addDatabase(DB_KEY, 'mysql:host=localhost;dbname=wf2_aqv5ak', 'aqv5ak', 'aqv5ak');
        R::selectDatabase(DB_KEY);
    }
} catch (\RedBeanPHP\RedException $e) {
    echo $e;
}
session_start();


if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'retrieve':
            $agent = R::findOne('ugynokok', ' id = :id ', [':id' => $_GET['parameter']]);
            $result = "success";
            $errors = array();
            if ($agent == null) {
                array_push($errors, "invalidId");
            }
            echo jsonResponse($result, $_GET['action'], $errors, array(
                'id' => $agent != null ? $agent->id : null,
                'szelesseg' => $agent != null ? $agent->szelesseg : null,
                'hosszusag' => $agent != null ? $agent->hosszusag : null,
                'aktiv' => $agent != null ? $agent->aktiv : null,
                'projekt' => $agent != null ? $agent->projekt : null,
                'feladat' => $agent != null ? $agent->feladat : null));
            break;
        case 'retrieveName':
            $agent = R::findOne('ugynokok', ' id = :id ', [':id' => $_GET['parameter']]);
            $result = "success";
            $errors = array();
            if ($agent == null) {
                array_push($errors, "invalidId");
            }
            echo jsonResponse($agent != null ? $agent->nev : null, $_GET['action'], $errors, array(
                'id' => $agent != null ? $agent->id : null,
                'name' => $agent != null ? $agent->nev : null));
            break;
        case 'list':
            $result = 'success';
            $errors = array();
            $other = array();
            $agents = array_values(R::find('ugynokok'
            , '(not :activeSearch) or aktiv = :active'
            , ['activeSearch' => isset($_GET['parameter']['active'])
                    , 'active' => isset($_GET['parameter']['active']) ? ($_GET['parameter']['active'] == 'true' ? 1 : 0) : 1]));
            
            $other['header'] = $_GET['parameter']['header'];
            if(isset($_GET['parameter']['headerClass'])) {
                $other['headerClass'] = $_GET['parameter']['headerClass'];
            }
            $other['body'] = $agents;
            echo jsonResponse($result, $_GET['action'], $errors, $other);
            break;
        case 'map':
            $result = 'success';
            $errors = array();
            $other = array();

            $agents = R::find('ugynokok');
            $other['agents'] = array_values($agents);
            echo jsonResponse($result, $_GET['action'], $errors, $other);
            break;
    }
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'active':
            $result = 'success';
            $errors = array();
            $other = array();
            $agent = R::findOne('ugynokok', 'id = :id', ['id' => $_POST['id']]);
            $agent['aktiv'] = $agent['aktiv'] == '1' ? '0' : '1';
            R::store($agent);
            echo jsonResponse($result, $_POST['action'], $errors, $other);
            break;
        case 'create':
            $agent = R::dispense('ugynokok');
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $agent = R::findOne('ugynokok', ' id = :id ', ['id' => $_POST['id']]);
            }
            $errors = array();
            
            if ($_POST['szelesseg'] == null || $_POST['szelesseg'] == "") {
                array_push($errors, error('szelesseg', 'A szélesség kötelező'));
            } else if( !ctype_digit($_POST['szelesseg'])) {
                array_push($errors, error('szelesseg', 'A szélesség nem szám'));
            }

            if ($_POST['hosszusag'] == null || $_POST['hosszusag'] == "") {
                array_push($errors, error('hosszusag', 'A hosszúság kötelező'));
            } else if( !ctype_digit($_POST['hosszusag'])) {
                array_push($errors, error('hosszusag', 'A hosszúság nem szám'));
            }
            
            if ($_POST['projekt'] == null || $_POST['projekt'] == "") {
                array_push($errors, error('projekt', 'A projekt kötelező'));
            }

            if ($_POST['feladat'] == null || $_POST['feladat'] == "") {
                array_push($errors, error('feladat', 'A feladat kötelező'));
            }

            $result = "success";
            $other = array();
            if (count($errors) > 0) {
                $result = "error";
            } else {
                $agent->szelesseg = $_POST['szelesseg'];
                $agent->hosszusag = $_POST['hosszusag'];
                $agent->aktiv = isset($_POST['aktiv']) ? '1' : '0';
                $agent->projekt = $_POST['projekt'];
                $agent->feladat = $_POST['feladat'];
                R::store($agent);
                $other['id'] = $agent->id;

/*
                $pdo = R::getPDO();

                if (isset($_POST['id']) && $_POST['id'] != '') { // id set, update or insert
                    $count = R::count('alakzatok', 'id = :id', ['id' => $_POST['id']]);
                    if($count > 0) { // existing, update
                        $sth = $pdo->prepare('update alakzatok set nev = :nev, szelesseg = :szelesseg, magassag = :magassag, kedvenc = :kedvenc, alakzat = :alakzat where id = :id');

                        $sth->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
                        $sth->bindValue(':nev', $_POST['nev']);
                        $sth->bindValue(':szelesseg', $_POST['szelesseg']);
                        $sth->bindValue(':magassag', $_POST['magassag']);
                        $sth->bindValue(':kedvenc', isset($_POST['kedvenc']) ? '1' : '0');
                        $sth->bindValue(':alakzat', $_POST['alakzat']);
                        $sth->execute();
                        $other['id'] = $_POST['id'];
                    } else { // no existing, insert
                        $sth = $pdo->prepare('insert into alakzatok(id, nev,szelesseg, magassag, kedvenc, alakzat) values(:id, :nev, :szelesseg, :magassag , :kedvenc, :alakzat)');

                        $sth->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
                        $sth->bindValue(':nev', $_POST['nev']);
                        $sth->bindValue(':szelesseg', $_POST['szelesseg']);
                        $sth->bindValue(':magassag', $_POST['magassag']);
                        $sth->bindValue(':kedvenc', isset($_POST['kedvenc']) ? '1' : '0');
                        $sth->bindValue(':alakzat', $_POST['alakzat']);
                        $sth->execute();
    
                        $other['id'] = $pdo->lastInsertId();
                    }
                } else { // id not set, insert, generate
                    $sth = $pdo->prepare('insert into alakzatok(nev,szelesseg, magassag, kedvenc, alakzat) values(:nev, :szelesseg, :magassag , :kedvenc, :alakzat)');

                    $sth->bindValue(':nev', $_POST['nev']);
                    $sth->bindValue(':szelesseg', $_POST['szelesseg']);
                    $sth->bindValue(':magassag', $_POST['magassag']);
                    $sth->bindValue(':kedvenc', isset($_POST['kedvenc']) ? '1' : '0');
                    $sth->bindValue(':alakzat', $_POST['alakzat']);
                    $sth->execute();

                    $other['id'] = $pdo->lastInsertId();
                }           
                    */
            }
            echo jsonResponse($result, $_POST['action'], $errors, $other);
            break;
        case 'remove':
            break;
    }
}


function jsonResponse($result, $reason = "", $errors = array(), $parameters = array()) {
    return json_encode(array_merge(array(
        'result' => $result,
        'reason' => $reason,
        'errors' => $errors),
        $parameters));
}

function error($field, $reason = 'Mandatory') {
    return array("field" => $field, "reason" => $reason);
}

function isJson($string) {
    return preg_match('
    /
    (?(DEFINE)
       (?<number>   -? (?= [1-9]|0(?!\d) ) \d+ (\.\d+)? ([eE] [+-]? \d+)? )    
       (?<boolean>   true | false | null )
       (?<string>    " ([^"\\\\]* | \\\\ ["\\\\bfnrt\/] | \\\\ u [0-9a-f]{4} )* " )
       (?<array>     \[  (?:  (?&json)  (?: , (?&json)  )*  )?  \s* \] )
       (?<pair>      \s* (?&string) \s* : (?&json)  )
       (?<object>    \{  (?:  (?&pair)  (?: , (?&pair)  )*  )?  \s* \} )
       (?<json>   \s* (?: (?&number) | (?&boolean) | (?&string) | (?&array) | (?&object) ) \s* )
    )
    \A (?&json) \Z
    /six   
  ', $string);
}

// alakzat: [[2,1,1],
//           [2,0,0]] 


//            o
//            o,o,o

//            o,o
//            o,o

// felül - 
/**
 * egymás alá ahol van = black
 * 
 */

function parseTop($shape) {
    $json = json_decode($shape->alakzat);
    $result = '';
    foreach ($json as &$row) {
        $result = $result.'<tr>';
        foreach ($row as &$val) {
            $result = $result.'<td class="'.($val > 0 ? 'black' : '').'"></td>';
        }
        $result = $result.'</tr>';
    }
    echo $result;
}

function parseFront($shape) {
    $json = json_decode($shape->alakzat);
    $result = '';
    foreach ($json as &$row) {
        $result = $result.'<tr>';
        foreach ($row as &$val) {
            $result = $result.'<td class="'.($val > 0 ? 'black' : '').'"></td>';
        }
        $result = $result.'</tr>';
    }
    echo $result;
}


function parseSide($shape) {
    $json = json_decode($shape->alakzat);
    $result = '';
    foreach ($json as &$row) {
        $result = $result.'<tr>';
        foreach ($row as &$val) {
            $result = $result.'<td class="'.($val > 0 ? 'black' : '').'"></td>';
        }
        $result = $result.'</tr>';
    }
    echo $result;
}