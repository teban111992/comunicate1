<?php
 include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';

    session_start();
    if(isset($_SESSION['username'])){
    $tableName = "seller";

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
            $idSeller=filter_input(INPUT_GET, "idSeller", FILTER_VALIDATE_INT);
            $data->setQuery("SELECT * FROM $tableName WHERE idseller = '" . $idSeller."'");
            $data->execute();
        
            if ($data->getResultset() != NULL) {
                echo "\t<br><br>\n";
                echo "\t<form id=\"frmUpdate" . ucwords($tableName)
                        . "\" name=\"frmUpdate" . ucwords($tableName)
                        . "\" action=\"../controller/" . ucwords($tableName)
                        . "Update2Controller.php\" method=\"post\">\n";
                echo "\t\t<table>\n";

               while($row = mysqli_fetch_array($data->getResultset(),MYSQLI_ASSOC)){
                $seller= result2object($row);

                echo "\t\t\t<tr><td>Id Seller:</td>"
                    . "<td align=\"right\">" . $seller->getIdSeller() . "</td></tr>\n"
                    . "<input id=\"idSeller\" name=\"idSeller\" type=\"hidden\" value=\""
                    . $seller->getIdSeller() . "\">";

                echo "\t\t\t<tr><td><label for=\"nameSeller\">Name Seller</label></td>"
                    . "<td><input id=\"nameSeller\" name=\"nameSeller\" type=\"text\" value=\"" 
                    . $seller->getNameSeller() . "\"></td></tr>\n";

                echo "\t\t\t<tr><td><label for=\"lastnameSeller\">Lastname Seller</label></td>"
                    . "<td><input id=\"lastnameSeller\" name=\"lastnameSeller\" type=\"text\" value=\"" 
                    . $seller->getLastnameSeller() . "\"></td></tr>\n";

              

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
        return new Seller(
                $row['nameseller'],
                $row['lastnameseller'],
                $row['idseller']
                );
    }
?>