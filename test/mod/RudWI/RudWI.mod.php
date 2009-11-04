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
	 * Skin to be used by the module.
	 *
	 * @var string
	 */
	private $outSkin;
	/**
	 * URL of skin to be used.
	 * 
	 * @var string
	 */
	private $outSkinURL;
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
		$this->outSkin = 'RudWI';
		$this->outSkinURL = _APP_SKIN_WWW.'RudWI/';
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/mod/rw_iModule#index()
	 */
	public function index()
	{
		echo 'Welcome to RudWI module.';
		echo '<pre>';
		print_r($_SESSION);
		echo '<hr />';
		print_r($_COOKIE);
		echo '</pre>';
	}

	public function login()
	{
		$this->_output();
	}

	private function _output($data = array())
	{
		$data['outSkinURL'] = $this->outSkinURL;
		return $this->rwOutput('layout', $data, $this->outSkin);
	}
}
?>