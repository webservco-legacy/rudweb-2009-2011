<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Generate dynamic content menu.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-04-12 10:56:00
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

class rw_Ext_cntMenu extends rw_Ext_global implements rw_iExt
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
		$about['name'] = 'cntMenu';
		$about['desc'] = 'Generate dynamic content menu';
		$about['ver']  = '$Revision$';
		$about['auth'] = 'Radu Maier';
		$about['web']  = 'http://www.rudisoft.net';
		$about['mail'] = 'rudisoft@rudisoft.net';
		$about['deps'] = array();
		$about['deps']['cfg'] = array();
		$about['deps']['cfg'][]  = 'Database';
		$about['deps']['ext'] = array();
		parent::__construct($about, $appCore);
	}
	/**
	 * Create administration menu
	 *
	 * @return mixed result
	 */
	public function makeCntMenu($parent=0)
	{
		/**
		 * Initialize menu
		 */
		$menu = NULL;
		/**
		 * Initialize menu data
		 */
		$menuData = array('items'=>array(), 'parents'=>array());
		/**
		 * Get data from db
		 */
		$rs = $this->extDb->dbSelect('pg_id, pg_parent, pg_level, pg_order, pg_title, pg_alias', _APP_PRE.'_web_pages', "pg_ln = '{$_SESSION[_APP_PRE.'_usr_lang']}' AND pg_deleted = '0'", 'pg_parent, pg_order, pg_title', NULL);
		$t = $rs->dbNumRows();
		if($t>0)
		{
			/**
			 * If data exists, populate menu data array.
			 */
			while($menuItem = $rs->dbFetchArray())
			{
				$menuData['items'][$menuItem['pg_id']] = $menuItem;
				$menuData['parents'][$menuItem['pg_parent']][] = $menuItem['pg_id'];
			}
			/**
			 * If the request was not for the root menu return only requested level
			 */
			$levels = ($parent != 0) ? FALSE : TRUE;
			/**
			 * Format menu data.
			 */
			$menu = $this->_formatList($parent, $menuData, $levels);
		}
		/**
		 * Return formatted menu.
		 */
		return $menu;
	}
	/**
	 * Format menu data
	 *
	 * @param integer $parent parent id
	 * @param array $data menu data
	 * @param boolean $levels go down in the list or display only current level?
	 */
	private function _formatList($parent, $data, $levels)
	{
		$list = '';
		if(isset($data['parents'][$parent]))
		{
			$i = 1;
			$list .= '<ul>';
      foreach($data['parents'][$parent] as $itemId)
      {
      	$list .= '<li>';
      	$list .= '<a href="'._APP_URL.'content/'.$data['items'][$itemId]['pg_id'].'-'.$data['items'][$itemId]['pg_alias'].'" title="'.$data['items'][$itemId]['pg_title'].'">';
      	$list .= $data['items'][$itemId]['pg_title'];
      	$list .= '</a>';
      	$list .= '</li>';
      	if($levels)
      	{
      		$list .= $this->_formatList($itemId, $data, TRUE);
      	}
      	$i++;
      }
      $list .= '</ul>';
		}
		$list .= '';
		
		return $list;
		
		/*
		 echo '<pre>';
		 print_r($menuData);
		 trigger_error('xxx', E_USER_ERROR);
		 */
		//XXX
	}
}
?>