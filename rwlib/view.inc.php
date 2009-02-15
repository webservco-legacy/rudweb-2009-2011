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
 * @subpackage Core
 * @todo       stuff
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
 * @subpackage Core
 */
class app_Viewer
{
	public $cnt = array();
	public $atpl = array();
	public function __construct($cnt, $atpl=array())
	{
		$this->cnt = $cnt;
		$this->atpl = $atpl;
	}
	public function _display()
	{
		switch($this->cnt['type'])
		{
			case 'text' :
				{
					$this->_displayText($this->cnt['skin'], $this->atpl);
					break;
				}
			case 'image' :
				{
					$this->_displayImage($this->cnt['image']);
					break;
				}
			default :
				{
					break;
				}
		}
	}
	public function _displayText($vars, $atpl=array())
	{
		if(is_readable(_RW_DIR_LIB_SKIN.'skin.inc.php')) {require_once(_RW_DIR_LIB_SKIN.'skin.inc.php');} else {require_once('./index.php'); exit;}
		$skinObj = rw_Skin::_load(_APP_TPL);
		$skin_dir = _APP_CFG_SESSIONS ? $_SESSION[_APP_PRE.'_skin_dir'] : _APP_DIR_SKINS._APP_SKIN;
		if($vars['dir'] != '')
		{
			$skin_dir .= '/'.$vars['dir'];
		}
		$skinObj->skindir($skin_dir);
		$skinObj->compile_id = $vars['dir'];

		$totalAtpl = count($atpl);
		if($totalAtpl > 0)
		{
			$atplObj = rw_Skin::_load(_APP_TPL);
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
								//$atplObj->compile_id = $atplVars[$i]['dir'];
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
							//$atplObj->compile_id = $atplVars['dir'];
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
	public function _displayImage($image)
	{
		switch($image['type'])
		{
			case 'png' :
				{
					header("Content-type: image/png");
					header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
					header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
					break;
				}
			default :
				{
					break;
				}
		}
		echo base64_decode($image['data']);
	}
}
?>