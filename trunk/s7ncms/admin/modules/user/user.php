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

class S7N_Admin_User extends S7N_Admin {
    public function __construct() {
        parent::__construct();
        /*
         * TODO: anders lösen
         */
        $this->cfg['s7ncms']['imageurl'] = '../'.$this->cfg['s7ncms']['imageurl'];
    }
    
    public function execute() {
        $this->output = $this->getUserList();
    }
    
    private function getUserList() {
        $list = '<h1>Benutzerverwaltung</h1><table style="width: 100%;" border="0" cellpadding="3"><thead><tr style="font-weight: bold;"><th>User</th><th>Gruppe</th><th>Status</th><th>Aktion</th></tr></thead>';
        $sql = "
        SELECT
            users.id,
            users.loginname,
            users.isLocked,
            users.isAdmin,
            groups.name AS groupname
        FROM ".DB_PREFIX."users AS users

        LEFT JOIN ".DB_PREFIX."usergroups AS groups
        ON users.group_id = groups.id

        GROUP BY users.id

        ORDER BY
            isAdmin DESC,
            loginname ASC
        ";
        $result = $this->db->query($sql);
        while ($row = $this->db->fetchAssoc($result)) {
            $locked = ($row['isLocked'] == 1) ? true : false;
            $link = $locked ? '<a href="'.$this->cfg['s7ncms']['scripturl'].'user&admin=true&action=changestatus&number='.$row['id'].'">'.'<img src="'.$this->cfg['s7ncms']['imageurl'].'/deactivate.png" alt="Deaktiviert" title="Deaktiviert" border="0" /></a>' : '<a href="'.$this->cfg['s7ncms']['scripturl'].'user&admin=true&action=changestatus&number='.$row['id'].'">'.'<img src="'.$this->cfg['s7ncms']['imageurl'].'/activate.png" alt="Aktiviert" title="Aktiviert" border="0" /></a>';

            if($row['isAdmin'] == 1) {
                $list .= '<tr><td><span title="Administrator" style="color: red;">'.$row['loginname'].'</span></td>';
                $list .= '<td>'.$row['groupname'].'</td>';
                $list .= '<td>'.$link.'</td>';
                $list .= '<td><img src="'.$this->cfg['s7ncms']['imageurl'].'/edit.png" alt="Edit User" title="Edit User" border="0" /><img src="'.$this->cfg['s7ncms']['imageurl'].'/delete.png" alt="Delete User" title="Delete User" border="0" /></td></tr>';
            } else {
                $list .= '<tr><td>'.$row['loginname'].'</td>';
                $list .= '<td>'.$row['groupname'].'</td>';
                $list .= '<td>'.$link.'</td>';
                $list .= '<td><img src="'.$this->cfg['s7ncms']['imageurl'].'/edit.png" alt="Edit User" title="Edit User" border="0" /><img src="'.$this->cfg['s7ncms']['imageurl'].'/delete.png" alt="Delete User" title="Delete User" border="0" /></td></tr>';

            }
        }

        $list .= '</table>';
        return $list;
    }
}
?>