<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Application index file
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-04-07 12:00:00
 * @access     public
 * @package    rwTools
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
 * Prevent unauthorized access to included files
 */
define('_RW_VALID', TRUE);

/**
 * Check if paths configuration file is readable.
 */
if(!is_readable('./paths.cfg.xml'))
{
	/**
	 * Set application directory.
	 */
	$path['app_dir'] = './';
	/**
	 * Set extensione directory.
	 */
	$path['ext_dir'] = './';
	/**
	 * Set application web directory.
	 */
	$path['www_dir'] = './';
	/**
	 * Set application URL.
	 */
	$path['app_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/';
}
/**
 * Configuration file is readable.
 */
else
{
	/**
	 * Read paths configuration file.
	 */
	$cfg = simplexml_load_file('./paths.cfg.xml');
	/**
	 * Set application directory.
	 */
	$path['app_dir'] = ($cfg->paths->app_dir) ? (string) $cfg->paths->app_dir : './';
	/**
	 * Set extensione directory.
	 */
	$path['ext_dir'] = ($cfg->paths->ext_dir) ? (string) $cfg->paths->ext_dir : './';
	/**
	 * Set application web directory.
	 */
	$path['www_dir'] = ($cfg->paths->www_dir) ? (string) $cfg->paths->www_dir : './';
	/**
	 * Set application URL.
	 */
	$path['app_url'] = ($cfg->paths->app_url) ? (string) $cfg->paths->app_url : 'http://'.$_SERVER['HTTP_HOST'].'/';
}

/**
 * Check if Nfo extension loader is readable.
 */
if(!is_readable('./nfo.ext.loader.php'))
{
	/**
	 * Stop script execution
	 */
	exit;
}

/**
 * Load Nfo extension loader.
 */
require_once('./nfo.ext.loader.php');

/**
 * Stop script execution
 */
exit;
?>