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
	 * @param array $lang language object
	 * @param array $db database connection
	 * @return mixed result
	 */
	public function appProcess($lang, $db=NULL)
	{
		/**
		 * Temporary solution for user status
		 */
		global $usr_status;
		if(_APP_CFG_USERS && (isset($_GET['logout']) && $_GET['logout'] = 'true'))
		{
			/**
			 * Logout user
			 */
			$this->rwLogoutUser();
		}
		else if(isset($_GET['page']))
		{
			/**
			 * Normal content from files
			 */
			$cnt = array();
			/**
			 * Request security check
			 */
			$page = $db ? $this->rwFilterInput($_GET['page'], $db) : $this->rwFilterInput($_GET['page']);
			/**
			 * Check if requested page exists
			 */
			if($page != '' && is_file(_APP_DIR_CNT.$page.'.inc.php'))
			{
				/**
				 * Load page.
				 */
				require_once(_APP_DIR_CNT.$page.'.inc.php');
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
		else if(isset($_GET['content']))
		{
			/**
			 * Content from database (shortcut to a module /content/ID_AND_NAME = /module/dbContent/action/display/content/ID_AND_NAME)
			 * Usual module checks, then translate request and pass it on.
			 * Not implemented yet.
			 */
			trigger_error('content functionality not implemented', E_USER_ERROR);
		}
		else if(isset($_GET['module']))
		{
			/**
			 * Content from a module
			 */
			$cnt = array();
			/**
			 * Request security check
			 */
			$module = $db ? $this->rwFilterInput($_GET['module'], $db) : $this->rwFilterInput($_GET['module']);
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
				if(is_file(_APP_DIR_MOD.$module.'/intl/'.$ln.'/lang.inc.php'))
				{
					/**
					 * Add module internationalization to the current one.
					 */
					require_once(_APP_DIR_MOD.$module.'/intl/'.$ln.'/lang.inc.php');
				}
				/**
				 * Load module
				 */
				$modClass = 'rw_Mod_'.$module;
				$modObject = $db ? new $modClass($lang, $db) : new $modClass($lang);
				/**
				 * Module is loaded, check action
				 */
				if(isset($_GET['action']))
				{
					$action = $db ? $this->rwFilterInput($_GET['action'], $db) : $this->rwFilterInput($_GET['action']);
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
							return $cnt;
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
		else
		{
			/**
			 * No request, load default content
			 */
			require_once(_APP_DIR_CNT.'index.inc.php');
			return $cnt;
		}
	}
}
?>