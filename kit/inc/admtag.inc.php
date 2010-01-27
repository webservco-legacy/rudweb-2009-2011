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
./inc/admtag.inc.php
10:43 2008-05-26
*/
if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 5 && $new_onoff !== "") {
  changedbcfg("CNT_TAGS", $new_onoff, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/tagmoda';
}
if(isset($_POST['tag_id'])) {
  $query_lock = "LOCK TABLES "._RUDWEB_PRE."ws_tags WRITE";
  mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  foreach ($_POST['tag_id'] as $tag_id => $dump) {
    $dtq = "DELETE FROM "._RUDWEB_PRE."ws_tags WHERE tag_id = '".$tag_id."' LIMIT 1";
    mysql_query($dtq) or require _RUDWEB_LIB_DIR . 'myerr.php';
  }
  $query_unlock = "UNLOCK TABLES";
  mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/tagmod/act/adm';
}
else if(isset($_POST['delutags'])) {
  $query_lock = "LOCK TABLES "._RUDWEB_PRE."ws_tags WRITE, "._RUDWEB_PRE."ws_rel WRITE";
  mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  
  $dtq = "DELETE FROM "._RUDWEB_PRE."ws_tags WHERE tag_id NOT IN (SELECT tag_id AS tid FROM "._RUDWEB_PRE."ws_rel)";
  mysql_query($dtq) or require _RUDWEB_LIB_DIR . 'myerr.php';
    
  $query_unlock = "UNLOCK TABLES";
  mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/tagmod/act/adm';
}
?>