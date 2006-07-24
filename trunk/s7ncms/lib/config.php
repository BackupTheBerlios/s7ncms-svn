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

class S7N_Config {
    private $db;
    
    public function __construct($s7n) {
        $this->db = &$s7n->db;
    }
    
    private function getConfigArray() {
        $config = array();
        $result = $this->db->query("SELECT module,name,value FROM ".DB_PREFIX."config");
		
        while($row = $this->db->fetchAssoc($result)) {
            $config[$row['module']][$row['name']] = $row['value'];
        }
        return $config;
    }
    
    public function getCachedConfig() {
        include_once(BASE_PATH.'/cache/config.php');
        if(isset($cfg)) {
        	return $cfg;
        } else {
            $this->createCachedConfig();
            return $this->getConfigArray();
        }
    }
    
    public function createCachedConfig() {
		$path = BASE_PATH.'/cache/config.php';
        if(file_exists($path)) {
			file_put_contents($path,'<?php $cfg='.var_export($this->getConfigArray(),true).'?>');
			return true;
        } 
        
        // TODO: Notiz im debug schreiben, dass file nicht existiert		
		return false;
    }
}
?>