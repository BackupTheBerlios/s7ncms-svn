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
    public $cfg;
    public $db;
    public $param;
    
    /**
     * initializes some instances
     *
     */
    public function __construct() {
        /*
         * TODO: Instanzen einbauen
         * - Parameter vielleicht?! glaub nich... naja, we'll see :o
         * - Datenbank
         * - Konfiguration
         * - Benutzerverwaltung (Zugriffsrechte)
         */
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
    
}
?>