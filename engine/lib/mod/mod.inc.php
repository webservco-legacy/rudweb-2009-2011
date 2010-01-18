<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Module library.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
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
	 * Default module functionality.
	 */
	public function index();
}

/**
 * rw_Module.
 *
 * Global values and methods for all module classes.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwMod
 */
class rw_Module
{
	/**
	 * Module information.
	 *
	 * @var array
	 */
	protected $modAbout = array();

	/**
	 * Core object.
	 *
	 * @var mixed
	 */
	protected $rwCore = NULL;

	/**
	 * Location.
	 *
	 * Useful for redirects.
	 * This is set to url route,
	 * not necessarily module/action.
	 *
	 * @var string
	 */
	protected $modLocation = NULL;

	/**
	 * Request query.
	 *
	 * @var mixed
	 */
	protected $modRequest = NULL;

	/**
	 * Constructor.
	 *
	 * Sets module information, core object, request query.
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
		 * Set module information.
		 */
		$this->modAbout = $modAbout;
		/**
		 * Set core object.
		 */
		$this->rwCore = $rwCore;
		/**
		 * Set module location.
		 */
		$this->modLocation = $modLocation;
		/**
		 * Set request query.
		 */
		$this->modRequest = $modRequest;
	}

	/**
	 * Get module information.
	 *
	 * Returns an information field if specified.
	 * The whole list otherwise.
	 *
	 * @param string $field field to return
	 * @return array module information
	 */
	protected function modAbout($field=NULL)
	{
		/**
		 * Return only a field if specified and valid, or the whole list.
		 */
		return ($field && array_key_exists($field, $this->modAbout)) ? $this->modAbout[$field] : $this->modAbout;
	}

	/**
	 * Parse output data and send it to browser.
	 *
	 * @param mixed $outTemplate template file to parse
	 * @param mixed $outData data to include in template
	 * @param mixed $outSkin application skin to use
	 * @param mixed $outEngine output engine to use
	 * @return mixed result
	 */
	protected function rwOutput($outTemplate=NULL, $outData=NULL, $outSkin=NULL, $outEngine=NULL)
	{
		/**
		 * Check if output library is loaded.
		 */
		if(!$this->rwCore->rwOut)
		{
			/**
			 * Show error message.
			 */
			trigger_error('Engine::Can not display output. Output library not loaded.', 256);
		}
		/**
		 * Call output function with outDisplay set to TRUE.
		 */
		return $this->rwCore->rwOut->output($outTemplate, $outData, $outSkin, $outEngine, TRUE);
	}

	/**
	 * Parse output data but don't send it to browser.
	 *
	 * @param mixed $outTemplate template file to parse
	 * @param mixed $outData data to include in template
	 * @param mixed $outSkin skin used
	 * @param mixed $outEngine output engine used
	 * @return mixed result
	 */
	protected function rwParse($outTemplate=NULL, $outData=NULL, $outSkin=NULL, $outEngine=NULL)
	{
		/**
		 * Check if output library is loaded.
		 */
		if(!$this->rwCore->rwOut)
		{
			/**
			 * Show error message.
			 */
			trigger_error('Engine::Can not parse output. Output library not loaded.', 256);
		}
		/**
		 * Call output function with outDisplay set to TRUE.
		 */
		return $this->rwCore->rwOut->output($outTemplate, $outData, $outSkin, $outEngine, FALSE);
	}
}
?>