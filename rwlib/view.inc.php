<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Core application viewer
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-01-22 20:07:00
 * @access     public
 * @package    RudWEb
 * @subpackage rwOut
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
 * app_Viewer
 *
 * Displays content
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage rwOut
 */
class app_Viewer
{
	/**
	 * Output data
	 *
	 * @var array
	 */
	public $out = array();
	/**
	 * Additional template data
	 *
	 * @var array
	 */
	public $atpl = array();
	/**
	 * Set class variables.
	 *
	 * @param array $out
	 * @param array $atpl
	 */
	public function __construct($out, $atpl=array())
	{
		$this->out = $out;
		$this->atpl = $atpl;
	}
	/**
	 * Choose what to display.
	 *
	 * Pass it on to the next method
	 *
	 */
	public function display()
	{
		switch($this->out['type'])
		{
			case 'Smarty' :
			case 'rudweb' :
				{
					$this->_outTpl($this->out['skin'], $this->atpl, $this->out['type']);
					break;
				}
			case 'image' :
				{
					$this->_outImg($this->out['image']);
					break;
				}
			default :
				{
					break;
				}
		}
	}

	/**
	 * HTML + Template output
	 *
	 * @param array $vars
	 * @param array $atpl
	 * @param string $tpl
	 * @return mixed data to be displayed
	 */
	private function _outTpl($vars, $atpl=array(), $tpl='rudweb')
	{
		/**
		 * Load template engine
		 */
		if(is_readable(_RW_DIR_LIB_SKIN.'skin.inc.php')) {require_once(_RW_DIR_LIB_SKIN.'skin.inc.php');} else {require_once('./index.php'); exit;}
		$skinObj = rw_Skin::_load($tpl);
		/**
		 * Get skin directory
		 */
		$skin_dir = _APP_CFG_SESSIONS ? $_SESSION[_APP_PRE.'_skin_dir'] : _APP_DIR_SKINS._APP_SKIN;
		if($vars['dir'] != '')
		{
			$skin_dir .= '/'.$vars['dir'];
		}
		/**
		 * Set skin directory
		 */
		$skinObj->skindir($skin_dir);
		/**
		 * Set compile_id
		 */
		$skinObj->compile_id = $vars['dir'];

		$totalAtpl = count($atpl);
		if($totalAtpl > 0)
		{
			$atplObj = rw_Skin::_load($tpl);
			$atplObj->skindir($skin_dir);
			$atplObj->compile_id = $vars['dir'];
			foreach($atpl as $atplTitle=>$atplVars)
			{
				if(array_key_exists(0, $atplVars))
				{
					$tc = count($atplVars);
					$mainContent = '';
					for($i=0;$i<$tc;$i++)
					{
						$totalAtplVars = count($atplVars[$i]['vars']);
						if($totalAtplVars > 0)
						{
							foreach($atplVars[$i]['vars'] as $name=>$value)
							{
								/**
								 * deprecated
								 * $atplObj->compile_id = $atplVars[$i]['dir'];
								 */
								$atplObj->set($name, $value);
							}
						}
						$atplTpl = ($atplVars[$i]['dir'] != '') ? $atplVars[$i]['dir'].'/'.$atplVars[$i]['tpl'].'.tpl' : $atplVars[$i]['tpl'].'.tpl';
						$mainContent .= $atplObj->parse($atplTpl);
						$skinObj->set($atplTitle, $mainContent);
					}
				}
				else
				{
					$totalAtplVars = count($atplVars['vars']);
					if($totalAtplVars > 0)
					{
						foreach($atplVars['vars'] as $name=>$value)
						{
							/**
							 * deprecated
							 * $atplObj->compile_id = $atplVars['dir'];
							 */
							$atplObj->set($name, $value);
						}
					}
					$atplTpl = ($atplVars['dir'] != '') ? $atplVars['dir'].'/'.$atplVars['tpl'].'.tpl' : $atplVars['tpl'].'.tpl';
					$skinObj->set($atplTitle, $atplObj->parse($atplTpl));
				}
			}
		}

		$varsNew = array_diff_key($vars, array('tpl'=>''));
		$totalVars = count($varsNew);
		if($totalVars > 0)
		{
			foreach($varsNew as $name=>$value)
			{
				$skinObj->set($name, $value);
			}
		}
		return $skinObj->view($vars['tpl'].'.tpl');
	}
	/**
	 * Image Output
	 *
	 * Valid image types:
	 * gif, jpeg, png
	 * note: only tested with png
	 *
	 * @param array $img image data
	 */
	private function _outImg($img)
	{
		header("Content-type: image/".$img['type']);
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		echo base64_decode($img['data']);
	}
}
?>