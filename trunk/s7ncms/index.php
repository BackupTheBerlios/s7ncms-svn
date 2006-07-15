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

require('config.php');
require('lib/s7ncms.php');
require('lib/interface/database.php');
require('lib/mysqli.php');
require('lib/exception.php');
require('lib/abstract/module.php');
require('lib/abstract/plugin.php');

$s7n = new S7Ncms();
$module = $s7n->getRequestedModule();
require('modules/'.$module.'/'.$module.'.php');
$module = 'S7N_Module_'.ucfirst($module);

$moduleInstance = new $module($s7n);
$moduleInstance->execute();


?>