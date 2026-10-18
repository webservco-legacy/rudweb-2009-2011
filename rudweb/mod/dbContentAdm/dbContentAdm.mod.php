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
 * @package    rwMod
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
 * rw_Mod_dbContentAdm
 *
 * rw_Mod_dbContentAdm module
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwMod
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
        $about['deps']['ext'][] = 'Intl';
        $about['deps']['mod']   = array();
        /**
         * These must be declared
         */
        $out['skin'] = array();
        $out['skin']['meta'] = array();
        $out['cnt'] = array();
        /**
         * Module default content
         *
         * $out['type'] added by default in parent class
         * $out['skin']['dir'] added by default in parent class
         * $out['skin']['tpl'] added by default in parent class
         * $out['skin']['title'] added by default in parent class
         * $out['skin']['meta'] added by default in parent class
         * $out['skin']['lang'] added by default in parent class
         * $out['skin']['langAdm'] added by default in parent class
         */
        $out['type'] = 'Smarty';
        $out['skin']['dir'] = 'admin';
        $out['cnt']['dir'] = 'content';
        $out['cnt']['tpl'] = 'blank';
        $out['cnt']['content'] = array();
        /**
         * Call parent constructor
         */
        parent::__construct($about, $out, $appCore);
        $this->_makeMenu();

        $intl = $this->modAppCore->rwActivateExt('Intl');
        /**
         * Override title in the parent class
         * because we need it to be for admin.
         */
        $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'];
        $this->modOut['skin']['langs'] = $intl->intlMenu('adm');
        $this->modOut['cnt']['content']['langsCnt'] = $intl->intlMenu('cnt');
    }
    /**
     * Default module functionality
     *
     * @return mixed result
     */
    public function _default()
    {
        $auth = $this->_authVerify(2);
        if($auth !== 'ok')
        {
            return $auth;
        }
        else
        {
            return $this->modOut;
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
        $auth = $this->_authVerify(2);
        if($auth !== 'ok')
        {
            return $auth;
        }
        else
        {
            /**
             * Authorization ok, proceed.
             */
            $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['PAGE']['ADMIN'];
            $this->modOut['cnt']['tpl'] = 'pageList';
            /**
             * Prepare pages array
             */
            $pageData = array();
            $pageData['items'] = array();
            $pageData['parents'] = array();
            /**
             * Get data
             */
            $rs = $this->modDb->dbSelect('pg_id, pg_parent, pg_level, pg_order, pg_title, pg_alias, pg_group, pg_created_user', _APP_PRE.'_web_pages', "pg_ln = '{$_SESSION[_APP_PRE.'_cnt_lang']}' AND pg_deleted = '0'", 'pg_parent, pg_order, pg_title', NULL);
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
            $this->modOut['cnt']['content']['page_list'] = $this->_formatPages(0, $pageData);
            return $this->modOut;
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
            $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['PAGE']['ADD'];
            $this->modOut['cnt']['tpl'] = 'pageAdd';
            /**
             * Get data
             */
            $rs = $this->modDb->dbSelect('pg_order, pg_title', _APP_PRE.'_web_pages', "pg_ln = '{$_SESSION[_APP_PRE.'_cnt_lang']}' AND pg_deleted = '0' AND pg_parent = '{$pg_parent}'", 'pg_parent, pg_order, pg_title', NULL);
            $t = $rs->dbNumRows();
            $this->modOut['cnt']['content']['page_list_add'] = array();
            if($t>0)
            {
                while($pageItem = $rs->dbFetchArray())
                {
                    /**
                     * Content items
                     */
                    $this->modOut['cnt']['content']['page_list_add'][] = $pageItem;
                }
            }
            $this->modOut['cnt']['content']['page_parent'] = $pg_parent;
            return $this->modOut;
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
            $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['PAGE']['ADD'];
            $this->modOut['cnt']['tpl'] = 'pageNew';

            $this->modOut['cnt']['content']['page_title'] = '';
            $this->modOut['cnt']['content']['page_kw'] = '';
            $this->modOut['cnt']['content']['page_dsc'] = '';
            $this->modOut['cnt']['content']['page_template'] = 'layout';
            $this->modOut['cnt']['content']['page_err'] = array();
            /**
             * If form is sent, process request
             */
            if(isset($_POST['pg_title']))
            {
                /**
                 * Form data that should be processed
                 */
                $form = array();
                $form[]= array('title'=>$this->modLangAdm['MOD']['PAGE']['PAGE_TITLE'],'name'=>'pg_title','type'=>'text','req'=>TRUE);
                $form[]= array('title'=>$this->modLangAdm['MOD']['PAGE']['PAGE_KEYWORDS'],'name'=>'pg_kw','type'=>'text','req'=>FALSE);
                $form[]= array('title'=>$this->modLangAdm['MOD']['PAGE']['PAGE_DESCRIPTION'],'name'=>'pg_dsc','type'=>'text','req'=>FALSE);
                $form[]= array('title'=>$this->modLangAdm['MOD']['PAGE']['PAGE_TEMPLATE'],'name'=>'pg_template','type'=>'text','req'=>TRUE);
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
                    $this->modOut['cnt']['content']['page_title'] = isset($_POST['pg_title']) ? $_POST['pg_title'] : '';
                    $this->modOut['cnt']['content']['page_kw'] = isset($_POST['pg_kw']) ? $_POST['pg_kw'] : '';
                    $this->modOut['cnt']['content']['page_dsc'] = isset($_POST['pg_dsc']) ? $_POST['pg_dsc'] : '';
                    $this->modOut['cnt']['content']['page_template'] = isset($_POST['pg_template']) ? $_POST['pg_template'] : '';
                    $this->modOut['cnt']['content']['page_err'] = $err;
                    return $this->modOut;
                }
                else
                {
                    /**
                     * Additional data for the db
                     */
                    $data = array();
                    $data['pg_ln'] = $_SESSION[_APP_PRE.'_cnt_lang'];
                    $data['pg_parent'] = $pg_parent;
                    $rl = $this->modDb->dbSelect('pg_level', _APP_PRE.'_web_pages', "pg_id = '{$pg_parent}'", NULL, 1);
                    $tl = $rl->dbNumRows();
                    $data['pg_level'] = ($tl>0) ? ($rl->dbFetchResult()+1) : 0;
                    $ro = $this->modDb->dbSelect('MAX(pg_order)', _APP_PRE.'_web_pages', "pg_parent = '{$pg_parent}' AND pg_ln = '{$_SESSION[_APP_PRE.'_cnt_lang']}'", NULL, 1);
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
                        $dataUpdate['pg_order'] = '{pg_order+1}';
                        $this->modDb->dbUpdate(_APP_PRE.'_web_pages', $dataUpdate, "pg_ln = '{$data['pg_ln']}' AND pg_id != '{$pg_id}' AND pg_order >= '{$data['pg_order']}'", NULL, NULL);
                        header("Location: "._APP_URL.'module/'.$this->modAbout['name'].'/action/actionOk/type/add/resource/page/id/'.$pg_id);
                        exit;
                    }
                    else
                    {
                        /**
                         * Insert error
                         */
                        trigger_error('<u>Database Error</u>: Insert query failed.');
                    }
                }
            }
            else
            {
                /**
                 * No post, initial view
                 */
                return $this->modOut;
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
            trigger_error('<u>Error</u>: Requested page does not exist.');
        }
        $pg_group = $rs->dbFetchResult();
        /**
         * Verify authorization
         */
        $auth = $this->_authVerify(2, $pg_group);
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
            $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['PAGE']['EDIT'];
            $this->modOut['cnt']['tpl'] = 'pageEdit';
            $this->modOut['cnt']['content']['page_id'] = $pg_id;
            /**
             * Page data
             */
            $rs = $this->modDb->dbSelect('pg_title, pg_kw, pg_dsc, pg_template, pg_group', _APP_PRE.'_web_pages', "pg_id = '{$pg_id}'", NULL, 1);
            $t = $rs->dbNumRows();
            if($t != 1)
            {
                trigger_error('<u>Error</u>: Requested page does not exist.');
            }
            $r = $rs->dbFetchArray();
            $this->modOut['cnt']['content']['page_title'] = $r['pg_title'];
            $this->modOut['cnt']['content']['page_kw'] = $r['pg_kw'];
            $this->modOut['cnt']['content']['page_dsc'] = $r['pg_dsc'];
            $this->modOut['cnt']['content']['page_template'] = $r['pg_template'];
            $this->modOut['cnt']['content']['page_err'] = array();
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
                $this->modOut['cnt']['content']['page_content'] = $page_content;
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
                $form[]= array('title'=>$this->modLangAdm['MOD']['PAGE']['PAGE_TITLE'],'name'=>'pg_title','type'=>'text','req'=>TRUE);
                $form[]= array('title'=>$this->modLangAdm['MOD']['PAGE']['PAGE_KEYWORDS'],'name'=>'pg_kw','type'=>'text','req'=>FALSE);
                $form[]= array('title'=>$this->modLangAdm['MOD']['PAGE']['PAGE_DESCRIPTION'],'name'=>'pg_dsc','type'=>'text','req'=>FALSE);
                $form[]= array('title'=>$this->modLangAdm['MOD']['PAGE']['PAGE_TEMPLATE'],'name'=>'pg_template','type'=>'text','req'=>TRUE);
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
                    $this->modOut['cnt']['content']['page_title'] = isset($_POST['pg_title']) ? $_POST['pg_title'] : $r['pg_title'];
                    $this->modOut['cnt']['content']['page_kw'] = isset($_POST['pg_kw']) ? $_POST['pg_kw'] : $r['pg_kw'];
                    $this->modOut['cnt']['content']['page_dsc'] = isset($_POST['pg_dsc']) ? $_POST['pg_dsc'] : $r['pg_dsc'];
                    $this->modOut['cnt']['content']['page_template'] = isset($_POST['pg_template']) ? $_POST['pg_template'] : $r['pg_template'];
                    $this->modOut['cnt']['content']['page_err'] = $err;
                    return $this->modOut;
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
                         * Update error
                         */
                        trigger_error('<u>Database Error</u>: Update query failed.');
                    }
                }
            }
            else
            {
                /**
                 * No post, normal view
                 */
                return $this->modOut;
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
            trigger_error('<u>Error</u>: Requested page does not exist.');
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
            $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['PAGE']['DELETE'];
            $this->modOut['cnt']['content']['page_id'] = $pg_id;
            $this->modOut['cnt']['content']['page_title'] = $pg_title;
            /**
             * Check if page contains other pages
             */
            $rc = $this->modDb->dbSelect('pg_id', _APP_PRE.'_web_pages', "pg_parent = '{$pg_id}' AND pg_deleted = '0'", NULL, NULL);
            $tc = $rc->dbNumRows();
            if($tc > 0)
            {
                $this->modOut['cnt']['tpl'] = 'pageDeleteDenied';
                return $this->modOut;
            }
            /**
             * Ok to go forward, set template.
             */
            $this->modOut['cnt']['tpl'] = 'pageDelete';
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
                     * Delete error
                     */
                    trigger_error('<u>Database Error</u>: Delete query failed.');
                }
            }
            else
            {
                /**
                 * Display are you sure message
                 */
                return $this->modOut;
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
            trigger_error('<u>Error</u>: Requested page does not exist.');
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
            trigger_error('<u>Error</u>: Requested content does not exist.');
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
            trigger_error('<u>Error</u>: Requested page does not exist.');
        }
        $pg_group = $rp->dbFetchResult();
        $auth = $this->_authVerify(2, $pg_group);
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
            trigger_error('<u>Error</u>: Requested content does not exist.');
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
            trigger_error('<u>Error</u>: Requested page does not exist.');
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
     * Thumbnail administration (popup)
     *
     * @return mixed content
     */
    public function thumbnailListPop()
    {
        return $this->thumbnailList(TRUE);
    }
    /**
     * Thumbnail administration
     *
     * @return mixed content
     */
    public function thumbnailList($pop=FALSE)
    {
        $thumb_label = (isset($_GET['label']) && $this->modAppCore->rwFilterInput($_GET['label']) != '') ? $this->modAppCore->rwFilterInput($_GET['label']) : 'pictures';
        if(!$thumb_label)
        {
            return $this->_authDenied();
        }
        $auth = $this->_authVerify(2);
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
            $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['THUMBNAIL']['ADMIN'];
            $this->modOut['cnt']['tpl'] = 'thumbnailList';
            if($pop)
            {
                $this->modOut['skin']['tpl'] = 'layoutPop';
                $this->modOut['cnt']['tpl'] = 'thumbnailListPop';
            }
            $this->modOut['cnt']['content']['thumb_label'] = $thumb_label;
            $this->modOut['cnt']['content']['thumb_list'] = array();

            /**
             * Get all labels
             */
            $rl = $this->modDb->dbSelect('DISTINCT thumb_label', _APP_PRE.'_web_thumbs', "thumb_group = '{$_SESSION[_APP_PRE.'_usr_grp']}' AND thumb_deleted = '0'", NULL, NULL);
            $tl = $rl->dbNumRows();
            $this->modOut['cnt']['content']['thumb_labels'] = array();
            if($tl>0)
            {
                while($r = $rl->dbFetchArray())
                {
                    $this->modOut['cnt']['content']['thumb_labels'][] = $r;
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
                //xxx
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
                $this->modOut['cnt']['content']['thumb_list'] = $thumb_list;
            }
            return $this->modOut;
        }
    }
    /**
     * Image administration (popup)
     *
     * @return mixed content
     */
    public function imageListPop()
    {
        return $this->imageList(TRUE);
    }
    /**
     * Image administration
     *
     * @return mixed content
     */
    public function imageList($pop=FALSE)
    {
        $pic_label = (isset($_GET['label']) && $this->modAppCore->rwFilterInput($_GET['label']) != '') ? $this->modAppCore->rwFilterInput($_GET['label']) : 'pictures';
        if(!$pic_label)
        {
            return $this->_authDenied();
        }
        $auth = $this->_authVerify(2);
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
            $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['IMAGE']['ADMIN'];
            $this->modOut['cnt']['tpl'] = 'imageList';
            if($pop)
            {
                $this->modOut['skin']['tpl'] = 'layoutPop';
                $this->modOut['cnt']['tpl'] = 'imageListPop';
            }
            $this->modOut['cnt']['content']['pic_label'] = $pic_label;
            $this->modOut['cnt']['content']['pic_list'] = array();
            $this->modOut['cnt']['content']['form']['thumb_size'] = '150';
            $this->modOut['cnt']['content']['form']['pic_label'] = 'pictures';
            $this->modOut['cnt']['content']['form']['pic_title'] = '';
            $this->modOut['cnt']['content']['form_err'] = array();
            /**
             * POST Content-length PHP "bug"
             */
            $error = function_exists('error_get_last') ? error_get_last() : NULL;
            if(is_array($error) && (FALSE !== strpos($error['message'], 'POST Content-Length of')))
            {
                $this->modOut['cnt']['content']['form_err'][] = $this->modLangAdm['FORM']['FILE_ERR'].$this->modLangAdm['MOD']['IMAGE']['IMAGE_FILE'].$this->modLangAdm['FORM']['FILE_1'];
            }
            /**
             * Process thumbnail creation form
             */
            if(isset($_POST['thumb_save']))
            {
                /**
                 * Verify authorization again
                 */
                $auth = $this->_authVerify(3);
                if($auth !== 'ok')
                {
                    return $auth;
                }
                /**
                 * Form data that should be processed
                 */
                $form = array();
                $form[] = array('title'=>'pic_id','name'=>'pic_id','type'=>'int','req'=>TRUE);
                $form[] = array('title'=>$this->modLangAdm['MOD']['THUMBNAIL']['THUMB_SIZE'],'name'=>'thumb_size','type'=>'numberNotNull','req'=>TRUE);
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
                        trigger_error('<u>Image Error</u>: Image reference does not exist.');
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
                        trigger_error('<u>Image Error</u>: Image file does not exist.');
                    }
                    $dataDb['pic_id'] = $dataForm['pic_id'];
                    $dataDb['thumb_label'] = $pic_label;
                    $dataDb['thumb_title'] = $r['pic_title'];
                    $dataDb['thumb_file'] = $thumb->thumb(_APP_DIR_IMG.$r['pic_file'].$r['pic_ext']);
                    $dataDb['thumb_type'] = $r['pic_type'];
                    $thumbExt = image_type_to_extension($dataDb['thumb_type'], TRUE);
                    if(!is_file(_APP_DIR_THUMB.$dataDb['thumb_file'].$thumbExt))
                    {
                        trigger_error('<u>Image Error</u>: Thumbnail file creation failed.');
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
                         * Insert failed
                         */
                        trigger_error('<u>Database Error</u>: Insert query failed.');
                    }
                }
                else
                {
                    /**
                     * Errors occured
                     */
                    $this->modOut['cnt']['content']['form']['thumb_size'] = isset($_POST['thumb_size']) ? $_POST['thumb_size'] : '150';
                    $this->modOut['cnt']['content']['form_err'] = $errForm;
                }
            }
            /**
             * Process image add form
             */
            if(isset($_POST['image_save']))
            {
                /**
                 * Verify authorization again
                 */
                $auth = $this->_authVerify(3);
                if($auth !== 'ok')
                {
                    return $auth;
                }
                /**
                 * Form data that should be processed
                 */
                $form = array();
                $form[]= array('title'=>$this->modLangAdm['MOD']['IMAGE']['IMAGE_LABEL'],'name'=>'pic_label','type'=>'text','req'=>TRUE);
                $form[]= array('title'=>$this->modLangAdm['MOD']['IMAGE']['IMAGE_TITLE'],'name'=>'pic_title','type'=>'text','req'=>TRUE);
                /**
                 * Image data that should pe processed
                 */
                $upload = array();
                $upload[]= array('title'=>$this->modLangAdm['MOD']['IMAGE']['IMAGE_FILE'],'name'=>'pic_file','type'=>'picture','req'=>TRUE);
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
                         * Inser failed
                         */
                        trigger_error('<u>Database Error</u>: Insert query failed.');
                    }
                }
                else
                {
                    /**
                     * Errors occured
                     */
                    $this->modOut['cnt']['content']['form']['pic_label'] = isset($_POST['pic_label']) ? $_POST['pic_label'] : 'pictures';
                    $this->modOut['cnt']['content']['form']['pic_title'] = isset($_POST['pic_title']) ? $_POST['pic_title'] : '';
                    $this->modOut['cnt']['content']['form_err'] = $err;
                }
            }
            /**
             * Get all labels
             */
            $rl = $this->modDb->dbSelect('DISTINCT pic_label', _APP_PRE.'_web_pictures', "pic_group = '{$_SESSION[_APP_PRE.'_usr_grp']}' AND pic_deleted = '0'", NULL);
            $tl = $rl->dbNumRows();
            $this->modOut['cnt']['content']['pic_labels'] = array();
            if($tl>0)
            {
                while($r = $rl->dbFetchArray())
                {
                    $this->modOut['cnt']['content']['pic_labels'][] = $r;
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
                $this->modOut['cnt']['content']['pic_list'] = $pic_list;
            }
            return $this->modOut;
        }
    }
    public function imageDelete()
    {
        /**
         * Verify authorization again
         */
        $auth = $this->_authVerify(3);
        if($auth !== 'ok')
        {
            return $auth;
        }
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
            trigger_error('<u>Image Error</u>: Image reference does not exist.');
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
            trigger_error('<u>Image Error</u>: Image file does not exist.');
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
            $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['IMAGE']['DELETE'];
            $this->modOut['cnt']['content']['image_id']    = $img_id;
            $this->modOut['cnt']['content']['image_title'] = $img_title;
            $this->modOut['cnt']['content']['image_label'] = $img_label;
            $this->modOut['cnt']['content']['image_type']  = $img_type;
            /**
             * Check if image is used in content
             */
            $rc = $this->modDb->dbSelect('cnt_id, pg_id', _APP_PRE.'_web_content', "cnt_body REGEXP '{$img_file}' AND cnt_deleted = '0'", NULL, NULL);
            $tc = $rc->dbNumRows();
            if($tc > 0)
            {
                $this->modOut['cnt']['content']['items'] = $tc;
                $this->modOut['cnt']['tpl'] = 'imageDeleteDenied';
                return $this->modOut;
            }
            /**
             * Ok to go forward, set template.
             */
            $this->modOut['cnt']['tpl'] = 'imageDelete';
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
                         * Moving failed
                         */
                        trigger_error('<u>Image Error</u>: Move image to trash failed.');
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
                     * Delete failed
                     */
                    trigger_error('<u>Database Error</u>: Delete query failed.');
                }
            }
            else
            {
                /**
                 * Display are you sure message
                 */
                return $this->modOut;
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
        $auth = $this->_authVerify(2);
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
                        $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['FORM']['ADD_OK'];

                        $this->modOut['cnt']['content']['link'][0]['return_title'] = $this->modLangAdm['MOD'][$res_intl]['ADMIN'];
                        if($_GET['resource'] == 'content')
                        {
                            $ri = $this->modDb->dbSelect('pg_id', _APP_PRE.'_web_content', "cnt_id = '{$_GET['id']}'", NULL, 1);
                            $t = $ri->dbNumRows();
                            $pg_id = 0;
                            if($t == 1)
                            {
                                $pg_id = $ri->dbFetchResult();
                            }
                            $this->modOut['cnt']['content']['link'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/pageEdit/id/'.$pg_id;
                        }
                        else
                        {
                            $this->modOut['cnt']['content']['link'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'List';
                        }
                        $this->modOut['cnt']['content']['link'][1]['return_title'] = $this->modLangAdm['MOD'][$res_intl]['EDIT'];
                        $this->modOut['cnt']['content']['link'][1]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'Edit/id/'.$_GET['id'];
                        break;
                    }
                case 'edit' :
                    {
                        /**
                         * Data was edited, go back to edited resource
                         */
                        $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['FORM']['EDIT_OK'];

                        $this->modOut['cnt']['content']['link'][0]['return_title'] = $this->modLangAdm['MOD'][$res_intl]['ADMIN'];
                        if($_GET['resource'] == 'content')
                        {
                            $ri = $this->modDb->dbSelect('pg_id', _APP_PRE.'_web_content', "cnt_id = '{$_GET['id']}'", NULL, 1);
                            $t = $ri->dbNumRows();
                            $pg_id = 0;
                            if($t == 1)
                            {
                                $pg_id = $ri->dbFetchResult();
                            }
                            $this->modOut['cnt']['content']['link'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/pageEdit/id/'.$pg_id;
                        }
                        else
                        {
                            $this->modOut['cnt']['content']['link'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'List';
                        }
                        $this->modOut['cnt']['content']['link'][1]['return_title'] = $this->modLangAdm['MOD'][$res_intl]['EDIT'];
                        $this->modOut['cnt']['content']['link'][1]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'Edit/id/'.$_GET['id'];

                        break;
                    }
                case 'remove' :
                    {
                        /**
                         * Data was removed, go back to resource list
                         */
                        $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['FORM']['REMOVE_OK'];

                        $this->modOut['cnt']['content']['link'][0]['return_title'] = $this->modLangAdm['MOD'][$res_intl]['ADMIN'];
                        if($_GET['resource'] == 'content')
                        {
                            $ri = $this->modDb->dbSelect('pg_id', _APP_PRE.'_web_content', "cnt_id = '{$_GET['id']}'", NULL, 1);
                            $t = $ri->dbNumRows();
                            $pg_id = 0;
                            if($t == 1)
                            {
                                $pg_id = $ri->dbFetchResult();
                            }
                            $this->modOut['cnt']['content']['link'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/pageEdit/id/'.$pg_id;
                        }
                        else
                        {
                            $this->modOut['cnt']['content']['link'][0]['return_link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/'.$_GET['resource'].'List';
                        }

                        break;
                    }
                default :
                    {
                        return $this->_authDenied();
                        break;
                    }
            }
            $this->modOut['cnt']['tpl'] = 'actionOk';
            return $this->modOut;
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
            $this->modOut['type'] = 'image';
            $this->modOut['image'] = $captchaObj->display();

            return $this->modOut;
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
        $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['CONTENT']['ADD'];
        $this->modOut['cnt']['tpl'] = 'htmlNew';

        $this->modOut['cnt']['content']['pg_id'] = $pg_id;
        $this->modOut['cnt']['content']['cnt_body'] = '';
        $this->modOut['cnt']['content']['cnt_template'] = 'cntHTML';
        $this->modOut['cnt']['content']['cnt_err'] = array();
        /**
         * Rich text editor to use
         * FCKeditor, TinyMCE, or blank
         */
        $this->modOut['cnt']['content']['rte'] = 'FCKeditor';
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
            $form[]= array('title'=>$this->modLangAdm['MOD']['CONTENT']['CONTENT_BODY'],'name'=>'cnt_body','type'=>'html','req'=>TRUE);
            $form[]= array('title'=>$this->modLangAdm['MOD']['CONTENT']['CONTENT_TEMPLATE'],'name'=>'cnt_template','type'=>'text','req'=>TRUE);
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
                $this->modOut['cnt']['content']['cnt_body'] = isset($_POST['cnt_body']) ? $_POST['cnt_body'] : '';
                $this->modOut['cnt']['content']['cnt_template'] = isset($_POST['cnt_template']) ? $_POST['cnt_template'] : '';
                $this->modOut['cnt']['content']['cnt_err'] = $err;
                return $this->modOut;
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
                     * Insert failed
                     */
                    trigger_error('<u>Database Error</u>: Insert query failed.');
                }
            }
        }
        else
        {
            /**
             * No post, initial view
             */
            return $this->modOut;
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
        $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['CONTENT']['EDIT'];
        $this->modOut['cnt']['tpl'] = 'htmlEdit';
        $this->modOut['cnt']['content']['pg_id'] = $pg_id;
        $this->modOut['cnt']['content']['cnt_id'] = $cnt_id;
        /**
         * Content data
         */
        $rs = $this->modDb->dbSelect('cnt_body, cnt_template', _APP_PRE.'_web_content', "cnt_id = '{$cnt_id}'", NULL, 1);
        $t = $rs->dbNumRows();
        if($t != 1)
        {
            trigger_error('<u>Error</u>: Requested content does not exist.');
        }
        $r = $rs->dbFetchArray();
        $this->modOut['cnt']['content']['cnt_body'] = $r['cnt_body'];
        $this->modOut['cnt']['content']['cnt_template'] = $r['cnt_template'];
        $this->modOut['cnt']['content']['cnt_err'] = array();
        /**
         * Rich text editor to use
         * FCKeditor, TinyMCE, or blank
         */
        $this->modOut['cnt']['content']['rte'] = 'FCKeditor';

        if(isset($_POST['cnt_id']) && ($_POST['cnt_id'] == $cnt_id))
        {
            /**
             * Form data that should be processed
             */
            $form = array();
            $form[]= array('title'=>$this->modLangAdm['MOD']['CONTENT']['CONTENT_BODY'],'name'=>'cnt_body','type'=>'html','req'=>TRUE);
            $form[]= array('title'=>$this->modLangAdm['MOD']['CONTENT']['CONTENT_TEMPLATE'],'name'=>'cnt_template','type'=>'text','req'=>TRUE);
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
                $this->modOut['cnt']['content']['cnt_body'] = isset($_POST['cnt_body']) ? $_POST['cnt_body'] : $r['cnt_body'];
                $this->modOut['cnt']['content']['cnt_template'] = isset($_POST['cnt_template']) ? $_POST['cnt_template'] : $r['cnt_template'];
                $this->modOut['cnt']['content']['cnt_err'] = $err;
                return $this->modOut;
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
                 * Update failed
                 */
                trigger_error('<u>Database Error</u>: Update query failed.');
            }
        }
        else
        {
            return $this->modOut;
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
        $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['CONTENT']['DELETE'];
        $this->modOut['cnt']['content']['cnt_id'] = $cnt_id;
        $this->modOut['cnt']['content']['pg_id'] = $pg_id;

        $this->modOut['cnt']['tpl'] = 'contentDelete';

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
                /**
                 * Delete failed
                 */
                trigger_error('<u>Database Error</u>: Delete query failed.');
            }
        }
        else
        {
            /**
             * Display message
             */
            return $this->modOut;
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
        $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['CONTENT']['ADD'];
        $this->modOut['cnt']['tpl'] = 'textNew';

        $this->modOut['cnt']['content']['pg_id'] = $pg_id;
        $this->modOut['cnt']['content']['cnt_body'] = '';
        $this->modOut['cnt']['content']['cnt_template'] = 'cntText';
        $this->modOut['cnt']['content']['cnt_err'] = array();
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
            $form[]= array('title'=>$this->modLangAdm['MOD']['CONTENT']['CONTENT_BODY'],'name'=>'cnt_body','type'=>'text','req'=>TRUE);
            $form[]= array('title'=>$this->modLangAdm['MOD']['CONTENT']['CONTENT_TEMPLATE'],'name'=>'cnt_template','type'=>'text','req'=>TRUE);
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
                $this->modOut['cnt']['content']['cnt_body'] = isset($_POST['cnt_body']) ? $_POST['cnt_body'] : '';
                $this->modOut['cnt']['content']['cnt_template'] = isset($_POST['cnt_template']) ? $_POST['cnt_template'] : '';
                $this->modOut['cnt']['content']['cnt_err'] = $err;
                return $this->modOut;
            }
            else
            {
                /**
                 * Additional data for the db
                 */
                $data = array();
                $data['pg_id'] = $pg_id;
                $ro = $this->modDb->dbSelect('MAX(cnt_order)', _APP_PRE.'_web_content', "pg_id = '{$pg_id}' AND cnt_deleted = '0'", NULL, 1);
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
                     * Insert failed
                     */
                    trigger_error('<u>Database Error</u>: Insert query failed.');
                }
            }
        }
        else
        {
            /**
             * No post, initial view
             */
            return $this->modOut;
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
        $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['CONTENT']['EDIT'];
        $this->modOut['cnt']['tpl'] = 'textEdit';
        $this->modOut['cnt']['content']['pg_id'] = $pg_id;
        $this->modOut['cnt']['content']['cnt_id'] = $cnt_id;
        /**
         * Content data
         */
        $rs = $this->modDb->dbSelect('cnt_body, cnt_template', _APP_PRE.'_web_content', "cnt_id = '{$cnt_id}'", NULL, 1);
        $t = $rs->dbNumRows();
        if($t != 1)
        {
            trigger_error('<u>Error</u>: Requested content does not exist.');
        }
        $r = $rs->dbFetchArray();
        $this->modOut['cnt']['content']['cnt_body'] = $r['cnt_body'];
        $this->modOut['cnt']['content']['cnt_template'] = $r['cnt_template'];
        $this->modOut['cnt']['content']['cnt_err'] = array();
        if(isset($_POST['cnt_id']) && ($_POST['cnt_id'] == $cnt_id))
        {
            /**
             * Form data that should be processed
             */
            $form = array();
            $form[]= array('title'=>$this->modLangAdm['MOD']['CONTENT']['CONTENT_BODY'],'name'=>'cnt_body','type'=>'text','req'=>TRUE);
            $form[]= array('title'=>$this->modLangAdm['MOD']['CONTENT']['CONTENT_TEMPLATE'],'name'=>'cnt_template','type'=>'text','req'=>TRUE);
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
                $this->modOut['cnt']['content']['cnt_body'] = isset($_POST['cnt_body']) ? $_POST['cnt_body'] : $r['cnt_body'];
                $this->modOut['cnt']['content']['cnt_template'] = isset($_POST['cnt_template']) ? $_POST['cnt_template'] : $r['cnt_template'];
                $this->modOut['cnt']['content']['cnt_err'] = $err;
                return $this->modOut;
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
                 * Update failed
                 */
                trigger_error('<u>Database Error</u>: Update query failed.');
            }
        }
        else
        {
            return $this->modOut;
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
        $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['MOD']['CONTENT']['DELETE'];
        $this->modOut['cnt']['content']['cnt_id'] = $cnt_id;
        $this->modOut['cnt']['content']['pg_id'] = $pg_id;

        $this->modOut['cnt']['tpl'] = 'contentDelete';

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
                /**
                 * Delete failed
                 */
                trigger_error('<u>Delete Error</u>: Delete query failed.');
            }
        }
        else
        {
            /**
             * Display message
             */
            return $this->modOut;
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
                for($j=0;$j<$data['items'][$itemId]['pg_level'];$j++)
                {
                    $page_list .= '&#160;&#160;&#160;';
                }
                $page_list .= $data['items'][$itemId]['pg_title'].'</td>';
                $group = ($data['items'][$itemId]['pg_group_name']) ? $data['items'][$itemId]['pg_group_name'] : '&#160;';
                $page_list .= '<td class="page_list_cr">'. $data['items'][$itemId]['pg_author'].'</td>';
                $page_list .= '<td class="page_list_cr">'. $group.'</td>';
                $page_list .= '<td class="page_list_cr">'. $data['items'][$itemId]['pg_items'] .'</td>';
                $page_list .= '<td class="page_list_cr">';
                $page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/pageNew/parent/'.$data['items'][$itemId]['pg_parent'].'/order/'.$data['items'][$itemId]['pg_order'].'" title="'.$this->modLangAdm['MOD']['PAGE']['ADD_BEFORE'].'">' . '<img class="page_list_act_img" src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_add_before.png" title="'.$this->modLangAdm['MOD']['PAGE']['ADD_BEFORE'].'" alt="'.$this->modLangAdm['MOD']['PAGE']['ADD_BEFORE'].'" />' . '</a>';
                $page_list .= '&#160;';
                $page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/pageNew/parent/'.$data['items'][$itemId]['pg_parent'].'/order/'.(($data['items'][$itemId]['pg_order'])+1).'" title="'.$this->modLangAdm['MOD']['PAGE']['ADD_AFTER'].'">' . '<img class="page_list_act_img" src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_add_after.png" title="'.$this->modLangAdm['MOD']['PAGE']['ADD_AFTER'].'" alt="'.$this->modLangAdm['MOD']['PAGE']['ADD_AFTER'].'" />' . '</a>';
                $page_list .= '&#160;';
                $page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/pageAdd/parent/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLangAdm['MOD']['PAGE']['ADD_INSIDE'].'">' . '<img class="page_list_act_img" src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_add_inside.png" title="'.$this->modLangAdm['MOD']['PAGE']['ADD_INSIDE'].'" alt="'.$this->modLangAdm['MOD']['PAGE']['ADD_INSIDE'].'" />' . '</a>';
                $page_list .= '&#160;';
                $page_list .= '<a href="'._APP_URL.'content/'.$data['items'][$itemId]['pg_id'].'-'.$data['items'][$itemId]['pg_alias'].'" title="'.$this->modLangAdm['MOD']['PAGE']['VIEW'].'" target="website">' . '<img class="page_list_act_img" src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_view.png" title="'.$this->modLangAdm['MOD']['PAGE']['VIEW'].'" alt="'.$this->modLangAdm['MOD']['PAGE']['VIEW'].'" />' . '</a>';
                $page_list .= '&#160;';
                $page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/pageEdit/id/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLangAdm['MOD']['PAGE']['EDIT'].'">' . '<img class="page_list_act_img" src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_edit.png" title="'.$this->modLangAdm['MOD']['PAGE']['EDIT'].'" alt="'.$this->modLangAdm['MOD']['PAGE']['EDIT'].'" />' . '</a>';
                $page_list .= '&#160;';
                $page_list .= '<a href="'._APP_URL.'module/'.$this->modAbout['name'].'/action/pageDelete/id/'.$data['items'][$itemId]['pg_id'].'" title="'.$this->modLangAdm['MOD']['PAGE']['DELETE'].'">' . '<img class="page_list_act_img" src="'.$_SESSION[_APP_PRE.'_skin_url'].'admin/graphics/icons/page_delete.png" title="'.$this->modLangAdm['MOD']['PAGE']['DELETE'].'" alt="'.$this->modLangAdm['MOD']['PAGE']['DELETE'].'" />' . '</a>';
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
                        $err[] = $this->modLangAdm['FORM']['FIELD'].$id['title'].$this->modLangAdm['FORM']['IS_EMPTY'];
                    }
                }
                switch($id['type'])
                {
                    case 'email' :
                        {
                            if($data[$id['name']] != '' && !$this->modAppCore->rwCheckEmail($data[$id['name']]))
                            {
                                $err[] = $this->modLangAdm['FORM']['FIELD'].$id['title'].$this->modLangAdm['FORM']['IS_INVALID'];
                            }
                            break;
                        }
                    case 'int' :
                        {
                            if($data[$id['name']] != '' && !$this->modAppCore->rwCheckInt($data[$id['name']]))
                            {
                                $err[] = $this->modLangAdm['FORM']['FIELD'].$id['title'].$this->modLangAdm['FORM']['IS_INVALID'];
                            }
                            break;
                        }
                    case 'intNotNull' :
                        {
                            if($data[$id['name']] == 0)
                            {
                                $err[] = $this->modLangAdm['FORM']['FIELD'].$id['title'].$this->modLangAdm['FORM']['IS_INVALID'];
                            }
                            else if($data[$id['name']] != '' && (!$this->modAppCore->rwCheckInt($data[$id['name']])))
                            {
                                $err[] = $this->modLangAdm['FORM']['FIELD'].$id['title'].$this->modLangAdm['FORM']['IS_INVALID'];
                            }
                            break;
                        }
                    case 'number' :
                        {
                            if($data[$id['name']] != '' && (!$this->modAppCore->rwCheckInt($data[$id['name']]) && !is_numeric($data[$id['name']]) ))
                            {
                                $err[] = $this->modLangAdm['FORM']['FIELD'].$id['title'].$this->modLangAdm['FORM']['IS_INVALID'];
                            }
                            break;
                        }
                    case 'numberNotNull' :
                        {
                            if($data[$id['name']] == 0)
                            {
                                $err[] = $this->modLangAdm['FORM']['FIELD'].$id['title'].$this->modLangAdm['FORM']['IS_INVALID'];
                            }
                            else if($data[$id['name']] != '' && (!$this->modAppCore->rwCheckInt($data[$id['name']]) && (!is_numeric($data[$id['name']]))))
                            {
                                $err[] = $this->modLangAdm['FORM']['FIELD'].$id['title'].$this->modLangAdm['FORM']['IS_INVALID'];
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
                    $err[] = $this->modLangAdm['FORM']['FIELD'].$id['title'].$this->modLangAdm['FORM']['IS_EMPTY'];
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
                            $err[] = $this->modLangAdm['FORM']['FILE_ERR'].$id['title'].$this->modLangAdm['FORM']['FILE_8'];
                            break;
                        }
                    case 7 :
                        {
                            $err[] = $this->modLangAdm['FORM']['FILE_ERR'].$id['title'].$this->modLangAdm['FORM']['FILE_7'];
                            break;
                        }
                    case 6 :
                        {
                            $err[] = $this->modLangAdm['FORM']['FILE_ERR'].$id['title'].$this->modLangAdm['FORM']['FILE_6'];
                            break;
                        }
                    case 4 :
                        {
                            $err[] = $this->modLangAdm['FORM']['FILE_ERR'].$id['title'].$this->modLangAdm['FORM']['FILE_4'];
                            break;
                        }
                    case 3 :
                        {
                            $err[] = $this->modLangAdm['FORM']['FILE_ERR'].$id['title'].$this->modLangAdm['FORM']['FILE_3'];
                            break;
                        }
                    case 2 :
                        {
                            $err[] = $this->modLangAdm['FORM']['FILE_ERR'].$id['title'].$this->modLangAdm['FORM']['FILE_2'];
                            break;
                        }
                    case 1 :
                        {
                            $err[] = $this->modLangAdm['FORM']['FILE_ERR'].$id['title'].$this->modLangAdm['FORM']['FILE_1'];
                            break;
                        }
                    case 0 :
                        {
                            /**
                             * Check that file was uploaded
                             */
                            if(!is_uploaded_file($file_tname))
                            {
                                $err[] = $this->modLangAdm['FORM']['FILE_ERR'].$id['title'].$this->modLangAdm['FORM']['FILE_FORM'];
                                break;
                            }
                            /**
                             * File uploaded ok,
                             * check type
                             */
                            if(!in_array($file_type, $file_types[$id['type']]))
                            {
                                $err[] = $this->modLangAdm['FORM']['FILE_ERR'].$id['title'].$this->modLangAdm['FORM']['FILE_TYPE'];
                                break;
                            }
                            switch($id['type'])
                            {
                                case 'picture' :
                                    {
                                        $info = getimagesize($file_tname);
                                        if(!in_array($info['mime'], $file_types[$id['type']]))
                                        {
                                            $err[] = $this->modLangAdm['FORM']['FILE_ERR'].$id['title'].$this->modLangAdm['FORM']['FILE_TYPE'];
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
                                            $err[] = $this->modLangAdm['FORM']['FILE_ERR'].$id['title'].$this->modLangAdm['FORM']['FILE_SAVE'];
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
                    $err[] = $this->modLangAdm['FORM']['FILE_ERR'].$id['title'].$this->modLangAdm['FORM']['FILE_EMPTY'];
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
     * @return mixed modOut output
     */
    private function _authLogin()
    {
        $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['AUTH']['LOGIN_TT'];
        $this->modOut['cnt']['tpl'] = 'login';
        $this->modOut['cnt']['content']['captcha'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/captcha.png';
        return $this->modOut;
    }
    /**
     * Authorization - access denied
     *
     * @return mixed modOut output
     */
    private function _authDenied()
    {
        $this->modOut['skin']['title'] = $this->modLangAdm['MOD']['TITLE'] . ' - ' . $this->modLangAdm['AUTH']['DENIED_TT'];
        $this->modOut['cnt']['tpl'] = 'denied';
        return $this->modOut;
    }
    /**
     * Create administration menu
     *
     * @return mixed result
     */
    private function _makeMenu()
    {
        /**
         * Header
         */
        $this->modOut['atpl']['header'] = array();
        $this->modOut['atpl']['header']['dir'] = '';
        $this->modOut['atpl']['header']['tpl'] = 'header';
        $this->modOut['atpl']['header']['vars'] = array();
        $this->modOut['atpl']['header']['vars']['lang'] = $this->modAppCore->rwLang();
        $this->modOut['atpl']['header']['vars']['langAdm'] = $this->modAppCore->rwLangAdm();
        $this->modOut['atpl']['header']['vars']['adminMenu'] = array();

        $auth = $this->_authVerify(2);
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
            $adminMenu[0]['title'] = $this->modLangAdm['MOD']['PAGE']['ADMIN'];
            /**
             * Image administration
             */
            $adminMenu[1]['link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/imageList';
            $adminMenu[1]['title'] = $this->modLangAdm['MOD']['IMAGE']['ADMIN'];
            /**
             * Thumbnail administration
             */
            $adminMenu[2]['link'] = _APP_URL.'module/'.$this->modAbout['name'].'/action/thumbnailList';
            $adminMenu[2]['title'] = $this->modLangAdm['MOD']['THUMBNAIL']['ADMIN'];

            $this->modOut['atpl']['menu']['vars']['adminMenu'] = $adminMenu;

            return true;
        }
    }
}
?>