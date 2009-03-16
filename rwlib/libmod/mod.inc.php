<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Module building classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-09 15:43:00
 * @access     public
 * @package    RudWEb
 * @subpackage Modules
 * @todo       stuff
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
 * Prevent direct file access
 */
if(!defined('_RW_VALID')) {require_once('./index.php'); exit;}

/**
 * rw_iMod
 *
 * Methods to be implemented by all module classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Modules
 */
interface rw_iMod
{
	/**
	 * Method for displaying information about the module
	 *
	 * @return mixed information about the module
	 */
	public function modAbout();
	/**
	 * Default module functionality
	 */
	public function _default();
}
/**
 * rw_Mod_global
 *
 * Global values and methods for all module classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Modules
 */
class rw_Mod_global
{
	/**
	 * Set module info
	 *
	 * @var array
	 */
	public $modAbout = array();
	/**
	 * Application core object
	 *
	 * @var mixed
	 */
	public $modAppCore = NULL;
	/**
	 * Internationalization
	 *
	 * @var array
	 */
	public $modLang = array();
	/**
	 * Database connection
	 *
	 * @var mixed
	 */
	public $modDb = NULL;
	/**
	 * Default content values
	 *
	 * @var array
	 */
	public $modCnt = array();
	/**
	 * Load the module
	 *
	 * @param mixed $appCore Application core object
	 * @return mixed result of loading
	 */
	public function __construct($modAbout, $modCnt, $appCore)
	{
		$this->modAbout = $modAbout;
		$this->modAppCore = $appCore;
		$this->modLang = $this->modAppCore->rwLang();
		$this->modDb = $this->modAppCore->rwDb();
		/**
		 * Default values.
		 * These can be overridden by modules
		 */
		$cnt1['type'] = 'text';
		$cnt1['skin'] = array();
		$cnt1['skin']['title'] = $this->modLang['MOD']['TITLE'];
		$cnt1['skin']['meta'] = array();
		$cnt1['skin']['meta']['subject'] = _APP_NAME;
		$cnt1['skin']['meta']['description'] = _APP_NAME;
		$cnt1['skin']['meta']['keywords'] = _APP_NAME;
		$cnt1['skin']['meta']['copyright'] = _APP_AUTH;
		$cnt1['skin']['meta']['designer'] = _APP_AUTH;
		$cnt1['skin']['meta']['publisher'] = _APP_AUTH;
		$cnt1['skin']['meta']['author'] = _APP_AUTH;
		$cnt1['skin']['lang'] = $this->modLang;
		$cnt1['cnt'] = array();
		/**
		 * Join with values from module.
		 */
		$cnt = array_merge($cnt1, $modCnt);
		$cnt['skin'] = array_merge($cnt1['skin'], $modCnt['skin']);
		$cnt['skin']['meta'] = array_merge($cnt1['skin']['meta'], $modCnt['skin']['meta']);
		$cnt['cnt']  = array_merge($cnt1['cnt'], $modCnt['cnt']);
		/**
		 * Set default values
		 */
		$this->modCnt = $cnt;
	}
	/**
	 * Method for displaying information about the module
	 *
	 * @return mixed information about the module
	 */
	public function modAbout()
	{
		return $this->modAbout;
	}
}
?>