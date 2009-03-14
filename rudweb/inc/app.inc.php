<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Main application class
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2008-12-16 09:29:00
 * @access     public
 * @package    RudWEb
 * @subpackage App
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
 * Load parent class
 */
if(is_readable(_RW_DIR_LIB.'rw.inc.php')) {require_once(_RW_DIR_LIB.'rw.inc.php');} else {require_once('./index.php'); exit;}
/**
 * app_Core
 *
 * Basic engine functions extended
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Core
 */
class app_Core extends rw_Core
{
	/**
	 * Handle requests
	 *
	 * @return mixed content
	 */
	public function appProcess()
	{
		/**
		 * Open database connection, if enabled
		 */
		if(_APP_CFG_DATABASE)
		{
			$db = $this->rwDbConnect();
			$this->rwDbSet($db);
		}
		/**
		 * Initialize content
		 */
		$cnt = array();
		/**
		 * Handle logout
		 */
		if(_APP_CFG_USERS && (isset($_GET['logout']) && $_GET['logout'] == 'true'))
		{
			$usr = $this->rwActivateExt('Users');
			return $usr->usrLogout();
		}
		/**
		 * Handle page requests
		 */
		else if(isset($_GET['page']))
		{
			$cnt = $this->_appProcessPage();
		}
		/**
		 * Handle content requests
		 */
		else if(isset($_GET['content']))
		{
			$cnt = $this->_appProcessContent();
		}
		/**
		 * Handle module requests
		 */
		else if(isset($_GET['module']))
		{
			$cnt = $this->_appProcessModule();
		}
		/**
		 * No special request, load default content
		 */
		else
		{
			$cnt = $this->_appProcessDefault();
		}
		/**
		 * Close database connection, if opened.
		 */
		if($this->db)
		{
			$this->db->dbClose();
		}
		return $cnt;
	}
	/**
	 * Handle page requests
	 *
	 * @return mixed content
	 */
	private function _appProcessPage()
	{
		/**
		 * Request security check and fake extension remover
		 */
		$page = $this->rwFilterRequest($_GET['page']);
		/**
		 * Check if requested page exists
		 */
		if($page != '' && is_file(_APP_DIR_PG.$page.'.inc.php'))
		{
			/**
			 * Load page.
			 */
			require_once(_APP_DIR_PG.$page.'.inc.php');
		}
		else
		{
			/**
			 * Page doesn't exist, go to 404 page
			 */
			require_once(_APP_DIR_CNT.'404.inc.php');
		}
		return $cnt;
	}
	/**
	 * Handle content requests
	 *
	 * Display content from database
	 * (shortcut to a module:
	 * /content/ID[-ALIAS] => /module/dbContent/action/pageDisplay/id/ID)
	 *
	 * @return mixed content
	 */
	private function _appProcessContent()
	{
		/**
		 * Get page id
		 */
		$pg = $this->rwStripAlias($_GET['content']);
		$pg_id = (!$pg[0]) ? 0 : $pg[0];
		if($pg_id == 0)
		{
			/**
			 * Invalid page id, go to 404 page
			 */
			require_once(_APP_DIR_CNT.'404.inc.php');
			return $cnt;
		}
		/**
		 * Rewrite get request.
		 */
		$_GET['module'] = 'dbContent';
		$_GET['action'] = 'pageDisplay';
		$_GET['id'] = $pg_id;
		/**
		 * Process module
		 */
		return $this->_appProcessModule();
	}
	/**
	 * Handle module requests
	 *
	 * @return mixed content
	 */
	private function _appProcessModule()
	{
		/**
		 * Request security check and fake extension remover
		 */
		$module = $this->rwFilterRequest($_GET['module']);
		/**
		 * Check if requested module exists
		 */
		if($module != '' && is_file(_APP_DIR_MOD.$module.'/'.$module.'.mod.php'))
		{
			/**
			 * Load module file
			 */
			require_once(_RW_DIR_LIB_MOD.'mod.inc.php');
			require_once(_APP_DIR_MOD.$module.'/'.$module.'.mod.php');
			/**
			 * Get current language
			 */
			$ln = _APP_CFG_SESSIONS ? $_SESSION[_APP_PRE.'_usr_lang'] : _APP_LANG;
			/**
			 * Check if module has it's own internationalization file corresponding to the current language.
			 */
			$modlang = array();
			if(is_file(_APP_DIR_MOD.$module.'/intl/'.$ln.'/lang.inc.php'))
			{
				/**
				 * Add module internationalization to the current one.
				 */
				require_once(_APP_DIR_MOD.$module.'/intl/'.$ln.'/lang.inc.php');
			}
			$this->lang = array_merge($this->lang, $modlang);
			/**
			 * Load module
			 */
			$modClass = 'rw_Mod_'.$module;
			$modObject = new $modClass($this);
			/**
			 * Check module dependencies
			 */
			$modAbout = $modObject->modAbout();
			$cfgDeps = count($modAbout['deps']['cfg']);
			$extDeps = count($modAbout['deps']['ext']);
			$modDeps = count($modAbout['deps']['mod']);
			/**
			 * If configuration dependencies exist solve them
			 */
			if($cfgDeps > 0)
			{
				foreach($modAbout['deps']['cfg'] as $cfgDep)
				{
					if(TRUE !== constant('_APP_CFG_'.strtoupper($cfgDep)))
					{
						trigger_error('Module <b>'.$module.'</b> can not be loaded. Configuration dependecy <b>'.$cfgDep.'</b> is missing.', E_USER_ERROR);
					}
				}
			}
			/**
			 * If extensions dependecies exist, solve them
			 */
			if($extDeps > 0)
			{
				foreach($modAbout['deps']['ext'] as $extDep)
				{
					if(!array_key_exists($extDep, $this->ext))
					{
						trigger_error('Module <b>'.$module.'</b> can not be loaded. Extensions dependecy <b>'.$extDep.'</b> is missing.', E_USER_ERROR);
					}
				}
			}
			/**
			 * If module dependecies exist, solve them
			 */
			if($modDeps > 0)
			{
				foreach($modAbout['deps']['mod'] as $modDep)
				{
					if(!is_file(_APP_DIR_MOD.$modDep.'/'.$modDep.'.mod.php'))
					{
						trigger_error('Module <b>'.$module.'</b> can not be loaded. Modules dependecy <b>'.$extDep.'</b> is missing.', E_USER_ERROR);
					}
				}
			}
			/**
			 * Module is loaded, check action
			 */
			if(isset($_GET['action']))
			{
				/**
				 * Request security check and fake extension remover
				 */
				$action = $this->rwFilterRequest($_GET['action']);
				/**
				 * Action must not be a special method
				 */
				if(!ereg("^_{1,2}", $action))
				{
					/**
					 * Action must exist and be public
					 */
					if(method_exists($modObject, $action) && is_callable(array($modObject, $action)))
					{
						/**
						 * Call the action
						 */
						$cnt = $modObject->$action();
						/**
						 * "Trigger" 404 from inside the module.
						 *
						 * Use "return FALSE" in module action.
						 */
						if(FALSE === $cnt)
						{
							require_once(_APP_DIR_CNT.'404.inc.php');
						}
					}
					else
					{
						/**
						 * Action doesn't exist or is restricted, go to 404 page
						 */
						require_once(_APP_DIR_CNT.'404.inc.php');
					}
				}
				else
				{
					/**
					 * Action is a special one, go to 404 page
					 */
					require_once(_APP_DIR_CNT.'404.inc.php');
				}
			}
			else
			{
				/**
				 * No action requested, load default action
				 */
				$cnt = $modObject->_default();
			}
		}
		else
		{
			/**
			 * Requested module doesn't exist, go to 404 page
			 */
			require_once(_APP_DIR_CNT.'404.inc.php');
		}
		return $cnt;
	}
	/**
	 * Default, no request
	 *
	 * @return mixed content
	 */
	private function _appProcessDefault()
	{
		/**
		 * Default content from config
		 */
		switch(_APP_CONTENT_TYPE)
		{
			case 'page' :
				{
					/**
					 * Rewrite get request
					 */
					$_GET['page'] = _APP_CONTENT_ID;
					return $this->_appProcessPage();
					break;
				}
			case 'content' :
				{
					/**
					 * Rewrite get request
					 */
					$_GET['content'] = _APP_CONTENT_ID;
					return $this->_appProcessContent();
					break;
				}
			default :
				{
					/**
					 * No request, no config, load default content
					 */
					if(is_file(_APP_DIR_PG.'index.inc.php'))
					{
						require_once(_APP_DIR_PG.'index.inc.php');
					}
					else
					{
						require_once(_APP_DIR_CNT.'index.inc.php');
					}
					break;
				}
		}
		return $cnt;
	}
}
?>