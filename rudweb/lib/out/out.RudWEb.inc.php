<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>RudWEb Output Class
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-18 17:44:00
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

/**
 * rw_Output_RudWEb
 *
 * RudWEb output class.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwLibOut
 */
class rw_Output_RudWEb implements rw_iOutput
{
	public $outSkinDir;

	public $outData = array();

	public function __construct()
	{

	}

	public function outSkinDir($outSkinDir)
	{
		$this->outSkinDir = $outSkinDir;
	}

	public function set($name, $value)
	{
		$this->outData[$name] = $value;
	}
	
	public function parse($outTemplate, $output=FALSE)
	{
		extract($this->outData);
		ob_start();
		include($this->outSkinDir.''.$outTemplate);
		$out = ob_get_contents();
		ob_end_clean();
		if($output)
		{
			echo $out;
		}
		else
		{
			return $out;
		}
	}
	
	public function output($outTemplate)
	{
		$this->parse($outTemplate, TRUE);
	}
}
?>