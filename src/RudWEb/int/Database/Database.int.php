<?php
/**
 * $Id$
 *
 * Database interface.
 *
 * All database libraries will implement it
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
 * Interface_Database
 *
 * Database interface.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudDb
 *
 */
interface Interface_Database
{
	/**
	 * Open database connection.
	 *
	 * @return bool
	 */
	public function Connect();

	/**
	 * Close database connection.
	 *
	 * @return bool
	 */
	public function Disconnect();

	/**
	 * Escape a string for use in a database query.
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public function EscapeString( $string );

	//public function Now();

	//public function Create();

	//public function Retrieve();

	//public function Update();

	//public function Delete();
}