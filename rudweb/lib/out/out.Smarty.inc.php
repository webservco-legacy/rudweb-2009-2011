<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Smarty Output Class
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-18 18:18:00
 * @access     public
 * @package    rwLibOut
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

$smartyPath = 'Smarty/2.6.26/Smarty.class.php';

if (is_readable(_APP_DIR.'opt/'.$smartyPath))
{
	require_once(_APP_DIR.'opt/'.$smartyPath);
}
else if (is_readable(_RW_DIR.'opt/'.$smartyPath))
{
	require_once(_RW_DIR.'opt/'.$smartyPath);
}
else
{
	trigger_error('Output::Template engine Smarty not found.', 256);
}



/**
 * rw_Output_Smarty
 *
 * Smarty output class.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwLibOut
 */
class rw_Output_Smarty extends Smarty implements rw_iOutput
{
	public function __construct()
	{
		parent::__construct();
	}

	public function outSkinDir($outSkinDir)
	{
		$this->template_dir = $outSkinDir;
		$this->compile_dir = _APP_DIR.'tmp/';
		$this->cache_dir = _APP_DIR.'tmp/';
		$this->config_dir = _APP_DIR.'tmp/';
	}

	function set($name, $value)
	{
		return $this->assign($name, $value);
	}

	function parse($outTemplate)
	{
		return $this->fetch($outTemplate);
	}

	function output($outTemplate)
	{
		return $this->display($outTemplate);
	}


}