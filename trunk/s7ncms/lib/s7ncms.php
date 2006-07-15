<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id$
 * @copyright Eduard Baun, 2006
 */

class S7Ncms {
    private static $instance = null;
    public $cfg;
    public $db;
    public $output;
    public $page;
    private $i18n;
    public $translation;
    
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
        $this->translation = & $this->i18n->getTranslation();
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new S7Ncms();
        }
        return self::$instance;
    }
    
    /**
     * Prints out the generated output
     *
     */
    public function __destruct() {
        /*
         * TODO: Hier kommt die Ausgabe rein
         * $template = new Template('main');
         * echo $template->parse(array(
         *     'title' => $this->cfg->get('s7ncms','title'),
         *     'content' => $this->output
         * ));
         */
        echo $this->output;
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
    
}
?>