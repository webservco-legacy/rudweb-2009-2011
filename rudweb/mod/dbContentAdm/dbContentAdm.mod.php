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
	/**
	 * Pages administration
	 *
	 * Displays a list of all the pages.
	 *
	 * @return mixed result
	 */
	public function page_list()
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
			$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['PAGE']['ADMIN'];
			$this->modCnt['cnt']['tpl'] = 'page_list';
			/**
			 * Prepare pages array
			 */
			$pageData = array();
			$pageData['items'] = array();
			$pageData['parents'] = array();
			/**
			 * Get data
			 */
			$rs = $this->modDb->dbSelect('pg_id, pg_parent, pg_level, pg_order, pg_title, pg_alias, pg_group, pg_created_user', _APP_PRE.'_web_pages', "pg_ln = '{$_SESSION[_APP_PRE.'_usr_lang']}' AND pg_deleted = '0'", 'pg_parent, pg_order, pg_title', NULL);
			$t = $rs->dbNumRows();
			if($t>0)
			{
				while($pageItem = $rs->dbFetchArray())
				{
					/**
					 * Author and group
					 */
					$rs2 = $this->modDb->dbSelect('A.usr_name as pg_author, B.grp_name as pg_group', _APP_PRE."_usr_users AS A left join "._APP_PRE."_usr_groups as B on (B.grp_id = '{$pageItem['pg_group']}')", "A.usr_id = '{$pageItem['pg_created_user']}'", NULL, NULL);
					$t2 = $rs2->dbNumRows();
					$r2 = $rs2->dbFetchArray();
					$pageItem['pg_author'] = $r2['pg_author'];
					$pageItem['pg_group_name']  = $r2['pg_group'];
					/**
					 * Content items
					 */
					$rs3 = $this->modDb->dbSelect('COUNT(cnt_id)', _APP_PRE.'_web_content', "pg_id={$pageItem['pg_id']}", NULL, NULL);
					$pageItem['pg_items'] = $rs3->dbFetchResult();
					$pageData['items'][$pageItem['pg_id']] = $pageItem;
					$pageData['parents'][$pageItem['pg_parent']][] = $pageItem['pg_id'];
				}
			}
			$this->modCnt['cnt']['content']['page_list'] = $this->_formatPages(0, $pageData);
			return $this->modCnt;
		}
	}
 /**
  * Page add (list)
  *
  * Displays a list of all the pages
  * with placeholders to add new pages
  * 
  * @return mixed result
  */
	public function page_list_add()
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
      $this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['PAGE']['ADD'];
      $this->modCnt['cnt']['tpl'] = 'page_list_add';
      /**
       * Prepare pages array
       */
      $pageData = array();
      $pageData['items'] = array();
      $pageData['parents'] = array();
      /**
       * Get data
       */
      $rs = $this->modDb->dbSelect('pg_id, pg_parent, pg_level, pg_order, pg_title', _APP_PRE.'_web_pages', "pg_ln = '{$_SESSION[_APP_PRE.'_usr_lang']}' AND pg_deleted = '0'", 'pg_parent, pg_order, pg_title', NULL);
      $t = $rs->dbNumRows();
      if($t>0)
      {
        while($pageItem = $rs->dbFetchArray())
        {
          /**
           * Content items
           */
          $pageData['items'][$pageItem['pg_id']] = $pageItem;
          $pageData['parents'][$pageItem['pg_parent']][] = $pageItem['pg_id'];
        }
      }
      $this->modCnt['cnt']['content']['page_list_add'] = $this->_formatPagesAdd(0, $pageData);
      return $this->modCnt;
    }
  }
	/**
	 * Edit page
	 *
	 * @return mixed content
	 */
	public function page_edit()
	{
		$pg_id = (isset($_GET['id']) && (int)$this->modAppCore->rwFilterInput($_GET['id']) !== 0) ? $this->modAppCore->rwFilterInput($_GET['id']) : NULL;
		if(!$pg_id)
		{
			trigger_error('invalid page id', E_USER_ERROR);
		}
		$rs = $this->modDb->dbSelect('pg_group', _APP_PRE.'_web_pages', "pg_id = '{$pg_id}'", NULL, 1);
		$t = $rs->dbNumRows();
		if($t != 1)
		{
			trigger_error("page doesn't exist", E_USER_ERROR);
		}
		$pg_group = $rs->dbFetchResult();
		$auth = $this->_authVerify(3, $pg_group);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else
		{
			/**
			 * Authorization passed, do the stuff
			 */
			/**
			 * Default values, if no form is processed
			 */
			$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . __FUNCTION__;
			$this->modCnt['cnt']['tpl'] = 'page_edit';
			$this->modCnt['cnt']['content']['page_id'] = $pg_id;
			/**
			 * Page data
			 */
			$rs = $this->modDb->dbSelect('pg_title, pg_kw, pg_dsc, pg_template, pg_group', _APP_PRE.'_web_pages', "pg_id = '{$pg_id}'", NULL, 1);
			$t = $rs->dbNumRows();
			if($t != 1)
			{
				trigger_error("page doesn't exist", E_USER_ERROR);
			}
			$r = $rs->dbFetchArray();
			$this->modCnt['cnt']['content']['page_title'] = $r['pg_title'];
			$this->modCnt['cnt']['content']['page_kw'] = $r['pg_kw'];
			$this->modCnt['cnt']['content']['page_dsc'] = $r['pg_dsc'];
			$this->modCnt['cnt']['content']['page_template'] = $r['pg_template'];
			$this->modCnt['cnt']['content']['page_err'] = array();
			/**
			 * Page content
			 */
			$rsc = $this->modDb->dbSelect('cnt_id, cnt_order, cnt_type, cnt_template', _APP_PRE.'_web_content', "pg_id = '{$pg_id}' AND cnt_disabled = '0'", 'cnt_order', NULL);
			$tc  = $rsc->dbNumRows();
			$page_content = array();
			if($tc>0)
			{
				while($rc = $rsc->dbFetchArray())
				{
					$page_content[] = $rc;
				}
			}
			$this->modCnt['cnt']['content']['page_content'] = $page_content;
			/**
			 * If form is sent, process request
			 */
			if(isset($_POST['pg_id']) && ($_POST['pg_id'] == $pg_id))
			{
				/**
				 * Form data that should be processed
				 */
				$form = array();
				$form[]= array('title'=>$this->modLang['MOD']['PAGE']['PAGE_TITLE'],'name'=>'pg_title','type'=>'text','req'=>TRUE);
				$form[]= array('title'=>$this->modLang['MOD']['PAGE']['PAGE_KEYWORDS'],'name'=>'pg_kw','type'=>'text','req'=>FALSE);
				$form[]= array('title'=>$this->modLang['MOD']['PAGE']['PAGE_DESCRIPTION'],'name'=>'pg_dsc','type'=>'text','req'=>FALSE);
				$form[]= array('title'=>$this->modLang['MOD']['PAGE']['PAGE_TEMPLATE'],'name'=>'pg_template','type'=>'text','req'=>TRUE);
				/**
				 * Process form
				 */
				list($err, $dataForm) = $this->_processForm($form);
				/**
				 * validateFormData
				 */
				$te = count($err);
				if($te > 0)
				{
					/**
					 * Errors occured
					 */
					$this->modCnt['cnt']['content']['page_title'] = isset($_POST['pg_title']) ? $_POST['pg_title'] : $r['pg_title'];
					$this->modCnt['cnt']['content']['page_kw'] = isset($_POST['pg_kw']) ? $_POST['pg_kw'] : $r['pg_kw'];
					$this->modCnt['cnt']['content']['page_dsc'] = isset($_POST['pg_dsc']) ? $_POST['pg_dsc'] : $r['pg_dsc'];
					$this->modCnt['cnt']['content']['page_template'] = isset($_POST['pg_template']) ? $_POST['pg_template'] : $r['pg_template'];
					$this->modCnt['cnt']['content']['page_err'] = $err;
					return $this->modCnt;
				}
				else
				{
					/**
					 * Additional data for the db
					 */
					$data = array();
					$data['pg_alias'] = $this->modAppCore->rwFormatAlias($dataForm['pg_title']);
					$data['pg_modified_time'] = date('Y-m-d H:i:s');
					$data['pg_modified_user'] = $_SESSION[_APP_PRE.'_usr_id'];
					$data['pg_version'] = '{pg_version+1}';
					/**
					 * Total data for the db
					 */
					$dataUpdate = array_merge($dataForm, $data);

					if($this->modDb->dbUpdate(_APP_PRE.'_web_pages', $dataUpdate, 'pg_id = '.$pg_id, NULL, 1))
					{
						/**
						 * Update successfull, redirect to mesage page
						 *
						 * get parameters: type of update, id of page
						 */
						header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/action_ok/type/edit/resource/page/id/'.$pg_id);
						exit;
					}
					else
					{
						/**
						 * Needs work...
						 */
						trigger_error('update error', E_USER_ERROR);
					}
				}
			}
			else
			{
				/**
				 * No post, normal view
				 */
				return $this->modCnt;
			}
		}
	}
	/**
	 * Successful action message page
	 *
	 * @return mixed result
	 */
	public function action_ok()
	{
		$res = array('page', 'content');
		$auth = $this->_authVerify(3);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else if(isset($_GET['type']) && (isset($_GET['resource']) && (in_array($_GET['resource'], $res) && (isset($_GET['id']) && $this->modAppCore->rwCheckInt($_GET['id'])))))
		{
			/**
			 * If post data exists, do a self redirect to avoid double submits
			 */
			$post = count($_POST);
			if($post > 0)
			{
				$this->modAppCore->rwSelfRedirect();
			}
			/**
			 * Format resource name for internationalization
			 */
			$res_intl = strtoupper($_GET['resource']);
			switch($_GET['type'])
			{
				case 'add' :
					{
						/**
						 * Data was added, go back to resource list
						 */
						$this->modCnt['cnt']['content']['return_title'] = $this->modLang['MOD'][$res_intl]['ADMIN'];
						$this->modCnt['cnt']['content']['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'_list';
						$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['FORM']['ADD_OK'];
						break;
					}
				case 'edit' :
					{
						/**
						 * Data was edited, go back to edited resource
						 */
						$this->modCnt['cnt']['content']['return_title'] = $this->modLang['MOD'][$res_intl]['EDIT'];
						$this->modCnt['cnt']['content']['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'_edit/id/'.$_GET['id'];
						$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['FORM']['EDIT_OK'];
						break;
					}
				case 'remove' :
					{
						/**
						 * Data was removed, go back to resource list
						 */
						$this->modCnt['cnt']['content']['return_title'] = $this->modLang['MOD'][$res_intl]['ADMIN'];
						$this->modCnt['cnt']['content']['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'_list';
						$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['FORM']['REMOVE_OK'];
						break;
					}
				default :
					{
						return $this->_authDenied();
						break;
					}
			}
			$this->modCnt['cnt']['tpl'] = 'action_ok';
			return $this->modCnt;
		}
		else
		{
			return $this->_authDenied();
		}
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
	/**
	 * Format pages list for viewer
	 *
	 * @param integer $parent parent id
	 * @param array $data page information
	 * @return mixed html data for viewer
	 */
	private function _formatPages($parent, $data)
	{
		$page_list = '';
		if(isset($data['parents'][$parent]))
		{
			$i = 1;
			foreach($data['parents'][$parent] as $itemId)
			{
				$page_list .= "\n".'<tr';
				if($data['items'][$itemId]['pg_level'] > 0)
				{
					$page_list .= ' title="'.$data['items'][$itemId]['pg_level'].'"';
				}
				$page_list .= '>';
				$page_list .= '<td class="page_list_cr">'. $data['items'][$itemId]['pg_level'].'.'.$i.'</td>';
				$page_list .= '<td class="page_list_cr_tt">';
				for($i=0;$i<$data['items'][$itemId]['pg_level'];$i++)
				{
					$page_list .= '&#160;&#160;&#160;';
				}
				$page_list .= $data['items'][$itemId]['pg_title'].'</td>';
				$page_list .= '<td class="page_list_cr">'. $data['items'][$itemId]['pg_author'].'</td>';
				$page_list .= '<td class="page_list_cr">'. $data['items'][$itemId]['pg_group_name'].'</td>';
				$page_list .= '<td class="page_list_cr">'. $data['items'][$itemId]['pg_items'] .'</td>';
				$page_list .= '<td class="page_list_cr">';
				$page_list .= '<a href="'._APP_URL.'content/'.$data['items'][$itemId]['pg_id'].'-'.$data['items'][$itemId]['pg_alias'].'" title="'.$this->modLang['MOD']['PAGE']['VIEW'].'" target="website">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/application_go.png" title="'.$this->modLang['MOD']['PAGE']['VIEW'].'" alt="'.$this->modLang['MOD']['PAGE']['VIEW'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/page_order/group/'.$data['items'][$itemId]['pg_parent'].'" title="'.$this->modLang['MOD']['PAGE']['ORDER'].'">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/application_cascade.png" title="'.$this->modLang['MOD']['PAGE']['ORDER'].'" alt="'.$this->modLang['MOD']['PAGE']['ORDER'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/page_edit/id/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLang['MOD']['PAGE']['EDIT'].'">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/application_edit.png" title="'.$this->modLang['MOD']['PAGE']['EDIT'].'" alt="'.$this->modLang['MOD']['PAGE']['EDIT'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/page_delete/id/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLang['MOD']['PAGE']['DELETE'].'">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/application_delete.png" title="'.$this->modLang['MOD']['PAGE']['DELETE'].'" alt="'.$this->modLang['MOD']['PAGE']['DELETE'].'" />' . '</a>';
				$page_list .= '</td>';
				$page_list .= '</tr>';
				$page_list .= $this->_formatPages($itemId, $data);
				$i++;
			}
		}
		return $page_list;
	}
 /**
   * Format pages list for viewer (add page section)
   *
   * @param integer $parent parent id
   * @param array $data page information
   * @return mixed html data for viewer
   */
  private function _formatPagesAdd($parent, $data)
  {
    //XXX
  	$page_list = '';
    if(isset($data['parents'][$parent]))
    {
      $i = 1;
      foreach($data['parents'][$parent] as $itemId)
      {
        $page_list .= "\n".'<tr';
        if($data['items'][$itemId]['pg_level'] > 0)
        {
          $page_list .= ' title="'.$data['items'][$itemId]['pg_level'].'"';
        }
        $page_list .= '>';
        $page_list .= '<td class="page_list_cr">'. $data['items'][$itemId]['pg_level'].'.'.$i.'</td>';
        $page_list .= '<td class="page_list_cr_tt">';
        for($i=0;$i<$data['items'][$itemId]['pg_level'];$i++)
        {
          $page_list .= '&#160;&#160;&#160;';
        }
        $page_list .= $data['items'][$itemId]['pg_title'].'</td>';
        $page_list .= '</tr>';
        $page_list .= $this->_formatPagesAdd($itemId, $data);
        $i++;
      }
    }
    return $page_list;
  }
	/**
	 * Process a form sent through post
	 *
	 * Please note that the parameter is
	 * the form data that SHOULD PE PROCESSED,
	 * not the form itself, which the method
	 * gets form $_POST.
	 *
	 * @param array $form
	 * @return array errors and processed form data
	 */
	private function _processForm($form)
	{
		$err = array();
		$data = array();
		foreach($form as $id)
		{
			if(isset($_POST[$id['name']]))
			{
				$data[$id['name']] = $this->modAppCore->rwFilterInput($_POST[$id['name']]);
				if($id['req'])
				{
					if($data[$id['name']] == '')
					{
						$err[] = $this->modLang['FORM']['FIELD'].$id['title'].$this->modLang['FORM']['IS_EMPTY'];
					}
				}
				switch($id['type'])
				{
					case 'text' :
						{
							break;
						}
					case 'email' :
						{
							if($data[$id['name']] != '' && !$this->modAppCore->rwCheckEmail($data[$id['name']]))
							{
								$err[] = $this->modLang['FORM']['FIELD'].$id['title'].$this->modLang['FORM']['IS_INVALID'];
							}
							break;
						}
					case 'int' :
						{
							if($data[$id['name']] != '' && !$this->modAppCore->rwCheckInt($data[$id['name']]))
							{
								$err[] = $this->modLang['FORM']['FIELD'].$id['title'].$this->modLang['FORM']['IS_INVALID'];
							}
							break;
						}
				}
			}
			else
			{
				if($id['req'])
				{
					$err[] = $this->modLang['FORM']['FIELD'].$id['title'].$this->modLang['FORM']['IS_EMPTY'];
				}
			}
		}
		return array($err, $data);
	}
	/**
	 * Authorization verification
	 *
	 * @return mixed
	 */
	private function _authVerify($requiredLevel=0, $requiredGroup=NULL)
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
	private function _authLogin()
	{
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['AUTH']['LOGIN_TT'];
		$this->modCnt['cnt']['tpl'] = 'login';
		$this->modCnt['cnt']['content']['captcha'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/captcha.png';
		return $this->modCnt;
	}
	/**
	 * Authorization - access denied
	 *
	 * @return mixed modCnt content
	 */
	private function _authDenied()
	{
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['AUTH']['DENIED_TT'];
		$this->modCnt['cnt']['tpl'] = 'denied';
		return $this->modCnt;
	}

}
?>