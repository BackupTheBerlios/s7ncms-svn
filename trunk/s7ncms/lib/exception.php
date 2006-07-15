<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id$
 * @copyright Eduard Baun, 2006
 */

class S7N_Exception extends Exception {
    /*
     * TODO: default template
     */
    function __toString() {
        echo '<h1>Error</h1>';
        echo '<h2>'.$this->getMessage().'</h2>';
        exit;
    }
}

class FatalException extends S7N_Exception {
    function __toString() {
			echo "<h1>Fatal Error</h1>";
            echo "<h2>{$this->getMessage()}</h2>";
            /*
             * TODO: File und line nur ausgeben, wenn debug = 1
             */			
			echo "<i>{$this->getFile()} ({$this->getLine()})</i>";
            exit; 
    }
}

?>