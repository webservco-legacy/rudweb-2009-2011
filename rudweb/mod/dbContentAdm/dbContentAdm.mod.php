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
/**
 * Module class
 *
 */
class rw_Mod_dbContentAdm extends rw_Mod_global implements rw_iMod
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
		$about['name'] = 'dbContentAdm';
		$about['desc'] = 'Database Content Administration Module';
		$about['ver']  = '$Revision$';
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
		 * $cnt['skin']['dir'] added by default in parent class
		 * $cnt['skin']['tpl'] added by default in parent class
		 * $cnt['skin']['title'] added by default in parent class
		 * $cnt['skin']['meta'] added by default in parent class
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
		$this->_makeMenu();
	}
	/**
	 * Default module functionality
	 *
	 * @return mixed result
	 */
	public function _default()
	{
		//$this->_makeMenu();
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
	public function pageList()
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
			$this->modCnt['cnt']['tpl'] = 'pageList';
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
	public function pageAdd()
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
			$this->modCnt['cnt']['tpl'] = 'pageAdd';
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
	public function pageNew()
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
			$this->modCnt['cnt']['tpl'] = 'pageNew';

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
						header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/actionOk/type/add/resource/page/id/'.$pg_id);
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
	public function pageEdit()
	{
		/**
		 * Get page id
		 */
		$pg_id = (isset($_GET['id']) && $this->modAppCore->rwCheckInt($_GET['id'])) ? $_GET['id'] : NULL;
		if(!$pg_id)
		{
			return $this->_authDenied();
		}
		/**
		 * Check page
		 */
		$rs = $this->modDb->dbSelect('pg_group', _APP_PRE.'_web_pages', "pg_id = '{$pg_id}'", NULL, 1);
		$t = $rs->dbNumRows();
		if($t != 1)
		{
			trigger_error("page doesn't exist", E_USER_ERROR);
		}
		$pg_group = $rs->dbFetchResult();
		/**
		 * Verify authorization
		 */
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
			$this->modCnt['cnt']['tpl'] = 'pageEdit';
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
						header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/actionOk/type/edit/resource/page/id/'.$pg_id);
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
	public function pageDelete()
	{
		/**
		 * Get page id
		 */
		$pg_id = (isset($_GET['id']) && $this->modAppCore->rwCheckInt($_GET['id'])) ? $_GET['id'] : NULL;
		if(!$pg_id)
		{
			return $this->_authDenied();
		}
		/**
		 * Check page
		 */
		$rs = $this->modDb->dbSelect('pg_group, pg_title', _APP_PRE.'_web_pages', "pg_id = '{$pg_id}' AND pg_deleted = '0'", NULL, 1);
		$t = $rs->dbNumRows();
		if($t != 1)
		{
			trigger_error("page doesn't exist", E_USER_ERROR);
		}
		$r = $rs->dbFetchArray();
		$pg_group = $r['pg_group'];
		$pg_title = $r['pg_title'];
		/**
		 * Verify rights
		 */
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
			/**
			 * Check if page contains other pages
			 */
			$rc = $this->modDb->dbSelect('pg_id', _APP_PRE.'_web_pages', "pg_parent = '{$pg_id}' AND pg_deleted = '0'", NULL, NULL);
			$tc = $rc->dbNumRows();
			if($tc > 0)
			{
				$this->modCnt['cnt']['tpl'] = 'pageDeleteDenied';
				return $this->modCnt;
			}
			/**
			 * Ok to go forward, set template.
			 */
			$this->modCnt['cnt']['tpl'] = 'pageDelete';
			/**
			 * If user is sure to delete, do it
			 */
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
					header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/actionOk/type/remove/resource/page/id/'.$pg_id);
					exit;
				}
				else
				{
					/**
					 * Needs work
					 */
					trigger_error('delete error', E_USER_ERROR);
				}
			}
			else
			{
				/**
				 * Display are you sure message
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
	public function contentAdd()
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
	public function contentEdit()
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
						return $this->_textEdit($pg_id, $cnt_id);
						break;
					}
				case 'html' :
					{
						return $this->_htmlEdit($pg_id, $cnt_id);
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
	 * Delete content
	 *
	 * @return mixed content
	 */
	public function contentDelete()
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
						return $this->_htmlDelete($cnt_id, $pg_id);
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
	 * Thumbnail administration
	 *
	 * @return mixed content
	 */
	public function thumbnailList()
	{
		$thumb_label = (isset($_GET['label']) && $this->modAppCore->rwFilterInput($_GET['label']) != '') ? $this->modAppCore->rwFilterInput($_GET['label']) : 'pictures';
		if(!$thumb_label)
		{
			return $this->_authDenied();
		}
		$auth = $this->_authVerify(3);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else
		{
			/**
			 * Everything is ok, proceed
			 */
			/**
			 * Default values
			 */
			$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['THUMBNAIL']['ADMIN'];
			$this->modCnt['cnt']['tpl'] = 'thumbnailList';
			$this->modCnt['cnt']['content']['thumb_label'] = $thumb_label;
			$this->modCnt['cnt']['content']['thumb_list'] = array();

			/**
			 * Get all labels
			 */
			$rl = $this->modDb->dbSelect('DISTINCT thumb_label', _APP_PRE.'_web_thumbs', "thumb_group = '{$_SESSION[_APP_PRE.'_usr_grp']}' AND thumb_deleted = '0'", NULL, NULL);
			$tl = $rl->dbNumRows();
			$this->modCnt['cnt']['content']['thumb_labels'] = array();
			if($tl>0)
			{
				while($r = $rl->dbFetchArray())
				{
					$this->modCnt['cnt']['content']['thumb_labels'][] = $r;
				}
			}
			/**
			 * Thumbnails data
			 */
			$rs = $this->modDb->dbSelect('thumb_id, thumb_title, thumb_file, thumb_type, thumb_width, thumb_height', _APP_PRE.'_web_thumbs', "thumb_group = '{$_SESSION[_APP_PRE.'_usr_grp']}' AND thumb_label = '{$thumb_label}' AND thumb_deleted = '0'", NULL, NULL);
			$t = $rs->dbNumRows();
			$thumb_list = array();
			if($t > 0)
			{
				$thumb = $this->modAppCore->rwActivateExt('Thumb');
				$thumb->set_cacheDir(_APP_DIR_TMP);
				$thumb->set_maxSize(120);
				$thumb->set_thumbFormat(3); //png = 3, jpeg = 2, gif = 1
				while($r = $rs->dbFetchArray())
				{
					/**
					 * Get image information
					 */
					$r['thumb_ext']  = image_type_to_extension($r['thumb_type'], TRUE);
					$r['thumb_preview'] = $thumb->thumb(_APP_DIR_THUMB.$r['thumb_file'].$r['thumb_ext']);
					$thumb_list[] = $r;
				}
				$this->modCnt['cnt']['content']['thumb_list'] = $thumb_list;
			}
			return $this->modCnt;
		}
	}
	/**
	 * Image administration
	 *
	 * @return mixed content
	 */
	public function imageList()
	{
		$pic_label = (isset($_GET['label']) && $this->modAppCore->rwFilterInput($_GET['label']) != '') ? $this->modAppCore->rwFilterInput($_GET['label']) : 'pictures';
		if(!$pic_label)
		{
			return $this->_authDenied();
		}
		$auth = $this->_authVerify(3);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else
		{
			/**
			 * Everything is ok, proceed
			 */
			/**
			 * Default values, if no form is processed
			 */
			$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['IMAGE']['ADMIN'];
			$this->modCnt['cnt']['tpl'] = 'imageList';
			$this->modCnt['cnt']['content']['pic_label'] = $pic_label;
			$this->modCnt['cnt']['content']['pic_list'] = array();
			$this->modCnt['cnt']['content']['form']['thumb_size'] = '150';
			$this->modCnt['cnt']['content']['form']['pic_label'] = 'pictures';
			$this->modCnt['cnt']['content']['form']['pic_title'] = '';
			$this->modCnt['cnt']['content']['form_err'] = array();
			/**
			 * POST Content-length PHP "bug"
			 */
			$error = function_exists('error_get_last') ? error_get_last() : NULL;
			if(is_array($error) && (FALSE !== strpos($error['message'], 'POST Content-Length of')))
			{
				$this->modCnt['cnt']['content']['form_err'][] = $this->modLang['FORM']['FILE_ERR'].$this->modLang['MOD']['IMAGE']['IMAGE_FILE'].$this->modLang['FORM']['FILE_1'];
			}
			/**
			 * Process thumbnail creation form
			 */
			if(isset($_POST['thumb_save']))
			{
				/**
				 * Form data that should be processed
				 */
				$form = array();
				$form[] = array('title'=>'pic_id','name'=>'pic_id','type'=>'int','req'=>TRUE);
				$form[] = array('title'=>$this->modLang['MOD']['THUMBNAIL']['THUMB_SIZE'],'name'=>'thumb_size','type'=>'numberNotNull','req'=>TRUE);
				/**
				 * Process form data
				 */
				list($errForm, $dataForm) = $this->_processForm($form);
				$te = count($errForm);
				if($te == 0)
				{
					/**
					 * Data ok, do the stuff
					 */
					/**
					 * Get image data
					 */
					$ri = $this->modDb->dbSelect('pic_title, pic_file, pic_type, pic_width, pic_height, pic_group', _APP_PRE.'_web_pictures', "pic_id = '{$dataForm['pic_id']}' AND pic_group = '{$_SESSION[_APP_PRE.'_usr_grp']}' AND pic_deleted = '0'", NULL, 1);
					$ti = $ri->dbNumRows();
					if($ti != 1)
					{
						trigger_error('image doesn\'t exist', E_USER_ERROR);
					}
					$r=$ri->dbFetchArray();

					// generate thumbnail of desired size
					$thumb = $this->modAppCore->rwActivateExt('Thumb');
					$thumb->set_cacheDir(_APP_DIR_THUMB);
					$thumb->set_maxSize($dataForm['thumb_size']);
					$thumb->set_thumbFormat($r['pic_type']);
					$thumb->set_thumbSuffix('_'.$dataForm['thumb_size']);
					$thumb->set_thumbUseExt(TRUE);
					$r['pic_ext'] = image_type_to_extension($r['pic_type'], TRUE);
					if(!is_file(_APP_DIR_IMG.$r['pic_file'].$r['pic_ext']))
					{
						trigger_error('image doesn\'t exist', E_USER_ERROR);
					}
					$dataDb['pic_id'] = $dataForm['pic_id'];
					$dataDb['thumb_label'] = $pic_label;
					$dataDb['thumb_title'] = $r['pic_title'];
					$dataDb['thumb_file'] = $thumb->thumb(_APP_DIR_IMG.$r['pic_file'].$r['pic_ext']);
					$dataDb['thumb_type'] = $r['pic_type'];
					$thumbExt = image_type_to_extension($dataDb['thumb_type'], TRUE);
					if(!is_file(_APP_DIR_THUMB.$dataDb['thumb_file'].$thumbExt))
					{
						trigger_error('thumbnail not created', E_USER_ERROR);
					}
					$info = getimagesize(_APP_DIR_THUMB.$dataDb['thumb_file'].$thumbExt);
					$dataDb['thumb_width'] = $info['0'];
					$dataDb['thumb_height'] = $info['1'];
					$dataDb['thumb_group'] = $r['pic_group'];
					$dataDb['thumb_created_user'] = $_SESSION[_APP_PRE.'_usr_id'];
					if($this->modDb->dbInsert(_APP_PRE.'_web_thumbs', NULL, $dataDb))
					{
						/**
						 * Insert successfull, redirect to thumbnail page
						 * with new label
						 */
						header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/thumbnailList/label/'.$dataDb['thumb_label']);
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
				else
				{
					/**
					 * Errors occured
					 */
					$this->modCnt['cnt']['content']['form']['thumb_size'] = isset($_POST['thumb_size']) ? $_POST['thumb_size'] : '150';
					$this->modCnt['cnt']['content']['form_err'] = $errForm;
				}
			}
			/**
			 * Process image add form
			 */
			if(isset($_POST['image_save']))
			{
				/**
				 * Form data that should be processed
				 */
				$form = array();
				$form[]= array('title'=>$this->modLang['MOD']['IMAGE']['IMAGE_LABEL'],'name'=>'pic_label','type'=>'text','req'=>TRUE);
				$form[]= array('title'=>$this->modLang['MOD']['IMAGE']['IMAGE_TITLE'],'name'=>'pic_title','type'=>'text','req'=>TRUE);
				/**
				 * Image data that should pe processed
				 */
				$upload = array();
				$upload[]= array('title'=>$this->modLang['MOD']['IMAGE']['IMAGE_FILE'],'name'=>'pic_file','type'=>'picture','req'=>TRUE);
				/**
				 * Process form data
				 */
				list($errForm, $dataForm) = $this->_processForm($form);
				/**
				 * Process image data
				 */
				list($errUpload, $dataUpload) = $this->_processUpload($upload);
				/**
				 * Check for errors
				 */
				$err = array_merge($errForm, $errUpload);
				$te = count($err);
				if($te == 0)
				{
					/**
					 * Upload ok, data ok.
					 * Add to database
					 */
					$dataDb['pic_group'] = $_SESSION[_APP_PRE.'_usr_grp'];
					$dataDb['pic_created_user'] = $_SESSION[_APP_PRE.'_usr_id'];
					$data = array_merge($dataForm, $dataUpload, $dataDb);
					if($this->modDb->dbInsert(_APP_PRE.'_web_pictures', NULL, $data))
					{
						/**
						 * Insert successfull, redirect to same page
						 * with new label
						 */
						header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/imageList/label/'.$dataForm['pic_label']);
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
				else
				{
					/**
					 * Errors occured
					 */
					$this->modCnt['cnt']['content']['form']['pic_label'] = isset($_POST['pic_label']) ? $_POST['pic_label'] : 'pictures';
					$this->modCnt['cnt']['content']['form']['pic_title'] = isset($_POST['pic_title']) ? $_POST['pic_title'] : '';
					$this->modCnt['cnt']['content']['form_err'] = $err;
				}
			}
			/**
			 * Get all labels
			 */
			$rl = $this->modDb->dbSelect('DISTINCT pic_label', _APP_PRE.'_web_pictures', "pic_group = '{$_SESSION[_APP_PRE.'_usr_grp']}' AND pic_deleted = '0'", NULL);
			$tl = $rl->dbNumRows();
			$this->modCnt['cnt']['content']['pic_labels'] = array();
			if($tl>0)
			{
				while($r = $rl->dbFetchArray())
				{
					$this->modCnt['cnt']['content']['pic_labels'][] = $r;
				}
			}
			/**
			 * Pictures data
			 */
			$rs = $this->modDb->dbSelect('pic_id, pic_title, pic_file, pic_type, pic_width, pic_height', _APP_PRE.'_web_pictures', "pic_group = '{$_SESSION[_APP_PRE.'_usr_grp']}' AND pic_label = '{$pic_label}' AND pic_deleted = '0'", NULL);
			$t = $rs->dbNumRows();
			$pic_list = array();
			if($t > 0)
			{
				$thumb = $this->modAppCore->rwActivateExt('Thumb');
				$thumb->set_cacheDir(_APP_DIR_TMP);
				$thumb->set_maxSize(120);
				$thumb->set_thumbFormat(3); //png = 3, jpeg = 2, gif = 1
				while($r = $rs->dbFetchArray())
				{
					/**
					 * Get image information
					 */
					$r['pic_ext']  = image_type_to_extension($r['pic_type'], TRUE);
					$r['pic_preview'] = $thumb->thumb(_APP_DIR_IMG.$r['pic_file'].$r['pic_ext']);
					$pic_list[] = $r;
				}
				$this->modCnt['cnt']['content']['pic_list'] = $pic_list;
			}
			return $this->modCnt;
		}
	}
	public function imageDelete()
	{
		/**
		 * Get image type and id
		 */
		$img_id = (isset($_GET['id']) && $this->modAppCore->rwCheckInt($_GET['id'])) ? $_GET['id'] : NULL;
		$img_types = array('image', 'thumbnail');
		$img_type = (isset($_GET['type']) && in_array($_GET['type'], $img_types)) ? $_GET['type'] : NULL;
		if(!$img_id || !$img_type)
		{
			return $this->_authDenied();
		}
		/**
		 * Set image type
		 */
		switch($img_type)
		{
			case 'image' :
				{
					$img_table = _APP_PRE.'_web_pictures';
					$img_prefix = 'pic_';
					$img_dir = _APP_DIR_IMG;
					break;
				}
			case 'thumbnail' :
				{
					$img_table = _APP_PRE.'_web_thumbs';
					$img_prefix = 'thumb_';
					$img_dir = _APP_DIR_THUMB;
					break;
				}
			default :
				{
					break;
				}
		}
		/**
		 * Check image
		 */
		$rs = $this->modDb->dbSelect("{$img_prefix}group, {$img_prefix}label, {$img_prefix}title, {$img_prefix}file, {$img_prefix}type", $img_table, "{$img_prefix}id = '{$img_id}' AND {$img_prefix}deleted = '0'", NULL, 1);
		$t = $rs->dbNumRows();
		if($t != 1)
		{
			trigger_error('image doesn\'t exist', E_USER_ERROR);
		}
		$r = $rs->dbFetchArray();
		$img_group = $r[$img_prefix.'group'];
		$img_label = $r[$img_prefix.'label'];
		$img_title = $r[$img_prefix.'title'];
		$img_file  = $r[$img_prefix.'file'];
		$img_ext   = image_type_to_extension($r[$img_prefix.'type'], TRUE);
		/**
		 * Check "physical" image
		 */
		if(!is_file($img_dir.$img_file.$img_ext))
		{
			trigger_error('image doesn\'t exist', E_USER_ERROR);
		}
		/**
		 * Verify user rights
		 */
		$auth = $this->_authVerify(3, $img_group);
		if($auth !== 'ok')
		{
			return $auth;
		}
		else
		{
			/**
			 * Everything is ok, proceed.
			 */
			$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['IMAGE']['DELETE'];
			$this->modCnt['cnt']['content']['image_id']    = $img_id;
			$this->modCnt['cnt']['content']['image_title'] = $img_title;
			$this->modCnt['cnt']['content']['image_label'] = $img_label;
			$this->modCnt['cnt']['content']['image_type']  = $img_type;
			/**
			 * Check if image is used in content
			 */
			$rc = $this->modDb->dbSelect('cnt_id, pg_id', _APP_PRE.'_web_content', "cnt_body REGEXP '{$img_file}' AND cnt_deleted = '0'", NULL, NULL);
			$tc = $rc->dbNumRows();
			if($tc > 0)
			{
				$this->modCnt['cnt']['content']['items'] = $tc;
				$this->modCnt['cnt']['tpl'] = 'imageDeleteDenied';
				return $this->modCnt;
			}
			/**
			 * Ok to go forward, set template.
			 */
			$this->modCnt['cnt']['tpl'] = 'imageDelete';
			/**
			 * If user is sure to delete, do it
			 */
			$delete = (isset($_GET['delete']) && $_GET['delete'] == 'true') ? TRUE : FALSE;
			if($delete)
			{
				/**
				 * Delete the image and redirect
				 */
				$dataUpdate[$img_prefix.'deleted'] = 1;
				$dataUpdate[$img_prefix.'deleted_time'] = date('Y-m-d H:i:s');
				$dataUpdate[$img_prefix.'deleted_user'] = $_SESSION[_APP_PRE.'_usr_id'];
				if($this->modDb->dbUpdate($img_table, $dataUpdate, "{$img_prefix}id = '{$img_id}'", NULL, 1))
				{
					/**
					 * Move physical image to trash.
					 */
					if(!rename($img_dir.$img_file.$img_ext, _APP_DIR_TRASH.$img_file.$img_ext))
					{
						/**
						 * Needs work
						 */
						trigger_error('delete error', E_USER_ERROR);
					}
					/**
					 * Redirect to action ok message
					 */
					header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/actionOk/type/remove/resource/'.$img_type.'/id/'.$img_id);
					exit;
				}
				else
				{
					/**
					 * Needs work
					 */
					trigger_error('delete error', E_USER_ERROR);
				}
			}
			else
			{
				/**
				 * Display are you sure message
				 */
				return $this->modCnt;
			}
		}
	}
	/**
	 * Successfull action message
	 *
	 * @return mixed content
	 */
	public function actionOk()
	{
		$res = array('page', 'content', 'image', 'thumbnail');
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
							$ri = $this->modDb->dbSelect('pg_id', _APP_PRE.'_web_content', "cnt_id = '{$_GET['id']}'", NULL, 1);
							$t = $ri->dbNumRows();
							$pg_id = 0;
							if($t == 1)
							{
								$pg_id = $ri->dbFetchResult();
							}
							$this->modCnt['cnt']['content'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/pageEdit/id/'.$pg_id;
						}
						else
						{
							$this->modCnt['cnt']['content'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'List';
						}
						$this->modCnt['cnt']['content'][1]['return_title'] = $this->modLang['MOD'][$res_intl]['EDIT'];
						$this->modCnt['cnt']['content'][1]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'Edit/id/'.$_GET['id'];

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
							$ri = $this->modDb->dbSelect('pg_id', _APP_PRE.'_web_content', "cnt_id = '{$_GET['id']}'", NULL, 1);
							$t = $ri->dbNumRows();
							$pg_id = 0;
							if($t == 1)
							{
								$pg_id = $ri->dbFetchResult();
							}
							$this->modCnt['cnt']['content'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/pageEdit/id/'.$pg_id;
						}
						else
						{
							$this->modCnt['cnt']['content'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'List';
						}
						$this->modCnt['cnt']['content'][1]['return_title'] = $this->modLang['MOD'][$res_intl]['EDIT'];
						$this->modCnt['cnt']['content'][1]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'Edit/id/'.$_GET['id'];

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
							$ri = $this->modDb->dbSelect('pg_id', _APP_PRE.'_web_content', "cnt_id = '{$_GET['id']}'", NULL, 1);
							$t = $ri->dbNumRows();
							$pg_id = 0;
							if($t == 1)
							{
								$pg_id = $ri->dbFetchResult();
							}
							$this->modCnt['cnt']['content'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/pageEdit/id/'.$pg_id;
						}
						else
						{
							$this->modCnt['cnt']['content'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'List';
						}

						break;
					}
				default :
					{
						return $this->_authDenied();
						break;
					}
			}
			$this->modCnt['cnt']['tpl'] = 'actionOk';
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
			$this->modCnt['type'] = 'image';
			$this->modCnt['image'] = $captchaObj->display();

			return $this->modCnt;
		}
	}
	/**
	 * Add content - html
	 *
	 * @param integer $pg_id id of containing page
	 * @param integer $cnt_order content order
	 * @return mixed content
	 */
	private function _htmlAdd($pg_id, $cnt_order)
	{
		/**
		 * Default values, when form is not submitted
		 */
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['CONTENT']['ADD'];
		$this->modCnt['cnt']['tpl'] = 'htmlNew';

		$this->modCnt['cnt']['content']['pg_id'] = $pg_id;
		$this->modCnt['cnt']['content']['cnt_body'] = '';
		$this->modCnt['cnt']['content']['cnt_template'] = 'cntHTML';
		$this->modCnt['cnt']['content']['cnt_err'] = array();
		/**
		 * Rich text editor to use
		 * FCKeditor, TinyMCE, or blank
		 */
		$this->modCnt['cnt']['content']['rte'] = 'FCKeditor';
		/**
		 * If form is sent, process request
		 */
		if(isset($_POST['pg_id']) && $_POST['pg_id'] == $pg_id)
		{
			/**
			 * Check page id
			 */
			/**
			 * Form data that should be processed
			 */
			$form = array();
			$form[]= array('title'=>$this->modLang['MOD']['CONTENT']['CONTENT_BODY'],'name'=>'cnt_body','type'=>'html','req'=>TRUE);
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
					header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/actionOk/type/add/resource/content/id/'.$cnt_id);
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
	 * Edit content - html
	 *
	 * @param integer $pg_id id of containing pages
	 * @param integer $cnt_id content id
	 * @return mixed content
	 */
	private function _htmlEdit($pg_id, $cnt_id)
	{
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['CONTENT']['EDIT'];
		$this->modCnt['cnt']['tpl'] = 'htmlEdit';
		$this->modCnt['cnt']['content']['pg_id'] = $pg_id;
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
		/**
		 * Rich text editor to use
		 * FCKeditor, TinyMCE, or blank
		 */
		$this->modCnt['cnt']['content']['rte'] = 'FCKeditor';

		if(isset($_POST['cnt_id']) && ($_POST['cnt_id'] == $cnt_id))
		{
			/**
			 * Form data that should be processed
			 */
			$form = array();
			$form[]= array('title'=>$this->modLang['MOD']['CONTENT']['CONTENT_BODY'],'name'=>'cnt_body','type'=>'html','req'=>TRUE);
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
				header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/actionOk/type/edit/resource/content/id/'.$cnt_id);
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
	 * Delete content - html
	 *
	 * @param integer $cnt_id content id
	 * @param integer $pg_id page id
	 * @return mixed content
	 */
	private function _htmlDelete($cnt_id, $pg_id)
	{
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['CONTENT']['DELETE'];
		$this->modCnt['cnt']['content']['cnt_id'] = $cnt_id;
		$this->modCnt['cnt']['content']['pg_id'] = $pg_id;

		$this->modCnt['cnt']['tpl'] = 'contentDelete';

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
				header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/actionOk/type/remove/resource/content/id/'.$cnt_id);
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
		$this->modCnt['cnt']['tpl'] = 'textNew';

		$this->modCnt['cnt']['content']['pg_id'] = $pg_id;
		$this->modCnt['cnt']['content']['cnt_body'] = '';
		$this->modCnt['cnt']['content']['cnt_template'] = 'cntText';
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
					 * Insert successfull, update order and redirect to mesage page
					 *
					 * get parameters: type of action, id of page
					 */
					$ri = $this->modDb->dbLastInsertId();
					$cnt_id = $ri->dbFetchResult();
					$dataUpdate['cnt_order'] = '{cnt_order+1}';
					$this->modDb->dbUpdate(_APP_PRE.'_web_content', $dataUpdate, "pg_id = {$data['pg_id']} AND cnt_id != '{$cnt_id}' AND cnt_order >= '{$data['cnt_order']}'", NULL, NULL);
					header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/actionOk/type/add/resource/content/id/'.$cnt_id);
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
	 * Edit content - text
	 *
	 * @param integer $pg_id id of containing page
	 * @param integer $cnt_id content id
	 * @return mixed content
	 */
	private function _textEdit($pg_id, $cnt_id)
	{
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['CONTENT']['EDIT'];
		$this->modCnt['cnt']['tpl'] = 'textEdit';
		$this->modCnt['cnt']['content']['pg_id'] = $pg_id;
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
				header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/actionOk/type/edit/resource/content/id/'.$cnt_id);
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
	 * Delete content - text
	 *
	 * @param integer $cnt_id content id
	 * @param integer $pg_id page id
	 * @return mixed content
	 */
	private function _textDelete($cnt_id, $pg_id)
	{
		$this->modCnt['skin']['title'] = $this->modLang['MOD']['TITLE'] . ' - ' . $this->modLang['MOD']['CONTENT']['DELETE'];
		$this->modCnt['cnt']['content']['cnt_id'] = $cnt_id;
		$this->modCnt['cnt']['content']['pg_id'] = $pg_id;

		$this->modCnt['cnt']['tpl'] = 'contentDelete';

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
				header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/actionOk/type/remove/resource/content/id/'.$cnt_id);
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
				$page_list .= '<td class="page_list_lvl page_list_cr">'. $data['items'][$itemId]['pg_level'].'.'.$i.'</td>';
				$page_list .= '<td class="page_list_cr_tt">';
				for($i=0;$i<$data['items'][$itemId]['pg_level'];$i++)
				{
					$page_list .= '&#160;&#160;&#160;';
				}
				$page_list .= $data['items'][$itemId]['pg_title'].'</td>';
				$group = ($data['items'][$itemId]['pg_group_name']) ? $data['items'][$itemId]['pg_group_name'] : '&#160;';
				$page_list .= '<td class="page_list_cr">'. $data['items'][$itemId]['pg_author'].'</td>';
				$page_list .= '<td class="page_list_cr">'. $group.'</td>';
				$page_list .= '<td class="page_list_cr">'. $data['items'][$itemId]['pg_items'] .'</td>';
				$page_list .= '<td class="page_list_cr">';
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/pageNew/parent/'.$data['items'][$itemId]['pg_parent'].'/order/'.$data['items'][$itemId]['pg_order'].'" title="'.$this->modLang['MOD']['PAGE']['ADD_BEFORE'].'">' . '<img class="page_list_act_img" src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_add_before.png" title="'.$this->modLang['MOD']['PAGE']['ADD_BEFORE'].'" alt="'.$this->modLang['MOD']['PAGE']['ADD_BEFORE'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/pageNew/parent/'.$data['items'][$itemId]['pg_parent'].'/order/'.(($data['items'][$itemId]['pg_order'])+1).'" title="'.$this->modLang['MOD']['PAGE']['ADD_AFTER'].'">' . '<img class="page_list_act_img" src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_add_after.png" title="'.$this->modLang['MOD']['PAGE']['ADD_AFTER'].'" alt="'.$this->modLang['MOD']['PAGE']['ADD_AFTER'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/pageAdd/parent/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLang['MOD']['PAGE']['ADD_INSIDE'].'">' . '<img class="page_list_act_img" src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_add_inside.png" title="'.$this->modLang['MOD']['PAGE']['ADD_INSIDE'].'" alt="'.$this->modLang['MOD']['PAGE']['ADD_INSIDE'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'content/'.$data['items'][$itemId]['pg_id'].'-'.$data['items'][$itemId]['pg_alias'].'" title="'.$this->modLang['MOD']['PAGE']['VIEW'].'" target="website">' . '<img class="page_list_act_img" src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_view.png" title="'.$this->modLang['MOD']['PAGE']['VIEW'].'" alt="'.$this->modLang['MOD']['PAGE']['VIEW'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/pageEdit/id/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLang['MOD']['PAGE']['EDIT'].'">' . '<img class="page_list_act_img" src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_edit.png" title="'.$this->modLang['MOD']['PAGE']['EDIT'].'" alt="'.$this->modLang['MOD']['PAGE']['EDIT'].'" />' . '</a>';
				$page_list .= '&#160;';
				$page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/pageDelete/id/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLang['MOD']['PAGE']['DELETE'].'">' . '<img class="page_list_act_img" src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_delete.png" title="'.$this->modLang['MOD']['PAGE']['DELETE'].'" alt="'.$this->modLang['MOD']['PAGE']['DELETE'].'" />' . '</a>';
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
				$blockTags = ($id['type'] == 'html') ? FALSE : TRUE;
				$data[$id['name']] = $this->modAppCore->rwFilterInput($_POST[$id['name']], $blockTags);
				if($id['req'])
				{
					if($data[$id['name']] == '')
					{
						$err[] = $this->modLang['FORM']['FIELD'].$id['title'].$this->modLang['FORM']['IS_EMPTY'];
					}
				}
				switch($id['type'])
				{
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
					case 'intNotNull' :
						{
							if($data[$id['name']] == 0)
							{
								$err[] = $this->modLang['FORM']['FIELD'].$id['title'].$this->modLang['FORM']['IS_INVALID'];
							}
							else if($data[$id['name']] != '' && (!$this->modAppCore->rwCheckInt($data[$id['name']])))
							{
								$err[] = $this->modLang['FORM']['FIELD'].$id['title'].$this->modLang['FORM']['IS_INVALID'];
							}
							break;
						}
					case 'number' :
						{
							if($data[$id['name']] != '' && (!$this->modAppCore->rwCheckInt($data[$id['name']]) && !is_numeric($data[$id['name']]) ))
							{
								$err[] = $this->modLang['FORM']['FIELD'].$id['title'].$this->modLang['FORM']['IS_INVALID'];
							}
							break;
						}
					case 'numberNotNull' :
						{
							if($data[$id['name']] == 0)
							{
								$err[] = $this->modLang['FORM']['FIELD'].$id['title'].$this->modLang['FORM']['IS_INVALID'];
							}
							else if($data[$id['name']] != '' && (!$this->modAppCore->rwCheckInt($data[$id['name']]) && (!is_numeric($data[$id['name']]))))
							{
								$err[] = $this->modLang['FORM']['FIELD'].$id['title'].$this->modLang['FORM']['IS_INVALID'];
							}
							break;
						}
					default :
						{
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
	 * Process file uploads sent through form
	 *
	 * Please note that the parameter is
	 * the form data that SHOULD PE PROCESSED,
	 * not the form itself, which the method
	 * gets form $_FILES.
	 *
	 * @param array $form
	 * @return array errors and processed form data
	 */
	private function _processUpload($upload)
	{
		$err = array();
		$data = array();
		$file_types = array();
		$file_types['picture'] = array("image/jpeg", "image/pjpeg", "image/png", "image/x-png", "image/gif");

		foreach($upload as $id)
		{
			if(isset($_FILES[$id['name']]))
			{
				$file_type  = $_FILES[$id['name']]['type'];
				$file_size  = $_FILES[$id['name']]['size'];
				$file_tname = $_FILES[$id['name']]['tmp_name'];
				$file_error = $_FILES[$id['name']]['error'];
				/**
				 * Check general file stuff
				 */
				switch($file_error)
				{
					case 8 :
						{
							$err[] = $this->modLang['FORM']['FILE_ERR'].$id['title'].$this->modLang['FORM']['FILE_8'];
							break;
						}
					case 7 :
						{
							$err[] = $this->modLang['FORM']['FILE_ERR'].$id['title'].$this->modLang['FORM']['FILE_7'];
							break;
						}
					case 6 :
						{
							$err[] = $this->modLang['FORM']['FILE_ERR'].$id['title'].$this->modLang['FORM']['FILE_6'];
							break;
						}
					case 4 :
						{
							$err[] = $this->modLang['FORM']['FILE_ERR'].$id['title'].$this->modLang['FORM']['FILE_4'];
							break;
						}
					case 3 :
						{
							$err[] = $this->modLang['FORM']['FILE_ERR'].$id['title'].$this->modLang['FORM']['FILE_3'];
							break;
						}
					case 2 :
						{
							$err[] = $this->modLang['FORM']['FILE_ERR'].$id['title'].$this->modLang['FORM']['FILE_2'];
							break;
						}
					case 1 :
						{
							$err[] = $this->modLang['FORM']['FILE_ERR'].$id['title'].$this->modLang['FORM']['FILE_1'];
							break;
						}
					case 0 :
						{
							/**
							 * Check that file was uploaded
							 */
							if(!is_uploaded_file($file_tname))
							{
								$err[] = $this->modLang['FORM']['FILE_ERR'].$id['title'].$this->modLang['FORM']['FILE_FORM'];
								break;
							}
							/**
							 * File uploaded ok,
							 * check type
							 */
							if(!in_array($file_type, $file_types[$id['type']]))
							{
								$err[] = $this->modLang['FORM']['FILE_ERR'].$id['title'].$this->modLang['FORM']['FILE_TYPE'];
								break;
							}
							switch($id['type'])
							{
								case 'picture' :
									{
										$info = getimagesize($file_tname);
										if(!in_array($info['mime'], $file_types[$id['type']]))
										{
											$err[] = $this->modLang['FORM']['FILE_ERR'].$id['title'].$this->modLang['FORM']['FILE_TYPE'];
											break;
										}
										/**
										 * If we got here
										 * everything must be ok.
										 * Try to store the image
										 */
										$file_hash = md5_file($file_tname);
										$file_ext = image_type_to_extension($info['2'], TRUE);
										$file_path = _APP_DIR_IMG.$file_hash.$file_ext;
										if(!move_uploaded_file($file_tname, $file_path))
										{
											$err[] = $this->modLang['FORM']['FILE_ERR'].$id['title'].$this->modLang['FORM']['FILE_SAVE'];
											break;
										}
										$data['pic_file']   = $file_hash;
										$data['pic_type']   = $info['2'];
										$data['pic_width']  = $info['0'];
										$data['pic_height'] = $info['1'];
										break;
									}
							}
							break;
						}
				}
			}
			else
			{
				if($id['req'])
				{
					$err[] = $this->modLang['FORM']['FILE_ERR'].$id['title'].$this->modLang['FORM']['FILE_EMPTY'];
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
	/**
	 * Create administration menu
	 *
	 * @return mixed result
	 */
	private function _makeMenu()
	{
		/**
		 * Menu
		 */
		$this->modCnt['atpl']['menu'] = array();
		$this->modCnt['atpl']['menu']['dir'] = '';
		$this->modCnt['atpl']['menu']['tpl'] = 'menu';
		$this->modCnt['atpl']['menu']['vars'] = array();
		$this->modCnt['atpl']['menu']['vars']['lang'] = $this->modAppCore->rwLang();
		$this->modCnt['atpl']['menu']['vars']['adminMenu'] = array();

		$auth = $this->_authVerify(3);
		if($auth !== 'ok')
		{
			return false;
		}
		else
		{
			/**
			 * Page administration
			 */
			$adminMenu[0]['link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/pageList';
			$adminMenu[0]['title'] = $this->modLang['MOD']['PAGE']['ADMIN'];
			/**
			 * Image administration
			 */
			$adminMenu[1]['link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/imageList';
			$adminMenu[1]['title'] = $this->modLang['MOD']['IMAGE']['ADMIN'];
			/**
			 * Thumbnail administration
			 */
			$adminMenu[2]['link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/thumbnailList';
			$adminMenu[2]['title'] = $this->modLang['MOD']['THUMBNAIL']['ADMIN'];

			$this->modCnt['atpl']['menu']['vars']['adminMenu'] = $adminMenu;

			return true;
		}
	}
}
?>