<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Default blank module.
 * <BR>This is the default module and should always be present.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-17 20:29:00
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
$modAbout['default']['name'] = 'default';
/**
 * Module description.
 */
$modAbout['default']['desc'] = 'Default module.';
/**
 * Module version.
 */
$modAbout['default']['ver']  = '$Revision$';
/**
 * Module author.
 */
$modAbout['default']['auth'] = 'Radu Maier';
/**
 * Module Website URL.
 */
$modAbout['default']['web']  = 'http://www.rudisoft.net';
/**
 * Module author email.
 */
$modAbout['default']['mail'] = 'radu@rudisoft.net';
/**
 * Module dependencies.
 */
$modAbout['default']['deps'] = array();
/**
 * Module library dependencies.
 */
$modAbout['default']['deps']['lib'] = array();
/**
 * Module extension dependencies.
 */
$modAbout['default']['deps']['ext'] = array();
/**
 * Module module dependencies.
 */
$modAbout['default']['deps']['mod'] = array();

/**
 * rw_Module_default
 *
 * rw_Module_default module.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwMod
 */
class rw_Module_default extends rw_Module implements rw_iModule
{
	/**
	 * Constructor.
	 *
	 * Sets module information, core object, request query.
	 *
	 * @param array $modAbout module information
	 * @param mixed $rwCore core engine object
	 * @param mixed $modRequest module request query
	 * @return mixed result
	 */
	public function __construct($modAbout, $rwCore, $modRequest)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($modAbout, $rwCore, $modRequest);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/mod/rw_iModule#index()
	 */
	public function index()
	{
		/**
		 * Test direct output.
		 */
		echo 'Hello World!';
	}
}
?>