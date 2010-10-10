<?php
/**
 * $Id$
 *
 * MySQL Improved database library.
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
 * MySQL Improved database library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudDb
 *
 */
class Database_Mysqli extends Database implements Interface_Database
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
			$message = __( 'Error connecting to database management server.' ) . ' ' . $db_link->connect_error;

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
		 * UTF Compatibility.
		 */
		$this->_mDbLink->query( "SET NAMES 'utf8'" );

		return TRUE;
	}

	/**
	 * (non-PHPdoc)
	 * @see src/RudWEb/int/Database/Interface_Database::Disconnect()
	 */
	public function Disconnect()
	{
		return $this->_mDbLink->close();
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

		return $this->_mDbLink->real_escape_string( $string );
	}
}
?>