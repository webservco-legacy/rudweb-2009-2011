<?php
/**
 * $Id$
 *
 * PHP Data Objects library.
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
 * PHP Data Objects library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudDb
 *
 */
class Database_Pdo extends Database implements Interface_Database
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
		 * @var string
		 */
		$db_type = Core::Cfg()->Get( 'db.type' );

		if ( FALSE !== strpos( $db_type, '_' ) )
		{
			/**
			 * @var array
			 */
			$parts = explode( '_', $db_type );

			/**
			 * @var string
			 */
			$db_type = strtolower( $parts[0] );
		}

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
		try
		{
			$db_link = new PDO("{$db_type}:host={$this->_mDbHost};dbname={$this->_mDbDatabase};port={$this->_mDbPort}", $this->_mDbUser, $this->_mDbPassword);
		}
		catch( PDOException $e )
		{
			/**
			 * @var string
			 */
			$message = __( 'Error connecting to database management server.' ) . ' ' . $e->getMessage();

			trigger_error( $message );

			return FALSE;
		}

		/**
		 * Set database link identifier.
		 *
		 * @var resource
		 */
		$this->_mDbLink = $db_link;

		Core::Log()->Write(
		sprintf(
		__( 'Database connection opened (driver: %s).' ), Core::Cfg()->Get( 'db.type' )
		)
		);

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
		$this->_mDbLink = NULL;

		return TRUE;
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

		return $this->_mDbLink->quote( $string );
	}
}
?>