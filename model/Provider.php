<?php

class Provider {
    var $nameProvider;
    var $idProvider;
    var $typeProvider;
    
    function __construct($nameProvider, $idProvider, $typeProvider) {
        $this->nameProvider = $nameProvider;
        $this->idProvider = $idProvider;
        $this->typeProvider = $typeProvider;
    }
    function resultset($row) {
        $this->setNameProvider($row['nameprovider']);
        $this->setIdProvider($row['idprovider']);
        $this->setTypeProvider($row['type']);
    
    }
    
    function getNameProvider() {
        return $this->nameProvider;
    }

    function getIdProvider() {
        return $this->idProvider;
    }

    function getTypeProvider() {
        return $this->typeProvider;
    }

    function setNameProvider($nameProvider) {
        $this->nameProvider = $nameProvider;
    }

    function setIdProvider($idProvider) {
        $this->idProvider = $idProvider;
    }

    function setTypeProvider($typeProvider) {
        $this->typeProvider = $typeProvider;
    }



}
