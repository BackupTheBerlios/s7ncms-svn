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

try {
    $s7n = S7Ncms::getInstance();
	/*
	 * TODO: Plugins in der Datenbank an-/ausschalten
	 * Load here your Plugins:
	 */
	require('plugins/Mailer.php');
	
	
	$module = $s7n->getRequestedModule();
	if($module === null) {
	    header('Location: '.$s7n->cfg['s7ncms']['scripturl'].$s7n->cfg['s7ncms']['defaultpage']);
	    //exit;
	}
	$type = $s7n->getRequestedPageType($module);
	
	if ($type == 'dynamic') {
	    $class = $s7n->getRequestedClass();
	    if($class == null OR ctype_digit($class)) {
	        $class = $module;
	    }
		/*
		 * TODO: path prüfen und ggf exception werfen
		 */
	    require(BASE_PATH.'/modules/'.$module.'/'.$class.'.php');
		$module = 'S7N_Module_'.ucfirst($class);
		
		$moduleInstance = new $module();		
		
		$moduleInstance->execute();

	} elseif($type == 'static') {
	    $tmp = new S7N_Template('default_content');
	    $s7n->output = $tmp->parse(array('title' => $s7n->page['title'],'content' => $s7n->page['content']));
	} else {
	    throw new S7N_Exception($s7n->_('Page not found'));	    
	}
	
	$s7n->finalize();
} catch(S7N_Exceptionn $e) {
    echo $e;
}

?>