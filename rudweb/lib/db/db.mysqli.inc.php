<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>MySQL Improved Database library.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-08 19:16:00
 * @access     public
 * @package    rwLibDb
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
 * rw_Database_mysqli
 *
 * Database Class for MySQL Improved
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwLibDb
 */
class rw_Database_mysqli extends rw_Database_global implements rw_iDatabase
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
	public function __construct($dbHost, $dbPort, $dbUser, $dbPass, $dbName)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($dbHost, $dbPort, $dbUser, $dbPass, $dbName);
	}

	/**
	 * Initialize database connection.
	 *
	 * @return mixed result.
	 */
	public function dbConnect()
	{
		/**
		 * Attempt connection.
		 */
		// XXX continue work...
		//$_connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

	}
}
?>