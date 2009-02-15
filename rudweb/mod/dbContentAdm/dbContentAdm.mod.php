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
		/**
		 * Module default content
		 *
		 * $cnt['type'] added by default in parent class
		 * $cnt['skin']['title'] added by default in parent class
		 * $cnt['skin']['lang'] added by default in parent class
		 */
		$cnt['skin']['dir'] = 'admin';
		$cnt['skin']['tpl'] = 'layout';
		$cnt['cnt']['dir'] = 'content';
		$cnt['cnt']['tpl'] = 'blank';
		$cnt['cnt']['content'] = array();
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
		if(!$_SESSION[_APP_PRE.'_auth'])
		{
			/**
			 * User is not logged in
			 */
			return $this->login();
		}
		else if($_SESSION[_APP_PRE.'_usr_lvl'] < 3)
		{
			/**
			 * User doesn't have proper credentials
			 */
			trigger_error('denied', E_USER_ERROR);
		}
		else
		{
			/**
			 * Everything is ok
			 */
			trigger_error('now what?', E_USER_ERROR);
		}
	}
	/**
	 * Login method
	 *
	 * @return mixed modCnt content
	 */
	public function login()
	{
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . __FUNCTION__;
		$this->modCnt['cnt']['tpl'] = 'login';
		$cnt['cnt']['content']['usr_status'] = $this->modAppCore->usr_status;
		return $this->modCnt;
		//XXX
	}
	/**
	 * Test administration menu
	 */
	public function menu()
	{
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . __FUNCTION__;
		$this->modCnt['cnt']['tpl'] = 'test';
		$this->modCnt['cnt']['content']['menu'] = array();

		if($this->modDb)
		{
			$menu = $this->_pagesMenu();
			$this->modCnt['cnt']['content']['menu'] = $menu;
		}

		return $this->modCnt;
	}
	/**
	 * Pages menu test
	 */
	public function _pagesMenu($parent=0)
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

				$menu .= $this->_pagesMenu($r['pg_id']);
				$menu .= '</li>';
			}
			$menu .= '<li><a href="new">'.'[new]'.'</a></li>';
			$menu .= '</ul>';
		}

		return $menu;
	}
	
	public function captcha()
	{
	if(isset($_SESSION[_APP_PRE.'_token']))
    {
      $captchaObj = $this->modAppCore->rwActivateExt($this->modAppCore->ext, 'Captcha');
      $this->modCnt = array();
      $this->modCnt['type'] = 'image';
      $this->modCnt['image'] = $captchaObj->display(); 
    	
    	return $this->modCnt;  
    }
	}
}
?>