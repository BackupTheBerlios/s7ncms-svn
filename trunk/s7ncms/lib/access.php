<?php
/**
 * S7Ncms - www.s7n.de
 * 
 * Copyright (c) 2006, Eduard Baun
 * All rights reserved.
 * 
 * See license.txt for full text and disclaimer
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @copyright Eduard Baun, 2006
 * @version $Id$
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
    
    public function canRead($module) {
        if($this->isAdmin()) {
            return true;
        }

        $groupId = isset($_SESSION['group_id']) ? $_SESSION['group_id'] : 0;

        $result = $this->db->query("SELECT rights FROM ".DB_PREFIX."userrights WHERE group_id = '".$groupId."' AND module = '".$module."' LIMIT 1");
        $row = $this->db->fetchAssoc($result);

        $bin = decbin($row['rights']);
        $bin = substr("0000",0,4 - strlen($bin)) . $bin;
        if(substr($bin,0,1)==1) {
            return true;
        } else {
            return false;
        }
    }

    public function canWrite($module) {
        if($this->isAdmin()) {
            return true;
        }
        $groupId = isset($_SESSION['group_id']) ? $_SESSION['group_id'] : 0;

        $result = $this->db->query("SELECT rights FROM ".DB_PREFIX."userrights WHERE group_id = '".$groupId."' AND module = '".$module."' LIMIT 1");
        $row = $this->db->fetchAssoc($result);

        $bin = decbin($row['rights']);
        $bin = substr("0000",0,4 - strlen($bin)) . $bin;
        if(substr($bin,1,1)==1) {
            return true;
        } else {
            return false;
        }
    }

    public function canEdit($module) {
        if($this->isAdmin()) {
            return true;
        }
        $groupId = isset($_SESSION['group_id']) ? $_SESSION['group_id'] : 0;

        $result = $this->db->query("SELECT rights FROM ".DB_PREFIX."userrights WHERE group_id = '".$groupId."' AND module = '".$module."' LIMIT 1");
        $row = $this->db->fetchAssoc($result);

        $bin = decbin($row['rights']);
        $bin = substr("0000",0,4 - strlen($bin)) . $bin;
        if(substr($bin,2,1)==1) {
            return true;
        } else {
            return false;
        }
    }

    public function canDelete($module) {
        if($this->isAdmin()) {
            return true;
        }
        $groupId = isset($_SESSION['group_id']) ? $_SESSION['group_id'] : 0;

        $result = $this->db->query("SELECT rights FROM ".DB_PREFIX."userrights WHERE group_id = '".$groupId."' AND module = '".$module."' LIMIT 1");
        $row = $this->db->fetchAssoc($result);

        $bin = decbin($row['rights']);
        $bin = substr("0000",0,4 - strlen($bin)) . $bin;
        if(substr($bin,3,1)==1) {
            return true;
        } else {
            return false;
        }
    }
}
?>