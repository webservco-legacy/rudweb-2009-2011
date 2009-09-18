<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Output library
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-18 12:03:00
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
 * rw_iOutput.
 *
 * Methods to be implemented by all output classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwLibOut
 */
interface rw_iOutput
{
	public function set($name, $value);
	
	public function parse($outTemplate);
	
	public function output($outTemplate);
}

/**
 * rw_Output.
 *
 * Global values and methods for all output classes.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwLibOut
 */
class rw_Output
{
	public $outEngine = NULL;
	
	public $outSkin = NULL;
	
	public $outTemplate = NULL;
	
	public $outData = array();
	
	public function __construct()
	{
		//$this->outEngine = 'RudWEb';
		$this->outEngine = 'Smarty';
		//$this->outSkin = 'RudWEb';
		$this->outSkin = 'RudWEb_Smarty';
		$this->outTemplate = 'layout';
	}
	
	
	private function _load()
	{
		$outClass = 'rw_Output_' . $this->outEngine;
		require_once(_RW_DIR_LIB.'out/out.'.$this->outEngine.'.inc.php');
		return new $outClass();
	}
	
	public function display($outData)
	{
		$this->outData = $outData;
		/**
		 * Load template engine
		 */
		$outObj = $this->_load();
		/**
		 * Set skin directory
		 */
		$outObj->outSkinDir(_APP_DIR.'usr/skins/'.$this->outSkin.'/');
		/**
		 * Set compile id
		 */
		//$outObj->compile_id = 'xxx';
		
		foreach($this->outData as $name => $value)
		{
			$outObj->set($name, $value);
		}
		/**
		 * Return data.
		 */
		return $outObj->output('layout'.'.tpl.php');
	}
}
?>