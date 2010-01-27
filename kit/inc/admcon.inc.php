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
./inc/admcon.inc.php
19:03 2008-11-19
*/
if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 5 && $new_onoff !== "") {
  changedbcfg("CON", $new_onoff, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmoda';
}
if (isset($_POST['con_cat_add'])) {
  $con_cat_id     = 0;
  $con_cat_tt     = null;
  $con_cat_notif3 = null;
  $con_cat_notif4 = null;
  $con_cat_notify = null;
  $con_cat_send   = null;
  if(isset($_POST['con_cat_tt'][0]))     {$con_cat_tt     = rudweb_filter_input($_POST['con_cat_tt'][0]);}
  if(isset($_POST['con_cat_notif3'][0])) {$con_cat_notif3 = 1;}
  if(isset($_POST['con_cat_notif4'][0])) {$con_cat_notif4 = 1;}
  if(isset($_POST['con_cat_notify'][0])) {$con_cat_notify = rudweb_filter_input($_POST['con_cat_notify'][0]);}
  if(isset($_POST['con_cat_send'][0]))   {$con_cat_send   = rudweb_filter_input($_POST['con_cat_send'][0]);}
  
  if($con_cat_tt[0] != '') {
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."con_cat WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $con_cat_id = getNextId('con_cat', 'con_cat_id');
    $q = "INSERT INTO "._RUDWEB_PRE."con_cat (con_cat_id, con_cat_ln, con_cat_tt, con_cat_notif3, con_cat_notif4, con_cat_notify, con_cat_send, con_cat_crd, con_cat_crt, con_cat_cru, con_cat_mdd, con_cat_mdt, con_cat_mdu) VALUES ('".$con_cat_id."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$con_cat_tt."', '".$con_cat_notif3."', '".$con_cat_notif4."', '".$con_cat_notify."', '".$con_cat_send."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '0000-00-00', '00:00:00', '0')";
    mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  }
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmod/act/cat';
}
else if (isset($_POST['con_cat_mod'])) {
  $con_cat_id = 0;
  if(isset($_POST['con_cat_id'])) {
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."con_cat WRITE, "._RUDWEB_PRE."con_con WRITE, "._RUDWEB_PRE."con_det WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    foreach ($_POST['con_cat_id'] as $current_id => $con_cat_id) {
      $con_cat_tt     = null;
      $con_cat_notif3 = null;
      $con_cat_notif4 = null;
      $con_cat_notify = null;
      $con_cat_send   = null;
    
      if(isset($_POST['con_cat_tt'][$current_id]))     {$con_cat_tt[$current_id]     = rudweb_filter_input($_POST['con_cat_tt'][$current_id]);}
      if(isset($_POST['con_cat_notif3'][$current_id])) {$con_cat_notif3[$current_id] = 1;}
      if(isset($_POST['con_cat_notif4'][$current_id])) {$con_cat_notif4[$current_id] = 1;}
      if(isset($_POST['con_cat_notify'][$current_id])) {$con_cat_notify[$current_id] = rudweb_filter_input($_POST['con_cat_notify'][$current_id]);}
      if(isset($_POST['con_cat_send'][$current_id]))   {$con_cat_send[$current_id]   = rudweb_filter_input($_POST['con_cat_send'][$current_id]);}
      
      if($con_cat_tt[$current_id] != '') {
        if (isset($_POST['con_cat_del'][$current_id])) {
          $ve = 0;
          
          $qv1 = "SELECT con_id FROM ". _RUDWEB_PRE. "con_con WHERE con_cat_id = '".$current_id."'";
          $rv1 = rudweb_qres($rudweb_dbtype, $qv1);
          $tv1 = rudweb_qtotal($rudweb_dbtype, $rv1);
          if($tv1 != 0) {$ve = 1;}
          
          $qv2 = "SELECT con_det_id FROM ". _RUDWEB_PRE. "con_det WHERE con_cat_id = '".$current_id."'";
          $rv2 = rudweb_qres($rudweb_dbtype, $qv2);
          $tv2 = rudweb_qtotal($rudweb_dbtype, $rv2);
          if($tv2 != 0) {$ve = 1;}
          
          if($ve == 0) {
            $q = "DELETE FROM "._RUDWEB_PRE."con_cat WHERE con_cat_id = '".$current_id."'";
            mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
            $q = "OPTIMIZE TABLE "._RUDWEB_PRE."con_cat";
            mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
          }
        }
        else {
          $q = "UPDATE "._RUDWEB_PRE."con_cat SET con_cat_tt = '".$con_cat_tt[$current_id]."', con_cat_notif3 = '".$con_cat_notif3[$current_id]."', con_cat_notif4 = '".$con_cat_notif4[$current_id]."', con_cat_notify = '".$con_cat_notify[$current_id]."', con_cat_send = '".$con_cat_send[$current_id]."', con_cat_mdd = '".$action_date."', con_cat_mdt = '".$action_time."', con_cat_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE con_cat_id = '".$current_id."'";
          mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
        }
      }
    }
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  }
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmod/act/cat';
}
else if (isset($_POST['con_det_add'])) {
  $con_det_id[0]  = 0;
  $con_cat_id     = 0;
  $con_det_typ[0] = null;
  $con_det_tt[0]  = null;
  $con_det_ord[0] = null;
  $con_det_req[0] = null;
  if(isset($_POST['con_cat_id'][0]))  {$con_cat_id     = rudweb_filter_input($_POST['con_cat_id'][0]);}
  if(isset($_POST['con_det_typ'][0])) {$con_det_typ[0] = rudweb_filter_input($_POST['con_det_typ'][0]);}
  if(isset($_POST['con_det_tt'][0]))  {$con_det_tt[0]  = rudweb_filter_input($_POST['con_det_tt'][0]);}
  if(isset($_POST['con_det_ord'][0])) {$con_det_ord[0] = rudweb_filter_input($_POST['con_det_ord'][0]);}
  if(isset($_POST['con_det_req'][0])) {$con_det_req[0] = 1;}
  
  if($con_det_tt[0] != '') {
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."con_det WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $con_det_id[0] = getNextId('con_det', 'con_det_id');
    $q = "INSERT INTO "._RUDWEB_PRE."con_det (con_det_id, con_cat_id, con_det_typ, con_det_tt, con_det_ord, con_det_req, con_det_crd, con_det_crt, con_det_cru, con_det_mdd, con_det_mdt, con_det_mdu) VALUES ('".$con_det_id[0]."', '".$con_cat_id."', '".$con_det_typ[0]."', '".$con_det_tt[0]."', '".$con_det_ord[0]."', '".$con_det_req[0]."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '0000-00-00', '00:00:00', '0')";
    mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  }
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmod/act/det/cat/' . $con_cat_id;
}
else if (isset($_POST['con_det_mod'])) {
  $con_det_id = 0;
  if(isset($_POST['con_det_id'])) {
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."con_det WRITE, "._RUDWEB_PRE."con_opt WRITE, "._RUDWEB_PRE."con_val WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    foreach ($_POST['con_det_id'] as $current_id => $con_det_id) {
      $con_cat_id               = 0;
      $con_det_tt[$current_id]  = null;
      $con_det_ord[$current_id] = null;
      $con_det_req[$current_id] = null;
    
      if(isset($_POST['con_cat_id'][$current_id]))  {$con_cat_id               = rudweb_filter_input($_POST['con_cat_id'][$current_id]);}
      if(isset($_POST['con_det_tt'][$current_id]))  {$con_det_tt[$current_id]  = rudweb_filter_input($_POST['con_det_tt'][$current_id]);}
      if(isset($_POST['con_det_ord'][$current_id])) {$con_det_ord[$current_id] = rudweb_filter_input($_POST['con_det_ord'][$current_id]);}
      if(isset($_POST['con_det_req'][$current_id])) {$con_det_req[$current_id] = 1;}
      
      if($con_det_tt[$current_id] != '') {
        if (isset($_POST['con_det_del'][$current_id])) {
          $ve = 0;
          
          $qv1 = "SELECT con_val_id FROM ". _RUDWEB_PRE. "con_val WHERE con_det_id = '".$current_id."'";
          $rv1 = rudweb_qres($rudweb_dbtype, $qv1);
          $tv1 = rudweb_qtotal($rudweb_dbtype, $rv1);
          if($tv1 != 0) {$ve = 1;}
          
          $qv2 = "SELECT con_opt_id FROM ". _RUDWEB_PRE. "con_opt WHERE con_det_id = '".$current_id."'";
          $rv2 = rudweb_qres($rudweb_dbtype, $qv2);
          $tv2 = rudweb_qtotal($rudweb_dbtype, $rv2);
          if($tv2 != 0) {$ve = 1;}
          
          if($ve == 0) {
            $q = "DELETE FROM "._RUDWEB_PRE."con_det WHERE con_det_id = '".$current_id."'";
            mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
            $q = "OPTIMIZE TABLE "._RUDWEB_PRE."con_det";
            mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
          }
        }
        else {
          $q = "UPDATE "._RUDWEB_PRE."con_det SET con_det_tt = '".$con_det_tt[$current_id]."', con_det_ord = '".$con_det_ord[$current_id]."', con_det_req = '".$con_det_req[$current_id]."', con_det_mdd = '".$action_date."', con_det_mdt = '".$action_time."', con_det_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE con_det_id = '".$current_id."'";
          mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
        }
      }
    }
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  }
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmod/act/det/cat/' . $con_cat_id;
}
else if (isset($_POST['con_opt_add'])) {
  $con_opt_id[0]  = 0;
  $con_det_id     = 0;
  $con_opt_tt[0]  = null;
  $con_opt_ord[0] = null;
  if(isset($_POST['con_det_id'][0]))  {$con_det_id     = rudweb_filter_input($_POST['con_det_id'][0]);}
  if(isset($_POST['con_opt_tt'][0]))  {$con_opt_tt[0]  = rudweb_filter_input($_POST['con_opt_tt'][0]);}
  if(isset($_POST['con_opt_ord'][0])) {$con_opt_ord[0] = rudweb_filter_input($_POST['con_opt_ord'][0]);}
  
  if($con_opt_tt[0] != '') {
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."con_opt WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $con_opt_id[0] = getNextId('con_opt', 'con_opt_id');
    $q = "INSERT INTO "._RUDWEB_PRE."con_opt (con_opt_id, con_det_id, con_opt_tt, con_opt_ord, con_opt_crd, con_opt_crt, con_opt_cru, con_opt_mdd, con_opt_mdt, con_opt_mdu) VALUES ('".$con_opt_id[0]."', '".$con_det_id."', '".$con_opt_tt[0]."', '".$con_opt_ord[0]."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '0000-00-00', '00:00:00', '0')";
    mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  }
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmod/act/opt/det/' . $con_det_id;
}
else if (isset($_POST['con_opt_mod'])) {
  $con_opt_id = 0;
  if(isset($_POST['con_opt_id'])) {
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."con_opt WRITE, "._RUDWEB_PRE."con_val WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    foreach ($_POST['con_opt_id'] as $current_id => $con_opt_id) {
      $con_det_id               = 0;
      $con_opt_tt[$current_id]  = null;
      $con_opt_ord[$current_id] = null;
   
      if(isset($_POST['con_det_id'][$current_id]))  {$con_det_id               = rudweb_filter_input($_POST['con_det_id'][$current_id]);}
      if(isset($_POST['con_opt_tt'][$current_id]))  {$con_opt_tt[$current_id]  = rudweb_filter_input($_POST['con_opt_tt'][$current_id]);}
      if(isset($_POST['con_opt_ord'][$current_id])) {$con_opt_ord[$current_id] = rudweb_filter_input($_POST['con_opt_ord'][$current_id]);}
      
      if($con_opt_tt[$current_id] != '') {
        if (isset($_POST['con_opt_del'][$current_id])) {
          $ve = 0;
          $qv = "SELECT con_val_id FROM ". _RUDWEB_PRE. "con_val WHERE con_opt_id = '".$current_id."'";
          $rv = rudweb_qres($rudweb_dbtype, $qv);
          $tv = rudweb_qtotal($rudweb_dbtype, $rv);
          if($tv != 0) {$ve = 1;}
          if($ve == 0) {
            $q = "DELETE FROM "._RUDWEB_PRE."con_opt WHERE con_opt_id = '".$current_id."'";
            mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
            $q = "OPTIMIZE TABLE "._RUDWEB_PRE."con_opt";
            mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
          }
        }
        else{
          $q = "UPDATE "._RUDWEB_PRE."con_opt SET con_opt_tt = '".$con_opt_tt[$current_id]."', con_opt_ord = '".$con_opt_ord[$current_id]."', con_opt_mdd = '".$action_date."', con_opt_mdt = '".$action_time."', con_opt_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE con_opt_id = '".$current_id."'";
          mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
        }
      }
    }
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  }
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmod/act/opt/det/' . $con_det_id;
}
else if (isset($_POST['con_msg_solve'])) {
  $con_id = 0;
  if(isset($_POST['con_id']) && isValidInt($_POST['con_id'])) {
    $con_id = rudweb_filter_input($_POST['con_id']);
    
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."con_con WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    
    $q = "UPDATE "._RUDWEB_PRE."con_con SET con_sd = '".$action_date."', con_st = '".$action_time."', con_su = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE con_id = '".$con_id."';";
    mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
    
    $q2 = "OPTIMIZE TABLE "._RUDWEB_PRE."con_con";
    mysql_query($q2) or require _RUDWEB_LIB_DIR . 'myerr.php';
        
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  }
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmod/view/msg/con/' . $con_id;
}
else if (isset($_POST['con_msg_del'])) {
  $con_id = 0;
  $con_cat_id = 0;
  if (isset($_POST['con_id']) && isset($_POST['con_cat_id'])) {
    if (isValidInt($_POST['con_id']) && (isValidInt($_POST['con_cat_id']) || $_POST['con_cat_id'] == 0)) {
      $con_id = rudweb_filter_input($_POST['con_id']);
      $con_cat_id = rudweb_filter_input($_POST['con_cat_id']);
      
      $query_lock = "LOCK TABLES "._RUDWEB_PRE."con_con WRITE, "._RUDWEB_PRE."con_val WRITE";
      mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
      
      $q = "DELETE FROM "._RUDWEB_PRE."con_con WHERE con_id = '".$con_id."';";
      mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
      
      $q1 = "DELETE FROM "._RUDWEB_PRE."con_val WHERE con_id = '".$con_id."';";
      mysql_query($q1) or require _RUDWEB_LIB_DIR . 'myerr.php';
    
      $q2 = "OPTIMIZE TABLE "._RUDWEB_PRE."con_con";
      mysql_query($q2) or require _RUDWEB_LIB_DIR . 'myerr.php';
      
      $q3 = "OPTIMIZE TABLE "._RUDWEB_PRE."con_val";
      mysql_query($q3) or require _RUDWEB_LIB_DIR . 'myerr.php';
        
      $query_unlock = "UNLOCK TABLES";
      mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    }
  }
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmod/view/msgs/cat/' . $con_cat_id;
}
?>