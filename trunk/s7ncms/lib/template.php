<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id$
 * @copyright Eduard Baun, 2006
 */

class S7N_Template {
    private $s7n;
    private $template;
    
    public function __construct($name) {
        $this->s7n = & S7Ncms::getInstance();
        
        if(defined('ADMINISTRATION')) {
            $this->s7n->cfg['s7ncms']['theme'] = 'admin';
        }
        
        $path = BASE_PATH.'/templates/'.$this->s7n->cfg['s7ncms']['theme'].'/html/'.$name.'.html';
        
        if(preg_match("/^\S+$/", $name) AND file_exists($path)) {
            $this->template = file_get_contents($path);
        } else {
            $this->template = $name;
        } 
    }
    
    public function parse($replace=array()) {
        $pagetitle = isset($replace['pagetitle']) ? $replace['pagetitle'] . ' - ': '';
        if(defined('ADMINISTRATION')) {
            $this->s7n->cfg['s7ncms']['imageurl'] = '../'.$this->s7n->cfg['s7ncms']['imageurl'];
        }
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