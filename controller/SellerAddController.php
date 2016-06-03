<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../view/css/style.css" media="screen"/>
        <title>Add an Seller</title>
    </head>
    <body>
       
<?php
    include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';

    session_start();
    if(isset($_SESSION['username'])){
        echo "<h1>Add an Seller</h1>";
        echo "<div><a class='button' href='../controller/SellerController.php'>View Seller</a></div>";
        echo "<br>";
    
    $tableName = "seller";

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
        include '../model/Seller.php';
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
            $seller = view2object();
            $data->setQuery(insertQuery($seller, $tableName));
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
        return new Seller(
                filter_input(INPUT_POST, "nameSeller"),
                filter_input(INPUT_POST, "lastnameseller"),
                filter_input(INPUT_POST, "idSeller", FILTER_VALIDATE_INT) 
        );
    }
    
    function insertQuery($seller) {
        return "INSERT INTO seller (nameseller,lastnameseller,idseller) VALUES ('"
            . $seller-> getNameSeller() . "', '"
            . $seller-> getLastnameSeller() . "', '"
            . $seller->getIdSeller() . "')";   
    }
?>
    </body>
</html>