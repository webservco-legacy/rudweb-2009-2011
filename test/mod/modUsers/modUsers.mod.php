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
	/**
	 * Constructor.
	 *
	 * @param array $modAbout
	 * @param mixed $rwCore
	 * @param mixed $request
	 * @return mixed result
	 */
	public function __construct($modAbout, $rwCore, $request)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($modAbout, $rwCore, $request);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/mod/rw_iModule#index()
	 */
	public function index()
	{
		//$this->login();
		echo 'Welcome to users module.';
	}

	/**
	 * Login action.
	 *
	 * @return mixed result
	 */
	public function login()
	{
		// set (init) form data.
		$cnt_login['formData'] = array();
		$lang = $this->rwCore->rwGetLang();

		$this->rwCore->rwExts['Forms']->setPostData(_APP_PRE.'_token', 'Security Token', 'StripTags|RemoveBadChars', 'Required');
		$this->rwCore->rwExts['Forms']->setPostData(_APP_PRE.'_login', $lang['MOD']['SOME_STUFF'], 'StripTags', 'Required|ValidEmail');
		$this->rwCore->rwExts['Forms']->setPostData(_APP_PRE.'_pass', 'Password', 'StripTags|RemoveBadChars', 'Required|Min[6]|Max[6]');
		$this->rwCore->rwExts['Forms']->setPostData(_APP_PRE.'_captcha', 'Security Code', 'StripTags|RemoveBadChars', 'Required');
		$this->rwCore->rwExts['Forms']->setPostData(_APP_PRE.'_remember', 'Checkbox', '', 'Required');
		$this->rwCore->rwExts['Forms']->setPostData(_APP_PRE.'_select', 'Select Field', '', 'Equals[2]');

		// filter and validate form data.
		$this->rwCore->rwExts['Forms']->rwForms($this->rwCore->rwSec);


		$cnt_login['formErr'] = $this->rwCore->rwExts['Forms']->formErrors;

		$cnt_login['formData'] = $this->rwCore->rwExts['Forms']->formData;

		$err = $this->rwCore->rwExts['Forms']->countFormErrors();

		// if ok -> continue to personalized user validation.
		// if err -> display form and errors.
		$_SESSION['test_stuff'] = 'mystuff';
		$this->rwCore->rwExts['Routing']->rwSelfRedirect();

		if($err > 0)
		{
			$this->_login_form($cnt_login);
		}
		else{
			$this->index();
		}
	}

	private function _login_form($cnt_login)
	{
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
		$cnt['content'] = $this->rwParse('users/login', $cnt_login);
		/**
		 * Set footer.
		 */
		$cnt['footer'] = $this->rwParse('footer');
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
	 * Captcha action.
	 *
	 * @return mixed result
	 */
	public function captcha()
	{
		echo $this->rwCore->rwExts['Captcha']->displayCaptcha();
	}


}
?>