<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Blank module
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-09 15:52:00
 * @access     public
 * @package    RudWEb
 * @subpackage Modules
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

class rw_Mod_test extends rw_Mod_global implements rw_iMod
{
	/**
	 * Constructor
	 * Set module information and call parent constructor
	 *
	 */
	function __construct()
	{
		/**
		 * Module info
		 */
		$about['name'] = 'test';
		$about['desc'] = 'Test module.';
		$about['ver']  = '15:52 2009-02-09';
		$about['auth'] = 'Radu Maier';
		$about['web']  = 'http://www.rudisoft.net';
		$about['mail'] = 'rudisoft@rudisoft.net';
		$about['deps'] = array();
		$about['deps'][]  = 'dep1';
		$about['deps'][]  = 'dep2';
		parent::__construct($about);
	}
	/**
	 * Default module functionality
	 *
	 * @return mixed result
	 */
	function defaultAction()
	{
		$cnt = array();

		$cnt['skin']['tpl'] = 'layout';
		$cnt['skin']['title'] = 'Test Module - Default action';

		$cnt['cnt']['tpl'] = 'blank';
		$cnt['cnt']['content'] = array();

		return $cnt;
	}
	/**
	 * Some other module functionality
	 */
	function testAction()
	{
		$cnt = array();

		$cnt['skin']['tpl'] = 'layout';
		$cnt['skin']['title'] = 'Test Module - testAction';

		$cnt['cnt']['tpl'] = 'contact';
		$cnt['cnt']['content'] = array();

		return $cnt;
	}
	function testMenu()
	{
		global $db;

		$cnt = array();

		$cnt['skin']['tpl'] = 'layout';
		$cnt['skin']['title'] = 'Test Module - testMenu';

		$cnt['cnt']['tpl'] = 'test';
		$cnt['cnt']['content'] = array();
		// db_stuff start
		if($db)
		{
			function pageAdmMenu($parent=0)
			{
				global $db;
				$rs = $db->dbQuery("SELECT * FROM rw_ws_pages WHERE pg_parent = $parent");

				while($r = $rs->dbFetchArray())
				{
					echo $r['pg_id'] . ' : ';
					echo $r['pg_parent'] . ' : ';
					echo $r['pg_level'] . ' : ';
					for($i=1; $i<=$r['pg_level'];$i++)
					{
						echo 'x';
					}
					if($r['pg_parent'] == 0)
					{
						echo "<b>".$r['pg_title']."</b><br>";
					}
					else
					{
						echo $r['pg_title']."<br>";
					}
					//$r['pg_parent'] == 0 ? echo "<b>{$r['pg_title']}</b><br>" : echo $r['pg_title']."<br>";
					pageAdmMenu($r['pg_id']);
				}
			}

			pageAdmMenu();
			trigger_error('here', E_USER_ERROR);

			$rs = $db->dbQuery("SELECT pg_id, pg_title FROM rw_ws_pages");
			$tr = $rs->dbNumRows();
			for($i=0;$i<$tr;$i++)
			{$cnt['cnt']['content'][$i] = $rs->dbFetchArray();}

			//list($pg_id, $pg_parent, $pg_level, $pg_order, $pg_title, $pg_alias) = $rs->dbFetchResult();
		}
		// db_stuff end




		return $cnt;
	}
}
?>