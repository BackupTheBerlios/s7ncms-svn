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
require('config.php');
require(BASE_PATH.'/lib/s7ncms.php');
require(BASE_PATH.'/lib/interface/database.php');
require(BASE_PATH.'/lib/mysqli.php');
require(BASE_PATH.'/lib/config.php');
require(BASE_PATH.'/lib/exception.php');
require(BASE_PATH.'/lib/i18n.php');
require(BASE_PATH.'/lib/abstract/module.php');
require(BASE_PATH.'/lib/abstract/plugin.php');


try {
    $s7n = new S7Ncms();

	$module = $s7n->getRequestedModule();
	$type = $s7n->getRequestedPageType($module);
	if ($type == 'dynamic') {
		require(BASE_PATH.'/modules/'.$module.'/'.$module.'.php');
		$module = 'S7N_Module_'.ucfirst($module);
		
		$moduleInstance = new $module($s7n);
		$moduleInstance->execute(); 
	} elseif($type == 'static') {
	    /*
	     * TODO: default_template
	     */
	    echo $s7n->page['title'];
	    echo $s7n->page['content'];
	} else {
	    /*
	     * TODO: exception
	     */
	    throw new S7N_Exception($s7n->_('Page not found'));
	    
	}
} catch(S7N_Exceptionn $e) {
    echo $e;
}

?>