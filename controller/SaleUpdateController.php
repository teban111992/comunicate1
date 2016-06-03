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
            $idBill=filter_input(INPUT_GET, "idBill", FILTER_VALIDATE_INT);
            $data->setQuery("SELECT * FROM $tableName WHERE idbill = " . $idBill);
            $data->execute();
        
            if ($data->getResultset() != NULL) {
                echo "\t<br><br>\n";
                echo "\t<form id=\"frmUpdate" . ucwords($tableName)
                        . "\" name=\"frmUpdate" . ucwords($tableName)
                        . "\" action=\"../controller/" . ucwords($tableName)
                        . "Update2Controller.php\" method=\"post\">\n";
                echo "\t\t<table>\n";

                while($row = mysqli_fetch_array($data->getResultset(),MYSQLI_ASSOC)){
                $sale= result2object($row);
                

                echo "\t\t\t<tr><td>Id Bill:</td>"
                    . "<td align=\"right\">" . $sale->getIdBill() . "</td></tr>\n"
                    . "<input id=\"idBill\" name=\"idBill\" type=\"hidden\" value=\""
                    . $sale->getIdBill() . "\">";

                echo "\t\t\t<tr><td>Code Product:</td>"
                    . "<td align=\"right\">" . $sale->getCodeProduct() . "</td></tr>\n"
                    . "<input id=\"codeProduct\" name=\"codeProduct\" type=\"hidden\" value=\""
                    . $sale->getCodeProduct() . "\">";

                echo "\t\t\t<tr><td><label for=\"quantity\">Quantity</label></td>"
                    . "<td><input id=\"quantity\" name=\"quantity\" type=\"text\" value=\"" 
                    . $sale->getQuatity() . "\"></td></tr>\n";

               

                echo "\t\t\t<tr><td colspan=\"2\"><center><input type=\"submit\"></center></td></tr>\n";

                echo "\t\t</table>\n";
                echo "\t</form>\n";
                }
            }
            //$data->mysqlFreeQuery();
        }
        $data->mysqlClose();
    }
    
     function result2object($row){
        return new Sale(
                $row['idbill'],
                $row['codeproduct'],
                $row['quantity']
                );
    }
?>
