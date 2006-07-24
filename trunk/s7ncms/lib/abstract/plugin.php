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

class S7N_Plugin {
    /**
    * Protected
    * $subject a child of class Observable that we're observing
    */
    protected $subject;
 
    /**
    * Constructs the Plugin
    * @param $subject the object to observe
    * @param $states Array of state to observe
    */
    function __construct(&$subject,$states=array()) {
        $this->subject=$subject;
 
        // Register this object so subject can notify it
        $subject->addPlugin($this,$states);
    }
 
    /**
    * Abstract function implemented by children to repond to
    * to changes in Observable subject
    * @return void
    */    
    function update($state,$string=null) {
        try {
            throw new S7N_Exception('Update not implemented');
        } catch (S7N_Exception $e) {
            echo $e;
        }
    }
}
?>