<?php
header('Content-type: text/plain; charset=utf-8');
require_once '/home/hallgatok/alexaegis/www/wf2zh/resources/php/rb-mysql.php';
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
            } else if(isJson($_POST['alakzat'])) {
                array_push($errors, error('alakzat', 'Az alakzat rossz formátumú'));
            }

            $result = "success";
            $other = array();
            if (count($errors) > 0) {
                $result = "error";
            } else {
                R::begin();
                $sql = 'insert into alakzatok(id, nev,szelesseg, magassag, kedvenc, alakzat) values('.$_POST['id'].','.$_POST['nev'].','.$_POST['szelesseg'].','.$_POST['magassag'].','.( isset($_POST['kedvenc']) ? '1' : '0').','.'"'.$_POST['alakzat'].'")';
                $other['sql'] = $sql; 
                echo $sql;
                R::exec($sql);


                R::commit();
                   
                    R::begin();

                    $shape = R::dispense('alakzatok');
                    //$shape['id'] = ((isset($_POST['id']) && $_POST['id'] != "" && ctype_digit($_POST['id'])) ? $_POST['id'] : null);
                    $shape['nev'] = $_POST['nev'];
                    $shape['szelesseg'] = $_POST['szelesseg'];
                    $shape['magassag'] = $_POST['magassag'];
                    $shape['kedvenc'] = isset($_POST['kedvenc']) ? '1' : '0';
                    $shape['alakzat'] = $_POST['alakzat'];
                    R::store($shape);
                    R::commit();
                   // $shape = R::findOne('alakzatok', ' id = :id ', [ 'id' => $_POST['id'] ]);
                    $other['id'] = $shape->id;
             
                    
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
    json_decode($string, true);
    return (json_last_error() == JSON_ERROR_NONE);
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