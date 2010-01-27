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
./lib/pic.php
12:50 2008-04-05
*/
/*
WORK ON THIS + UBTHUMB
FOR
SECURITY + FUNCTIONALITY!
*/
error_reporting(E_ALL);

define("_RUDWEB_PUBFIL", TRUE);
//if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}
require_once '../inc/config.inc.php';
require_once '../inc/rudwebc.inc.php';
require_once _RUDWEB_INC_DIR . 'rudwebf.inc.php';

// START SESSION
session_cache_limiter ('public, must-revalidate');
session_cache_expire(600); //minutes
ini_set("session.gc_maxlifetime","36000"); //seconds
session_start();

if (isset($_GET['imgfile']) && isset($_SESSION[_RUDWEB_PRE.'usr_level'])) {
  require_once './ubthumb.php';
}
else {
  require_once './404.php';
}
?>