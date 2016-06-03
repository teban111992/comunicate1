<?php


class Client {
  
    var $nameClient;
    var $lastnameClient;
    var $idClient;
      
    function __construct($nameClient, $lastnameClient, $idClient) {
        $this->nameClient = $nameClient;
        $this->lastnameClient = $lastnameClient;
         $this->idClient = $idClient;
    }
     function resultset($row) {
        $this->setNameClient($row['nameclient']);
        $this->setLastnameClient($row['lastnameclient']);
        $this->setIdClient($row['idclient']);
     }
    
    function getIdClient() {
        return $this->idClient;
    }

    function getNameClient() {
        return $this->nameClient;
    }

    function getLastnameClient() {
        return $this->lastnameClient;
    }

    function setIdClient($idClient) {
        $this->idClient = $idClient;
    }

    function setNameClient($nameClient) {
        $this->nameClient = $nameClient;
    }

    function setLastnameClient($lastnameClient) {
        $this->lastnameClient = $lastnameClient;
    }



}
