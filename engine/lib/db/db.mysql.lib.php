<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>MySQL Database library.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-10 18:38:00
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
 * @package    rwDb
 */
class rw_Database_mysql extends rw_Database implements rw_iDatabase
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
	public function __construct()
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct(_APP_DB_HOST, _APP_DB_PORT, _APP_DB_USER, _APP_DB_PASS, _APP_DB_NAME);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbConnect()
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
			trigger_error('Database:::COULD_NOT_CONNECT.', 256);
		}
		/**
		 * If we can't open database.
		 */
		if(!mysql_select_db($this->dbName, $_connection))
		{
			/**
			 * Show error message.
			 */
			trigger_error('Database:::COULD_NOT_OPEN:::'.$this->dbName, 256);
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
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbDisconnect()
	 */
	public function dbDisconnect()
	{
		/**
		 * Return result.
		 */
		return mysql_close($this->_connection);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbEscapeString($string)
	 */
	public function dbEscapeString($string)
	{
		/**
		 * Return result.
		 */
		return mysql_real_escape_string($string, $this->_connection);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbQuery($sql, $stats)
	 */
	public function dbQuery($sql, $stats=TRUE)
	{
		/**
		 * If debug is set, we just output query.
		 */
		if($this->dbDebug)
		{
			/**
			 * Show query as error message.
			 */
			trigger_error('Database:::DEBUG:::'.$sql);
		}
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
			 * Show error message.
			 */
			trigger_error('Database:::QUERY:::'.mysql_error().':::'.mysql_errno(), 256);
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
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbIsEmpty()
	 */
	public function dbIsEmpty()
	{
		/**
		 * Execute query.
		 *
		 * Count number of tables in database.
		 * Don't add to query statistics.
		 */
		$r = $this->dbQuery("SELECT COUNT(TABLE_NAME) FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$this->dbName."'", FALSE);
		/**
		 * Try to get result.
		 */
		$t = $r->dbFetchResult();
		/**
		 * No result.
		 */
		if($t == 0)
		{
			/**
			 * No tables.
			 *
			 * Return result.
			 */
			return TRUE;
		}
		/**
		 * We got tables.
		 *
		 * Return result.
		 */
		return FALSE;
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbSelect($columns, $table, $condition, $order, $limit)
	 */
	public function dbSelect($columns, $table, $condition=NULL, $order=NULL, $limit=NULL)
	{
		/**
		 * Check if we have limit and set it.
		 *
		 * Otherwise limit is blank.
		 */
		$limit = (isset($limit) && $limit != '') ? ' LIMIT '.$limit : '';
		/**
		 * Check if we have order by.
		 */
		if($order)
		{
			/**
			 * Init order by.
			 */
			$ord = ' ORDER BY ';
			/**
			 * Check if we have multiple values for order.
			 */
			if(is_array($order))
			{
				/**
				 * Parse values into string.
				 */
				$ord .= implode(', ', $order);
			}
			/**
			 * Ony one value.
			 */
			else
			{
				/**
				 * Set order by.
				 */
				$ord .= $order;
			}
		}
		/**
		 * Order by not set.
		 */
		else
		{
			/**
			 * Order by is blank.
			 */
			$ord = '';
		}
		/**
		 * Check for where condition.
		 */
		if($condition)
		{
			/**
			 * Init condition.
			 */
			$cond = ' WHERE ';
			/**
			 * Check if condition contains multple values.
			 */
			if(is_array($condition))
			{
				/**
				 * Parse values as string.
				 */
				$cond .= implode(' AND ', $condition);
			}
			/**
			 * Condition contains only one value.
			 */
			else
			{
				/**
				 * Set condition.
				 */
				$cond .= $condition;
			}
		}
		/**
		 * No where condition.
		 */
		else
		{
			/**
			 * Condition is blank.
			 */
			$cond = '';
		}
		/**
		 * Check for multiple columns.
		 */
		if(is_array($columns))
		{
			/**
			 * Parse values into string.
			 */
			$columns = implode(', ', $columns);
		}
		/**
		 * Create query.
		 */
		$sql = "SELECT {$columns} FROM {$table}{$cond}{$ord}{$limit}";
		/**
		 * Return result.
		 */
		return $this->dbQuery($sql);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbInsert($table, $columns, $values)
	 */
	public function dbInsert($table, $columns=NULL, $data)
	{
		/**
		 * Check for column values.
		 */
		if($columns)
		{
			/**
			 * Init columns.
			 */
			$cols = '(';
			/**
			 * Check for multiple column values.
			 */
			if(is_array($columns))
			{
				/**
				 * Parse columns values as string.
				 */
				$cols .= implode(', ', $columns);
			}
			/**
			 * Only one column value.
			 */
			else
			{
				/**
				 * Set column value.
				 */
				$cols .= $columns;
			}
			/**
			 * Complete column string.
			 */
			$cols .= ')';
		}
		/**
		 * No column value.
		 */
		else
		{
			/**
			 * Columns string is blank.
			 * @var unknown_type
			 */
			$cols = '';
		}
		/**
		 * Check data to be inserted.
		 *
		 * The data array contains both columns and values.
		 */
		if(is_array($data))
		{
			/**
			 * Init columns.
			 */
			$col = array();
			/**
			 * Init values.
			 */
			$val = array();
			/**
			 * Split columns from values.
			 */
			foreach($data as $column => $value)
			{
				/**
				 * Set columns.
				 */
				$col[] = $column;
				/**
				 * Search for {VALUE}.
				 */
				if(preg_match("/^{.*}$/", $value))
				{
					/**
					 * Set value to function or raw data.
					 */
					$val[] = str_replace(array('{', '}'), '', $value);
				}
				/**
				 * No need to parse.
				 */
				else
				{
					/**
					 * Set value.
					 */
					$val[] = "'".$value."'";
				}
			}
			/**
			 * Init columns string.
			 */
			$cols = '(';
			/**
			 * Set columns string
			 */
			$cols .= implode(', ', $col);
			/**
			 * Complete column string.
			 */
			$cols .= ')';
			/**
			 * Set data string.
			 */
			$data  = implode(', ', $val);
		}
		/**
		 * Create query.
		 */
		$sql = "INSERT INTO {$table}{$cols} VALUES($data)";

		/**
		 * Return result.
		 */
		return $this->dbQuery($sql);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbUpdate($table, $data, $condition, $order, $limit)
	 */
	public function dbUpdate($table, $data, $condition=NULL, $order=NULL, $limit=NULL)
	{
		/**
		 * Check if we  have limit and set it.
		 *
		 * Otherwise limit is blank.
		 */
		$limit = (isset($limit) && $limit != '') ? ' LIMIT '.$limit : '';
		/**
		 * Check if we have order by.
		 */
		if($order)
		{
			/**
			 * Init order by.
			 */
			$ord = ' ORDER BY ';
			/**
			 * Check for multiple values.
			 */
			if(is_array($order))
			{
				/**
				 * Parse values as string.
				 */
				$ord .= implode(', ', $order);
			}
			/**
			 * Only one value.
			 */
			else
			{
				/**
				 * Set order string.
				 */
				$ord .= $order;
			}
		}
		/**
		 * No order by.
		 */
		else
		{
			/**
			 * Order by string is empty.
			 */
			$ord = '';
		}
		/**
		 * Check for condition.
		 */
		if($condition)
		{
			/**
			 * Init condition.
			 */
			$cond = ' WHERE ';
			/**
			 * Check for multiple values.
			 */
			if(is_array($condition))
			{
				/**
				 * Parse values as string.
				 */
				$cond .= implode(' AND ', $condition);
			}
			/**
			 * Only one value.
			 */
			else
			{
				/**
				 * Set condition string.
				 */
				$cond .= $condition;
			}
		}
		/**
		 * No condition.
		 */
		else
		{
			/**
			 * Condition is blank.
			 */
			$cond = '';
		}
		/**
		 * Check for data.
		 */
		if(is_array($data))
		{
			/**
			 * Init values.
			 */
			$values = array();
			/**
			 * Split columns from values.
			 */
			foreach($data as $column=>$value)
			{
				/**
				 * Search for {VALUE}.
				 */
				if(preg_match("/^{.*}$/", $value))
				{
					/**
					 * Parse data.
					 */
					$value = str_replace(array('{', '}'), '', $value);
					/**
					 * Set individual string.
					 */
					$values[] = $column . " = " . $value;
				}
				/**
				 * No need to parse.
				 */
				else
				{
					/**
					 * Set individual string.
					 */
					$values[] = $column . " = '" . $value . "'";
				}

			}
			/**
			 * Set data string.
			 */
			$data = implode(', ', $values);
		}
		/**
		 * No data.
		 */
		else
		{
			/**
			 * Data is null.
			 */
			$data = NULL;
		}
		/**
		 * Create query.
		 */
		$sql = "UPDATE {$table} SET {$data}{$cond}{$ord}{$limit}";
		/**
		 * Return result.
		 */
		return $this->dbQuery($sql);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbDelete($table, $condition, $order, $limit)
	 */
	public function dbDelete($table, $condition=NULL, $order=NULL, $limit=NULL)
	{
		/**
		 * Check if we have limit and set it.
		 *
		 * Otherwise limit is blank.
		 */
		$limit = (isset($limit) && $limit != '') ? ' LIMIT '.$limit : '';
		/**
		 * Check if we have order by.
		 */
		if($order)
		{
			/**
			 * Init order by.
			 */
			$ord = ' ORDER BY ';
			/**
			 * Check if we have multiple values for order.
			 */
			if(is_array($order))
			{
				/**
				 * Parse values into string.
				 */
				$ord .= implode(', ', $order);
			}
			/**
			 * Ony one value.
			 */
			else
			{
				/**
				 * Set order by.
				 */
				$ord .= $order;
			}
		}
		/**
		 * Order by not set.
		 */
		else
		{
			/**
			 * Order by is blank.
			 */
			$ord = '';
		}
		/**
		 * Check for where condition.
		 */
		if($condition)
		{
			/**
			 * Init condition.
			 */
			$cond = ' WHERE ';
			/**
			 * Check if condition contains multple values.
			 */
			if(is_array($condition))
			{
				/**
				 * Parse values as string.
				 */
				$cond .= implode(' AND ', $condition);
			}
			/**
			 * Condition contains only one value.
			 */
			else
			{
				/**
				 * Set condition.
				 */
				$cond .= $condition;
			}
		}
		/**
		 * No where condition.
		 */
		else
		{
			/**
			 * Condition is blank.
			 */
			$cond = '';
		}
		/**
		 * Create query.
		 */
		$sql = "DELETE FROM {$table}{$cond}{$ord}{$limit}";
		/**
		 * Return result.
		 */
		return $this->dbQuery($sql);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbNumRows($result)
	 */
	public function dbNumRows($result)
	{
		/**
		 * Return result.
		 */
		return mysql_num_rows($result);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbFetchArray($result)
	 */
	public function dbFetchArray($result)
	{
		/**
		 * Return result.
		 */
		return mysql_fetch_array($result, MYSQL_ASSOC);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbFetchResult($result, $row, $field)
	 */
	public function dbFetchResult($result, $row, $field)
	{
		/**
		 * Return result.
		 */
		return mysql_result($result, $row, $field);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbLastInsertId()
	 */
	public function dbLastInsertId()
	{
		/**
		 * Execute query.
		 */
		$r = $this->dbQuery("SELECT LAST_INSERT_ID()");
		/**
		 * Return result.
		 */
		return $r->dbFetchResult();
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbNow()
	 */
	public function dbNow()
	{
		/**
		 * Return current date and time (DATETIME compatible string).
		 */
		return date('Y-m-d H:i:s');
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/db/rw_iDatabase#dbNowMinAgo($min)
	 */
	public function dbNowMinAgo($min=0)
	{
		/**
		 * Return date and time (DATETIME compatible string).
		 */
		return date('Y-m-d H:i:s', time() - $min * 60);
	}
}
?>