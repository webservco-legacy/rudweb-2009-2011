<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Provide session functionality.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-01 09:47:00
 * @access     public
 * @package    RudWEb
 * @subpackage rwExt
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
 * rw_Ext_Sessions
 *
 * rw_Ext_Sessions extension
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage rwExt
 */
class rw_Ext_Sessions extends rw_Ext_global implements rw_iExt
{
	/**
	 * Constructor
	 * Set extension information and call parent constructor
	 *
	 */
	function __construct($appCore)
	{
		/**
		 * Extension info
		 */
		$about['name'] = 'Sessions';
		$about['desc'] = 'Provide session functionality.';
		$about['ver']  = '$Revision$';
		$about['auth'] = 'Radu Maier';
		$about['web']  = 'http://www.rudisoft.net';
		$about['mail'] = 'rudisoft@rudisoft.net';
		$about['deps'] = array();
		$about['deps']['cfg'] = array();
		$about['deps']['cfg'][] = 'Sessions';
    $about['deps']['ext'] = array();
		parent::__construct($about, $appCore);
	}
	/**
	 * Start session
	 *
	 * @param array $ext loaded extensions
	 * @return $usr_status user status
	 */
	public function rwSession()
	{
		/**
		 * Headers and stuff
		 */
		session_cache_limiter('public, must-revalidate');
		session_cache_expire(600); //minutes (10hrs)
		ini_set("session.gc_maxlifetime","36000"); //seconds (1 hours)
		session_start();
		header("ETag: PUB" . time());
		header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()-10) . " GMT");
		header("Expires: " . gmdate("D, d M Y H:i:s", time() + 5) . " GMT");
		header("Pragma: no-cache");
		header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
		/**
		 * Default user status - not logged in
		 */
		$usr_status = 1;
		/**
		 * First load of the page?
		 */
		if(!isset($_SESSION[_APP_PRE.'_token']))
		{
			/**
			 * User authorization
			 */
			$_SESSION[_APP_PRE.'_auth'] = FALSE;
			/**
			 * Unique token for security
			 */
			$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
			/**
			 * Visit time
			 */
			$_SESSION[_APP_PRE.'_vtime'] = date("Y-m-d H:i:s");
			/**
			 * User id
			 */
			$_SESSION[_APP_PRE.'_usr_id'] = 0;
			/**
			 * User level
			 */
			$_SESSION[_APP_PRE.'_usr_lvl'] = 0;
			/**
			 * User group id
			 */
			$_SESSION[_APP_PRE.'_usr_grp'] = 0;
			/**
			 * User alias
			 */
			$_SESSION[_APP_PRE.'_usr_alias'] = 'Guest';
			/**
			 * User full name
			 */
			$_SESSION[_APP_PRE.'_usr_name'] = 'Anonymous';
			/**
			 * User group name
			 */
			$_SESSION[_APP_PRE.'_usr_grp_name'] = 'Guests';
			/**
			 * Default language
			 */
			$_SESSION[_APP_PRE.'_usr_lang'] = _APP_LANG;
			/**
			 * Content language
			 */
			$_SESSION[_APP_PRE.'_cnt_lang'] = _APP_LANG;
			/**
			 * Admin language
			 */
			$_SESSION[_APP_PRE.'_adm_lang'] = _APP_LANG;
			/**
			 * Default skin
			 */
			$_SESSION[_APP_PRE.'_skin_dir'] = _APP_DIR_SKINS._APP_SKIN;
			$_SESSION[_APP_PRE.'_skin_url'] = _APP_WWW.'skins/'._APP_SKIN.'/';
		}
		else
		{
			/**
			 * If user is not logged in include login functionality
			 */
			if(!$_SESSION[_APP_PRE.'_auth'])
			{
				/**
				 * user status based on login result
				 */
				if(_APP_CFG_USERS)
				{
					$users = $this->extCore->rwActivateExt('Users');
					$usr_status = $users->usrAuth();
				}
			}
			else if($_SESSION[_APP_PRE.'_auth'])
			{
				/**
				 * User status - logged in
				 */
				$usr_status = 6;
			}
		}
		return $usr_status;
	}
}
?>