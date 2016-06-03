<?php

/**
 * Description of MenuModel
 *
 * @author jf
 */
class MenuModel {
    
    /**
     * Show HTML header
     */
    function printHTMLHead($title) {
        echo "<!DOCTYPE html>

<html>
    <head>
        <title>$title</title>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"../view/css/style.css\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"../view/css/menu.css\">
        
        <link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css\">
        <script src=\"//code.jquery.com/jquery-1.10.2.js\"></script>
        <script src=\"//code.jquery.com/ui/1.11.4/jquery-ui.js\"></script>
        <script>
            $(function() {
               $(\"#bornDate\").datepicker({ dateFormat:'yy-mm-dd'});
               $(\"#hiredDate\").datepicker({ dateFormat:'yy-mm-dd'});
            });
        </script>
</head>
    <body>
        <h1>$title</h1>
";
    }
    
    /**
     * Show menu
     */
    function showMenu($menuName, $currentLevel) {
        include '../config/billConfig.php';

        echo "
        <ul id=\"menu-bar\">
            <li class=\"active\"><a href=\"../view/index.php\">Home</a></li>
            <li><a href=\"#\">$menuName</a>
                <ul>
";
        if (isset($currentLevel)) {
            foreach ($privileges as $table => $subArray) {
                foreach ($subArray as $userLevel => $permission) {
                    if ($userLevel == $currentLevel) {
                        if (strcmp($permission, "") != 0) {
                            echo "\t\t\t<li>";
                            echo "<a href=\"../controller/" . ucwords($table) 
                                    . "Controller.php\">";
                            echo ucwords($table);
                            echo "</a></li>\n";
                        }
                    }
                }
            }
        }

        echo "                </ul>
            </li>
            <li><a href=\"../view/about.html\">About</a></li>
            <li><a href=\"../index.php\">Log out</a></li>
        </ul>
";
    }
}
