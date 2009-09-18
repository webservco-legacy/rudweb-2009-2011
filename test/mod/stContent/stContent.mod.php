<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Static content module.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-17 18:40:00
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
$modAbout['stContent']['name'] = 'stContent';
/**
 * Module description.
 */
$modAbout['stContent']['desc'] = 'Static content module.';
/**
 * Module version.
 */
$modAbout['stContent']['ver']  = '$Revision$';
/**
 * Module author.
 */
$modAbout['stContent']['auth'] = 'Radu Maier';
/**
 * Module Website URL.
 */
$modAbout['stContent']['web']  = 'http://www.rudisoft.net';
/**
 * Module author email.
 */
$modAbout['stContent']['mail'] = 'radu@rudisoft.net';
/**
 * Module dependencies.
 */
$modAbout['stContent']['deps'] = array();
/**
 * Module library dependencies.
 */
$modAbout['stContent']['deps']['lib'] = array('Error', 'Security', 'Database');
/**
 * Module extension dependencies.
 */
$modAbout['stContent']['deps']['ext'] = array('Routing');
/**
 * Module module dependencies.
 */
$modAbout['stContent']['deps']['mod'] = array();

/**
 * rw_Module_stContent
 *
 * rw_Module_stContent module.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwMod
 */
class rw_Module_stContent extends rw_Module_global implements rw_iModule
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

	public function index()
	{
		/**
		 * XXX Test.
		 */
		$this->rwCore->rwLoadLib('Output');
		$cnt = array();
		$cnt['htitle'] = 'Hello World';
		$cnt['title'] = 'Just a title';
		$this->rwCore->rwOut->display($cnt);
		//echo 'request: '.$this->request;
	}
}
?>