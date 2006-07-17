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
	if($s7n->user->isAdmin()) {	
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
			$path = BASE_PATH.'/admin/modules/'.$module.'/'.$module.'.php';
			if(file_exists($path)) {
		    	require($path);
				$module = 'S7N_Admin_'.ucfirst($module);
				
				$moduleInstance = new $module();
				$moduleInstance->execute();
			} else {
			    throw new S7N_Exception($s7n->_('Module not found'));
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