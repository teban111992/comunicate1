<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../view/css/style.css" media="screen"/>
        <title>Add an Sale</title>
    </head>
    <body>
     
    
<?php
    include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';

    session_start();
    if(isset($_SESSION['username'])){
        echo "<h1>Add an Sale</h1>";
        echo "<div><a class='button' href='../controller/SaleController.php'>View Sale</a></div>";
        echo "<br>";
    
    $tableName = "sale";

    $menu = new MenuModel();
    $menu->printHTMLHead($_SESSION["appName"] . " (Add " . ucwords($tableName) . ")");
    $menu->showMenu($_SESSION["menuName"], $_SESSION["userLevel"]);

    $privileges = new PrivilegesModel();
    if ($privileges->isAuthorized($tableName, $_SESSION["userLevel"], "c")) {
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

    /**
     * Show form
     */
    function showForm($tableName) {
        include '../model/Sale.php';
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
            $sale = view2object();
            $data->setQuery(insertQuery($sale, $tableName));
            $data->execute();
        
            if ($data->getResultset() != NULL) {
                echo "\t<p class=\"warning\">Record added!</p>\n";
            }
            else {
                echo "\t<p class=\"warning\">Record cannot added!</p>\n";
            }
            //$data->mysqlFreeQuery();
        }
        $data->mysqlClose();
    }

    /**
     * Create an employee object from a view
     * @return \Employee Employee object
     */
    function view2object() {
        return new Sale(
                
                filter_input(INPUT_POST, "idBill", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "codeProduct", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT)
        );
    }
    
    /*function insertQuery($product) {
        return "INSERT INTO product (nameproduct,codeproduct,publicprice,suplierprice,quantity,idprovider) VALUES ('coca cola'"
            . ",'5432',"
            . "'654',"
            . "'6543',"
            . "'1',"
            . "'123')";   
    }*/
    function insertQuery($sale) {
        return "INSERT INTO sale (idbill,codeproduct,quantity) VALUES ('"
            . $sale->getIdBill()."','"
            . $sale->getCodeProduct()."','"
            . $sale->getQuatity()."')";   
    }
    
    
?>

    </body>
</html>