<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Users extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-22 10:34:00
 * @access     public
 * @package    rwExt
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
 * Security check.
 */
if (!defined('_RW_VALID'))
{
	/**
	 * Display "Not Found" page.
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * Extension name.
 */
$extAbout['Users']['name'] = 'Users';
/**
 * Extension description.
 */
$extAbout['Users']['desc'] = 'User related methods.';
/**
 * Extension version.
 */
$extAbout['Users']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Users']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Users']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Users']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Users']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Users']['deps']['lib'] = array('Error', 'Database');
/**
 * Extension extension dependencies.
 */
$extAbout['Users']['deps']['ext'] = array('Session', 'Geo');

/**
 * rw_Extension_Users.
 *
 * rw_Extension_Users extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Users extends rw_Extension implements rw_iExtension
{
	/**
	 * Database library object.
	 *
	 * @var mixed
	 */
	protected $rwDb;

	/**
	 * Geo extension object.
	 *
	 * @var mixed
	 */
	protected $extGeo;

	/**
	 * Routing extension object.
	 *
	 * @var mixed
	 */
	protected $extRouting;

	/**
	 * User data.
	 *
	 * This is used to populate the session array.
	 *
	 * @var array
	 */
	private $usrData = array();

	/**
	 * Login data.
	 *
	 * This is data used to perform login time checks.
	 *
	 * @var array
	 */
	protected $loginData = array();

	/**
	 * Constructor.
	 *
	 * @param array $extAbout
	 * @return mixed result
	 */
	public function __construct($extAbout)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($extAbout);
	}

	/**
	 * Main extension functionality.
	 *
	 * Set session user data.
	 * Must be called after Session->rwSession()
	 *
	 * @return mixed result
	 */
	public function rwUsers()
	{
		/**
		 * Check if we have user data in session.
		 */
		if (isset($_SESSION[_APP_PRE.'_usr']))
		{
			/**
			 * Set current user data from session.
			 */
			$this->usrData = $_SESSION[_APP_PRE.'_usr'];
		}
		/**
		 * Set new user data.
		 */
		$this->_setUserData();
		/**
		 * Write new user data to session.
		 */
		$this->_setSessionData();
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Set new user data.
	 *
	 * @return mixed result
	 */
	private function _setUserData()
	{
		/**
		 * Set initial user status.
		 *
		 * 0 not logged in
		 * 1 empty fields
		 * 2 incorrect data
		 * 3 suspended account
		 * 4 authentication ok
		 * 5 logged in
		 * 6 incorrect verification code
		 * 7 multiple submits
		 * 8 hacker attack
		 */
		$this->usrData['status'] = 0;
		/**
		 * Check if it is the first load of the page.
		 */
		if (!isset($_SESSION[_APP_PRE.'_usr']['token']))
		{
			/**
			 * Set initial user data.
			 */
			$this->_setInitialData();
		}
		/**
		 * Not first load of the page.
		 */
		else
		{
			/**
			 * Set user data.
			 */
			$this->_setData();
		}
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Set initial user data.
	 *
	 * @return mixed result
	 */
	private function _setInitialData()
	{
		/**
		 * User authentication.
		 */
		$this->usrData['auth'] = FALSE;
		/**
		 * Unique token for security.
		 */
		$this->usrData['token'] = sha1(uniqid(rand(), TRUE));
		/**
		 * User id.
		 */
		$this->usrData['id'] = 0;
		/**
		 * User level.
		 */
		$this->usrData['lvl'] = 0;
		/**
		 * User group id.
		 */
		$this->usrData['grp'] = 0;
		/**
		 * User group name.
		 */
		$this->usrData['grp_title'] = 'Guests';
		/**
		 * Default visitor country.
		 *
		 * Try to guess it for the visitor's ip.
		 * The called method takes care to set it to application default when no match is found.
		 */
		$this->usrData['vc'] = $this->extGeo->getVisitorCountry();
		/**
		 * Default user language.
		 *
		 * Try to guess it for the visitor's (guessed) country.
		 * The called method takes care to set it to application default when no match is found.
		 */
		$this->usrData['ln'] = $this->extGeo->getLangByCountry($this->usrData['vc']);
		/**
		 * Skin directory.
		 */
		$this->usrData['skin_dir'] = _APP_SKIN_DIR._APP_SKIN.'/';
		/**
		 * Skin url.
		 */
		$this->usrData['skin_url'] = _APP_SKIN_WWW._APP_SKIN.'/';
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Set data.
	 *
	 * @return mixed result.
	 */
	private function _setData()
	{
		/**
		 * Check if user is logged in.
		 */
		if (!$_SESSION[_APP_PRE.'_usr']['auth'])
		{
			/**
			 * User not logged in.
			 */
			$this->usrData['status'] = 0;
		}
		/**
		 * User is already logged in.
		 */
		$this->usrData['status'] = 5;
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Set session data.
	 *
	 * @return mixed result
	 */
	private function _setSessionData()
	{
		/**
		 * Set session user data.
		 */
		$_SESSION[_APP_PRE.'_usr'] = $this->usrData;
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Check maximum failed login attempts.
	 * If there are more than 10 failed login attempts,
	 * the method return TRUE. FALSE otherwise.
	 *
	 * @return boolean result
	 */
	public function failedLoginsLimit()
	{
		/**
		 * Get failed login attempts from the same IP.
		 */
		$failedLoginsIp = $this->_getFailedLogins('ip');
		/**
		 * Get failed logins targeting the current account.
		 */
		$failedLoginsAccount = $this->_getFailedLogins('account');
		/**
		 * Check failed login attempts to be no more than 10 in the last 10 minutes.
		 */
		if ($failedLoginsIp >= 10 || $failedLoginsAccount >= 10)
		{
			/**
			 * We have failed login attempts.
			 *
			 * Return result.
			 */
			return TRUE;
		}
		/**
		 * No failed login attempts.
		 *
		 * Return result.
		 */
		return FALSE;
	}

	/**
	 * Get failed login attempts.
	 *
	 * Login attempt type can be:
	 * ip - failed login attempts from the same IP.
	 * account - failed login attempts on the same account.
	 *
	 * @param string $type login attempt type
	 * @return mixed result
	 */
	private function _getFailedLogins($type='ip')
	{
		/**
		 * Init condition.
		 */
		$cond = array();
		/**
		 * Check what condition we got.
		 */
		switch ($type)
		{
			/**
			 * Failed login attempts from the same IP.
			 */
			case 'ip' : {
				/**
				 * Set condition.
				 */
				$cond[] = "login_ip = '{$this->loginData['login_ip']}'";
				/**
				 * Stop execution.
				 */
				break;
			}
			/**
			 * Failed login attempts on the same account.
			 */
			case 'account' : {
				/**
				 * Set condition.
				 */
				$cond[] = "login_mail = '{$this->loginData['login_mail']}'";
				/**
				 * Stop execution.
				 */
				break;
			}
			/**
			 * Default type is IP.
			 */
			default : {
				/**
				 * Set condition.
				 */
				$cond[] = "login_ip = '{$this->loginData['login_ip']}'";
				/**
				 * Stop execution.
				 */
				break;
			}
		}
		/**
		 * Set time condition to 10 minutes.
		 */
		$cond[] = "login_time > '{$this->rwDb->dbNowMinAgo(10)}'";
		/**
		 * Run query.
		 *
		 * Count the number of failed login attempts in the last 10 minutes.
		 */
		$r = $this->rwDb->dbSelect('COUNT(usr_id)', _APP_PRE.'_var_login', $cond, NULL, NULL);
		/**
		 * Return result.
		 */
		return $r->dbFetchResult();
	}

	/**
	 * Get user data.
	 *
	 * This method takes login form data
	 * and checks for a match in the database.
	 * It returns the user data array from database on success,
	 * or NULL on failure.
	 *
	 * @return mixed result
	 */
	public function getUserData($pass)
	{
		/**
		 * Set user hash form data sent throught login form.
		 */
		$usrHash = $this->getUserHash($this->loginData['login_mail'], $pass);
		/**
		 * Set user login condition.
		 */
		$cond[] = "usr_mail = '{$this->loginData['login_mail']}'";
		/**
		 * Set user hash condition.
		 */
		$cond[] = "usr_hash = '{$usrHash}'";
		/**
		 * Set user not deleted condition.
		 */
		$cond[] = "usr_status != '3'";
		/**
		 * Run query.
		 *
		 * Get all data for the user that matches the conditions.
		 */
		$r = $this->rwDb->dbSelect('usr_id, grp_id, usr_mail, usr_hash, usr_skin, usr_lang, usr_status', _APP_PRE.'_usr_user', $cond, NULL, 1);
		/**
		 * Return result.
		 */
		return $r->dbFetchArray();
	}

	/**
	 * Get group data.
	 *
	 * This method takes an user_id
	 * and checks for group data in the database matching that user id.
	 * It returns the group data array from database on success,
	 * or NULL on failure.
	 *
	 * @param integer $grp_id group id
	 * @return mixed result
	 */
	public function getGroupData($grp_id)
	{
		/**
		 * Set group id condition.
		 */
		$cond[] = "grp_id = {$grp_id}";
		/**
		 * Set group not deleted condition.
		 */
		$cond[] = "grp_status != '3'";
		/**
		 * Run query.
		 *
		 * Get all data from the group that matches the conditions.
		 */
		$r = $this->rwDb->dbSelect('grp_id, grp_lvl, grp_title, grp_dsc, grp_status', _APP_PRE.'_usr_group', $cond, NULL, 1);
		/**
		 * Return result.
		 */
		return $r->dbFetchArray();
	}

	/**
	 * Set user hash.
	 *
	 * This method generates an unique hash for a user.
	 * It takes the user login (email address) and password as parameters.
	 *
	 * @param string $login user login
	 * @param string $pass user password
	 * @return string user hash
	 */
	public function getUserHash($login, $pass)
	{
		/**
		 * Set salt.
		 */
		$salt = strrev(substr(sha1($login), 1, 10));
		/**
		 * Return user hash.
		 */
		return $salt.sha1($salt.$pass);
	}

	/**
	 * Set validation hash.
	 *
	 * This method generates an unique hash for user validation.
	 *
	 * The hash is based on the validation type.
	 *
	 * @param string $login user login
	 * @param integer $validation validation type.
	 * @return string validation hash.
	 */
	public function getValidationHash($login, $validation)
	{
		/**
		 * Set salt.
		 */
		$salt = strrev(substr(sha1(date('Y-m-d H:i:s')), 1, 9));
		/**
		 * Return validation hash.
		 */
		return $validation.$salt.sha1($salt.$login);
	}

	/**
	 * Check validation hash.
	 *
	 * The hash must be valid, of the required type, and not used before.
	 * Return usr_id if hash is valid.
	 * Redirect to error page otherwise.
	 *
	 * @param string $hash validation hash
	 * @return mixed result
	 */
	public function checkValidationHash($hash=NULL)
	{
		/**
		 * Check if we have a request.
		 */
		if($hash)
		{
			/**
			 * Check if the request is a valid validation key, the validation key was not used before, and the key is not older than 48h.
			 */
			$r = $this->rwDb->dbSelect('usr_id', _APP_PRE.'_var_validation', "val_key = '{$hash}' AND val_complete = '0000-00-00 00:00:00' AND TIMESTAMPDIFF(HOUR, val_start, NOW()) <= '48'", NULL, 1);
			/**
			 * Check if we got a valid request.
			 */
			if($r->dbNumRows() > 0)
			{
				/**
				 * Return usr_id.
				 */
				return $r->dbFetchResult();
			}
			/**
			 * Key not valid.
			 */
			else
			{
				/**
				 * Redirect to error page.
				 */
				return $this->extRouting->rwRedirect('error/app/validation/2');
			}
		}
		/**
		 * No key.
		 */
		else
		{
			/**
			 * Redirect to error page.
			 */
			return $this->extRouting->rwRedirect('error/app/validation/1');
		}
	}

	/**
	 * Check completed validation hash.
	 *
	 * The hash must be valid, of the required type, and alreary completed.
	 * Return usr_id if hash is valid.
	 * Redirect to error page otherwise.
	 *
	 * @param string $hash validation hash
	 * @return mixed result
	 */
	public function checkValidationHashComplete($hash=NULL)
	{
		/**
		 * Check if we have a request.
		 */
		if($hash)
		{
			/**
			 * Check if the request is a valid validation key, the validation key was not used before, and the key is not older than 48h.
			 */
			$r = $this->rwDb->dbSelect('usr_id', _APP_PRE.'_var_validation', "val_key = '{$hash}' AND val_complete != '0000-00-00 00:00:00' AND TIMESTAMPDIFF(HOUR, val_start, NOW()) <= '48'", NULL, 1);
			/**
			 * Check if we got a valid request.
			 */
			if($r->dbNumRows() > 0)
			{
				/**
				 * Return usr_id.
				 */
				return $r->dbFetchResult();
			}
			/**
			 * Key not valid.
			 */
			else
			{
				/**
				 * Redirect to error page.
				 */
				return $this->extRouting->rwRedirect('error/app/validation/2');
			}
		}
		/**
		 * No key.
		 */
		else
		{
			/**
			 * Redirect to error page.
			 */
			return $this->extRouting->rwRedirect('error/app/validation/1');
		}
	}

	/**
	 * Check validation hash type.
	 *
	 * The hash must be of the required type.
	 * Return TRUE if hash is of required type.
	 * Redirect to error page otherwise.
	 *
	 * Please note that the method doeas not check if hash is valid.
	 *
	 * @param string $hash validation hash
	 * @param integer $type validation type
	 * @return mixed result
	 */
	public function checkValidationHashType($hash=NULL, $type=0)
	{
		/**
		 * Check if we have a request.
		 */
		if($hash)
		{
			/**
			 * Check if validation key is of the matching type.
			 */
			return (substr($hash, 0,1) == $type) ? TRUE : $this->extRouting->rwRedirect('error/app/validation/2');
		}
		/**
		 * No key.
		 */
		else
		{
			/**
			 * Redirect to error page.
			 */
			return $this->extRouting->rwRedirect('error/app/validation/1');
		}
	}

	/**
	 * Record login data.
	 *
	 * This methods writes login data to database.
	 * If the login was invalid,
	 * usr_id will have the value of 0
	 *
	 * @param integer $usr_id user id
	 * @return mixed result
	 */
	public function recordLogin($usr_id=0)
	{
		/**
		 * Check if we got a valid user id.
		 */
		if ($usr_id != 0){
			/**
			 * Set user id to the valid one.
			 *
			 * This will be a valid login attempt.
			 */
			$this->loginData['usr_id'] = $usr_id;
		}
		/**
		 * Run query.
		 *
		 * Insert login data in database.
		 */
		$this->rwDb->dbInsert(_APP_PRE.'_var_login', NULL , $this->loginData);
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Record user activity.
	 *
	 * This method writes information in the database
	 * about the user activity.
	 *
	 * @param string $location location
	 * @param string $request request
	 * @param boolean $guest whether to record guest activity
	 * @return mixed result
	 */
	public function recordOnline($location=NULL, $request=NULL, $guest=FALSE)
	{
		/**
		 * Check if we have an authenticated user or if we shoul record guest activity.
		 *
		 * Only if this is true do we record the data.
		 */
		if ($_SESSION[_APP_PRE.'_usr']['auth'] || FALSE !== $guest)
		{
			/**
			 * Set user id.
			 */
			$logData['usr_id'] = $_SESSION[_APP_PRE.'_usr']['id'];
			/**
			 * Set location.
			 */
			$logData['log_location'] = $location;
			/**
			 * Set request.
			 */
			$logData['log_request'] = $request;
			/**
			 * Set IP to it's numeric value.
			 */
			$logData['log_ip'] = ip2long($_SERVER['REMOTE_ADDR']);
			/**
			 * Set user agent.
			 */
			$logData['log_agent'] = $_SERVER['HTTP_USER_AGENT'];
			/**
			 * Set activity date and time.
			 */
			$logData['log_time'] = $this->rwDb->dbNow();
			/**
			 * Run query.
			 *
			 * Insert data to database.
			 */
			$this->rwDb->dbInsert(_APP_PRE.'_var_log', NULL , $logData);
			/**
			 * Return result.
			 */
			return TRUE;
		}
		/**
		 * No user authenticated, or guest logging disabled.
		 *
		 * Return result.
		 */
		return FALSE;
	}

	/**
	 * Check if a user is online.
	 *
	 * This method checks the latest location a user has visited in the last 10 minutes.
	 * If we get a result different than 'members/logout',
	 * the user is considered to be online.
	 *
	 * @param integer $usr_id user id
	 * @return boolean result.
	 */
	public function usrOnline($usr_id)
	{
		/**
		 * Set user id condition.
		 */
		$cond[] = "usr_id = {$usr_id}";
		/**
		 * Set time condition.
		 *
		 * User must have had activity in the last 10 minutes.
		 */
		$cond[] = "log_time > '{$this->rwDb->dbNowMinAgo(10)}'";
		/**
		 * Run query.
		 *
		 * Get the last location the user visited in the last 10 minutes.
		 */
		$r = $this->rwDb->dbSelect('log_location', _APP_PRE.'_var_log', $cond, 'log_time DESC', 1);
		/**
		 * Check if we have a result.
		 */
		if($r->dbNumRows() == 1)
		{
			/**
			 * Check if the last location visited was the logout page. Return result.
			 */
			return ($r->dbFetchResult() != 'members/logout') ? TRUE : FALSE;
		}
		/**
		 * No result.
		 */
		else
		{
			/**
			 * Return result.
			 */
			return FALSE;
		}

		/**
		 * Return IP address (numeric value) of user if user is online, FALSE otherwise.
		 *
		 * Return result.
		 */
		return ($r->dbNumRows() == 1) ? $r->dbFetchResult() : FALSE;
	}

	/**
	 * Authenticate user.
	 *
	 * This method sets user data,
	 * and regenerates session.
	 *
	 * @param array $userData user data
	 * @param $array groupData group data
	 * @return mixed result
	 */
	public function usrAuth($userData, $groupData)
	{
		/**
		 * Record valid login data to database.
		 */
		$this->recordLogin($userData['usr_id']);
		/**
		 * Set user authentication.
		 */
		$this->usrData['auth'] = TRUE;
		/**
		 * Generate new unique token for security.
		 */
		$this->usrData['token'] = sha1(uniqid(rand(), TRUE));
		/**
		 * User id.
		 */
		$this->usrData['id'] = $userData['usr_id'];
		/**
		 * User level.
		 */
		$this->usrData['lvl'] = $groupData['grp_lvl'];
		/**
		 * User group id.
		 */
		$this->usrData['grp'] = $groupData['grp_id'];
		/**
		 * User group name.
		 */
		$this->usrData['grp_title'] = $groupData['grp_title'];
		/**
		 * User country.
		 *
		 * This is still the default application country from configuration file.
		 */
		$this->usrData['vc'] = _APP_VC;
		/**
		 * User language.
		 */
		$this->usrData['ln'] = $userData['usr_lang'];
		/**
		 * Skin directory.
		 */
		$this->usrData['skin_dir'] = _APP_SKIN_DIR.$userData['usr_skin'].'/';
		/**
		 * Skin url.
		 */
		$this->usrData['skin_url'] = _APP_SKIN_WWW.$userData['usr_skin'].'/';
		/**
		 * Keep existing data but get a new session id.
		 */
		session_regenerate_id(TRUE);
		/**
		 * Write new user data to session.
		 */
		$this->_setSessionData();
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Logout user.
	 *
	 * Please note that this method does not check
	 * if a session was started or if a user is actually logged in.
	 * You have to do that in the module action that calls it.
	 *
	 * @return mixed result.
	 */
	public function usrLogout()
	{
		/**
		 * Re-initialize session array.
		 */
		$_SESSION = array();
		/**
		 * Destroy current session.
		 */
		session_destroy();
		/**
		 * Get cookie info.
		 */
		$CookieInfo = session_get_cookie_params();
		/**
		 * Check if cookie domain and cookie secure are empty.
		 */
		if ((empty($CookieInfo['domain'])) && (empty($CookieInfo['secure'])) )
		{
			/**
			 * Set a dummy cookie with an expiration date in the past.
			 */
			setcookie(session_name(), '', time()-3600, $CookieInfo['path']);
		}
		/**
		 * Check if cookie secure is empty.
		 */
		elseif (empty($CookieInfo['secure']))
		{
			/**
			 * Set a dummy cookie with an expiration date in the past.
			 */
			setcookie(session_name(), '', time()-3600, $CookieInfo['path'], $CookieInfo['domain']);
		}
		/**
		 * No conditions met.
		 */
		else
		{
			/**
			 * Set a dummy cookie with an expiration date in the past.
			 */
			setcookie(session_name(), '', time()-3600, $CookieInfo['path'], $CookieInfo['domain'], $CookieInfo['secure']);
		}
		/**
		 * Destroy cookies.
		 */
		unset ($_COOKIE[session_name()]);
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Get user id from email address.
	 *
	 * Useful for checking if an email address is already registered.
	 * Returns the corresponding user id or 0 if no match is found.
	 *
	 * @param string $email email address to check.
	 * @return mixed result
	 */
	public function getIdFromEmail($email)
	{
		/**
		 * Get matching user id.
		 */
		$r = $this->rwDb->dbSelect('usr_id', _APP_PRE.'_usr_user', "usr_mail = '{$email}'", NULL, 1);
		/**
		 * Count results.
		 */
		$t = $r->dbNumRows();
		/**
		 * Return user id or 0 if no match.
		 */
		return ($t > 0) ? $r->dbFetchResult() : 0;
	}

	/**
	 * Get user email address from user email.
	 *
	 * Returns the corresponding email address or FALSE if no match is found.
	 *
	 * @param integer $id user id to check.
	 * @return mixed result
	 */
	public function getEmailFromId($id)
	{
		/**
		 * Get matching user id.
		 */
		$r = $this->rwDb->dbSelect('usr_mail', _APP_PRE.'_usr_user', "usr_id = '{$id}'", NULL, 1);
		/**
		 * Count results.
		 */
		$t = $r->dbNumRows();
		/**
		 * Return email address or FALSE if no match.
		 */
		return ($t > 0) ? $r->dbFetchResult() : FALSE;
	}

	/**
	 * Check user credentials.
	 *
	 * This method takes a credential from the user session
	 * and checks it against a required value.
	 *
	 * @param string $cr credential to check
	 * @param string $type comparision type
	 * @param mixed $req required value
	 * @param string $msg error message to redirect to
	 * @return mixed result
	 */
	public function checkCredentials($cr, $type, $req, $redact)
	{
		/**
		 * Check what comparision type we got.
		 */
		switch($type)
		{
			/**
			 * Equal.
			 */
			case 'eq' : {
				/**
				 * Check if credential is equal to required.
				 */
				if($_SESSION[_APP_PRE.'_usr'][$cr] == $req)
				{
					/**
					 * Return result.
					 */
					return TRUE;
				}
				/**
				 * Stop execution.
				 */
				break;
			}
			/**
			 * Identical.
			 */
			case 'id' : {
				/**
				 * Check if credential is identical with required.
				 */
				if($_SESSION[_APP_PRE.'_usr'][$cr] === $req)
				{
					/**
					 * Return result.
					 */
					return TRUE;
				}
				/**
				 * Stop execution.
				 */
				break;
			}
			/**
			 * Not equal.
			 */
			case 'ne' : {
				/**
				 * Check if credential is no equal to required.
				 */
				if($_SESSION[_APP_PRE.'_usr'][$cr] != $req)
				{
					/**
					 * Return result.
					 */
					return TRUE;
				}
				/**
				 * Stop execution.
				 */
				break;
			}
			/**
			 * Not identical.
			 */
			case 'ni' : {
				/**
				 * Check if credential is not identical to required.
				 */
				if($_SESSION[_APP_PRE.'_usr'][$cr] !== $req)
				{
					/**
					 * Return result.
					 */
					return TRUE;
				}
				/**
				 * Stop execution.
				 */
				break;
			}
			/**
			 * Less than.
			 */
			case 'lt' : {
				/**
				 * Check if credential is less than required.
				 */
				if($_SESSION[_APP_PRE.'_usr'][$cr] < $req)
				{
					/**
					 * Return result.
					 */
					return TRUE;
				}
				/**
				 * Stop execution.
				 */
				break;
			}
			/**
			 * Greater than.
			 */
			case 'gt' : {
				/**
				 * Check if credential is greater than required.
				 */
				if($_SESSION[_APP_PRE.'_usr'][$cr] > $req)
				{
					/**
					 * Return result.
					 */
					return TRUE;
				}
				/**
				 * Stop execution.
				 */
				break;
			}
			/**
			 * Less than or equal to.
			 */
			case 'le' : {
				/**
				 * Check if credential is less than or equal to required.
				 */
				if($_SESSION[_APP_PRE.'_usr'][$cr] <= $req)
				{
					/**
					 * Return result.
					 */
					return TRUE;
				}
				/**
				 * Stop execution.
				 */
				break;
			}
			/**
			 * Greater than or equal to.
			 */
			case 'ge' : {
				/**
				 * Check if credential is greater than or equal to required.
				 */
				if($_SESSION[_APP_PRE.'_usr'][$cr] >= $req)
				{
					/**
					 * Return result.
					 */
					return TRUE;
				}
				/**
				 * Stop execution.
				 */
				break;
			}
		}
		/**
		 * Credential checking did not pass, so we redirect to requested error message.
		 */
		$this->extRouting->rwRedirect($redact);
		/**
		 * Return result.
		 */
		return FALSE;
	}
}
?>