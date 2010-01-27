<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>No description
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @access     public
 * @package    RudWEb-1.0
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
 *
./inc/config.inc.php
11:43 2010-01-11
*/

if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

// DATABASE CONNECTION SETTINGS
$rudweb_dbtype = 'my';
$rudweb_dbport = '3306';
$rudweb_dbhost = 'localhost';
$rudweb_dbuser = 'rudweb';
$rudweb_dbpass = 'rudweb';
$rudweb_dbname = 'rudweb_temp';
// WEBSITE URL
define('_RUDWEB_SITE_URL','http://localhost/rudweb_1/test/');
//define('_RUDWEB_SITE_URL','http://www.example.com/');
// WEBSITE DIRECTORY
define('_RUDWEB_SITE_DIR','d:/home/rudisoft/www/localhost/public_html/rudweb_1/test/');
//define('_RUDWEB_SITE_DIR','/var/www/html/');
// TAKE SITE SETTINGS FROM DB (1) OR FROM FILE (0)
define('_RUDWEB_DBCFG', '1');
// TAKE SKIN SETTINGS FROM DB(1) OR FROM FILE (0)
define('_RUDWEB_DBSKIN', '0');
// GLOBAL PREFIX, INCLUDING DATABASE TABLES PREFIX
define('_RUDWEB_PRE', 'rudweb_1_');
// REMOVE 'index.php' FROM URLS = ''. DON'T REMOVE = 'index.php/'
define('_RUDWEB_INDEX_PHP', '');
?>