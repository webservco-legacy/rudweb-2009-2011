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
					$rs3 = $this->modDb->dbSelect('COUNT(cnt_id)', _APP_PRE.'_web_content', "pg_id={$pageItem['pg_id']} AND cnt_deleted = '0'", NULL, NULL);
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
	public function page_add()
	{
		$auth = $this->_authVerify(3);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else
		{
			/**
			 * Get page level
			 */
			$pg_parent = (isset($_GET['parent']) && $this->modAppCore->rwCheckInt($_GET['parent'])) ? $_GET['parent'] : NULL;
			$pg_level = NULL;
			if($pg_parent == 0)
			{
				$pg_level = 1;
			}
			else{
				$rp = $this->modDb->dbSelect('pg_level', _APP_PRE.'_web_pages', "pg_id = '{$pg_parent}'", NULL, 1);
				$tp = $rp->dbNumRows();
				$pg_level = ($tp > 0) ? ($rp->dbFetchResult())+1 : NULL;
			}
			if($pg_parent == NULL || $pg_level == NULL)
			{
				return $this->_authDenied();
			}
			/**
			 * Authorization ok, proceed.
			 */
			$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['PAGE']['ADD'];
			$this->modCnt['cnt']['tpl'] = 'page_add';
			/**
			 * Get data
			 */
			$rs = $this->modDb->dbSelect('pg_order, pg_title', _APP_PRE.'_web_pages', "pg_ln = '{$_SESSION[_APP_PRE.'_usr_lang']}' AND pg_deleted = '0' AND pg_parent = '{$pg_parent}'", 'pg_parent, pg_order, pg_title', NULL);
			$t = $rs->dbNumRows();
			$this->modCnt['cnt']['content']['page_list_add'] = array();
			if($t>0)
			{
				while($pageItem = $rs->dbFetchArray())
				{
					/**
					 * Content items
					 */
					$this->modCnt['cnt']['content']['page_list_add'][] = $pageItem;
				}
			}
			$this->modCnt['cnt']['content']['page_parent'] = $pg_parent;
			return $this->modCnt;
		}
	}
	/**
	 * Page new
	 *
	 * @return mixed result
	 */
	public function page_new()
	{
		$auth = $this->_authVerify(3);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else
		{
			$pg_parent = (isset($_GET['parent']) && $this->modAppCore->rwCheckInt($_GET['parent'])) ? $_GET['parent'] : NULL;
			$pg_order = (isset($_GET['order']) && $this->modAppCore->rwCheckInt($_GET['order'])) ? $_GET['order'] : NULL;
			if($pg_parent == NULL || $pg_order == NULL)
			{
				return $this->_authDenied();
			}
			/**
			 * Default values, when form is not submitted
			 */
			$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['PAGE']['ADD'];
			$this->modCnt['cnt']['tpl'] = 'page_new';

			$this->modCnt['cnt']['content']['page_title'] = '';
			$this->modCnt['cnt']['content']['page_kw'] = '';
			$this->modCnt['cnt']['content']['page_dsc'] = '';
			$this->modCnt['cnt']['content']['page_template'] = '';
			$this->modCnt['cnt']['content']['page_err'] = array();
			/**
			 * If form is sent, process request
			 */
			if(isset($_POST['pg_title']))
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
				 * Validate Form Data
				 */
				$te = count($err);
				if($te > 0)
				{
					/**
					 * Errors occured
					 */
					$this->modCnt['cnt']['content']['page_title'] = isset($_POST['pg_title']) ? $_POST['pg_title'] : '';
					$this->modCnt['cnt']['content']['page_kw'] = isset($_POST['pg_kw']) ? $_POST['pg_kw'] : '';
					$this->modCnt['cnt']['content']['page_dsc'] = isset($_POST['pg_dsc']) ? $_POST['pg_dsc'] : '';
					$this->modCnt['cnt']['content']['page_template'] = isset($_POST['pg_template']) ? $_POST['pg_template'] : '';
					$this->modCnt['cnt']['content']['page_err'] = $err;
					return $this->modCnt;
				}
				else
				{
					/**
					 * Additional data for the db
					 */
					$data = array();
					$data['pg_ln'] = $_SESSION[_APP_PRE.'_usr_lang'];
					$data['pg_parent'] = $pg_parent;
					$rl = $this->modDb->dbSelect('pg_level', _APP_PRE.'_web_pages', "pg_id = '{$pg_parent}'", NULL, 1);
					$tl = $rl->dbNumRows();
					$data['pg_level'] = ($tl>0) ? ($rl->dbFetchResult()+1) : 0;
					$ro = $this->modDb->dbSelect('MAX(pg_order)', _APP_PRE.'_web_pages', "pg_parent = '{$pg_parent}'", NULL, 1);
					$to = $ro->dbNumRows();
					$data['pg_order'] = ($pg_order == 0) ? ($ro->dbFetchResult()+1) : $pg_order;
					$data['pg_alias'] = $this->modAppCore->rwFormatAlias($dataForm['pg_title']);
					$data['pg_menu'] = 1;
					$data['pg_created_user'] = $_SESSION[_APP_PRE.'_usr_id'];
					$data['pg_version'] = 1;
					/**
					 * Total data for the db
					 */
					$dataInsert = array_merge($dataForm, $data);
					if($this->modDb->dbInsert(_APP_PRE.'_web_pages', NULL, $dataInsert))
					{
						/**
						 * Insert successfull, redirect to mesage page
						 *
						 * get parameters: type of action, id of page
						 */
						$ri = $this->modDb->dbLastInsertId();
						$pg_id = $ri->dbFetchResult();
						header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/action_ok/type/add/resource/page/id/'.$pg_id);
						exit;
					}
					else
					{
						/**
						 * Needs work...
						 */
						trigger_error('insert error', E_USER_ERROR);
					}
				}
			}
			else
			{
				/**
				 * No post, initial view
				 */
				return $this->modCnt;
			}
		}
	}
	/**
	 * Edit page
	 *
	 * @return mixed content
	 */
	public function page_edit()
	{
		$pg_id = (isset($_GET['id']) && $this->modAppCore->rwCheckInt($_GET['id'])) ? $_GET['id'] : NULL;
		if(!$pg_id)
		{
			return $this->_authDenied();
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
			$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['PAGE']['EDIT'];
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
			$rsc = $this->modDb->dbSelect('cnt_id, cnt_order, cnt_type, cnt_template', _APP_PRE.'_web_content', "pg_id = '{$pg_id}' AND cnt_deleted = '0'", 'cnt_order', NULL);
			$tc  = $rsc->dbNumRows();
			$page_content = array();
			if($tc>0)
			{
				while($rc = $rsc->dbFetchArray())
				{
					$page_content[] = $rc;
				}
				$this->modCnt['cnt']['content']['page_content'] = $page_content;
			}
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
				 * Validate Form Data
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
						 * get parameters: type of action, id of page
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
	 * Delete page
	 *
	 */
	public function page_delete()
	{
		$pg_id = (isset($_GET['id']) && $this->modAppCore->rwCheckInt($_GET['id'])) ? $_GET['id'] : NULL;
		if(!$pg_id)
		{
			return $this->_authDenied();
		}
		$rs = $this->modDb->dbSelect('pg_group, pg_title', _APP_PRE.'_web_pages', "pg_id = '{$pg_id}'", NULL, 1);
		$t = $rs->dbNumRows();
		if($t != 1)
		{
			trigger_error("page doesn't exist", E_USER_ERROR);
		}
		$r = $rs->dbFetchArray();
		$pg_group = $r['pg_group'];
		$pg_title = $r['pg_title'];
		$auth = $this->_authVerify(3, $pg_group);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else
		{
			/**
			 * Everything is ok, proceed.
			 */
			$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['PAGE']['DELETE'];
			$this->modCnt['cnt']['content']['page_id'] = $pg_id;
			$this->modCnt['cnt']['content']['page_title'] = $pg_title;

			$rc = $this->modDb->dbSelect('pg_id', _APP_PRE.'_web_pages', "pg_parent = '{$pg_id}' AND pg_deleted = '0'", NULL, NULL);
			$tc = $rc->dbNumRows();
			if($tc > 0)
			{
				$this->modCnt['cnt']['tpl'] = 'page_delete_denied';
				return $this->modCnt;
			}

			$this->modCnt['cnt']['tpl'] = 'page_delete';

			$delete = (isset($_GET['delete']) && $_GET['delete'] == 'true') ? TRUE : FALSE;
			if($delete)
			{
				/**
				 * Delete the page and redirect
				 */
				$dataUpdate['pg_deleted'] = 1;
				$dataUpdate['pg_deleted_time'] = date('Y-m-d H:i:s');
				$dataUpdate['pg_deleted_user'] = $_SESSION[_APP_PRE.'_usr_id'];
				if($this->modDb->dbUpdate(_APP_PRE.'_web_pages', $dataUpdate, 'pg_id = '.$pg_id, NULL, 1))
				{
					/**
					 * Also delete content
					 */
					$cntUpdate['cnt_deleted'] = 1;
					$cntUpdate['cnt_deleted_time'] = date('Y-m-d H:i:s');
					$cntUpdate['cnt_deleted_user'] = $_SESSION[_APP_PRE.'_usr_id'];
					$this->modDb->dbUpdate(_APP_PRE.'_web_content', $cntUpdate, 'pg_id = '.$pg_id, NULL, 1);
					header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/action_ok/type/remove/resource/page/id/'.$pg_id);
					exit;
				}
				else
				{
					trigger_error('delete error', E_USER_ERROR);
				}
			}
			else
			{
				/**
				 * Display message
				 */
				return $this->modCnt;
			}
		}
	}
	/**
	 * Add content
	 *
	 * @return mixed content
	 */
	public function content_add()
	{
		/**
		 * Check that parent page exists
		 * and user has the right to add content
		 */
		$pg_id = (isset($_GET['id']) && $this->modAppCore->rwCheckInt($_GET['id'])) ? $_GET['id'] : NULL;
		$cnt_type = (isset($_GET['type'])) ? $_GET['type'] : NULL;
		$cnt_order = (isset($_GET['order']) && $this->modAppCore->rwCheckInt($_GET['order'])) ? $_GET['order'] : NULL;
		if(!$pg_id || !$cnt_type)
		{
			return $this->_authDenied();
		}
		$rp = $this->modDb->dbSelect('pg_group', _APP_PRE.'_web_pages', "pg_id = '{$pg_id}'", NULL, 1);
		$tp = $rp->dbNumRows();
		if($tp != 1)
		{
			trigger_error("page doesn't exist", E_USER_ERROR);
		}
		$pg_group = $rp->dbFetchResult();
		$auth = $this->_authVerify(3, $pg_group);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else
		{
			if($cnt_order == NULL)
			{
				return $this->_authDenied();
			}
			/**
			 * Everything is ok, proceed
			 */
			switch($cnt_type)
			{
				case 'text' :
					{
						return $this->_textAdd($pg_id, $cnt_order);
						break;
					}
				case 'html' :
					{
						return $this->_htmlAdd($pg_id, $cnt_order);
						break;
					}
				default :
					{
						return $this->_authDenied();
						break;
					}
			}
		}
	}
	/**
	 * Edit content
	 *
	 * @return mixed content
	 */
	public function content_edit()
	{
		/**
		 * Get content id
		 */
		$cnt_id = (isset($_GET['id']) && $this->modAppCore->rwCheckInt($_GET['id'])) ? $_GET['id'] : NULL;
		if(!$cnt_id)
		{
			return $this->_authDenied();
		}
		/**
		 * Select basic information about content
		 */
		$rs = $this->modDb->dbSelect('pg_id, cnt_type', _APP_PRE.'_web_content', "cnt_id = '{$cnt_id}'", NULL, 1);
		$t = $rs->dbNumRows();
		if($t != 1)
		{
			trigger_error("content doesn't exist", E_USER_ERROR);
		}
		$r = $rs->dbFetchArray();
		$pg_id = $r['pg_id'];
		$cnt_type = $r['cnt_type'];
		/*
		 * Check group rights
		 */
		$rp = $this->modDb->dbSelect('pg_group', _APP_PRE.'_web_pages', "pg_id = '{$pg_id}'", NULL, 1);
		$tp = $rp->dbNumRows();
		if($tp != 1)
		{
			trigger_error("page doesn't exist", E_USER_ERROR);
		}
		$pg_group = $rp->dbFetchResult();
		$auth = $this->_authVerify(3, $pg_group);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else
		{
			/**
			 * Everything is in place, proceed
			 */
			switch($cnt_type)
			{
				case 'text' :
					{
						return $this->_textEdit($cnt_id);
						break;
					}
				case 'html' :
					{
						return $this->_authDenied();
						break;
					}
				default :
					{
						return $this->_authDenied();
						break;
					}
			}
		}
	}
	public function content_delete()
	{
		/**
		 * Get content id
		 */
		$cnt_id = (isset($_GET['id']) && $this->modAppCore->rwCheckInt($_GET['id'])) ? $_GET['id'] : NULL;
		if(!$cnt_id)
		{
			return $this->_authDenied();
		}
		/**
		 * Select basic information about content
		 */
		$rs = $this->modDb->dbSelect('pg_id, cnt_type', _APP_PRE.'_web_content', "cnt_id = '{$cnt_id}'", NULL, 1);
		$t = $rs->dbNumRows();
		if($t != 1)
		{
			trigger_error("content doesn't exist", E_USER_ERROR);
		}
		$r = $rs->dbFetchArray();
		$pg_id = $r['pg_id'];
		$cnt_type = $r['cnt_type'];
		/*
		 * Check group rights
		 */
		$rp = $this->modDb->dbSelect('pg_group', _APP_PRE.'_web_pages', "pg_id = '{$pg_id}'", NULL, 1);
		$tp = $rp->dbNumRows();
		if($tp != 1)
		{
			trigger_error("page doesn't exist", E_USER_ERROR);
		}
		$pg_group = $rp->dbFetchResult();
		$auth = $this->_authVerify(3, $pg_group);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else
		{
			/**
			 * Everything is in place, proceed
			 */
			switch($cnt_type)
			{
				case 'text' :
					{
						return $this->_textDelete($cnt_id, $pg_id);
						break;
					}
				case 'html' :
					{
						return $this->_authDenied();
						break;
					}
				default :
					{
						return $this->_authDenied();
						break;
					}
			}
		}
	}
	/**
	 * Add content - html
	 *
	 * @param integer $pg_id id of containing page
	 * @param unknown_type $cnt_order content order
	 * @return mixed content
	 */
	private function _htmlAdd($pg_id, $cnt_order)
	{
		/**
		 * Default values, when form is not submitted
		 */
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['CONTENT']['ADD'];
		$this->modCnt['cnt']['tpl'] = 'html_new';

		$this->modCnt['cnt']['content']['pg_id'] = $pg_id;
		$this->modCnt['cnt']['content']['cnt_body'] = '';
		$this->modCnt['cnt']['content']['cnt_template'] = '';
		$this->modCnt['cnt']['content']['cnt_err'] = array();
		/**
		 * Rich text editor to use
		 * FCKeditor, TinyMCE, or blank
		 */
		$this->modCnt['cnt']['content']['rte'] = 'FCKeditor';

		/**
		 * If form is sent, process request
		 */
		//if(isset($_POST['cnt_body']))
		if(isset($_POST['pg_id']) && $_POST['pg_id'] == $pg_id)
		{
			/**
			 * Check page id
			 */
			/**
			 * Form data that should be processed
			 */
			$form = array();
			$form[]= array('title'=>$this->modLang['MOD']['CONTENT']['CONTENT_BODY'],'name'=>'cnt_body','type'=>'text','req'=>TRUE);
			$form[]= array('title'=>$this->modLang['MOD']['CONTENT']['CONTENT_TEMPLATE'],'name'=>'cnt_template','type'=>'text','req'=>TRUE);
			/**
			 * Process form
			 */
			list($err, $dataForm) = $this->_processForm($form);
			/**
			 * Validate Form Data
			 */
			$te = count($err);
			if($te > 0)
			{
				/**
				 * Errors occured
				 */
				$this->modCnt['cnt']['content']['cnt_body'] = isset($_POST['cnt_body']) ? $_POST['cnt_body'] : '';
				$this->modCnt['cnt']['content']['cnt_template'] = isset($_POST['cnt_template']) ? $_POST['cnt_template'] : '';
				$this->modCnt['cnt']['content']['cnt_err'] = $err;
				return $this->modCnt;
			}
			else
			{
				/**
				 * Additional data for the db
				 */
				$data = array();
				$data['pg_id'] = $pg_id;
				$ro = $this->modDb->dbSelect('MAX(cnt_order)', _APP_PRE.'_web_content', "pg_id = '{$pg_id}'", NULL, 1);
				$to = $ro->dbNumRows();
				$data['cnt_order'] = ($cnt_order == 0) ? ($ro->dbFetchResult()+1) : $cnt_order;
				$data['cnt_type'] = 'html';
				$data['cnt_created_user'] = $_SESSION[_APP_PRE.'_usr_id'];
				$data['cnt_version'] = 1;
				/**
				 * Total data for the db
				 */
				$dataInsert = array_merge($dataForm, $data);
				if($this->modDb->dbInsert(_APP_PRE.'_web_content', NULL, $dataInsert))
				{
					/**
					 * Insert successfull, redirect to mesage page
					 *
					 * get parameters: type of action, id of page
					 */
					$ri = $this->modDb->dbLastInsertId();
					$cnt_id = $ri->dbFetchResult();
					header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/action_ok/type/add/resource/content/id/'.$cnt_id);
					exit;
				}
				else
				{
					/**
					 * Needs work...
					 */
					trigger_error('insert error', E_USER_ERROR);
				}
			}
		}
		else
		{
			/**
			 * No post, initial view
			 */
			return $this->modCnt;
		}
	}
	/**
	 * Add content - text
	 *
	 * @param integer $pg_id id of containing page
	 * @param integer $cnt_order content order
	 * @return mixed content
	 */
	private function _textAdd($pg_id, $cnt_order)
	{
		/**
		 * Default values, when form is not submitted
		 */
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['CONTENT']['ADD'];
		$this->modCnt['cnt']['tpl'] = 'text_new';

		$this->modCnt['cnt']['content']['pg_id'] = $pg_id;
		$this->modCnt['cnt']['content']['cnt_body'] = '';
		$this->modCnt['cnt']['content']['cnt_template'] = '';
		$this->modCnt['cnt']['content']['cnt_err'] = array();
		/**
		 * If form is sent, process request
		 */
		//if(isset($_POST['cnt_body']))
		if(isset($_POST['pg_id']) && $_POST['pg_id'] == $pg_id)
		{
			/**
			 * Check page id
			 */
			/**
			 * Form data that should be processed
			 */
			$form = array();
			$form[]= array('title'=>$this->modLang['MOD']['CONTENT']['CONTENT_BODY'],'name'=>'cnt_body','type'=>'text','req'=>TRUE);
			$form[]= array('title'=>$this->modLang['MOD']['CONTENT']['CONTENT_TEMPLATE'],'name'=>'cnt_template','type'=>'text','req'=>TRUE);
			/**
			 * Process form
			 */
			list($err, $dataForm) = $this->_processForm($form);
			/**
			 * Validate Form Data
			 */
			$te = count($err);
			if($te > 0)
			{
				/**
				 * Errors occured
				 */
				$this->modCnt['cnt']['content']['cnt_body'] = isset($_POST['cnt_body']) ? $_POST['cnt_body'] : '';
				$this->modCnt['cnt']['content']['cnt_template'] = isset($_POST['cnt_template']) ? $_POST['cnt_template'] : '';
				$this->modCnt['cnt']['content']['cnt_err'] = $err;
				return $this->modCnt;
			}
			else
			{
				/**
				 * Additional data for the db
				 */
				$data = array();
				$data['pg_id'] = $pg_id;
				$ro = $this->modDb->dbSelect('MAX(cnt_order)', _APP_PRE.'_web_content', "pg_id = '{$pg_id}'", NULL, 1);
				$to = $ro->dbNumRows();
				$data['cnt_order'] = ($cnt_order == 0) ? ($ro->dbFetchResult()+1) : $cnt_order;
				$data['cnt_type'] = 'text';
				$data['cnt_created_user'] = $_SESSION[_APP_PRE.'_usr_id'];
				$data['cnt_version'] = 1;
				/**
				 * Total data for the db
				 */
				$dataInsert = array_merge($dataForm, $data);
				if($this->modDb->dbInsert(_APP_PRE.'_web_content', NULL, $dataInsert))
				{
					/**
					 * Insert successfull, redirect to mesage page
					 *
					 * get parameters: type of action, id of page
					 */
					$ri = $this->modDb->dbLastInsertId();
					$cnt_id = $ri->dbFetchResult();
					header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/action_ok/type/add/resource/content/id/'.$cnt_id);
					exit;
				}
				else
				{
					/**
					 * Needs work...
					 */
					trigger_error('insert error', E_USER_ERROR);
				}
			}
		}
		else
		{
			/**
			 * No post, initial view
			 */
			return $this->modCnt;
		}
	}
	/**
	 * Edit content - page
	 *
	 * @param integer $cnt_id content id
	 * @return mixed content
	 */
	private function _textEdit($cnt_id)
	{
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['CONTENT']['EDIT'];
		$this->modCnt['cnt']['tpl'] = 'text_edit';
		$this->modCnt['cnt']['content']['cnt_id'] = $cnt_id;
		/**
		 * Content data
		 */
		$rs = $this->modDb->dbSelect('cnt_body, cnt_template', _APP_PRE.'_web_content', "cnt_id = '{$cnt_id}'", NULL, 1);
		$t = $rs->dbNumRows();
		if($t != 1)
		{
			trigger_error("content doesn't exist", E_USER_ERROR);
		}
		$r = $rs->dbFetchArray();
		$this->modCnt['cnt']['content']['cnt_body'] = $r['cnt_body'];
		$this->modCnt['cnt']['content']['cnt_template'] = $r['cnt_template'];
		$this->modCnt['cnt']['content']['cnt_err'] = array();
		if(isset($_POST['cnt_id']) && ($_POST['cnt_id'] == $cnt_id))
		{
			/**
			 * Form data that should be processed
			 */
			$form = array();
			$form[]= array('title'=>$this->modLang['MOD']['CONTENT']['CONTENT_BODY'],'name'=>'cnt_body','type'=>'text','req'=>TRUE);
			$form[]= array('title'=>$this->modLang['MOD']['CONTENT']['CONTENT_TEMPLATE'],'name'=>'cnt_template','type'=>'text','req'=>TRUE);
			/**
			 * Process form
			 */
			list($err, $dataForm) = $this->_processForm($form);
			/**
			 * Validate Form Data
			 */
			$te = count($err);
			if($te > 0)
			{
				/**
				 * Errors occured
				 */
				$this->modCnt['cnt']['content']['cnt_body'] = isset($_POST['cnt_body']) ? $_POST['cnt_body'] : $r['cnt_body'];
				$this->modCnt['cnt']['content']['cnt_template'] = isset($_POST['cnt_template']) ? $_POST['cnt_template'] : $r['cnt_template'];
				$this->modCnt['cnt']['content']['cnt_err'] = $err;
				return $this->modCnt;
			}
			/**
			 * Additional data for the db
			 */
			$data = array();
			$data['cnt_modified_time'] = date('Y-m-d H:i:s');
			$data['cnt_modified_user'] = $_SESSION[_APP_PRE.'_usr_id'];
			$data['cnt_version'] = '{cnt_version+1}';
			/**
			 * Total data for the db
			 */
			$dataUpdate = array_merge($dataForm, $data);
			if($this->modDb->dbUpdate(_APP_PRE.'_web_content', $dataUpdate, 'cnt_id = '.$cnt_id, NULL, 1))
			{
				/**
				 * Update successfull, redirect to mesage page
				 *
				 * get parameters: type of action, id of page
				 */
				header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/action_ok/type/edit/resource/content/id/'.$cnt_id);
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
		else
		{
			return $this->modCnt;
		}
	}
	/**
	 * Delete content - page
	 *
	 * @param integer $cnt_id content id
	 * @return mixed content
	 */
	private function _textDelete($cnt_id, $pg_id)
	{
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['CONTENT']['DELETE'];
		$this->modCnt['cnt']['content']['cnt_id'] = $cnt_id;
		$this->modCnt['cnt']['content']['pg_id'] = $pg_id;

		$this->modCnt['cnt']['tpl'] = 'content_delete';

		$delete = (isset($_GET['delete']) && $_GET['delete'] == 'true') ? TRUE : FALSE;
		if($delete)
		{
			/**
			 * Delete the content and redirect
			 */
			$dataUpdate['cnt_deleted'] = 1;
			$dataUpdate['cnt_deleted_time'] = date('Y-m-d H:i:s');
			$dataUpdate['cnt_deleted_user'] = $_SESSION[_APP_PRE.'_usr_id'];
			if($this->modDb->dbUpdate(_APP_PRE.'_web_content', $dataUpdate, 'cnt_id = '.$cnt_id, NULL, 1))
			{
				header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/action_ok/type/remove/resource/content/id/'.$cnt_id);
				exit;
			}
			else
			{
				trigger_error('delete error', E_USER_ERROR);
			}
		}
		else
		{
			/**
			 * Display message
			 */
			return $this->modCnt;
		}
	}
	/**
	 * Successfull action message
	 *
	 * @return mixed content
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
						$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['FORM']['ADD_OK'];

						$this->modCnt['cnt']['content'][0]['return_title'] = $this->modLang['MOD'][$res_intl]['ADMIN'];
						if($_GET['resource'] == 'content')
						{
							$this->modCnt['cnt']['content'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/page_edit/id/'.$_GET['id'];
						}
						else
						{
							$this->modCnt['cnt']['content'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'_list';
						}
						$this->modCnt['cnt']['content'][1]['return_title'] = $this->modLang['MOD'][$res_intl]['EDIT'];
						$this->modCnt['cnt']['content'][1]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'_edit/id/'.$_GET['id'];

						break;
					}
				case 'edit' :
					{
						/**
						 * Data was edited, go back to edited resource
						 */
						$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['FORM']['EDIT_OK'];

						$this->modCnt['cnt']['content'][0]['return_title'] = $this->modLang['MOD'][$res_intl]['ADMIN'];
						if($_GET['resource'] == 'content')
						{
							$this->modCnt['cnt']['content'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/page_edit/id/'.$_GET['id'];
						}
						else
						{
							$this->modCnt['cnt']['content'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'_list';
						}
						$this->modCnt['cnt']['content'][1]['return_title'] = $this->modLang['MOD'][$res_intl]['EDIT'];
						$this->modCnt['cnt']['content'][1]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'_edit/id/'.$_GET['id'];

						break;
					}
				case 'remove' :
					{
						/**
						 * Data was removed, go back to resource list
						 */
						$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['FORM']['REMOVE_OK'];

						$this->modCnt['cnt']['content'][0]['return_title'] = $this->modLang['MOD'][$res_intl]['ADMIN'];
						if($_GET['resource'] == 'content')
						{
							$this->modCnt['cnt']['content'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/page_edit/id/'.$_GET['id'];
						}
						else
						{
							$this->modCnt['cnt']['content'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'_list';
						}

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
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/page_new/parent/'.$data['items'][$itemId]['pg_parent'].'/order/'.$data['items'][$itemId]['pg_order'].'" title="'.$this->modLang['MOD']['PAGE']['ADD_BEFORE'].'">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_add_before.png" title="'.$this->modLang['MOD']['PAGE']['ADD_BEFORE'].'" alt="'.$this->modLang['MOD']['PAGE']['ADD_BEFORE'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/page_new/parent/'.$data['items'][$itemId]['pg_parent'].'/order/'.(($data['items'][$itemId]['pg_order'])+1).'" title="'.$this->modLang['MOD']['PAGE']['ADD_AFTER'].'">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_add_after.png" title="'.$this->modLang['MOD']['PAGE']['ADD_AFTER'].'" alt="'.$this->modLang['MOD']['PAGE']['ADD_AFTER'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/page_add/parent/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLang['MOD']['PAGE']['ADD_INSIDE'].'">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_add_inside.png" title="'.$this->modLang['MOD']['PAGE']['ADD_INSIDE'].'" alt="'.$this->modLang['MOD']['PAGE']['ADD_INSIDE'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'content/'.$data['items'][$itemId]['pg_id'].'-'.$data['items'][$itemId]['pg_alias'].'" title="'.$this->modLang['MOD']['PAGE']['VIEW'].'" target="website">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_view.png" title="'.$this->modLang['MOD']['PAGE']['VIEW'].'" alt="'.$this->modLang['MOD']['PAGE']['VIEW'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/page_edit/id/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLang['MOD']['PAGE']['EDIT'].'">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_edit.png" title="'.$this->modLang['MOD']['PAGE']['EDIT'].'" alt="'.$this->modLang['MOD']['PAGE']['EDIT'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/page_delete/id/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLang['MOD']['PAGE']['DELETE'].'">' . '<img src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_delete.png" title="'.$this->modLang['MOD']['PAGE']['DELETE'].'" alt="'.$this->modLang['MOD']['PAGE']['DELETE'].'" />' . '</a>';
				$page_list .= '</td>';
				$page_list .= '</tr>';
				$page_list .= $this->_formatPages($itemId, $data);
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