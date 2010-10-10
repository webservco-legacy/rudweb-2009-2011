<?php
/**
 * $Id$
 *
 * SQLite3 database library.
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
 * SQLite3 database library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudDb
 *
 */
class Database_Sqlite3 extends Database implements Interface_Database
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

		$db_path = $this->_mDbDatabase . '.db';

		if ( !is_readable( $db_path ) )
		{
			/**
			 * @var string
			 */
			$message = __( 'Database file is not readable.' );

			trigger_error( $message );

			return FALSE;
		}

		/**
		 * Set database link identifier.
		 *
		 * @var resource
		 */
		try
		{
			$db_link =  new SQLite3( $db_path );
		}
		catch ( Exception $e )
		{
			/**
			 * @var string
			 */
			$message = sprintf( __( 'Error opening database %s.' ), $this->_mDbDatabase ) . ' ' . $e->getMessage();

			trigger_error( $message );

			return FALSE;
		}

		/**
		 * Set database link identifier.
		 *
		 * @var resource
		 */
		$this->_mDbLink = $db_link;

		CCore::Log()->Write(
		sprintf(
		__( 'Database connection opened (driver: %s).' ), Core::Cfg()->Get( 'db.type' )
		)
		);

		return TRUE;
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Database::Disconnect()
	 */
	public function Disconnect()
	{
		return  $this->_mDbLink->close();
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

		return $this->_mDbLink->escapeString( $string );
	}
}
?>