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
		$auth = $this->_authVerify(3);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else
		{
			return $this->modCnt;
		}
	}
	public function pages()
	{
		$auth = $this->_authVerify(3);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else
		{
			/**
			 * Authorization ok, proceed.
			 */
			$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . __FUNCTION__;
			$this->modCnt['cnt']['tpl'] = 'pages';
			$this->modCnt['cnt']['content']['pages'] = $this->_pagesList();
			return $this->modCnt;
		}
	}
	/**
	 * Generate pages list for administration
	 */
	public function _pagesList($parent=0)
	{
		//XXX
		$rs = $this->modDb->dbSelect('*', _APP_PRE.'_web_pages', "pg_parent = $parent", 'pg_order ASC', NULL);
		$t = $rs->dbNumRows();

		$menu = '';

		if($t > 0)
		{
			//$menu = '<table border="1">';
			$menu = '';

			while($r = $rs->dbFetchArray())
			{

				//$menu .= '<li><a href="new">'.'[new]'.'</a></li>';
				//$menu .= '<li><a href="'._APP_WWW.'module/'.$this->modAbout['name'].'/action/modPage/id/'.$r['pg_id'].'">'.$r['pg_title'].'</a>';
				//$menu .= $this->_pagesList($r['pg_id']);
				//$menu .= '</li>';
				//XXX JavaScript Show/Hide around here
				$menu .= "\n".'<tr';
				if($r['pg_level'] > 0)
				{
					$menu .= ' title="'.$r['pg_title'].'"';
				}
				$menu .= '>';
				$menu .= '<td class="pages_cr">'.$r['pg_level'].'</td>';
				$menu .= '<td class="pages_cr_tt">';
				for($i=0;$i<$r['pg_level'];$i++)
				{
					$menu .= '&#160;&#160;&#160;';
				}
				$menu .= '&#160;';
				$menu .= $r['pg_title'].'</td>';
				$menu .= '<td class="pages_cr">'.$r['pg_template'] . '</td>';
				$menu .= '<td class="pages_cr">'.'&#160;'. '</td>';
				$menu .= '<td class="pages_cr">'.'&#160;'. '</td>';
				$menu .= '<td class="pages_cr">'.'&#160;'. '</td>';
				$menu .= '<td class="pages_cr">'.'&#160;'. '</td>';
				$menu .= '<td class="pages_cr">'.'&#160;'. '</td>';
				$menu .= '<td class="pages_cr">';
				$menu .= 'Move Hide Edit Delete';
				$menu .= '</td>';
				$menu .= '</tr>';
				$menu .= $this->_pagesList($r['pg_id']);
			}
			//$menu .= '<li><a href="new">'.'[new]'.'</a></li>';
			//$menu .= '</table>';
		}

		return $menu;
	}
	public function _pagesMenuOLD($parent=0)
	{
		$rs = $this->modDb->dbSelect('*', _APP_PRE.'_web_pages', "pg_parent = $parent", 'pg_order ASC', NULL);
		$t = $rs->dbNumRows();

		$menu = '';

		if($t > 0)
		{
			$menu = '<ul>';

			while($r = $rs->dbFetchArray())
			{

				$menu .= '<li><a href="new">'.'[new]'.'</a></li>';
				$menu .= '<li><a href="'._APP_WWW.'module/'.$this->modAbout['name'].'/action/modPage/id/'.$r['pg_id'].'">'.$r['pg_title'].'</a>';

				$menu .= $this->_pagesMenuOLD($r['pg_id']);
				$menu .= '</li>';
			}
			$menu .= '<li><a href="new">'.'[new]'.'</a></li>';
			$menu .= '</ul>';
		}

		return $menu;
	}
	/**
	 * Authorization verification
	 *
	 * @return mixed
	 */
	public function _authVerify($requiredLevel=0, $requiredGroup=NULL)
	{
		if(!$_SESSION[_APP_PRE.'_auth'])
		{
			/**
			 * User is not logged in
			 */
			return $this->_authLogin();
		}
		else
		{
			if($_SESSION[_APP_PRE.'_usr_lvl'] == 5)
			{
				/**
				 * User is root, total access
				 */
				return 'ok';
			}
			/**
			 * User is logged in, check access level and group user belongs to
			 */
			if($requiredGroup)
			{
				if($_SESSION[_APP_PRE.'_usr_grp'] != $requiredGroup)
				{
					/**
					 * User doesn't belong to the required group
					 */
					return $this->_authDenied();
				}
			}
			if($_SESSION[_APP_PRE.'_usr_lvl'] < $requiredLevel)
			{
				/**
				 * User doesn't have proper access level
				 */
				return $this->_authDenied();
			}
			/**
			 * If we get to this part, everything must be ok
			 */
			return 'ok';
		}
	}
	/**
	 * Authorization - login page
	 *
	 * @return mixed modCnt content
	 */
	public function _authLogin()
	{
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . __FUNCTION__;
		$this->modCnt['cnt']['tpl'] = 'login';
		$this->modCnt['cnt']['content']['captcha'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/captcha.png';
		return $this->modCnt;
	}
	/**
	 * Authorization - access denied
	 *
	 * @return mixed modCnt content
	 */
	public function _authDenied()
	{
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . __FUNCTION__;
		$this->modCnt['cnt']['tpl'] = 'denied';
		return $this->modCnt;
	}
	/**
	 * Generate captcha for login
	 *
	 * @return mixed captcha image
	 */
	public function captcha()
	{
		if(isset($_SESSION[_APP_PRE.'_token']))
		{
			$captchaObj = $this->modAppCore->rwActivateExt('Captcha');
			$this->modCnt = array();
			$this->modCnt['type'] = 'image';
			$this->modCnt['image'] = $captchaObj->display();

			return $this->modCnt;
		}
	}
}
?>