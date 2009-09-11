<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>MySQL Database library.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-10 18:38:00
 * @access     public
 * @package    rwLibDb
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

/**
 * Security check.
 */
if (!defined('_RW_VALID'))
{
	/**
	 * Display "Not Found" page.
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * rw_Database_mysql
 *
 * Database Class for MySQL
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwLibDb
 */
class rw_Database_mysql extends rw_Database_global implements rw_iDatabase
{
	/**
	 * Constructor.
	 *
	 * Calls parent constructor.
	 *
	 * @param string $dbHost Database host
	 * @param string $dbPort Database port
	 * @param string $dbUser Database username
	 * @param string $dbPass Database password
	 * @param string $dbName Database name
	 * @return mixed result
	 */
	public function __construct($dbHost, $dbPort, $dbUser, $dbPass, $dbName)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($dbHost, $dbPort, $dbUser, $dbPass, $dbName);
	}

	/**
	 * Initialize database connection.
	 *
	 * @return mixed result.
	 */
	public function dbConnect()
	{
		/**
		 * Attempt connection.
		 */
		$_connection = @mysql_connect($this->dbHost.':'.$this->dbPort, $this->dbUser, $this->dbPass);
		/**
		 * Connection error.
		 */
		if(!$_connection)
		{
			/**
			 * Show error message.
			 */
			trigger_error('Database::Could not connect to Database Server.<br />Please check your connection settings.', 256);
		}
		/**
		 * If we can't open database.
		 */
		if(!mysql_select_db($this->dbName, $_connection))
		{
			/**
			 * Show error message.
			 */
			trigger_error('Database::Could not open Database <b>'.$this->dbName.'</b>.<br />Please check that the specified database exists and that you have enough privileges to access it.', 256);
		}
		/**
		 * Set connection.
		 */
		$this->_connection = $_connection;
		/**
		 * Set UTF8 encoding.
		 *
		 * Do not record query.
		 */
		$this->dbQuery("SET NAMES 'utf8'", FALSE);
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Close database connection.
	 *
	 * @return mixed result
	 */
	public function dbDisconnect()
	{
		/**
		 * Return result.
		 */
		return mysql_close($this->_connection);
	}

	/**
	 * Escape a string for queries.
	 *
	 * @param string $string string to be escaped
	 * @return string $string escaped string
	 */
	public function dbEscapeString($string)
	{
		/**
		 * Return result.
		 */
		return mysql_real_escape_string($string, $this->_connection);
	}

	/**
	 * Method for raw queries.
	 *
	 * Executes a query and returns the result.
	 * Counts the time the query took and increments the query counter.
	 *
	 * @param string $sql Query to be executed
	 * @param boolean $stats Whether or not to record query data. Default is TRUE
	 * @return mixed query result
	 */
	public function dbQuery($sql, $stats)
	{
		/**
		 * Record start time if stats enabled.
		 */
		$s = $stats ? microtime(TRUE) : 0;
		/**
		 * Execute query.
		 */
		$result = mysql_query($sql, $this->_connection);
		/**
		 * If query failed...
		 */
		if(!$result)
		{
			/**
			 * Show error message/
			 */
			trigger_error('Database::'.mysql_error().' ('.mysql_errno().')', 256);
		}
		/**
		 * Record end time if stats enabled.
		 */
		$e = $stats ? microtime(TRUE) : 0;
		/**
		 * If stats enabled...
		 */
		if($stats) {
			/**
			 * Record current query time.
			 */
			$this->_queryLast = $e - $s;
			/**
			 * Update total query time.
			 */
			$this->_queryTime = $this->_queryLast + $this->_queryTime;
			/**
			 * Increment query counter.
			 */
			$this->_queryCount++;
		}
		/**
		 * Return result.
		 */
		return new rw_Database_result($this, $result);
	}

	/**
	 * Check if there are no tables in database.
	 *
	 * @return mixed result
	 */
	public function dbCheckEmpty()
	{
		/**
		 * //XXX continue...
		 */
	}

	/**
	 * Method for simple select queries.
	 *
	 * Creates sql query based on input and calls dbQuery.
	 * @param mixed $columns
	 * @param mixed $table
	 * @param mixed $condition
	 * @param mixed $limit
	 * @return mixed query result
	 */
	public function dbSelect($columns, $table, $condition=NULL, $order=NULL, $limit=NULL)
	{
		/**
		 *
		 */
	}

	/**
	 * Method for data insertion.
	 *
	 * @param mixed $table
	 * @param mixed $columns
	 * @param mixed $values
	 * @return mixed query result
	 */
	public function dbInsert($table, $columns=NULL, $values)
	{
		/**
		 *
		 */
	}

	/**
	 * Method for data update.
	 *
	 * @param string $table
	 * @param mixed $data
	 * @param mixed $condition
	 * @param mixed $order
	 * @param mixed $limit
	 * @return mixed result
	 */
	public function dbUpdate($table, $data, $condition=NULL, $order=NULL, $limit=NULL)
	{
		/**
		 *
		 */
	}

	/**
	 * Returns the number of rows returned by a query result.
	 *
	 * @param mixed $result The result of the query.
	 * @return integer Number of rows
	 */
	public function dbNumRows($result)
	{
		/**
		 *
		 */
	}

	/**
	 * Returns an array corresponding to a fetched row.
	 *
	 * @param mixed $result The result of the query.
	 * @return array
	 */
	public function dbFetchArray($result)
	{
		/**
		 *
		 */
	}

	/**
	 * Returns a query result.
	 *
	 * @param mixed $result result object
	 * @param int $row row number
	 * @param int $field field number
	 * @return mixed result
	 */
	public function dbFetchResult($result, $row, $field)
	{
		/**
		 *
		 */
	}

	/**
	 * Method for getting the last inserted id.
	 *
	 * @return mixed result
	 */
	public function dbLastInsertId()
	{
		/**
		 *
		 */
	}
}
?>