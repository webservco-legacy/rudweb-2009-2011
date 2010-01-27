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
./inc/adm/itemadd.inc.php
16:13 2008-06-20
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}
if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 3) {

  echo $rudweb_skin['cnt']['tt1']['pre'];
  echo $rudweb_ln['catalog']['catalog'] . ' - ' . $rudweb_ln['catalog']['itemstt'] . ' : ' .  $rudweb_ln['adm']['add'];
  echo $rudweb_skin['cnt']['tt1']['suf'];
  
  echo $rudweb_skin['cnt']['txt']['pre'];
  
  if(isset($_GET['cat'])) {
    $cat_id = rudweb_filter_input($_GET['cat']);
    $qd = "SELECT det_id, det_typ, det_tt, det_req FROM ". _RUDWEB_PRE. "cat_det WHERE cat_id = '".$cat_id."' AND det_lvl <= '".$_SESSION[_RUDWEB_PRE.'usr_level']."' ORDER BY det_ord ASC";
    $rd = rudweb_qres($rudweb_dbtype, $qd);
    $td = rudweb_qtotal($rudweb_dbtype, $rd);
  
    if($td != '0') {
      for($i=1;$i<=$td;$i++) {
        $rowd     = rudweb_fetch_assoc($rudweb_dbtype, $rd); 
        $di[$i]   = $rowd['det_id'];
        $dtyp[$i] = $rowd['det_typ'];
        $dtt[$i]  = $rowd['det_tt'];
        $dr[$i]   = $rowd['det_req'];
        $sorta[]  = "det".$i;
      }
      $dt = count($di);
    }
    else {$dt = 0;}
    
    // init
    $prd_id = 0;
    $prd_tt  = '';
    $prd_iid = '';
    $prd_dsc = '';
    for($ii=1;$ii<=$dt;$ii++) {
      $diiid = $di[$ii];
      $val_id[$diiid] = NULL;
      if($dtyp[$ii] == '0') {$val_tt[$diiid] = '';}
      else {$opt_id[$diiid] = '0';}
    }
    $prd_qty = '1';
    $prd_qlvl = '3';
    $prd_prc = '0.00';
    $prd_plvl = '0';
    $mpic_id = NULL;
    $mpic_fn = NULL;
    if(isset($_POST['itemadd'])) {
      if(isset($_POST['prd_tt']))  {$prd_tt = rudweb_filter_input($_POST['prd_tt']);}
      if(isset($_POST['prd_iid'])) {$prd_iid = rudweb_filter_input($_POST['prd_iid']);}
      if(isset($_POST['prd_dsc'])) {$prd_dsc = rudweb_filter_input($_POST['prd_dsc']);}
      for($ij=1;$ij<=$dt;$ij++) {
        $dtjid = $di[$ij];
        if($dtyp[$ij] == '0') {
          if(isset($_POST['val_tt'][$dtjid])) {$val_tt[$dtjid] = $_POST['val_tt'][$dtjid];}
        }
        else {
          if(isset($_POST['opt_id'][$dtjid])) {$opt_id[$dtjid] = $_POST['opt_id'][$dtjid];}
        }
      }
      if(isset($_POST['prd_qty']))  {$prd_qty = rudweb_filter_input($_POST['prd_qty']);}
      if(isset($_POST['prd_qlvl'])) {$prd_qlvl = rudweb_filter_input($_POST['prd_qlvl']);}
      if(isset($_POST['prd_prc']))  {$prd_prc = rudweb_filter_input($_POST['prd_prc']);}
      if(isset($_POST['prd_plvl'])) {$prd_plvl = rudweb_filter_input($_POST['prd_plvl']);}
      
      $err = 0;
      // validate
      if($prd_tt == '') {$err = 1;}
      
      for($ik=1;$ik<=$dt;$ik++) {
        $dtid = $di[$ik];
        if($dtyp[$ik] == '0' && ($dr[$ik] == '1' && $val_tt[$dtid] == '')) {$err = 3;}
        else if (isset($_POST['opt_id'][$dtid]) && $opt_id[$dtid] == '0') {$err = 2;}
      }
      if($prd_id != 0) {$err = 1;}
      if ($err == 0) {
        $qlk = "LOCK TABLES "._RUDWEB_PRE."cat_prd WRITE, "._RUDWEB_PRE."cat_val WRITE, "._RUDWEB_PRE."cat_pic WRITE";
        mysql_query($qlk) or require _RUDWEB_LIB_DIR . 'myerr.php';

        $qn1 = "SELECT MAX(prd_id) FROM "._RUDWEB_PRE."cat_prd";
        $rn1 = rudweb_qres($rudweb_dbtype, $qn1);
        $prd_id = rudweb_result($rudweb_dbtype, $rn1, 0) + 1;
        $prd_crd  = date("Y-m-d");
        $prd_crt  = date("H:i:s");
        // main product details
        $aq1 = "INSERT INTO "._RUDWEB_PRE."cat_prd (prd_id, prd_ln, cat_id, prd_iid, prd_tt, prd_dsc, prd_qty, prd_qlvl, prd_prc, prd_plvl, prd_crd, prd_crt, prd_cru, prd_mdd, prd_mdt, prd_mdu) VALUES ('".$prd_id."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$cat_id."', '".$prd_iid."', '".$prd_tt."', '".$prd_dsc."', '".$prd_qty."', '".$prd_qlvl."', '".$prd_prc."', '".$prd_plvl."', '".$prd_crd."', '".$prd_crt."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '', '', '')";
        mysql_query($aq1) or require _RUDWEB_LIB_DIR . 'myerr.php';
        // all other details
        for($il=1;$il<=$dt;$il++) {
          $dlid = $di[$il];
          $qnv         = "SELECT MAX(val_id) FROM "._RUDWEB_PRE."cat_val";
          $rnv         = rudweb_qres($rudweb_dbtype, $qnv);
          $nval_id[$il] = rudweb_result($rudweb_dbtype, $rnv, 0) + 1;
          if($dtyp[$il] == '0') {
            if (isset($_POST['val_tt'][$dlid])) {
              $q = "INSERT INTO "._RUDWEB_PRE."cat_val (val_id, det_id, prd_id, opt_id, val_tt, val_crd, val_crt, val_cru, val_mdd, val_mdt, val_mdu) VALUES ('".$nval_id[$il]."', '".$dlid."', '".$prd_id."', '0', '".$val_tt[$dlid]."', '".$prd_crd."', '".$prd_crt."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '', '', '')";
              mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
            }
          }
          else {
            if (isset($_POST['opt_id'][$dlid])) {
              $q = "INSERT INTO "._RUDWEB_PRE."cat_val (val_id, det_id, prd_id, opt_id, val_tt, val_crd, val_crt, val_cru, val_mdd, val_mdt, val_mdu) VALUES ('".$nval_id[$il]."', '".$dlid."', '".$prd_id."', '".$opt_id[$dlid]."', '', '".$prd_crd."', '".$prd_crt."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '', '', '')";
              mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
            }
          }
        }
        //pictures
        if(isset($_FILES['itempic'])) {
          $allowed_file_types = array("image/jpeg", "image/pjpeg", "image/png", "image/x-png", "image/gif");
          foreach ($_FILES['itempic']['error'] as $pic_loc => $error) {
            $file_name[$pic_loc]  = $_FILES['itempic']['name'][$pic_loc];
            $file_type[$pic_loc]  = $_FILES['itempic']['type'][$pic_loc];
            $file_temp[$pic_loc]  = $_FILES['itempic']['tmp_name'][$pic_loc];
            $file_error[$pic_loc] = $_FILES['itempic']['error'][$pic_loc];
            $file_size[$pic_loc]  = $_FILES['itempic']['size'][$pic_loc];
          
            if ($file_error[$pic_loc] == '0' && !in_array($file_type[$pic_loc], $allowed_file_types)) {/* NOT A PICTURE */$err = '1';}
            else if ($file_error[$pic_loc] == '4') {/* NO FILE UPLOADED */ $err = '1';}
            else if ($file_error[$pic_loc] == '3') {/* PARTIAL UPLOAD */ $err = '1';}
            else if ($file_error[$pic_loc] == '0' && !is_uploaded_file($file_temp[$pic_loc])) {/*NOT SENT BY FORM*/ $err = '1';}
            else if ($file_error[$pic_loc] == '0') {/* OK */ $err = '0';}
          
            if ($err == '0') {
              $upload_dir[$pic_loc] = _RUDWEB_PRDP_DIR;
              $new_file_name[$pic_loc] = "prd_" . $_SESSION[_RUDWEB_PRE.'usr_id'] . "_" . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . "_" . time() . "_" . basename($file_name[$pic_loc]);
              $upload_path[$pic_loc] = $upload_dir[$pic_loc] . $new_file_name[$pic_loc];
              if($file_error[$pic_loc] == '0') {
                if (move_uploaded_file($file_temp[$pic_loc], $upload_path[$pic_loc])) {
                  $qni = "SELECT MAX(pic_id) FROM "._RUDWEB_PRE."cat_pic";
                  $rni = rudweb_qres($rudweb_dbtype, $qni);
                  $new_pic_id = rudweb_result($rudweb_dbtype, $rni, 0) + 1;
                
                  $qno = "SELECT MAX(pic_ord) FROM "._RUDWEB_PRE."cat_pic WHERE prd_id = '".$prd_id."' AND pic_loc = '".$pic_loc."'";
                  $rno = rudweb_qres($rudweb_dbtype, $qno);
                  $new_pic_ord = rudweb_result($rudweb_dbtype, $rno, 0) + 1;
                
                  $qp = "INSERT INTO "._RUDWEB_PRE."cat_pic (pic_id, prd_id, pic_fn, pic_loc, pic_ord, pic_crd, pic_crt, pic_cru, pic_mdd, pic_mdt, pic_mdu, pic_lvl) VALUES ('".$new_pic_id."', '".$prd_id."', '".$new_file_name[$pic_loc]."', '".$pic_loc."', '".$new_pic_ord."', '".$prd_crd."', '".$prd_crt."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '', '', '', '0')";
                  mysql_query($qp) or require _RUDWEB_LIB_DIR . 'myerr.php';
                }
              }
            }
          }
        }
        $quk = "UNLOCK TABLES";
        mysql_query($quk) or require _RUDWEB_LIB_DIR . 'myerr.php';
        
        echo '<DIV CLASS="ok" STYLE="padding-top: 10px; padding-bottom: 10px;">';
        echo $rudweb_ln['adm']['itemaddok'];
        echo '</DIV>';
        echo '<DIV CLASS="ok" STYLE="padding-top: 10px; padding-bottom: 10px;">';
        restrictedLocalLink('default', $rudweb_ln['adm']['itemmod'], _RUDWEB_INDEX_PHP . 'catalog/item/id/'.$prd_id, $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo '</DIV>';
        echo '<DIV CLASS="ok" STYLE="padding-top: 10px; padding-bottom: 10px;">';
        restrictedLocalLink('default', $rudweb_ln['adm']['itemaddnew'], _RUDWEB_INDEX_PHP . 'admin/itemadd/cat/'.$cat_id, $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo '</DIV>';
        echo '<DIV CLASS="ok" STYLE="padding-top: 10px; padding-bottom: 10px;">';
        restrictedLocalLink('default', $rudweb_ln['adm']['itemviewcat'], _RUDWEB_INDEX_PHP . 'catalog/items/cat/'.$cat_id, $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo '</DIV>';
      }
      else {
        // error mesage
        echo '<DIV CLASS="err" STYLE="padding-top: 10px; padding-bottom: 10px;">';
        echo $rudweb_ln['err']['tt'];
        echo '&#160;';
        echo $rudweb_ln['err']['itemadd'][$err];
        echo '</DIV>';
        //require _RUDWEB_ADMIN_DIR . 'itemaddform.inc.php';
        require _RUDWEB_ADMIN_DIR . 'itemform.inc.php';
      }
    }
    else {
      //require _RUDWEB_ADMIN_DIR . 'itemaddform.inc.php';
      require _RUDWEB_ADMIN_DIR . 'itemform.inc.php';
    }
  }
  else {
    // queries to get all categories (id, tt, lev, par)
    // show all categories
    catalogCategoriesMenu('itemadd');
  }
  echo $rudweb_skin['cnt']['txt']['suf'];
} // if user has the rights
else {
  echo "<DIV CLASS=\"err\">" . $rudweb_ln['err']['1'] . "</DIV>";
} // else if user has no rights
?>