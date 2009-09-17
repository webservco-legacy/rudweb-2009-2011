<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Module library.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-17 18:24:00
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
 * rw_iModule.
 *
 * Methods to be implemented by all module classes.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwMod
 */
interface rw_iModule
{
	/**
	 * Method for displaying information about the module.
	 *
	 * @return mixed information about the module
	 */
	public function modAbout();
	/**
	 * Default module functionality.
	 */
	public function index();
}

/**
 * rw_Module_global.
 *
 * Global values and methods for all module classes.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwMod
 */
class rw_Module_global
{
	/**
	 * Module information.
	 *
	 * @var array $modAbout
	 */
	public $modAbout = array();

	/**
	 * Core object.
	 *
	 * @var mixed $rwCore
	 */
	public $rwCore = NULL;
	
	/**
	 * Request query.
	 * 
	 * @var mixed $query
	 */
	public $request = NULL;

	/**
	 * Constructor.
	 *
	 * Sets module information.
	 *
	 * @param array $modAbout
	 * @param mixed $rwCore
	 * @param mixed $request
	 * @return mixed result
	 */
	public function __construct($modAbout, $rwCore, $request)
	{
		/**
		 * Set module information.
		 */
		$this->modAbout = $modAbout;
		/**
		 * Set core object.
		 */
		$this->rwCore = $rwCore;
		/**
		 * Set request query.
		 */
		$this->request = $request;
	}

	/**
	 * Get module information.
	 *
	 * @return array module information
	 */
	public function modAbout()
	{
		/**
		 * Return result.
		 */
		return $this->modAbout;
	}
}
?>