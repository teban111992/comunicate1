<?php

/**
 * Description of User
 *
 * @author jf
 */
class User {
    var $username;
    var $password;
    var $userLevel;
    var $email;
    var $firstLogin;
    var $lastLogin;
    
    
    /**
     * User constructor
     * @param type $username
     * @param type $password
     * @param type $idEmployee
     * @param type $userLevel
     * @param type $email
     */
    function __construct($username, $password, $userLevel, $email) {
        $this->username = $username;
        $this->password = $password;
        $this->userLevel = $userLevel;
        $this->email = $email;
   
    }
   
    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getUserLevel() {
        return $this->userLevel;
    }

    function getEmail() {
        return $this->email;
    }

    function getFirstLogin() {
        return $this->firstLogin;
    }

    function getLastLogin() {
        return $this->lastLogin;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setUserLevel($userLevel) {
        $this->userLevel = $userLevel;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setFirstLogin($firstLogin) {
        $this->firstLogin = $firstLogin;
    }

    function setLastLogin($lastLogin) {
        $this->lastLogin = $lastLogin;
    }


}