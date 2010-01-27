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
./inc/adm/itemform.inc.php
13:04 2008-07-22
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}
if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 3) {

  echo $rudweb_skin['prod']['dt']['hdr'];
  echo '<FORM ENCTYPE="multipart/form-data" CLASS="itemform" NAME="itemform" ACTION="" METHOD="post">';
  
  echo $rudweb_skin['prod']['dt']['pict0']['pre'];
  
  if($mpic_id != 0 && $mpic_fn != NULL) {
    $pic0url     = _RUDWEB_LIB_URL.'pic.php?imgfile='._RUDWEB_PRDP_DIR.$mpic_fn.'&amp;max_size='.$rudweb_skin['prod']['dt']['picmax'];
    $pic0fileurl = _RUDWEB_PRDP_URL.$mpic_fn;
    
    echo '<A CLASS="default" rel="lightbox[1]" HREF="'.$pic0fileurl.'" TITLE="'.$prd_tt.'">';
    echo '<IMG CLASS="op" SRC="'.$pic0url.'" TITLE="'.$prd_tt.'" ALT="'.$prd_tt.'" onMouseOver="bevisible(this,0)" onMouseOut="bevisible(this,1)">';
    echo '</A>';
    echo '<BR>';
    
    echo '<BR>';
    echo $rudweb_ln['adm']['pic_del'];
    echo '<INPUT CLASS="chk" TYPE="checkbox" NAME="delpic['.$mpic_id.']">';
      
    echo '<BR>';
    echo $rudweb_ln['adm']['pic_repl'];
    echo '<INPUT CLASS="imgupload" TYPE="file" NAME="itemrepl['.$mpic_id.']" SIZE="1">';
  }
  else {
    echo $rudweb_ln['adm']['new_pic'];
    echo '<INPUT CLASS="imgupload" TYPE="file" NAME="itempic[1]" SIZE="1">';
  }

  echo $rudweb_skin['prod']['dt']['pict0']['suf'];
  
  echo $rudweb_skin['prod']['dt']['tt_vl']['pre'];
  echo '<INPUT TYPE="hidden" NAME="prd_id" VALUE="'.$prd_id.'">';
  echo $rudweb_ln['prod']['pname'] . '&#160;:&#160;';
  echo '<INPUT CLASS="forminput" STYLE="background-color: '.$rudweb_skin['BgReqColor'].'" TYPE="text" NAME="prd_tt" MAXLENGTH="150" VALUE="'.$prd_tt.'">';
  echo $rudweb_skin['prod']['dt']['tt_vl']['suf'];
  
  echo $rudweb_skin['prod']['dt']['pid_tt']['pre'];
  echo $rudweb_ln['prod']['pid'];
  echo $rudweb_skin['prod']['dt']['pid_tt']['suf'];
  echo $rudweb_skin['prod']['dt']['pid_vl']['pre'];
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="prd_iid" SIZE="5" MAXLENGTH="30" VALUE="'.$prd_iid.'">';
  echo $rudweb_skin['prod']['dt']['pid_vl']['suf'];
  
  echo $rudweb_skin['prod']['dt']['dsc_tt']['pre'];
  echo $rudweb_ln['prod']['prd_dsc'];
  echo $rudweb_skin['prod']['dt']['dsc_tt']['suf'];
  echo $rudweb_skin['prod']['dt']['dsc_vl']['pre'];
  echo '<TEXTAREA CLASS="forminput" NAME="prd_dsc" ROWS="3" onKeyDown="limitText(this.form.prd_dsc,this.form.prd_dsc_cnt,255);" onKeyUp="limitText(this.form.prd_dsc,this.form.prd_dsc_cnt,255);" onChange="limitText(this.form.prd_dsc,this.form.prd_dsc_cnt,255);">';
  echo $prd_dsc;
  echo '</TEXTAREA>';
  echo '&#160;';
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="prd_dsc_cnt" SIZE="3" MAXLENGTH="3" VALUE="255">';
  echo '&#160;' . $rudweb_ln['adm']['chl'];
  echo $rudweb_skin['prod']['dt']['dsc_vl']['suf'];
  
  for($fi=1;$fi<=$dt;$fi++) {
    $did = $di[$fi];
    echo $rudweb_skin['prod']['dt']['det']['hdr'];
    echo $rudweb_skin['prod']['dt']['det_tt']['pre'];
    echo $dtt[$fi];
    echo $rudweb_skin['prod']['dt']['det_tt']['suf'];
    echo $rudweb_skin['prod']['dt']['det_vl']['pre'];
    echo '<INPUT TYPE="hidden" NAME="val_id['.$did.']" VALUE="'.$val_id[$did].'">';
    if($dtyp[$fi] == '0') {
      $rf1 = '';
      if($dr[$fi] == '1') {$rf1 = ' STYLE="background-color: '.$rudweb_skin['BgReqColor'].';"';}
      echo '<INPUT CLASS="forminput"'.$rf1.' TYPE="text" NAME="val_tt['.$did.']" MAXLENGTH="255" VALUE="'.$val_tt[$did].'">';
    }
    else {
      $qo = "SELECT opt_id, opt_tt FROM ". _RUDWEB_PRE. "cat_opt WHERE det_id = '".$di[$fi]."' ORDER BY opt_ord ASC";
      $ro = rudweb_qres($rudweb_dbtype, $qo);
      $to = rudweb_qtotal($rudweb_dbtype, $ro);
      if($to != '0') {
        echo '<SELECT CLASS="forminput" STYLE="background-color: '.$rudweb_skin['BgReqColor'].'" NAME="opt_id['.$did.']">';
        echo '<OPTION VALUE="0">'.$rudweb_ln['adm']['sel'].'</OPTION>';
        for($fj=1;$fj<=$to;$fj++) {
          $rowo = rudweb_fetch_assoc($rudweb_dbtype, $ro);
          $of = '';
          if($opt_id[$did] == $rowo['opt_id']) {$of = ' SELECTED';}
          echo '<OPTION VALUE="'.$rowo['opt_id'].'"'.$of.'>'.$rowo['opt_tt'].'</OPTION>';
        }
        echo '</SELECT>';
      }
    }
    echo $rudweb_skin['prod']['dt']['det_vl']['suf'];
    echo $rudweb_skin['prod']['dt']['det']['ftr'];
  }
  
  if ($_SESSION[_RUDWEB_PRE.'usr_level'] >= 3) {
    echo $rudweb_skin['prod']['dt']['qty_tt']['pre'];
    echo $rudweb_ln['cat']['quantity'];
    echo $rudweb_skin['prod']['dt']['qty_tt']['suf'];
    echo $rudweb_skin['prod']['dt']['qty_vl']['pre'];
    echo '<INPUT CLASS="forminput" STYLE="text-align: right;" TYPE="text" NAME="prd_qty" SIZE="4" MAXLENGTH="5" VALUE="'.$prd_qty.'">';
    echo '&#160;' . $rudweb_ln['adm']['viewrights'] . ':&#160;';
    echo '<SELECT CLASS="forminput" NAME="prd_qlvl">';
    
    for ($fk=0;$fk<=4;$fk++) {
      $of1[$fk] = '';
      if($prd_qlvl == $fk) {$of1[$fk] = ' SELECTED';}
      echo '<OPTION VALUE="'.$fk.'"'.$of1[$fk].'>'.$rudweb_ln['adm']['lvl'][$fk].'</OPTION>';
    }
    echo '</SELECT>';
    echo $rudweb_skin['prod']['dt']['qty_vl']['suf'];
  }
  
  if ($_SESSION[_RUDWEB_PRE.'usr_level'] >= 3) {
    echo $rudweb_skin['prod']['dt']['prc_tt']['pre'];
    echo $rudweb_ln['prod']['pprice'];
    echo $rudweb_skin['prod']['dt']['prc_tt']['suf'];
    echo $rudweb_skin['prod']['dt']['prc_vl']['pre'];
    echo '<INPUT CLASS="forminput" STYLE="text-align: right;" TYPE="text" NAME="prd_prc" SIZE="4" MAXLENGTH="9" VALUE="'.$prd_prc.'">';
    echo '&#160;' . $rudweb_ln['adm']['viewrights'] . ':&#160;';
    echo '<SELECT CLASS="forminput" NAME="prd_plvl">';
    
    for ($fl=0;$fl<=4;$fl++) {
      $of1[$fl] = '';
      if($prd_plvl == $fl) {$of1[$fl] = ' SELECTED';}
      echo '<OPTION VALUE="'.$fl.'"'.$of1[$fl].'>'.$rudweb_ln['adm']['lvl'][$fl].'</OPTION>';
    }
    echo '</SELECT>';
    echo $rudweb_skin['prod']['dt']['prc_vl']['suf'];
  }
  
  echo $rudweb_skin['prod']['dt']['pic0']['hdr'];
  
  if(isset($item_id)) {
    $qpc = "SELECT pic_id, pic_fn FROM "._RUDWEB_PRE."cat_pic WHERE prd_id = '".$item_id."' AND pic_loc >= '2' ORDER BY pic_ord ASC";
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
        echo '<A CLASS="default" REL="lightbox['.$ip.']" HREF="'.$picurl[$ip].'" TITLE="'.$prd_tt.'">';
        echo $picsrc[$ip];
        echo '</A>';
        echo '<BR>';
        echo $rudweb_ln['adm']['pic_del'];
        echo '<INPUT CLASS="chk" TYPE="checkbox" NAME="delpic['.$rowp['pic_id'].']">';
      
        echo '<BR>';
        echo $rudweb_ln['adm']['pic_repl'];
        echo '<INPUT CLASS="imgupload" TYPE="file" NAME="itemrepl['.$rowp['pic_id'].']" SIZE="1">';
      
        echo $rudweb_skin['prod']['dt']['pic0']['suf'];
        if($ip != $tpc) {echo $rudweb_skin['prod']['dt']['pic0']['sep'];}
      }
    }
  }
  
  echo $rudweb_skin['prod']['dt']['pic0']['pre'];
  echo $rudweb_ln['adm']['new_pic'];
  $iceil = _RUDWEB_CFG_CAT_PCS + 2;
  for($i=2;$i<$iceil;$i++) {
    echo '<INPUT CLASS="imgupload" TYPE="file" NAME="itempic['.$i.']" SIZE="1">';
  }
  echo $rudweb_skin['prod']['dt']['pic0']['suf'];
  
  echo $rudweb_skin['prod']['dt']['pic0']['ftr'];
  
  echo $rudweb_skin['prod']['dt']['form']['pre'];
  if(isset($item_id)) {
    echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="itemmod" VALUE="'.$rudweb_ln['adm']['mod'].'">';
    echo '&#160;&#160;&#160;';
    echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="itemdel" VALUE="'.$rudweb_ln['adm']['del'].'">';
  }
  else {
    echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="itemadd" VALUE="'.$rudweb_ln['adm']['add'].'">';
  }
  echo $rudweb_skin['prod']['dt']['form']['suf'];
  
  echo '</FORM>';
  echo $rudweb_skin['prod']['dt']['ftr'];
}
else {
  echo "<DIV CLASS=\"err\">" . $rudweb_ln['err']['1'] . "</DIV>";
} // else if user has no rights
?>