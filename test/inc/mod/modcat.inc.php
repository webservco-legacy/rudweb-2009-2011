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
./inc/mod/modcat.inc.php
12:49 2008-05-13
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

function catYah($cat=0,$item=0) {
  global $rudweb_req_page;
  global $rudweb_ln;
  global $rudweb_skin;
  global $rudweb_dbtype;
  
  echo $rudweb_skin['catyah']['hdr'];
  
  echo $rudweb_skin['catyah']['pre'];
  restrictedLocalLink('default', $rudweb_ln['catalog']['catalog'], _RUDWEB_INDEX_PHP . 'catalog/main', $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
  echo $rudweb_skin['catyah']['suf'];
  
  
  switch($rudweb_req_page) {
    case "items" : {
      $query_cat  = "SELECT cat_tt, cat_lev FROM ". _RUDWEB_PRE. "cat_cat WHERE cat_id = '".$cat."' LIMIT 1";
      $result_cat = rudweb_qres($rudweb_dbtype, $query_cat);
      $cat_row = rudweb_fetch_assoc($rudweb_dbtype, $result_cat);
      $cat_tt  = $cat_row['cat_tt'];
      $cat_lev = $cat_row['cat_lev'];
      
      $qf1 = "";
      $qf2 = "";
      
      for($i=$cat_lev;$i>0;$i--) {
        $i1 = $i - 1;
        $qf1 .= " ,lev".$i1.".cat_id AS cat_id".$i1."";
        $qf1 .= " ,lev".$i1.".cat_tt AS cat_tt".$i1."";
        $qf2 .= " left join ". _RUDWEB_PRE. "cat_cat as lev".$i1." on (lev".$i.".cat_par = lev".$i1.".cat_id)";
      }
      $query_cats = "SELECT lev".$cat_lev.".cat_id" . $qf1 . " FROM ". _RUDWEB_PRE. "cat_cat AS lev".$cat_lev."" . $qf2 . " WHERE lev".$cat_lev.".cat_id = '".$cat."'";
      $result_cats = rudweb_qres($rudweb_dbtype, $query_cats);
      $cats_row = rudweb_fetch_assoc($rudweb_dbtype, $result_cats);
      
      for($j=0;$j<$cat_lev;$j++) {
        echo $rudweb_skin['catyah']['sep'];
        echo $rudweb_skin['catyah']['pre'];
        restrictedLocalLink('default', $cats_row['cat_tt'.$j.''], _RUDWEB_INDEX_PHP . 'catalog/items/cat/'.$cats_row['cat_id'.$j.''], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['catyah']['suf'];
      }
      echo $rudweb_skin['catyah']['sep'];
      echo $rudweb_skin['catyah']['pre'];
      echo $cat_tt;
      echo $rudweb_skin['catyah']['suf'];
      break;
    }
    case "item" : {
      $query_cat  = "SELECT DISTINCT P.prd_tt, B.cat_id, B.cat_tt, B.cat_lev FROM ". _RUDWEB_PRE. "cat_prd AS P left join ". _RUDWEB_PRE. "cat_cat as B on (B.cat_id = P.cat_id) WHERE P.prd_id = '".$item."' LIMIT 1;";
      $result_cat = rudweb_qres($rudweb_dbtype, $query_cat);
      $cat_row = rudweb_fetch_assoc($rudweb_dbtype, $result_cat);
      $prd_tt  = $cat_row['prd_tt'];
      $cat_id  = $cat_row['cat_id'];
      $cat_tt  = $cat_row['cat_tt'];
      $cat_lev = $cat_row['cat_lev'];
      
      $qf1 = "";
      $qf2 = "";
      
      for($i=$cat_lev;$i>0;$i--) {
        $i1 = $i - 1;
        $qf1 .= " ,lev".$i1.".cat_id AS cat_id".$i1."";
        $qf1 .= " ,lev".$i1.".cat_tt AS cat_tt".$i1."";
        $qf2 .= " left join ". _RUDWEB_PRE. "cat_cat as lev".$i1." on (lev".$i.".cat_par = lev".$i1.".cat_id)";
      }
      $query_cats = "SELECT lev".$cat_lev.".cat_id" . $qf1 . " FROM ". _RUDWEB_PRE. "cat_cat AS lev".$cat_lev."" . $qf2 . " WHERE lev".$cat_lev.".cat_id = '".$cat_id."'";
      $result_cats = rudweb_qres($rudweb_dbtype, $query_cats);
      $cats_row = rudweb_fetch_assoc($rudweb_dbtype, $result_cats);

      for($j=0;$j<$cat_lev;$j++) {
        echo $rudweb_skin['catyah']['sep'];
        echo $rudweb_skin['catyah']['pre'];
        restrictedLocalLink('default', $cats_row['cat_tt'.$j.''], _RUDWEB_INDEX_PHP . 'catalog/items/cat/'.$cats_row['cat_id'.$j.''], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['catyah']['suf'];
      }
      echo $rudweb_skin['catyah']['sep'];
      echo $rudweb_skin['catyah']['pre'];
      restrictedLocalLink('default', $cat_tt, _RUDWEB_INDEX_PHP . 'catalog/items/cat/'.$cat_id, $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      echo $rudweb_skin['catyah']['suf'];
      
      echo $rudweb_skin['catyah']['sep'];
      echo $rudweb_skin['catyah']['pre'];
      echo $prd_tt;
      echo $rudweb_skin['catyah']['suf'];
      
      break;
    }
    default : {break;}
  }
 
  echo $rudweb_skin['catyah']['ftr'];
  
}
/* ********** ********** ********** CATALOG PAGINATION  ********** ********** ********** */
function catalogPageNavigation($totalitems,$itemspg,$pg,$urlsofar) {
  global $rudweb_ln;
  global $rudweb_skin;
  
  $maxpage = ceil($totalitems/$itemspg);
  
  // FIRST+PREVIOUS
  $prevpage = $pg - 1;
  $first = $rudweb_ln['pgnav']['first'];
  $prev = $rudweb_ln['pgnav']['prev'];
  if ($pg > 1) {
    $first = '<A CLASS="default" HREF="'.$urlsofar.'/pg/1/itemspg/'.$itemspg.'">'.$first.'</A>';
    $prev  = '<A CLASS="default" HREF="'.$urlsofar.'/pg/'.$prevpage.'/itemspg/'.$itemspg.'">'.$prev.'</A>';;
  }
  //NEXT+LAST
  $nextpage = $pg + 1;
  $next = $rudweb_ln['pgnav']['next'];
  $last = $rudweb_ln['pgnav']['last'];
  if ($pg < $maxpage) {
    $next = '<A CLASS="default" HREF="'.$urlsofar.'/pg/'.$nextpage.'/itemspg/'.$itemspg.'">'.$next.'</A>';
    $last = '<A CLASS="default" HREF="'.$urlsofar.'/pg/'.$maxpage.'/itemspg/'.$itemspg.'">'.$last.'</A>';
  }

  echo $rudweb_skin['pgnav']['hdr'];
  
  echo $rudweb_skin['pgnav']['pre'];
  echo $first;
  echo $rudweb_skin['pgnav']['suf'];
  echo $rudweb_skin['pgnav']['sep'];
  
  echo $rudweb_skin['pgnav']['pre'];
  echo $prev;
  echo $rudweb_skin['pgnav']['suf'];
  echo $rudweb_skin['pgnav']['sep'];
  
  echo $rudweb_skin['pgnav']['pre'];
  echo $rudweb_ln['pgnav']['page'] . $pg . $rudweb_ln['pgnav']['of'] . $maxpage;
  echo $rudweb_skin['pgnav']['suf'];
  echo $rudweb_skin['pgnav']['sep'];
  
  echo $rudweb_skin['pgnav']['pre'];
  echo $next;
  echo $rudweb_skin['pgnav']['suf'];
  echo $rudweb_skin['pgnav']['sep'];
  
  echo $rudweb_skin['pgnav']['pre'];
  echo $last;
  echo $rudweb_skin['pgnav']['suf'];
  
  echo $rudweb_skin['pgnav']['ftr'];
}
/* ********** ********** ********** //CATALOG PAGINATION  ********** ********** ********** */
/* ********** ********** ********** CATALOG CATEGORIES MENU WITH CUSTOM LINKS  ********** ********** ********** */
function catalogSubcatsMenu($parent, $rep, $link) {
  global $rudweb_dbtype;
  global $rudweb_ln;
  
  $q = "SELECT cat_id, cat_tt FROM ". _RUDWEB_PRE. "cat_cat WHERE cat_par = '".$parent."' ORDER BY cat_ord";
  $r = rudweb_qres($rudweb_dbtype, $q);
  $t = rudweb_qtotal($rudweb_dbtype, $r);
  
  if ($t != 0) {
    echo '<UL STYLE="list-style-type: none; padding-left: 1.5em; text-indent: -1.5em;">';
    for($i=0;$i<$t;$i++) {
      $rw = rudweb_fetch_assoc($rudweb_dbtype, $r);
      echo '<LI>';
      echo '&#187;';
      echo '&#160;';
      restrictedLocalLink('default', $rw['cat_tt'], _RUDWEB_INDEX_PHP . 'admin/'.$link.'/cat/'.$rw['cat_id'], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      catalogSubcatsMenu($rw['cat_id'], $rep+1, $link);
      echo '</LI>';
    }
    echo '</UL>';
  }
}

function catalogCategoriesMenu($link) {
  global $rudweb_dbtype;
  global $rudweb_ln;
  
  $qlev    = "SELECT MAX(cat_lev) FROM ". _RUDWEB_PRE. "cat_cat";
  $resqlev = rudweb_qres($rudweb_dbtype, $qlev);
  $max_lev = rudweb_result($rudweb_dbtype, $resqlev, 0);
  
  $q0 = "SELECT cat_id, cat_tt FROM ". _RUDWEB_PRE. "cat_cat WHERE cat_par = '0' ORDER BY cat_ord";
  $r0 = rudweb_qres($rudweb_dbtype, $q0);
  $t0 = rudweb_qtotal($rudweb_dbtype, $r0);
  
  if($t0 != 0) {
    echo '<UL STYLE="list-style-type: none; padding-left: 1.5em; text-indent: -1.5em;">';
    for ($i=0;$i<$t0;$i++) {
      $rw0 = rudweb_fetch_assoc($rudweb_dbtype, $r0);
      echo '<LI>';
      echo '&#187;';
      echo '&#160;';
      restrictedLocalLink('default', $rw0['cat_tt'], _RUDWEB_INDEX_PHP . 'admin/'.$link.'/cat/'.$rw0['cat_id'], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      catalogSubcatsMenu($rw0['cat_id'], 1, $link);
      echo '</LI>';
    }
    echo '</UL>';
  }
}
/* ********** ********** ********** //CATALOG CATEGORIES MENU WITH CUSTOM LINKS  ********** ********** ********** */
/* ********** ********** ********** CATALOG SPECIAL OFFERS  ********** ********** ********** */
function showCso() {
  global $rudweb_dbtype;
  global $rudweb_ln;
  global $rudweb_skin;
  // CATALOG SPECIAL OFFERS MODULE
  if (_RUDWEB_CFG_CSP_ON === "1") {
    $csp_today = date("Y-m-d");
    
    //$qcsp = "SELECT * FROM "._RUDWEB_PRE."cat_csp WHERE csp_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND ('".$csp_today."' BETWEEN csp_sdate AND csp_edate) ORDER BY csp_ord ASC LIMIT "._RUDWEB_CFG_CSP_LMT."";
    $qcsp = "SELECT "
    . "PC.pic_fn AS picture, "
    . "P.prd_id AS id, "
    . "P.prd_tt AS title, "
    . "P.prd_dsc AS dsc "
    . "FROM "._RUDWEB_PRE."cat_csp AS A "
    . "LEFT JOIN "._RUDWEB_PRE."cat_prd AS P on (P.prd_id = A.prd_id) "
    . "LEFT JOIN "._RUDWEB_PRE."cat_pic AS PC on (PC.prd_id = A.prd_id AND PC.pic_loc = '1') "
    . "WHERE csp_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND (P.prd_tt IS NOT NULL AND ('".$csp_today."' BETWEEN A.csp_sdate AND A.csp_edate)) ORDER BY csp_ord ASC LIMIT "._RUDWEB_CFG_CSP_LMT."";
    
    $rcsp = rudweb_qres($rudweb_dbtype, $qcsp);
    $tcsp = rudweb_qtotal($rudweb_dbtype, $rcsp);
    
    echo $rudweb_skin['csp']['hdr'];
    if($tcsp != 0) {
      for($i=1;$i<=$tcsp;$i++) {
        $rw = rudweb_fetch_assoc($rudweb_dbtype, $rcsp);
        
        echo $rudweb_skin['csp']['pre'];
        
        echo $rudweb_skin['csp']['pic']['pre'];
        if($rw['picture'] != NULL && is_file(_RUDWEB_PRDP_DIR.$rw['picture'])) {
          $picurl = _RUDWEB_LIB_URL.'pic.php?imgfile='._RUDWEB_PRDP_DIR.$rw['picture'].'&amp;max_size='.$rudweb_skin['prod']['picmax'];
        }
        else {
          $picurl = _RUDWEB_LIB_URL.'img.php?pw='.$rudweb_skin['prod']['picmax'].'&amp;ph='.$rudweb_skin['prod']['picmax'].'&amp;txt='.$rudweb_ln['adm']['nopic'];
        }
        echo '<A CLASS="default" HREF="'._RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'catalog/item/id/'.$rw['id'].'" TITLE="'.$rw['title'].'">';
        echo '<IMG CLASS="op" SRC="'.$picurl.'" TITLE="'.$rw['title'].'" ALT="'.$rw['title'].'" onMouseOver="bevisible(this,0)" onMouseOut="bevisible(this,1)">';
        echo '</A>';
        echo $rudweb_skin['csp']['pic']['suf'];
        
        echo $rudweb_skin['csp']['tt']['pre'];
        if (strlen($rw['title']) <= $rudweb_skin['csp']['chartt']) {$short_title = $rw['title'];}
        else {$short_title = str_split($rw['title'], $rudweb_skin['csp']['chartt']); $short_title = $short_title['0'] . ' ...';}
        restrictedLocalLink("csplink", $short_title, _RUDWEB_INDEX_PHP . 'catalog/item/id/' . $rw['id'], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $short_title, $rudweb_ln['WinStatOut'], "_self");
        echo $rudweb_skin['csp']['tt']['suf'];
        
        echo $rudweb_skin['csp']['dsc']['pre'];
        if (strlen($rw['dsc']) <= $rudweb_skin['csp']['chardesc']) {$short_desc = $rw['dsc'];}
        else {$short_desc = str_split($rw['dsc'], $rudweb_skin['csp']['chardesc']); $short_desc = $short_desc['0'] . ' ...';}
        echo $short_desc;
        echo $rudweb_skin['csp']['dsc']['suf'];
        
        echo $rudweb_skin['csp']['suf'];
        
        if ($i < $tcsp) {echo $rudweb_skin['csp']['sep'];}
      }
    }
    else {
      echo $rudweb_ln['cat']['noitems'];
    }
    echo $rudweb_skin['csp']['ftr'];
  }
}
/* ********** ********** ********** //CATALOG SPECIAL OFFERS  ********** ********** ********** */
/* ********** ********** ********** CATALOG DEFAULT ITEMS PER PAGE  ********** ********** ********** */
function setIpg() {
  global $rudweb_dbtype;
  global $rudweb_ln;
  global $rudweb_skin;
  echo $rudweb_skin['adm']['mod']['pre'];
  echo '<FORM ENCTYPE="multipart/form-data" NAME="ipgform" ACTION="" METHOD="post">';
  echo $rudweb_ln['cat']['ipg'];
  echo ':&#160;';
  echo '<SELECT CLASS="forminput" NAME="ipg">';
  for ($i=1; $i<=50; $i++) {
    echo '<OPTION VALUE="'.$i.'"';
    if($i == _RUDWEB_CFG_CAT_IPG) {echo ' SELECTED';}
    echo '>'.$i.'</OPTION>';
  }
  echo '</SELECT>';
  echo '&#160;';
  echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="catmod" VALUE="'.$rudweb_ln['adm']['save'].'">';
  echo '</FORM>';
  echo $rudweb_skin['adm']['mod']['suf'];
}
/* ********** ********** ********** CATALOG NUMBER OF PICTURES TO UPLOAD AT ONCE  ********** ********** ********** */
function setCatPcs() {
  global $rudweb_dbtype;
  global $rudweb_ln;
  global $rudweb_skin;
  echo $rudweb_skin['adm']['mod']['pre'];
  echo '<FORM ENCTYPE="multipart/form-data" NAME="pcsform" ACTION="" METHOD="post">';
  echo $rudweb_ln['cat']['pcs'];
  echo ':&#160;';
  echo '<SELECT CLASS="forminput" NAME="pcs">';
  for ($i=1; $i<=10; $i++) {
    echo '<OPTION VALUE="'.$i.'"';
    if($i == _RUDWEB_CFG_CAT_PCS) {echo ' SELECTED';}
    echo '>'.$i.'</OPTION>';
  }
  echo '</SELECT>';
  echo '&#160;';
  echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="catmod" VALUE="'.$rudweb_ln['adm']['save'].'">';
  echo '</FORM>';
  echo $rudweb_skin['adm']['mod']['suf'];
}
/* ********** ********** ********** //CATALOG SORTING LINKS  ********** ********** ********** */
function catSortLink($sort, $tt, $old_asc) {
  global $rudweb_ln;
  $thiscat = null;
  if(isset($_GET['cat'])) {
    $thiscat = rudweb_filter_input($_GET['cat']); 
    if(isValidInt($thiscat)) {
      if(isset($_GET['asc'])) {
        $old_asc = $_GET['asc'];
      }
      if($old_asc == 1 ) {$asc = 0;}
      else if($old_asc == 0 ) {$asc = 1;}
      restrictedLocalLink('catsort', $tt, _RUDWEB_INDEX_PHP . 'catalog/items/cat/'.$thiscat.'/sort/'.$sort.'/asc/'.$asc, $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
    }
  }
}
/* ********** ********** ********** //CATALOG FILTER BOX  ********** ********** ********** */
function displayFilterBox($di, $dtyp, $dtt, $dt, $urlsofar) {
  global $rudweb_dbtype;
  global $rudweb_ln;
  global $rudweb_skin;
  
  $flb_pid = '';
  if(isset($_POST['id'])) {$flb_pid = rudweb_filter_input($_POST['id']);}
  
  $flb_pname = '';
  if(isset($_POST['kw'])) {$flb_pname = rudweb_filter_input($_POST['kw']);}
  
  echo $rudweb_skin['prod']['flb']['hdr'];
  echo '<FORM ENCTYPE="multipart/form-data" NAME="flb_form" ACTION="'.$urlsofar.'" METHOD="post">';
  
  echo $rudweb_skin['prod']['flb']['pidpre'];
  echo $rudweb_ln['prod']['pid'] . ':<BR>';
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="id" SIZE="10" MAXLENGTH="30" VALUE="'.$flb_pid.'">';
  echo $rudweb_skin['prod']['flb']['pidsuf'];
  
  echo $rudweb_skin['prod']['flb']['pnamepre'];
  echo $rudweb_ln['prod']['pname'] . ':<BR>';
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="kw" SIZE="" MAXLENGTH="150" VALUE="'.$flb_pname.'">';
  echo $rudweb_skin['prod']['flb']['pnamesuf'];
  
  for($i=1;$i<=$dt;$i++) {
    $did = $di[$i];
    $flb_opt_id[$did] = 0;
    if(isset($_POST['opt_id'][$did])) {$flb_opt_id[$did] = rudweb_filter_input($_POST['opt_id'][$did]);}
    $flb_val_tt[$did] = '';
    if(isset($_POST['val_tt'][$did])) {$flb_val_tt[$did] = rudweb_filter_input($_POST['val_tt'][$did]);}
    
    echo $rudweb_skin['prod']['flb']['pdetpre'];
    echo $dtt[$i] . ':<BR>';
    if($dtyp[$i] == 1) {
      $qo = "SELECT opt_id, opt_tt FROM "._RUDWEB_PRE."cat_opt WHERE det_id = '".$di[$i]."' ORDER BY opt_tt ASC";
      $rq = rudweb_qres($rudweb_dbtype, $qo);
      $tq = rudweb_qtotal($rudweb_dbtype, $rq);
      if($tq != 0) {
        echo '<SELECT CLASS="forminput" NAME="opt_id['.$di[$i].']">';
        echo '<OPTION VALUE="0">'.$rudweb_ln['adm']['sel'].'</OPTION>'; 
        for($j=1;$j<=$tq;$j++) {
          $ro = rudweb_fetch_assoc($rudweb_dbtype, $rq);
          $of = '';
          if($flb_opt_id[$did] == $ro['opt_id']) {$of = ' SELECTED';}
          echo '<OPTION VALUE="'.$ro['opt_id'].'"'.$of.'>'.$ro['opt_tt'].'</OPTION>';
        }
        echo '</SELECT>';
      }
    }
    else {
      echo '<INPUT CLASS="forminput" TYPE="text" NAME="val_tt['.$did.']" VALUE="'.$flb_val_tt[$did].'">';
    }
    echo $rudweb_skin['prod']['flb']['pdetsuf'];
  }
  
  //echo $rudweb_skin['prod']['flb']['ppricepre'];
  //echo $rudweb_skin['prod']['flb']['ppricesuf'];
  
  echo $rudweb_skin['prod']['flb']['applypre'];
  echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="filter" VALUE="'.$rudweb_ln['adm']['filter'].'">';
  echo '</FORM>';
  echo '<FORM ENCTYPE="multipart/form-data" NAME="flb_form" ACTION="'.$urlsofar.'" METHOD="post">';
  echo '<INPUT CLASS="formsubmit" STYLE="margin-top: 3px;" TYPE="submit" NAME="filter" VALUE="'.$rudweb_ln['adm']['reset'].'">';
  echo '</FORM>';
  echo $rudweb_skin['prod']['flb']['applysuf'];
  
  echo $rudweb_skin['prod']['flb']['ftr'];
  
}
?>