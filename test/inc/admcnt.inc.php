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
./inc/admcnt.inc.php
16:24 2008-07-01
*/
if(isset($_POST['cntdelcnt'])) { // delete selected content
  // verify
  $query = "SELECT mnu_id FROM "._RUDWEB_PRE."ws_mnu WHERE mnu_par = '".$mnu_id."' LIMIT 1";
  $rst_query = mysql_query($query) or require _RUDWEB_LIB_DIR . 'myerr.php';
  
  if (mysql_num_rows($rst_query) == '0') { // do the delete
    // lock
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."ws_mnu WRITE, "._RUDWEB_PRE."ws_cnt WRITE, "._RUDWEB_PRE."ws_pic WRITE, "._RUDWEB_PRE."ws_tags WRITE, "._RUDWEB_PRE."ws_rel WRITE, "._RUDWEB_PRE."ws_cmt WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    //comments
    $qcm = "DELETE FROM "._RUDWEB_PRE."ws_cmt WHERE cmt_typ = '0' AND cnt_id = '".$cnt_id."'";
    mysql_query($qcm) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // pictures
    $query_pic = "SELECT * FROM "._RUDWEB_PRE."ws_pic WHERE cnt_id = '".$cnt_id."' AND pic_loc != '0'";
    $rst_query_pic = mysql_query($query_pic) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $total_pic = mysql_num_rows($rst_query_pic);
    if ($total_pic != '0') {
      for ($pici=1; $pici<=$total_pic; $pici++) {
        $row_rst_pic = mysql_fetch_assoc($rst_query_pic);
        $filepath = _RUDWEB_PIC_DIR . $row_rst_pic['pic_fn'];
        if (is_file($filepath)) {unlink($filepath);}
        $picquery = "DELETE FROM "._RUDWEB_PRE."ws_pic WHERE pic_id = '".$row_rst_pic['pic_id']."' LIMIT 1";
        mysql_query($picquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
      }
    }
    // tags
    $tagquery = "DELETE FROM "._RUDWEB_PRE."ws_rel WHERE cnt_id = '".$cnt_id."'";
    mysql_query($tagquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // menu
    $menuquery = "DELETE FROM "._RUDWEB_PRE."ws_mnu WHERE mnu_id = '".$mnu_id."' LIMIT 1";
    mysql_query($menuquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // content
    $cntquery = "DELETE FROM "._RUDWEB_PRE."ws_cnt WHERE cnt_id = '".$cnt_id."' LIMIT 1";
    mysql_query($cntquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // unlock
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // redirect
    $redirect = _RUDWEB_SITE_URL;
  }
  else { // don't delete
    // redirect
    $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'content/' . rudweb_filter_input($_POST['cnt_alias']);
  }
}
else if(isset($_POST['cntmodcnt'])) { // modify selected content
  // verify
  $query = "SELECT cnt_id FROM "._RUDWEB_PRE."ws_cnt WHERE cnt_alias = '".$cnt_alias."' AND (cnt_id != '".$cnt_id."' AND cnt_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."') LIMIT 1";
  $rst_query = mysql_query($query) or require _RUDWEB_LIB_DIR . 'myerr.php';
  
  if (mysql_num_rows($rst_query) == '0') { // do the mods
    // lock
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."ws_mnu WRITE, "._RUDWEB_PRE."ws_cnt WRITE, "._RUDWEB_PRE."ws_pic WRITE, "._RUDWEB_PRE."ws_tags WRITE, "._RUDWEB_PRE."ws_rel WRITE, ". _RUDWEB_PRE. "ws_rel AS r WRITE, ". _RUDWEB_PRE. "ws_tags AS t WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // menu
    $modquery = "UPDATE "._RUDWEB_PRE."ws_mnu SET mnu_tt = '".$mnu_tt."', mnu_cnt_alias = '".$cnt_id . "_" .$cnt_alias."', mnu_trg = '".$mnu_trg."', mnu_mdd = '".$action_date."', mnu_mdt = '".$action_time."', mnu_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE mnu_id = '".$mnu_id."' LIMIT 1";
    mysql_query($modquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // content
    $modquery2 = "UPDATE "._RUDWEB_PRE."ws_cnt SET cnt_alias = '".$cnt_id . "_" . $cnt_alias."', cnt_tt = '".$cnt_tt."', cnt_stt = '".$cnt_stt."', cnt_txt = '".$cnt_txt."', cnt_mdd = '".$action_date."', cnt_mdt = '".$action_time."', cnt_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE cnt_id = '".$cnt_id."' LIMIT 1";
    mysql_query($modquery2) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // tags
    $tags = eregi_replace(', ', ',', $cnt_tags);
    $tags = explode(',', $tags);
    $q_et = "SELECT DISTINCT tag_name AS tag FROM ". _RUDWEB_PRE. "ws_rel AS r LEFT JOIN ". _RUDWEB_PRE. "ws_tags AS t ON (r.tag_id = t.tag_id) WHERE r.cnt_id = '".$cnt_id."' ORDER BY t.tag_name ASC";
    $rs_et = rudweb_qres($rudweb_dbtype, $q_et);
    $t_et  = rudweb_qtotal($rudweb_dbtype, $rs_et);
    if($t_et != 0) {
      for($ei=0;$ei<$t_et;$ei++) {
        $r_et = rudweb_fetch_assoc($rudweb_dbtype, $rs_et);
        $et[$ei] = $r_et['tag'];
      }
    }
    else {$et = array();}
    $dump_tags = array_diff($et, $tags);
    $tdt = count($dump_tags);
    if($tdt != 0) {
      for($di=0;$di<$tdt;$di++) {
        if($dump_tags[$di] != '') {
          $q_dt  = "SELECT tag_id FROM "._RUDWEB_PRE."ws_tags WHERE tag_name = '".$dump_tags[$di]."'";
          $rs_dt = rudweb_qres($rudweb_dbtype, $q_dt);
          $dt_id  = rudweb_result($rudweb_dbtype, $rs_dt, 0);
          $q_delt  = "DELETE FROM "._RUDWEB_PRE."ws_rel WHERE cnt_id = '".$cnt_id."' AND tag_id = '".$dt_id."'";
          mysql_query($q_delt) or require _RUDWEB_LIB_DIR . 'myerr.php';
        }
      }
    }
    for($ti=0;$ti<count($tags);$ti++) {
      if($tags[$ti] != '') {
        $q_vt  = "SELECT tag_id FROM "._RUDWEB_PRE."ws_tags WHERE tag_name = '".$tags[$ti]."' LIMIT 1";
        $rs_vt = rudweb_qres($rudweb_dbtype, $q_vt);
        $t_vt  = rudweb_qtotal($rudweb_dbtype, $rs_vt);
        if($t_vt != 0) {$t_id = rudweb_result($rudweb_dbtype, $rs_vt, 0);}
        else {
          $q_nt  = "SELECT MAX(tag_id) FROM "._RUDWEB_PRE."ws_tags";
          $rs_nt = rudweb_qres($rudweb_dbtype, $q_nt);
          $t_id  = rudweb_result($rudweb_dbtype, $rs_nt, 0) + 1;
          $q_it  = "INSERT INTO "._RUDWEB_PRE."ws_tags (tag_id, tag_name) VALUES ('".$t_id."', '".$tags[$ti]."')";
          mysql_query($q_it) or require _RUDWEB_LIB_DIR . 'myerr.php';
        }
        $q_vr = "SELECT rel_id FROM "._RUDWEB_PRE."ws_rel WHERE cnt_id = '".$cnt_id."' AND tag_id = '".$t_id."' LIMIT 1";
        $rs_vr = rudweb_qres($rudweb_dbtype, $q_vr);
        $t_vr  = rudweb_qtotal($rudweb_dbtype, $rs_vr);
        if ($t_vr == 0) {
          $q_nr  = "SELECT MAX(rel_id) FROM "._RUDWEB_PRE."ws_rel";
          $rs_nr = rudweb_qres($rudweb_dbtype, $q_nr);
          $r_id  = rudweb_result($rudweb_dbtype, $rs_nr, 0) + 1;
          $q_ir  = "INSERT INTO "._RUDWEB_PRE."ws_rel (rel_id, cnt_id, tag_id) VALUES ('".$r_id."', '".$cnt_id."', '".$t_id."')";
          mysql_query($q_ir) or require _RUDWEB_LIB_DIR . 'myerr.php';
        }
      }
    }
    // delete pictures
    if (isset($_POST['delpic'])) { // delete pics
      foreach ($_POST['delpic'] as $pic_id => $dump) {
        $query_fn = "SELECT pic_fn FROM "._RUDWEB_PRE."ws_pic WHERE pic_id = '".$pic_id."'";
        $rst_fn=mysql_query($query_fn) or die('Oups!<br>' . mysql_error());
        $del_pic_fn = (mysql_result($rst_fn, 0));
        $filepath = _RUDWEB_PIC_DIR . $del_pic_fn;
        if (is_file($filepath)) {unlink($filepath);}
        $picquery = "DELETE FROM "._RUDWEB_PRE."ws_pic WHERE pic_id = '".$pic_id."' LIMIT 1";
        mysql_query($picquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
      }
    }
    // modify pictures
    else { // mod pics
      if(isset($_FILES['pcscnt'])) {
        foreach ($_FILES['pcscnt']['error'] as $pic_id => $error) {
          $file_name[$pic_id]  = $_FILES['pcscnt']['name'][$pic_id];
          $file_type[$pic_id]  = $_FILES['pcscnt']['type'][$pic_id];
          $file_temp[$pic_id]  = $_FILES['pcscnt']['tmp_name'][$pic_id];
          $file_error[$pic_id] = $_FILES['pcscnt']['error'][$pic_id];
          $file_size[$pic_id]  = $_FILES['pcscnt']['size'][$pic_id];
          if ($file_error[$pic_id] == '0' && !in_array($file_type[$pic_id], $allowed_file_types)) {/* NOT A PICTURE */$err = '1';}
          else if ($file_error[$pic_id] == '4') {/* NO FILE UPLOADED */ $err = '1';}
          else if ($file_error[$pic_id] == '3') {/* PARTIAL UPLOAD */ $err = '1';}
          else if ($file_error[$pic_id] == '0' && !is_uploaded_file($file_temp[$pic_id])) {/*NOT SENT BY FORM*/ $err = '1';}
          else if ($file_error[$pic_id] == '0') {/* OK */ $err = '0';}
          if ($err == '0') {
            $upload_dir[$pic_id] = _RUDWEB_PIC_DIR;
            $new_file_name[$pic_id] = "cnt_" . $_SESSION[_RUDWEB_PRE.'usr_id'] . "_" . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . "_" . time() . "_" . basename($file_name[$pic_id]);
            $upload_path[$pic_id] = $upload_dir[$pic_id] . $new_file_name[$pic_id];
            if($file_error[$pic_id] == '0') {
              if (move_uploaded_file($file_temp[$pic_id], $upload_path[$pic_id])) {
                $query_fn = "SELECT pic_fn FROM "._RUDWEB_PRE."ws_pic WHERE pic_id = '".$pic_id."'";
                $rst_fn=mysql_query($query_fn) or die('Oups!<br>' . mysql_error());
                $del_pic_fn = (mysql_result($rst_fn, 0));
                $filepath = _RUDWEB_PIC_DIR . $del_pic_fn;
                if (is_file($filepath)) {unlink($filepath);}
                //$picquery = "UPDATE "._RUDWEB_PRE."ws_pic SET pic_tt = '".basename($file_name[$pic_id])."', pic_fn = '".$new_file_name[$pic_id]."', pic_mdd = '".$action_date."', pic_mdt = '".$action_time."', pic_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE pic_id = '".$pic_id."' LIMIT 1";
                if (isset($_POST['pcscnttmb'][$pic_id])) {
                  $picquery = "UPDATE "._RUDWEB_PRE."ws_pic SET pic_tt = '".basename($file_name[$pic_id])."', pic_fn = '".$new_file_name[$pic_id]."', pic_tmb = '1', pic_mdd = '".$action_date."', pic_mdt = '".$action_time."', pic_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE pic_id = '".$pic_id."' LIMIT 1";
                }
                else {
                  $picquery = "UPDATE "._RUDWEB_PRE."ws_pic SET pic_tt = '".basename($file_name[$pic_id])."', pic_fn = '".$new_file_name[$pic_id]."', pic_tmb = '0', pic_mdd = '".$action_date."', pic_mdt = '".$action_time."', pic_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE pic_id = '".$pic_id."' LIMIT 1";
                }
                
                mysql_query($picquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
              }
            }
          }
        }
      }
    }
    // add pictures
    if(isset($_FILES['pcscntnew'])) {
      foreach ($_FILES['pcscntnew']['error'] as $pic_loc => $error) {
        $file_name[$pic_loc]  = $_FILES['pcscntnew']['name'][$pic_loc];
        $file_type[$pic_loc]  = $_FILES['pcscntnew']['type'][$pic_loc];
        $file_temp[$pic_loc]  = $_FILES['pcscntnew']['tmp_name'][$pic_loc];
        $file_error[$pic_loc] = $_FILES['pcscntnew']['error'][$pic_loc];
        $file_size[$pic_loc]  = $_FILES['pcscntnew']['size'][$pic_loc];
        if ($file_error[$pic_loc] == '0' && !in_array($file_type[$pic_loc], $allowed_file_types)) {/* NOT A PICTURE */$err = '1';}
        else if ($file_error[$pic_loc] == '4') {/* NO FILE UPLOADED */ $err = '1';}
        else if ($file_error[$pic_loc] == '3') {/* PARTIAL UPLOAD */ $err = '1';}
        else if ($file_error[$pic_loc] == '0' && !is_uploaded_file($file_temp[$pic_loc])) {/*NOT SENT BY FORM*/ $err = '1';}
        else if ($file_error[$pic_loc] == '0') {/* OK */ $err = '0';}
        if ($err == '0') {
          $upload_dir[$pic_loc] = _RUDWEB_PIC_DIR;
          $new_file_name[$pic_loc] = "cnt_" . $_SESSION[_RUDWEB_PRE.'usr_id'] . "_" . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . "_" . time() . "_" . basename($file_name[$pic_loc]);
          $upload_path[$pic_loc] = $upload_dir[$pic_loc] . $new_file_name[$pic_loc];
          if($file_error[$pic_loc] == '0') {
            if (move_uploaded_file($file_temp[$pic_loc], $upload_path[$pic_loc])) {
              $query_NextId = "SELECT MAX(pic_id) FROM "._RUDWEB_PRE."ws_pic";
              $rstNextId=mysql_query($query_NextId) or die('Oups!<br>' . mysql_error());
              $new_pic_id = (mysql_result($rstNextId, 0)) + 1;
              $query_NextOrd = "SELECT MAX(pic_ord) FROM "._RUDWEB_PRE."ws_pic WHERE cnt_id = '".$cnt_id."' AND pic_loc = '".$pic_loc."'";
              $rstNextOrd=mysql_query($query_NextOrd) or die('Oups!<br>' . mysql_error());
              $new_pic_ord = (mysql_result($rstNextOrd, 0)) + 1;
              $pic_tmb = '0';
              if (isset($_POST['pcscnttmb'][$pic_loc])) {$pic_tmb = '1';}
              $picquery = "INSERT INTO "._RUDWEB_PRE."ws_pic (pic_id, cnt_id, pic_ln, pic_tt, pic_fn, pic_loc, pic_ord, pic_tmb, pic_crd, pic_crt, pic_cru) VALUES ('".$new_pic_id."', '".$cnt_id."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".basename($file_name[$pic_loc])."', '".$new_file_name[$pic_loc]."', '".$pic_loc."', '".$new_pic_ord."', '".$pic_tmb."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."');";
              mysql_query($picquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
            }
          }
        }
      }
    }
    // unlock
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // redirect
    $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'content/' . $cnt_id  . "_" . $cnt_alias;
  }
  else { // don't do the mod
    // redirect
    $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'content/' . rudweb_filter_input($_POST['cnt_alias']);
  }
}
else if(isset($_POST['cntaddcnt']) || (isset($_POST['cntaddlnk']) || isset($_POST['cntaddpg']))) { // add new content
  $total_results = "1";
  if(isset($_POST['cntaddcnt']))      {
    $mnu_typ = "1";
    // sa nu existe deja un continut cu acelasi alias
    $query = "SELECT cnt_id FROM "._RUDWEB_PRE."ws_cnt WHERE cnt_alias = '".$cnt_alias."' AND cnt_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' LIMIT 1";
    $rst_query = mysql_query($query) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $total_results = mysql_num_rows($rst_query);
  }
  else if(isset($_POST['cntaddlnk'])) {
    $mnu_typ = "2";
    // sa  nu existe deja un link cu acelasi alias
    $query = "SELECT lnk_id FROM "._RUDWEB_PRE."ws_lnk WHERE lnk_alias = '".$lnk_alias."' AND lnk_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' LIMIT 1";
    $rst_query = mysql_query($query) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $total_results = mysql_num_rows($rst_query);
  }
  else if(isset($_POST['cntaddpg']))  {
    $mnu_typ = "3";
    $total_results = "0";
  }
  if ($total_results == '0') { // do the add
    // lock
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."ws_mnu WRITE, "._RUDWEB_PRE."ws_cnt WRITE, "._RUDWEB_PRE."ws_pic WRITE, "._RUDWEB_PRE."ws_lnk WRITE, "._RUDWEB_PRE."ws_tags WRITE, "._RUDWEB_PRE."ws_rel WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // mnu_id query
    $query_NextId = "SELECT MAX(mnu_id) FROM "._RUDWEB_PRE."ws_mnu";
    $rstNextId=mysql_query($query_NextId) or die('Oups!<br>' . mysql_error());
    $new_mnu_id = (mysql_result($rstNextId, 0)) + 1;
    // mnu_ord query
    $query_NextId = "SELECT MAX(mnu_ord) FROM "._RUDWEB_PRE."ws_mnu WHERE mnu_lev = '".$mnu_lev."' AND mnu_cat = '".$mnu_cat."'";
    $rstNextId=mysql_query($query_NextId) or die('Oups!<br>' . mysql_error());
    $new_mnu_ord = (mysql_result($rstNextId, 0)) + 1;
    
    // cnt_id query
    $query_NextcntId = "SELECT MAX(cnt_id) FROM "._RUDWEB_PRE."ws_cnt";
    $rstNextcntId=mysql_query($query_NextcntId) or die('Oups!<br>' . mysql_error());
    $new_cnt_id = (mysql_result($rstNextcntId, 0)) + 1;
    
    // lnk_id query
    $query_NextlnkId = "SELECT MAX(lnk_id) FROM "._RUDWEB_PRE."ws_lnk";
    $rstNextlnkId=mysql_query($query_NextlnkId) or die('Oups!<br>' . mysql_error());
    $new_lnk_id = (mysql_result($rstNextlnkId, 0)) + 1;

    switch($mnu_typ) {
      case "1": {
        // new menu
        $addquery = "INSERT INTO "._RUDWEB_PRE."ws_mnu (mnu_id, mnu_ln, mnu_cat, mnu_lev, mnu_par, mnu_ord, mnu_tt, mnu_typ, mnu_cnt_alias, mnu_trg, mnu_crd, mnu_crt, mnu_cru, mnu_mdd, mnu_mdt, mnu_mdu, mnu_dis, mnu_lvl) VALUES ('".$new_mnu_id."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$mnu_cat."', '".$mnu_lev."', '".$mnu_par."', '".$new_mnu_ord."', '".$mnu_tt."', '".$mnu_typ."', '".$new_cnt_id . "_" . $mnu_cnt_alias."', '".$mnu_trg."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '0000-00-00', '00:00:00', '0', '0', '0')";
        mysql_query($addquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
        // content
        $addquery2 = "INSERT INTO "._RUDWEB_PRE."ws_cnt (cnt_id, cnt_ln, cnt_alias, cnt_tt, cnt_kw, cnt_dsc, cnt_stt, cnt_txt, cnt_crd, cnt_crt, cnt_cru, cnt_mdd, cnt_mdt, cnt_mdu, cnt_dis, cnt_lvl) VALUES ('".$new_cnt_id."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$new_cnt_id . "_" . $cnt_alias."', '".$cnt_tt."', '".$cnt_kw."', '".$cnt_dsc."', '".$cnt_stt."', '".$cnt_txt."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '0000-00-00', '00:00:00', '0', '0', '0')";
        mysql_query($addquery2) or require _RUDWEB_LIB_DIR . 'myerr.php';
        //add tags
        $tags = eregi_replace(', ', ',', $cnt_tags);
        $tags = explode(',', $tags);
        
        for($ti=0;$ti<count($tags);$ti++) {
          if($tags[$ti] != '') {
            $q_vt  = "SELECT tag_id FROM "._RUDWEB_PRE."ws_tags WHERE tag_name = '".$tags[$ti]."' LIMIT 1";
            $rs_vt = rudweb_qres($rudweb_dbtype, $q_vt);
            $t_vt  = rudweb_qtotal($rudweb_dbtype, $rs_vt);
            if($t_vt != 0) {$t_id = rudweb_result($rudweb_dbtype, $rs_vt, 0);}
            else {
              $q_nt  = "SELECT MAX(tag_id) FROM "._RUDWEB_PRE."ws_tags";
              $rs_nt = rudweb_qres($rudweb_dbtype, $q_nt);
              $t_id  = rudweb_result($rudweb_dbtype, $rs_nt, 0) + 1;
              $q_it  = "INSERT INTO "._RUDWEB_PRE."ws_tags (tag_id, tag_name) VALUES ('".$t_id."', '".$tags[$ti]."')";
              mysql_query($q_it) or require _RUDWEB_LIB_DIR . 'myerr.php';
            }
            $q_vr = "SELECT rel_id FROM "._RUDWEB_PRE."ws_rel WHERE cnt_id = '".$new_cnt_id."' AND tag_id = '".$t_id."' LIMIT 1";
            $rs_vr = rudweb_qres($rudweb_dbtype, $q_vr);
            $t_vr  = rudweb_qtotal($rudweb_dbtype, $rs_vr);
            if ($t_vr == 0) {
              $q_nr  = "SELECT MAX(rel_id) FROM "._RUDWEB_PRE."ws_rel";
              $rs_nr = rudweb_qres($rudweb_dbtype, $q_nr);
              $r_id  = rudweb_result($rudweb_dbtype, $rs_nr, 0) + 1;
              $q_ir  = "INSERT INTO "._RUDWEB_PRE."ws_rel (rel_id, cnt_id, tag_id) VALUES ('".$r_id."', '".$new_cnt_id."', '".$t_id."')";
              mysql_query($q_ir) or require _RUDWEB_LIB_DIR . 'myerr.php';
            }
          }
        }
        // add pictures
        if(isset($_FILES['pcscntnew'])) {
          foreach ($_FILES['pcscntnew']['error'] as $pic_loc => $error) {
            $file_name[$pic_loc]  = $_FILES['pcscntnew']['name'][$pic_loc];
            $file_type[$pic_loc]  = $_FILES['pcscntnew']['type'][$pic_loc];
            $file_temp[$pic_loc]  = $_FILES['pcscntnew']['tmp_name'][$pic_loc];
            $file_error[$pic_loc] = $_FILES['pcscntnew']['error'][$pic_loc];
            $file_size[$pic_loc]  = $_FILES['pcscntnew']['size'][$pic_loc];
            if ($file_error[$pic_loc] == '0' && !in_array($file_type[$pic_loc], $allowed_file_types)) {/* NOT A PICTURE */$err = '1';}
            else if ($file_error[$pic_loc] == '4') {/* NO FILE UPLOADED */ $err = '1';}
            else if ($file_error[$pic_loc] == '3') {/* PARTIAL UPLOAD */ $err = '1';}
            else if ($file_error[$pic_loc] == '0' && !is_uploaded_file($file_temp[$pic_loc])) {/*NOT SENT BY FORM*/ $err = '1';}
            else if ($file_error[$pic_loc] == '0') {/* OK */ $err = '0';}
            if ($err == '0') {
              $upload_dir[$pic_loc] = _RUDWEB_PIC_DIR;
              $new_file_name[$pic_loc] = "cnt_" . $_SESSION[_RUDWEB_PRE.'usr_id'] . "_" . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . "_" . time() . "_" . basename($file_name[$pic_loc]);
              $upload_path[$pic_loc] = $upload_dir[$pic_loc] . $new_file_name[$pic_loc];
              if($file_error[$pic_loc] == '0') {
                if (move_uploaded_file($file_temp[$pic_loc], $upload_path[$pic_loc])) {
                  $query_NextId = "SELECT MAX(pic_id) FROM "._RUDWEB_PRE."ws_pic";
                  $rstNextId=mysql_query($query_NextId) or die('Oups!<br>' . mysql_error());
                  $new_pic_id = (mysql_result($rstNextId, 0)) + 1;
                  $query_NextOrd = "SELECT MAX(pic_ord) FROM "._RUDWEB_PRE."ws_pic WHERE cnt_id = '".$cnt_id."' AND pic_loc = '".$pic_loc."'";
                  $rstNextOrd=mysql_query($query_NextOrd) or die('Oups!<br>' . mysql_error());
                  $new_pic_ord = (mysql_result($rstNextOrd, 0)) + 1;
                  $pic_tmb = '0';
                  if (isset($_POST['pcscnttmb'][$pic_loc])) {$pic_tmb = '1';}
                  $picquery = "INSERT INTO "._RUDWEB_PRE."ws_pic (pic_id, cnt_id, pic_ln, pic_tt, pic_fn, pic_loc, pic_ord, pic_tmb, pic_crd, pic_crt, pic_cru) VALUES ('".$new_pic_id."', '".$new_cnt_id."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".basename($file_name[$pic_loc])."', '".$new_file_name[$pic_loc]."', '".$pic_loc."', '".$new_pic_ord."', '".$pic_tmb."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."');";
                  mysql_query($picquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
                }
              }
            }
          }
        }
        break;
      }
      case "2": {
        // new menu
        $addquery = "INSERT INTO "._RUDWEB_PRE."ws_mnu (mnu_id, mnu_ln, mnu_cat, mnu_lev, mnu_par, mnu_ord, mnu_tt, mnu_typ, mnu_cnt_alias, mnu_trg, mnu_crd, mnu_crt, mnu_cru, mnu_mdd, mnu_mdt, mnu_mdu, mnu_dis, mnu_lvl) VALUES ('".$new_mnu_id."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$mnu_cat."', '".$mnu_lev."', '".$mnu_par."', '".$new_mnu_ord."', '".$mnu_tt."', '".$mnu_typ."', '".$new_cnt_id . "_" . $mnu_cnt_alias."', '".$mnu_trg."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '0000-00-00', '00:00:00', '0', '0', '0')";
        mysql_query($addquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
        // link
        $addquery = "INSERT INTO "._RUDWEB_PRE."ws_lnk (lnk_id, lnk_ln, lnk_alias, lnk_cat, lnk_tt, lnk_url, lnk_trg, lnk_dsc, lnk_crd, lnk_crt, lnk_cru, lnk_mdd, lnk_mdt, lnk_mdu, lnk_dis, lnk_lvl) VALUES ('".$new_lnk_id."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$new_lnk_id . "_" . $lnk_alias."', '".$lnk_cat."', '".$lnk_tt."', '".$lnk_url."', '".$lnk_trg."', '".$lnk_dsc."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '0000-00-00', '00:00:00', '0', '0', '0')";
        mysql_query($addquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
        break;
      }
      case "3": {
        // new menu
        $addquery = "INSERT INTO "._RUDWEB_PRE."ws_mnu (mnu_id, mnu_ln, mnu_cat, mnu_lev, mnu_par, mnu_ord, mnu_tt, mnu_typ, mnu_cnt_alias, mnu_trg, mnu_crd, mnu_crt, mnu_cru, mnu_mdd, mnu_mdt, mnu_mdu, mnu_dis, mnu_lvl) VALUES ('".$new_mnu_id."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$mnu_cat."', '".$mnu_lev."', '".$mnu_par."', '".$new_mnu_ord."', '".$mnu_tt."', '".$mnu_typ."', '".$page_tt."', '".$mnu_trg."', '".$action_date."', '".$action_time."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '0000-00-00', '00:00:00', '0', '0', '0')";
        mysql_query($addquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
        //page
        break;
      }
      default: {die("Oops! This is really bad! Error #admcnt244 "); break;}
    }
    // unlock
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // redirect
    if(isset($_POST['cntaddcnt']))      {$redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'content/' . $new_cnt_id . "_" . $cnt_alias;}
    else if(isset($_POST['cntaddpg']))  {$redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'page/' . $cnt_alias;}
    else if(isset($_POST['cntaddlnk'])) {$redirect = _RUDWEB_SITE_URL;}
    
  }
  else { // don't do the mod
    // redirect
    $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/cntadd/mc/' . $mnu_cat . '/ml/' . $mnu_lev . '/mp/' . $mnu_par;
  }
  // abc
}
?>