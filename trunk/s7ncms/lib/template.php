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

class S7N_Template {
    private $s7n;
    private $template;
    
    public function __construct($name) {
        $this->s7n = S7Ncms::getInstance();
        
        if(defined('ADMINISTRATION')) {
            $this->s7n->cfg['s7ncms']['theme'] = 'admin';
        }
        
        
        if(preg_match("/^[a-zA-Z_\/\-]+$/", $name)) {
            $path = BASE_PATH.'/templates/'.$this->s7n->cfg['s7ncms']['theme'].'/html/'.$name.'.html';
        	if(file_exists($path)) {
        	    $this->template = file_get_contents($path);
        	} else {
        	    $this->template = 'Template '. $name .' not found.';
        	}
        } else {
            $this->template = $name;
        }
        
    }
    
    public function parse($replace=array()) {
        $pagetitle = isset($replace['pagetitle']) ? $replace['pagetitle'] . ' - ': '';
        
        $replace = array_merge($replace,array(
            'imageurl' => $this->s7n->cfg['s7ncms']['imageurl'],
            'pagetitle' => $pagetitle.$this->s7n->cfg['s7ncms']['title'],
            'scripturl' => $this->s7n->cfg['s7ncms']['scripturl'],
            'theme' => $this->s7n->cfg['s7ncms']['theme'],
            //'rewrite' => $this->s7n->cfg['s7ncms']['rewrite'],
            //'module' => $_GET['module'],
            //'page' => $param->get('page'),
            //'number' => $param->get('number'),
            'VERSION' => VERSION
        ));
        
        ob_start();
            extract($replace);
            eval('?>'.$this->template.'<?php ');
            $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
?>