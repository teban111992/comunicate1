<?php

/**
 * Description of PrivilegesModel
 *
 * @author jf
 */
class PrivilegesModel {

    /**
     * Check if you have the required permissions
     * @return type True if you have the permissions
     */
    function isAuthorized($table, $userLevel, $permission) {
        if (!isset($table) || !isset($userLevel) || !isset($permission)) {
            return false;
        }
        return (strstr($this->readPermissions($table, $userLevel), $permission) != FALSE);
    }

    /**
     * Consult the privilegies for the user profile
     * @param type $currentTable Current db table
     * @return type Permissions string
     */
   function readPermissions($currentTable, $currentLevel) {
        include '../config/billConfig.php';

        foreach ($privileges as $table => $subArray) {
            if (strcmp($currentTable, $table) == 0) {
                foreach ($subArray as $userLevel => $permission) {
                    if ($userLevel == $currentLevel) {
                        return $permission;
                    }
                }
                break;
            }
        }
        return "";
    }
}
