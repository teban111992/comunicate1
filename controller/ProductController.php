<!DOCTYPE html>

<html>
    <head>
            <title>Product</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Product</h1>
 <?php
    include '../model/MenuModel.php';
    include '../model/PrivilegesModel.php';

    session_start();
    if(isset($_SESSION['username'])){
    $tableName = "product";

    $menu = new MenuModel();
    $menu->printHTMLHead($_SESSION["appName"] . " (" . ucwords($tableName) . ")");
    $menu->showMenu($_SESSION["menuName"], $_SESSION["userLevel"]);

    $privileges = new PrivilegesModel();
    if ($privileges->isAuthorized($tableName, $_SESSION["userLevel"], "r")) {
        showForm($privileges, $tableName, $_SESSION["userLevel"]);
    }
    else {
        echo "\t<br><br><br><br>\n";
        echo "\t<hr><p class=\"warning\">Sorry!, you do not have access privileges!</p>\n";
    }
    }else{
        echo "\t<br><br><br><br>\n";
        echo "\t<hr><p class=\"warning\">Sorry!, you do not have session initialitate!</p>\n";
    
    }
    
    
    function showForm($privileges, $tableName, $userLevel){
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
            $data->setQuery("SELECT * FROM " . $tableName);
            $data->execute();
            
            if($data->getResultset() != NULL){
                echo "\t<br><br>\n";
                if ($privileges->isAuthorized($tableName, $userLevel, "c")) {
                    echo "\t<div><a class=\"button\" href=\"../view/"
                        . ucwords($tableName) . "Add.html\">Add " 
                        . ucwords($tableName) . "</a></div>\n";
                    echo "\t<br>\n";
                }
                echo "\t<table>\n";

                $headers = array("name", "code", "publicPrice", "suplierPrice", "Quantity", "IdProvider");
                $formatter = new Formatter();
                $formatter->tableHeaders($headers);

                while($row = mysqli_fetch_array($data->getResultset(),MYSQLI_ASSOC)){
                $product= result2object($row);
                
                    echo "\t\t<tr>\n";
                    $formatter->addTableField($product->getNameProduct());
                    $formatter->addTableField($product->getCodeProduct());
                    $formatter->addTableField($product->getPublicPrice());
                    $formatter->addTableField($product->getSuplierPrice());
                    $formatter->addTableField($product->getQuantity());
                    $formatter->addTableField($product->getIdProvider());

                    $formatter->addIcons($privileges->readPermissions($tableName, $userLevel)
                            , $tableName
                            , "codeproduct=" . $product->getCodeProduct()
                    );
                    echo "\t\t</tr>\n";
                }
                echo "\t</table>\n";
            }
            $data->mysqlFreeQuery();
        }
        $data->mysqlClose();
    }

/*
 
$data = new DBModel("localhost", "user", "esteban", "dbcomunicate", "8080");
$data->mysqlConnect();   
    if ($data->getLink() != NULL) {
     $data->setQuery("SELECT * FROM product");
     $data->execute();
     
     if($data->getResultset() !=NULL){
         echo "\t<table>\n"; 
         
         $header = array("name", "code", "publicPrice", "suplierPrice", "Quantity", "IdProvider");
         $formatter = new Formatter();
         $formatter->tableHeaders($header);
         
          while($row = mysqli_fetch_array($data->getResultset(),MYSQLI_ASSOC)){
                $product= result2object($row);
                
                echo "\t\t<tr>\n";
                $formatter->addTableField($product->getNameProduct());
                $formatter->addTableField($product->getCodeProduct());
                $formatter->addTableField($product->getPublicPrice());
                $formatter->addTableField($product->getSuplierPrice());
                $formatter->addTableField($product->getQuantity());
                $formatter->addTableField($product->getIdProvider());
                
                echo "\t\t</tr>\n";
            }   
            echo "\t</table>\n";
        }
        mysqli_free_result($data->getResultset());
    }
   
    mysqli_close($data->getLink());
    */
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