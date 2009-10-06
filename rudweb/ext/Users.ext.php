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
$extAbout['Users']['deps']['ext'] = array('Session');

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
	 * User data.
	 *
	 * This is used to populate the session array.
	 *
	 * @var array
	 */
	private $usrData = array();

	/**
	 * Database object.
	 *
	 * @var mixed
	 */
	private $rwDb;

	/**
	 * Login data.
	 *
	 * This is data used to perform login time checks.
	 *
	 * @var array
	 */
	private $loginData = array();

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
	 * Set database library object.
	 *
	 * Database library object is passed by reference.
	 * Useful for query statistics.
	 *
	 * @param mixed $rwDb database library object
	 * @return mixed result.
	 */
	public function setDb(&$rwDb)
	{
		/**
		 * Set database library object.
		 *
		 */
		$this->rwDb = $rwDb;
		/**
		 * Return result.
		 */
		return TRUE;
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
		 * User alias.
		 */
		$this->usrData['name'] = 'Guest';
		/**
		 * User group name.
		 */
		$this->usrData['grp_name'] = 'Guests';
		/**
		 * User default language.
		 */
		$this->usrData['ln'] = _APP_LN;
		/**
		 * Skin directory.
		 */
		$this->usrData['skin_dir'] = _APP_SKIN_DIR._APP_SKIN;
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
	 * Set login data.
	 *
	 * Login data is used to perform variois checks
	 * at login time.
	 *
	 * @param array $loginData login data
	 * @return mixed result
	 */
	public function setLoginData($loginData)
	{
		/**
		 * Set login data.
		 */
		$this->loginData = $loginData;
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Check failed login attempts.
	 *
	 * @return mixed result
	 */
	public function checkFailedLogins()
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
		if ($failedLoginsIp > 9 || $failedLoginsAccount > 9)
		{
			/**
			 * We have failed login attempts.
			 *
			 * Return result.
			 */
			return FALSE;
		}
		/**
		 * No failed login attempts.
		 *
		 * Return result.
		 */
		return TRUE;
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
		$r = $this->rwDb->dbSelect('COUNT(usr_id)', 'app_var_login', $cond , NULL, NULL);
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
		$usrHash = $this->_userHash($this->loginData['login_mail'], $pass);
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
		$cond[] = "usr_deleted = '0'";
		/**
		 * Run query.
		 *
		 * Get all data for the user that matches the conditions.
		 */
		$r = $this->rwDb->dbSelect('*', _APP_PRE.'_usr_usr', $cond, NULL, 1);
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
		$cond[] = "grp_deleted = '0'";
		/**
		 * Run query.
		 *
		 * Get all data from the group that matches the conditions.
		 */
		$r = $this->rwDb->dbSelect('*', _APP_PRE.'_usr_grp', $cond, NULL, 1);
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
	private function _userHash($login, $pass)
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
	 * Clear failed login attempts.
	 *
	 * This method deletes failed login attempts info from database.
	 *
	 * @return mixed result
	 */
	public function clearLogin()
	{
		/**
		 * Set user id condition.
		 */
		$cond = "usr_id = {$_SESSION[_APP_PRE.'_usr']['id']}";
		/**
		 * Run query.
		 *
		 * Delete online activity data for user.
		 */
		$this->rwDb->dbDelete(_APP_PRE.'_var_login', $cond, NULL, NULL);
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
	 * @return mixed result
	 */
	public function recordOnline($location=NULL, $request=NULL)
	{
		/**
		 * Check if we have an authenticated user.
		 *
		 * Only if this is true do we record the data.
		 */
		if ($_SESSION[_APP_PRE.'_usr']['auth'])
		{
			/**
			 * Set user id.
			 */
			$onlineData['usr_id'] = $_SESSION[_APP_PRE.'_usr']['id'];
			/**
			 * Set location.
			 */
			$onlineData['online_location'] = $location;
			/**
			 * Set request.
			 */
			$onlineData['online_request'] = $request;
			/**
			 * Set IP.
			 */
			$onlineData['online_ip'] = $_SERVER['REMOTE_ADDR'];
			/**
			 * Set user agent.
			 */
			$onlineData['online_agent'] = $_SERVER['HTTP_USER_AGENT'];
			/**
			 * Set activity date and time.
			 */
			$onlineData['online_time'] = $this->rwDb->dbNow();
			/**
			 * Run query.
			 *
			 * Insert data to database.
			 */
			$this->rwDb->dbInsert(_APP_PRE.'_var_online', NULL , $onlineData);
			/**
			 * Return result.
			 */
			return TRUE;
		}
		/**
		 * No user authenticated.
		 *
		 * Return result.
		 */
		return FALSE;
	}

	/**
	 * Clear online activity.
	 *
	 * This method deletes user activity info from database.
	 *
	 * @return mixed result
	 */
	public function clearOnline()
	{
		/**
		 * Set user id condition.
		 */
		$cond = "usr_id = {$_SESSION[_APP_PRE.'_usr']['id']}";
		/**
		 * Run query.
		 *
		 * Delete online activity data for user.
		 */
		$this->rwDb->dbDelete(_APP_PRE.'_var_online', $cond, NULL, NULL);
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Check if a user is online.
	 *
	 * This method checks if a user has had any activity
	 * in the last 10 minutes.
	 * If so, it is considered that the user is online,
	 * and the method returns the user's IP address.
	 * Otherwise the method return FALSE.
	 *
	 * @param integer $usr_id user id
	 * @return mixed result.
	 */
	public function usrLoggedIn($usr_id)
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
		$cond[] = "online_time > '{$this->rwDb->dbNowMinAgo(10)}'";
		/**
		 * Run query.
		 *
		 * Get ip adress of user, it the user is online.
		 */
		$r = $this->rwDb->dbSelect('online_ip', _APP_PRE.'_var_online', $cond, NULL, 1);
		/**
		 * Return IP address of user if user is online, FALSE otherwise.
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
		 * User alias.
		 */
		$this->usrData['name'] = $userData['usr_name'];
		/**
		 * User group name.
		 */
		$this->usrData['grp_name'] = $groupData['grp_name'];
		/**
		 * User language.
		 */
		$this->usrData['ln'] = $userData['usr_ln'];
		/**
		 * Skin directory.
		 */
		$this->usrData['skin_dir'] = _APP_SKIN_DIR.$userData['usr_skin'];
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
}
?>