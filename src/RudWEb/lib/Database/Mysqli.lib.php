<?php
/**
 * $Id$
 *
 * MySQL Improved database library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudDatabase
 * @version    $Revision$
 * @since      Version 5
 * @access     public
 * @filesource
 */

/**
 * Security check.
 */
if ( !defined( '_RUDWEB' ) )
{
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * MySQL Improved database library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudDatabase
 *
 */
class Database_Mysqli extends Database implements Interface_Database
{
	/**
	 * Stores the mysqli database statement.
	 *
	 * @var mixed
	 */
	protected $_mDbStmt;

	/**
	 * Comparison operators.
	 *
	 * @var array
	 */
	private $_mCompOperators = array(
		'eq' => '=',
		'not' => '!=',
		'lt' => '<',
		'gt' => '>',
		'lte' => '<=',
		'gte' => '>=',
	);

	/**
	 * Order by.
	 *
	 * @var array
	 */
	private $_mOrderBy = array(
		'asc' => 'ASC',
		'desc' => 'DESC',
	);

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::Connect()
	 */
	public function Connect()
	{
		/**
		 * Set configuration data.
		 */
		$this->_SetData();

		/**
		 * Set MySQL default port if we have no custom port in configuration settings.
		 *
		 * @var string
		 */
		$db_port = ( '' != $this->_mDbPort ) ? $this->_mDbPort : '3306';

		/**
		 * Set database link identifier.
		 *
		 * @var resource
		 */
		$db_link = new mysqli( $this->_mDbHost, $this->_mDbUser, $this->_mDbPassword, $this->_mDbDatabase, $db_port );

		if ( 0 != $db_link->connect_errno )
		{
			/**
			 * @var string
			 */
			$message = __( 'Database library: Error connecting to database management server.', 'RudWEb' ) . ' ' . $db_link->connect_error;

			trigger_error( $message );

			return FALSE;
		}

		/**
		 * Set database link identifier.
		 *
		 * @var resource
		 */
		$this->_mDbLink = $db_link;

		/**
		 * @var string
		 */
		$db_message = sprintf(
		__( 'Database library: Database connection opened (driver: %s).', 'RudWEb' ),
		Core::Config()->Get( 'db.type' )
		);

		Core::Log()->Write( $db_message, 'debug' );

		/**
		 * UTF Compatibility.
		 */
		$this->_mDbLink->set_charset( 'utf8' );

		return TRUE;
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::Disconnect()
	 */
	public function Disconnect()
	{
		return $this->_mDbLink->close();
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::EscapeString()
	 */
	public function EscapeString( $string )
	{
		/**
		 * Open database connection if not already opened.
		 */
		$this->_GetLink();

		return $this->_mDbLink->real_escape_string( $string );
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::GetVersion()
	 */
	public function GetVersion()
	{
		return $this->_mDbLink->server_info;
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::GenerateId()
	 */
	public function GenerateId()
	{
		$result = $this->_mDbLink->query( "SELECT REPLACE( UUID(), '-', '' )" );

		$row = $result->fetch_row();

		$result->close();

		return $row[0];
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::GetPrimaryKey()
	 */
	public function GetPrimaryKey( $table )
	{
		/**
		 * @var string
		 */
		$query  = "SELECT COLUMN_NAME AS primary_key FROM INFORMATION_SCHEMA.STATISTICS
					WHERE INDEX_NAME='PRIMARY'
					AND INDEX_SCHEMA='{$this->_mDbDatabase}'
					AND TABLE_NAME='{$table}'";

		$result = $this->_mDbLink->query( $query );

		if ( FALSE === $result )
		{
			return FALSE;
		}

		$row = $result->fetch_row();

		$result->close();

		return $row[0];
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::Create()
	 */
	public function Create( $data, $table )
	{
		/**
		 * @var array
		 */
		$fields = array( );

		/**
		 * @var array
		 */
		$values = array();

		foreach ( $data as $field => $value )
		{
			/**
			 * Ignore NULL values.
			 */
			if ( isset( $value ) )
			{
				if ( $this->_IsBinaryField( $field ) )
				{
					/**
					 * @var array
					 */
					$fields[] = $this->_PrepareBinaryField( $field );
					/**
					 * @var array
					 */
					$values[] = "UNHEX('{$this->EscapeString( $value )}')";
				}
				else
				{
					/**
					 * @var array
					 */
					$fields[] = $field;
					/**
					 * @var array
					 */
					$values[] = "'{$this->EscapeString( $value )}'";
				}
			}
		}

		/**
		 * @var string
		 */
		$qf_fields = implode(', ', $fields );

		/**
		 * @var string
		 */
		$qf_values = implode( ', ', $values );

		/**
		 * @var string
		 */
		$query = "INSERT INTO {$table} ({$qf_fields}) VALUES ({$qf_values})";

		$this->_mDbStmt = $this->_mDbLink->prepare( $query );

		if ( FALSE === $this->_mDbStmt )
		{
			return FALSE;
		}

		$this->_mDbStmt->execute();

		$this->_mDbStmt->close();

		//return $this->_mDbLink->insert_id;

		return TRUE;
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::Retrieve()
	 */
	public function Retrieve( $data, $table, $options = array() )
	{
		/**
		 * Needed for result binding.
		 *
		 * @var array
		 */
		$data = ( !is_array( $data ) ) ? array( $data ) : $data;

		/**
		 * @var array
		 */
		$fields = array();

		foreach ( $data as $field )
		{
			if ( $this->_IsBinaryField( $field ) )
			{
				/**
				 * @var array
				 */
				$fields[] = $this->_PrepareBinaryField( $field, TRUE );
			}
			else
			{
				/**
				 * @var array
				 */
				$fields[] = $field;
			}
		}

		/**
		 * @var string
		 */
		$columns = implode( ', ', $fields );

		/**
		 * Set default condition query fill.
		 *
		 * @var string
		 */
		$qf_conditions = $this->_PrepareConditionsString( $options );

		/**
		 * Set default order query fill.
		 *
		 * @var string
		 */
		$qf_order = $this->_PrepareOrderString( $options );

		/**
		 * Set default limit query fill.
		 *
		 * @var string
		 */
		$qf_limit = $this->_PrepareLimitString( $options );

		/**
		 * @var string
		 */
		$query = "SELECT {$columns} FROM {$table}{$qf_conditions}{$qf_order}{$qf_limit}";

		$this->_mDbStmt = $this->_mDbLink->prepare( $query );

		if ( FALSE === $this->_mDbStmt )
		{
			return FALSE;
		}

		$this->_mDbStmt->execute();

		/**
		 * @var array
		 */
		$parameters = array();
		/**
		 * @var array
		 */
		$params = $data;

		/**
		 * Reset hack
		 *
		 * @var array
		 */
		$data = array();

		foreach ($params as $key => $val)	{
			/**
			 * @var array
			 */
			$parameters[] = &$data[$val];
		}

		/**
		 * Set field names to use in result.
		 */
		call_user_func_array( array( $this->_mDbStmt, 'bind_result' ), $this->_ArrayValuesAsRefference( $parameters ) );

		/**
		 * Init empty result.
		 *
		 * @var array
		 */
		$results = array();

		while( $this->_mDbStmt->fetch() )
		{
			/**
			 * @var array
			 */
			$result = array();

			foreach( $data as $key => $val ) {
				/**
				 * @var array
				 */
				$result[$key] = $val;
			}
			/**
			 * @var array
			 */
			$results[] = $result;
		}

		$this->_mDbStmt->close();

		if ( empty( $results ) )
		{
			return FALSE;
		}

		return $results;
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::Update()
	 */
	public function Update( $data, $table, $options = array() )
	{
		/**
		 * Set default values query fill.
		 *
		 * @var string
		 */
		$qf_data = NULL;

		foreach ( $data as $key => $value )
		{
			/**
			 * Ignore NULL values.
			 */
			if ( isset( $value ) )
			{
				/**
				 * @var string
				 */
				$value = $this->EscapeString( $value );

				if ( $this->_IsBinaryField( $key ) )
				{
					/**
					 * @var string
					 */
					$key = $this->_PrepareBinaryField( $key );
					/**
					 * @var string
					 */
					$value = "UNHEX('$value')";
				}
				else {
					$value = "'{$value}'";
				}

				/**
				 * @var string
				 */
				$values[] = "{$key} = {$value}";
			}
		}

		$qf_data .= implode( ', ', $values );

		/**
		 * Set default condition query fill.
		 *
		 * @var string
		 */
		$qf_conditions = $this->_PrepareConditionsString( $options );

		/**
		 * Set default limit query fill.
		 *
		 * @var string
		 */
		$qf_limit = $this->_PrepareLimitString( $options );

		/**
		 * @var string
		 */
		$query = "UPDATE {$table} SET {$qf_data}{$qf_conditions}{$qf_limit}";

		$this->_mDbStmt = $this->_mDbLink->prepare( $query );

		$this->_mDbStmt->execute();

		$this->_mDbStmt->close();

		return $this->_mDbLink->affected_rows;
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::Delete()
	 */
	public function Delete( $table, $options = array() )
	{
		/**
		 * Set default condition query fill.
		 *
		 * @var string
		 */
		$qf_conditions = $this->_PrepareConditionsString( $options );

		/**
		 * Set default order query fill.
		 *
		 * @var string
		 */
		$qf_order = $this->_PrepareOrderString( $options );

		/**
		 * Set default limit query fill.
		 *
		 * @var string
		 */
		$qf_limit = $this->_PrepareLimitString( $options );

		$query = "DELETE FROM {$table}{$qf_conditions}{$qf_order}{$qf_limit}";

		$this->_mDbStmt = $this->_mDbLink->prepare( $query );

		$this->_mDbStmt->execute();

		$this->_mDbStmt->close();

		return $this->_mDbLink->affected_rows;
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::RetrieveOne()
	 */
	public function RetrieveOne( $data, $table, $options = array() )
	{
		/**
		 * Make sure the limit isset.
		 *
		 * @var array
		 */
		$options['limit'] = 1;

		/**
		 * Get result.
		 *
		 * @var array
		 */
		$result = $this->Retrieve($data, $table, $options);

		return ( empty( $result ) ) ? FALSE : $result[0];
	}

	/**
	 * PHP 5.3 fix call_user_func_array + mysqli bind_param
	 *
	 * @author http://ca.php.net/manual/en/mysqli-stmt.bind-param.php#96770
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	private function _ArrayValuesAsRefference( $data = array() )
	{
		if ( strnatcmp( phpversion(), '5.3' ) >= 0 )
		{
			$refs = array();
			foreach( $data as $key => $value )
			{
				$refs[$key] = &$data[$key];
			}
			return $refs;
		}

		return $data;
	}

	/**
	 * Prepare conditions query filler.
	 *
	 * @param array $options
	 *
	 * @return string
	 */
	private function _PrepareConditionsString( $options = array() )
	{
		/**
		 * @var string
		 */
		$qf_conditions = NULL;

		/**
		 * Check if we have any conditions.
		 */
		if ( array_key_exists( 'conditions', $options ) && !empty ( $options['conditions'] ) )
		{
			$qf_conditions .= ' WHERE ';

			$conditions = array();

			if ( !is_array( $options['conditions'][0] ) )
			{
				$comp_operator = ( array_key_exists( 2, $options['conditions'] ) && array_key_exists( $options['conditions'][2], $this->_mCompOperators ) ) ?
				$this->_mCompOperators[$options['conditions'][2]] : $this->_mCompOperators['eq'];

				/**
				 * @var string
				 */
				$value = $this->EscapeString( $options['conditions'][1] );

				/**
				 * Check binary field
				 */
				if ( $this->_IsBinaryField( $options['conditions'][0] ) )
				{
					/**
					 * @var array
					 */
					$options['conditions'][0] = $this->_PrepareBinaryField( $options['conditions'][0] );
					/**
					 * @var array
					 */
					$options['conditions'][1] = "UNHEX('{$value}')";
				}
				else
				{
					/**
					 * @var array
					 */
					$options['conditions'][1] = "'{$value}'";
				}
				/**
				 * @var string
				 */
				$qf_conditions .= "{$options['conditions'][0]} {$comp_operator} {$options['conditions'][1]}";
			}
			else
			{
				foreach ( $options['conditions'] as $dump => $condition )
				{
					$comp_operator = ( array_key_exists(2, $condition) && array_key_exists($condition[2], $this->_mCompOperators ) ) ?
					$this->_mCompOperators[$condition[2]] : $this->_mCompOperators['eq'];

					/**
					 * @var string
					 */
					$value = $this->EscapeString( $condition[1] );

					/**
					 * Check binary field
					 */
					if ( $this->_IsBinaryField( $condition[0] ) )
					{
						/**
						 * @var array
						 */
						$condition[0] = $this->_PrepareBinaryField( $condition[0] );

						/**
						 * @var array
						 */
						$condition[1] = "UNHEX('{$value}')";
					}
					else
					{
						/**
						 * @var array
						 */
						$condition[1] = $this->EscapeString( $condition[1] );

						$condition[1] = "'{$value}'";
					}
					/**
					 * @var array
					 */
					$conditions[] = "{$condition[0]} {$comp_operator} {$condition[1]}";
				}
				/**
				 * @var string
				 */
				$qf_conditions .= implode( ' AND ', $conditions );
			}
		}

		return $qf_conditions;
	}

	/**
	 * Prepare order query filler.
	 *
	 * @param array $options
	 *
	 * @return string
	 */
	private function _PrepareOrderString( $options = array() )
	{
		/**
		 * @var string
		 */
		$qf_order = NULL;

		/**
		 * Check if we have ordering.
		 */
		if ( array_key_exists( 'order', $options ) && !empty ( $options['order'] ) )
		{
			$qf_order .= ' ORDER BY ';

			if ( !is_array( $options['order'] ) )
			{
				/**
				 * Check binary field
				 */
				if ( $this->_IsBinaryField( $options['order'] ) )
				{
					/**
					 * @var array
					 */
					$options['order'] = $this->_PrepareBinaryField( $options['order'] );
				}
				/**
				 * @var string
				 */
				$qf_order .= "{$options['order']}  {$this->_mOrderBy['asc']}";
			}
			else {

				$ordering = array();

				foreach ( $options['order'] as $order )
				{
					if ( !is_array( $order ) )
					{
						/**
						 * Check binary field
						 */
						if ( $this->_IsBinaryField( $order ) )
						{
							/**
							 * @var string
							 */
							$order = $this->_PrepareBinaryField( $order );
						}
						/**
						 * @var array
						 */
						$ordering[] = "{$order} {$this->_mOrderBy['asc']}";
					}
					else {
						$order_by = ( array_key_exists( 1, $order ) && array_key_exists( $order[1], $this->_mOrderBy ) ) ?
						$this->_mOrderBy[$order[1]] : $this->_mOrderBy['asc'];
						/**
						 * Check binary field
						 */
						if ( $this->_IsBinaryField( $order[0] ) )
						{
							/**
							 * @var string
							 */
							$order[0] = $this->_PrepareBinaryField( $order[0] );
						}
						/**
						 * @var array
						 */
						$ordering[] = "{$order[0]} {$order_by}";
					}
				}

				$qf_order .= implode( ', ', $ordering );
			}
		}

		return $qf_order;
	}

	/**
	 * Prepare limit query filler.
	 *
	 * @param array $options
	 *
	 * @return string
	 */
	private function _PrepareLimitString( $options = array() )
	{
		/**
		 * @var string
		 */
		$qf_limit = NULL;

		/**
		 * Check if we have a limit.
		 */
		if ( array_key_exists( 'limit', $options ) && !empty ( $options['limit'] ) )
		{
			$qf_limit .= ' LIMIT ';

			if ( is_array( $options['limit'] ) )
			{
				$qf_limit .= ( array_key_exists( 1, $options['limit'] ) ) ?
				"{$options['limit'][1]}, {$options['limit'][0]}" : "{$options['limit'][0]}";
			}
			else
			{
				$qf_limit .= $options['limit'];
			}
		}

		return $qf_limit;
	}

	/**
	 * Check if field is binary.
	 *
	 * @param string $field
	 *
	 * @return boolen
	 */
	private function _IsBinaryField( $field )
	{
		return ( 0 === strpos( $field, 'bin.') );
	}

	/**
	 * Parse binary field.
	 *
	 * @param string $field
	 * @param boolean $retrieve
	 *
	 * @return string
	 */
	private function _PrepareBinaryField( $field, $retrieve = FALSE )
	{
		/**
		 * @var string
		 */
		$field = ltrim( $field, 'bin.' );

		return ( $retrieve ) ? "HEX({$field})" : $field;
	}
}
?>