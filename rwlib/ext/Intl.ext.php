<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Provide internationalization functionality.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-04-11 18:54:00
 * @access     public
 * @package    RudWEb
 * @subpackage Extensions
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

class rw_Ext_Intl extends rw_Ext_global implements rw_iExt
{
	/**
	 * Constructor
	 * Set extension information and call parent constructor
	 *
	 */
	function __construct($appCore)
	{
		/**
		 * Extension info
		 */
		$about['name'] = 'Intl';
		$about['desc'] = 'Provide internationalization functionality.';
		$about['ver']  = '$Revision$';
		$about['auth'] = 'Radu Maier';
		$about['web']  = 'http://www.rudisoft.net';
		$about['mail'] = 'rudisoft@rudisoft.net';
		$about['deps'] = array();
		$about['deps']['cfg'] = array();
		$about['deps']['cfg'][] = 'Sessions';
		$about['deps']['ext'] = array();
		$about['deps']['ext'][]  = 'Sessions';
		parent::__construct($about, $appCore);
	}
	/**
	 * Create data for language menu
	 *
	 * @return array language menu
	 */
	public function intlMenu($type='usr', $target=NULL)
	{
		$list     = $this->extCore->rwLsDir(_APP_DIR_LANG);
		$langList = $list['d'];
		$total    = count($langList);
		$langs    = array();
		$typeList = array('usr', 'cnt');
		$type = (in_array($type, $typeList)) ? $type : 'usr';
		/*
		echo $type;
		trigger_error('xxx', E_USER_ERROR);
		exit;
		*/
		switch($type)
		{
			case 'cnt' :
				{
					$action = 'setContent';
					break;
				}
			case 'usr' :
				{
					
				}
			default :
				{
					$action = 'setSession';
					break;
				}
		}
		for($i=0;$i<$total;$i++)
		{
			$target = $target ? '/target/'.$target : '';
			$langs[$i]['link'] = ($langList[$i] == $_SESSION[_APP_PRE.'_'.$type.'_lang']) ? 0 : 1;
			$langs[$i]['url'] = ($langList[$i] == $_SESSION[_APP_PRE.'_'.$type.'_lang']) ? '' : _APP_URL.'module/intl/action/'.$action.'/ln/'.$langList[$i].$target;
			$langs[$i]['lang'] = $langList[$i];
		}
		return $langs;
	}
}
?>