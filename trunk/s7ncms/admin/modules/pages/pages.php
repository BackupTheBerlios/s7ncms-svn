<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id$
 * @copyright Eduard Baun, 2006
 */

class S7N_Admin_Pages extends S7N_Admin {
    public function __construct() {
        parent::__construct();
    }
    public function execute() {
        $tpl = new S7N_Template('sysinfo/sysinfo');
        $this->output = $tpl->parse(array('databaseversion' => $this->db->getVersion()));
    }
}

?>