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
	static function _display($vars, $atpl=array())
	{
		if(is_readable(_RW_DIR_LIB_SKIN.'skin.inc.php')) {require_once(_RW_DIR_LIB_SKIN.'skin.inc.php');} else {require_once('./index.php'); exit;}
		$skinObj = rw_Skin::_load(_APP_TPL);
		$skin_dir = _APP_CFG_SESSIONS ? $_SESSION[_APP_PRE.'_skin_dir'] : _APP_DIR_SKINS._APP_SKIN;
		$skinObj->skindir($skin_dir);

		$totalAtpl = count($atpl);
		if($totalAtpl > 0)
		{
			$atplObj = rw_Skin::_load(_APP_TPL);
			$atplObj->skindir($skin_dir);
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
								$atplObj->set($name, $value);
							}
						}
						$mainContent .= $atplObj->parse($atplVars[$i]['dir'].$atplVars[$i]['tpl'].'.tpl');
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
							$atplObj->set($name, $value);
						}
					}
					$skinObj->set($atplTitle, $atplObj->parse($atplVars['dir'].$atplVars['tpl'].'.tpl'));
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
}
?>