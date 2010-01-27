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
./inc/admcmt.inc.php
10:56 2008-05-26
*/
if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 5 && $new_onoff !== "") {
  changedbcfg("CNT_CMNTS", $new_onoff, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/cmtmoda';
}
$cmt_alias = '';
if(isset($_POST['cmt_id'])) {
  if($cmt_typ == 0) {
    $aq = "SELECT cnt_alias FROM "._RUDWEB_PRE."ws_cnt WHERE cnt_id = '".$cnt_id."' LIMIT 1";
    $rq = rudweb_qres($rudweb_dbtype, $aq);
    $cnt_alias = rudweb_result($rudweb_dbtype, $rq, 0);
  }
}
if(isset($_POST['cmtadd']) && $cnt_id != 0) {
  if($cmt_txt != '') {
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."ws_cmt WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $query_NextId = "SELECT MAX(cmt_id) FROM "._RUDWEB_PRE."ws_cmt";
    $rstNextId = rudweb_qres($rudweb_dbtype, $query_NextId);
    $new_cmt_id = rudweb_result($rudweb_dbtype, $rstNextId, 0) + 1;
    $acq = "INSERT INTO "._RUDWEB_PRE."ws_cmt (cmt_id, cmt_ln, cmt_typ, cnt_id, cmt_txt, cmt_crd, cmt_crt, cmt_cru, cmt_mdd, cmt_mdt, cmt_mdu) VALUES ('".$new_cmt_id."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$cmt_typ."', '".$cnt_id."', '".$cmt_txt."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '0000-00-00', '00:00:00', '0')";
    mysql_query($acq) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    if($cmt_typ == 0) {$redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'content/' . $cnt_alias . '#cmtview';}
    else {$redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'catalog/item/id/' . $cnt_id . '#cmtview';}
  }
}
else if (isset($_POST['cmtmod']) && $cmt_id != 0) {
  if($cmt_txt != '') {
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."ws_cmt WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $mcq = "UPDATE "._RUDWEB_PRE."ws_cmt SET cmt_txt = '".$cmt_txt."', cmt_mdd = '".$action_date."', cmt_mdt = '".$action_time."', cmt_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE cmt_id = '".$cmt_id."' LIMIT 1";
    mysql_query($mcq) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    if($cmt_typ == 0) {$redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'content/' . $cnt_alias . '#cmtview';}
    else {$redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'catalog/item/id/' . $cnt_id . '#cmtview';}
  }
}
else if (isset($_POST['cmtdel']) && ($cmt_id != 0 && $cnt_id != 0)) {
  $query_lock = "LOCK TABLES "._RUDWEB_PRE."ws_cmt WRITE";
  mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  $dcq = "DELETE FROM "._RUDWEB_PRE."ws_cmt WHERE cmt_id = '".$cmt_id."' LIMIT 1";
  mysql_query($dcq) or require _RUDWEB_LIB_DIR . 'myerr.php';
  $query_unlock = "UNLOCK TABLES";
  mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  if($cmt_typ == 0) {$redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'content/' . $cnt_alias . '#cmtview';}
  else {$redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'catalog/item/id/' . $cnt_id . '#cmtview';}
}
?>