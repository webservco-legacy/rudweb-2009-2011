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
./inc/admftr.inc.php
11:09 2008-05-26
*/
if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 5 && $new_onoff !== "") {
  changedbcfg("FTR_ON", $new_onoff, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/ftrmoda';
}
if($ftr_lmt !== "") {
  changedbcfg("FTR_LMT", $ftr_lmt, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/ftrmod';
}
if(isset($_POST['ftr_new'])) { // add new
  $query_NextId = "SELECT MAX(ftr_id) FROM "._RUDWEB_PRE."ws_ftr";
  $rstNextId=mysql_query($query_NextId) or die('Oups!<br>' . mysql_error());
  $id_of_ftr = (mysql_result($rstNextId, 0)) + 1;
  
  $query_ord = "SELECT MAX(ftr_ord) FROM "._RUDWEB_PRE."ws_ftr WHERE ftr_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."'";
  $rst_ord=mysql_query($query_ord) or die('Oups!<br>' . mysql_error());
  $ftr_ord[$id_of_ftr] = (mysql_result($rst_ord, 0)) + 1;
  
  $cnt_id[$id_of_ftr]    = rudweb_filter_input($_POST['cnt_id']);
  $ftr_sup[$id_of_ftr]   = rudweb_filter_input($_POST['ftr_sup']); 
  $ftr_sdate[$id_of_ftr] = rudweb_filter_input($_POST['ftr_sdate']);
  $ftr_edate[$id_of_ftr] = rudweb_filter_input($_POST['ftr_edate']);
  $pic_id[$id_of_ftr] = NULL;
  
  $query_lock = "LOCK TABLES "._RUDWEB_PRE."ws_ftr WRITE, "._RUDWEB_PRE."ws_pic WRITE";
  mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  
  if(isset($_FILES['pcsftrnew'])) { // add pics
    $file_name[$id_of_ftr]  = $_FILES['pcsftrnew']['name'];
    $file_type[$id_of_ftr]  = $_FILES['pcsftrnew']['type'];
    $file_temp[$id_of_ftr]  = $_FILES['pcsftrnew']['tmp_name'];
    $file_error[$id_of_ftr] = $_FILES['pcsftrnew']['error'];
    $file_size[$id_of_ftr]  = $_FILES['pcsftrnew']['size'];
    if ($file_error[$id_of_ftr] == '0' && !in_array($file_type[$id_of_ftr], $allowed_file_types)) {/* NOT A PICTURE */$err = '1';}
    else if ($file_error[$id_of_ftr] == '4') {/* NO FILE UPLOADED */ $err = '1';}
    else if ($file_error[$id_of_ftr] == '3') {/* PARTIAL UPLOAD */ $err = '1';}
    else if ($file_error[$id_of_ftr] == '0' && !is_uploaded_file($file_temp[$id_of_ftr])) {/*NOT SENT BY FORM*/ $err = '1';}
    else if ($file_error[$id_of_ftr] == '0') {/* OK */ $err = '0';}
    if ($err == '0') {
      $upload_dir[$id_of_ftr] = _RUDWEB_PIC_DIR;
      $new_file_name[$id_of_ftr] = "ftr_" . $_SESSION[_RUDWEB_PRE.'usr_id'] . "_" . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . "_" . time() . "_" . basename($file_name[$id_of_ftr]);
      $upload_path[$id_of_ftr] = $upload_dir[$id_of_ftr] . $new_file_name[$id_of_ftr];
      if($file_error[$id_of_ftr] == '0') {
        if (move_uploaded_file($file_temp[$id_of_ftr], $upload_path[$id_of_ftr])) {
          $query_NextId = "SELECT MAX(pic_id) FROM "._RUDWEB_PRE."ws_pic";
          $rstNextId=mysql_query($query_NextId) or die('Oups!<br>' . mysql_error());
          $pic_id[$id_of_ftr] = (mysql_result($rstNextId, 0)) + 1;
          $picquery = "INSERT INTO "._RUDWEB_PRE."ws_pic (pic_id, cnt_id, pic_ln, pic_tt, pic_fn, pic_loc, pic_ord, pic_tmb, pic_crd, pic_crt, pic_cru) VALUES ('".$pic_id[$id_of_ftr]."', '0', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".basename($file_name[$id_of_ftr])."', '".$new_file_name[$id_of_ftr]."', '0', '0', 1, '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."');";
          mysql_query($picquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
        }
      }
    }
  }
  $insertquery = "INSERT INTO "._RUDWEB_PRE."ws_ftr (ftr_id, ftr_ln, cnt_id, pic_id, ftr_sdate, ftr_edate, ftr_sup, ftr_ord, ftr_crd, ftr_crt, ftr_cru, ftr_mdd, ftr_mdt, ftr_mdu, ftr_dis, ftr_lvl) VALUES ('".$id_of_ftr."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$cnt_id[$id_of_ftr]."', '".$pic_id[$id_of_ftr]."', '".$ftr_sdate[$id_of_ftr]."', '".$ftr_edate[$id_of_ftr]."', '".$ftr_sup[$id_of_ftr]."', '".$ftr_ord[$id_of_ftr]."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '0000-00-00', '00:00:00', '0', '0', '0')";
  mysql_query($insertquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
  $query_unlock = "UNLOCK TABLES";
  mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/ftrmod/act/adm';
  
}
else if(isset($_POST['ftr_id'])) { // modify
  foreach ($_POST['ftr_id'] as $id_of_ftr => $dump) {
    $ftr_id[$id_of_ftr]    = rudweb_filter_input($_POST['ftr_id'][$id_of_ftr]);
    $cnt_id[$id_of_ftr]    = rudweb_filter_input($_POST['cnt_id'.$id_of_ftr]);
    $ftr_sup[$id_of_ftr]   = rudweb_filter_input($_POST['ftr_sup'.$id_of_ftr]); 
    $ftr_ord[$id_of_ftr]   = rudweb_filter_input($_POST['ftr_ord'.$id_of_ftr]); 
    $ftr_sdate[$id_of_ftr] = rudweb_filter_input($_POST['ftr_sdate'.$id_of_ftr]);
    $ftr_edate[$id_of_ftr] = rudweb_filter_input($_POST['ftr_edate'.$id_of_ftr]);
    
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."ws_ftr WRITE, "._RUDWEB_PRE."ws_pic WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';

    $query_pic_id = "SELECT pic_id FROM "._RUDWEB_PRE."ws_ftr WHERE ftr_id = '".$id_of_ftr."'";
    $rst_pic_id=mysql_query($query_pic_id) or die('Oups!<br>' . mysql_error());
    $pic_id[$id_of_ftr] = (mysql_result($rst_pic_id, 0));
    
    if (isset($_POST['delftr'.$id_of_ftr])) { // delete featured
      $query_fn = "SELECT pic_fn FROM "._RUDWEB_PRE."ws_pic WHERE pic_id = '".$pic_id[$id_of_ftr]."'";
      $rst_fn=mysql_query($query_fn) or die('Oups!<br>' . mysql_error());
      $del_pic_fn = (mysql_result($rst_fn, 0));
      $filepath = _RUDWEB_PIC_DIR . $del_pic_fn;
      if (is_file($filepath)) {unlink($filepath);}
      $picquery = "DELETE FROM "._RUDWEB_PRE."ws_pic WHERE pic_id = '".$pic_id[$id_of_ftr]."' LIMIT 1";
      mysql_query($picquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
      
      $ftrquery = "DELETE FROM "._RUDWEB_PRE."ws_ftr WHERE ftr_id = '".$ftr_id[$id_of_ftr]."' LIMIT 1";
      mysql_query($ftrquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
    }
    else {
      if (isset($_POST['delpic'.$id_of_ftr])) { // delete pics
        $query_fn = "SELECT pic_fn FROM "._RUDWEB_PRE."ws_pic WHERE pic_id = '".$pic_id[$id_of_ftr]."'";
        $rst_fn=mysql_query($query_fn) or die('Oups!<br>' . mysql_error());
        $del_pic_fn = (mysql_result($rst_fn, 0));
        $filepath = _RUDWEB_PIC_DIR . $del_pic_fn;
        if (is_file($filepath)) {unlink($filepath);}
        $picquery = "DELETE FROM "._RUDWEB_PRE."ws_pic WHERE pic_id = '".$pic_id[$id_of_ftr]."' LIMIT 1";
        mysql_query($picquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $picquery2 = "UPDATE "._RUDWEB_PRE."ws_ftr SET pic_id = '0' WHERE ftr_id = '".$id_of_ftr."' LIMIT 1";
        mysql_query($picquery2) or require _RUDWEB_LIB_DIR . 'myerr.php';
      }
      if (isset($_FILES['pcsftrmod'.$id_of_ftr])) { // modify pics
        $file_name[$id_of_ftr]  = $_FILES['pcsftrmod'.$id_of_ftr]['name'];
        $file_type[$id_of_ftr]  = $_FILES['pcsftrmod'.$id_of_ftr]['type'];
        $file_temp[$id_of_ftr]  = $_FILES['pcsftrmod'.$id_of_ftr]['tmp_name'];
        $file_error[$id_of_ftr] = $_FILES['pcsftrmod'.$id_of_ftr]['error'];
        $file_size[$id_of_ftr]  = $_FILES['pcsftrmod'.$id_of_ftr]['size'];
        if ($file_error[$id_of_ftr] == '0' && !in_array($file_type[$id_of_ftr], $allowed_file_types)) {/* NOT A PICTURE */$err = '1';}
        else if ($file_error[$id_of_ftr] == '4') {/* NO FILE UPLOADED */ $err = '1';}
        else if ($file_error[$id_of_ftr] == '3') {/* PARTIAL UPLOAD */ $err = '1';}
        else if ($file_error[$id_of_ftr] == '0' && !is_uploaded_file($file_temp[$id_of_ftr])) {/*NOT SENT BY FORM*/ $err = '1';}
        else if ($file_error[$id_of_ftr] == '0') {/* OK */ $err = '0';}
        if ($err == '0') {
          $upload_dir[$id_of_ftr] = _RUDWEB_PIC_DIR;
          $new_file_name[$id_of_ftr] = "ftr_" . $_SESSION[_RUDWEB_PRE.'usr_id'] . "_" . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . "_" . time() . "_" . basename($file_name[$id_of_ftr]);
          $upload_path[$id_of_ftr] = $upload_dir[$id_of_ftr] . $new_file_name[$id_of_ftr];
          if($file_error[$id_of_ftr] == '0') {
            if (move_uploaded_file($file_temp[$id_of_ftr], $upload_path[$id_of_ftr])) {
              $query_fn = "SELECT pic_fn FROM "._RUDWEB_PRE."ws_pic WHERE pic_id = '".$pic_id[$id_of_ftr]."'";
              $rst_fn=mysql_query($query_fn) or die('Oups!<br>' . mysql_error());
              $del_pic_fn = (mysql_result($rst_fn, 0));
              $filepath = _RUDWEB_PIC_DIR . $del_pic_fn;
              if (is_file($filepath)) {unlink($filepath);}
              $modquery = "UPDATE "._RUDWEB_PRE."ws_pic SET pic_tt = '".basename($file_name[$id_of_ftr])."', pic_fn = '".$new_file_name[$id_of_ftr]."', pic_mdd = '".$action_date."', pic_mdt = '".$action_time."', pic_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE pic_id = '".$pic_id[$id_of_ftr]."' LIMIT 1";
              mysql_query($modquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
            }
          }
        }
      }
      if (isset($_FILES['pcsftrnew'.$id_of_ftr])) { // add pics
        $file_name[$id_of_ftr]  = $_FILES['pcsftrnew'.$id_of_ftr]['name'];
        $file_type[$id_of_ftr]  = $_FILES['pcsftrnew'.$id_of_ftr]['type'];
        $file_temp[$id_of_ftr]  = $_FILES['pcsftrnew'.$id_of_ftr]['tmp_name'];
        $file_error[$id_of_ftr] = $_FILES['pcsftrnew'.$id_of_ftr]['error'];
        $file_size[$id_of_ftr]  = $_FILES['pcsftrnew'.$id_of_ftr]['size'];
        if ($file_error[$id_of_ftr] == '0' && !in_array($file_type[$id_of_ftr], $allowed_file_types)) {/* NOT A PICTURE */$err = '1';}
        else if ($file_error[$id_of_ftr] == '4') {/* NO FILE UPLOADED */ $err = '1';}
        else if ($file_error[$id_of_ftr] == '3') {/* PARTIAL UPLOAD */ $err = '1';}
        else if ($file_error[$id_of_ftr] == '0' && !is_uploaded_file($file_temp[$id_of_ftr])) {/*NOT SENT BY FORM*/ $err = '1';}
        else if ($file_error[$id_of_ftr] == '0') {/* OK */ $err = '0';}
        if ($err == '0') {
          $upload_dir[$id_of_ftr] = _RUDWEB_PIC_DIR;
          $new_file_name[$id_of_ftr] = "ftr_" . $_SESSION[_RUDWEB_PRE.'usr_id'] . "_" . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . "_" . time() . "_" . basename($file_name[$id_of_ftr]);
          $upload_path[$id_of_ftr] = $upload_dir[$id_of_ftr] . $new_file_name[$id_of_ftr];
          if($file_error[$id_of_ftr] == '0') {
            if (move_uploaded_file($file_temp[$id_of_ftr], $upload_path[$id_of_ftr])) {
              $query_NextId = "SELECT MAX(pic_id) FROM "._RUDWEB_PRE."ws_pic";
              $rstNextId=mysql_query($query_NextId) or die('Oups!<br>' . mysql_error());
              $pic_id[$id_of_ftr] = (mysql_result($rstNextId, 0)) + 1;
              $picquery = "INSERT INTO "._RUDWEB_PRE."ws_pic (pic_id, cnt_id, pic_ln, pic_tt, pic_fn, pic_loc, pic_ord, pic_tmb, pic_crd, pic_crt, pic_cru) VALUES ('".$pic_id[$id_of_ftr]."', '0', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".basename($file_name[$id_of_ftr])."', '".$new_file_name[$id_of_ftr]."', '0', '0', 1, '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."');";
              mysql_query($picquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
            }
          }
        }
      }
      $modquery = "UPDATE "._RUDWEB_PRE."ws_ftr SET cnt_id = '".$cnt_id[$id_of_ftr]."', pic_id = '".$pic_id[$id_of_ftr]."', ftr_sdate = '".$ftr_sdate[$id_of_ftr]."', ftr_edate = '".$ftr_edate[$id_of_ftr]."', ftr_sup = '".$ftr_sup[$id_of_ftr]."', ftr_ord = '".$ftr_ord[$id_of_ftr]."', ftr_mdd = '".$action_date."', ftr_mdt = '".$action_time."', ftr_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE ftr_id = '".$ftr_id[$id_of_ftr]."' LIMIT 1";
      mysql_query($modquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
    }
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/ftrmod/act/adm';
  }
}
?>