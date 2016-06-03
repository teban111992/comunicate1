<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../view/css/style.css" media="screen"/>
        <title>Add an Product</title>
    </head>
    <body>
       
<?php
    include '../model/DBModel.php';
    include '../model/product.php';
    include '../view/Formatter.php';
    include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';
    
    session_start();
    
    if(isset($_SESSION['username'])){
        echo "<h1>Add an Product</h1>";
        echo "<div><a class='button' href='../controller/ProductController.php'>View Products</a></div>";
        echo "<br>";
    
    $tableName="product";
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
    
    function showForm($tableName) {
        $data = new DBModel(
                $_SESSION["host"],
                $_SESSION["user"],
                $_SESSION["pass"],
                $_SESSION["db"]
        );  
   
    $data->mysqlConnect();
    if ($data->getLink() != NULL) {
        $product = view2object();
        $data->setQuery(insertQuery($product, $tableName));
        $data->execute();
        
        if ($data->getResultset() != NULL) {
            echo "\t<p>Record added!</p>\n";
        }
        else {
            echo "\t<p>Record cannot added!</p>\n";
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
        return new product(
                filter_input(INPUT_POST, "nameProduct"),
                filter_input(INPUT_POST, "code", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "publicPrice", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "suplierPrice", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "idProvider", FILTER_VALIDATE_INT)
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
    function insertQuery($product, $tableName) {
        return "INSERT INTO $tableName (nameproduct,codeproduct,publicprice,suplierprice,quantity,idprovider) VALUES ('"
            . $product->getNameProduct()."','"
            . $product->getCodeProduct()."','"
            . $product->getPublicPrice()."','"
            . $product->getSuplierPrice()."','"
            . $product->getQuantity()."','"
            . $product->getIdProvider()."')";   
    }
?>

    </body>
</html>