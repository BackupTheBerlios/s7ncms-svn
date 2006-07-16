<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id$
 * @copyright Eduard Baun, 2006
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);
$startTime = microtime();
require('../config.php');
require('../lib/abstract/admin.php');
define('ADMINISTRATION', true);

try {
    $s7n = S7Ncms::getInstance();

	$module = $s7n->getRequestedModule();
	if($module === null) {
	    /*
	     * TODO: Adminpanel anzeigen lassen
	     */
	    $tpl = new S7N_Template('admin_overview');
	    $s7n->output = $tpl->parse();
	    //header('Location: '.$s7n->cfg['s7ncms']['scripturl'].$s7n->cfg['s7ncms']['defaultpage']);
	    //exit;
	} else {	
		require(BASE_PATH.'/admin/modules/'.$module.'/'.$module.'.php');
		$module = 'S7N_Admin_'.ucfirst($module);
		
		$moduleInstance = new $module();
		$moduleInstance->execute();
	}
	
	/*if ($type == 'dynamic') {
		require(BASE_PATH.'/modules/'.$module.'/'.$module.'.php');
		$module = 'S7N_Module_'.ucfirst($module);
		
		$moduleInstance = new $module();
		$moduleInstance->execute(); 
	} elseif($type == 'static') {
	    $tmp = new S7N_Template('default_content');
	    $s7n->output = $tmp->parse(array('title' => $s7n->page['title'],'text' => $s7n->page['content']));
	} else {
	    throw new S7N_Exception($s7n->_('Page not found'));	    
	}*/
} catch(S7N_Exceptionn $e) {
    echo $e;
}

?>