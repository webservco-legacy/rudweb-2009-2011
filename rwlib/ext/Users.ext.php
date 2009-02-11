<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Provide user functionality.
 * <BR>Requires: _APP_CFG_DATABASE
 * <BR>Requires: _APP_CFG_SESSIONS
 * <BR>Requires: _APP_CFG_USERS
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-01 10:19:00
 * @access     public
 * @package    RudWEb
 * @subpackage Extensions
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

class rw_Ext_Users extends rw_Ext_global implements rw_iExt
{
	/**
	 * Constructor
	 * Set extension information and call parent constructor
	 *
	 */
	function __construct()
	{
		/**
		 * Extension info
		 */
		$about['name'] = 'Users';
		$about['desc'] = 'Provide user functionality.';
		$about['ver']  = '10:19 2009-02-01';
		$about['auth'] = 'Radu Maier';
		$about['web']  = 'http://www.rudisoft.net';
		$about['mail'] = 'rudisoft@rudisoft.net';
		$about['deps'] = array();
		$about['deps'][]  = 'Session';
		parent::__construct($about);
	}
	/**
	 * Login functionality
	 *
	 * Requires: USERS, DATABASE, SESSIONS
	 *
	 * @return mixed result
	 */
	public function rwLoginUser()
	{
		if((isset($_POST[_APP_PRE.'_login']) && isset($_POST[_APP_PRE.'_pass'])) && isset($_POST[_APP_PRE.'_captcha']))
		{
			if(isset($_SESSION[_APP_PRE.'_token']) && isset($_POST[_APP_PRE.'_token']))
			{
				if($_POST[_APP_PRE.'_token'] === $_SESSION[_APP_PRE.'_token'])
				{
					$core = new rw_Core;
					if(_APP_CFG_DATABASE && _APP_CFG_SESSIONS)
					{
						$udb = $core->rwDbConnect();
					}
					else
					{
						trigger_error('User functionality requires session and database functionality. Please check your configuration file!', E_USER_ERROR);
					}
					$login = $core->rwFilterInput($_POST[_APP_PRE.'_login'],$udb);
					$pass = md5($_POST[_APP_PRE.'_pass']);
					$captcha = strtoupper($core->rwFilterInput($_POST[_APP_PRE.'_captcha'],$udb));
					if(($login != '' && $pass != '') && $captcha != '')
					{
						$verif = str_split($_SESSION[_APP_PRE.'_token'], 5);
						$verif = strtoupper(strrev($verif[0]));
						if($captcha == $verif)
						{
							$r = $udb->dbQuerySimpleSelect('*', _APP_PRE.'_set_usr', "usr_mail = '{$login}' AND usr_pass = '{$pass}'", '1');
							$t = $r->dbNumRows();
							if($t == 1)
							{
								/**
								 * We have a match, log in the user
								 */
								$rw = $r->dbFetchArray();
								if($rw['usr_status'] == 0)
								{
									/**
									 * Account is suspended
									 */
									return 4;
								}
								else
								{
									/**
									 * Keep existing data but get a new session id
									 */
									session_regenerate_id(TRUE);
									/**
									 * Issue authorization
									 */
									$_SESSION[_APP_PRE.'_auth'] = 'ok';
									/**
									 * Unique security token
									 */
									$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
									/**
									 * Visit date
									 */
									$_SESSION[_APP_PRE.'_vdate'] = date("Y-m-d");
									/**
									 * Visit time
									 */
									$_SESSION[_APP_PRE.'_vtime'] = date("H:i:s");
									/**
									 * User id
									 */
									$_SESSION[_APP_PRE.'_usr_id'] = $rw['usr_id'];
									/**
									 * User level
									 */
									$_SESSION[_APP_PRE.'_usr_lvl'] = $rw['usr_level'];
									/**
									 * User alias
									 */
									$_SESSION[_APP_PRE.'_usr_alias'] = $rw['usr_name'];
									/**
									 * User full name
									 */
									$_SESSION[_APP_PRE.'_usr_name'] = $rw['usr_fname'] . ' ' . $rw['usr_lname'];
									/**
									 * Default language
									 */
									$_SESSION[_APP_PRE.'_usr_lang'] = $rw['usr_lang'];
									/**
									 * Default skin
									 */
									$_SESSION[_APP_PRE.'_skin_dir'] = _APP_DIR_SKINS.$rw['usr_skin'];
									$_SESSION[_APP_PRE.'_skin_url'] = _APP_WWW.'skins/'.$rw['usr_skin'].'/';
									/**
									 * Get previous login data
									 */
									$rL = $udb->dbQuerySimpleSelect('log_date, log_time', _APP_PRE.'_var_log', "log_id = (SELECT MAX(log_id) FROM "._APP_PRE."_var_log WHERE usr_id = '{$_SESSION[_APP_PRE.'_usr_id']}')");
									$tL = $rL->dbNumRows();
									if($tL == 1)
									{
										$rwL = $rL->dbFetchArray();
										/**
										 * Last login date
										 */
										$_SESSION[_APP_PRE.'_ldate'] = $rwL['log_date'];
										/**
										 * Last login time
										 */
										$_SESSION[_APP_PRE.'_ltime'] = $rwL['log_time'];
									}
									else
									{
										/**
										 * Last login date (this is the first login)
										 */
										$_SESSION[_APP_PRE.'_ldate'] = '0000-00-00';
										/**
										 * Last login time
										 */
										$_SESSION[_APP_PRE.'_ltime'] = '0000-00-00';
									}
									/**
									 * Count total logins
									 */
									$rT = $udb->dbQuerySimpleSelect('COUNT(log_id)', _APP_PRE.'_var_log', "usr_id = '{$_SESSION[_APP_PRE.'_usr_id']}'");
									$_SESSION[_APP_PRE.'_ltotal'] = $rT->dbFetchResult() + 1;
									/**
									 * Record current login
									 */
									$udb->dbQuery("INSERT INTO "._APP_PRE."_var_log (usr_id, log_date, log_time) VALUES('{$_SESSION[_APP_PRE.'_usr_id']}', '{$_SESSION[_APP_PRE.'_vdate']}', '{$_SESSION[_APP_PRE.'_vtime']}')");
									/**
									 * Close database connection
									 */
									$udb->dbClose();
									/**
									 * Redirect to the same page we came from to avoid double submit
									 */
									if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != '')
									{
										$redirect = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
									}
									else if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != '')
									{
										$redirect = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
									}
									else
									{
										$redirect = _APP_URL;
									}
									header("Location: ".$redirect);
									exit;
								}
							}
							else
							{
								/**
								 * Invalid login
								 */
								session_regenerate_id(TRUE);
								$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
								return 3;
							}
						}
						else
						{
							/**
							 * Invalid security code
							 */
							session_regenerate_id(TRUE);
							$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
							return 7;
						}
					}
					else
					{
						/**
						 * Empty fields
						 */
						session_regenerate_id(TRUE);
						$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
						return 2;
					}
				}
				else
				{
					/**
					 * Multiple submits ???
					 */
					session_regenerate_id(TRUE);
					$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
					return 8;
				}
			}
			else
			{
				/**
				 * Hacker attack
				 */
				session_regenerate_id(TRUE);
				$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
				return 9;
			}
		}
		else
		{
			/**
			 * Not submitted
			 */
			return 1;
		}
	}
	/**
	 * Logout functionality
	 *
	 * Requires: USERS, SESSIONS
	 */
	public function rwLogoutUser()
	{
		if(_APP_CFG_SESSIONS === TRUE)
		{
			$_SESSION = array();
			session_destroy();
			/**
			 * Cookie removal code from php manual user commentss
			 */
			$CookieInfo = session_get_cookie_params();
			if ( (empty($CookieInfo['domain'])) && (empty($CookieInfo['secure'])) ) {
				setcookie(session_name(), '', time()-3600, $CookieInfo['path']);
			}
			elseif (empty($CookieInfo['secure'])) {
				setcookie(session_name(), '', time()-3600, $CookieInfo['path'], $CookieInfo['domain']);
			}
			else {
				setcookie(session_name(), '', time()-3600, $CookieInfo['path'], $CookieInfo['domain'], $CookieInfo['secure']);
			}
			unset($_COOKIE[session_name()]);
		}
		header("Location: "._APP_WWW);
		exit;
	}
}
?>