<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Provide user functionality.
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
	function __construct($appCore)
	{
		/**
		 * Extension info
		 */
		$about['name'] = 'Users';
		$about['desc'] = 'Provide user functionality.';
		$about['ver']  = '$Revision$';
		$about['auth'] = 'Radu Maier';
		$about['web']  = 'http://www.rudisoft.net';
		$about['mail'] = 'rudisoft@rudisoft.net';
		$about['deps'] = array();
		$about['deps']['cfg']  = array();
		$about['deps']['cfg'][]  = 'Database';
		$about['deps']['cfg'][]  = 'Sessions';
		$about['deps']['cfg'][]  = 'Users';
		$about['deps']['ext']  = array();
		$about['deps']['ext'][]  = 'Sessions';
		$about['deps']['ext'][]  = 'Captcha';
		parent::__construct($about, $appCore);
	}
	/**
	 * Login functionality
	 *
	 * @return mixed result
	 */
	public function usrAuth()
	{
		/**
		 * Check for authentication request
		 */
		if((isset($_POST[_APP_PRE.'_login']) && isset($_POST[_APP_PRE.'_pass'])) && isset($_POST[_APP_PRE.'_captcha']))
		{
			/**
			 * Check if tokens exist
			 */
			if(isset($_SESSION[_APP_PRE.'_token']) && isset($_POST[_APP_PRE.'_token']))
			{
				/**
				 * Check for token match
				 */
				if($_POST[_APP_PRE.'_token'] === $_SESSION[_APP_PRE.'_token'])
				{
					/**
					 * Sanitize post data
					 */
					$login = $this->extCore->rwFilterInput($_POST[_APP_PRE.'_login']);
					$pass = md5($_POST[_APP_PRE.'_pass']);
					$captcha = strtoupper($this->extCore->rwFilterInput($_POST[_APP_PRE.'_captcha']));
					/**
					 * Check for empty fields
					 */
					if(($login != '' && $pass != '') && $captcha != '')
					{
						/**
						 * Verify security code
						 */
						$captchaObj = $this->extCore->rwActivateExt('Captcha');
						$verif = $captchaObj->verify($captcha);

						if($verif)
						{
							/**
							 * Check if user exists
							 */
							$r = $this->extDb->dbSelect(array('usr_id', 'grp_id', 'usr_name', 'usr_fname', 'usr_lname', 'usr_skin', 'usr_lang', 'usr_disabled'), _APP_PRE.'_usr_users', array("usr_mail = '{$login}'", "usr_pass = '{$pass}'", "usr_deleted = '0'"), NULL, 1);
							$t = $r->dbNumRows();
							if($t == 1)
							{
								/**
								 * We have a match...
								 */
								$rw = $r->dbFetchArray();
								/**
								 * Check if group exists
								 */
								$r2 = $this->extDb->dbSelect(array('grp_id', 'grp_lvl', 'grp_name', 'grp_disabled'), _APP_PRE.'_usr_groups', array("grp_id = '{$rw['grp_id']}'", "grp_deleted = '0'"), NULL, 1);
								$t2 = $r2->dbNumRows();
								if($t2 == 1)
								{
									/**
									 * Group exists and is not disabled
									 */
									$rw2 = $r2->dbFetchArray();
									/**
									 * Check if user or group is suspended
									 */
									if($rw['usr_disabled'] == 1 || $rw2['grp_disabled'] == 1)
									{
										/**
										 * User or group is suspended
										 */
										return $this->_errSuspended();

									}
									else
									{
										/**
										 * Everything seems ok, log in the user
										 */
										$this->_usrLogin($rw, $rw2);
									}
								}
								else
								{
									/**
									 * No group data available
									 */
									return $this->_errNoGroup();
								}
							}
							else
							{
								/**
								 * Invalid login
								 */
								return $this->_errInvalidData();
							}
						}
						else
						{
							/**
							 * Invalid security code
							 */
							return $this->_errInvalidSecurityCode();
						}
					}
					else
					{
						/**
						 * Empty fields
						 */
						return $this->_errEmptyFields();
					}
				}
				else
				{
					/**
					 * Token dowsn't match, multiple submits ?
					 */
					return $this->_errMultipleSubmits();
				}
			}
			else
			{
				/**
				 * Tokens don't exist, hacker attack ?
				 */
				return $this->_errHackerAttack();
			}
		}
		else
		{
			/**
			 * No authentication request
			 */
			return $this->_errNoSubmit();
		}
	}
	/**
	 * Login method
	 *
	 * @param array $usr user data
	 * @param array $grp group data
	 */
	private function _usrLogin($usr, $grp)
	{
		/**
		 * Keep existing data but get a new session id
		 */
		session_regenerate_id(TRUE);
		/**
		 * User authorization
		 */
		$_SESSION[_APP_PRE.'_auth'] = TRUE;
		/**
		 * Unique security token
		 */
		$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
		/**
		 * Visit time
		 */
		$_SESSION[_APP_PRE.'_vtime'] = date("Y-m-d H:i:s");
		/**
		 * User id
		 */
		$_SESSION[_APP_PRE.'_usr_id'] = $usr['usr_id'];
		/**
		 * User level
		 */
		$_SESSION[_APP_PRE.'_usr_lvl'] = $grp['grp_lvl'];
		/**
		 * User group id
		 */
		$_SESSION[_APP_PRE.'_usr_grp'] = $usr['grp_id'];
		/**
		 * User alias
		 */
		$_SESSION[_APP_PRE.'_usr_alias'] = $usr['usr_name'];
		/**
		 * User full name
		 */
		$_SESSION[_APP_PRE.'_usr_name'] = $usr['usr_fname'] . ' ' . $usr['usr_lname'];
		/**
		 * User group name
		 */
		$_SESSION[_APP_PRE.'_usr_grp_name'] = $grp['grp_name'];
		/**
		 * Default language
		 */
		$_SESSION[_APP_PRE.'_usr_lang'] = $usr['usr_lang'];
		/**
		 * Default skin
		 */
		$_SESSION[_APP_PRE.'_skin_dir'] = _APP_DIR_SKINS.$usr['usr_skin'];
		$_SESSION[_APP_PRE.'_skin_url'] = _APP_WWW.'skins/'.$usr['usr_skin'].'/';
		/**
		 * Get last login time
		 */
		$rl1 = $this->extDb->dbSelect("MAX(login_id)", _APP_PRE.'_var_logins', "usr_id = '{$_SESSION[_APP_PRE.'_usr_id']}'", NULL, 1);
		$lid = $rl1->dbFetchResult();
		if($lid)
		{
			$rl2 = $this->extDb->dbSelect('login_time', _APP_PRE.'_var_logins', "login_id = {$lid}", NULL, 1);
			$ltime = $rl2->dbFetchResult();
			if($ltime)
			{
				$_SESSION[_APP_PRE.'_ltime'] = $ltime;
			}
			else
			{
				$_SESSION[_APP_PRE.'_ltime'] = NULL;
			}
		}
		else
		{
			$_SESSION[_APP_PRE.'_ltime'] = NULL;
		}
		/**
		 * Count total logins
		 */
		$rl3 = $this->extDb->dbSelect('COUNT(login_id)', _APP_PRE.'_var_logins', "usr_id = '{$_SESSION[_APP_PRE.'_usr_id']}'", NULL, NULL);
		$_SESSION[_APP_PRE.'_ltotal'] = $rl3->dbFetchResult() + 1;
		/**
		 * Record current login
		 */
		$this->extDb->dbInsert(_APP_PRE.'_var_logins', 'usr_id', $_SESSION[_APP_PRE.'_usr_id']);
		/**
		 * Close database connection
		 */
		$this->extDb->dbClose();
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
	/**
	 * Logout functionality
	 *
	 * @return mixed result
	 */
	public function usrLogout()
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
	/**
	 * Login error - no reques
	 *
	 * @return integer user status
	 */
	private function _errNoSubmit()
	{
		return 1;
	}
	/**
	 * Login error - user or group disabled
	 *
	 * @return integer user status
	 */
	private function _errSuspended()
	{
		return 4;
	}
	/**
	 * Login error - no group info
	 *
	 * @return integer user status
	 */
	private function _errNoGroup()
	{
		session_regenerate_id(TRUE);
		$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
		return 3;
	}
	/**
	 * Login error - invalid data
	 *
	 * @return integer user status
	 */
	private function _errInvalidData()
	{
		session_regenerate_id(TRUE);
		$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
		return 3;
	}
	/**
	 * Login error - invalid security code
	 *
	 * @return integer user status
	 */
	private function _errInvalidSecurityCode()
	{
		session_regenerate_id(TRUE);
		$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
		return 7;
	}
	/**
	 * Login error - empty fields
	 *
	 * @return integer user status
	 */
	private function _errEmptyFields()
	{
		session_regenerate_id(TRUE);
		$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
		return 2;
	}
	/**
	 * Login error - multiple submits
	 *
	 * @return integer user status
	 */
	private function _errMultipleSubmits()
	{
		session_regenerate_id(TRUE);
		$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
		return 8;
	}
	/**
	 * Login error - hacker attack
	 *
	 * @return integer user status
	 */
	private function _errHackerAttack()
	{
		session_regenerate_id(TRUE);
		$_SESSION[_APP_PRE.'_token'] = md5(uniqid(rand(), TRUE));
		return 9;
	}
}
?>