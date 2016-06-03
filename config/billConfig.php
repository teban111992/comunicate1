<?php

/**
 * key => value, where
 *  key is 
 *   host: machine where the database is (localhost default)
 *   user: user to query the database
 *   password: user's password to query the database
 *   db: name of the database
 */
$bdConfig = array(
    "host" => "localhost",
    "user" => "user",
    "pass" => "esteban",
    "db"   => "dbcomunicate",
    "port" => "71"
);

/*
 * key => value, where
 *  key is DB table
 *  value is an array of subkey => subvalue, where
 *   subkey is a privilege (0: administrator, 1: seller, ...)
 *   value is the permission (Create, Read, Update, Delete)
 * 
 * */

$privileges = array (
    "user"         => array(0 => "crud", 1 => "r"),
    "bill"         => array(0 => "crud", 1 => "cru"),
    "client"     => array(0 => "crud", 1 => "ru"),
    "product"         => array(0 => "crud", 1 => "cru"),
    "provider"       => array(0 => "crud", 1 => "cru"),
    "sale"      => array(0 => "crud", 1 => "cru"),
    "seller"      => array(0 => "crud", 1 => "ru"),
    
);

$appName = "Comunicate Cafe";
$menuName = "Comunicate";
 