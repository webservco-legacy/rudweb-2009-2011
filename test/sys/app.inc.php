<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>RudWEb Application controller
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-07 16:44:00
 * @access     public
 * @package    rwApp
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
 * Security check
 */
if(!defined('_RW_VALID'))
{
	/**
	 * Display "Not Found" page
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution
	 */
	exit;
}

/**
 * Initialize configuration
 */
$cfg = array();

/**
 * Check if application configuration file is readable
 */
if(is_readable('./etc/app.ini'))
{
	/**
	 * Read configuration file
	 */
	$cfg = parse_ini_file('./etc/app.ini', TRUE);
	/**
	 * Set engine path
	 */
	define('_RW_DIR',$cfg['Paths']['CoreDir']);
}
/**
 * Application configuration file is missing.
 */
else
{
	/**
	 * Display "Not Found" page
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution
	 */
	exit;
}

/**
 * Check if main engine class is readable
 */
if(is_readable(_RW_DIR.'lib/rw/rw.core.inc.php'))
{
	/**
	 * Load main engine class
	 */
	require_once(_RW_DIR.'lib/rw/rw.core.inc.php');
	/**
	 * Initialize core
	 */
	$core = new rw_Core;
	/**
	 * Preprocess
	 */
	$core->rwPreprocess($cfg);
	/**
	 * From now on we can do try/catch
	 */
	try
	{
		/**
		 * Process
		 */
		$core->rwProcess();
		/**
		 * Postprocess
		 */
		$core->rwPostprocess();
		/**
		 * Test output
		 */
		echo 'Hello World';
	}
	/**
	 * Catch errors.
	 *
	 * @var mixed $e error object
	 */
	catch(Exception $e)
	{
		/**
		 * Handle errors.
		 */
		echo $core->rwErr->showError($e);
		/**
		 * Stop execution.
		 */
		exit;
	}
}
/**
 * Main engine class is missing.
 */
else
{
	/**
	 * Display "Not Found" page
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution
	 */
	exit;
}