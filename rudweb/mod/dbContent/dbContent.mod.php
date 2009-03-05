<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Database Content Display module
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-03-05 15:13:00
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
 * Module class
 *
 */
class rw_Mod_dbContent extends rw_Mod_global implements rw_iMod
{
	/**
	 * Constructor
	 *
	 * Set module information and call parent constructor
	 *
	 * @param mixed $appCore core object
	 * @return mixed result
	 */
	public function __construct($appCore)
	{
		/**
		 * Module information
		 */
		$about['name'] = 'dbContent';
		$about['desc'] = 'Database Content Display Module';
		$about['ver']  = '$Revision$';
		$about['auth'] = 'Radu Maier';
		$about['web']  = 'http://www.rudisoft.net';
		$about['mail'] = 'rudisoft@rudisoft.net';
		$about['deps'] = array();
		$about['deps']['cfg']   = array();
		$about['deps']['cfg'][] = 'Database';
		$about['deps']['cfg'][] = 'Sessions';
		//$about['deps']['cfg'][] = 'Users';
		$about['deps']['ext']   = array();
		$about['deps']['ext'][] = 'Sessions';
		//$about['deps']['ext'][] = 'Users';
		$about['deps']['mod']   = array();
		/**
		 * Module default content
		 *
		 * $cnt['type'] added by default in parent class
		 * $cnt['skin']['dir'] added by default in parent class
     * $cnt['skin']['tpl'] added by default in parent class
		 * $cnt['skin']['title'] added by default in parent class
		 * $cnt['skin']['meta'] added by default in parent class
		 * $cnt['skin']['lang'] added by default in parent class
		 */
		$cnt['cnt'][0]['dir'] = 'content';
		$cnt['cnt'][0]['tpl'] = 'blank';
		$cnt['cnt'][0]['content'] = array();
		/**
		 * Call parent constructor
		 */
		parent::__construct($about, $cnt, $appCore);
	}
	/**
	 * Default module functionality
	 *
	 * @return mixed result
	 */
	public function _default()
	{
		return $this->modCnt;
	}
	public function pageDisplay()
	{
		/**
		 * Get page id
		 */
		$pg_id = (isset($_GET['id']) && $this->modAppCore->rwCheckInt($_GET['id'])) ? $_GET['id'] : NULL;
		if(!$pg_id)
		{
			return FALSE;
		}
		/**
		 * Check page
		 */
		$rs = $this->modDb->dbSelect("pg_title, pg_kw, pg_dsc, pg_template", _APP_PRE.'_web_pages', "pg_id = '{$pg_id}' AND pg_ln = '{$_SESSION[_APP_PRE.'_usr_lang']}' AND pg_deleted = '0'", NULL, 1);
		$t = $rs->dbNumRows();
		if($t != 1)
		{
			return FALSE;
		}
		$r = $rs->dbFetchArray();
		/**
		 * Set page template vars
		 */
		$this->modCnt['skin']['tpl'] = $r['pg_template'];
		$this->modCnt['skin']['title'] = $r['pg_title'];
		$this->modCnt['skin']['meta']['subject'] = $r['pg_dsc'] != '' ? $r['pg_dsc'] : $this->modCnt['skin']['meta']['subject'];
		$this->modCnt['skin']['meta']['description'] = $r['pg_dsc'] != '' ? $r['pg_dsc'] : $this->modCnt['skin']['meta']['description'];
		$this->modCnt['skin']['meta']['keywords'] = $r['pg_kw'] != '' ? $r['pg_kw'] : $this->modCnt['skin']['meta']['keywords'];
		/**
		 * Set content template vars
		 */
		//XXX
		return $this->modCnt;
	}
}
?>