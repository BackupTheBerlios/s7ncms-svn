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
 * Database Interface
 */
interface S7N_Interface_Database {
    /**
     * Send a query to database
     * 
     * @param string query
     */
    public function query($query);
    
    /**
     * Send multimpe query to database which are concatenated by a semicolon
     *
     * @param string query
     */
    public function multipleQuery($query);
    
    /**
     * Affected Rows in the last query
     *
     */
    public function affectedRows();
    
    /**
     * Last inserted ID of the last query
     *
     */
    public function lastInsertId();
    
    /**
     * Escapes special characters in a string for use in a SQL statement
     *
     * @param string $string as a reference
     */
    public function escapeString(&$string);
    
    /**
     * Fetch a result row as an associative array
     *
     * @param resource $result
     */
    public function fetchAssoc($result);
    
    public function getVersion();
}

?>