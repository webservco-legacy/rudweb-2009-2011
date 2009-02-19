<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Aplication controller
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-01-22 20:28:00
 * @access     public
 * @package    RudWEb
 * @subpackage App
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

if(_APP_CFG_DATABASE)
{
	$db = $appCore->rwDbConnect();
	$appCore->rwDbSet($db);
	$cnt = $appCore->appProcess();
	$db->dbClose();
}
else
{
	$cnt = $appCore->appProcess();
}
/**
 * Additional templates
 */
$atpl = array();

if($cnt['type'] == 'text')
{
	/**
	 * Menu
	 */
	$atpl['menu'] = array();
	$atpl['menu']['dir'] = '';
	$atpl['menu']['tpl'] = 'menu';
	$atpl['menu']['vars'] = array();
	/**
	 * Actual content
	 */
	$atpl['content'] = array();
	$atpl['content'][0] = array();
	$atpl['content'][0]['dir'] = $cnt['cnt']['dir'];
	$atpl['content'][0]['tpl'] = $cnt['cnt']['tpl'];
	$atpl['content'][0]['vars']['cnt'] = $cnt['cnt']['content'];
	$atpl['content'][0]['vars']['lang'] = $appCore->rwLang();
	$atpl['content'][0]['vars']['usr_status'] = $appCore->rwUsrStatus();
	/**
	 * Footer
	 */
	$atpl['footer'] = array();
	$atpl['footer']['dir'] = '';
	$atpl['footer']['tpl'] = 'footer';
	$atpl['footer']['vars'] = array();
	/**
	 * Override additional templates
	 */
	if(array_key_exists('atpl', $cnt))
	{
		$a_tpl = array('menu', 'content', 'footer');
		foreach($a_tpl as $name=>$value)
		{
			if(array_key_exists($value, $cnt['atpl']))
			{
				$atpl[$value] = array();
				$atpl[$value] = $cnt['atpl'][$value];
			}
		}
	}
}
?>