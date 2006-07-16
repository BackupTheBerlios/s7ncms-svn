<?php

class S7N_Admin_Sysinfo extends S7N_Admin {
    public function __construct() {
        parent::__construct();
    }
    public function execute() {
        $tpl = new S7N_Template('sysinfo/sysinfo');
        $this->output = $tpl->parse(array('databaseversion' => $this->db->getVersion()));
    }
}

?>