<?php

/**
 * Description of DBModel
 *
 * @author jf
 */
class DBModel {
    var $host;
    var $user;
    var $password;
    var $dbname;
    var $link;
    var $query;
    var $resultset;
    var $port;
    
    /**
     * DBModel constructor
     * @param type $host
     * @param type $user
     * @param type $password
     * @param type $dbname
     */
    function __construct($host, $user, $password, $dbname) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->dbname = $dbname;
        //$this->port=$port;
    }
    function getPort() {
        return $this->port;
    }

    function setPort($port) {
        $this->port = $port;
    }

        function getHost() {
        return $this->host;
    }

    function getUser() {
        return $this->user;
    }

    function getPassword() {
        return $this->password;
    }

    function getDbname() {
        return $this->dbname;
    }

    function getLink() {
        return $this->link;
    }

    function getQuery() {
        return $this->query;
    }

    function getResultset() {
        return $this->resultset;
    }

    function setHost($host) {
        $this->host = $host;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setDbname($dbname) {
        $this->dbname = $dbname;
    }

    function setLink($link) {
        $this->link = $link;
    }

    function setQuery($query) {
        $this->query = $query;
    }

    function setResultset($resultset) {
        $this->resultset = $resultset;
    }

    /**
     * Connect to DB mysql
     */                               
    function mysqlConnect() {
        $this->setLink(
                mysqli_connect(
                        $this->getHost(),
                        $this->getUser(),
                        $this->getPassword(),
                        $this->getDbname(),
                        $this->getPort()
                )
        );
    }
    
    /**
     * Execute a query
     */
     function execute() {
        $this->setResultset(mysqli_query($this->getLink(), $this->getQuery()));
    }

    function resultset2Array() {
        return mysqli_fetch_array($this->getResultset(), MYSQLI_ASSOC);
    }
    
    function mysqlFreeQuery() {
        mysqli_free_result($this->getResultset());
    }

    function mysqlClose() {
        mysqli_close($this->getLink());
    }
}
