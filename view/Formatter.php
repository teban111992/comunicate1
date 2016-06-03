<?php

/**
 * Description of Formatter
 *
 * @author 
 */
class Formatter {
    function tableHeaders($header) {
        echo "\t\t<tr> \n";
        foreach($header as $field) {
            echo "\t\t\t<th>" . $field . "</th>\n";
        }
        echo "\t\t</tr>\n";
    }
    
    function showRow($row) { 
        echo "\t\t<tr>\n";
        foreach ($row as $field) {
            echo "\t\t\t<td>" . $field . "</td>\n";
        }
        echo "\t\t</tr>\n";
    }
    
    function addTableField($field) {
        echo "\t\t\t<td>" . $field . "</td>\n";
    }
    
    function addIcons($permissions, $table, $key) {
        echo "\t\t\t<td>";
        if (strstr($permissions, "u")) {
            echo "<a href=\"../controller/" . ucwords($table) . "UpdateController.php?". $key . "\">";
            echo "<img src=\"../view/media/update.ico\" width=\"16\" height=\"16\" alt=\"u\">";
            echo "</a>";
        }
        if (strstr($permissions, "d")) {
            echo "<a href=\"../controller/" . ucwords($table) . "DeleteController.php?". $key . "\">";
            echo "<img src=\"../view/media/delete.png\" width=\"16\" height=\"16\" alt=\"d\">";
            echo "</a>";
        }
        echo "</td>\n";
    }
}
