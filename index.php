<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Comunicate</title>
    </head>
    <body>
        <?php
            session_start();
            $arr = get_defined_vars();
            unset_all_vars($arr["_SESSION"]);
            session_destroy();

            $htmlFile = "view/User.html";
            if (readfile($htmlFile)) {
                header("Location:" . $htmlFile);
            }

            function unset_all_vars($a) {
                foreach($a as $key => $val) {
                    unset($GLOBALS[$key]);
                }
                return serialize($a);
            }
        ?>
    </body>
</html>
 