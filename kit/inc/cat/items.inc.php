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
./inc/cat/items.inc.php
13:24 2008-07-18
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

if(isset($_GET['cat'])) {

  $current_cat = rudweb_filter_content($_GET['cat']);

  $query_cat  = "SELECT A.cat_tt, A.cat_lev, D.crt_sm AS currency FROM ". _RUDWEB_PRE. "cat_cat as A left join ". _RUDWEB_PRE. "cat_crv as C on (A.cat_ln = C.crv_ln) left join ". _RUDWEB_PRE. "cat_crt as D on (C.crt_id = D.crt_id) WHERE cat_id = '".$current_cat."' LIMIT 1";
  $result_cat = rudweb_qres($rudweb_dbtype, $query_cat);
  $total_cat  = rudweb_qtotal($rudweb_dbtype, $result_cat);

  if($total_cat == '1') {$cat_row = rudweb_fetch_assoc($rudweb_dbtype, $result_cat); $current_cat_tt = $cat_row['cat_tt']; $current_cat_lev = $cat_row['cat_lev']; $currency = $cat_row['currency'];}
  else {$current_cat_tt = 'N/A'; $current_cat_lev = 0; $currency = 'N/A';}

  $scat_lev = $current_cat_lev + 1;

  $query_scat  = "SELECT cat_id, cat_tt, cat_pic, cat_dsc FROM ". _RUDWEB_PRE. "cat_cat WHERE cat_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND cat_lev = '".$scat_lev."' AND cat_par = '".$current_cat."'";
  $result_scat = rudweb_qres($rudweb_dbtype, $query_scat);
  $total_scat  = rudweb_qtotal($rudweb_dbtype, $result_scat);

  echo $rudweb_skin['catalog']['hdr'];

  echo $rudweb_skin['cnt']['tt1']['pre'];
  echo $current_cat_tt;
  echo $rudweb_skin['cnt']['tt1']['suf'];

  catYah($current_cat,0);

  // ITEMS
  $q1 = "SELECT det_id, det_typ, det_tt FROM ". _RUDWEB_PRE. "cat_det WHERE cat_id = '".$current_cat."' AND (det_front = '1' AND det_lvl <= '".$_SESSION[_RUDWEB_PRE.'usr_level']."') ORDER BY det_ord ASC";
  $r1 = rudweb_qres($rudweb_dbtype, $q1);
  $t1 = rudweb_qtotal($rudweb_dbtype, $r1);

  $sorta = array("id", "name", "price");

  $filters = '0';
  if($t1 != '0') {
    $filters = 1;
    for($i=1;$i<=$t1;$i++) {
      $row1     = rudweb_fetch_assoc($rudweb_dbtype, $r1); 
      $di[$i]   = $row1['det_id']; 
      $dtyp[$i] = $row1['det_typ']; 
      $dtt[$i]  = $row1['det_tt'];
      $sorta[]  = "det".$i;
    }
    $dt = count($di);
  }
  else {$filters = 0; $dt = 0;}


  // SORTING
  $sorting = " ORDER BY";
  $sort = null;
  $asc = 1;
  if(isset($_GET['sort'])) {
    $sort = rudweb_filter_input($_GET['sort']);
    if (in_array($sort, $sorta)) {
      $sortorder = 'ASC';
      if (isset($_GET['asc'])) {
        $asc = rudweb_filter_input($_GET['asc']);
        if ($asc == 0) {$sortorder = 'DESC';}
        else if ($asc == 1) {$sortorder = 'ASC';}
      }
      $sorting .= " p" . $sort . " " . $sortorder . ",";
    }
  }
  $sorting .= " A.prd_crd DESC, A.prd_crt DESC";

  // FILTERS
  $qf1 = "";
  $qf2 = "";
  $qf3 = "";
  $qf4 = "";
  if($filters == '1') {
    $qf3 = " AND (";
    $qf4 = " AND (";
    for($j=1;$j<=$dt;$j++) {
      $detid = $di[$j];
      $dettyp = $dtyp[$j];
      $fm[$detid] = "IS NOT NULL";
      $fl[$detid] = "IS NOT NULL";

      if(isset($_GET['det_id']) && ($_GET['det_id'] == $detid && isset($_GET['opt_id']))) {
        $_POST['opt_id'][$detid] = rudweb_filter_content($_GET['opt_id']);
      }
      if(isset($_POST['opt_id'][$detid])) {
        $flm = rudweb_filter_content($_POST['opt_id'][$detid]);
        if($flm == '' || $flm == 0) {$fm[$detid] = "IS NOT NULL";}
        else{$fm[$detid] = "= '".$flm."'";}
      }
     
      else if(isset($_POST['val_tt'][$detid])) {
        //$flt = rudweb_filter_content($_POST['val_tt'][$detid]);
        $flt = parseSearchString($_POST['val_tt'][$detid]);
        if($flt == '') {$fl[$detid] = "IS NOT NULL";}
        //else{$fl[$detid] = "= '".$flt."'";}
        else{$fl[$detid] = "REGEXP '".$flt."'";}
      }
      if($j == '1') {
        if($dettyp == '1') {
          $qf1  = ", G".$j.".opt_tt AS pdet".$j."";
          $qf2  = " left join ". _RUDWEB_PRE. "cat_val as F".$j." on (A.prd_id = F".$j.".prd_id)";
          $qf2 .= " left join ". _RUDWEB_PRE. "cat_opt as G".$j." on (G".$j.".opt_id = F".$j.".opt_id)";
          $qf3 .= " F".$j.".det_id = '".$detid."'";
          $qf4 .= "G".$j.".opt_id " . $fm[$detid];
        } 
        else {
          $qf1  = ", F".$j.".val_tt AS pdet".$j."";
          $qf2  = " left join ". _RUDWEB_PRE. "cat_val as F".$j." on (A.prd_id = F".$j.".prd_id)";
          $qf3 .= " F".$j.".det_id = '".$detid."'";
          $qf4 .= "F".$j.".val_tt " . $fl[$detid];
        }
      }
      else if ($j != '1') {
        if($dettyp == '1') {
          $qf1 .= ", G".$j.".opt_tt AS pdet".$j."";
          $qf2 .= " left join ". _RUDWEB_PRE. "cat_val as F".$j." on (A.prd_id = F".$j.".prd_id)";
          $qf2 .= " left join ". _RUDWEB_PRE. "cat_opt as G".$j." on (G".$j.".opt_id = F".$j.".opt_id)";
          $qf3 .= " AND F".$j.".det_id = '".$detid."'";
          $qf4 .= " AND G".$j.".opt_id " . $fm[$detid];
        }
        else {
          $qf1 .= ", F".$j.".val_tt AS pdet".$j."";
          $qf2 .= " left join ". _RUDWEB_PRE. "cat_val as F".$j." on (A.prd_id = F".$j.".prd_id)";
          $qf3 .= " AND F".$j.".det_id = '".$detid."'";
          $qf4 .= " AND F".$j.".val_tt " . $fl[$detid];
        }
      }
    }
    $qf3 .= ")";
    $qf4 .= ")";
  }

  // KEYWORDS
  $qf5 = '';
  if(isset($_POST['kw']) && $_POST['kw'] != '') {
    $kw = parseSearchString($_POST['kw']);
    if($kw != '') {
    $qf5 = ' AND (';
    $qf5 .= "A.prd_tt REGEXP '".$kw."'";
  //  $qf5 .= ' OR ';
  //  $qf5 .= "A.prd_dsc REGEXP '".$kw."'";
    $qf5 .= ')';
    }
  }
  // PID
  $qf6 = '';
  if(isset($_POST['id']) && $_POST['id'] != '') {
    $fpid = parseSearchString($_POST['id']);
    if($fpid != '') {
    $qf6 = ' AND (';
    $qf6 .= "A.prd_iid REGEXP '".$fpid."'";
    $qf6 .= ')';
    }
  }
  // PAGINATION START
  $pg = 1;
  if(isset($_GET['pg']) && isValidInt($_GET['pg'])) {$pg = rudweb_filter_input($_GET['pg']);}

  $itemspg = _RUDWEB_CFG_CAT_IPG;
  if(isset($_GET['itemspg']) && isValidInt($_GET['itemspg'])) {$itemspg = rudweb_filter_input($_GET['itemspg']);}

  $offset = ($pg - 1) * $itemspg;

  $limit = " LIMIT ".$offset.", ".$itemspg."";

  // MAIN QUERIES
  $q2 =
  "SELECT SQL_CALC_FOUND_ROWS A.prd_id, A.prd_iid AS pid, A.prd_tt AS pname, A.prd_dsc, A.prd_qty, A.prd_qlvl, A.prd_prc AS pprice, A.prd_plvl, PIC.pic_fn as pic_fn" .
  $qf1 .
  " FROM ". _RUDWEB_PRE. "cat_prd as A left join ". _RUDWEB_PRE. "cat_pic as PIC on (A.prd_id = PIC.prd_id AND PIC.pic_loc = '1')" . 
  $qf2 .
  " WHERE A.cat_id = '".$current_cat."'" .
  $qf3 .
  $qf4 .
  $qf5 .
  $qf6 .
  $sorting .
  $limit
  ;

  $q3 = "SELECT FOUND_ROWS() as totalitems";


  $r2 = rudweb_qres($rudweb_dbtype, $q2);
  $t2 = rudweb_qtotal($rudweb_dbtype, $r2);
  // I M P O R T A N T ! ! !  needs to be the exact first thing after the big query ! ! !
  $totalitems = rudweb_result($rudweb_dbtype, rudweb_qres($rudweb_dbtype, $q3), 0);
  // //ITEMS

  echo $rudweb_skin['cat']['hdr'];

  if ($total_scat != 0) {
    for($i=1;$i<=$total_scat;$i++) {
      $scat_row = rudweb_fetch_assoc($rudweb_dbtype, $result_scat);
      
      echo $rudweb_skin['cat']['pre'];
      
      echo $rudweb_skin['cat']['pc']['pre'];
      
      if(is_file(_RUDWEB_CATP_DIR.$scat_row['cat_pic'])) {
        $pic_src = _RUDWEB_LIB_URL.'pic.php?imgfile='._RUDWEB_CATP_DIR.$scat_row['cat_pic'].'&amp;max_size='.$rudweb_skin['cat']['pic'];
      }
      else {
        $pic_src = _RUDWEB_LIB_URL.'pic.php?imgfile='._RUDWEB_SKIN_DIR . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'].'/graphics/nopic.png'.'&amp;max_size='.$rudweb_skin['cat']['pic'];
        //$pic_src = _RUDWEB_LIB_URL.'img.php?pw='.$rudweb_skin['cat']['pic'].'&amp;ph='.$rudweb_skin['cat']['pic'].'&amp;txt='.$rudweb_ln['adm']['nopic'];;
      }
      
      echo '<A CLASS="default" HREF="'._RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'catalog/items/cat/'.$scat_row['cat_id'].'" TITLE="'.$scat_row['cat_tt'].'" TARGET="_self">';
      echo '<IMG CLASS="op" SRC="'.$pic_src.'" TITLE="'.$scat_row['cat_tt'].'" ALT="'.$scat_row['cat_tt'].'" onMouseOver="bevisible(this,0)" onMouseOut="bevisible(this,1)">';
      echo '</A>';
      
      echo $rudweb_skin['cat']['pc']['suf'];
      
      echo $rudweb_skin['cat']['tt']['pre'];
      restrictedLocalLink('categ', $scat_row['cat_tt'], _RUDWEB_INDEX_PHP . 'catalog/items/cat/'.$scat_row['cat_id'], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      echo $rudweb_skin['cat']['tt']['suf'];
      
      echo $rudweb_skin['cat']['dsc']['pre'];
      echo $scat_row['cat_dsc'];
      echo $rudweb_skin['cat']['dsc']['suf'];
      
      echo $rudweb_skin['cat']['suf'];
      
      if($i != $total_scat) {echo $rudweb_skin['cat']['sep'];}
    }
  }
  echo $rudweb_skin['cat']['ftr'];

  // DISPLAY FILTER BOX
  $urlsofar1 = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'catalog/items/cat/' . $current_cat;
  $urlsofar = 'http'.((!empty($_SERVER['HTTPS'])) ? 's' : '').'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  if(_RUDWEB_CFG_CAT_FLT == 1) {
    if($t1 != 0 && $pg == 1) {
      displayFilterBox($di, $dtyp, $dtt, $dt, $urlsofar1);
    }
  }
  // xxx

  // DISPLAY COMPARE BOX

  // DISPLAY ITEMS
  if($t2 != '0') {
    echo $rudweb_skin['prod']['lst']['hdr'];
    
    // header:
    echo $rudweb_skin['prod']['lst']['hdrhdr'];
    // pid
    echo $rudweb_skin['prod']['lst']['pidpre'];
    catSortLink('id', $rudweb_ln['prod']['pid'], $asc);
    echo $rudweb_skin['prod']['lst']['pidsuf'];
    
    echo $rudweb_skin['prod']['lst']['ppicpre'] . $rudweb_ln['prod']['ppic'] . $rudweb_skin['prod']['lst']['ppicsuf'];
    echo $rudweb_skin['prod']['lst']['pnamepre'];
    //echo $rudweb_ln['prod']['pname'];
    catSortLink('name', $rudweb_ln['prod']['pname'], $asc);
    echo $rudweb_skin['prod']['lst']['pnamesuf'];
    //echo $rudweb_skin['prod']['lst']['prd_dscpre'] . $rudweb_ln['prod']['prd_dsc'] . $rudweb_skin['prod']['lst']['prd_dscsuf'];
    
    // other details
    for($l=1;$l<=$dt;$l++) {
      //$detid = $di[$l];
      echo $rudweb_skin['prod']['lst']['detpre'];
      //echo $dtt[$detid];
      catSortLink('det'.$l, $dtt[$l], $asc);
      echo $rudweb_skin['prod']['lst']['detsuf'];
    }
    
    echo $rudweb_skin['prod']['lst']['ppricepre'];
    catSortLink('price', $rudweb_ln['prod']['pprice'], $asc);
    echo $rudweb_skin['prod']['lst']['ppricesuf'];
    
    echo $rudweb_skin['prod']['lst']['ftrhdr'];
    
    for($k=1;$k<=$t2;$k++) {
      $rw = rudweb_fetch_assoc($rudweb_dbtype, $r2);
      echo $rudweb_skin['prod']['lst']['hdrprd'];
      
      // pid
      echo $rudweb_skin['prod']['lst']['pidpre'];
      restrictedLocalLink('prdlnk', $rw['pid'], _RUDWEB_INDEX_PHP .  'catalog/item/id/'.$rw['prd_id'], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      echo $rudweb_skin['prod']['lst']['pidsuf'];
      // picture
      echo $rudweb_skin['prod']['lst']['ppicpre'];
      
      if(is_file(_RUDWEB_PRDP_DIR.$rw['pic_fn'])) {
        $pic_src = _RUDWEB_LIB_URL.'pic.php?imgfile='._RUDWEB_PRDP_DIR.$rw['pic_fn'].'&amp;max_size='.$rudweb_skin['prod']['picmax'];
      }
      else {
        $pic_src = _RUDWEB_LIB_URL.'pic.php?imgfile='._RUDWEB_SKIN_DIR . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'].'/graphics/nopic.png'.'&amp;max_size='.$rudweb_skin['prod']['picmax'];
      }

      echo '<A CLASS="default" HREF="'._RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'catalog/item/id/'.$rw['prd_id'].'" TITLE="'.$rw['pname'].'" TARGET="_self">';
      echo '<IMG CLASS="op" SRC="'.$pic_src.'" TITLE="'.$rw['pname'].'" ALT="'.$rw['pname'].'" onMouseOver="bevisible(this,0)" onMouseOut="bevisible(this,1)">';
      echo '</A>';
      
      echo $rudweb_skin['prod']['lst']['ppicsuf'];
      //pname
      echo $rudweb_skin['prod']['lst']['pnamepre'];
      restrictedLocalLink('prdlnk', $rw['pname'], _RUDWEB_INDEX_PHP . 'catalog/item/id/'.$rw['prd_id'], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      echo $rudweb_skin['prod']['lst']['pnamesuf'];
      
      
      
      // prd_dsc
      //echo $rudweb_skin['prod']['lst']['prd_dscpre'];
      //$short_dsc = str_split($rw['prd_dsc'], $rudweb_skin['prod']['chardesc']);
      //$short_dsc = $short_dsc['0'] . ' ...';
      //echo $short_dsc;
      //echo $rudweb_skin['prod']['lst']['prd_dscsuf'];
      
      // all other details
      for($m=1;$m<=$dt;$m++) {
        //$detid = $di[$m];
        echo $rudweb_skin['prod']['lst']['detpre'];
        if($rw['pdet'.$m] == $rudweb_ln['yes']) {
          echo '<IMG SRC="'._RUDWEB_SKIN_URL.$_SESSION[_RUDWEB_PRE.'usr_skin_dir'].'/graphics/yes.gif" WIDTH="16" HEIGHT="16" ALT="'.$rudweb_ln['yes'].'" TITLE="'.$rudweb_ln['yes'].'">';
        }
        else if($rw['pdet'.$m] == $rudweb_ln['no']) {
          echo '<IMG SRC="'._RUDWEB_SKIN_URL.$_SESSION[_RUDWEB_PRE.'usr_skin_dir'].'/graphics/no.gif" WIDTH="16" HEIGHT="16" ALT="'.$rudweb_ln['no'].'" TITLE="'.$rudweb_ln['no'].'">';
        }
        else {echo $rw['pdet'.$m];}
        echo $rudweb_skin['prod']['lst']['detsuf'];
      }
      
      // pprice
      echo $rudweb_skin['prod']['lst']['ppricepre'];
      if($rw['prd_plvl'] > $_SESSION[_RUDWEB_PRE.'usr_level'] || $rw['pprice'] == '0.00') {echo '---';}
      else {echo $rw['pprice'] . '&#160;' . $currency;}
      echo $rudweb_skin['prod']['lst']['ppricesuf'];
      
      echo $rudweb_skin['prod']['lst']['ftrprd'];
    }
    
    echo $rudweb_skin['prod']['lst']['ftr'];
    
    //$urlsofar = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'catalog/items/cat/' . $current_cat;
    //$urlsofar = 'http'.((!empty($_SERVER['HTTPS'])) ? 's' : '').'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    catalogPageNavigation($totalitems,$itemspg,$pg,$urlsofar);
  }

  echo $rudweb_skin['catalog']['ftr'];

  /*
  echo '<BR><BR><SPAN STYLE="font-weight: bold; line-height: 120%; font-size: 16px;">' . $q2 . '</SPAN><BR>';
  echo '<BR><SPAN STYLE="font-weight: bold; font-size: 16px;">' . $q3 . '</SPAN><BR><BR>';
  echo '<BR>';
  echo $t2;
  echo '<BR>';
  echo $totalitems;
  echo '<BR>';
  */
}
else {
  echo "<DIV CLASS=\"err\">" . $rudweb_ln['err']['1'] . "</DIV>";
} // else if user has no rights
?>