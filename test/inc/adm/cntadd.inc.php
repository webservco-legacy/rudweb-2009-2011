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
./inc/adm/cntadd.inc.php
16:24 2008-07-01
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}
if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 3 && (isset($_GET['mc']) && (isset($_GET['ml']) && isset($_GET['mp'])))) {

// menu
//$mnu_id        = ""; // QRY
//$mnu_ln        = ""; // SES
$mnu_cat       = $_GET['mc']; // GET +++
$mnu_lev       = $_GET['ml']; // GET +++
$mnu_par       = $_GET['mp']; // GET +++
//$mnu_ord       = ""; // QRY
$mnu_tt        = ""; // POST +++
//$mnu_typ       = ""; // POST HD +++
//$mnu_cnt_alias = ""; // POST (cnt_tt)
$mnu_trg       = "_self"; // POST +++
//$mnu_crd       = ""; // PHP
//$mnu_crt       = ""; // PHP
//$mnu_cru       = ""; // SES
//$mnu_mdd       = ""; // // 0000-00-00
//$mnu_mdt       = ""; // // 00:00:00
//$mnu_mdu       = ""; // // 0
//$mnu_dis       = ""; // // 0
//$mnu_lvl       = ""; // // 0

// content
//$cnt_id        = ""; // QRY
//$cnt_ln        = ""; // SES
//$cnt_alias     = ""; // POST (cnt_tt)
$cnt_tt        = ""; // POST
$cnt_kw        = ""; // POST
$cnt_dsc       = ""; // POST
$cnt_stt       = ""; // POST
$cnt_txt       = ""; // POST
//$cnt_crd       = ""; // PHP
//$cnt_crt       = ""; // PHP
//$cnt_cru       = ""; // SES
//$cnt_mdd       = ""; // // 0000-00-00
//$cnt_mdt       = ""; // // 00:00:00
//$cnt_mdu       = ""; // // 0
//$cnt_dis       = ""; // // 0
//$cnt_lvl       = ""; // // 0

// link
$lnk_id        = "";
$lnk_ln        = "";
$lnk_alias     = "";
$lnk_cat       = "";
$lnk_tt        = "";
$lnk_url       = "http://";
$lnk_trg       = "_blank";
$lnk_dsc       = "";
$lnk_crd       = "";
$lnk_crt       = "";
$lnk_cru       = "";
$lnk_mdd       = "";
$lnk_mdt       = "";
$lnk_mdu       = "";
$lnk_dis       = "";
$lnk_lvl       = "";

$cnt_tags      = '';
?>
<?php
echo $rudweb_skin['cnt']['hdr'];
echo $rudweb_skin['cnt']['pre'];
?>
<FORM ENCTYPE="multipart/form-data" CLASS="contaddform" NAME="contaddform" ACTION="" METHOD="post">
<DIV CLASS="adm_mod">
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" WIDTH="100%">
<TR>
  <TD CLASS="cnt_adm_txt1">
    <?php echo $rudweb_ln['adm']['mnu_tt'];?>
  </TD>
  <TD CLASS="cnt_adm_txt2">
    <INPUT TYPE="hidden" NAME="mnu_cat" VALUE="<?php echo $mnu_cat;?>">
    <INPUT TYPE="hidden" NAME="mnu_lev" VALUE="<?php echo $mnu_lev;?>">
    <INPUT TYPE="hidden" NAME="mnu_par" VALUE="<?php echo $mnu_par;?>">
    <?php $dostuff = "JavaScript:copyvalue(document.forms['contaddform'].mnu_tt, document.forms['contaddform'].cnt_tt);JavaScript:copyvalue(document.forms['contaddform'].mnu_tt, document.forms['contaddform'].lnk_tt);"; ?>
    <INPUT CLASS="forminput" TYPE="text" NAME="mnu_tt" MAXLENGTH="150" VALUE="<?php echo $mnu_tt;?>" onKeyDown="<?php echo $dostuff; ?>" onKeyUp="<?php echo $dostuff; ?>" onChange="<?php echo $dostuff; ?>">
  </TD>
</TR>
<TR>
  <TD CLASS="cnt_adm_txt1">
    <?php echo $rudweb_ln['adm']['mnu_trg'];?>
  </TD>
  <TD CLASS="cnt_adm_txt2">
    <INPUT CLASS="forminput" TYPE="text" NAME="mnu_trg" MAXLENGTH="8" VALUE="<?php echo $mnu_trg;?>">
  </TD>
</TR>
</TABLE>
</DIV>

<DIV ID="cntaddcntoff" CLASS="hidden">
<DIV STYLE="margin-left: 20px;">
<?php restrictedJsLink("adm-mnu", "[+] ".$rudweb_ln['adm']['new_content'], "JavaScript:toggleLayer('cntaddcnton');toggleLayer('cntaddcntoff');", $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut']); ?>
</DIV>
</DIV>
<DIV ID="cntaddcnton">
<DIV STYLE="margin-left: 20px;">
<?php restrictedJsLink("adm-mnu", "[-] ".$rudweb_ln['adm']['new_content'], "JavaScript:toggleLayer('cntaddcntoff');toggleLayer('cntaddcnton');", $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut']); ?>
</DIV>
<DIV CLASS="adm_mod">
<DIV STYLE="text-align: left; padding: 0px 0px 10px 0px;"><?php echo $rudweb_ln['adm']['pic1']; ?></DIV>
<!-- pics 1 -->
<?php
if (_RUDWEB_CFG_PICS_1 === "1") {
  // NEW PIC
  echo $rudweb_skin['cnt']['pic']['hdr']['1'];
  echo $rudweb_skin['cnt']['pic']['pre']['1'];
  echo $rudweb_ln['adm']['new_pic'];
  echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcscntnew[1]\" SIZE=\"1\">";
  echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"pcscnttmb[1]\" SIZE=\"1\">";
  echo '&#160;' . $rudweb_ln['adm']['pic_tmb'];
  echo $rudweb_skin['cnt']['pic']['suf']['1'];
  echo $rudweb_skin['cnt']['pic']['ftr']['1'];
}
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
<!-- keywords /  description -->
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" WIDTH="100%">
<TR>
  <TD CLASS="cnt_adm_txt1">
    <?php echo $rudweb_ln['adm']['cnt_kw'];?>
  </TD>
  <TD CLASS="cnt_adm_txt2">
    <INPUT CLASS="forminput" TYPE="text" NAME="cnt_kw" MAXLENGTH="255" VALUE="<?php echo $cnt_kw;?>">
  </TD>
</TR>
<TR>
  <TD CLASS="cnt_adm_txt1">
    <?php echo $rudweb_ln['adm']['cnt_dsc'];?>
  </TD>
  <TD CLASS="cnt_adm_txt2">
    <INPUT CLASS="forminput" TYPE="text" NAME="cnt_dsc" MAXLENGTH="255" VALUE="<?php echo $cnt_dsc;?>">
  </TD>
</TR>
</TABLE>
</DIV>

<DIV CLASS="adm_mod">
<DIV STYLE="text-align: left; padding: 0px 0px 10px 0px;"><?php echo $rudweb_ln['adm']['pic2']; ?></DIV>
<!-- pics 2 -->
<?php
if (_RUDWEB_CFG_PICS_2 === "1") {
  // NEW PIC
  echo $rudweb_skin['cnt']['pic']['hdr']['2'];
  echo $rudweb_skin['cnt']['pic']['pre']['2'];
  echo $rudweb_ln['adm']['new_pic'];
  echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcscntnew[2]\" SIZE=\"1\">";
  echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"pcscnttmb[2]\" SIZE=\"1\">";
  echo '&#160;' . $rudweb_ln['adm']['pic_tmb'];
  echo $rudweb_skin['cnt']['pic']['suf']['2'];
  echo $rudweb_skin['cnt']['pic']['ftr']['2'];
}
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
<!-- pics 3 -->
<?php
if (_RUDWEB_CFG_PICS_3 === "1") {
  // NEW PIC
  echo $rudweb_skin['cnt']['pic']['hdr']['3'];
  echo $rudweb_skin['cnt']['pic']['pre']['3'];
  echo $rudweb_ln['adm']['new_pic'];
  echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcscntnew[3]\" SIZE=\"1\">";
  echo "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"pcscnttmb[3]\" SIZE=\"1\">";
  echo '&#160;' . $rudweb_ln['adm']['pic_tmb'];
  echo $rudweb_skin['cnt']['pic']['suf']['3'];
  echo $rudweb_skin['cnt']['pic']['ftr']['3'];
}
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
$oFCKeditor->Height                             = 500;
$oFCKeditor->Value                              = $cnt_txt;
$oFCKeditor->Config['AutoDetectLanguage'] 	    = false;
$oFCKeditor->Config['DefaultLanguage']          = $_SESSION[_RUDWEB_PRE.'usr_lang_index'];
$oFCKeditor->Create();
?>
</DIV>

<DIV CLASS="adm_mod">
<DIV STYLE="text-align: left; padding: 0px 0px 10px 0px;"><?php echo $rudweb_ln['adm']['pic4']; ?></DIV>
<!-- pics 4 -->
<?php
if (_RUDWEB_CFG_PICS_4 === "1") {
  // NEW PIC
  echo $rudweb_skin['cnt']['pic']['hdr']['4'];
  echo $rudweb_skin['cnt']['pic']['pre']['4'];
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
      echo '<SPAN CLASS="tag" onClick="JavaScript: addTag(\''.$r_t['tag'].'\', document.forms[\'contaddform\'].tags)">';
      echo $r_t['tag'];
      echo '</SPAN>';
      echo $rudweb_skin['tagsc']['suf'];
      if ($i != $t_t) {echo ',&#160;';}
    }
  }
  
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="tags" SIZE="50" MAXLENGTH="255" VALUE="'.$cnt_tags.'">';
  echo $rudweb_skin['tagsc']['ftr'];
}
?>
</DIV>

  <DIV CLASS="adm_mod">
  <INPUT CLASS="formsubmit" TYPE="submit" NAME="cntaddcnt" VALUE="<?php echo $rudweb_ln['adm']['cnt_add'];?>">
  </DIV>
</DIV>

<DIV ID="cntaddlnkoff">
<DIV STYLE="margin-left: 20px;">
<?php restrictedJsLink("adm-mnu", "[+] ".$rudweb_ln['adm']['new_link'], "JavaScript:toggleLayer('cntaddlnkon');toggleLayer('cntaddlnkoff');", $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut']); ?>
</DIV>
</DIV>
<DIV ID="cntaddlnkon" CLASS="hidden">
<DIV STYLE="margin-left: 20px;">
<?php restrictedJsLink("adm-mnu", "[-] ".$rudweb_ln['adm']['new_link'], "JavaScript:toggleLayer('cntaddlnkoff');toggleLayer('cntaddlnkon');", $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut']); ?>

<DIV CLASS="adm_mod">
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" WIDTH="100%">
<TR>
  <TD CLASS="cnt_adm_txt1">
    <?php echo $rudweb_ln['adm']['lnk_tt']; ?>
  </TD>
  <TD CLASS="cnt_adm_txt2">
    <INPUT TYPE="hidden" NAME="lnk_cat" VALUE="1">
    <INPUT CLASS="forminput" TYPE="text" NAME="lnk_tt" MAXLENGTH="150" VALUE="<?php echo $lnk_tt;?>">    
  </TD>
</TR>
<TR>
  <TD CLASS="cnt_adm_txt1">
    <?php echo $rudweb_ln['adm']['lnk_url']; ?>
  </TD>
  <TD CLASS="cnt_adm_txt2">
    <INPUT CLASS="forminput" TYPE="text" NAME="lnk_url" MAXLENGTH="150" VALUE="<?php echo $lnk_url;?>">
  </TD>
</TR>
<TR>
  <TD CLASS="cnt_adm_txt1">
    <?php echo $rudweb_ln['adm']['lnk_trg']; ?>
  </TD>
  <TD CLASS="cnt_adm_txt2">
    <INPUT CLASS="forminput" TYPE="text" NAME="lnk_trg" MAXLENGTH="8" VALUE="<?php echo $lnk_trg;?>">
  </TD>
</TR>
<TR>
  <TD CLASS="cnt_adm_txt1">
    <?php echo $rudweb_ln['adm']['lnk_dsc']; ?>
  </TD>
  <TD CLASS="cnt_adm_txt2">
    <INPUT CLASS="forminput" TYPE="text" NAME="lnk_dsc" MAXLENGTH="255" VALUE="<?php echo $lnk_dsc;?>">
  </TD>
</TR>
</TABLE>
</DIV>

  <DIV CLASS="adm_mod">
  <INPUT CLASS="formsubmit" TYPE="submit" NAME="cntaddlnk" VALUE="<?php echo $rudweb_ln['adm']['cnt_add_lnk'];?>">
  </DIV>
</DIV>
</DIV>

<DIV ID="cntaddpgoff">
<DIV STYLE="margin-left: 20px;">
<?php restrictedJsLink("adm-mnu", "[+] ".$rudweb_ln['adm']['new_page'], "JavaScript:toggleLayer('cntaddpgon');toggleLayer('cntaddpgoff');", $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut']); ?>
</DIV>
</DIV>
<DIV ID="cntaddpgon" CLASS="hidden">
<DIV STYLE="margin-left: 20px;">
<?php restrictedJsLink("adm-mnu", "[-] ".$rudweb_ln['adm']['new_page'], "JavaScript:toggleLayer('cntaddpgoff');toggleLayer('cntaddpgon');", $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut']); ?>

<DIV CLASS="adm_mod">
<?php
$page_list = lsfiles(_RUDWEB_PG_DIR, ".inc.php");
if(is_array($page_list)) {
  echo '<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" WIDTH="100%">';
  echo '<TR>';
  echo '<TD CLASS="cnt_adm_txt1">';
  echo $rudweb_ln['adm']['pg_name'];
  echo '</TD>';
  echo '<TD CLASS="cnt_adm_txt2">';
  echo "<SELECT CLASS=\"forminput\" NAME=\"page_tt\">";
  for ($page_i=1; $page_i<=count($page_list); $page_i++) {
    echo "<OPTION VALUE=\"".$page_list[$page_i]."\">".$page_list[$page_i]."</OPTION>";
  }
  echo "</SELECT>";
  echo '</TD>';
  echo '</TR>';
  echo '</TABLE>';
}
else {echo $rudweb_ln['adm']['noitems'];}
?>
</DIV>

  <DIV CLASS="adm_mod">
  <INPUT CLASS="formsubmit" TYPE="submit" NAME="cntaddpg" VALUE="<?php echo $rudweb_ln['adm']['cnt_add_pg'];?>">
  </DIV>
</DIV>
</DIV>
</FORM>
<?php
echo $rudweb_skin['cnt']['suf'];
echo $rudweb_skin['cnt']['ftr'];
?>
<?php
} // if user has the rights
else {
  echo "<DIV CLASS=\"err\">" . $rudweb_ln['err']['1'] . "</DIV>";
} // else if user has no rights
?>