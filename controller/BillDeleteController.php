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
            $data->setQuery("SELECT * FROM $tableName WHERE idBill = " . $idBill);
            $data->execute();
        
            if ($data->getResultset() != NULL) {
                echo "\t<br><br>\n";
                echo "\t<form id=\"frmUpdate" . ucwords($tableName)
                        . "\" name=\"frmUpdate" . ucwords($tableName)
                        . "\" action=\"../controller/" . ucwords($tableName)
                        . "Delete2Controller.php\" method=\"post\">\n";
                echo "\t\t<table>\n";

                while($row = mysqli_fetch_array($data->getResultset(),MYSQLI_ASSOC)){
                $bill= result2object($row);

                echo "\t\t\t<tr><td>Id:</td>"
                    . "<td align=\"right\">" . $bill->getIdBill() . "</td></tr>\n"
                    . "<input id=\"idBill\" name=\"idBill\" type=\"hidden\" value=\""
                    . $bill->getIdBill() . "\">";

                echo "\t\t\t<tr><td>Date:</td>"
                    . "<td>" . $bill->getDate() . "</td></tr>\n";

                echo "\t\t\t<tr><td>Id Seller:</td>"
                    . "<td>" . $bill->getIdSeller() . "</td></tr>\n";

                echo "\t\t\t<tr><td>Id Client:</td>"
                   . "<td>" . $bill->getIdClient() . "</td></tr>\n";
                echo "\t\t\t<tr><td>Total</td>"
                    . "<td>" . $bill->getTotal() . "</td></tr>\n";

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
