<?php
    include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';

    session_start();
    if(isset($_SESSION['username'])){
    $tableName = "bill";

    $menu = new MenuModel();
    $menu->printHTMLHead($_SESSION["appName"] . " (Delete " . ucwords($tableName) . ")");
    $menu->showMenu($_SESSION["menuName"], $_SESSION["userLevel"]);

    $privileges = new PrivilegesModel();
    if ($privileges->isAuthorized($tableName, $_SESSION["userLevel"], "d")) {
        deleteRecord($tableName);
    }
    else {
        echo "\t<br><br><br><br>\n";
        echo "\t<hr><p class=\"warning\">Sorry!, you do not have access privileges!</p>\n";
    }
    
    }else{
        echo "\t<br><br><br><br>\n";
        echo "\t<hr><p class=\"warning\">Sorry!, you do not have session initialitate!</p>\n";
    
    }

    /**
     * Update record
     */
    function deleteRecord($tableName) {
        include '../model/DBModel.php';

        $data = new DBModel(
                $_SESSION["host"],
                $_SESSION["user"],
                $_SESSION["pass"],
                $_SESSION["db"]
        );    
        $data->mysqlConnect();
        if ($data->getLink() != NULL) {
            $idBill = filter_input(INPUT_POST, "idBill", FILTER_VALIDATE_INT);
            $query = "DELETE FROM $tableName WHERE idBill=" . $idBill;
            $data->setQuery($query);
            $data->execute();
        
            echo "\t<br><br>\n";
            if ($data->getResultset() != NULL) {
                echo "\t<p class=\"warning\">Register deleted!</p>\n";
            }
            else {
                echo "\t<p class=\"warning\">Sorry, the register didn't delete!</p>";
            }
           // $data->mysqlFreeQuery();
        }
        $data->mysqlClose();
    }    
?>
    </body>
</html>
