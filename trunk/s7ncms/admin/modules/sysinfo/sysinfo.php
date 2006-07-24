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