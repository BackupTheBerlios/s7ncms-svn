<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id$
 * @copyright Eduard Baun, 2006
 */

/**
 *  Base Observer class
 */
class S7N_Plugin {
    /**
    * Protected
    * $subject a child of class Observable that we're observing
    */
    protected $subject;
 
    //! A constructor
    /**
    * Constructs the Observer
    * @param $subject the object to observe
    */
    function __construct(&$subject) {
        $this->subject=&$subject;
 
        // Register this object so subject can notify it
        $subject->addModule($this);
    }
 
    //! An accessor
    /**
    * Abstract function implemented by children to repond to
    * to changes in Observable subject
    * @return void
    */    
    function update($state,$string=null) {
        trigger_error ('Update not implemented');
    }
}
?>