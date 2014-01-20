<p>Привет!</p>
<?php
echo '<table>
        <caption>Таблица размеров обуви</caption>
        <tr>
          <th>slideKey</th>
          <th>date</th>
        </tr>';
foreach ($echo as $value) {
    echo '<tr>';
    echo '<td>'.$value->slideKey.'</td>';
    echo '<td>';
    foreach ($value->shows->children() as $sh) {
        echo $sh->date.' <br> ';
    }
    echo '</td>';
    echo '</tr>';
}
echo '</table>';
echo '<p>' . $model->HASH . '</p>';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

