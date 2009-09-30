<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>RudWEb Application controller
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
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
	 * Set core configuration directory.
	 */
	define('_RW_CFG_DIR', _RW_DIR . 'etc/');
	/**
	 * Load engine paths from configuration file.
	 */
	require_once(_RW_CFG_DIR.'paths.cfg.php');
	/**
	 * Set application path.
	 */
	define('_APP_DIR',$cfg['Paths']['AppDir']);
	/**
	 * Set application configuration directory.
	 */
	define('_APP_CFG_DIR', _APP_DIR . 'etc/');
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
	 * Load application paths from configuration file.
	 */
	require_once(_APP_CFG_DIR.'paths.cfg.php');
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
	define('_APP_LN',$cfg['Defaults']['Language']);
	/**
	 * Set default time zone.
	 */
	define('_APP_TIMEZONE',$cfg['Defaults']['TimeZone']);
	/**
	 * Set default skin.
	 */
	define('_APP_SKIN',$cfg['Defaults']['Skin']);
	/**
	 * Set error handling.
	 */
	define('_APP_ERR',$cfg['Config']['Errors'] ? TRUE : FALSE);
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
if(is_readable(_RW_LIB_DIR.'rw/rw.core.inc.php'))
{
	/**
	 * Load main engine class.
	 */
	require_once(_RW_LIB_DIR.'rw/rw.core.inc.php');
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
		 * Check if mbsting extension is available.
		 */
		if (function_exists('mb_internal_encoding'))
		{
			/**
			 * Set internal character encoding.
			 */
			mb_internal_encoding("UTF-8");
			/**
			 * Set output characted encoding.
			 */
			mb_http_output("UTF-8");
		}
		/**
		 * Load routing extension.
		 */
		$core->rwLoadExt('Routing');
		/**
		 * Perform routing.
		 */
		$core->rwExts['Routing']->rwRouting();
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
		 * If database connection is not available,
		 * $_POST is filtered as get.
		 * Tags are not removed nor disabled from $_POST array.
		 */
		$core->rwSec->rwSanitizeInput();
		/**
		 * Load Sessions extension.
		 */
		$core->rwLoadExt('Session');
		/**
		 * Load users extension.
		 */
		$core->rwLoadExt('Users');
		/**
		 * Load captcha extension.
		 */
		$core->rwLoadExt('Captcha');
		/**
		 * Load forms extension.
		 */
		$core->rwLoadExt('Forms');
		/**
		 * Initialize session.
		 */
		$core->rwExts['Session']->rwSession();
		/**
		 * Initialize users.
		 */
		$core->rwExts['Users']->rwUsers();
		/**
		 * Get language.
		 */
		$rwLn = ($core->rwLoadedExt('Session') && $core->rwLoadedExt('Users') && isset($_SESSION[_APP_PRE.'_usr']['ln'])) ? $_SESSION[_APP_PRE.'_usr']['ln'] : _APP_LN;
		/**
		 * Set language.
		 */
		$core->rwSetLn($rwLn);
		/**
		 * Load internationalization extension.
		 */
		$core->rwLoadExt('Int');
		/**
		 * Set main translation list.
		 */
		$core->rwAddLang($core->rwExts['Int']->rwInt($core->rwGetLn()));
		/**
		 * Load output library.
		 */
		$core->rwLoadLib('Output');
		/**
		 * Load application module.
		 */
		$core->rwLoadModule();
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