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
./setup/cfg/cfg_rudweb.inc.php
12:57 2008-04-06

rudweb configration
do not modify this file
*/
define('_RUDWEB_NAME', 'rudweb');
define('_RUDWEB_PHP_VER', '4.3.4');
$acts = array('index', 'verif', 'engn', 'lngs', 'skins', 'usett', 'cfgs', 'dbs', 'finish', 'removed', 'removefu', 'removef');
$sets = array('install', 'upgrade', 'remove');
$langs = array('en', 'de', 'es', 'fr', 'it', 'ro'); // don't need this yet

$eol = "\n";

$config_file_path = "inc/";
$config_file_name = "config.inc.php";

$rudwebcfg_file_path = "inc/";
$rudwebcfg_file_name = "rudwebcfg.inc.php";

$lang_file_path    = "inc/langs/";
$lang_file_name    = "langcfg.inc.php";

$skin_file_path     = "skins/";
$skin_file_name     = "skin.info.php";

$sql_file_name     = "dbs.sql";
$sql_delimiter     = ";";

$file_time_stamp = date("H:i Y-m-d");
?>