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
	 * User loadable libraries.
	 *
	 * Format: name => object.
	 *
	 * @var array
	 */
	public $rwLibs = array();

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
			$libPath = _RW_DIR_LIB.$this->rwLibs[$lib].'/'.$this->rwLibs[$lib].'.inc.php';
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
					 * Show error message.
					 */
					trigger_error('Library::Library <b>'.$lib.'</b> is already loaded.', 256);
					/**
					 * Stop execution.
					 */
					exit;
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
							require_once(_RW_DIR_LIB.$this->rwLibs[$lib].'/'.$this->rwLibs[$lib].'.'._APP_DB_TYPE.'.inc.php');
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
						trigger_error('Database::Database type <b>' . _APP_DB_TYPE . '</b> not supported.', 256);
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
				trigger_error('Engine::Requested library <b>'.$lib.'</b> does not exist.', 256);
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
			trigger_error('Engine::Requested library <b>'.$lib.'</b> does not exist or is not loadable.', 256);
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
		 * Check if library is aleady loaded.
		 */
		if($this->_rwLoadedExt($ext))
		{
			/**
			 * Show error message.
			 */
			trigger_error('Extension::Extension <b>'.$ext.'</b> is already loaded.', 256);
			/**
			 * Stop execution.
			 */
			exit;
		}
		/**
		 * Load extension library.
		 */
		require_once(_RW_DIR_LIB.'ext/ext.inc.php');
		/**
		 * Search in local extension dir.
		 */
		if (is_readable(_APP_DIR.'ext/'.$ext.'.ext.php'))
		{
			/**
			 * Load local extension.
			 */
			require_once(_APP_DIR.'ext/'.$ext.'.ext.php');
		}
		/**
		 * Search in global extension dir.
		 */
		else if (is_readable(_RW_DIR.'ext/'.$ext.'.ext.php'))
		{
			/**
			 * Load local extension.
			 */
			require_once(_RW_DIR.'ext/'.$ext.'.ext.php');
		}
		/**
		 * Extension not found.
		 */
		else
		{
			/**
			 * Show error message.
			 */
			trigger_error('Engine::Extension <b>'.$ext.'</b> not found.');
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
			$missingDeps = implode (', ', $missingLibDeps);
			/**
			 * Show error message.
			 */
			trigger_error('Extension::Extension <b>'.$ext.'</b> can not be loaded. Missing library dependencies (<b>'.$missingDeps.'</b>)', 256);
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
			$missingDeps = implode (', ', $missingExtDeps);
			/**
			 * Show error message.
			 */
			trigger_error('Extension::Extension <b>'.$ext.'</b> can not be loaded. Missing library dependencies (<b>'.$missingDeps.'</b>)', 256);
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
	private function _rwLoadedExt($ext)
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
					 * Check if library is laoded.
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
}
?>