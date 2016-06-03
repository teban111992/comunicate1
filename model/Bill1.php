<?php
class Bill{
    
    var $idBill;
    var $date;
    var $idSeller;
    var $idClient;
    var $total;
   
    function __construct($idBill, $date, $idSeller, $idClient, $total) {
        $this->idBill = $idBill;
        $this->date = $date;
        $this->idSeller = $idSeller;
        $this->idClient = $idClient;
        $this->total = $total;
        
    }
    function resultset($row) {
        
        $this->setIdBill($row['idbill']);
        $this->setDate($row['date']);
        $this->setIdSeller($row['idseller']);
        $this->setIdClient($row['idclient']);
        $this->setTotal($row['total']);
    }
    
    function getIdBill() {
        return $this->idBill;
    }

    function getDate() {
        return $this->date;
    }

    function getIdSeller() {
        return $this->idSeller;
    }

    function getIdClient() {
        return $this->idClient;
    }

    function getTotal() {
        return $this->total;
    }

    function setIdBill($idBill) {
        $this->idBill = $idBill;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setIdSeller($idSeller) {
        $this->idSeller = $idSeller;
    }

    function setIdClient($idClient) {
        $this->idClient = $idClient;
    }

    function setTotal($total) {
        $this->total = $total;
    }
}

