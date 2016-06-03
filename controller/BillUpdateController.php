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
        include '../model/Bill.php';
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
            $idBill=filter_input(INPUT_GET, "idBill", FILTER_VALIDATE_INT);
            $data->setQuery("SELECT * FROM $tableName WHERE idbill = '" .$idBill."'");
            $data->execute();
        
            if ($data->getResultset() != NULL) {
                echo "\t<br><br>\n";
                echo "\t<form id=\"frmUpdate" . ucwords($tableName)
                        . "\" name=\"frmUpdate" . ucwords($tableName)
                        . "\" action=\"../controller/" . ucwords($tableName)
                        . "Update2Controller.php\" method=\"POST\">\n";
                echo "\t\t<table>\n";

                while($row = mysqli_fetch_array($data->getResultset(),MYSQLI_ASSOC)){
                $bill= result2object($row);

                echo "\t\t\t<tr><td>Id:</td>"
                    . "<td align=\"right\">" . $bill->getIdBill() . "</td></tr>\n"
                    . "<input id=\"idBill\" name=\"idBill\" type=\"hidden\" value=\""
                    . $bill->getIdBill() . "\">";

                echo "\t\t\t<tr><td><label for=\"dateBill\">Date</label></td>"
                    . "<td><input id=\"dateBill\" name=\"dateBill\" type=\"text\" value=\"" 
                    . $bill->getDate() . "\"></td></tr>\n";

                echo "\t\t\t<tr><td><label for=\"idSeller\">Id Seller</label></td>"
                    . "<td><input id=\"idSeller\" name=\"idSeller\" type=\"text\" value=\"" 
                    . $bill->getIdSeller() . "\"></td></tr>\n";

                
                echo "\t\t\t</tr>\n";

                echo "\t\t\t<tr><td><label for=\"idClient\">Id Client</label></td>"
                    . "<td><input id=\"idClient\" name=\"idClient\" type=\"text\" value=\"" 
                    . $bill->getIdClient() . "\"></td></tr>\n";

                echo "\t\t\t<tr><td><label for=\"totalBill\">Total date</label></td>"
                    . "<td><input id=\"totalBill\" name=\"totalBill\" type=\"text\" value=\"" 
                    . $bill->getTotal() . "\"></td></tr>\n";
                echo "\t\t\t<tr><td colspan=\"2\"><center><input type=\"submit\"></center></td></tr>\n";

                echo "\t\t</table>\n";
                echo "\t</form>\n";
                }
            }
            $data->mysqlFreeQuery();
        }
        $data->mysqlClose();
    }
    
     function result2object($row){
        return new Bill(
                $row['idbill'],
                $row['date'],
                $row['idseller'] ,
                $row['idclient'],
                $row['total'] 
                );
    }
     
?>
    </body>
</html>
