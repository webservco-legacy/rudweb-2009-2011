<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>MySQL database class
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2008-12-03 19:04:00
 * @access     public
 * @package    rwDb
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
 * rw_DB_mysql
 *
 * Database Class for MySQL
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwDb
 */
class rw_DB_mysql extends rw_DB_global implements rw_iDB
{
	/**
	 * Constructor
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
	function __construct($dbHost, $dbPort, $dbUser, $dbPass, $dbName)
	{
		$link = @mysql_connect($dbHost.':'.$dbPort, $dbUser, $dbPass);
		if(!$link)
		{
			trigger_error('<u>Database Error</u>: Could not connect to Database Server.<br />Please check your connection settings.');
		}
		if(!mysql_select_db($dbName, $link))
		{
			trigger_error('<u>Database Error</u>: Could not open Database <b>'.$dbName.'</b>.<br />Please check that the specified database exists and that you have enough privileges to access it.');
		}
		$this->_connection = $link;
		$this->dbQuery("SET NAMES 'utf8'", FALSE);
	}
	/**
	 * Method for raw queries
	 *
	 * Executes a query and returns the result.
	 * Counts the time the query took and increments the query counter.
	 *
	 * @param string $sql Query to be executed
	 * @param boolean $a Whether or not to record query data. Default is TRUE
	 * @return mixed query result
	 */
	function dbQuery($sql, $stats=TRUE)
	{
		$s = $stats ? microtime(TRUE) : 0;
		$result = mysql_query($sql, $this->_connection);
		if(!$result)
		{
			trigger_error('<u>Database Error</u>: '.mysql_error().' ('.mysql_errno().')');
		}
		$e = $stats ? microtime(TRUE) : 0;

		if($stats) {
			$this->_queryLast = $e - $s;
			$this->_queryTime = $this->_queryLast + $this->_queryTime;
			$this->_queryCount++;
		}
		return new rw_DB_result($this, $result);
	}
	/**
	 * Method for simple select queries
	 * Creates sql query based on input and calls dbQuery
	 * @param mixed $columns
	 * @param mixed $table
	 * @param mixed $condition
	 * @param mixed $limit
	 * @return mixed query result
	 */
	function dbSelect($columns, $table, $condition=NULL, $order=NULL, $limit=NULL, $x=0)
	{
		$limit = (isset($limit) && $limit != '') ? ' LIMIT '.$limit : '';
		if($order)
		{
			$ord = ' ORDER BY ';
			if(is_array($order))
			{
				$ord .= implode(', ', $order);
			}
			else
			{
				$ord .= $order;
			}
		}
		else
		{
			$ord = '';
		}
		if($condition)
		{
			$cond = ' WHERE ';
			if(is_array($condition))
			{
				$cond .= implode(' AND ', $condition);
			}
			else
			{
				$cond .= $condition;
			}
		}
		else
		{
			$cond = '';
		}
		if(is_array($columns))
		{
			$columns = implode(', ', $columns);
		}
		$sql = "SELECT {$columns} FROM {$table}{$cond}{$ord}{$limit}";
		if($x==1){trigger_error('<u>Database Debug</u>: '.$sql);}
		return $this->dbQuery($sql);
	}
	function dbInsert($table, $columns=NULL, $data)
	{
		if($columns)
		{
			$cols = '(';
			if(is_array($columns))
			{
				$cols .= implode(', ', $columns);
			}
			else
			{
				$cols .= $columns;
			}
			$cols .= ')';
		}
		else
		{
			$cols = '';
		}
		if(is_array($data))
		{
			/*
			 $values = array();
			 foreach($values as $value)
			 {
				$val[] = "'".$value."'";
				}
				$data = implode(', ', $val);
				*/
			$col = array();
			$val = array();
			foreach($data as $column => $value)
			{
				$col[] = $column;
				$val[] = "'".$value."'";
			}
			$cols = '(';
			$cols .= implode(', ', $col);
			$cols .= ')';
			$data  = implode(', ', $val);
		}
		$sql = "INSERT INTO {$table}{$cols} VALUES($data)";
		return $this->dbQuery($sql);
	}
	public function dbLastInsertId()
	{
		$sql = "SELECT LAST_INSERT_ID()";
		return $this->dbQuery($sql);
	}
	/**
	 * Method for data update
	 *
	 * @param string $table
	 * @param mixed $data
	 * @param mixed $condition
	 * @param mixed $order
	 * @param mixed $limit
	 * @return mixed result
	 */
	public function dbUpdate($table, $data, $condition=NULL, $order=NULL, $limit=NULL, $x=0)
	{
		$limit = (isset($limit) && $limit != '') ? ' LIMIT '.$limit : '';
		if($order)
		{
			$ord = ' ORDER BY ';
			if(is_array($order))
			{
				$ord .= implode(', ', $order);
			}
			else
			{
				$ord .= $order;
			}
		}
		else
		{
			$ord = '';
		}
		if($condition)
		{
			$cond = ' WHERE ';
			if(is_array($condition))
			{
				$cond .= implode(' AND ', $condition);
			}
			else
			{
				$cond .= $condition;
			}
		}
		else
		{
			$cond = '';
		}
		if(is_array($data))
		{
			$values = array();
			foreach($data as $column=>$value)
			{
				if(preg_match("/^{.*}$/", $value))
				{
					$value = str_replace(array('{', '}'), '', $value);
					$values[] = $column . " = " . $value;
				}
				else
				{
					$values[] = $column . " = '" . $value . "'";
				}

			}
			$data = implode(', ', $values);
		}
		else
		{
			$data = NULL;
		}
		$sql = "UPDATE {$table} SET {$data}{$cond}{$ord}{$limit}";
		if($x==1){trigger_error('<u>Database Debug</u>: '.$sql);}
		return $this->dbQuery($sql);
	}
	/**
	 * Escape a string for queries
	 * @param string $string string to be escaped
	 * @return string $string escaped string
	 */
	function dbEscapeString($string)
	{
		return mysql_real_escape_string($string, $this->_connection);
	}
	/**
	 * Method for closing database connection
	 *
	 * @return mixed result of connection closing
	 */
	function dbClose()
	{
		return mysql_close($this->_connection);
	}
	/**
	 * Returns an array corresponding to a fetched row.
	 *
	 * @param mixed $result The result of the query.
	 * @return array
	 */
	function dbFetchArray($result)
	{
		return mysql_fetch_array($result, MYSQL_ASSOC);
	}
	/**
	 * Returns a query result
	 *
	 * @param mixed $result result object
	 * @param int $row row number
	 * @param int $field field number
	 * @return mixed result
	 */
	function dbFetchResult($result, $row, $field)
	{
		return mysql_result($result, $row, $field);
	}
	/**
	 * Returns the number of rows returned by a query result
	 *
	 * @param mixed $result The result of the query.
	 * @return integer Number of rows
	 */
	function dbNumRows($result)
	{
		return mysql_num_rows($result);
	}
}
?>