<?php
 include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';

    session_start();
     if(isset($_SESSION['username'])){
    $tableName = "sale";

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
        include '../model/Sale.php';
        include '../model/DBModel.php';

        $data = new DBModel(
                $_SESSION["host"],
                $_SESSION["user"],
                $_SESSION["pass"],
                $_SESSION["db"]
        );    
        $data->mysqlConnect();
        if ($data->getLink() != NULL) {
            $sale = view2object();

            $query = "UPDATE $tableName SET "
                    . "idbill='" . $sale->getIdBill() . "', "
                    . "codeproduct='" . $sale->getCodeProduct() . "', "
                    . "quantity='" . $sale->getQuatity() . "'"
                    . "WHERE idbill='" . $sale->getIdBill()."' AND codeproduct='".$sale->getCodeProduct()."'";
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
        return new Sale(
                filter_input(INPUT_POST, "idBill", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "codeProduct", FILTER_VALIDATE_INT), 
                filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT)
        );
    }    
?>
    
