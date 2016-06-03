<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../view/css/style.css" media="screen"/>
        <title>Add an Bill</title>
    </head>
    <body>
        
<?php
    include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';
    
    session_start();
    if(isset($_SESSION['username'])){
        echo "<h1>Add an Bill</h1>";
        echo "<div><a class='button' href='../controller/BillController.php'>View Bills</a></div>";
        echo "<br>";
    
    $tableName = "bill";
    
    $menu = new MenuModel();
    $menu->printHTMLHead($_SESSION["appName"] . " (Add " . ucwords($tableName) . ")" );
    $menu->showMenu($_SESSION["menuName"], $_SESSION["userLevel"]);
    
    $privileges = new PrivilegesModel();
    if($privileges->isAuthorized($tableName, $_SESSION["userLevel"], "c")){
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
    
    function showForm($tableName){
    
    include '../model/DBModel.php';
    include '../view/Formatter.php';
    
    $bill = view2object();
    $data = new DBModel( $_SESSION["host"],
                $_SESSION["user"],
                $_SESSION["pass"],
                $_SESSION["db"]
                //$_SESSION["port"]
          );
    
    $data->mysqlConnect();
    if ($data->getLink() != NULL) {
        $data->setQuery(insertQuery($bill, $tableName));
        $data->execute();
        
        
        if ($data->getResultset() != NULL) {
            echo "\t<p class=\"warning\">Record added!</p>\n";
        }else {
            echo "\t<p class=\"warning\">Record cannot added!</p>\n";
        }
      //  $data->mysqlFreeQuery();
        }
        $data->mysqlClose();
    }
    

    /**
     * Create an employee object from a view
     * @return \Employee Employee object
     */
    function view2object() {
        include '../model/Bill.php';
        return new Bill(
                filter_input(INPUT_POST, "idBill", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "dateBill"),
                filter_input(INPUT_POST, "idSeller", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "idClient", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "totalBill", FILTER_VALIDATE_INT)
        );
    }
    
    function insertQuery($bill, $tableName) {
        return "INSERT INTO $tableName (idbill,date,idseller,idclient,total) VALUES ('"
            .$bill->getIdBill()."','"
            .date("Y-m-d", strtotime($bill->getDate())) . "', '"
            .$bill->getIdSeller()."','"
            .$bill->getIdClient()."','"
            .$bill->getTotal()."')";   
    }
?>

    </body>
</html>