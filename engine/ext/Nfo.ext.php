<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Misc information.
 * <BR>This is the first standalone extension ever!
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-04-06 16:16
 * @access     public
 * @package    rwExt
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
 * Extension name.
 */
$extAbout['Nfo']['name'] = 'Nfo';
/**
 * Extension description.
 */
$extAbout['Nfo']['desc'] = 'Misc information.';
/**
 * Extension version.
 */
$extAbout['Nfo']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Nfo']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Nfo']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Nfo']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Nfo']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Nfo']['deps']['lib'] = array();
/**
 * Extension extension dependencies.
 */
$extAbout['Nfo']['deps']['ext'] = array();

/**
 * rw_Extension_Nfo.
 *
 * rw_Extension_Nfo extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Nfo extends rw_Extension implements rw_iExtension
{
	/**
	 * Server info.
	 *
	 * @var array
	 */
	private $server = array();

	/**
	 * Constructor.
	 *
	 * @param array $extAbout
	 * @return mixed result
	 */
	public function __construct($extAbout)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($extAbout);
	}

	/**
	 * PHPInfo() method
	 *
	 * @return mixed result.
	 */
	public function nfoPhpInfo()
	{
		/**
		 * Check if function is available.
		 */
		if (!function_exists('phpinfo'))
		{
			/**
			 * Return result.
			 */
			return FALSE;
		}
		/**
		 * Start buffer.
		 */
		ob_start();
		/**
		 * Call function.
		 */
		phpinfo();
		/**
		 * Get function output.
		 */
		$php_info = ob_get_contents();
		/**
		 * End buffer.
		 */
		ob_end_clean();
		/**
		 * Parse function output.
		 */
		$php_info = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $php_info);
		/**
		 * Return output.
		 */
		return $php_info;
	}

	/**
	 * General PHP information method.
	 *
	 * @return mixed result.
	 */
	public function nfoPhpNfo()
	{
		/**
		 * Init.
		 */
		$php = array();
		/**
		 * PHP Version
		 */
		$php['version']          = (function_exists('phpversion')) ? phpversion() : PHP_VERSION;
		/**
		 * Server interface.
		 */
		$php['interdace']       = (function_exists('php_sapi_name')) ? php_sapi_name() : PHP_SAPI;
		/**
		 * Short open tag.
		 */
		$php['short_open_tag']   = (function_exists('ini_get')) ? (int) ini_get('short_open_tag') : FALSE;
		/**
		 * Safe mode.
		 */
		$php['safe_mode']        = (function_exists('ini_get')) ? (int) ini_get('safe_mode') : FALSE;
		/**
		 * Register globals.
		 */
		$php['register_globals'] = (function_exists('ini_get')) ? (int) ini_get('register_globals') : FALSE;
		/**
		 * Magic quotes.
		 */
		$php['magic_quotes_gpg'] = (function_exists('ini_get')) ? (int) ini_get('magic_quotes_gpg') : FALSE;
		/**
		 * File uploads.
		 */
		$php['file_uploads']     = (function_exists('ini_get')) ? (int) ini_get('file_uploads') : FALSE;
		/**
		 * Allow URL fopen.
		 */
		$php['allow_url_fopen']  = (function_exists('ini_get')) ? (int) ini_get('allow_url_fopen') : FALSE;
		/**
		 * Return result.
		 */
		return $php;
	}

	/**
	 * Loaded PHP extensions method.
	 *
	 * @return mixed result.
	 */
	public function nfoPhpExt()
	{
		/**
		 * Check if method is available.
		 */
		if(!function_exists('get_loaded_extensions'))
		{
			/**
			 * Return result.
			 */
			return array();
		}
		/**
		 * Get loaded extensions.
		 */
		$ext = get_loaded_extensions();
		/**
		 * Sort them by name
		 */
		sort($ext);
		/**
		 * Get additional extesnsion information.
		 */
		$ext = $this->_nfoPhpExtInfo($ext);
		/**
		 * Return result.
		 */
		return $ext;
	}

	/**
	 * Get additional extension information.
	 *
	 * @param array $e extensions array.
	 */
	private function _nfoPhpExtInfo($e)
	{
		/**
		 * Init.
		 */
		$ext = array();
		/**
		 * Parse extension list.
		 */
		foreach ($e as $id => $name)
		{
			/**
			 * Check each name.
			 */
			switch($name)
			{
				/**
				 * GD.
				 */
				case 'gd' : {
					/**
					 * Set array item.
					 */
					$ext[$name] = function_exists('gd_info') ? gd_info() : TRUE;
					/**
					 * Stop execution.
					 */
					break;
				}
				/**
				 * Default.
				 */
				default : {
					/**
					 * Set array item.
					 */
					$ext[$name] = TRUE;
					/**
					 * Stop execution.
					 */
					break;
				}
			}
		}
		/**
		 * Return result.
		 */
		return $ext;
	}

	/**
	 * PHP settings method.
	 *
	 * @return mixed result.
	 */
	public function nfoPhpIni()
	{
		/**
		 * Check if method is available.
		 */
		if (!function_exists('ini_get_all'))
		{
			/**
			 * Return result.
			 */
			return array();
		}
		/**
		 * Return result.
		 */
		return ini_get_all();
	}

	/**
	 * Server information method.
	 *
	 * @return mixed result
	 */
	public function nfoServerNfo()
	{
		/**
		 * Init.
		 */
		$server = NULL;
		/**
		 * Check for apache in server info.
		 */
		if (isset($_SERVER['SERVER_SOFTWARE']) && (preg_match("/Apache\/[0-9.+]{1,10}/", $_SERVER['SERVER_SOFTWARE'], $server_raw)))
		{
			/**
			 * Split string
			 */
			$server_split = explode('/', $server_raw[0]);
			/**
			 * Server name.
			 */
			$server['name'] = $server_split[0];
			/**
			 * Server version.
			 */
			$server['version'] = $server_split[1];
		}
		/**
		 * Check for apache my function.
		 */
		else if (function_exists('apache_get_version'))
		{
			/**
			 * Server name.
			 */
			$server['name'] = 'Apache';
			/**
			 * Server version.
			 */
			$server['version'] = apache_get_version();
		}
		/**
		 * Apache not found
		 */
		else
		{
			/**
			 * Server name.
			 */
			$server['name'] = 'n/a';
			/**
			 * Server version.
			 */
			$server['version'] = 'n/a';
		}
		/**
		 * Set server.
		 */
		$this->server = $server;
		/**
		 * Return result.
		 */
		return $server;
	}

	/**
	 * Server modules information.
	 *
	 * This HAS to be called after nfoServerNfo()
	 *
	 * @return mixed result.
	 */
	public function nfoServerModules()
	{
		/**
		 * Check if method is available.
		 */
		if (!function_exists('apache_get_modules'))
		{
			/**
			 * Return result.
			 */
			return array();
		}
		/**
		 * Return result.
		 */
		return apache_get_modules();
	}

	/**
	 * Server information.
	 */
	public function nfoServerInfo()
	{
		/**
		 * Return result.
		 */
		return $_SERVER;
	}

	/**
	 * OS Information.
	 */
	public function nfoOsNfo()
	{
		/**
		 * Init.
		 */
		$os = array();
		/**
		 * OS PHP was build on.
		 */
		$os['build'] = PHP_OS;
		/**
		 * OS Name.
		 */
		$os['os'] = function_exists('php_uname') ? php_uname('s') : 'n/a';
		/**
		 * Host.
		 */
		$os['host'] = function_exists('php_uname') ? php_uname('n') : 'n/a';
		/**
		 * Release.
		 */
		$os['release'] = function_exists('php_uname') ? php_uname('r') : 'n/a';
		/**
		 * Version
		 */
		$os['version'] = function_exists('php_uname') ? php_uname('v') : 'n/a';
		/**
		 * Machine type.
		 */
		$os['machine'] = function_exists('php_uname') ? php_uname('m') : 'n/a';
		/**
		 * Directory separator.
		 */
		$os['directory_separator'] = DIRECTORY_SEPARATOR;
		/**
		 * Path separator.
		 */
		$os['path_separator'] = PATH_SEPARATOR;
		/**
		 * Return result.
		 */
		return $os;
	}

	/**
	 * Filesystem information.
	 */
	public function nfoFsNfo()
	{
		/**
		 * Init.
		 */
		$fs = array();
		/**
		 * Current path.
		 */
		$fs['path']      = dirname(__FILE__);
		/**
		 * Total size.
		 */
		$fs['size']      = disk_total_space($fs['path']);
		/**
		 * Available.
		 */
		$fs['available'] = disk_free_space($fs['path']);
		/**
		 * Used.
		 */
		$fs['used']      = $fs['size'] - $fs['available'];
		/**
		 * Use.
		 */
		$fs['use']       = round(($fs['used'] * 100) / $fs['size'], 2);
		/**
		 * Return result.
		 */
		return $fs;
	}
}
?>