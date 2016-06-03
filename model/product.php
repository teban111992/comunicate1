<?php

class product {
    var $nameProduct;
    var $codeProduct;
    var $publicPrice;
    var $suplierPrice;
    var $quantity;
    var $idProvider;
    function __construct($nameProduct, $codeProduct, $publicPrice, $suplierPrice, $quantity, $idProvider) {
        $this->nameProduct = $nameProduct;
        $this->codeProduct = $codeProduct;
        $this->publicPrice = $publicPrice;
        $this->suplierPrice = $suplierPrice;
        $this->quantity = $quantity; 
        $this->quantity = $quantity; 
        $this->idProvider = $idProvider;
        
    }
    function resultset($row) {
        $this->setNameProduct($row['nameproduct']);
        $this->setCodeProduct($row['codeproduct']);
        $this->setPublicPrice($row['publicprice']);
        $this->setSuplierPrice($row['suplierprice']);   
        $this->setQuantity($row['quantity']);
        $this->setIdProvider($row['idprovider']);
    }
    

    function getNameProduct() {
        return $this->nameProduct;
    }

    function getCodeProduct() {
        return $this->codeProduct;
    }

    function getPublicPrice() {
        return $this->publicPrice;
    }

    function getSuplierPrice() {
        return $this->suplierPrice;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function getIdProvider() {
        return $this->idProvider;
    }

    function setNameProduct($nameProduct) {
        $this->nameProduct = $nameProduct;
    }

    function setCodeProduct($codeProduct) {
        $this->codeProduct = $codeProduct;
    }

    function setPublicPrice($publicPrice) {
        $this->publicPrice = $publicPrice;
    }

    function setSuplierPrice($suplierPrice) {
        $this->suplierPrice = $suplierPrice;
    }

    function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    function setIdProvider($idProvider) {
        $this->idProvider = $idProvider;
    }


    


}