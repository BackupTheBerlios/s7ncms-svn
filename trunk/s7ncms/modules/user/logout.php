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

class S7N_Module_Logout extends S7N_Module {
    public function execute() {
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        session_destroy();
        header('Location: '.$this->cfg['s7ncms']['scripturl'].$this->cfg['s7ncms']['defaultpage']);
        exit;
    }
}
?>