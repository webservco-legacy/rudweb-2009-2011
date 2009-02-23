<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Controller
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-23 12:28:00
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
 * Configuration file
 */
$cfg = array();
if(is_readable('./cfg/cfg.ini'))
{
	$cfg = parse_ini_file('./cfg/cfg.ini', TRUE);
	define('_APP_CFG_ERRORS',$cfg['Config']['Errors'] ? TRUE : FALSE);
	define('_APP_CFG_DATABASE',$cfg['Config']['Database'] ? TRUE : FALSE);
	define('_APP_CFG_SESSIONS',$cfg['Config']['Sessions'] ? TRUE : FALSE);
	define('_APP_CFG_USERS',$cfg['Config']['Users'] ? TRUE : FALSE);
	define('_APP_CFG_FAKEXT',$cfg['Config']['Fakext'] ? TRUE : FALSE);

	define('_RW_DIR',$cfg['Paths']['Engine']);
	define('_APP_DIR',$cfg['Paths']['App']);
	define('_APP_WWW',$cfg['Paths']['AppURL']);
	define('_APP_INDEX',$cfg['Defaults']['FullSEO'] ? TRUE : FALSE);

	define('_APP_DB_TYPE',$cfg['Database']['Type']);
	define('_APP_DB_HOST',$cfg['Database']['Host']);
	define('_APP_DB_PORT',$cfg['Database']['Port']);
	define('_APP_DB_USER',$cfg['Database']['User']);
	define('_APP_DB_PASS',$cfg['Database']['Pass']);
	define('_APP_DB_NAME',$cfg['Database']['Name']);

	define('_APP_NAME',$cfg['AppInfo']['Name']);
	define('_APP_AUTH',$cfg['AppInfo']['Author']);
	define('_APP_PRE',$cfg['AppInfo']['Prefix']);

	define('_APP_LANG',$cfg['Defaults']['Language']);
	define('_APP_TPL',$cfg['Defaults']['TemplateEngine']);
	define('_APP_SKIN',$cfg['Defaults']['Skin']);
	define('_APP_TIMEZONE',$cfg['Defaults']['TimeZone']);
}
else
{
	require_once('./404.php');
	exit;
}
/**
 * Extensions
 */
$exts = array_keys($cfg['Extensions']);
/**
 * Engine configuration
 */
if(is_readable(_RW_DIR.'rwc.inc.php'))
{
	require_once(_RW_DIR.'rwc.inc.php');
}
else
{
	require_once('./404.php');
	exit;
}
/**
 * Core
 */
if(is_readable(_APP_DIR_INC.'app.inc.php'))
{
	require_once(_APP_DIR_INC.'app.inc.php');
}
else
{
	require_once('./404.php');
	exit;
}
/**
 * Initialize main application core
 */
$appCore = new app_Core;
$appCore->rwInit($exts);

try
{
	/**
	 * Page content
	 */
	$cnt = $appCore->appProcess();
	/**
	 * Global additional templates
	 */
	$atpl = array();
	/**
	 * If normal content, set it,
	 * and also set additional templates
	 */
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
		 * Load custom configuration
		 */
		if(is_readable(_APP_DIR.'cfg/atpl.inc.php'))
		{
			require_once(_APP_DIR.'cfg/atpl.inc.php');
		}
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
}
catch (Exception $e)
{
	echo $appCore->rwErr($e);
	exit;
}
?>