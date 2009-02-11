<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Database classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      0008-12-03 18:31:00
 * @access     public
 * @package    RudWEb
 * @subpackage Database
 * @todo       stuff
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
 * Prevent direct file access
 */
if(!defined('_RW_VALID')) {require_once('./index.php'); exit;}

/**
 * rw_iDB
 *
 * Methods to be implemented by all database classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Core
 */
interface rw_iDB
{
	/**
	 * Constructor interface
	 *
	 * Initializes the database connection
	 *
	 * @param string $dbHost Database host
	 * @param string $dbPort Database port
	 * @param string $dbUser Database username
	 * @param string $dbPass Database password
	 * @param string $dbName Database name
	 * @return mixed opens the connection or returns an error
	 */
	function __construct($dbHost, $dbPort, $dbUser, $dbPass, $dbName);
	/**
	 * Method for raw queries
	 *
	 * Executes a query and returns the result.
	 * Counts the time the query took and increments the query counter.
	 *
	 * @param string $sql Query to be executed
	 * @return mixed query result
	 */
	function dbQuery($sql);
	/**
	 * Method for simple select queries
	 * Creates sql query based on input and calls dbQuery
	 * @param mixed $columns
	 * @param mixed $table
	 * @param mixed $condition
	 * @param mixed $limit
	 * @return mixed query result
	 */
	function dbQuerySimpleSelect($columns, $table, $condition, $limit=NULL);
	/**
	 * Escape a string for queries
	 * @param string $string string to be escaped
	 * @return string $string escaped string
	 */
	function dbEscapeString($string);
	/**
	 * Method for closing database connection
	 *
	 * @return mixed result of connection closing
	 */
	function dbClose();
	/**
	 * Returns an array corresponding to a fetched row.
	 *
	 * @param mixed $result The result of the query.
	 * @return array
	 */
	function dbFetchArray($result);
	/**
	 * Test
	 */
	function dbFetchResult($result, $row, $field);
	/**
	 * Returns the number of rows returned by a query result
	 *
	 * @param mixed $result The result of the query.
	 * @return integer Number of rows
	 */
	function dbNumRows($result);
}
/**
 * rw_DB_global
 *
 * Global values and methods for all database classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Core
 */
class rw_DB_global
{
	/**
	 * Database connection
	 *
	 * @var mixed $_connection connection resource
	 */
	protected $_connection;
	/**
	 * Execution time of last query
	 *
	 * @var integer $_queryLast last query execution time
	 */
	protected $_queryLast = 0;
	/**
	 * Execution time of all queries
	 *
	 * @var integer $_queryTime all queries execution time
	 */
	protected $_queryTime  = 0;
	/**
	 * Total queries executed
	 *
	 * @var integer $_queryCount total number of queries
	 */
	protected $_queryCount = 0;
	/**
	 * Returns last query execution time
	 *
	 * @return float last query time
	 */
	function dbQueryLast()
	{
		return round($this->_queryLast, 5);
	}
	/**
	 * Returns total query execution time
	 *
	 * @return float total query time
	 */
	function dbQueryTime()
	{
		return round($this->_queryTime, 5);
	}
	/**
	 * Returns total number of queries executed
	 *
	 * @return integer total number of queries
	 */
	function dbQueryCount()
	{
		return $this->_queryCount;
	}
}
/**
 * rw_DB_result
 *
 * Common result class for all database classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Core
 */
class rw_DB_result
{
	/**
	 * Database object
	 *
	 * @var mixed $_dbObject database object
	 */
	protected $_dbObject;
	/**
	 * Query result
	 * @var mixed $_result result resource
	 */
	protected $_result;
	/**
	 * Constructor
	 *
	 * @param mixed $_dbObject Database object
	 * @param mixed $_result Query result resource
	 * @return mixed Sets the variables
	 */
	function __construct($_dbObject, $_result)
	{
		$this->_dbObject = $_dbObject;
		$this->_result = $_result;
	}
	/**
	 * Returns an array corresponding to a fetched row.
	 *
	 * @return array
	 */
	function dbFetchArray()
	{
		return $this->_dbObject->dbFetchArray($this->_result);
	}
	/**
	 * Test
	 */
	function dbFetchResult($row=0, $field=0)
	{
		return $this->_dbObject->dbFetchResult($this->_result, $row, $field);
	}
	/**
	 * Returns the number of rows returned by a query result
	 *
	 * @return integer Number of rows
	 */
	function dbNumRows()
	{
		return $this->_dbObject->dbNumRows($this->_result);
	}
}
/**
 * rw_DB
 *
 * Database type switcher
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Core
 */
class rw_DB
{
	/**
	 * Connect and open database _THIS_IS_DEPREACTED_NOT_USED_ANYMORE
	 *
	 * This is where the acutal connection is initiated
	 *
	 * @param string $dbType Database type
	 * @param string $dbHost Database host
	 * @param string $dbPort Database port
	 * @param string $dbUser Database username
	 * @param string $dbPass Database password
	 * @param string $dbName Database name
	 * @return mixed opens the connection or returns an error
	 */
	static function _connect()
	{
		/**
		 * Allowed database types
		 */
		if(in_array(_APP_DB_TYPE, array('mysql', 'postgresql')))
		{
			/**
			 * Required database class name
			 */
			$dbClass = 'rw_DB_'._APP_DB_TYPE;
			/**
			 * Include database class
			 */
			require_once(_RW_DIR_LIB_DB.'db.'._APP_DB_TYPE.'.inc.php');
			return new $dbClass(_APP_DB_HOST, _APP_DB_PORT, _APP_DB_USER, _APP_DB_PASS, _APP_DB_NAME);
		}
	}
}
?>