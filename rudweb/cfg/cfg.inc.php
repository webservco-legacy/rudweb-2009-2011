<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Application configuration file
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-05 11:35:00
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

/* ********** ********** ********** ********** ********** MAIN CONFIGURATION ********** ********** ********** ********** ********** */
/**
 * Error reporting (TRUE/FALSE)
 */
define('_APP_CFG_ERRORS',TRUE);
/**
 * Use a database? (TRUE/FALSE)
 */
define('_APP_CFG_DATABASE',TRUE);
/**
 * Use sessions and users? (TRUE/FALSE)
 */
define('_APP_CFG_SESSIONS',TRUE);
/**
 * Use user authentication? (TRUE/FALSE)
 */
define('_APP_CFG_USERS',TRUE);
/* ********** ********** ********** ********** ********** PATHS ********** ********** ********** ********** ********** */
/**
 * Application path
 *
 * Must end with a slash (/)
 */
define('_APP_DIR', 'e:/home/devel/workspace/RudWEb/rudweb/');
/**
 * Engine path
 *
 * Must end with a slash (/)
 */
define('_RW_DIR', 'e:/home/devel/workspace/RudWEb/rwlib/');
/**
 * Application url
 *
 * Must end with a slash (/)
 */
define('_APP_WWW','http://localhost/workspace/RudWEb/rudweb/');
/* ********** ********** ********** ********** ********** SEO ********** ********** ********** ********** ********** */
/**
 * Application index
 *
 * For full SEO make sure mod_rewrite is enabled and set this value to ''
 * Otherwise this value must be 'index.php/'
 */
define('_APP_INDEX','');
/* ********** ********** ********** ********** ********** DATABASE ********** ********** ********** ********** ********** */
/**
 * Database information
 *
 * Only needed is a database is actually used
 */
define('_APP_DB_TYPE','mysql');
define('_APP_DB_HOST','localhost');
define('_APP_DB_PORT','3306');
define('_APP_DB_USER','test');
define('_APP_DB_PASS','REDACTED');
define('_APP_DB_NAME','test');
/* ********** ********** ********** ********** ********** APPLICATION ********** ********** ********** ********** ********** */
/**
 * Application Information
 */
define('_APP_NAME','Test App');
define('_APP_AUTH','Radu Maier');
define('_APP_PRE','rudweb');
/* ********** ********** ********** ********** ********** LANGUAGE ********** ********** ********** ********** ********** */
/**
 * Default language
 */
define('_APP_LANG','ro');
/* ********** ********** ********** ********** ********** SKINS ********** ********** ********** ********** ********** */
/**
 * Default template engine (Smarty/rudweb/)
 */
define('_APP_TPL','Smarty');
/**
 * Default skin (skin directory name)
 */
define('_APP_SKIN','rudweb_smarty');
/* ********** ********** ********** ********** ********** MISC ********** ********** ********** ********** ********** */
/**
 * Default timezone (http://www.php.net/timezones)
 */
define('_APP_TIMEZONE','Europe/Bucharest');
/* ********** ********** ********** ********** ********** DO NOT EDIT PAST THIS LINE ********** ********** ********** ********** ********** */
/**
 * Extensions
 */
if(is_readable(_APP_DIR.'cfg/cfg.ext.inc.php')) {require_once(_APP_DIR.'cfg/cfg.ext.inc.php');} else {require_once('./404.php'); exit;}
/**
 * Engine config
 */
if(is_readable(_RW_DIR.'rwc.inc.php')) {require_once(_RW_DIR.'rwc.inc.php');} else {require_once('./404.php'); exit;}
/**
 * Core
 */
if(is_readable(_APP_DIR_INC.'app.inc.php')) {require_once(_APP_DIR_INC.'app.inc.php');} else {require_once('./404.php'); exit;}
?>