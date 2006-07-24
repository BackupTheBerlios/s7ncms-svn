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

class S7N_Admin_Pages extends S7N_Admin {
    public function __construct() {
        parent::__construct();
    }
    public function execute() {
        $this->output = $this->getOverview();
    }
    
    private function getOverview() {
        $output = "<h1>".$this->s7n->_('Statische Seiten')."</h1>";
        $sql = "SELECT
            id,
            name,
            title,
            DATE_FORMAT(lastUpdate,'%d.%m.%Y, %H:%i') AS lastUpdate
            
        FROM ".DB_PREFIX."pages
        WHERE type = 'static'
        ORDER BY name ASC";
        
        /*
         * Das ist Murks! Templates müssen her! Raus mit HTML!
         */
        $result = $this->db->query($sql);
        $output .= '<a href="'.$this->cfg['s7ncms']['scripturl'].'admin/pages/new">create new</a><hr>';
        $output .= '<table style="width: 100%;" border="0" cellpadding="3"><thead><tr style="font-weight: bold;"><th>Name</th><th>Zuletzt bearbeitet</th><th>Aktion</th></tr></thead>';
        while($row = $this->db->fetchAssoc($result)) {
            $output .= '<tr>';
            $output .= '<td><a href="'.$this->cfg['s7ncms']['scripturl'].$row['name'].'">'.$row['title'].'</a></td>';
            $output .= '<td>'.$row['lastUpdate'].'</td>';
            $output .= '<td>(<a href="'.$this->cfg['s7ncms']['scripturl'].'admin/pages/edit?id='.$row['id'].'">edit</a>, <a href="'.$this->cfg['s7ncms']['scripturl'].'admin/pages/delete?id='.$row['id'].'">delete</a>)</td>';
            $output .= '</tr>';
        }
        $output .= '</table>';
        return $output;
    }
    
}

?>