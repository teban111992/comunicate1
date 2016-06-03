<?php

class Sale {
   var $idBill;
   var $codeProduct;
   var $quatity;
   
   function __construct($idBill, $codeProduct, $quatity) {
       $this->idBill = $idBill;
       $this->codeProduct = $codeProduct;
       $this->quatity = $quatity;
   }
   function resultset($row) {
       $this->setIdBill($row['idbill']);
       $this->setCodeproduct($row['codeproduct']);
       $this->setQuatity($row['quantity']);
   }

   function getIdBill() {
       return $this->idBill;
   }

   function getCodeProduct() {
       return $this->codeProduct;
   }

   function getQuatity() {
       return $this->quatity;
   }

   function setIdBill($idBill) {
       $this->idBill = $idBill;
   }

   function setCodeProduct($codeProduct) {
       $this->codeProduct = $codeProduct;
   }

   function setQuatity($quatity) {
       $this->quatity = $quatity;
   }

}
