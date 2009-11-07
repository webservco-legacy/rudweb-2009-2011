<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Users module.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-23 11:18:00
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
$modAbout['modUsers']['name'] = 'modUsers';
/**
 * Module description.
 */
$modAbout['modUsers']['desc'] = 'Users module.';
/**
 * Module version.
 */
$modAbout['modUsers']['ver']  = '$Revision$';
/**
 * Module author.
 */
$modAbout['modUsers']['auth'] = 'Radu Maier';
/**
 * Module Website URL.
 */
$modAbout['modUsers']['web']  = 'http://www.rudisoft.net';
/**
 * Module author email.
 */
$modAbout['modUsers']['mail'] = 'radu@rudisoft.net';
/**
 * Module dependencies.
 */
$modAbout['modUsers']['deps'] = array();
/**
 * Module library dependencies.
 */
$modAbout['modUsers']['deps']['lib'] = array('Error', 'Security', 'Database');
/**
 * Module extension dependencies.
 */
$modAbout['modUsers']['deps']['ext'] = array('Session', 'Users', 'Captcha');
/**
 * Module module dependencies.
 */
$modAbout['modUsers']['deps']['mod'] = array();

/**
 * rw_Module_modUsers
 *
 * rw_Module_modUsers module.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwMod
 */
class rw_Module_modUsers extends rw_Module implements rw_iModule
{
	private $formData = array();

	private $formErr = array();

	private $formErrNr = 0;

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
		$this->extForms = $this->rwCore->rwExts['Forms'];
		$this->extUsers = $this->rwCore->rwExts['Users'];
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
		}
		else
		{
			echo 'Welcome to users module.';
			echo '<pre>';
			print_r($_SESSION);
			echo '<hr />';
			print_r($_COOKIE);
			echo '</pre>';
		}

	}

	/**
	 * Login action.
	 *
	 * @return mixed result
	 */
	public function login()
	{
		/*
		 if ($_SESSION[_APP_PRE.'_usr']['auth'])
		 {
			$this->index();
			exit;
			}
			*/
		/**
		 * Parse login form.
		 */
		$this->_parseLoginForm();

		// if ok -> continue to personalized user validation.
		// if err -> display form and errors.
		if($this->formErrNr > 0)
		{
			$this->_login_form();
		}
		else
		{
			/**
			 * XXXTEMP DB Debug
			 */
			//$this->rwCore->rwDb->dbDebug();
			/**
			* Set login data.
			*/
			$this->_setLoginData();
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
				$this->rwCore->rwExts['Routing']->rwRedirect('users/error/manyattempts');
				/**
				 * Stop script execution.
				 */
				exit;
			}
			/**
			 * Get user data.
			 *
			 */
			$userData = $this->extUsers->getUserData($this->formData[_APP_PRE.'_pass']);
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
				$this->rwCore->rwExts['Routing']->rwRedirect('users/error/nomatch');
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
				$this->rwCore->rwExts['Routing']->rwRedirect('users/error/inactive');
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
				$this->rwCore->rwExts['Routing']->rwRedirect('users/error/disabled');
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
				$this->rwCore->rwExts['Routing']->rwRedirect('users/error/nogroup');
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
				$this->rwCore->rwExts['Routing']->rwRedirect('users/error/inactive');
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
				$this->rwCore->rwExts['Routing']->rwRedirect('users/error/online');
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
			$this->rwCore->rwExts['Routing']->rwRedirect('users');
			/**
			 * Stop script execution.
			 */
			exit();
		}
	}

	/**
	 * Display login form.
	 *
	 * Note that this mathod cannot be called directly.
	 *
	 * @return mixed result
	 */
	private function _login_form()
	{
		/**
		 * Initialize content vars.
		 */
		$cnt = array();
		/**
		 * Set header title.
		 */
		$cnt['htitle'] = _APP_NAME;
		/**
		 * Set page title.
		 */
		$cnt['title'] = 'Hello World!';
		/**
		 * Set page content.
		 */
		$data['formData'] = $this->formData;
		$data['formErr'] = $this->formErr;
		$cnt['content'] = $this->rwParse('users/login', $data);
		/**
		 * Set footer.
		 */
		$cnt['footer'] = $this->rwParse('footer');
		/**
		 * Set action variable.
		 */
		$cnt['location'] = $this->modLocation;
		/**
		 * Set request variable.
		 */
		$cnt['request'] = $this->modRequest;
		/**
		 * Display output.
		 */
		$this->rwOutput('layout', $cnt);
	}

	/**
	 *
	 */
	public function error()
	{
		echo 'error: ' . $this->modRequest;
	}

	public function logout()
	{
		if ($_SESSION[_APP_PRE.'_usr']['auth'])
		{
			//clear online activity and failed login history.
			$this->extUsers->clearOnline();
			$this->extUsers->clearLogin();
			$this->extUsers->usrLogout();
		}
		$this->rwCore->rwExts['Routing']->rwRedirect('users');
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

	private function _parseLoginForm()
	{
		/**
		 * Set error messages list.
		 */
		$this->extForms->setErrorMessages($this->rwCore->rwGetLang('MOD', 'ERR'));
		/**
		 * Set work data.
		 *
		 * Form fields, Filtering rules, Validation rules).
		 */
		$this->_setWorkData();
		/**
		 * Filter and validate form data.
		 */
		$this->extForms->rwForms();
		/**
		 * Get form data.
		 */
		$this->formData = $this->extForms->getformData();
		/**
		 * Get form errors.
		 */
		$this->formErr = $this->extForms->getformErrors();
		/**
		 * Get number of errors.
		 */
		$this->formErrNr = $this->extForms->countFormErrors();
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Set wotk data to Forms extension.
	 *
	 * @return mixed result
	 */
	private function _setWorkData()
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
		 * TEMP Remember.
		 */
		$this->extForms->setWorkData(_APP_PRE.'_remember', 'Checkbox', '', 'Required');
		/**
		 * TEMP Select.
		 */
		$this->extForms->setWorkData(_APP_PRE.'_select', 'Select Field', '', 'Equals[2]');
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Set login data.
	 *
	 * Login data is used by the Users extension
	 * to perform various checks at login time.
	 *
	 * @return mixed result
	 */
	private function _setLoginData()
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
		$loginData['login_mail'] = $this->formData[_APP_PRE.'_login'];
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