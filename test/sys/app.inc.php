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
 * Security check.
 */
if(!defined('_RW_VALID'))
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
 * Initialize configuration.
 */
$cfg = array();

/**
 * Check if application configuration file is readable.
 */
if(is_readable('./etc/app.ini'))
{
	/**
	 * Read configuration file.
	 */
	$cfg = parse_ini_file('./etc/app.ini', TRUE);
	/**
	 * Set engine path.
	 */
	define('_RW_DIR',$cfg['Paths']['CoreDir']);
	/**
	 * Set application path.
	 */
	define('_APP_DIR',$cfg['Paths']['AppDir']);
	/**
	 * Set base application URL (web path).
	 */
	define('_APP_WWW',$cfg['Paths']['AppURL']);
	/**
	 * Check if FullSEO is enabled.
	 */
	$app_index = $cfg['Config']['FullSEO'] ? '' : 'index.php/';
	/**
	 * Set full application URL.
	 */
	define('_APP_URL', _APP_WWW . $app_index);
	/**
	 * Set database type.
	 */
	define('_APP_DB_TYPE',$cfg['Database']['Type']);
	/**
	 * Set database host.
	 */
	define('_APP_DB_HOST',$cfg['Database']['Host']);
	/**
	 * Set database port.
	 */
	define('_APP_DB_PORT',$cfg['Database']['Port']);
	/**
	 * Set database user.
	 */
	define('_APP_DB_USER',$cfg['Database']['User']);
	/**
	 * Set database password.
	 */
	define('_APP_DB_PASS',$cfg['Database']['Pass']);
	/**
	 * Set database name.
	 */
	define('_APP_DB_NAME',$cfg['Database']['Name']);
	/**
	 * Set application name.
	 */
	define('_APP_NAME',$cfg['AppInfo']['Name']);
	/**
	 * Set application author.
	 */
	define('_APP_AUTH',$cfg['AppInfo']['Author']);
	/**
	 * Set application prefix.
	 */
	define('_APP_PRE',$cfg['AppInfo']['Prefix']);
	/**
	 * Set default language.
	 */
	define('_APP_LANG',$cfg['Defaults']['Language']);
	/**
	 * Set default time zone.
	 */
	define('_APP_TIMEZONE',$cfg['Defaults']['TimeZone']);
	/**
	 * Set default skin.
	 */
	define('_APP_SKIN',$cfg['Defaults']['Skin']);
	/**
	 * Set application system directory.
	 */
	define('_APP_DIR_SYS', _APP_DIR . 'sys/');
	/**
	 * Set error handling.
	 */
	define('_APP_ERR',$cfg['Config']['Errors'] ? TRUE : FALSE);
	/**
	 * Set core library path.
	 */
	define('_RW_DIR_LIB', _RW_DIR . 'lib/');
	/**
	 * Use fake file extension for URL's?
	 */
	define('_APP_FAKEXT',$cfg['Config']['Fakext'] ? TRUE : FALSE);
}
/**
 * Application configuration file is missing.
 */
else
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
 * Check if main engine class is readable.
 */
if(is_readable(_RW_DIR.'lib/rw/rw.core.inc.php'))
{
	/**
	 * Load main engine class.
	 */
	require_once(_RW_DIR.'lib/rw/rw.core.inc.php');
	/**
	 * Initialize core.
	 */
	$core = new rw_Core;
	/**
	 * Load error handling library.
	 */
	$core->rwLoadLib('Error');
	/**
	 * Initialize error handling.
	 */
	$core->rwErr->init();
	/**
	 * From now on we can process errors ourselves.
	 */
	try
	{
		/**
		 * Set default timezone.
		 */
		date_default_timezone_set(_APP_TIMEZONE);
		/**
		 * Load routing extension.
		 */
		$core->rwLoadExt('Routing');
		/**
		 * Perform routing.
		 */
		$core->rwExts['Routing']->doRouting();
		/**
		 * Load database library.
		 */
		$core->rwLoadLib('Database');
		/**
		 * Open database connection.
		 */
		$core->rwDb->dbConnect();
		/**
		 * Load security library.
		 */
		$core->rwLoadLib('Security');
		/**
		 * Sanitize input.
		 * 
		 * This filters the $_GET and $_POST arrays.
		 * If database connection is available,
		 * tags are not removed nor disabled from $_POST array.
		 */
		$core->rwSec->rwSanitizeInput();
		/**
		 * XXX Test start.
		 */
		echo '<pre>';
		var_dump($_GET);
		echo '<hr />';
		var_dump($_POST);
		//echo 'Hello World';
		/**
		 * XXX Test end.
		 */
		/**
		 * XXX Load requested module.
		 */
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
	 * Display "Not Found" page.
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution.
	 */
	exit;
}