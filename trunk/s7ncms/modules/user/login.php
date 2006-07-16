<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id$
 * @copyright Eduard Baun, 2006
 */

class S7N_Module_Login extends S7N_Module {
    public function execute() {
        if($_SERVER["REQUEST_METHOD"] == 'POST' AND $this->event == 'login') {
		    if($this->loginUser()) {
		        /*
		         * TODO: header oder eine tolle weiterleitungsseite
		         */
		        $this->output = 'Alles klärchen. Bist ingeloggt <3';
		    }
		} else {
		    $this->output = $this->getLoginForm();
		}
    }
    
    public function getLoginForm() {
        $tpl = new S7N_Template('user/login_form');
        return $tpl->parse();
    }
    
    public function loginUser() {
        $username = htmlentities($_POST['username']);
        $password = $_POST['password'];

        try {
            $result = $this->db->query("SELECT id, group_id, isAdmin, loginname, password, email, homepage FROM "
	        .DB_PREFIX."users WHERE loginname = '".$this->db->escapeString($username)."' AND isLocked=0 LIMIT 1");
	
	        $row = $this->db->fetchAssoc($result);	        
	        if ($this->db->affectedRows() > 0) {
	            if (md5($password) == $row['password']) {
	                $_SESSION['loggedin'] = true;
	                $_SESSION['loginname'] = $row['loginname'];
	                $_SESSION['id'] = $row['id'];
	                $_SESSION['group_id'] = $row['group_id'];
	                $_SESSION['isAdmin'] = $row['isAdmin'] == 1 ? true : false;
	                $_SESSION['email'] = $row['email'];
	                $_SESSION['homepage'] = $row['homepage'];
	                return true;
	            } else {
	                throw new S7N_Exception($this->s7n->_('Wrong username/password'));
	            }
	
	        } else {
	            throw new S7N_Exception($this->s7n->_('Wrong username/password'));
	        }
        } catch (S7N_Exception $e) {
            echo $e;
        }
    }
}
?>