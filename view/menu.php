<?php
    include '../model/MenuModel.php';
    
    session_start();
    
    $menu = new MenuModel();
    $menu->printHTMLHead($_SESSION["appName"]);
    
    if (isset($_SESSION["username"]) && isset($_SESSION["userLevel"]) && isset($_SESSION["db"])) {
        $menu->showMenu($_SESSION["menuName"], $_SESSION["userLevel"]);
    }
    else {
        echo "<hr><p>I'm sorry. You must first loggin!</p>";
    }
?>
    </body>
</html>
