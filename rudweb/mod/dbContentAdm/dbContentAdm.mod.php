<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Database Content Administration Module
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-12 12:04:00
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

class rw_Mod_dbContentAdm extends rw_Mod_global implements rw_iMod
{
	/**
	 * Constructor
	 *
	 * Set module information and call parent constructor
	 */
	public function __construct($appCore)
	{
		/**
		 * Module information
		 */
		$about['name'] = 'dbContentAdm';
		$about['desc'] = 'Database Content Administration Module';
		$about['ver']  = '12:08 2009-02-12';
		$about['auth'] = 'Radu Maier';
		$about['web']  = 'http://www.rudisoft.net';
		$about['mail'] = 'rudisoft@rudisoft.net';
		$about['deps'] = array();
		$about['deps']['cfg']   = array();
		$about['deps']['cfg'][] = 'Database';
		$about['deps']['cfg'][] = 'Sessions';
		$about['deps']['cfg'][] = 'Users';
		$about['deps']['ext']   = array();
		$about['deps']['ext'][] = 'Sessions';
		$about['deps']['ext'][] = 'Users';
		$about['deps']['mod']   = array();
		parent::__construct($about, $appCore);
	}
	/**
	 * Default module functionality
	 *
	 * @return mixed result
	 */
	public function _default()
	{
		$cnt = array();

		$cnt['skin']['tpl'] = 'layout';
		$cnt['skin']['title'] = $this->modLang['MOD']['TITLE'];
		$cnt['skin']['lang'] = $this->modLang;

		$cnt['cnt']['dir'] = 'content';
		$cnt['cnt']['tpl'] = 'blank';
		$cnt['cnt']['content'] = array();

		return $cnt;
	}
	/**
	 * Test administration menu
	 */
	public function menu()
	{
		$cnt = array();

		$cnt['skin']['tpl'] = 'layout';
		$cnt['skin']['title'] = 'Database Content Administration - Menu';

		$cnt['cnt']['tpl'] = 'test';
		$cnt['cnt']['content'] = array();
		$cnt['cnt']['content']['menu'] = array();

		if($this->modDb)
		{
			$menu = $this->_pagesMenu2();
			$cnt['cnt']['content']['menu'] = $menu;
		}

		return $cnt;
	}
	/**
	 * menu test
	 */
	public function _pagesMenu2($parent=0)
	{
		$rs = $this->modDb->dbQuerySimpleSelect('*', 'rw_ws_pages', "pg_parent = $parent", 'pg_order ASC', NULL);
		$t = $rs->dbNumRows();

		$menu = '';

		if($t > 0)
		{
			$menu = '<ul>';
				
			while($r = $rs->dbFetchArray())
			{

				$menu .= '<li><a href="new">'.'[new]'.'</a></li>';
				$menu .= '<li><a href="'._APP_WWW.'module/dbContentAdm/action/modPage/id/'.$r['pg_id'].'">'.$r['pg_title'].'</a>';

				$menu .= $this->_pagesMenu2($r['pg_id']);
				$menu .= '</li>';
			}
			$menu .= '<li><a href="new">'.'[new]'.'</a></li>';
			$menu .= '</ul>';
		}

		return $menu;
	}
	/**
	 * Generate database pages menu
	 */
	private function _pagesMenu($parent=0)
	{
		$rs = $this->modDb->dbQuerySimpleSelect('*', 'rw_ws_pages', "pg_parent = $parent");
		$t = $rs->dbNumRows();

		$menu = array();
		for($i=0;$i<$t;$i++)
		{
			$r = $rs->dbFetchArray();

			$menu[$i]['pg_id'] = $r['pg_id'];
			$menu[$i]['pg_parent'] = $r['pg_parent'];
			$menu[$i]['pg_level'] = $r['pg_level'];
			$menu[$i]['pg_title'] = $r['pg_title'];

			$this->_pagesMenu($r['pg_id']);
		}
		return $menu;
	}
}
?>