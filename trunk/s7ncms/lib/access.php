<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id: config.php 35 2006-07-16 13:25:24Z edy $
 * @copyright Eduard Baun, 2006
 */

class S7N_Access {
    public function isAdmin() {
        return isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : false;
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
    }
    
    public function getUserId() {
        return isset($_SESSION['id']) ? $_SESSION['id'] : 0;
    }

    public function getUserNickname() {
        return $this->isLoggedIn() ? $_SESSION['loginname'] : null;
    }
}
?>