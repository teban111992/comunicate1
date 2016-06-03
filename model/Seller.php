<?php

class Seller {
    var $nameSeller;
    var $lastnameSeller;
    var $idSeller;
    
    function __construct($nameSeller, $lastnameSeller, $idSeller) {
        $this->nameSeller = $nameSeller;
        $this->lastnameSeller = $lastnameSeller;
        $this->idSeller = $idSeller;
    }
    function resultset($row) {
        $this->setNameSeller($row['nameseller']);
         $this->setLastnameSeller($row['lastnameseller']);
          $this->setIdSeller($row['idseller']);

   
    }
    
    function getNameSeller() {
        return $this->nameSeller;
    }

    function getLastnameSeller() {
        return $this->lastnameSeller;
    }

    function getIdSeller() {
        return $this->idSeller;
    }

    function setNameSeller($nameSeller) {
        $this->nameSeller = $nameSeller;
    }

    function setLastnameSeller($lastnameSeller) {
        $this->lastnameSeller = $lastnameSeller;
    }

    function setIdSeller($idSeller) {
        $this->idSeller = $idSeller;
    }



    
}