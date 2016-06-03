<?php
    include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';

    session_start();
    if(isset($_SESSION['username'])){
    $tableName = "bill";

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

    /**
     * Update record
     */
    function updateRecord($tableName) {
        include '../model/Bill.php';
        include '../model/DBModel.php';

        $data = new DBModel(
                $_SESSION["host"],
                $_SESSION["user"],
                $_SESSION["pass"],
                $_SESSION["db"]
        );    
        $data->mysqlConnect();
        if ($data->getLink() != NULL) {
            $bill = view2object();

             $query = "UPDATE $tableName SET "
                    . "idbill= '".$bill->getIdBill()."', "
                    . "date= '".$bill->getDate()."', "
                    . "idseller= '".$bill->getIdSeller()."', "
                    . "idclient= '".$bill->getIdClient()."', "
                    . "total= '".$bill->getTotal()."' "
                    . "WHERE idbill= '" . $bill->getIdBill()."'";
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
    
    /**
     * Create an employee object from a view
     * @return \Employee Employee object
     */
    function view2object() {
        return new Bill(
                filter_input(INPUT_POST, "idBill", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "dateBill"),
                filter_input(INPUT_POST, "idSeller", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "idClient", FILTER_VALIDATE_INT),
                filter_input(INPUT_POST, "totalBill", FILTER_VALIDATE_INT)
               
        );
    }    
?>
    </body>
</html>

