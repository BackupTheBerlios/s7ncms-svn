<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id$
 * @copyright Eduard Baun, 2006
 */

/**
 *  Base Observerable class
 */
class S7N_Module {
    /**
    * Private
    * $observers an array of Observer objects to notify
    */
    private $observers = array(); 
    
    protected $db;
    protected $title;
    protected $access;
    protected $error = array();
    protected $localization;
    protected $cfg;
    protected $output;
    protected $event;
    
    //! A constructor
    /**
    * Constructs the Observerable object
    */
    public function __construct($s7n) {
        $this->db = &$s7n->db;
        $this->cfg = &$s7n->cfg;
        $this->output = &$s7n->output;
        $this->event = $s7n->getRequestedEvent();
        
    }
 
    //! An accessor
    /**
    * Calls the update() function using the reference to each
    * registered observer - used by children of Observable
    * @return void
    */ 
    public function notifyObservers($state,&$string=null) {
    	$observers=count($this->observers);
        for ($i=0;$i<$observers;$i++) {
            $this->observers[$i]->update($state,$string);
        }
    }
 
    //! An accessor
    /**
    * Register the reference to an object
    * @return void
    */ 
    function addModule (&$observer) {
        $this->observers[]=&$observer;
    }
 
    
    /*public static function isValidModule($module) {
        return (is_object($module) AND $module instanceof S7N_Module);
    }*/

    public function execute($event,$id=null) { }

    public function getContent() { return $this->content; }
	public function getTitle() { return $this->title; }
}

class ModuleException extends Exception {
    function __toString() {
        $main = new S7N_Template('main');
        $content = new S7N_Template('default_content');
        echo $main->parse(array('content' => $content->parse(array('title' => "Error", 'text' => $this->getMessage())) ));
        exit;
    }
}

?>