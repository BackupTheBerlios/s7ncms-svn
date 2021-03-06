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

class S7Ncms {
    private $plugins = array(); 
    
    private static $instance = null;
    public $cfg;
    public $db;
    public $output;
    public $page;
    private $i18n;
    public $translation;
    public $user;
    
    
    /**
     * initializes some instances
     *
     */
    private function __construct() {
        /*
         * TODO: Instanzen einbauen
         * - Parameter vielleicht?! glaub nich... naja, we'll see :o
         * - Konfiguration
         * - Benutzerverwaltung (Zugriffsrechte)
         */
        $this->db = new S7N_Database_MySQLi(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        $config = new S7N_Config($this);
        $this->cfg = $config->getCachedConfig();
        $this->i18n = new S7N_I18n();
        $this->translation = $this->i18n->getTranslation();
        $this->user = new S7N_Access();
        define('VERSION', '0.4');
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new S7Ncms();
        }
        return self::$instance;
    }

    //! An accessor
    /**
    * Calls the update() function using the reference to each
    * registered plugin - used by children of Observable
    * @return void
    */ 
    public function notifyPlugins($state,&$string=null) {
    	if(array_key_exists($state,$this->plugins)){
            foreach ($this->plugins[$state] as $plugin) {
                $plugin->update($state,$string);
            }
        }
    }
 
    //! An accessor
    /**
    * Register the reference to an object
    * @return void
    */ 
    function addPlugin (&$plugin,$states) {
        foreach($states as $state) {
            $this->plugins[$state][] = $plugin;
        }
    }    
    
    /**
     * Prints out the generated output
     *
     */
    public function finalize() {
        if(!defined('FATAL_ERRORX')){
	        $main = new S7N_Template('main');
	        
	        echo $main->parse(array(
	        	'content' => $this->output
	        ));
    	}
        
        global $startTime;
        echo '<!--'. (microtime() - $startTime) . 'sec at all-->';
    }
    
    /**
     * gets the module
     *
     * @return mixed Modulname or null if none given
     */
    public function getRequestedModule() {
        if (    array_key_exists('module',$_GET)
            AND preg_match("/^([a-zA-Z]+)$/",$_GET['module'],$match)) {
    		return strtolower($match[1]);
        }
        return null;
    }
    
    /**
     * gets the class
     *
     * @return mixed null if none set; int if number (you can use it as id); string if class set
     */
    public function getRequestedClass() {
    	if (    array_key_exists('class',$_GET)
    	    AND ctype_digit($_GET['class'])) {
			return $_GET['class'];
		} elseif (array_key_exists('class',$_GET)
			AND preg_match("/^([a-zA-Z]+)$/",$_GET['class'],$match)) {
		    return strtolower($match[1]);
		} else {
		    return null;
		}
    }
    
    /**
     * gets the event
     *
     * @return mixed null if no event set otherwise the requested event
     */
    public function getRequestedEvent() {
    	if (    array_key_exists('event',$_GET)
    		AND preg_match("/^([a-zA-Z]+)$/",$_GET['event'],$match)) {
			return strtolower($match[1]);
		} else {
			return null;
		}        
    }
    
    public function getRequestedPageType($page) {
        $result = $this->db->query("SELECT id, name, content, title, type FROM ".DB_PREFIX."pages WHERE name = '".$page."' AND isEnabled = 1 LIMIT 1");
        if($this->db->affectedRows()) {
            $row = $this->db->fetchAssoc($result);
            $this->page = array(
                'id' => $row['id'],
                'name' => $row['name'],
            	'title' => $row['title'],
            	'content' => $row['content']);
            return $row['type'];
        }
        return null;
    }
    
    public function _($string,$param1=null) {
        return $this->i18n->_($string,$param1);
    }
    
    public function createSefString ($string) {
		$search =  array(' ', "\xc3\xa4", "\xc3\x84", "\xc3\xb6", "\xc3\x96", "\xc3\xbc", "\xc3\x9c", "\xc3\x9f", "\xe4", "\xc4", "\xf6", "\xd6", "\xfc", "\xdc", "\xdf");
		$replace = array('-', 'ae',       'Ae',       'oe',       'Oe',       'ue',       'Ue' ,      'ss',       'ae',   'Ae',   'oe',   'Oe',   'ue',   'Ue' ,  'ss');
        $string = str_replace($search, $replace, $string);
		$string = preg_replace('/[^A-Za-z0-9_\-]/', '', $string);
        $string = urldecode($string);
		$string = strtolower($string);
        return $string;
	}
    
}
?>