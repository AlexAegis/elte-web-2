<?php
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

// alakzat: [[2,1,1],[2,0,0]] 

// felül - 
/**
 * egymás alá ahol van = black
 * 
1           alma        2           2           igen       [[1,3],[0,2]]
2           korte       3           3           nem       [[1,2,1],[0,0,3],[4,0,1]]
200000000   szilva      3           2           nem        [[2,1,1],[2,0,0]] '


                    '    <tr>
                    <td class="black"></td>
                    <td class="black"></td>
                    <td class="black"></td>
                </tr>
                <tr>
                    <td class="black"></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
 */
function parseFront($shape) {
    $json = json_decode($shape->alakzat);
    $result = '';
    foreach ($json as &$row) {
        $result = $result.'<tr>';
        foreach ($row as &$val) {
            $result = $result.'<td class="'.(intval($val) > 0 ? 'black' : '').'"><td>';
        }
        $result = $result.'</tr>';
    }
    echo $result;
}