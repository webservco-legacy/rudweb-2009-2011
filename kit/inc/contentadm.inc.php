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
./inc/contentadm.inc.php
16:24 2008-07-01
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

      // CONTENT
      echo $rudweb_skin['cnt']['hdr'];
      echo $rudweb_skin['cnt']['pre'];
      
      $query_menu = "SELECT * FROM `"._RUDWEB_PRE."ws_mnu` WHERE `mnu_id` = '".$rudweb_mnu_id."' AND (`mnu_dis` = '0' AND `mnu_ln` = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."') LIMIT 1";
      $rst_query_menu = mysql_query($query_menu) or require _RUDWEB_LIB_DIR . 'myerr.php';
      $row_rst_menu = mysql_fetch_assoc($rst_query_menu);
        
      $mnu_tt    = $row_rst_menu['mnu_tt'];
      $mnu_trg   = $row_rst_menu['mnu_trg'];
      $cnt_alias = $row_rst_content['cnt_alias'];
      $cnt_tt    = $row_rst_content['cnt_tt'];
      $cnt_stt   = $row_rst_content['cnt_stt'];
      $cnt_txt   = $row_rst_content['cnt_txt'];
?>
<FORM ENCTYPE="multipart/form-data" CLASS="contmodform" NAME="contmodform" ACTION="" METHOD="post">

<DIV CLASS="adm_mod">
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" WIDTH="100%">
<TR>
  <TD CLASS="cnt_adm_txt1">
    <?php echo $rudweb_ln['adm']['mnu_tt'];?>
  </TD>
  <TD CLASS="cnt_adm_txt2">
    <INPUT TYPE="hidden" NAME="mnu_id" VALUE="<?php echo $rudweb_mnu_id;?>">
    <INPUT CLASS="forminput" TYPE="text" NAME="mnu_tt" MAXLENGTH="150" VALUE="<?php echo $mnu_tt;?>">
  </TD>
</TR>
<TR>
  <TD CLASS="cnt_adm_txt1">
    <?php echo $rudweb_ln['adm']['mnu_trg'];?>
  </TD>
  <TD CLASS="cnt_adm_txt2">
    <INPUT CLASS="forminput" TYPE="text" NAME="mnu_trg" MAXLENGTH="8" VALUE="<?php echo $mnu_trg;?>">
    <INPUT TYPE="hidden" NAME="cnt_id" VALUE="<?php echo $this_content_id;?>">
    <INPUT TYPE="hidden" NAME="cnt_alias" VALUE="<?php echo $cnt_alias;?>">
  </TD>
</TR>
</TABLE>
</DIV>

<DIV CLASS="adm_mod">
<DIV STYLE="text-align: left; padding: 0px 0px 10px 0px;"><?php echo $rudweb_ln['adm']['pic1']; ?></DIV>
<?php      
      // PICTURES 1
      if (_RUDWEB_CFG_PICS_1 === "1") {
        echo $rudweb_skin['cnt']['pic']['hdr']['1'];
        $query_pic1 = "SELECT * FROM `"._RUDWEB_PRE."ws_pic` WHERE `cnt_id` = '".$this_content_id."' AND (`pic_loc` = '1' AND `pic_dis` = '0') ORDER BY `pic_ord` ASC";
        $rst_query_pic1 = mysql_query($query_pic1) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $total_pic1 = mysql_num_rows($rst_query_pic1);
        if ($total_pic1 != '0') {
          for ($pic1i=1; $pic1i<=$total_pic1; $pic1i++) {
            $row_rst_pic1 = mysql_fetch_assoc($rst_query_pic1);
            $pictureFile1[$pic1i]    = _RUDWEB_PIC_DIR . $row_rst_pic1['pic_fn'];
            $pictureFile1url[$pic1i] = _RUDWEB_PIC_URL . $row_rst_pic1['pic_fn'];
            $pictureFile1TT[$pic1i] = $row_rst_pic1['pic_tt'];
            $pic1_imgsrcT[$pic1i] = "<IMG CLASS=\"op\" SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile1[$pic1i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['1']."\" TITLE=\"".$pictureFile1TT[$pic1i]."\" ALT=\"".$pictureFile1TT[$pic1i]."\" onMouseOver=\"bevisible(this,0)\" onMouseOut=\"bevisible(this,1)\">";
            $pic1_imgsrc[$pic1i] = "<IMG SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile1[$pic1i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['1']."\" TITLE=\"".$pictureFile1TT[$pic1i]."\" ALT=\"".$pictureFile1TT[$pic1i]."\">";
            echo $rudweb_skin['cnt']['pic']['pre']['1'];
            if ($row_rst_pic1['pic_tmb'] === '1') {
              echo "<A CLASS=\"default\" rel=\"lightbox[".$row_rst_pic1['pic_loc']."]\" HREF=\"" . $pictureFile1url[$pic1i] . "\" TITLE=\"".$pictureFile1TT[$pic1i]."\">";
              echo $pic1_imgsrcT[$pic1i];
              echo "</A>";
            }
            else {
              echo $pic1_imgsrc[$pic1i];
            }
            echo "<BR>" . $rudweb_ln['adm']['pic_del'];
            echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"delpic[".$row_rst_pic1['pic_id']."]\">";
            echo "<BR>" . $rudweb_ln['adm']['pic_repl'];
            echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcscnt[".$row_rst_pic1['pic_id']."]\" SIZE=\"1\">";
            echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"pcscnttmb[1]\" SIZE=\"1\">";
            echo '&#160;' . $rudweb_ln['adm']['pic_tmb'];
            echo $rudweb_skin['cnt']['pic']['suf']['1'];
            echo $rudweb_skin['cnt']['pic']['sep']['1'];
          }
        }
        // NEW PIC
        echo $rudweb_skin['cnt']['pic']['pre']['1'];
        echo "<BR><BR>";
        echo $rudweb_ln['adm']['new_pic'];
        echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcscntnew[1]\" SIZE=\"1\">";
        echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"pcscnttmb[1]\" SIZE=\"1\">";
        echo '&#160;' . $rudweb_ln['adm']['pic_tmb'];
        echo $rudweb_skin['cnt']['pic']['suf']['1'];
        echo $rudweb_skin['cnt']['pic']['ftr']['1'];
      }

      // TITLE
?>
</DIV>

<DIV CLASS="adm_mod">
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" WIDTH="100%">
<TR>
  <TD CLASS="cnt_adm_txt1">
    <?php echo $rudweb_ln['adm']['cnt_tt']; ?>
  </TD>
  <TD CLASS="cnt_adm_txt2">
    <INPUT CLASS="forminput" TYPE="text" NAME="cnt_tt" SIZE="30" MAXLENGTH="150" VALUE="<?php echo $cnt_tt;?>">
  </TD>
</TR>
</TABLE>
</DIV>

<DIV CLASS="adm_mod">
<DIV STYLE="text-align: left; padding: 0px 0px 10px 0px;"><?php echo $rudweb_ln['adm']['pic2']; ?></DIV>
<?php
      // PICTURES 2
      if (_RUDWEB_CFG_PICS_2 === "1") {
        echo $rudweb_skin['cnt']['pic']['hdr']['2'];
        $query_pic2 = "SELECT * FROM `"._RUDWEB_PRE."ws_pic` WHERE `cnt_id` = '".$this_content_id."' AND (`pic_loc` = '2' AND `pic_dis` = '0') ORDER BY `pic_ord` ASC";
        $rst_query_pic2 = mysql_query($query_pic2) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $total_pic2 = mysql_num_rows($rst_query_pic2);
        if ($total_pic2 != '0') {
          for ($pic2i=1; $pic2i<=$total_pic2; $pic2i++) {
            $row_rst_pic2 = mysql_fetch_assoc($rst_query_pic2);
            $pictureFile2[$pic2i]    = _RUDWEB_PIC_DIR . $row_rst_pic2['pic_fn'];
            $pictureFile2url[$pic2i] = _RUDWEB_PIC_URL . $row_rst_pic2['pic_fn'];
            $pictureFile2TT[$pic2i] = $row_rst_pic2['pic_tt'];
            $pic2_imgsrcT[$pic2i] = "<IMG CLASS=\"op\" SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile2[$pic2i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['2']."\" TITLE=\"".$pictureFile2TT[$pic2i]."\" ALT=\"".$pictureFile2TT[$pic2i]."\" onMouseOver=\"bevisible(this,0)\" onMouseOut=\"bevisible(this,1)\">";
            $pic2_imgsrc[$pic2i] = "<IMG SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile2[$pic2i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['2']."\" TITLE=\"".$pictureFile2TT[$pic2i]."\" ALT=\"".$pictureFile2TT[$pic2i]."\">";
            echo $rudweb_skin['cnt']['pic']['pre']['2'];
            if ($row_rst_pic2['pic_tmb'] === '1') {
              echo "<A CLASS=\"default\" rel=\"lightbox[".$row_rst_pic2['pic_loc']."]\" HREF=\"" . $pictureFile2url[$pic2i] . "\" TITLE=\"".$pictureFile2TT[$pic2i]."\">";
              echo $pic2_imgsrcT[$pic2i];
              echo "</A>";
            }
            else {
              echo $pic2_imgsrc[$pic2i];
            }
            echo "<BR>" . $rudweb_ln['adm']['pic_del'];
            echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"delpic[".$row_rst_pic2['pic_id']."]\">";
            echo "<BR>" . $rudweb_ln['adm']['pic_repl'];
            echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcscnt[".$row_rst_pic2['pic_id']."]\" SIZE=\"1\">";
            echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"pcscnttmb[2]\" SIZE=\"1\">";
            echo '&#160;' . $rudweb_ln['adm']['pic_tmb'];
            echo $rudweb_skin['cnt']['pic']['suf']['2'];
            echo $rudweb_skin['cnt']['pic']['sep']['2'];
          }
        }
        // NEW PIC
        echo $rudweb_skin['cnt']['pic']['pre']['2'];
        echo "<BR><BR>";
        echo $rudweb_ln['adm']['new_pic'];
        echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcscntnew[2]\" SIZE=\"1\">";
        echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"pcscnttmb[2]\" SIZE=\"1\">";
        echo '&#160;' . $rudweb_ln['adm']['pic_tmb'];
        echo $rudweb_skin['cnt']['pic']['suf']['2'];
        echo $rudweb_skin['cnt']['pic']['ftr']['2'];
      }
      
      // SUBTITLE
?>
</DIV>

<DIV CLASS="adm_mod">
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" WIDTH="100%">
<TR>
  <TD CLASS="cnt_adm_txt1">
    <?php echo $rudweb_ln['adm']['cnt_stt']; ?>
  </TD>
  <TD CLASS="cnt_adm_txt2">
    <INPUT CLASS="forminput" TYPE="text" NAME="cnt_stt" SIZE="30" MAXLENGTH="60" VALUE="<?php echo $cnt_stt;?>">
  </TD>
</TR>
</TABLE>
</DIV>

<DIV CLASS="adm_mod">
<DIV STYLE="text-align: left; padding: 0px 0px 10px 0px;"><?php echo $rudweb_ln['adm']['pic3']; ?></DIV>
<?php
      // PICTURES 3
      if (_RUDWEB_CFG_PICS_3 === "1") {
        echo $rudweb_skin['cnt']['pic']['hdr']['3'];
        $query_pic3 = "SELECT * FROM `"._RUDWEB_PRE."ws_pic` WHERE `cnt_id` = '".$this_content_id."' AND (`pic_loc` = '3' AND `pic_dis` = '0') ORDER BY `pic_ord` ASC";
        $rst_query_pic3 = mysql_query($query_pic3) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $total_pic3 = mysql_num_rows($rst_query_pic3);
        if ($total_pic3 != '0') {
          for ($pic3i=1; $pic3i<=$total_pic3; $pic3i++) {
            $row_rst_pic3 = mysql_fetch_assoc($rst_query_pic3);
            $pictureFile3[$pic3i]    = _RUDWEB_PIC_DIR . $row_rst_pic3['pic_fn'];
            $pictureFile3url[$pic3i] = _RUDWEB_PIC_URL . $row_rst_pic3['pic_fn'];
            $pictureFile3TT[$pic3i] = $row_rst_pic3['pic_tt'];
            $pic3_imgsrcT[$pic3i] = "<IMG CLASS=\"op\" SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile3[$pic3i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['3']."\" TITLE=\"".$pictureFile3TT[$pic3i]."\" ALT=\"".$pictureFile3TT[$pic3i]."\" onMouseOver=\"bevisible(this,0)\" onMouseOut=\"bevisible(this,1)\">";
            $pic3_imgsrc[$pic3i] = "<IMG SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile3[$pic3i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['3']."\" TITLE=\"".$pictureFile3TT[$pic3i]."\" ALT=\"".$pictureFile3TT[$pic3i]."\">";
            echo $rudweb_skin['cnt']['pic']['pre']['3'];
            if ($row_rst_pic3['pic_tmb'] === '1') {
              echo "<A CLASS=\"default\" rel=\"lightbox[".$row_rst_pic3['pic_loc']."]\" HREF=\"" . $pictureFile3url[$pic3i] . "\" TITLE=\"".$pictureFile3TT[$pic3i]."\">";
              echo $pic3_imgsrcT[$pic3i];
              echo "</A>";
            }
            else {
              echo $pic3_imgsrc[$pic3i];
            }
            echo "<BR>" . $rudweb_ln['adm']['pic_del'];
            echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"delpic[".$row_rst_pic3['pic_id']."]\">";
            echo "<BR>" . $rudweb_ln['adm']['pic_repl'];
            echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcscnt[".$row_rst_pic3['pic_id']."]\" SIZE=\"1\">";
            echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"pcscnttmb[".$row_rst_pic3['pic_id']."]\" SIZE=\"1\">";
            echo '&#160;' . $rudweb_ln['adm']['pic_tmb'];
            echo $rudweb_skin['cnt']['pic']['suf']['3'];
            echo $rudweb_skin['cnt']['pic']['sep']['3'];
          }
        }
        // NEW PIC
        echo $rudweb_skin['cnt']['pic']['pre']['3'];
        echo "<BR><BR>";
        echo $rudweb_ln['adm']['new_pic'];
        echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcscntnew[3]\" SIZE=\"1\">";
        echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"pcscnttmb[3]\" SIZE=\"1\">";
        echo '&#160;' . $rudweb_ln['adm']['pic_tmb'];
        echo $rudweb_skin['cnt']['pic']['suf']['3'];
        echo $rudweb_skin['cnt']['pic']['ftr']['3'];
      }

      // CONTENT TEXT
?>
</DIV>

<DIV CLASS="adm_mod">
<DIV STYLE="text-align: left; padding: 0px 0px 10px 0px;"><?php echo $rudweb_ln['adm']['cnt_txt']; ?></DIV>
<?php
$oFCKeditor                                     = new FCKeditor('cnt_txt');
$oFCKeditor->BasePath                           = _RUDWEB_LIB_URL .'editor/';
$oFCKeditor->Config['CustomConfigurationsPath'] = _RUDWEB_JS_URL . 'editor.js';
$oFCKeditor->ToolbarSet                         = "rudweb";
$oFCKeditor->Config['SkinPath']                 = _RUDWEB_LIB_URL . 'editor/editor/skins/rudweb/';
$oFCKeditor->Config['EditorAreaCSS']            = _RUDWEB_SKIN_URL . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'] . '/styles/editor.css';
//$oFCKeditor->Width                              = "80%";
$oFCKeditor->Height                             = 500;
$oFCKeditor->Value                              = $cnt_txt;
$oFCKeditor->Config['AutoDetectLanguage'] 	    = false;
$oFCKeditor->Config['DefaultLanguage']          = $_SESSION[_RUDWEB_PRE.'usr_lang_index'];
$oFCKeditor->Create();
?>
</DIV>

<DIV CLASS="adm_mod">
<DIV STYLE="text-align: left; padding: 0px 0px 10px 0px;"><?php echo $rudweb_ln['adm']['pic4']; ?></DIV>
<?php      
      // PICTURES 4
      if (_RUDWEB_CFG_PICS_4 === "1") {
        echo $rudweb_skin['cnt']['pic']['hdr']['4'];
        $query_pic4 = "SELECT * FROM `"._RUDWEB_PRE."ws_pic` WHERE `cnt_id` = '".$this_content_id."' AND (`pic_loc` = '4' AND `pic_dis` = '0') ORDER BY `pic_ord` ASC";
        $rst_query_pic4 = mysql_query($query_pic4) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $total_pic4 = mysql_num_rows($rst_query_pic4);
        if ($total_pic4 != '0') {
          for ($pic4i=1; $pic4i<=$total_pic4; $pic4i++) {
            $row_rst_pic4 = mysql_fetch_assoc($rst_query_pic4);
            $pictureFile4[$pic4i]    = _RUDWEB_PIC_DIR . $row_rst_pic4['pic_fn'];
            $pictureFile4url[$pic4i] = _RUDWEB_PIC_URL . $row_rst_pic4['pic_fn'];
            $pictureFile4TT[$pic4i] = $row_rst_pic4['pic_tt'];
            $pic4_imgsrcT[$pic4i] = "<IMG CLASS=\"op\" SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile4[$pic4i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['4']."\" TITLE=\"".$pictureFile4TT[$pic4i]."\" ALT=\"".$pictureFile4TT[$pic4i]."\" onMouseOver=\"bevisible(this,0)\" onMouseOut=\"bevisible(this,1)\">";
            $pic4_imgsrc[$pic4i] = "<IMG SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile4[$pic4i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['4']."\" TITLE=\"".$pictureFile4TT[$pic4i]."\" ALT=\"".$pictureFile4TT[$pic4i]."\">";
            echo $rudweb_skin['cnt']['pic']['pre']['4'];
            if ($row_rst_pic4['pic_tmb'] === '1') {
              echo "<A CLASS=\"default\" rel=\"lightbox[".$row_rst_pic4['pic_loc']."]\" HREF=\"" . $pictureFile4url[$pic4i] . "\" TITLE=\"".$pictureFile4TT[$pic4i]."\">";
              echo $pic4_imgsrcT[$pic4i];
              echo "</A>";
            }
            else {
              echo $pic4_imgsrc[$pic4i];
            }
            echo "<BR>" . $rudweb_ln['adm']['pic_del'];
            echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"delpic[".$row_rst_pic4['pic_id']."]\">";
            echo "<BR>" . $rudweb_ln['adm']['pic_repl'];
            echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcscnt[".$row_rst_pic4['pic_id']."]\" SIZE=\"1\">";
            echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"pcscnttmb[4]\" SIZE=\"1\">";
            echo '&#160;' . $rudweb_ln['adm']['pic_tmb'];
            echo $rudweb_skin['cnt']['pic']['suf']['4'];
            echo $rudweb_skin['cnt']['pic']['sep']['4'];
          }
        }
        // NEW PIC
        echo $rudweb_skin['cnt']['pic']['pre']['4'];
        echo "<BR><BR>";
        echo $rudweb_ln['adm']['new_pic'];
        echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcscntnew[4]\" SIZE=\"1\">";
        echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"pcscnttmb[4]\" SIZE=\"1\">";
        echo '&#160;' . $rudweb_ln['adm']['pic_tmb'];
        echo $rudweb_skin['cnt']['pic']['suf']['4'];
        echo $rudweb_skin['cnt']['pic']['ftr']['4'];
      }
?>
</DIV>

<DIV CLASS="adm_mod">
<?php
      // TAGS
if (_RUDWEB_CFG_CNT_TAGS === "1") {
  echo $rudweb_skin['tagsc']['hdr'];
  echo '<B>'.$rudweb_ln['cnt']['tags'].'</B><BR>';
  // al tags
  $q_t = "SELECT DISTINCT tag_name AS tag FROM ". _RUDWEB_PRE. "ws_tags ORDER BY tag_name ASC;";
  $rs_t = rudweb_qres($rudweb_dbtype, $q_t);
  $t_t  = rudweb_qtotal($rudweb_dbtype, $rs_t);
  
  if($t_t != 0) {
    echo $rudweb_ln['cnt']['avltags'];
    for($i=1;$i<=$t_t;$i++) {
      $r_t = rudweb_fetch_assoc($rudweb_dbtype, $rs_t);
      echo $rudweb_skin['tagsc']['pre'];
      echo '<SPAN CLASS="tag" onClick="JavaScript: addTag(\''.$r_t['tag'].'\', document.forms[\'contmodform\'].tags)">';
      echo $r_t['tag'];
      echo '</SPAN>';
      echo $rudweb_skin['tagsc']['suf'];
      if ($i != $t_t) {echo ',&#160;';}
    }
  }
  
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="tags" SIZE="50" MAXLENGTH="255" VALUE="'.$cnt_tags.'">';
  echo $rudweb_skin['tagsc']['ftr'];
}
      // FILES
      // XXX

      // LINKS
      // XXX

?>
</DIV>

<DIV CLASS="adm_mod">
<INPUT CLASS="formsubmit" TYPE="submit" NAME="cntmodcnt" VALUE="<?php echo $rudweb_ln['adm']['cnt_mod'];?>">
&#160;
<INPUT CLASS="formsubmit" TYPE="submit" NAME="cntdelcnt" VALUE="<?php echo $rudweb_ln['adm']['cnt_del'];?>">
</DIV>
</FORM>
<?php
      echo $rudweb_skin['cnt']['suf'];
      echo $rudweb_skin['cnt']['ftr'];
     
      // COMMENTS
      // XXX
?>