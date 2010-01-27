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
./inc/cat/item.inc.php
10:31 2008-06-05
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

if(isset($_GET['id'])) {$item_id = rudweb_filter_content($_GET['id']);}
else {$item_id = '0';}

$qd = "SELECT DISTINCT A.cat_id, B.det_id, B.det_typ, B.det_tt, B.det_req FROM ". _RUDWEB_PRE. "cat_prd AS P left join ". _RUDWEB_PRE. "cat_cat as A on (P.cat_id = A.cat_id) left join ". _RUDWEB_PRE. "cat_det as B on (A.cat_id = B.cat_id) WHERE P.prd_id = '".$item_id."' AND B.det_lvl <= '".$_SESSION[_RUDWEB_PRE.'usr_level']."' ORDER BY det_ord ASC";
$rd = rudweb_qres($rudweb_dbtype, $qd);
$td = rudweb_qtotal($rudweb_dbtype, $rd);

if($td != '0') {
  for($i=1;$i<=$td;$i++) {
    $rowd         = rudweb_fetch_assoc($rudweb_dbtype, $rd); 
    $current_scat = $rowd['cat_id'];
    $di[$i]       = $rowd['det_id'];
    $dtyp[$i]     = $rowd['det_typ'];
    $dtt[$i]      = $rowd['det_tt'];
    $dr[$i]       = $rowd['det_req'];
  }
  $dt = count($di);
}
else {$current_scat = 0; $dt = 0;}

$query_cat  = "SELECT A.cat_tt, D.crt_sm AS currency FROM ". _RUDWEB_PRE. "cat_cat as A left join ". _RUDWEB_PRE. "cat_crv as C on (A.cat_ln = C.crv_ln) left join ". _RUDWEB_PRE. "cat_crt as D on (C.crt_id = D.crt_id) WHERE cat_id = '".$current_scat."' LIMIT 1";
$result_cat = rudweb_qres($rudweb_dbtype, $query_cat);
$total_cat  = rudweb_qtotal($rudweb_dbtype, $result_cat);

echo $rudweb_skin['catalog']['hdr'];

if($total_cat == '1') {
  $cat_row = rudweb_fetch_assoc($rudweb_dbtype, $result_cat);
  $current_cat_tt = $cat_row['cat_tt'];
  $current_scat_tt = $cat_row['cat_tt'];
  $currency = $cat_row['currency'];
  
  // CONDITIONS
  $qf1   = '';
  $qf2   = '';
  $qf3   = '';
  $qf4   = '';

  $qf3 = " AND (";
  for($j=1;$j<=$dt;$j++) {
    $detid = $di[$j];
    $dettyp = $dtyp[$j];
    if($j == '1') {
      if($dettyp == '1') {
        $qf1  = ", F".$j.".val_id AS vid".$j.", G".$j.".opt_id AS oid".$j.", G".$j.".opt_tt AS pdet".$j."";
        $qf2  = " left join ". _RUDWEB_PRE. "cat_val as F".$j." on (A.prd_id = F".$j.".prd_id)";
        $qf2 .= " left join ". _RUDWEB_PRE. "cat_opt as G".$j." on (G".$j.".opt_id = F".$j.".opt_id)";
        $qf3 .= " F".$j.".det_id = '".$detid."'";
      }
      else {
        $qf1  = ", F".$j.".val_id AS vid".$j.", F".$j.".val_tt AS pdet".$j."";
        $qf2  = " left join ". _RUDWEB_PRE. "cat_val as F".$j." on (A.prd_id = F".$j.".prd_id)";
        $qf3 .= " F".$j.".det_id = '".$detid."'";
      }
    }
    else if ($j != '1') {
      if($dettyp == '1') {
        $qf1 .= ", F".$j.".val_id AS vid".$j.", G".$j.".opt_id AS oid".$j.", G".$j.".opt_tt AS pdet".$j."";
        $qf2 .= " left join ". _RUDWEB_PRE. "cat_val as F".$j." on (A.prd_id = F".$j.".prd_id)";
        $qf2 .= " left join ". _RUDWEB_PRE. "cat_opt as G".$j." on (G".$j.".opt_id = F".$j.".opt_id)";
        $qf3 .= " AND F".$j.".det_id = '".$detid."'";
      }
      else {
        $qf1 .= ", F".$j.".val_id AS vid".$j.", F".$j.".val_tt AS pdet".$j."";
        $qf2 .= " left join ". _RUDWEB_PRE. "cat_val as F".$j." on (A.prd_id = F".$j.".prd_id)";
        $qf3 .= " AND F".$j.".det_id = '".$detid."'";
      }
    }
  }
  $qf3 .= ")";

  $limit = ' LIMIT 1';
  // // CONDITIONS
  
  // DA MEAN QUERY
  $qp =
  "SELECT A.prd_id, A.cat_id, A.prd_iid AS pid, A.prd_tt AS pname, A.prd_dsc, A.prd_qty, A.prd_qlvl, A.prd_prc AS pprice, A.prd_plvl, PIC.pic_id AS pic_id, PIC.pic_fn as pic_fn" .
  $qf1 . " FROM ". _RUDWEB_PRE. "cat_prd as A left join ". _RUDWEB_PRE. "cat_pic as PIC on (A.prd_id = PIC.prd_id AND PIC.pic_loc = '1')" . 
  $qf2 . " WHERE A.prd_id = '".$item_id."'" . $qf3 . $qf4 . $limit;
  
  echo $rudweb_skin['cnt']['tt1']['pre'];
  echo $current_cat_tt . ' / ' . $current_scat_tt . ' - ' . $rudweb_ln['catalog']['itemtt'];
  echo $rudweb_skin['cnt']['tt1']['suf'];
  
  if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 3) {
    if(isset($_POST['itemmod']) || isset($_POST['itemdel'])) {
      // GRAB VALUES
      if(isset($_POST['prd_id']))  {$prd_id = rudweb_filter_input($_POST['prd_id']);}
      if(isset($_POST['prd_tt']))  {$prd_tt = rudweb_filter_input($_POST['prd_tt']);}
      if(isset($_POST['prd_iid'])) {$prd_iid = rudweb_filter_input($_POST['prd_iid']);}
      if(isset($_POST['prd_dsc'])) {$prd_dsc = rudweb_filter_input($_POST['prd_dsc']);}
      for($ij=1;$ij<=$dt;$ij++) {
        $dtjid = $di[$ij];
        if(isset($_POST['val_id'][$dtjid])) {$val_id[$dtjid] = $_POST['val_id'][$dtjid];}
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
      
      if($prd_tt == '') {$err = 1;}
      for($ik=1;$ik<=$dt;$ik++) {
        $dtid = $di[$ik];
        if($dtyp[$ik] == '0' && ($dr[$ik] == '1' && $val_tt[$dtid] == '')) {$err = 3;}
        else if (isset($_POST['opt_id'][$dtid]) && $opt_id[$dtid] == '0') {$err = 2;}
      }
      
      $qv = "SELECT prd_id FROM ". _RUDWEB_PRE. "cat_prd WHERE prd_id = '".$prd_id."' LIMIT 1";
      $rv = rudweb_qres($rudweb_dbtype, $qv);
      $tv = rudweb_qtotal($rudweb_dbtype, $rv);
      
      if($tv != 0) {
        if(isset($_POST['itemmod'])) {
          if($err == 0) {
            $prd_mdd  = date("Y-m-d");
            $prd_mdt  = date("H:i:s");
            $qlk = "LOCK TABLES "._RUDWEB_PRE."cat_prd WRITE, "._RUDWEB_PRE."cat_val WRITE, "._RUDWEB_PRE."cat_pic WRITE";
            mysql_query($qlk) or require _RUDWEB_LIB_DIR . 'myerr.php';
            // main product details
            $uq1 = "UPDATE "._RUDWEB_PRE."cat_prd SET prd_iid = '".$prd_iid."', prd_tt = '".$prd_tt."', prd_dsc = '".$prd_dsc."', prd_qty = '".$prd_qty."', prd_qlvl = '".$prd_qlvl."', prd_prc = '".$prd_prc."', prd_plvl = '".$prd_plvl."', prd_mdd = '".$prd_mdd."', prd_mdt = '".$prd_mdt."', prd_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE prd_id = '".$prd_id."' LIMIT 1";
            mysql_query($uq1) or require _RUDWEB_LIB_DIR . 'myerr.php';
            // all other details
            for($il=1;$il<=$dt;$il++) {
              $dlid = $di[$il];
              if($dtyp[$il] == '0') {
                if (isset($_POST['val_tt'][$dlid])) {
                  $q = "UPDATE "._RUDWEB_PRE."cat_val SET val_tt = '".$val_tt[$dlid]."', val_mdd = '".$prd_mdd."', val_mdt = '".$prd_mdt."', val_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE val_id = '".$val_id[$dlid]."' LIMIT 1";
                  mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
                }
              }
              else {
                if (isset($_POST['opt_id'][$dlid])) {
                  $q = "UPDATE "._RUDWEB_PRE."cat_val SET opt_id = '".$opt_id[$dlid]."', val_mdd = '".$prd_mdd."', val_mdt = '".$prd_mdt."', val_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE val_id = '".$val_id[$dlid]."' LIMIT 1";
                  mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
                }
              }
            }
            // delete pictures
            $allowed_file_types = array("image/jpeg", "image/pjpeg", "image/png", "image/x-png", "image/gif");
            if(isset($_POST['delpic'])) {
              foreach ($_POST['delpic'] as $pic_id => $dump) {
                $qpfn       = "SELECT pic_fn FROM "._RUDWEB_PRE."cat_pic WHERE pic_id = '".$pic_id."' LIMIT 1";
                $rqpfn      = rudweb_qres($rudweb_dbtype, $qpfn);
                $del_pic_fn = rudweb_result($rudweb_dbtype, $rqpfn, 0);
                $delpicfile = _RUDWEB_PRDP_DIR . $del_pic_fn;
                if (is_file($delpicfile)) {unlink($delpicfile);}
                $qd = "DELETE FROM "._RUDWEB_PRE."cat_pic WHERE pic_id = '".$pic_id."' LIMIT 1";
                mysql_query($qd) or require _RUDWEB_LIB_DIR . 'myerr.php';
              }
            }
            else {
              // mod pictures
              if(isset($_FILES['itemrepl'])) {
                foreach ($_FILES['itemrepl']['error'] as $pic_id => $error) {
                  $file_name[$pic_id]  = $_FILES['itemrepl']['name'][$pic_id];
                  $file_type[$pic_id]  = $_FILES['itemrepl']['type'][$pic_id];
                  $file_temp[$pic_id]  = $_FILES['itemrepl']['tmp_name'][$pic_id];
                  $file_error[$pic_id] = $_FILES['itemrepl']['error'][$pic_id];
                  $file_size[$pic_id]  = $_FILES['itemrepl']['size'][$pic_id];
                  
                  $err = '0';
                  if ($file_error[$pic_id] == '0' && !in_array($file_type[$pic_id], $allowed_file_types)) {/* NOT A PICTURE */$err = '1';}
                  else if ($file_error[$pic_id] == '4') {/* NO FILE UPLOADED */ $err = '1';}
                  else if ($file_error[$pic_id] == '3') {/* PARTIAL UPLOAD */ $err = '1';}
                  else if ($file_error[$pic_id] == '0' && !is_uploaded_file($file_temp[$pic_id])) {/*NOT SENT BY FORM*/ $err = '1';}
                  else if ($file_error[$pic_id] == '0') {/* OK */ $err = '0';}
                  
                  if ($err == '0') {
                    $upload_dir[$pic_id] = _RUDWEB_PRDP_DIR;
                    $new_file_name[$pic_id] = "prd_" . $_SESSION[_RUDWEB_PRE.'usr_id'] . "_" . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . "_" . time() . "_" . basename($file_name[$pic_id]);
                    $upload_path[$pic_id] = $upload_dir[$pic_id] . $new_file_name[$pic_id];
                    if($file_error[$pic_id] == '0') {
                      if (move_uploaded_file($file_temp[$pic_id], $upload_path[$pic_id])) {
                        $qpfn       = "SELECT pic_fn FROM "._RUDWEB_PRE."cat_pic WHERE pic_id = '".$pic_id."' LIMIT 1";
                        $rqpfn      = rudweb_qres($rudweb_dbtype, $qpfn);
                        $del_pic_fn = rudweb_result($rudweb_dbtype, $rqpfn, 0);
                        $delpicfile = _RUDWEB_PRDP_DIR . $del_pic_fn;
                        if (is_file($delpicfile)) {unlink($delpicfile);}
                        $qu = "UPDATE "._RUDWEB_PRE."cat_pic SET pic_fn = '".$new_file_name[$pic_id]."', pic_mdd = '".$prd_mdd."', pic_mdt = '".$prd_mdt."', pic_mdu = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE pic_id = '".$pic_id."' LIMIT 1";
                        mysql_query($qu) or require _RUDWEB_LIB_DIR . 'myerr.php';
                      }
                    }
                  }
                }
              }
            }
            // add pictures
            if(isset($_FILES['itempic'])) {
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
                
                      $qp = "INSERT INTO "._RUDWEB_PRE."cat_pic (pic_id, prd_id, pic_fn, pic_loc, pic_ord, pic_crd, pic_crt, pic_cru, pic_mdd, pic_mdt, pic_mdu, pic_lvl) VALUES ('".$new_pic_id."', '".$prd_id."', '".$new_file_name[$pic_loc]."', '".$pic_loc."', '".$new_pic_ord."', '".$prd_mdd."', '".$prd_mdt."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '', '', '', '0')";
                      mysql_query($qp) or require _RUDWEB_LIB_DIR . 'myerr.php';
                    }
                  }
                }
              }
            }
            $quk = "UNLOCK TABLES";
            mysql_query($quk) or require _RUDWEB_LIB_DIR . 'myerr.php';
            
            echo '<DIV CLASS="ok" STYLE="padding-top: 10px; padding-bottom: 10px;">';
            echo $rudweb_ln['cat']['itemmodok'];
            echo '</DIV>';
            echo '<DIV CLASS="ok" STYLE="padding-top: 10px; padding-bottom: 10px;">';
            restrictedLocalLink('default', $rudweb_ln['cat']['itemmod'], _RUDWEB_INDEX_PHP . 'catalog/item/id/'.$prd_id, $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
            echo '</DIV>';
            echo '<DIV CLASS="ok" STYLE="padding-top: 10px; padding-bottom: 10px;">';
            restrictedLocalLink('default', $rudweb_ln['cat']['itemaddnew'], _RUDWEB_INDEX_PHP . 'admin/itemadd/cat/'.$current_scat, $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
            echo '</DIV>';
            echo '<DIV CLASS="ok" STYLE="padding-top: 10px; padding-bottom: 10px;">';
            restrictedLocalLink('default', $rudweb_ln['cat']['itemviewcat'], _RUDWEB_INDEX_PHP . 'catalog/items/cat/'.$current_scat, $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
            echo '</DIV>';
            // XXX
          }
          else {
            catYah(0,$item_id);
            // DISPLAY ERRORS
            $rp = rudweb_qres($rudweb_dbtype, $qp);
            $tp = rudweb_qtotal($rudweb_dbtype, $rp);
            if($tp == '1') {
              $rwp = rudweb_fetch_assoc($rudweb_dbtype, $rp);
            }
            $mpic_id = $rwp['pic_id'];
            $mpic_fn = $rwp['pic_fn'];
            // DISPLAY FORM
            echo '<DIV CLASS="err" STYLE="padding-top: 10px; padding-bottom: 10px;">';
            echo $rudweb_ln['err']['tt'];
            echo '&#160;';
            echo $rudweb_ln['err']['itemadd'][$err];
            echo '</DIV>';
            require _RUDWEB_ADMIN_DIR . 'itemform.inc.php';
          }
        }
        else if(isset($_POST['itemdel'])) {
          $qlk = "LOCK TABLES "._RUDWEB_PRE."cat_prd WRITE, "._RUDWEB_PRE."cat_val WRITE, "._RUDWEB_PRE."cat_pic WRITE, "._RUDWEB_PRE."ws_cmt WRITE";
          mysql_query($qlk) or require _RUDWEB_LIB_DIR . 'myerr.php';
          //comments
          $qcm = "DELETE FROM "._RUDWEB_PRE."ws_cmt WHERE cmt_typ = '1' AND cnt_id = '".$prd_id."'";
          mysql_query($qcm) or require _RUDWEB_LIB_DIR . 'myerr.php';
          //pictures
          $qpc = "SELECT pic_fn FROM "._RUDWEB_PRE."cat_pic WHERE prd_id = '".$prd_id."'";
          $rpc = rudweb_qres($rudweb_dbtype, $qpc);
          $tpc = rudweb_qtotal($rudweb_dbtype, $rpc);
          if ($tpc != 0) {
            for($pi=1;$pi<=$tpc;$pi++) {
              $rwpc = rudweb_fetch_assoc($rudweb_dbtype, $rpc);
              $filepath[$pi] = _RUDWEB_PRDP_DIR . $rwpc['pic_fn'];
              if (is_file($filepath[$pi])) {unlink($filepath[$pi]);}
            }
            $qd1 = "DELETE FROM "._RUDWEB_PRE."cat_pic WHERE prd_id = '".$prd_id."'";
            mysql_query($qd1) or require _RUDWEB_LIB_DIR . 'myerr.php';
          }
          // additional product details
          $qd2 = "DELETE FROM "._RUDWEB_PRE."cat_val WHERE prd_id = '".$prd_id."'";
          mysql_query($qd2) or require _RUDWEB_LIB_DIR . 'myerr.php';
          // main product details
          $qd3 = "DELETE FROM "._RUDWEB_PRE."cat_prd WHERE prd_id = '".$prd_id."' LIMIT 1";
          mysql_query($qd3) or require _RUDWEB_LIB_DIR . 'myerr.php';
          $quk = "UNLOCK TABLES";
          mysql_query($quk) or require _RUDWEB_LIB_DIR . 'myerr.php';
          
          echo '<DIV CLASS="ok" STYLE="padding-top: 10px; padding-bottom: 10px;">';
          echo $rudweb_ln['cat']['itemdelok'];
          echo '</DIV>';
          echo '<DIV CLASS="ok" STYLE="padding-top: 10px; padding-bottom: 10px;">';
          restrictedLocalLink('default', $rudweb_ln['cat']['itemaddnew'], _RUDWEB_INDEX_PHP . 'admin/itemadd/cat/'.$current_scat, $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
          echo '</DIV>';
          echo '<DIV CLASS="ok" STYLE="padding-top: 10px; padding-bottom: 10px;">';
          restrictedLocalLink('default', $rudweb_ln['cat']['itemviewcat'], _RUDWEB_INDEX_PHP . 'catalog/items/cat/'.$current_scat, $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
          echo '</DIV>';
        }      
      }
      else {
        echo '<DIV CLASS="err" STYLE="padding-top: 15px;">'.$rudweb_ln['err']['0'].'</DIV>';
      }
    }
    else {
      $rp = rudweb_qres($rudweb_dbtype, $qp);
      $tp = rudweb_qtotal($rudweb_dbtype, $rp);
      
      if($tp == '1') {
        $rwp = rudweb_fetch_assoc($rudweb_dbtype, $rp);
        
        $prd_id  = $rwp['prd_id'];
        $prd_tt  = $rwp['pname'];
        $prd_iid = $rwp['pid'];
        $prd_dsc = $rwp['prd_dsc'];
        
        for($ii=1;$ii<=$dt;$ii++) {
          $diiid = $di[$ii];
          $val_id[$diiid] = $rwp['vid'.$ii];
          if($dtyp[$ii] == '0') {$val_tt[$diiid] = $rwp['pdet'.$ii];}
          else {$opt_id[$diiid] = $rwp['oid'.$ii];}
        }
        
        $prd_qty  = $rwp['prd_qty'];
        $prd_qlvl = $rwp['prd_qlvl'];
        $prd_prc  = $rwp['pprice'];
        $prd_plvl = $rwp['prd_plvl'];
        
        $mpic_id = $rwp['pic_id'];
        $mpic_fn = $rwp['pic_fn'];
        
        catYah(0,$item_id);
        require _RUDWEB_ADMIN_DIR . 'itemform.inc.php';
        showExtComments(1,$item_id,'');
      }  
    }
  }
  else {
    // NORMAL USER
    $rp = rudweb_qres($rudweb_dbtype, $qp);
      $tp = rudweb_qtotal($rudweb_dbtype, $rp);
      
      if($tp == '1') {
        $rwp = rudweb_fetch_assoc($rudweb_dbtype, $rp);
        
        catYah(0,$item_id);
        
        echo $rudweb_skin['prod']['dt']['hdr'];
        // main picture
        echo $rudweb_skin['prod']['dt']['pict0']['pre'];
  
        
        if($rwp['pic_id'] != 0 && $rwp['pic_fn'] != NULL) {
          if(is_file(_RUDWEB_PRDP_DIR.$rwp['pic_fn'])) {
            $pic0url = _RUDWEB_LIB_URL.'pic.php?imgfile='._RUDWEB_PRDP_DIR.$rwp['pic_fn'].'&amp;max_size='.$rudweb_skin['prod']['dt']['picmax'];
            $pic0fileurl = _RUDWEB_PRDP_URL.$rwp['pic_fn'];
          }
          
        }
        else {
          $pic0url     = _RUDWEB_LIB_URL.'pic.php?imgfile='._RUDWEB_SKIN_DIR . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'].'/graphics/nopic.png'.'&amp;max_size='.$rudweb_skin['prod']['dt']['picmax'];
          $pic0fileurl = _RUDWEB_SKIN_URL . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'].'/graphics/nopic.png';
        }
        echo '<A CLASS="default" rel="lightbox[1]" HREF="'.$pic0fileurl.'" TITLE="'.$rwp['pname'].'">';
        echo '<IMG CLASS="op" SRC="'.$pic0url.'" TITLE="'.$rwp['pname'].'" ALT="'.$rwp['pname'].'" onMouseOver="bevisible(this,0)" onMouseOut="bevisible(this,1)">';
        echo '</A>';
  
        echo $rudweb_skin['prod']['dt']['pict0']['suf'];
        // product name
        echo $rudweb_skin['prod']['dt']['tt_vl']['pre'];
        echo $rwp['pname'];
        echo $rudweb_skin['prod']['dt']['tt_vl']['suf'];
        // offer id
        echo $rudweb_skin['prod']['dt']['pid_tt']['pre'];
        echo $rudweb_ln['prod']['pid'];
        echo $rudweb_skin['prod']['dt']['pid_tt']['suf'];
        echo $rudweb_skin['prod']['dt']['pid_vl']['pre'];
        echo $rwp['pid'];
        echo $rudweb_skin['prod']['dt']['pid_vl']['suf'];
  
        // product description
        echo $rudweb_skin['prod']['dt']['dsc_tt']['pre'];
        echo $rudweb_ln['prod']['prd_dsc'];
        echo $rudweb_skin['prod']['dt']['dsc_tt']['suf'];
        echo $rudweb_skin['prod']['dt']['dsc_vl']['pre'];
        echo $rwp['prd_dsc'];
        echo $rudweb_skin['prod']['dt']['dsc_vl']['suf'];
  
  
        // all other details
        for($m=1;$m<=$dt;$m++) {
          echo $rudweb_skin['prod']['dt']['det']['hdr'];
          echo $rudweb_skin['prod']['dt']['det_tt']['pre'];
          echo $dtt[$m];
          echo $rudweb_skin['prod']['dt']['det_tt']['suf'];
          echo $rudweb_skin['prod']['dt']['det_vl']['pre'];
          echo $rwp['pdet'.$m];
          echo $rudweb_skin['prod']['dt']['det_vl']['suf'];
          echo $rudweb_skin['prod']['dt']['det']['ftr'];
        }
  
        // quantity
        if ($rwp['prd_qlvl'] <= $_SESSION[_RUDWEB_PRE.'usr_level']) {
          echo $rudweb_skin['prod']['dt']['qty_tt']['pre'];
          echo $rudweb_ln['cat']['quantity'];
          echo $rudweb_skin['prod']['dt']['qty_tt']['suf'];
          echo $rudweb_skin['prod']['dt']['qty_vl']['pre'];
          echo $rwp['prd_qty'];
          echo $rudweb_skin['prod']['dt']['qty_vl']['suf'];
        }
  
        // price
        echo $rudweb_skin['prod']['dt']['prc_tt']['pre'];
        echo $rudweb_ln['prod']['pprice'];
        echo $rudweb_skin['prod']['dt']['prc_tt']['suf'];
        echo $rudweb_skin['prod']['dt']['prc_vl']['pre'];
        if($rwp['prd_plvl'] > $_SESSION[_RUDWEB_PRE.'usr_level'] || $rwp['pprice'] == '0.00') {echo '---';}
        else {echo $rwp['pprice'] . '&#160;' . $currency;}
        echo $rudweb_skin['prod']['dt']['prc_vl']['suf'];
  
        // product pictures
        echo $rudweb_skin['prod']['dt']['pic0']['hdr'];
  
        $qpc = "SELECT * FROM "._RUDWEB_PRE."cat_pic WHERE prd_id = '".$item_id."' AND pic_loc >= '2' ORDER BY pic_ord ASC";
        $rpc = rudweb_qres($rudweb_dbtype, $qpc);
        $tpc = rudweb_qtotal($rudweb_dbtype, $rpc);
        if($tpc != 0) {
          for($ip=1;$ip<=$tpc;$ip++) {
            $rowp = rudweb_fetch_assoc($rudweb_dbtype, $rpc); 
            if(is_file(_RUDWEB_PRDP_DIR.$rowp['pic_fn'])) {
              $picpath[$ip] = _RUDWEB_PRDP_DIR . $rowp['pic_fn']; 
              $picurl[$ip]  = _RUDWEB_PRDP_URL . $rowp['pic_fn'];
              $picsrc[$ip]  = '<IMG CLASS="op" SRC="'._RUDWEB_LIB_URL.'pic.php?imgfile='.$picpath[$ip].'&amp;max_size='.$rudweb_skin['prod']['dt']['picmax'].'" TITLE="'.$rwp['pname'].'" ALT="'.$rwp['pname'].'" onMouseOver="bevisible(this,0)" onMouseOut="bevisible(this,1)">';
            }
            else {
              $picurl[$ip]  = _RUDWEB_LIB_URL.'img.php?pw='.$rudweb_skin['prod']['dt']['picmax'].'&amp;ph='.$rudweb_skin['prod']['dt']['picmax'].'&amp;txt='.$rudweb_ln['adm']['nopic'];
              $picsrc[$ip]  = $picurl[$ip];
            }
            echo $rudweb_skin['prod']['dt']['pic0']['pre'];
            echo '<A CLASS="default" REL="lightbox['.$ip.']" HREF="'.$picurl[$ip].'" TITLE="'.$rwp['pname'].'">';
            echo $picsrc[$ip];
            echo '</A>';
            echo $rudweb_skin['prod']['dt']['pic0']['suf'];
            if($ip != $tpc) {echo $rudweb_skin['prod']['dt']['pic0']['sep'];}
          }
        }
        echo $rudweb_skin['prod']['dt']['pic0']['ftr'];
  
        echo $rudweb_skin['prod']['dt']['ftr'];
        
        showExtComments(1,$item_id,'');
      }
  }
}
else {
  echo '<DIV CLASS="err" STYLE="padding-top: 15px;">'.$rudweb_ln['err']['1'].'</DIV>';
}
echo $rudweb_skin['catalog']['ftr'];
?>