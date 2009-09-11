<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Engine core class
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-07 18:06:00
 * @access     public
 * @package    rwLibCore
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
 * rw_Core.
 *
 * Basic engine functionality.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwLibCore
 */
class rw_Core
{
	/**
	 * Error handling object.
	 *
	 * One of the available libraries.
	 *
	 * @var mixed
	 */
	public $rwErr = NULL;

	/**
	 * Database object.
	 *
	 * One of the available libraries.
	 *
	 * @var mixed
	 */
	public $rwDb = NULL;

	/**
	 * Security object.
	 *
	 * One of the available libraries.
	 *
	 * @var mixed
	 */
	public $rwSec = NULL;

	/**
	 * Class constructor.
	 *
	 * @return mixed result
	 */
	public function __construct()
	{
		/**
		 * Do nothing.
		 */
	}

	/**
	 * Preprocess.
	 *
	 * @param array $cfg configuration options from ini file
	 * @return bool result
	 */
	public function rwPreprocess($cfg)
	{
		/**
		 * Set remaining configuration options.
		 */
		$this->_rwSetCfg($cfg);
		/**
		 * Load error handling library.
		 */
		$this->rwErr = $this->rwLoadLib('err');
		/**
		 * Initialize error handling.
		 */
		$this->rwErr->init();
		/**
		 * From now on we can handle errors ourselves.
		 */
		try
		{
			/**
			 * Set default timezone.
			 */
			date_default_timezone_set(_APP_TIMEZONE);
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
			echo $this->rwErr->showError($e);
			/**
			 * Stop execution.
			 */
			exit;
		}
		/**
		 * Return result
		 */
		return TRUE;
	}

	/**
	 * Process.
	 *
	 * @return mixed result
	 */
	public function rwProcess()
	{
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Postprocess.
	 *
	 * @return mixed result
	 */
	public function rwPostProcess()
	{
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Set configuration options.
	 *
	 * @param array $cfg configuration options from ini file
	 * @return bool result
	 */
	private function _rwSetCfg($cfg)
	{
		/**
		 * Set application path.
		 *
		 *  @var mixed _APP_DIR application path
		 */
		define('_APP_DIR',$cfg['Paths']['AppDir']);
		/**
		 * Set base application URL (web path).
		 *
		 *  @var mixed _APP_WWW application url
		 */
		define('_APP_WWW',$cfg['Paths']['AppURL']);
		/**
		 * Check if FullSEO is enabled.
		 *
		 * @var string $app_index index value
		 */
		$app_index = $cfg['Config']['FullSEO'] ? '' : 'index.php/';
		/**
		 * Set full application URL.
		 *
		 *  @var mixed _APP_URL application full URL
		 */
		define('_APP_URL', _APP_WWW . $app_index);
		/**
		 * Set database type.
		 *
		 * @var mixed _APP_DB_TYPE database type
		 */
		define('_APP_DB_TYPE',$cfg['Database']['Type']);
		/**
		 * Set database host.
		 *
		 * @var mixed _APP_DB_HOST database host
		 */
		define('_APP_DB_HOST',$cfg['Database']['Host']);
		/**
		 * Set database port.
		 *
		 * @var mixed _APP_DB_PORT database port
		 */
		define('_APP_DB_PORT',$cfg['Database']['Port']);
		/**
		 * Set database user.
		 *
		 * @var mixed _APP_DB_USER database user
		 */
		define('_APP_DB_USER',$cfg['Database']['User']);
		/**
		 * Set database password.
		 *
		 * @var mixed _APP_DB_PASS database password
		 */
		define('_APP_DB_PASS',$cfg['Database']['Pass']);
		/**
		 * Set database name.
		 *
		 * @var mixed _APP_DB_NAME database name
		 */
		define('_APP_DB_NAME',$cfg['Database']['Name']);
		/**
		 * Set application name.
		 *
		 * @var mixed _APP_NAME application name
		 */
		define('_APP_NAME',$cfg['AppInfo']['Name']);
		/**
		 * Set application author.
		 *
		 * @var mixed _APP_AUTH application author
		 */
		define('_APP_AUTH',$cfg['AppInfo']['Author']);
		/**
		 * Set application prefix.
		 *
		 * @var mixed _APP_PRE application prefix
		 */
		define('_APP_PRE',$cfg['AppInfo']['Prefix']);
		/**
		 * Set default language.
		 *
		 * @var mixed _APP_LANG default application language
		 */
		define('_APP_LANG',$cfg['Defaults']['Language']);
		/**
		 * Set default time zone.
		 *
		 * @var mixed _APP_TIMEZONE default application timezone
		 */
		define('_APP_TIMEZONE',$cfg['Defaults']['TimeZone']);
		/**
		 * Set default skin.
		 *
		 * @var mixed _APP_SKIN default application skin
		 */
		define('_APP_SKIN',$cfg['Defaults']['Skin']);
		/**
		 * Set application system directory.
		 *
		 *  @var mixed _APP_DIR_SYS application system directory
		 */
		define('_APP_DIR_SYS', _APP_DIR . 'sys/');
		/**
		 * Set error handling.
		 *
		 * @var mixed _APP_ERR error handling
		 */
		define('_APP_ERR',$cfg['Config']['Errors'] ? TRUE : FALSE);
		/**
		 * Set core library path.
		 *
		 *  @var mixed _RW_DIR_LIB core library path
		 */
		define('_RW_DIR_LIB', _RW_DIR . 'lib/');
		/**
		 * Use fake file extension for URL's?
		 *
		 * @var mixed _APP_FAKEXT
		 */
		define('_APP_FAKEXT',$cfg['Config']['Fakext'] ? TRUE : FALSE);
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Library loader.
	 *
	 * @param string $lib library to be loaded
	 * @return mixed result
	 */
	public function rwLoadLib($lib)
	{
		/**
		 * List of available libraries.
		 */
		$libs = array(
		'db' => 'Database',
		'err' => 'Error',
		'out' => 'Output',
		'sec' => 'Security'
		);
		/**
		 * Set library path.
		 */
		$libPath = _RW_DIR_LIB.$lib.'/'.$lib.'.inc.php';

		/**
		 * Check if requested library exists and is loadable.
		 */
		if (array_key_exists($lib, $libs) && is_readable($libPath))
		{
			/**
			 * Set library class name.
			 */
			$libClass = 'rw_' . $libs[$lib];
			/**
			 * Load library class.
			 */
			require_once($libPath);
			/**
			 * Each library may have different values passed to them.
			 */
			switch ($lib)
			{
				/**
				 * Database.
				 */
				case 'db' : {
					/**
					 * Allowed database types.
					 */
					$dbs = array('mysql');
					/**
					 * Check current database type.
					 */
					if (in_array(_APP_DB_TYPE, $dbs))
					{
						/**
						 * Set new class name.
						 */
						$libClass .= '_' . _APP_DB_TYPE;
						/**
						 * Load database interface.
						 */
						require_once(_RW_DIR_LIB.$lib.'/'.$lib.'.'._APP_DB_TYPE.'.inc.php');
						/**
						 * Load database object.
						 */
						$db = new $libClass(_APP_DB_HOST, _APP_DB_PORT, _APP_DB_USER, _APP_DB_PASS, _APP_DB_NAME);
						/**
						 * Initiate database connection.
						 */
						$db->dbConnect();
						/**
						 * Return result.
						 */
						return $db;
					}
					/**
					 * Database type is not supported.
					 */
					trigger_error('Database::Database type <b>' . _APP_DB_TYPE . '</b> not supported.', 256);
					/**
					 * Stop execution.
					 */
					break;
				}
				/**
				 * Security.
				 */
				case 'sec' : {
					/**
					 * Return result.
					 */
					return new $libClass($this->rwDb);
					/**
					 * Stop execution.
					 */
					break;
				}
				/**
				 * All others.
				 */
				default : {
					/**
					 * Return result.
					 */
					return new $libClass;
					/**
					 * Stop execution.
					 */
					break;
				}
			}
		}
		/**
		 * Library doesn't exist or is not loadable.
		 */
		else
		{
			/**
			 * Show error message.
			 */
			trigger_error('Engine::Requested library does not exist or is not loadable.', 256);
		}
	}
}
?>