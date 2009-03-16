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
 * Set configuration options
 */
$cfg = array();
if(is_readable('./cfg/cfg.ini'))
{
	/**
	 * Parse configuration file
	 */
	$cfg = parse_ini_file('./cfg/cfg.ini', TRUE);
	/**
	 * Report application errors
	 *
	 */
	define('_APP_CFG_ERRORS',$cfg['Config']['Errors'] ? TRUE : FALSE);
	/**
	 * Use database
	 *
	 */
	define('_APP_CFG_DATABASE',$cfg['Config']['Database'] ? TRUE : FALSE);
	/**
	 * Use sessions and users
	 *
	 */
	define('_APP_CFG_SESSIONS',$cfg['Config']['Sessions'] ? TRUE : FALSE);
	/**
	 * Use user authentication
	 *
	 */
	define('_APP_CFG_USERS',$cfg['Config']['Users'] ? TRUE : FALSE);
	/**
	 * Use fake file extension for URL's
	 *
	 */
	define('_APP_CFG_FAKEXT',$cfg['Config']['Fakext'] ? TRUE : FALSE);
	/**
	 * Engine path
	 *
	 */
	define('_RW_DIR',$cfg['Paths']['Engine']);
	/**
	 * Application path
	 *
	 */
	define('_APP_DIR',$cfg['Paths']['App']);
	/**
	 * Application URL
	 *
	 */
	define('_APP_WWW',$cfg['Paths']['AppURL']);
	/**
	 * Full SEO
	 *
	 */
	define('_APP_INDEX',$cfg['Defaults']['FullSEO'] ? '' : 'index.php/');
	/**
	 * Database type
	 *
	 */
	define('_APP_DB_TYPE',$cfg['Database']['Type']);
	/**
	 * Database host
	 *
	 */
	define('_APP_DB_HOST',$cfg['Database']['Host']);
	/**
	 * Database port
	 *
	 */
	define('_APP_DB_PORT',$cfg['Database']['Port']);
	/**
	 * Database user
	 *
	 */
	define('_APP_DB_USER',$cfg['Database']['User']);
	/**
	 * Database password
	 *
	 */
	define('_APP_DB_PASS',$cfg['Database']['Pass']);
	/**
	 * Database name
	 *
	 */
	define('_APP_DB_NAME',$cfg['Database']['Name']);
	/**
	 * Application name
	 *
	 */
	define('_APP_NAME',$cfg['AppInfo']['Name']);
	/**
	 * Application author
	 *
	 */
	define('_APP_AUTH',$cfg['AppInfo']['Author']);
	/**
	 * Application prefix
	 *
	 */
	define('_APP_PRE',$cfg['AppInfo']['Prefix']);
	/**
	 * Default language
	 *
	 */
	define('_APP_LANG',$cfg['Defaults']['Language']);
	/**
	 * Default template engine
	 *
	 */
	define('_APP_TPL',$cfg['Defaults']['TemplateEngine']);
	/**
	 * Default skin
	 *
	 */
	define('_APP_SKIN',$cfg['Defaults']['Skin']);
	/**
	 * Default time zone
	 *
	 */
	define('_APP_TIMEZONE',$cfg['Defaults']['TimeZone']);
	/**
	 * Default content type
	 */
	define('_APP_CONTENT_TYPE',$cfg['Defaults']['ContentType'] ? $cfg['Defaults']['ContentType'] : 'page');
	/**
	 * Default content id
	 */
	define('_APP_CONTENT_ID', $cfg['Defaults']['ContentId'] ? $cfg['Defaults']['ContentId'] : 'index');
	/**
	 * Initialize content
	 */
	$cnt1 = array();
	/**
	 * Default page content type
	 */
	$cnt1['type'] = $cfg['SkinDefaults']['CntType'] ? $cfg['SkinDefaults']['CntType'] : 'text';
	/**
	 * Main layout template directory.
	 */
	$cnt1['skin']['dir'] = $cfg['SkinDefaults']['SkinDir'] ? $cfg['SkinDefaults']['SkinDir'] : '';
	/**
	 * Main layout template file
	 */
	$cnt1['skin']['tpl'] = $cfg['SkinDefaults']['SkinTpl'] ? $cfg['SkinDefaults']['SkinTpl'] : 'layout';
	/**
	 * Main layout page title
	 */
	$cnt1['skin']['title'] = $cfg['SkinDefaults']['PageTitle'] ? $cfg['SkinDefaults']['PageTitle'] : '';
	/**
	 * Meta Data
	 */
	$cnt1['skin']['meta'] = array();
	/**
	 * Meta Subject
	 */
	$cnt1['skin']['meta']['subject'] = $cfg['SkinDefaults']['MetaSubject'] ? $cfg['SkinDefaults']['MetaSubject'] : _APP_NAME;
	/**
	 * Meta Description
	 */
	$cnt1['skin']['meta']['description'] = $cfg['SkinDefaults']['MetaDescription'] ? $cfg['SkinDefaults']['MetaDescription'] : _APP_NAME;
	/**
	 * Meta Keywords
	 */
	$cnt1['skin']['meta']['keywords'] = $cfg['SkinDefaults']['MetaKeywords'] ? $cfg['SkinDefaults']['MetaKeywords'] : _APP_NAME;
	/**
	 * Meta Copyright
	 */
	$cnt1['skin']['meta']['copyright'] = $cfg['SkinDefaults']['MetaCopyright'] ? $cfg['SkinDefaults']['MetaCopyright'] : _APP_AUTH;
	/**
	 * Meta Designer
	 */
	$cnt1['skin']['meta']['designer'] = $cfg['SkinDefaults']['MetaDesigner'] ? $cfg['SkinDefaults']['MetaDesigner'] : _APP_AUTH;
	/**
	 * Meta Publisher
	 */
	$cnt1['skin']['meta']['publisher'] = $cfg['SkinDefaults']['MetaPublisher'] ? $cfg['SkinDefaults']['MetaPublisher'] : _APP_AUTH;
	/**
	 * Meta Author
	 */
	$cnt1['skin']['meta']['author'] = $cfg['SkinDefaults']['MetaAuthor'] ? $cfg['SkinDefaults']['MetaAuthor'] : _APP_AUTH;
	//XXX
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
	$cnt2 = $appCore->appProcess();
	/**
	 * Merge content data
	 */
	$cnt = array_merge($cnt1, $cnt2);
	$cnt['skin'] = array_merge($cnt1['skin'], $cnt2['skin']);
	$cnt['cnt'] = array_merge($cnt1['cnt'], $cnt2['cnt']);
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
		$atpl['menu']['vars']['lang'] = $appCore->rwLang();
		/**
		 * Actual content
		 */
		$atpl['content'] = array();
		/**
		 * Check for multiple content items
		 */
		if(array_key_exists(0, $cnt['cnt']))
		{
			foreach($cnt['cnt'] as $index=>$data)
			{
				if($appCore->rwCheckInt($index))
				{
					/**
					 * Multiple content items
					 */
					$atpl['content'][$index] = array();
					$atpl['content'][$index]['dir'] = $cnt['cnt'][$index]['dir'];
					$atpl['content'][$index]['tpl'] = $cnt['cnt'][$index]['tpl'];
					$atpl['content'][$index]['vars']['cnt'] = $cnt['cnt'][$index]['content'];
					$atpl['content'][$index]['vars']['lang'] = $appCore->rwLang();
					$atpl['content'][$index]['vars']['usr_status'] = $appCore->rwUsrStatus();
				}
			}
		}
		else
		{
			/**
			 * Only one content item
			 */
			$atpl['content'][0] = array();
			$atpl['content'][0]['dir'] = $cnt['cnt']['dir'];
			$atpl['content'][0]['tpl'] = $cnt['cnt']['tpl'];
			$atpl['content'][0]['vars']['cnt'] = $cnt['cnt']['content'];
			$atpl['content'][0]['vars']['lang'] = $appCore->rwLang();
			$atpl['content'][0]['vars']['usr_status'] = $appCore->rwUsrStatus();
		}
		/**
		 * Footer
		 */
		$atpl['footer'] = array();
		$atpl['footer']['dir'] = '';
		$atpl['footer']['tpl'] = 'footer';
		$atpl['footer']['vars'] = array();
		$atpl['footer']['vars']['lang'] = $appCore->rwLang();
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