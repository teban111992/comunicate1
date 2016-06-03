<?php
    include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';

    session_start();
     if(isset($_SESSION['username'])){
    $tableName = "provider";

    $menu = new MenuModel();
    $menu->printHTMLHead($_SESSION["appName"] . " (Delete " . ucwords($tableName) . ")");
    $menu->showMenu($_SESSION["menuName"], $_SESSION["userLevel"]);

    $privileges = new PrivilegesModel();
    if ($privileges->isAuthorized($tableName, $_SESSION["userLevel"], "d")) {
        showForm($tableName);
    }
    else {
        echo "\t<br><br><br><br>\n";
        echo "\t<hr><p class=\"warning\">Sorry!, you do not have access privileges!</p>\n";
    }
     }else{
        echo "\t<br><br><br><br>\n";
        echo "\t<hr><p class=\"warning\">Sorry!, you do not have session initialitate!</p>\n";
    
    }
    
    
     
    function showForm($tableName) {
        include '../model/Provider.php';
        include '../model/DBModel.php';
        include '../view/Formatter.php';

        $data = new DBModel(
                $_SESSION["host"],
                $_SESSION["user"],
                $_SESSION["pass"],
                $_SESSION["db"]
        );    
        $data->mysqlConnect();
        if ($data->getLink() != NULL) {
            $idProvider=filter_input(INPUT_GET, "idProvider", FILTER_VALIDATE_INT);
            $data->setQuery("SELECT * FROM $tableName WHERE idprovider = '" . $idProvider."'");
            $data->execute();
        
            if ($data->getResultset() != NULL) {
                echo "\t<br><br>\n";
                echo "\t<form id=\"frmUpdate" . ucwords($tableName)
                        . "\" name=\"frmUpdate" . ucwords($tableName)
                        . "\" action=\"../controller/" . ucwords($tableName)
                        . "Delete2Controller.php\" method=\"post\">\n";
                echo "\t\t<table>\n";

                while($row = mysqli_fetch_array($data->getResultset(),MYSQLI_ASSOC)){
                $provider= result2object($row);

                echo "\t\t\t<tr><td>Id Provider:</td>"
                    . "<td align=\"right\">" . $provider->getIdProvider() . "</td></tr>\n"
                    . "<input id=\"idProvider\" name=\"idProvider\" type=\"hidden\" value=\""
                    . $provider->getIdProvider() . "\">";

                echo "\t\t\t<tr><td>Name Provider</td>"
                    . "<td>" . $provider->getNameProvider() . "</td></tr>\n";

                echo "\t\t\t<tr><td>Type Provider</td>"
                    . "<td>" . $provider->getTypeProvider() . "</td></tr>\n";

                echo "\t\t\t<tr><td colspan=\"2\"><center><input type=\"submit\"></center></td></tr>\n";

                echo "\t\t</table>\n";
                echo "\t</form>\n";
                }
            }
            //$data->mysqlFreeQuery();
        }
        $data->mysqlClose();
    }
    
    function result2object($row){
        return new Provider(
                $row['nameprovider'],
                $row['idprovider'],
                $row['type']
                );
    }
?>

