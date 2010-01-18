<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Application paths configuration file.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-11-07 19:21:00
 * @access     public
 * @package    RudWEb
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
 * Security check.
 */
if(!defined('_RW_VALID'))
{
	/**
	 * Display "Not Found" page.
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * Check if constant is already defined.
 */
if(!defined('_APP_EXT_DIR'))
{
	/**
	 * Set application extensions directory.
	 */
	define('_APP_EXT_DIR', _APP_DIR . 'ext/');
}

/**
 * Check if constant is already defined.
 */
if(!defined('_APP_INT_DIR'))
{
	/**
	 * Set application internationalization directory.
	 */
	define('_APP_INT_DIR', _APP_DIR . 'int/');
}

/**
 * Check if constant is already defined.
 */
if(!defined('_APP_MOD_DIR'))
{
	/**
	 * Set application modules directory.
	 */
	define('_APP_MOD_DIR', _APP_DIR . 'mod/');
}

/**
 * Check if constant is already defined.
 */
if(!defined('_APP_OPT_DIR'))
{
	/**
	 * Set application 3rdparty directory.
	 */
	define('_APP_OPT_DIR', _APP_DIR . 'opt/');
}

/**
 * Check if constant is already defined.
 */
if(!defined('_APP_TMP_DIR'))
{
	/**
	 * Set application temp directory.
	 */
	define('_APP_TMP_DIR', _APP_DIR . 'tmp/');
}

/**
 * Check if constant is already defined.
 */
if(!defined('_APP_SKIN_DIR'))
{
	/**
	 * Set application skins directory.
	 */
	define('_APP_SKIN_DIR', _APP_DIR . 'usr/skins/');
}

/**
 * Check if constant is already defined.
 */
if(!defined('_APP_SKIN_WWW'))
{
	/**
	 * Set application skins url path.
	 */
	define('_APP_SKIN_WWW', _APP_WWW . 'usr/skins/');
}

/**
 * Check if constant is already defined.
 */
if(!defined('_APP_USR_WWW'))
{
	/**
	 * Set application usr (web accessible 3rdparty) directory.
	 */
	define('_APP_USR_WWW', _APP_WWW . 'usr/');
}
?>