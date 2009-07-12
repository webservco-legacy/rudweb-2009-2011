<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Smarty skin class
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2008-12-09 16:25:00
 * @access     public
 * @package    rwOut
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
 * rw_Skin_smarty
 *
 * Skin Class for Smarty
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwOut
 */
class rw_Skin_smarty extends Smarty implements rw_iSkin
{
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}
	/**
	 * Sets the skin directory
	 */
	public function skindir($skindir)
	{
		$this->template_dir = $skindir;
		$this->compile_dir = _APP_DIR_TMP;
		$this->cache_dir = _APP_DIR_TMP;
		$this->config_dir = _APP_DIR_TMP;
	}
	/**
	 * Method for setting variables
	 *
	 */
	function set($name, $value)
	{
		return $this->assign($name, $value);
	}
	/**
	 * Method for parsing template
	 *
	 */
	function parse($template)
	{
		return $this->fetch($template);
	}
	/**
	 * Method for displaying results
	 *
	 */
	function view($template)
	{
		return $this->display($template);
	}
}
?>