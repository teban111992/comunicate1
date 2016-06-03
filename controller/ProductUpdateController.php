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
        include '../model/Product.php';
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
            $idProduct=filter_input(INPUT_GET, "codeproduct", FILTER_VALIDATE_INT);
            $data->setQuery("SELECT * FROM $tableName WHERE codeproduct = '" .$idProduct."'");
            $data->execute();
        
            if ($data->getResultset() != NULL) {
                echo "\t<br><br>\n";
                echo "\t<form id=\"frmUpdate" . ucwords($tableName)
                        . "\" name=\"frmUpdate" . ucwords($tableName)
                        . "\" action=\"../controller/" . ucwords($tableName)
                        . "Update2Controller.php\" method=\"POST\">\n";
                echo "\t\t<table>\n";

                while($row = mysqli_fetch_array($data->getResultset(),MYSQLI_ASSOC)){
                $product= result2object($row);
                

                echo "\t\t\t<tr><td>Name Product:</td>"
                    . "<td align=\"right\">" . $product->getNameProduct() . "</td></tr>\n"
                    . "<input id=\"nameProduct\" name=\"nameProduct\" type=\"hidden\" value=\""
                    . $product->getNameProduct() . "\">";

                echo "\t\t\t<tr><td>Code Product:</td>"
                    . "<td align=\"right\">" . $product->getCodeProduct() . "</td></tr>\n"
                    . "<input id=\"codeproduct\" name=\"codeproduct\" type=\"hidden\" value=\""
                    . $product->getCodeProduct() . "\">";

                 echo "\t\t\t<tr><td><label for=\"publicPrice\">Public Price</label></td>"
                    . "<td><input id=\"publicPrice\" name=\"publicPrice\" type=\"text\" value=\"" 
                    . $product->getPublicPrice() . "\"></td></tr>\n";

                 echo "\t\t\t<tr><td><label for=\"suplierPrice\">Suplier Price</label></td>"
                    . "<td><input id=\"suplierPrice\" name=\"suplierPrice\" type=\"text\" value=\"" 
                    . $product->getSuplierPrice() . "\"></td></tr>\n";

                echo "\t\t\t<tr><td><label for=\"quantity\">Quantity</label></td>"
                    . "<td><input id=\"quantity\" name=\"quantity\" type=\"text\" value=\"" 
                    . $product->getQuantity() . "\"></td></tr>\n";

                
                echo "\t\t\t<tr><td><label for=\"idProvider\">Id Provider: </label></td>"
                    . "<td><input id=\"idProvider\" name=\"idProvider\" type=\"text\" value=\"" 
                    . $product->getIdProvider() . "\"></td></tr>\n";


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
        return new product(
                $row['nameproduct'],
                $row['codeproduct'],
                $row['publicprice'],
                $row['suplierprice'],
                $row['quantity'],
                $row['idprovider']
                );
    }
?>

    </body>
</html>
