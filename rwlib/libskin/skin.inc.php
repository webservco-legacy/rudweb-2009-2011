<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Skin classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2008-12-09 16:08:00
 * @access     public
 * @package    RudWEb
 * @subpackage Skins
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
 * Prevent direct file access
 */
if(!defined('_RW_VALID')) {require_once('./index.php'); exit;}

/**
 * rw_iSkin
 *
 * Methods to be implemented by all skin classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Core
 */
interface rw_iSkin
{
	/**
	 * Constructor interface
	 */
	function __construct();
	/**
	 * Sets skin variables
	 *
	 * @param mixed $name Variable name
	 * @param mixed $value Variable value
	 * @return mixed Result
	 */
	function set($name, $value);
	/**
	 * Parses template file
	 *
	 * @param mixed $template Template file to be parsed
	 * @return mixed Result
	 */
	function parse($template);
	/**
	 * Displays template file
	 *
	 * @param mixed $template Template file to be displayed
	 * @return mixed Result
	 */
	function view($template);
}
/**
 * rw_Skin
 *
 * Template engine switcher
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Core
 */
class rw_Skin
{
	/**
	 * Load template engine
	 *
	 * @param string $tplEngine
	 * @return mixed template engine object
	 */
	static function _load($tplEngine = null)
	{
		/**
		 * Allowed template engine types
		 */
		$tplEngines = array('Smarty');
		if(in_array($tplEngine, $tplEngines))
		{
			/**
			 * Required skin class name
			 */
			$skinClass = 'rw_Skin_'.$tplEngine;
			/**
			 * Include skin class
			 */
			if(is_file(_APP_DIR.'3rdparty/'.$tplEngine.'/'.$tplEngine.'.class.php'))
			{
				require_once(_APP_DIR.'3rdparty/'.$tplEngine.'/'.$tplEngine.'.class.php');
			}
			else if(is_file(_RW_DIR.'3rdparty/'.$tplEngine.'/'.$tplEngine.'.class.php'))
			{
				require_once(_RW_DIR.'3rdparty/'.$tplEngine.'/'.$tplEngine.'.class.php');
			}
			else
			{
				trigger_error('Template engine '.$tplEngine . ' is missing.', E_USER_ERROR);
			}

			require_once(_RW_DIR_LIB_SKIN.'skin.'.$tplEngine.'.inc.php');
		}
		else {
			/**
			 * Default template engine
			 */
			$skinClass = 'rw_Skin_rudweb';
			/**
			 * Include skin class
			 */
			require_once(_RW_DIR_LIB_SKIN.'skin.rudweb.inc.php');
		}
		/**
		 * Include skin class
		 */
		return new $skinClass();
	}
}
?>