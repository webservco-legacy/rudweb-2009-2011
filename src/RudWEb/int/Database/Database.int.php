<?php
/**
 * $Id$
 *
 * Database interface.
 *
 * All database libraries will implement it
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
 * Interface_Database
 *
 * Database interface.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudDatabase
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

	/**
	 * Get DBMS Version number.
	 *
	 * @return string
	 */
	public function GetVersion();

	//public function Now();

	/**
	 * Generate an universally unique identifier.
	 *
	 * The Id is return as a string without hyphens.
	 *
	 * @return string
	 */
	public function GenerateId();

	/**
	 * Create record in the database.
	 *
	 * @param mixed $data
	 * @param string $table
	 *
	 * @return mixed
	 */
	public function Create( $data, $table );

	/**
	 * Get data from database.
	 *
	 * @param mixed $data
	 * @param string $table
	 * @param array $options
	 *
	 * @return mixed
	 */
	public function Retrieve( $data, $table, $options = array() );

	/**
	 * Update data.
	 *
	 * @param mixed $data
	 * @param string $table
	 * @param array $options
	 *
	 * @return mixed
	 */
	public function Update( $data, $table, $options = array() );

	/**
	 * Delete data.
	 *
	 * @param string $table
	 * @param array $options
	 *
	 * @return mixed
	 */
	public function Delete( $table, $options = array() );

	/**
	 * Get only one result from the database.
	 *
	 * @param mixed $data
	 * @param string $table
	 * @param array $options
	 *
	 * @return mixed
	 */
	public function RetrieveOne( $data, $table, $options = array() );
}
?>