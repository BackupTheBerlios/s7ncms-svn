<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id: s7ncms.php 10 2006-07-14 22:37:26Z edy $
 * @copyright Eduard Baun, 2006
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
			if(!$this->dbh) {
				throw new FatalException(mysqli_connect_error());
	        }
			if (!mysql_select_db($database,$this->dbh)) {
				throw new FatalException(mysql_error($this->dbh));
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
		    $result = $this->dbh->query($sql);
		    if(!$result) {
				throw new DatabaseException($this->dbh->error);
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
}
?>