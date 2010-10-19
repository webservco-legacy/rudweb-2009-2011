<?php
/**
 * $Id$
 *
 * PostgreSQL database library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudDb
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
 * PostgreSQL database library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudDb
 *
 */
class Database_Postgresql extends Database implements Interface_Database
{
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
		 * Set default port if we have no custom port in configuration settings.
		 *
		 * @var string
		 */
		$db_port = ( '' != $this->_mDbPort ) ? $this->_mDbPort : '5432';

		/**
		 * Set database link identifier.
		 *
		 * host=sheep port=5432 dbname=test user=lamb password=bar
		 *
		 * @var resource
		 */
		$db_link = pg_connect( "host={$this->_mDbHost} port={$db_port} dbname={$this->_mDbDatabase} user={$this->_mDbUser} password={$this->_mDbPassword}" );

		if ( !$db_link )
		{
			/**
			 * @var string
			 */
			$message = __( 'Database library: Error connecting to database management server.', 'RudWEb' );

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
		Core::Cfg()->Get( 'db.type' )
		);

		Core::Log()->Write( $db_message, 'debug' );

		/**
		 * UTF Compatibility.
		 */
		pg_query("SET NAMES 'UTF8'", $this->_mDbLink );

		return TRUE;
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::Disconnect()
	 */
	public function Disconnect()
	{
		return pg_close( $this->_mDbLink );
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

		return pg_escape_string( $string );
	}
}
?>