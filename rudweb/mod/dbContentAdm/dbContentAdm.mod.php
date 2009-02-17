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

			//http://crisp.tweakblogs.net/
			/**
			* Prepare pages array
			*/
			$pageData = array();
			$pageData['items'] = array();
			$pageData['parents'] = array();
			/**
			 * Get data
			 */
			$rs = $this->modDb->dbSelect('pg_id, pg_parent, pg_level, pg_order, pg_title, pg_alias, pg_template, pg_menu, pg_disabled, pg_created_user', _APP_PRE.'_web_pages', NULL, 'pg_parent, pg_title', NULL);
			$t = $rs->dbNumRows();
			if($t>0)
			{
				while($pageItem = $rs->dbFetchArray())
				{
					/**
					 * Author and group
					 */
					$rs2 = $this->modDb->dbSelect('A.usr_name as pg_author, B.grp_name as pg_group', _APP_PRE.'_usr_users AS A, '._APP_PRE.'_usr_groups AS B', "A.usr_id = '{$pageItem['pg_created_user']}' AND A.grp_id = B.grp_id", NULL, NULL);
					$t2 = $rs2->dbNumRows();
					$r2 = $rs2->dbFetchArray();
					$pageItem['pg_author'] = $r2['pg_author'];
					$pageItem['pg_group']  = $r2['pg_group'];
					/**
					 * Content items
					 */
					$rs3 = $this->modDb->dbSelect('COUNT(cnt_id)', _APP_PRE.'_web_content', "pg_id={$pageItem['pg_id']}", NULL, NULL);
					$pageItem['pg_items'] = $rs3->dbFetchResult();
					$pageData['items'][$pageItem['pg_id']] = $pageItem;
					$pageData['parents'][$pageItem['pg_parent']][] = $pageItem['pg_id'];
				}
			}
			$this->modCnt['cnt']['content']['pages'] = $this->formatPages(0, $pageData);
			return $this->modCnt;
		}
	}
	public function formatPages($parent, $data)
	{
		$pages = '';
		if(isset($data['parents'][$parent]))
		{
			$i = 1;
			foreach($data['parents'][$parent] as $itemId)
			{
				$pages .= "\n".'<tr';
				if($data['items'][$itemId]['pg_level'] > 0)
				{
					$pages .= ' title="'.$data['items'][$itemId]['pg_level'].'"';
				}
				$pages .= '>';
				$pages .= '<td class="pages_cr">'. $data['items'][$itemId]['pg_level'].'.'.$i.'</td>';
				$pages .= '<td class="pages_cr_tt">';
				for($i=0;$i<$data['items'][$itemId]['pg_level'];$i++)
				{
					$pages .= '&#160;&#160;&#160;';
				}
				$pages .= $data['items'][$itemId]['pg_title'].'</td>';
				$pages .= '<td class="pages_cr">'. $data['items'][$itemId]['pg_template'].'</td>';
				$pages .= '<td class="pages_cr">'. $data['items'][$itemId]['pg_menu'].'</td>';
				$pages .= '<td class="pages_cr">'. $data['items'][$itemId]['pg_disabled'].'</td>';
				$pages .= '<td class="pages_cr">'. $data['items'][$itemId]['pg_author'].'</td>';
				$pages .= '<td class="pages_cr">'. $data['items'][$itemId]['pg_group'].'</td>';
				$pages .= '<td class="pages_cr">'. $data['items'][$itemId]['pg_items'] .'</td>';
				$pages .= '<td class="pages_cr">';
				$pages .= '<a href="'._APP_URL.'content/'.$data['items'][$itemId]['pg_id'].'-'.$data['items'][$itemId]['pg_alias'].'" title="'.$this->modLang['MOD']['PAGES']['VIEW'].'">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/application_go.png" title="'.$this->modLang['MOD']['PAGES']['VIEW'].'" alt="'.$this->modLang['MOD']['PAGES']['VIEW'].'" />' . '</a>';
        $pages .= '&#160;';
				$pages .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/page_order/group/'.$data['items'][$itemId]['pg_parent'].'" title="'.$this->modLang['MOD']['PAGES']['ORDER'].'">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/application_cascade.png" title="'.$this->modLang['MOD']['PAGES']['ORDER'].'" alt="'.$this->modLang['MOD']['PAGES']['ORDER'].'" />' . '</a>';
        $pages .= '&#160;';
        $pages .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/page_edit/id/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLang['MOD']['PAGES']['EDIT'].'">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/application_edit.png" title="'.$this->modLang['MOD']['PAGES']['EDIT'].'" alt="'.$this->modLang['MOD']['PAGES']['EDIT'].'" />' . '</a>';
				$pages .= '&#160;';
				
				$pages .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/page_delete/id/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLang['MOD']['PAGES']['DELETE'].'">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/application_delete.png" title="'.$this->modLang['MOD']['PAGES']['DELETE'].'" alt="'.$this->modLang['MOD']['PAGES']['DELETE'].'" />' . '</a>';
				$pages .= '</td>';
				$pages .= '</tr>';
				$pages .= $this->formatPages($itemId, $data);
				$i++;
			}
		}
		return $pages;
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