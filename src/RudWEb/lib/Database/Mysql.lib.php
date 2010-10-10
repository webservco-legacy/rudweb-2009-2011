<?php
/**
 * $Id$
 *
 * MySQL database library.
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
 * MySQL database library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudDb
 *
 */
class Database_Mysql extends Database implements Interface_Database
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
		$db_link = @mysql_connect( $this->_mDbHost . ':' . $db_port, $this->_mDbUser, $this->_mDbPassword );

		if ( !$db_link )
		{
			/**
			 * @var string
			 */
			$message = __( 'Error connecting to database management server.' ) . ' ' . mysql_error();

			trigger_error( $message );

			return FALSE;
		}

		if ( TRUE !== mysql_select_db( $this->_mDbDatabase, $db_link ) )
		{
			/**
			 * @var string
			 */
			$message = sprintf( __( 'Error opening database %s.' ), $this->_mDbDatabase ) . ' ' . mysql_error();

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
		mysql_query( "SET NAMES 'utf8'", $this->_mDbLink );

		return TRUE;
	}

	/**
	 * (non-PHPdoc)
	 * @see src/RudWEb/int/Database/Interface_Database::Disconnect()
	 */
	public function Disconnect()
	{
		return mysql_close( $this->_mDbLink );
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

		return mysql_real_escape_string( $string );
	}
}
?>