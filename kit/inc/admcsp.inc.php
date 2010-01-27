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
./inc/admcsp.inc.php
11:43 2008-05-26
*/
if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 5 && $new_onoff !== "") {
  changedbcfg("CSP_ON", $new_onoff, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/cspmoda';
}
if($csp_lmt !== "") {
  changedbcfg("CSP_LMT", $csp_lmt, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/cspmod';
}
if(isset($_POST['csp_new'])) { // add new
  $query_NextId = "SELECT MAX(csp_id) FROM "._RUDWEB_PRE."cat_csp";
  $rstNextId = rudweb_qres($rudweb_dbtype, $query_NextId);
  $id_of_csp = rudweb_result($rudweb_dbtype, $rstNextId, 0) + 1;
  
  $query_ord = "SELECT MAX(csp_ord) FROM "._RUDWEB_PRE."cat_csp WHERE csp_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."'";
  $rst_ord = rudweb_qres($rudweb_dbtype, $query_ord);
  $csp_ord[$id_of_csp] = rudweb_result($rudweb_dbtype, $rst_ord, 0) + 1;
  
  $prd_id[$id_of_csp]    = rudweb_filter_input($_POST['prd_id']);
  $csp_sdate[$id_of_csp] = rudweb_filter_input($_POST['csp_sdate']);
  $csp_edate[$id_of_csp] = rudweb_filter_input($_POST['csp_edate']);
  
  $query_lock = "LOCK TABLES "._RUDWEB_PRE."cat_csp WRITE";
  mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  
  $insertquery = "INSERT INTO "._RUDWEB_PRE."cat_csp (csp_id, csp_ln, prd_id, csp_sdate, csp_edate, csp_ord, csp_crd, csp_crt, csp_cru, csp_mdd, csp_mdt, csp_mdu) VALUES ('".$id_of_csp."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$prd_id[$id_of_csp]."', '".$csp_sdate[$id_of_csp]."', '".$csp_edate[$id_of_csp]."', '".$csp_ord[$id_of_csp]."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '0000-00-00', '00:00:00', '0')";
  mysql_query($insertquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
  $query_unlock = "UNLOCK TABLES";
  mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/cspmod/act/adm';
  
}
else if(isset($_POST['csp_id'])) { // modify
  foreach ($_POST['csp_id'] as $id_of_csp => $dump) {
    $csp_id[$id_of_csp]    = rudweb_filter_input($_POST['csp_id'][$id_of_csp]);
    $prd_id[$id_of_csp]    = rudweb_filter_input($_POST['prd_id'.$id_of_csp]);
    $csp_ord[$id_of_csp]   = rudweb_filter_input($_POST['csp_ord'.$id_of_csp]); 
    $csp_sdate[$id_of_csp] = rudweb_filter_input($_POST['csp_sdate'.$id_of_csp]);
    $csp_edate[$id_of_csp] = rudweb_filter_input($_POST['csp_edate'.$id_of_csp]);
    
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."cat_csp WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';

    if (isset($_POST['delcsp'.$id_of_csp])) { // delete offer
      $cspquery = "DELETE FROM "._RUDWEB_PRE."cat_csp WHERE csp_id = '".$csp_id[$id_of_csp]."' LIMIT 1";
      mysql_query($cspquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
    }
    else {
      $modquery = "UPDATE "._RUDWEB_PRE."cat_csp SET prd_id = '".$prd_id[$id_of_csp]."', csp_sdate = '".$csp_sdate[$id_of_csp]."', csp_edate = '".$csp_edate[$id_of_csp]."', csp_ord = '".$csp_ord[$id_of_csp]."', csp_mdd = '".$action_date."', csp_mdt = '".$action_time."', csp_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE csp_id = '".$csp_id[$id_of_csp]."' LIMIT 1";
      mysql_query($modquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
    }
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/cspmod/act/adm';
  }
}
?>