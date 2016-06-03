<?php
    include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';

    session_start();
    if(isset($_SESSION['username'])){
    $tableName = "product";
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
        include '../model/product.php';
        include '../model/DBModel.php';

        $data = new DBModel(
                $_SESSION["host"],
                $_SESSION["user"],
                $_SESSION["pass"],
                $_SESSION["db"]
        );    
        $data->mysqlConnect();
        if ($data->getLink() != NULL) {
            $product = view2object();

            $query = "UPDATE $tableName SET "
                    . "nameproduct= '".$product->getNameProduct()."', "
                    . "codeproduct= '".$product->getCodeProduct()."', "
                    . "publicprice= '".$product->getPublicPrice()."', "
                    . "suplierprice= '".$product->getSuplierPrice()."', "
                    . "quantity= '".$product->getQuantity()."', "
                    . "idprovider= '".$product->getIdProvider()."' "
                    . "WHERE codeproduct= '" . $product->getCodeProduct()."'";
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
        return new product(
                filter_input(INPUT_POST, "nameProduct"),
                filter_input(INPUT_POST, "codeproduct", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "publicPrice", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "suplierPrice", FILTER_VALIDATE_INT), 
                filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "idProvider", FILTER_VALIDATE_INT)
        );
    }    
?>