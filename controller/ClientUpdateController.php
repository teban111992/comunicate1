<?php

    include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';

    session_start();
    if(isset($_SESSION['username'])){
    $tableName = "client";

    $menu = new MenuModel();
    $menu->printHTMLHead($_SESSION["appName"] . " (Update " . ucwords($tableName) . ")");
    $menu->showMenu($_SESSION["menuName"], $_SESSION["userLevel"]);

    $privileges = new PrivilegesModel();
    if ($privileges->isAuthorized($tableName, $_SESSION["userLevel"], "u")) {
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
        include '../model/Client.php';
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
            $idClient=filter_input(INPUT_GET, "idClient", FILTER_VALIDATE_INT);
            $data->setQuery("SELECT * FROM $tableName WHERE idclient = '" . $idClient."'");
            $data->execute();
        
            if ($data->getResultset() != NULL) {
                 while($row = mysqli_fetch_array($data->getResultset(),MYSQLI_ASSOC)){
                echo "\t<br><br>\n";
                echo "\t<form id=\"frmUpdate" . ucwords($tableName)
                        . "\" name=\"frmUpdate" . ucwords($tableName)
                        . "\" action=\"../controller/" . ucwords($tableName)
                        . "Update2Controller.php\" method=\"POST\">\n";
                echo "\t\t<table>\n";

               
                $client= result2object($row);
                

                echo "\t\t\t<tr><td>Identification:</td>"
                    . "<td align=\"right\">" . $client->getIdClient() . "</td></tr>\n"
                    . "<input id=\"idClient\" name=\"idClient\" type=\"hidden\" value=\""
                    . $client->getIdClient() . "\">";

                echo "\t\t\t<tr><td><label for=\"nameClient\">Firstname</label></td>"
                    . "<td><input id=\"nameClient\" name=\"nameClient\" type=\"text\" value=\"" 
                    . $client->getNameClient() . "\"></td></tr>\n";

                echo "\t\t\t<tr><td><label for=\"lastnameClient\">Lastname</label></td>"
                    . "<td><input id=\"lastnameClient\" name=\"lastnameClient\" type=\"text\" value=\"" 
                    . $client->getLastnameClient() . "\"></td></tr>\n";

               

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
        return new Client(
                $row['nameclient'],
                $row['lastnameclient'],
                $row['idclient']
                );
    }
?>