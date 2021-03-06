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

class S7N_Module {
    
    protected $db;
    protected $title;
    protected $access;
    protected $error = array();
    protected $translation;
    protected $cfg;
    protected $output;
    protected $event;
    protected $moduleInfo = array();
    protected $s7n;
    protected $user;
    
    public function __construct() {
        $this->s7n = S7Ncms::getInstance();
        $this->db = &$this->s7n->db;
        $this->cfg = &$this->s7n->cfg;
        $this->output = &$this->s7n->output;
        $this->event = $this->s7n->getRequestedEvent();
        $this->user = & $this->s7n->user;
        
    }
    
    /*public static function isValidModule($module) {
        return (is_object($module) AND $module instanceof S7N_Module);
    }*/

    public function execute($event,$id=null) { }

    public function getContent() { return $this->content; }
	public function getTitle() { return $this->title; }
	public function getModuleInfo() { return $this->moduleInfo; }
}

class ModuleException extends Exception {
    function __toString() {
        $main = new S7N_Template('main');
        $content = new S7N_Template('default_content');
        echo $main->parse(array('content' => $content->parse(array('title' => "Error", 'content' => $this->getMessage())) ));
        exit;
    }
}

?>