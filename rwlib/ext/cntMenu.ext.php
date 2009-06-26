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
	 * Current page id
	 *
	 * @var integer
	 */
	public $pg_id = 0;
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
	public function makeCntMenu($pg_id = 0, $parent=0)
	{
		/**
		 * Set page id
		 */
		$this->pg_id = $pg_id;
		/**
		 * Initialize menu
		 */
		$menu = NULL;
		/**
		 * Initialize menu data
		 */
		$menuData = array('items'=>array(), 'parents'=>array(), 'active'=>array());
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
				if($menuItem['pg_id'] == $this->pg_id)
				{
					$active = $this->_getActive($pg_id, TRUE);
					$menuData['active'] = explode(',', $active);
				}
				else
				{
					$menuData['active'][] = '0';
				}
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
			$menu = $this->_formatMenu($parent, $menuData, $levels, 0);
		}
		/**
		 * Return formatted menu.
		 */
		return $menu;
	}
	/**
	 * Get active links for menu
	 *
	 * @param integer $pg_id id of current page
	 * @param boolean $start if this is the first loop
	 * @return string list of active pages
	 */
	private function _getActive($pg_id, $start=FALSE)
	{
		/**
		 * Could not make this as an array :-(
		 *
		 * Initialize string
		 */
		$active = $start ? $pg_id : '';
		/**
		 * Get parent for current id
		 */
		$rs = $this->extDb->dbSelect('pg_parent', _APP_PRE.'_web_pages', "pg_id = '{$pg_id}'", NULL, NULL);
		$t = $rs->dbNumRows();
		if($t>0)
		{
			/**
			 * If we got something, check to see if it's null (0)
			 */
			$parent = $rs->dbFetchArray();
			if($parent['pg_parent'] != 0)
			{
				/**
				 * We have a valid value
				 * so we add it to the string and start/continue to loop.
				 */
				$active .= ',';
				$active .= $parent['pg_parent'];
				$active .= $this->_getActive($parent['pg_parent']);
			}
		}
		return $active;
	}
	/**
	 * Format menu data
	 *
	 * @param integer $parent parent id
	 * @param array $data menu data
	 * @param boolean $levels go down in the list or display only current level?
	 * @param integer $listLevel the list level
	 * @return string $menu formatted menu
	 */
	private function _formatMenu($parent, $data, $levels, $listLevel)
	{
		$menu = '';
		if(isset($data['parents'][$parent]))
		{
			if($listLevel>0)
			{
				$menu .= "\n";
				for($i=0;$i<=$listLevel;$i++)
				{
					$menu .= "\t";
				}
				$menu .= '<ul class="level'.$listLevel.'">';
			}
			foreach($data['parents'][$parent] as $itemId)
			{
				$menu .= ($listLevel == 0) ? "\n".'<ul class="level'.$listLevel.'">' : '';
				$menu .= "\n";
				if($listLevel>0)
				{
					$menu .= "\t";
				}
				for($j=0;$j<=$listLevel;$j++)
				{
					$menu .= "\t";
				}
				$menu .= '<li class="level'.$listLevel.'">';
				$menu .= '<span class="cntMenuSpan">';
				$menu .= '<a class="cntMenuLink';
				if($data['items'][$itemId]['pg_id'] == $data['active'][0])
				{
					$menu .= ' cntMenuActivePage';
				}
				else if(($data['items'][$itemId]['pg_id'] != $data['active'][0]) && in_array($data['items'][$itemId]['pg_id'], $data['active']))
				{
					$menu .= ' cntMenuActiveParent';
				}
				$menu .= '" href="'._APP_URL.'content/'.$data['items'][$itemId]['pg_id'].'-'.$data['items'][$itemId]['pg_alias'].'"';
				$menu .= ' title="'.$data['items'][$itemId]['pg_title'].'">';
				$menu .= $data['items'][$itemId]['pg_title'];
				$menu .= '</a>';
				$menu .= '</span>';
				if($levels)
				{
					$menu .= "\t\t";
					for($k=0;$k<=$listLevel;$k++)
					{
						$menu .= "\t";
					}
					$menu .= $this->_formatMenu($itemId, $data, TRUE, $listLevel+1);
				}
				$menu .= "\n";
				if($listLevel>0)
				{
					$menu .= "\t";
				}
				for($l=0;$l<=$listLevel;$l++)
				{
					$menu .= "\t";
				}
				$menu .= '</li>';
				$menu .= ($listLevel == 0) ? "\n".'</ul>' : '';
			}
			if($listLevel>0)
			{
				$menu .= "\n";
				for($m=0;$m<=$listLevel;$m++)
				{
					$menu .= "\t";
				}
				$menu .= '</ul>';
			}
		}
		return $menu;
	}
}
?>