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
		$about['deps']['ext']   = array();
		$about['deps']['ext'][] = 'Sessions';
		$about['deps']['ext'][] = 'Intl';
		$about['deps']['mod']   = array();
		/**
		 * These must be declared
		 */
		$cnt['skin'] = array();
		$cnt['skin']['meta'] = array();
		$cnt['cnt'] = array();
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
		$cnt['skin']['dir'] = '';
		$cnt['skin']['tpl'] = 'layout';
		$cnt['cnt'][0]['dir'] = 'content';
		$cnt['cnt'][0]['tpl'] = 'blank';
		$cnt['cnt'][0]['content'] = array();
		/**
		 * Call parent constructor
		 */
		parent::__construct($about, $cnt, $appCore);
		$intl = $this->modAppCore->rwActivateExt('Intl');
		$this->modCnt['skin']['langs'] = $intl->intlMenu('usr', 'home');
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
			/**
			 * Page doesn't exist for current language.
			 * Check if page exist for another language.
			 * If it does, switch language and continue.
			 */
			/**
			 * Get language list
			 */
			$list     = $this->modAppCore->rwLsDir(_APP_DIR_LANG);
			$langList = array_diff($list['d'], array($_SESSION[_APP_PRE.'_usr_lang']));
			foreach($langList as $lang)
			{
				$rs2[$lang] = $this->modDb->dbSelect("pg_title, pg_alias, pg_kw, pg_dsc, pg_template", _APP_PRE.'_web_pages', "pg_id = '{$pg_id}' AND pg_ln = '$lang' AND pg_deleted = '0'", NULL, 1);
				$t2[$lang] = $rs2[$lang]->dbNumRows();
				if($t2[$lang] == 1)
				{
					/**
					 * This page exists, but for a different language.
					 * Do a redirect
					 */
					$r[$lang] = $rs2[$lang]->dbFetchArray();
					$location = _APP_URL.'module/intl/action/setSession/ln/'.$lang.'/red/cnt/var/'.$pg_id.'-'.$r[$lang]['pg_alias'];
					header("Location: ".$location);
					exit;
				}
			}
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
		$rc = $this->modDb->dbSelect("cnt_type, cnt_body, cnt_resource, cnt_template", _APP_PRE.'_web_content', "pg_id = '{$pg_id}' AND cnt_deleted = '0'", 'cnt_order', NULL);
		$tc = $rc->dbNumRows();
		if($tc > 0)
		{
			$i = 0;
			while($c = $rc->dbFetchArray())
			{
				$this->modCnt['cnt'][$i]['dir'] = 'content';
				$this->modCnt['cnt'][$i]['tpl'] = $c['cnt_template'];
				switch($c['cnt_type'])
				{
					case 'text' :
						{
							$this->modCnt['cnt'][$i]['content']['body'] = nl2br($c['cnt_body']);
							break;
						}
					case 'html' :
						{
							$this->modCnt['cnt'][$i]['content']['body'] = $c['cnt_body'];
							break;
						}
					default :
						{
							break;
						}
				}
				$i++;
			}
		}


		return $this->modCnt;
	}
}
?>