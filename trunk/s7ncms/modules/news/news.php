<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id: index.php 10 2006-07-14 22:37:26Z edy $
 * @copyright Eduard Baun, 2006
 */

class S7N_Module_News extends S7N_Module {
    public function execute() {
        /*
         * TODO: $this->event auswerten
         */
        $this->output = 'Hallo, ich bin ein News-Modul<br />';
    }
}
?>