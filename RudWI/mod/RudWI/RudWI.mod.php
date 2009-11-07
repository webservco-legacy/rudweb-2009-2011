<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>RudWI module.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-11-04 18:09:00
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
 * Module name.
 */
$modAbout['RudWI']['name'] = 'RudWI';
/**
 * Module description.
 */
$modAbout['RudWI']['desc'] = 'RudWI module.';
/**
 * Module version.
 */
$modAbout['RudWI']['ver']  = '$Revision';
/**
 * Module author.
 */
$modAbout['RudWI']['auth'] = 'Radu Maier';
/**
 * Module Website URL.
 */
$modAbout['RudWI']['web']  = 'http://www.rudisoft.net';
/**
 * Module author email.
 */
$modAbout['RudWI']['mail'] = 'radu@rudisoft.net';
/**
 * Module dependencies.
 */
$modAbout['RudWI']['deps'] = array();
/**
 * Module library dependencies.
 */
$modAbout['RudWI']['deps']['lib'] = array('Error', 'Security', 'Database');
/**
 * Module extension dependencies.
 */
$modAbout['RudWI']['deps']['ext'] = array('Session', 'Users', 'Captcha');
/**
 * Module module dependencies.
 */
$modAbout['RudWI']['deps']['mod'] = array();

/**
 * rw_Module_RudWI
 *
 * rw_Module_RudWI module.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwMod
 */
class rw_Module_RudWI extends rw_Module implements rw_iModule
{
	/**
	 * $_POST data.
	 *
	 * @var array
	 */
	private $loginData = array();

	/**
	 * Form errors.
	 *
	 * @var array
	 */
	private $loginErr = array();

	/**
	 * ???
	 *
	 * @var unknown_type
	 */
	private $loginErrNr = 0;

	/**
	 * Forms extension object.
	 *
	 * Multiple calls to this extension
	 * made it necessary to have a separate object.
	 *
	 * @var mixed
	 */
	private $extForms;

	/**
	 * Users extension object.
	 *
	 * Multiple calls to this extension
	 * made it necessary to have a separate object.
	 *
	 * @var mixed
	 */
	private $extUsers;

	/**
	 * Constructor.
	 *
	 * @param array $modAbout module information
	 * @param mixed $rwCore core engine object
	 * @param mixed $modLocation module location
	 * @param mixed $modRequest module request query
	 * @return mixed result
	 */
	public function __construct($modAbout, $rwCore, $modLocation, $modRequest)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($modAbout, $rwCore, $modLocation, $modRequest);
		/**
		 * Set forms extension object.
		 */
		$this->extForms = $this->rwCore->rwExts['Forms'];
		/**
		 * Set users extension object.
		 */
		$this->extUsers = $this->rwCore->rwExts['Users'];
		/**
		 * Record user activity.
		 */
		$this->extUsers->recordOnline($modLocation, $modRequest);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/mod/rw_iModule#index()
	 */
	public function index()
	{
		if (!$_SESSION[_APP_PRE.'_usr']['auth'])
		{
			$this->login();
			exit;
		}
		echo 'Welcome to RudWI module.';
		echo '<pre>';
		print_r($_SESSION);
		echo '<hr />';
		print_r($_COOKIE);
		echo '</pre>';
	}

	/**
	 * Login user.
	 *
	 * @return mixed result
	 */
	public function login()
	{
		/**
		 * Parse login form.
		 */
		$this->_loginParseData();
		/**
		 * Check number of errors.
		 */
		if($this->loginErrNr > 0)
		{
			/**
			 * Display login form.
			 */
			$this->_loginDisplayForm();
		}
		/**
		 * No errors.
		 */
		else
		{
			/**
			 * Include login functionality.
			 */
			$this->_loginProcessData();
		}
	}

	/**
	 * Login error page.
	 *
	 * @return mixed result
	 */
	public function loginError()
	{
		//XXX
		echo 'error: ' . $this->modRequest;
	}

	/**
	 * Captcha display action.
	 *
	 * @return mixed result
	 */
	public function captcha()
	{
		/**
		 * Display image captcha.
		 */
		echo $this->rwCore->rwExts['Captcha']->displayCaptcha();
	}

	/**
	 * Logout user.
	 *
	 * @return mixed result
	 */
	public function logout()
	{
		if ($_SESSION[_APP_PRE.'_usr']['auth'])
		{
			//clear online activity and failed login history.
			$this->extUsers->clearOnline();
			$this->extUsers->clearLogin();
			$this->extUsers->usrLogout();
		}
		$this->rwCore->rwExts['Routing']->rwRedirect('RudWI');
	}

	/**
	 * Parse login form.
	 *
	 * @return mixed result
	 */
	private function _loginParseData()
	{
		/**
		 * Set error messages list.
		 */
		$this->extForms->setErrorMessages($this->rwCore->rwGetLang('MOD', 'LOGIN_ERR'));
		/**
		 * Set work data.
		 *
		 * Form fields, Filtering rules, Validation rules).
		 */
		$this->_loginSetWorkData();
		/**
		 * Filter and validate form data.
		 */
		$this->extForms->rwForms();
		/**
		 * Get form data.
		 */
		$this->loginData = $this->extForms->getformData();
		/**
		 * Get form errors.
		 */
		$this->loginErr = $this->extForms->getformErrors();
		/**
		 * Get number of errors.
		 */
		$this->loginErrNr = $this->extForms->countFormErrors();
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Set work data to Forms extension.
	 *
	 * @return mixed result
	 */
	private function _loginSetWorkData()
	{
		/**
		 * Security token.
		 */
		$this->extForms->setWorkData(_APP_PRE.'_token', 'Security Token', 'StripTags|RemoveBadChars', 'Required');
		/**
		 * Username.
		 */
		$this->extForms->setWorkData(_APP_PRE.'_login', 'User name', 'StripTags', 'Required|ValidEmail');
		/**
		 * Password.
		 */
		$this->extForms->setWorkData(_APP_PRE.'_pass', 'Password', 'StripTags|RemoveBadChars', 'Required|Min[6]|Max[30]');
		/**
		 * Captcha.
		 */
		$this->extForms->setWorkData(_APP_PRE.'_captcha', 'Security Code', 'StripTags|RemoveBadChars', 'Required|ValidCaptcha['.$this->rwCore->rwExts['Captcha']->getCaptcha().']');
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Display login form.
	 *
	 * @return mixed result
	 */
	private function _loginDisplayForm()
	{
		//XXX
		$dataLogin['formData'] = $this->loginData;
		$dataLogin['formErr'] = $this->loginErr;

		$data['login'] = $this->rwParse('login', $dataLogin);
		$data['skinURL'] = $_SESSION[_APP_PRE.'_usr']['skin_url'];
		return $this->rwOutput('layout', $data);
	}

	/**
	 * Process login data and attempt to login user.
	 *
	 * At this point there should be no validation errors.
	 *
	 * @return mixed result
	 */
	private function _loginProcessData()
	{
		/**
		 * TEMP DB Debug
		 */
		//$this->rwCore->rwDb->dbDebug();
		/**
		* Set login data.
		*/
		$this->_loginSetData();
		/**
		 * Check failed login attempts.
		 */
		if (!$this->extUsers->checkFailedLogins())
		{
			/**
			 * Record failed login attempt.
			 */
			$this->extUsers->recordLogin(0);
			/**
			 * Redirect to error page.
			 */
			$this->rwCore->rwExts['Routing']->rwRedirect('RudWI/loginError/manyattempts');
			/**
			 * Stop script execution.
			 */
			exit;
		}
		/**
		 * Get user data.
		 *
		 */
		$userData = $this->extUsers->getUserData($this->loginData[_APP_PRE.'_pass']);
		/**
		 * Check if user data is invalid (or user deleted).
		 */
		if (!$userData)
		{
			/**
			 * Record failed login attempt.
			 */
			$this->extUsers->recordLogin(0);
			/**
			 * Redirect to error page.
			 */
			$this->rwCore->rwExts['Routing']->rwRedirect('RudWI/loginError/nomatch');
			/**
			 * Stop script execution.
			 */
			exit;
		}
		/**
		 * Check if account is inactive.
		 */
		if ($userData['usr_status'] == 1)
		{
			/**
			 * Record failed login attempt.
			 */
			$this->extUsers->recordLogin(0);
			/**
			 * Redirect to error page.
			 */
			$this->rwCore->rwExts['Routing']->rwRedirect('RudWI/loginError/inactive');
			/**
			 * Stop script execution.
			 */
			exit;
		}
		/**
		 * Check if account is disabled.
		 */
		if ($userData['usr_status'] == 2)
		{
			/**
			 * Record failed login attempt.
			 */
			$this->extUsers->recordLogin(0);
			/**
			 * Redirect to error page.
			 */
			$this->rwCore->rwExts['Routing']->rwRedirect('RudWI/loginError/disabled');
			/**
			 * Stop script execution.
			 */
			exit;
		}
		/**
		 * Get group data.
		 */
		$groupData = $this->extUsers->getGroupData($userData['grp_id']);
		/**
		 * Check if group data is invalid (or group deleted).
		 */
		if (!$groupData)
		{
			/**
			 * Record failed login attempt.
			 */
			$this->extUsers->recordLogin(0);
			/**
			 * Redirect to error page.
			 */
			$this->rwCore->rwExts['Routing']->rwRedirect('RudWI/loginError/nogroup');
			/**
			 * Stop script execution.
			 */
			exit;
		}
		/**
		 * Check if group is inactive.
		 */
		if ($groupData['grp_status'] == 1)
		{
			/**
			 * Record failed login attempt.
			 */
			$this->extUsers->recordLogin(0);
			/**
			 * Redirect to error page.
			 */
			$this->rwCore->rwExts['Routing']->rwRedirect('RudWI/loginError/inactive');
			/**
			 * Stop script execution.
			 */
			exit;
		}
		/**
		 * Check if user already logged in.
		 */
		if ($this->extUsers->usrLoggedIn($userData['usr_id']))
		{
			/**
			 * Record failed login attempt.
			 */
			$this->extUsers->recordLogin(0);
			/**
			 * Redirect to error page.
			 */
			$this->rwCore->rwExts['Routing']->rwRedirect('RudWI/loginError/online');
			/**
			 * Stop script execution.
			 */
			exit;
		}
		/**
		 * Athenticate user.
		 */
		$this->extUsers->usrAuth($userData, $groupData);
		/**
		 * Redirect to new page.
		 */
		$this->rwCore->rwExts['Routing']->rwRedirect('RudWI');
		/**
		 * Stop script execution.
		 */
		exit;
	}

	private function _loginSetData()
	{
		/**
		 * Init login data array.
		 */
		$loginData = array();
		/**
		 * Set user id.
		 *
		 * User is not logged in at this point so we set it to 0.
		 */
		$loginData['usr_id'] = 0;
		/**
		 * Set login email address.
		 */
		$loginData['login_mail'] = $this->loginData[_APP_PRE.'_login'];
		/**
		 * Set ip address.
		 */
		$loginData['login_ip'] = $_SERVER['REMOTE_ADDR'];
		/**
		 * Set user agent.
		 */
		$loginData['login_agent'] = $_SERVER['HTTP_USER_AGENT'];
		/**
		 * Set login time.
		 */
		$loginData['login_time'] = $this->rwCore->rwDb->dbNow();
		/**
		 * Add login data to Users extension.
		 */
		$this->extUsers->setLoginData($loginData);
		/**
		 * Return result.
		 */
		return TRUE;
	}
}
?>