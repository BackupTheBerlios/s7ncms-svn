<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id$
 * @copyright Eduard Baun, 2006
 */

/*
 * TODO: Datei umbenennen, damit man beim installieren neuerer versionen
 * die config nicht überschreibt
 */

/**
 * Host or IP
 * @const DB_SERVER Host or IP
 */
define('DB_SERVER','localhost'); // IP oder Host des MySQL-Serves

/**
 * Username
 * @const DB_USERNAME Username
 */
define('DB_USERNAME','edy');

/**
 * Password
 * @const DB_PASSWORD Password
 */
define('DB_PASSWORD','edy');

/**
 * Database
 * @const DB_DATABASE Database
 */
define('DB_DATABASE','s7ncmsdev');

/**
 * Prefix for tablenames
 * @const DB_PREFIX Prefix
 */
define('DB_PREFIX', 's7ncmsdev_');

/*
 * MySQL Extension
 * Possible values: 'mysql' and 'mysqli'
 * @const MYSQL_EXT MySQL Extension
 */
define('MYSQL_EXT', 'mysqli');

/**
 * Default Module to load if none selected
 * @const DEFAULT_MODULE Default Module
 */
define('DEFAULT_MODULE', 'news');

/**
 * Here you can choose your language file
 * @const LANGUAGE Language
 */
define('LANGUAGE', 'german');

/*
 * **************  Ab hier nichts verändern  ******************
 */

/**
 * Base PATH to the Script
 * 
 * @const BASE_PATH Absolute PATH to S7Ncms
 */
define('BASE_PATH',dirname(__FILE__));

require(BASE_PATH.'/lib/s7ncms.php');
require(BASE_PATH.'/lib/interface/database.php');
require(BASE_PATH.'/lib/mysqli.php');
require(BASE_PATH.'/lib/config.php');
require(BASE_PATH.'/lib/exception.php');
require(BASE_PATH.'/lib/i18n.php');
require(BASE_PATH.'/lib/template.php');
require(BASE_PATH.'/lib/access.php');
require(BASE_PATH.'/lib/abstract/module.php');
require(BASE_PATH.'/lib/abstract/plugin.php');

// Session-Name festlegen
session_name('S7N');
// Cookie soll laaaaaange bestehen bleiben, denn wir wollen ja nicht ausgeloggt werden
session_set_cookie_params(5 * 365 * 24 * 60 * 60,'/');
// und abgehts
session_start();


/**
 * Loads automatically requested Classes
 *
 * @param string $class Classname
 */
/*function __autoload($class) {
    $path = BASE_PATH.'/lib/'.substr($class,4).'.php';
    if(file_exists($path)) {
        require_once($path);
    } else {
        die("Class <i>$class</i> not found. ($path)");
    }
}*/
?>
