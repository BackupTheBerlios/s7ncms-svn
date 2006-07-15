<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id$
 * @copyright Eduard Baun, 2006
 */

class S7N_Module_News extends S7N_Module {
    
    public function __construct($s7n) {
        parent::__construct($s7n);
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