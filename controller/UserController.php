<?php
    include '../model/DBModel.php';
    include '../model/MenuModel.php';
    
    $menu = new MenuModel();
    $menu->printHTMLHead("Login");
    
   
    $data = readConfig();
    if (isUser()) {
        callMenu($data);
    }
    else {
        showError();
    }
    $data->mysqlFreeQuery();
    $data->mysqlClose();

    /**
     * Check if he's the user
     * @return boolean True is the user
     */
    function isUser() {
        global $data;
        $data->mysqlConnect();
        
        if ($data->getLink() != NULL) {
            $username = filter_input(INPUT_POST, "username");
            $password = filter_input(INPUT_POST, "password");

            $query = "SELECT * FROM user WHERE " 
                . "username = '".$username."' AND "
                . "password = MD5('".$password."')";
            $data->setQuery($query);
            $data->execute();

            /*if (($data->getResultset() != NULL) && ($data->getResultset()->num_rows > 0)){
                echo "<script type='text/javascript'>alert('Usuario Logueado');window.location='../view/main.html';</script>";
            }*/
            return (($data->getResultset() != NULL) && ($data->getResultset()->num_rows > 0));
        
        }
        else {
            return false;
        }
    }

    /**
     * Obtain user data from db and call menu form
     * @param Resultset $data DB register of the user
     */
    function callMenu($data) {
        $row = $data->resultset2Array();

        $_SESSION["username"]  = $row['username'];
        $_SESSION["password"]  = $row['password'];
        $_SESSION["userLevel"] = $row['userlevel'];
        
        $htmlFile = "../view/main.html";
        //if (readfile($htmlFile)) {
            header("Location:" . $htmlFile);
        //}
       
    }

    /**
     * Read the config file
     * @return \DBModel Connection object
     */
    function readConfig() {
        include '../config/billConfig.php';
        session_start();

        
        $_SESSION["appName"] = $appName;
        $_SESSION["menuName"] = $menuName;

        return new DBModel(
            $_SESSION["host"] = $bdConfig["host"],
            $_SESSION["user"] = $bdConfig["user"],
            $_SESSION["pass"] = $bdConfig["pass"],
            $_SESSION["db"] = $bdConfig["db"]
            //$_SESSION["port"] = $bdConfig["port"]   
        );
    }
    
    /**
     * Show mismatch error
     */
    function showError() {
        echo "
        <h1>Login error!</h1>
        <hr><br>
        <div><a class=\"button\" href=\"../view/User.html\">Login</a></div>
        <br>
            <p class=\"warning\">Sorry, the username and password combination is incorrect!</p>
";
    }
?>
    </body>
</html>
