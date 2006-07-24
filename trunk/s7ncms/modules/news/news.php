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

class S7N_Module_News extends S7N_Module {
    
    public function __construct() {
        parent::__construct();
        $this->moduleInfo = array(
        	'modulename' => 'News',
        	'description' => 'Simple News module',
        	'author' => 'Eduard Baun',
        	'email' => 'edy@edy-b.de',
        	'url' => 'http://www.s7n.de',
        	'version' => '1.0',
        );
        
    }
    
    public function execute() {
        /*
         * TODO: $this->event auswerten
         */
        $this->output = $this->s7n->_('Hi, this is the simple news module').'<br />';
    }    
    
}
?>