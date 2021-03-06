<?php
    include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';

    session_start();
     if(isset($_SESSION['username'])){
    $tableName = "product";
    
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
    
    
    function showForm($tableName){
        include '../model/product.php';
        include '../model/DBModel.php';
        include '../view/Formatter.php';

        $data = new DBModel(
                $_SESSION["host"],
                $_SESSION["user"],
                $_SESSION["pass"],
                $_SESSION["db"]
        );    
        $data->mysqlConnect();
        if($data->getLink() != NULL){
            $idProduct=filter_input(INPUT_GET, "codeproduct", FILTER_VALIDATE_INT);
            $data->setQuery("SELECT * FROM $tableName WHERE  codeproduct = " .$idProduct);
            $data->execute();
            if ($data->getResultset() != NULL) {
                echo "\t<br><br>\n";
                echo "\t<form id=\"frmUpdate" . ucwords($tableName)
                        . "\" name=\"frmUpdate" . ucwords($tableName)
                        . "\" action=\"../controller/" . ucwords($tableName)
                        . "Delete2Controller.php\" method=\"post\">\n";
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

                echo "\t\t\t<tr><td>Public Price</td>"
                    . "<td>" . $product->getPublicPrice() . "</td></tr>\n";

                echo "\t\t\t<tr><td>Suplier Price</td>"
                    ."<td>" . $product->getSuplierPrice() . "</td></tr>\n";

                echo "\t\t\t<tr><td>Quantity</td>"
                    . "<td>" . $product->getIdProvider() . "</td></tr>\n";

                echo "\t\t\t<tr><td colspan=\"2\"><center><input type=\"submit\"></center></td></tr>\n";

                echo "\t\t</table>\n";
                echo "\t</form>\n";
      
                }
            }
            // $data->mysqlFreeQuery(); 
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