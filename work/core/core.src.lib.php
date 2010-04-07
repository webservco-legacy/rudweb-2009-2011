<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Engine core class
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-07 18:06:00
 * @access     public
 * @package    RudWEb
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
 * @package    RudWEb
 */
class rw_Core
{
	/**
	 * User loadable libraries.
	 *
	 * Format: name => object.
	 *
	 * @var array
	 */
	private $rwLibs = array();

	/**
	 * Available extensions.
	 *
	 * Format: name => object
	 *
	 * @var array
	 */
	public $rwExts = array();

	/**
	 * Database object.
	 *
	 * One of the available libraries.
	 *
	 * @var mixed
	 */
	public $rwDb = NULL;

	/**
	 * Error handling object.
	 *
	 * One of the available libraries.
	 *
	 * @var mixed
	 */
	public $rwErr = NULL;

	/**
	 * Output object.
	 *
	 * One of the available libraries.
	 *
	 * @var mixed
	 */
	public $rwOut = NULL;

	/**
	 * Security object.
	 *
	 * One of the available libraries.
	 *
	 * @var mixed
	 */
	public $rwSec = NULL;

	/**
	 * Translations list.
	 *
	 * @var array
	 */
	private $rwLang = array();

	/**
	 * Current module information.
	 *
	 * @var mixed
	 */
	private $modAbout = NULL;

	/**
	 * Current module location.
	 *
	 * @var mixed
	 */
	private $modLocation = NULL;

	/**
	 * Current module request string.
	 *
	 * @var mixed
	 */
	private $modRequest = NULL;

	/**
	 * Class constructor.
	 *
	 * @return mixed result
	 */
	public function __construct()
	{
		/**
		 * Define user loadable libraries.
		 */
		$rwLibs = array('Database' => 'db',	'Error' => 'err', 'Output' => 'out', 'Security' => 'sec');
		/**
		 * Set user loadable libraries.
		 */
		$this->rwLibs = $rwLibs;
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
		 * Parse library name.
		 */
		$lib = ucfirst(strtolower($lib));
		/**
		 * Check if requested library is user loadable.
		 */
		if (array_key_exists($lib, $this->rwLibs))
		{
			/**
			 * Set library path.
			 */
			$libPath = _CORE_LIB_DIR.$this->rwLibs[$lib].'/'.$this->rwLibs[$lib].'.lib.php';
			/**
			 * Check if library exists
			 */
			if (is_readable($libPath))
			{
				/**
				 * Set library class name.
				 */
				$libClass = 'rw_' . $lib;
				/**
				 * Set library object name.
				 */
				$libObj = 'rw'.ucfirst(strtolower($this->rwLibs[$lib]));
				/**
				 * Check if library is aleady loaded.
				 */
				if($this->_rwLoadedLib($libObj))
				{
					/**
					 * Do not load the library again, just return result.
					 */
					return TRUE;
				}
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
					case 'Database' : {
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
							require_once(_CORE_LIB_DIR.$this->rwLibs[$lib].'/'.$this->rwLibs[$lib].'.'._APP_DB_TYPE.'.lib.php');
							/**
							 * Load object.
							 */
							$obj = new $libClass;
							/**
							 * Stop execution.
							 */
							break;
						}
						/**
						 * Database type is not supported.
						 */
						trigger_error('Database:::TYPE_NOT_SUPPORTED:::' . _APP_DB_TYPE, 256);
						/**
						 * Stop execution.
						 */
						break;
					}
					/**
					 * Security.
					 */
					case 'Security' : {
						/**
						 * Load object.
						 */
						$obj = new $libClass($this->rwDb);
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
						 * Load object.
						 */
						$obj = new $libClass;
						/**
						 * Stop execution.
						 */
						break;
					}
				}
				/**
				 * Set library as engine object.
				 */
				$this->$libObj = $obj;
				/**
				 * Return result.
				 */
				return TRUE;
			}
			/**
			 * Library doesnt't exist.
			 */
			else
			{
				/**
				 * Show error message.
				 */
				trigger_error('Engine:::NO_LIB_1:::'.$lib, 256);
			}
		}
		/**
		 * Library doesn't exist or is not user loadable.
		 */
		else
		{
			/**
			 * Show error message.
			 */
			trigger_error('Engine:::NO_LIB_2:::'.$lib, 256);
		}
	}

	/**
	 * Load an extension.
	 *
	 * @param string $ext extension name
	 * @return mixed result
	 */
	public function rwLoadExt($ext)
	{
		/**
		 * Parse extension name.
		 */
		$ext = ucfirst(strtolower($ext));
		/**
		 * Check if library is already loaded.
		 */
		if($this->rwLoadedExt($ext))
		{
			/**
			 * Do not load extension again, just return result.
			 */
			return TRUE;
		}
		/**
		 * Load extension library.
		 */
		require_once(_CORE_LIB_DIR.'ext/ext.lib.php');
		/**
		 * Search in local extension dir.
		 */
		if (is_readable(_APP_EXT_DIR.$ext.'.ext.php'))
		{
			/**
			 * Load local extension.
			 */
			require_once(_APP_EXT_DIR.$ext.'.ext.php');
		}
		/**
		 * Search in global extension dir.
		 */
		else if (is_readable(_CORE_EXT_DIR.$ext.'.ext.php'))
		{
			/**
			 * Load global extension.
			 */
			require_once(_CORE_EXT_DIR.$ext.'.ext.php');
		}
		/**
		 * Extension not found.
		 */
		else
		{
			/**
			 * Show error message.
			 */
			trigger_error('Engine:::NO_EXT:::'.$ext, 256);
		}
		/**
		 * Check library dependencies.
		 */
		$missingLibDeps = $this->_rwDepLib($extAbout[$ext]['deps']['lib']);
		/**
		 * Check missing dependencies.
		 */
		if ($missingLibDeps)
		{
			/**
			 * Set missing dependencies list.
			 */
			$missingDeps = implode(', ', $missingLibDeps);
			/**
			 * Show error message.
			 */
			trigger_error('Extension:::NO_LIB_DEP:::'.$ext.':::'.$missingDeps, 256);
		}
		/**
		 * Check extension dependencies.
		 */
		$missingExtDeps = $this->_rwDepExt($extAbout[$ext]['deps']['ext']);
		/**
		 * Check missing dependencies.
		 */
		if ($missingExtDeps)
		{
			/**
			 * Set missing dependencies list.
			 */
			$missingDeps = implode(', ', $missingExtDeps);
			/**
			 * Show error message.
			 */
			trigger_error('Extension:::NO_EXT_DEP:::'.$ext.':::'.$missingDeps, 256);
		}
		/**
		 * Set extension class name.
		 */
		$extClass = 'rw_Extension_'.$ext;
		/**
		 * Load extension.
		 */
		$this->rwExts[$ext] = new $extClass($extAbout[$ext]);
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Load module.
	 *
	 * @return mixed result
	 */
	public function rwLoadModule()
	{
		/**
		 * Check application license.
		 */
		$this->_rwLicCheck();
		/**
		 * Section name.
		 *
		 * Filtering is already done at this point.
		 */
		$sct = $_GET['section'];
		/**
		 * Module name.
		 *
		 * Filtering is already done at this point.
		 */
		$mod = $_GET['module'];
		/**
		 * Action name.
		 *
		 * Filtering is already done at this point.
		 */
		$act = $_GET['action'];
		/**
		 * Initialize module.
		 */
		$this->rwInitModule($sct, $mod, $act);
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Initialize module.
	 *
	 * @param string $sct section name
	 * @param string $mod module name
	 * @param string $act action
	 * @param string $req request
	 * @return mixed result
	 */
	public function rwInitModule($sct, $mod, $act, $req=NULL)
	{
		/**
		 * Module path.
		 */
		$modPath = _APP_MOD_DIR.$sct.'/';
		/**
		 * Check if requested section exists.
		 */
		if (!is_readable($modPath))
		{
			/**
			 * Show error message.
			 */
			trigger_error('Section:::NO_DIR:::'.$sct, 256);
			/**
			 * Stop execution.
			 */
			exit;
		}
		/**
		 * Module file.
		 */
		$modFile = $modPath.$mod.'.mod.php';
		/**
		 * Check if requested module exists.
		 */
		if (!is_readable($modFile))
		{
			/**
			 * Show error message.
			 */
			trigger_error('Module:::NO_FILE:::'.$mod, 256);
			/**
			 * Stop execution.
			 */
			exit;
		}
		/**
		 * Load module library.
		 */
		require_once(_CORE_LIB_DIR.'mod/mod.lib.php');
		/**
		 * Load module.
		 */
		require_once($modFile);
		/**
		 * Set module information.
		 *
		 * This is required and also a little tricky
		 * because of the way we handle errors
		 * (trying to display them nicely using a custom error module).
		 */
		$this->modAbout = (is_array($this->modAbout) && array_key_exists($mod, $this->modAbout)) ? $this->modAbout : $modAbout;
		/**
		 * Set module location.
		 *
		 * This is required and also a little tricky
		 * because of the way we handle errors
		 * (trying to display them nicely using a custom error module).
		 */
		$this->modLocation = (is_array($_GET) && array_key_exists('location', $_GET)) ? $_GET['location'] : $this->modLocation;
		/**
		 * Set module request.
		 *
		 * This is required and also a little tricky
		 * because of the way we handle errors
		 * (trying to display them nicely using a custom error module).
		 */
		$this->modRequest = (is_array($_GET) && array_key_exists('query', $_GET)) ? $_GET['query'] : $this->modRequest;
		/**
		 * Check library dependencies.
		 */
		$missingLibDeps = $this->_rwDepLib($this->modAbout[$mod]['deps']['lib']);
		/**
		 * Check missing dependencies.
		 */
		if ($missingLibDeps)
		{
			/**
			 * Set missing dependencies list.
			 */
			$missingDeps = implode(', ', $missingLibDeps);
			/**
			 * Show error message.
			 */
			trigger_error('Module:::NO_LIB_DEP:::'.$mod.':::'.$missingDeps, 256);
		}
		/**
		 * Check extension dependencies.
		 */
		$missingExtDeps = $this->_rwDepExt($this->modAbout[$mod]['deps']['ext']);
		/**
		 * Check missing dependencies.
		 */
		if ($missingExtDeps)
		{
			/**
			 * Set missing dependencies list.
			 */
			$missingDeps = implode(', ', $missingExtDeps);
			/**
			 * Show error message.
			 */
			trigger_error('Module:::NO_EXT_DEP:::'.$mod.':::'.$missingDeps, 256);
		}
		/**
		 * Check module dependencies.
		 */
		$missingModDeps = $this->_rwDepMod($this->modAbout[$mod]['deps']['mod']);
		/**
		 * Check missing dependencies.
		 */
		if ($missingModDeps)
		{
			/**
			 * Set missing dependencies list.
			 */
			$missingDeps = implode(', ', $missingModDeps);
			/**
			 * Show error message.
			 */
			trigger_error('Module:::NO_MOD_DEP:::'.$mod.':::'.$missingDeps, 256);
		}
		/**
		 * Check if geo extension is loaded.
		 */
		if ($this->rwLoadedExt('Geo'))
		{
			/**
			 * Add module translation list to main translation list.
			 */
			$this->rwAddLang($this->rwExts['Geo']->setLangMod($sct, $mod));
		}
		/**
		 * Set module class name.
		 */
		$modClass = 'rw_Module_'.$mod;
		/**
		 * Load module.
		 *
		 * Needs about array, core object, location string and request query string.
		 * Filtering is already done at this point,
		 * so we can pass $_GET['query'] directly.
		 */
		$modObj = new $modClass($this->modAbout[$mod], $this, $this->modLocation, $this->modRequest);
		/**
		 * Check if action is a reserved method.
		 *
		 * Actually this is not really necessary,
		 * as request filtering prevents "_" character to appear in action name.
		 * But the filtering method might change in the future,
		 * and we don't want to open a security hole.
		 */
		if (preg_match("/^[_]{1,2}/", $act))
		{
			/**
			 * Show error message.
			 */
			trigger_error('Module:::NO_ACT', 256);
		}
		/**
		 * Check if action really exists and is callable.
		 */
		if(!method_exists($modObj, $act) || !is_callable(array($modObj, $act)))
		{
			/**
			 * Show error message.
			 */
			trigger_error('Module:::NO_ACT_FOUND', 256);
		}
		/**
		 * $_GET is not needed from now on,
		 * so we unset it for security reasons.
		 */
		$_GET = array();
		/**
		 * If we got so far, everything must be ok.
		 * Call requested action.
		 */
		$modObj->$act($req);
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Check if a library is loaded.
	 *
	 * @param string $libObj library object name
	 *
	 * @return boolean result
	 */
	private function _rwLoadedLib($libObj)
	{
		/**
		 * Check if library is already loaded.
		 */
		if ($this->$libObj)
		{
			/**
			 * return result.
			 */
			return TRUE;
		}
		/**
		 * Return result.
		 */
		return FALSE;
	}

	/**
	 * Check if an extension is loaded.
	 *
	 * @param string $ext extension name
	 *
	 * @return boolean result
	 */
	public function rwLoadedExt($ext)
	{
		/**
		 * Check if extension is already loaded.
		 */
		if (array_key_exists($ext, $this->rwExts))
		{
			/**
			 * return result.
			 */
			return TRUE;
		}
		/**
		 * Return result.
		 */
		return FALSE;
	}

	/**
	 * Check for missing library dependencies.
	 *
	 * This method returns FALSE if there are no missing dependencies,
	 * or an array containing the dependencies that are missing otherwise.
	 *
	 * @param array $deps list of dependencies to be checked.
	 * @return boolean result
	 */
	private function _rwDepLib($deps)
	{
		/**
		 * Init missing library deps list.
		 */
		$missingDeps = array();
		/**
		 * Check if we have library dependencies to check.
		 */
		if (count($deps > 0))
		{
			/**
			 * Check each dependency.
			 */
			foreach($deps as $dep)
			{
				/**
				 * Parse dependency name.
				 */
				$dep = ucfirst(strtolower($dep));
				/**
				 * Check if library is user loadable.
				 */
				if (array_key_exists($dep, $this->rwLibs))
				{
					/**
					 * Set library object name.
					 */
					$libObj = 'rw'.ucfirst(strtolower($this->rwLibs[$dep]));
					/**
					 * Check if library is loaded.
					 */
					if (!$this->$libObj)
					{
						/**
						 * Add to missing dependency list.
						 */
						$missingDeps[] = $dep;
					}
				}
				/**
				 * Library is not loadable
				 */
				else
				{
					/**
					 * Add to missing dependency list.
					 */
					$missingDeps[] = $dep;
				}
			}
		}
		/**
		 * Return result.
		 */
		return (count($missingDeps) > 0) ? $missingDeps : FALSE;
	}

	/**
	 * Check for missing extension dependencies.
	 *
	 * This method returns FALSE if there are no missing dependencies,
	 * or an array containing the dependencies that are missing otherwise.
	 *
	 * @param array $deps list of dependencies to be checked.
	 * @return boolean result
	 */
	private function _rwDepExt($deps)
	{
		/**
		 * Init missing library deps list.
		 */
		$missingDeps = array();
		/**
		 * Check if we have extension dependencies to check.
		 */
		if (count($deps > 0))
		{
			/**
			 * Check each dependency.
			 */
			foreach($deps as $dep)
			{
				/**
				 * Parse dependency name.
				 */
				$dep = ucfirst(strtolower($dep));
				/**
				 * Check if extension is loaded.
				 */
				if (!array_key_exists($dep, $this->rwExts))
				{
					/**
					 * Add to missing dependency list.
					 */
					$missingDeps[] = $dep;
				}
			}
		}
		/**
		 * Return result.
		 */
		return (count($missingDeps) > 0) ? $missingDeps : FALSE;
	}

	/**
	 * Check for missing module dependencies.
	 *
	 * This method returns FALSE if there are no missing dependencies,
	 * or an array containing the dependencies that are missing otherwise.
	 *
	 * @param array $deps list of dependencies to be checked.
	 * @return boolean result
	 */
	private function _rwDepMod($deps)
	{
		/**
		 * Init missing library deps list.
		 */
		$missingDeps = array();
		/**
		 * Check if we have module dependencies to check.
		 */
		if (count($deps > 0))
		{
			/**
			 * Check each dependency.
			 */
			foreach($deps as $dep)
			{
				/**
				 * Check if module exists.
				 */
				if (!is_readable(_APP_MOD_DIR.$dep.'.mod.php'))
				{
					/**
					 * Add to missing dependency list.
					 */
					$missingDeps[] = $dep;
				}
			}
		}
		/**
		 * Return result.
		 */
		return (count($missingDeps) > 0) ? $missingDeps : FALSE;
	}

	/**
	 * Open URL handle.
	 *
	 * @param string $url url
	 * @param array $p post data
	 */
	private function _rwWget($url, $p=array())
	{
		/**
		 * Initialize headers.
		 */
		$h = array();
		/**
		 * Set user agent header.
		 */
		$h['User-Agent'] = 'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2.2) Gecko/20100316 Firefox/3.6.2 GTB6 (.NET CLR 3.5.30729)';
		/**
		 * Set referer header.
		 */
		$h['Referer'] = _APP_WWW;
		/**
		 * Set accept encoding header.
		 */
		$h['Accept-Encoding'] = 'x-compress; x-zip';
		/**
		 * Parse url.
		 */
		preg_match("~([a-z]*://)?([^:^/]*)(:([0-9]{1,5}))?(/.*)?~i", $url, $matches);
		/**
		 * Get protocol.
		 */
		$protocol = $matches[1];
		/**
		 * Get server.
		 */
		$server = $matches[2];
		/**
		 * Get port.
		 */
		$port = ($matches[4] != '') ? $matches[4] : '80';
		/**
		 * Get path.
		 */
		$path = ($matches[5] != '') ? $matches[5] : '/';
		/**
		 * Initialize socket.
		 */
		$socket = false;
		/**
		 * Open socket.
		 */
		$socket = fsockopen($server, $port);
		/**
		 * Check if socket was opened successfully.
		 */
		if (!$socket)
		{
			/**
			 * Return result.
			 */
			return FALSE;
		}
		/**
		 * Set host header.
		 */
		$h['Host'] = $server;
		/**
		 * Set request.
		 */
		$request = (count($p) > 0) ? "POST $path HTTP/1.0\r\n" : "GET $path HTTP/1.0\r\n";
		/**
		 * Send request.
		 */
		fwrite($socket, $request);
		/**
		 * Check if we have post data.
		 */
		if (count($p) > 0)
		{
			/**
			 * Init post string data.
			 */
			$ps = array();
			/**
			 * Parse post array.
			 */
			foreach ($p as $key => $value)
			{
				/**
				 * Set post string data.
				 */
				$ps[] = "$key=$value";
			}
			/**
			 * Set post request string.
			 */
			$post = implode('&', $ps);
			/**
			 * Set content type header.
			 */
			$h['Content-Type'] = 'application/x-www-form-urlencoded';
			/**
			 * Set content length header.
			 */
			$h['Content-Length'] = strlen($post);
		}
		/**
		 * Parse header data.
		 */
		foreach ($h as $key => $value)
		{
			/**
			 * Send headers.
			 */
			fwrite($socket, "$key: $value\r\n");
		}
		/**
		 * Send newline.
		 */
		fwrite($socket, "\r\n");
		/**
		 * Check if he have post data.
		 */
		if (count($p) > 0)
		{
			/**
			 * Send post request string.
			 */
			fwrite($socket, $post."\r\n");
		}
		/**
		 * Get response.
		 */
		$line = fgets($socket, 1000);
		/**
		 * Get status.
		 */
		$status = substr($line,9,3);
		/**
		 * ???
		 */
		while (trim($line = fgets($socket, 1000)) != ""){
			/**
			 * ???
			 */
			if ($status=="401" && strpos($line,"WWW-Authenticate: Basic realm=\"")===0) {
				/**
				 * Close socket
				 */
				fclose($socket);
				/**
				 * Return result.
				 */
				return FALSE;
			}
		}
		/**
		 * Return result.
		 */
		return $socket;
	}

	/**
	 * Check license problems.
	 *
	 * @return mixed result
	 */
	private function _rwLicCheck()
	{
		/**
		 * Initialize license info.
		 */
		$l = $this->_rwLicInfo();
		/**
		 * Check if license status file is readable or license update request is made.
		 */
		if (is_readable($l['path']) || (isset($_GET['section']) && ($_GET['section'] == 'LicUpd')))
		{
			/**
			 * Update license information.
			 */
			return $this->_rwLicUpd($l);
		}
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Initialize license information.
	 *
	 * @return mixed result
	 */
	private function _rwLicInfo()
	{
		/**
		 * Initialize license info.
		 */
		$l = array();
		/**
		 * Set license CN
		 */
		$l['cn'] = rtrim(str_replace(array('http://', 'www.'), '', _APP_WWW), '/');
		/**
		 * Set licence key.
		 */
		$l['key'] = substr(md5($l['cn']), 0, 26);
		/**
		 * Set raw directory.
		 */
		$rawDir = session_save_path();
		/**
		 * Set directory.
		 */
		$l['dir'] = (FALSE !== strpos($rawDir, ';')) ? rtrim((substr($rawDir, strpos($rawDir, ";") + 1)), '/') : rtrim($rawDir, '/');
		/**
		 * Set license path.
		 */
		$l['path'] = $l['dir'].'/sess_'.$l['key'];
		/**
		 * Return result.
		 */
		return $l;
	}

	/**
	 * Get license data.
	 *
	 * @param array $l license info
	 * @param string $r request type
	 * @return mixed result
	 */
	private function _rwLicGet($l, $r)
	{
		/**
		 * Get private key.
		 */
		$pk = openssl_pkey_get_private(file_get_contents(_APP_DIR.'etc/'.$l['cn'].'.key'));
		/**
		 * Generate signature.
		 */
		openssl_sign($l['cn'], $s, $pk, OPENSSL_ALGO_SHA1);
		/**
		 * Set post data signature.
		 */
		$p['s'] = rawurlencode(base64_encode($s));
		/**
		 * Release private key.
		 */
		openssl_free_key($pk);
		/**
		 * Set post data request.
		 */
		$p['r'] = $r;
		/**
		 * Set post data CN.
		 */
		$p['cn'] = $l['cn'];
		/**
		 * Open encrypted license file handle.
		 */
		$efile = $this->_rwWget('http://clients.rudisoft.net/lu', $p);
		/**
		 * Get encrypted license string.
		 */
		$estring = fgets($efile, 1024);
		/**
		 * Close encrypted file handle.
		 */
		fclose($efile);
		/**
		 * Return result.
		 */
		return $estring;
	}

	/**
	 * Update license information.
	 *
	 * @param array $l license information
	 * @return mixed result
	 */
	private function _rwLicUpd($l)
	{
		/**
		 * Get encrypted license string.
		 */
		$s = $this->_rwLicGet($l, 'a8ee21598ca7cefa744e25f401aae48130b99afd');
		/**
		 * Get encrypted license key.
		 */
		$k = $this->_rwLicGet($l, '170f27a90290081cdedf11e3c87e3abe90592e49');
		/**
		 * Get private key.
		 */
		$pk = openssl_pkey_get_private(file_get_contents(_APP_DIR.'etc/'.$l['cn'].'.key'));
		/**
		 * Init decrypted license.
		 */
		$dec = NULL;
		/**
		 * Decrypt license info.
		 */
		openssl_open(base64_decode($s), $dec, base64_decode($k), $pk);
		/**
		 * Release private key.
		 */
		openssl_free_key($pk);
		/**
		 * Parse license data.
		 */
		$lic = @simplexml_load_string($dec);
		/**
		 * Get license status.
		 */
		$lstatus  = ($lic) ? (string) $lic->license[0]->status[0] : NULL;
		/**
		 * Check license status.
		 */
		if($lstatus != 'ok')
		{
			/**
			 * Create license status file with dummy content.
			 */
			file_put_contents($l['path'], $l['key'].' '.$lstatus);
			/**
			 * Trigger error.
			 */
			trigger_error('License:::LICENSE_PROBLEM', 256);
			/**
			 * Stop execution.
			 */
			exit;
		}
		/**
		 * Check if license status file exists.
		 */
		if (is_readable($l['path']))
		{
			/**
			 * Delete license status file.
			 */
			unlink($l['path']);
		}
		/**
		 * Redirect to application root.
		 */
		header("Location: "._APP_WWW);
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Set translation list.
	 *
	 * @param array $rwLang new translation list.
	 * @return mixed result
	 */
	public function rwSetLang($rwLang)
	{
		/**
		 * Set translation list.
		 */
		$this->rwLang = $rwLang;
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Add a translation list to main translation list.
	 *
	 * @param array $rwLang new translation list
	 * @return mixed result
	 */
	public function rwAddLang($rwLang)
	{
		/**
		 * Add translation list to main translation list.
		 */
		$this->rwLang = array_merge($this->rwLang, $rwLang);
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Return partial or complete translation list.
	 *
	 * @param string $l1 level1 key
	 * @param string $l2 level2 key
	 * @return mixed result
	 */
	public function rwGetLang($l1=NULL, $l2=NULL)
	{
		/**
		 * Init new translation list.
		 */
		$lang = array();
		/**
		 * Check for level1 key.
		 */
		if($l1 && array_key_exists($l1, $this->rwLang))
		{
			/**
			 * Set translation list to level1 key.
			 */
			$lang = $this->rwLang[$l1];
			/**
			 * Check for level2 key.
			 */
			if($l2 && array_key_exists($l2, $lang))
			{
				/**
				 * Set translation list to level2 key.
				 */
				$lang = $lang[$l2];
			}
		}
		/**
		 * No level1 key.
		 */
		else
		{
			/**
			 * Set translation list to complete list.
			 */
			$lang = $this->rwLang;
		}
		/**
		 * Return translation list.
		 */
		return $lang;
	}
}
?>