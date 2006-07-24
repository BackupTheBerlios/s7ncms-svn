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

ini_set('display_errors', 1);
error_reporting(E_ALL);
$startTime = microtime();
require('../config.php');
require('../lib/abstract/admin.php');
define('ADMINISTRATION', true);


try {
    $s7n = S7Ncms::getInstance();
	if(true or $s7n->user->isAdmin()) {	
		$module = $s7n->getRequestedModule();
		
		if($module === null) {
		    $tpl = new S7N_Template('admin_overview');
		    $s7n->output = $tpl->parse();
		    //header('Location: '.$s7n->cfg['s7ncms']['scripturl'].$s7n->cfg['s7ncms']['defaultpage']);
		    //exit;
		} else {	
			$class = $s7n->getRequestedClass();
	    	$className = 'S7N_Admin_'.ucfirst($module).'_'.ucfirst($class);
			if($class == null OR ctype_digit($class)) {
	        	$class = $module;
	        	$className = 'S7N_Admin_'.ucfirst($module);
	    	}
		    $path = BASE_PATH.'/admin/modules/'.$module.'/'.$class.'.php';
			if(file_exists($path)) {
		    	require($path);
				echo $className;
		    	$moduleInstance = new $className();
				$moduleInstance->execute();
			} else {
			    throw new S7N_Exception($s7n->_('Module not found: ').$path);
			}
		}
	} else {
	    throw new S7N_Exception($s7n->_('Get out of here!'));
	}
	$s7n->finalize();
} catch(S7N_Exception $e) {
    echo $e;
}

?>