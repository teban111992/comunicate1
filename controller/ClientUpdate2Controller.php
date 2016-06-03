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
        updateRecord($tableName);
    }
    else {
        echo "\t<br><br><br><br>\n";
        echo "\t<hr><p class=\"warning\">Sorry!, you do not have access privileges!</p>\n";
    }
    }else{
        echo "\t<br><br><br><br>\n";
        echo "\t<hr><p class=\"warning\">Sorry!, you do not have session initialitate!</p>\n";
    
    }
    
    function updateRecord($tableName) {
        include '../model/Client.php';
        include '../model/DBModel.php';

        $data = new DBModel(
                $_SESSION["host"],
                $_SESSION["user"],
                $_SESSION["pass"],
                $_SESSION["db"]
        );    
        $data->mysqlConnect();
        if ($data->getLink() != NULL) {
            $client = view2object();

            $query = "UPDATE $tableName SET "
                    . "nameclient='" . $client->getNameClient() . "', "
                    . "lastnameclient='" . $client->getLastnameClient() . "', "
                    . "idclient='" . $client->getIdClient() . "' "
                    . "WHERE idclient='" . $client->getIdClient()."'";
            $data->setQuery($query);
            $data->execute();
        
            echo "\t<br><br>\n";
            if ($data->getResultset() != NULL) {
                echo "\t<p class=\"warning\">Register updated!</p>\n";
            }
            else {
                echo "\t<p class=\"warning\">Sorry, the register didn't update!</p>";
            }
            //$data->mysqlFreeQuery();
        }
        $data->mysqlClose();
    }
    
    
     function view2object() {
        return new Client(
                filter_input(INPUT_POST, "nameClient"),
                filter_input(INPUT_POST, "lastnameClient"),
                filter_input(INPUT_POST, "idClient", FILTER_VALIDATE_INT)
                 );
    }    
?>
