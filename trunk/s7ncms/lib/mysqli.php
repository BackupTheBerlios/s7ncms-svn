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

class S7N_Database_MySQLi {
    /**
     * MySQLi link identifier
     *
     * @var link identifier
     */
    private $dbh;
    
    /**
     * Initializes the database
     *
     * @param string $server
     * @param string $user
     * @param string $password
     * @param string $database
     */
    public function __construct($server,$user,$password,$database) {
		try {
		    $this->dbh = new mysqli($server,$user,$password,$database);
			if(mysqli_connect_errno()) {
				throw new FatalException(mysqli_connect_error());
	        }
		} catch (FatalException $e) {
		    echo $e;
		}
    }
    
    /**
     * Send a query to database
     *
     * @param string query
     */
    public function query($query) {
		try {
		    $result = $this->dbh->query($query);
		    if(!$result) {
				throw new S7N_Exception($this->dbh->error);
			}
		} catch (DatabaseException $e) {
		    echo $e;
		}
		return $result;
    }
    
    /**
     * Send multimpe query to database which are concatenated by a semicolon
     *
     * @param string query
     */
    public function multipleQuery($query) {}
    
    /**
     * Affected Rows in the last query
     *
     * @return int
     */
    public function affectedRows() {
        return $this->dbh->affected_rows;
    }
    
    /**
     * Last inserted ID of the last query
     * 
     * @return int
     */
    public function lastInsertId() {
        return $this->dbh->insert_id;
    }
    
    /**
     * Escapes special characters in a string for use in a SQL statement
     *
     * @param string $string as a reference
     * @return string
     */
    public function escapeString(&$string) {
        return $this->dbh->real_escape_string($string);
    }
    
    /**
     * Fetch a result row as an associative array
     *
     * @param resource $result
     * @return array
     */
    public function fetchAssoc($result) {
        return $result->fetch_assoc();
    }
    
    public function getVersion() {
        return 'MySQLi '.$this->dbh->server_info;
    }
}
?>