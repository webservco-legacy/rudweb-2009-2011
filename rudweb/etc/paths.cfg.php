<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Engine paths configuration file.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-20 20:40:00
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
if(!defined('_RW_EXT_DIR'))
{
	/**
	 * Set core extensions directory.
	 */
	define('_RW_EXT_DIR', _RW_DIR . 'ext/');
}

/**
 * Check if constant is already defined.
 */
if(!defined('_RW_INT_DIR'))
{
	/**
	 * Set core internationalization directory.
	 */
	define('_RW_INT_DIR', _RW_DIR . 'int/');
}

/**
 * Check if constant is already defined.
 */
if(!defined('_RW_LIB_DIR'))
{
	/**
	 * Set core library directory.
	 */
	define('_RW_LIB_DIR', _RW_DIR . 'lib/');
}

/**
 * Check if constant is already defined.
 */
if(!defined('_RW_OPT_DIR'))
{
	/**
	 * Set core 3rdparty directory.
	 */
	define('_RW_OPT_DIR', _RW_DIR . 'opt/');
}

/**
 * Check if constant is already defined.
 */
if(!defined('_RW_TTF_DIR'))
{
	/**
	 * Set core fonts directory.
	 */
	define('_RW_TTF_DIR', _RW_OPT_DIR . 'ttf/');
}
?>