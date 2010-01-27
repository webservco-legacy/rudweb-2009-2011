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
./inc/mod/moddebug.inc.php
12:50 2008-04-05
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

function debugOutput($what) {
  if (_RUDWEB_CFG_DEBUG === "1") {
    echo "\n<HR WIDTH=\"50%\" ALIGN=\"left\">\n<PRE><B>";
    echo $what . "</B>:\n";
    switch($what) {
      case "SESSION": {print_r($_SESSION); break;}
      case "REQUEST": {print_r($_REQUEST); break;}
      case "GET": {print_r($_GET); break;}
      case "POST": {print_r($_POST); break;}
      case "FILES": {print_r($_FILES); break;}
      case "SERVER": {print_r($_SERVER); break;}
      case "CONSTANTS": {print_r(get_defined_constants(true));; break;}
      case "PHPINI": {print_r(ini_get_all());; break;}
      default: {break;}
    }
    echo "</PRE>\n";
  }
}
?>