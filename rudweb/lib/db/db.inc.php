<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Database library.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-08 19:01:00
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
 * rw_iDatabase.
 *
 * Methods to be implemented by all database classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwLibDb
 */
interface rw_iDatabase
{
	/**
	 * Initialize database connection.
	 *
	 * @return mixed result.
	 */
	public function dbConnect();

	/**
	 * Close database connection.
	 *
	 * @return mixed result
	 */
	public function dbDisconnect();

	/**
	 * Escape a string for queries.
	 *
	 * @param string $string string to be escaped
	 * @return string $string escaped string
	 */
	public function dbEscapeString($string);

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
	public function dbQuery($sql, $stats);

	/**
	 * Check if there are no tables in database.
	 *
	 * @return mixed result
	 */
	public function dbCheckEmpty();

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
	public function dbSelect($columns, $table, $condition=NULL, $order=NULL, $limit=NULL);

	/**
	 * Method for data insertion.
	 *
	 * @param mixed $table
	 * @param mixed $columns
	 * @param mixed $values
	 * @return mixed query result
	 */
	public function dbInsert($table, $columns=NULL, $values);

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
	public function dbUpdate($table, $data, $condition=NULL, $order=NULL, $limit=NULL);

	/**
	 * Returns the number of rows returned by a query result.
	 *
	 * @param mixed $result The result of the query.
	 * @return integer Number of rows
	 */
	public function dbNumRows($result);

	/**
	 * Returns an array corresponding to a fetched row.
	 *
	 * @param mixed $result The result of the query.
	 * @return array
	 */
	public function dbFetchArray($result);

	/**
	 * Returns a query result.
	 *
	 * @param mixed $result result object
	 * @param int $row row number
	 * @param int $field field number
	 * @return mixed result
	 */
	public function dbFetchResult($result, $row, $field);

	/**
	 * Method for getting the last inserted id.
	 *
	 * @return mixed result
	 */
	public function dbLastInsertId();
}

/**
 * rw_Database_global.
 *
 * Global values and methods for all database classes.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwLibDb
 */
class rw_Database_global
{
	/**
	 * Database host.
	 *
	 * @var mixed host
	 */
	protected $dbHost;

	/**
	 * Database port.
	 *
	 * @var mixed port
	 */
	protected $dbPort;

	/**
	 * Database user.
	 *
	 * @var mixed user
	 */
	protected $dbUser;

	/**
	 * Database password.
	 *
	 * @var mixed password
	 */
	protected $dbPass;

	/**
	 * Database name.
	 *
	 * @var mixed name
	 */
	protected $dbName;

	/**
	 * Database connection.
	 *
	 * @var mixed $_connection connection resource
	 */
	protected $_connection;

	/**
	 * Execution time of last query.
	 *
	 * @var integer $_queryLast last query execution time
	 */
	protected $_queryLast = 0;

	/**
	 * Execution time of all queries.
	 *
	 * @var integer $_queryTime all queries execution time
	 */
	protected $_queryTime  = 0;

	/**
	 * Total queries executed.
	 *
	 * @var integer $_queryCount total number of queries
	 */
	protected $_queryCount = 0;

	/**
	 * Constructor.
	 *
	 * Sets the database parameters.
	 *
	 * @param string $dbHost Database host
	 * @param string $dbPort Database port
	 * @param string $dbUser Database username
	 * @param string $dbPass Database password
	 * @param string $dbName Database name
	 * @return mixed opens the connection or returns an error
	 */
	public function __construct($dbHost, $dbPort, $dbUser, $dbPass, $dbName)
	{
		/**
		 * Set database host.
		 */
		$this->dbHost = $dbHost;
		/**
		 * Set database port.
		 */
		$this->dbPort = $dbPort;
		/**
		 * Set database user.
		 */
		$this->dbUser = $dbUser;
		/**
		 * Set database password.
		 */
		$this->dbPass = $dbPass;
		/**
		 * Set database name.
		 */
		$this->dbName = $dbName;
	}

	/**
	 * Returns last query execution time.
	 *
	 * @return float last query time
	 */
	public function dbQueryLast()
	{
		/**
		 * Return result.
		 */
		return round($this->_queryLast, 5);
	}

	/**
	 * Returns total query execution time.
	 *
	 * @return float total query time
	 */
	public function dbQueryTime()
	{
		/**
		 * Return result.
		 */
		return round($this->_queryTime, 5);
	}

	/**
	 * Returns total number of queries executed.
	 *
	 * @return integer total number of queries
	 */
	public function dbQueryCount()
	{
		/**
		 * Return result.
		 */
		return $this->_queryCount;
	}
}
/**
 * rw_Database_result
 *
 * Common result class for all database classes.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwLibDb
 */
class rw_Database_result
{
	/**
	 * Database object.
	 *
	 * @var mixed $_dbObject database object
	 */
	protected $_dbObject;

	/**
	 * Query result.
	 *
	 * @var mixed $_result result resource
	 */
	protected $_result;

	/**
	 * Constructor.
	 *
	 * @param mixed $_dbObject Database object
	 * @param mixed $_result Query result resource
	 * @return mixed Sets the variables
	 */
	public function __construct($_dbObject, $_result)
	{
		/**
		 * Set database object
		 */
		$this->_dbObject = $_dbObject;
		/**
		 * Set query result.
		 */
		$this->_result = $_result;
	}

	/**
	 * Returns the number of rows returned by a query result.
	 *
	 * @return integer Number of rows
	 */
	public function dbNumRows()
	{
		/**
		 * Return result.
		 */
		return $this->_dbObject->dbNumRows($this->_result);
	}

	/**
	 * Returns an array corresponding to a fetched row.
	 *
	 * @return array
	 */
	public function dbFetchArray()
	{
		/**
		 * Return result.
		 */
		return $this->_dbObject->dbFetchArray($this->_result);
	}

	/**
	 * Returns a query result.
	 *
	 * @param int $row row number
	 * @param int $field field number
	 * @return mixed result
	 */
	public function dbFetchResult($row=0, $field=0)
	{
		/**
		 * Return result.
		 */
		return $this->_dbObject->dbFetchResult($this->_result, $row, $field);
	}
}
?>