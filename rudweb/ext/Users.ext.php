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
	 * @var array
	 */
	private $usrData = array();

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
		 * User visit time.
		 */
		$this->usrData['vtime'] = date("Y-m-d H:i:s");
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
		$this->usrData['alias'] = 'Guest';
		/**
		 * User full name.
		 */
		$this->usrData['name'] = 'Anonymous';
		/**
		 * User group name.
		 */
		$this->usrData['grp_name'] = 'Guests';
		/**
		 * User default language
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
			 * Load user authentication method.
			 */
			$this->_authUser();
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
	 * User authentication.
	 *
	 * @return mixed result
	 */
	private function _authUser()
	{

		/**
		 * Return result.
		 */
		return TRUE;
	}
}
?>