<!DOCTYPE html>

<html>
    <head>
            <title>Bill</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Bill</h1>
 <?php

 include '../model/MenuModel.php';
 include '../model/PrivilegesModel.php';
 
 session_start();
 if(isset($_SESSION['username'])){
        
 
 $tableName = "bill";
 
    $menu = new MenuModel();
    $menu->printHTMLHead($_SESSION["appName"]." (" .ucwords($tableName).")");
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

 function showForm($privileges, $tableName, $userLevel) {
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
     $data->setQuery("SELECT * FROM " . $tableName);
     $data->execute();
     
     if($data->getResultset() !=NULL){
         echo "\t<table>\n"; 
          if ($privileges->isAuthorized($tableName, $userLevel, "c")) {
                    echo "\t<div><a class=\"button\" href=\"../view/"
                        . ucwords($tableName) . "Add.html\">Add " 
                        . ucwords($tableName) . "</a></div>\n";
                    echo "\t<br>\n";
                }
                echo "\t<table>\n";
         
         $header = array("idBill", "date", "idSeller", "idClient", "total");
         $formatter = new Formatter();
         $formatter->tableHeaders($header);
         
           while($row = mysqli_fetch_array($data->getResultset(),MYSQLI_ASSOC)){
                $bill= result2object($row);
                
                echo "\t\t<tr>\n";
                $formatter->addTableField($bill->getIdBill());
                $formatter->addTableField($bill->getDate());
                $formatter->addTableField($bill->getIdSeller());
                $formatter->addTableField($bill->getIdClient());
                $formatter->addTableField($bill->getTotal());
                
                $formatter->addIcons($privileges->readPermissions($tableName, $userLevel)
                            , $tableName
                            , "idBill=" . $bill->getIdBill()
                    );
                echo "\t\t</tr>\n";
            }   
            echo "\t</table>\n";
        }
        $data->mysqlFreeQuery();
        
       // mysqli_free_result($data->getResultset());
    }
    $data->mysqlClose();
 }
   
    //mysqli_close($data->getLink());
    
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