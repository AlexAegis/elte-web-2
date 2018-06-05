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
/*
            if(isset($_GET['parameter']['id'])) {
                $agent = R::findOne('ugynokok', 'id = :id', ['id' => $_GET['parameter']['id']]);
                $other['id'] = $agent['id'];
                $other['szelesseg'] = $agent['szelesseg'];
                $other['hosszusag'] = $agent['hosszusag'];
            }*/
            echo jsonResponse($result, $_GET['action'], $errors, $other);
            break;
    }
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'create':
            $shape = R::dispense('alakzat');/*
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $shape = R::findOne('alakzat', ' id = :id ', ['id' => $_POST['id']]);
            }*/
            $errors = array();

            if ($_POST['nev'] == null || $_POST['nev'] == "") {
                array_push($errors, error('nev', 'A név kötelező'));
            }

            if ($_POST['magassag'] == null || $_POST['magassag'] == "") {
                array_push($errors, error('magassag', 'A magasság kötelező'));
            } else if( !ctype_digit($_POST['magassag'])) {
                array_push($errors, error('magassag', 'A magasság nem szám'));
            }
            
            if ($_POST['szelesseg'] == null || $_POST['szelesseg'] == "") {
                array_push($errors, error('szelesseg', 'A szélesség kötelező'));
            } else if( !ctype_digit($_POST['szelesseg'])) {
                array_push($errors, error('szelesseg', 'A szélesség nem szám'));
            }

            if ($_POST['alakzat'] == null || $_POST['alakzat'] == "") {
                array_push($errors, error('alakzat', 'Az alakzat kötelező'));
            } else if(!isJson($_POST['alakzat'])) {
                array_push($errors, error('alakzat', 'Az alakzat rossz formátumú'));
            }

            $result = "success";
            $other = array();
            if (count($errors) > 0) {
                $result = "error";
            } else {
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