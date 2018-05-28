<?php
 require_once '../resources/php/rb-mysql.php';
 require_once '../class/sessionController.php';

$shapes = R::findAll('alakzatok');

echo '<table>';
echo '<th>';
echo '<td>Név</td>';
echo '<td>Méret</td>';
echo '<td>Kedvenc</td>';
echo '<td>Funkciók</td>';
echo '</th>\n';
echo '<tbody>';
foreach ($shapes as &$shape) {
    echo '<tr>';
    echo '<td data-id="'.$shape->id.'">'.$shape->név.'</td>';
    echo '<td data-id="'.$shape->id.'">'.$shape->szélesség.'</td>';
    echo '<td data-id="'.$shape->id.'">'.$shape->kedvenc.'</td>';
    echo '<td data-id="'.$shape->id.'">'.$shape->név.'</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';


?>