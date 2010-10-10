<?php
/**
 * $Id$
 *
 * SQLite database library.
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
 * SQLite database library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudDb
 *
 */
class Database_Sqlite extends Database implements Interface_Database
{
	/**
	 * (non-PHPdoc)
	 * @see src/RudWEb/int/Database/Interface_Database::Connect()
	 */
	public function Connect()
	{
		/**
		 * Set configuration data.
		 */
		$this->_SetData();

		/**
		 * Set database link identifier.
		 *
		 * @var resource
		 */
		$db_link = sqlite_open( "{$this->_mDbDatabase}.db", 0666, $err );

		if ( !$db_link )
		{
			/**
			 * @var string
			 */
			$message = sprintf( __( 'Error opening database %s.' ), $this->_mDbDatabase ) . ' ' . $err;

			trigger_error( $message );

			return FALSE;
		}

		/**
		 * Set database link identifier.
		 *
		 * @var resource
		 */
		$this->_mDbLink = $db_link;

		return TRUE;
	}

	/**
	 * (non-PHPdoc)
	 * @see src/RudWEb/int/Database/Interface_Database::Disconnect()
	 */
	public function Disconnect()
	{
		return sqlite_close( $this->_mDbLink );
	}

	/**
	 * (non-PHPdoc)
	 * @see src/RudWEb/int/Database/Interface_Database::EscapeString()
	 */
	public function EscapeString( $string )
	{
		/**
		 * Open database connection if not already opened.
		 */
		$this->_GetLink();

		return sqlite_escape_string( $string );
	}
}
?>