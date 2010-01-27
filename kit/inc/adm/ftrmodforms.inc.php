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
./inc/adm/ftrmodforms.inc.php
11:40 2008-05-02
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

$query_ftr = "SELECT * FROM "._RUDWEB_PRE."ws_ftr WHERE ftr_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND ftr_dis = '0' ORDER BY ftr_ord ASC";
$rst_query_ftr = mysql_query($query_ftr) or require _RUDWEB_LIB_DIR . 'myerr.php';
$total_ftr = mysql_num_rows($rst_query_ftr);

$qc = "SELECT cnt_id, cnt_alias, cnt_tt FROM "._RUDWEB_PRE."ws_cnt WHERE cnt_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND cnt_dis = '0' ORDER BY cnt_alias ASC";
$rc = rudweb_qres($rudweb_dbtype, $qc);
$t_c = rudweb_qtotal($rudweb_dbtype, $rc);
$row_rst_cnt = NULL;
for ($cnti=1; $cnti<=$t_c; $cnti++) {
  $row_rst_cnt[$cnti] = rudweb_fetch_assoc($rudweb_dbtype, $rc);
}
?>
<?php if ($total_ftr != '0') { ?>
<?php echo $rudweb_skin['adm']['mod']['pre']; ?>
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">document.write(getCalendarStyles());</SCRIPT>
<FORM ENCTYPE="multipart/form-data" CLASS="ftrmodform" NAME="ftrmodform" ACTION="" METHOD="post">
<?php
  for ($ftri=1; $ftri<=$total_ftr; $ftri++) {
    $row_rst_ftr[$ftri] = mysql_fetch_assoc($rst_query_ftr);
?>
    <?php echo $rudweb_skin['adm']['mod']['pre']; ?>
    <INPUT TYPE="hidden" NAME="ftr_id[<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>]" VALUE="<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>">
    <SELECT CLASS="forminput" NAME="cnt_id<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>">
<?php
    for ($cntid=1; $cntid<=count($row_rst_cnt); $cntid++) {
?>    
      <OPTION VALUE="<?php echo $row_rst_cnt[$cntid]['cnt_id'];?>"<?php if($row_rst_cnt[$cntid]['cnt_id'] == $row_rst_ftr[$ftri]['cnt_id']) {echo " SELECTED";}?>><?php echo $row_rst_cnt[$cntid]['cnt_alias'];?></OPTION>
<?php
    }
?>
  </SELECT>
  &#160;
  <INPUT CLASS="forminput" TYPE="text" SIZE="1" MAXLENGTH="1" NAME="ftr_ord<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>" VALUE="<?php echo $row_rst_ftr[$ftri]['ftr_ord'];?>">
  <BR>
<?php
    // PIC
    $query_pic = "SELECT * FROM `"._RUDWEB_PRE."ws_pic` WHERE `pic_id` = '".$row_rst_ftr[$ftri]['pic_id']."' AND (`cnt_id` = '0' AND `pic_dis` = '0')";
    $rst_query_pic = mysql_query($query_pic) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $total_pic = mysql_num_rows($rst_query_pic);
    if ($total_pic != '0') {
      $row_rst_pic = mysql_fetch_assoc($rst_query_pic);
      $pictureFile    = _RUDWEB_PIC_DIR . $row_rst_pic['pic_fn'];
      $pictureFileurl = _RUDWEB_PIC_URL . $row_rst_pic['pic_fn'];
      $pictureFileTT = $row_rst_pic['pic_tt'];
      $pic_imgsrc = "<IMG SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile . "&amp;max_size=".$rudweb_skin['ftr']['picsize']."\" ALT=\"".$pictureFileTT."\">";
      if ($row_rst_pic['pic_tmb'] === '1') {
        echo "<A CLASS=\"default\" rel=\"lightbox[".$row_rst_pic['pic_loc']."]\" HREF=\"" . $pictureFileurl . "\" TITLE=\"".$pictureFileTT."\">";
        echo $pic_imgsrc;
        echo "</A>";
      }
      else {
        echo $pic_imgsrc;
      }
      echo $rudweb_ln['adm']['pic_del'] . "<INPUT CLASS=\"chk\" TYPE=\"checkbox\" NAME=\"delpic".$row_rst_ftr[$ftri]['ftr_id']."\">";
      echo $rudweb_ln['adm']['pic_repl'] . "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcsftrmod".$row_rst_ftr[$ftri]['ftr_id']."\" SIZE=\"1\">";
    }
    else {
      echo $rudweb_ln['adm']['new_pic'];
      echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcsftrnew".$row_rst_ftr[$ftri]['ftr_id']."\" SIZE=\"1\">";
    }
    // PIC
    echo '<BR>';
    // SUP DESC
    echo $rudweb_ln['adm']['ftr_sup'] . "<INPUT CLASS=\"forminput\" TYPE=\"text\" NAME=\"ftr_sup".$row_rst_ftr[$ftri]['ftr_id']."\" MAXLENGTH=\"255\" VALUE=\"".$row_rst_ftr[$ftri]['ftr_sup']."\">";
    echo "<BR><BR>";
    echo $rudweb_ln['adm']['ftr_valid'];
?>
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">
var cal<?php echo $row_rst_ftr[$ftri]['ftr_id'];?> = new CalendarPopup("cal_div<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>");
cal<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>.setMonthNames(<?php echo $rudweb_ln['adm']['cal_months'];?>);
cal<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>.setDayHeaders(<?php echo $rudweb_ln['adm']['cal_days'];?>);
cal<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>.setWeekStartDay(1);
cal<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>.setTodayText("<?php echo $rudweb_ln['adm']['cal_today'];?>");
</SCRIPT>
<INPUT CLASS="forminput" TYPE="text" NAME="ftr_sdate<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>" ID="ftr_sdate<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>" SIZE="10" MAXLENGTH="10" VALUE="<?php echo $row_rst_ftr[$ftri]['ftr_sdate'];?>" onClick="cal<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>.select(document.forms['ftrmodform'].ftr_sdate<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>,'ftr_sdate<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>','yyyy-MM-dd'); return false;">
&#160;-&#160;
<INPUT CLASS="forminput" TYPE="text" NAME="ftr_edate<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>" ID="ftr_edate<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>" SIZE="10" MAXLENGTH="10" VALUE="<?php echo $row_rst_ftr[$ftri]['ftr_edate'];?>" onClick="cal<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>.select(document.forms['ftrmodform'].ftr_edate<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>,'ftr_edate<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>','yyyy-MM-dd'); return false;">
<BR><BR>
<?php echo $rudweb_ln['adm']['ftrdel'];?><INPUT CLASS="chk" TYPE="checkbox" NAME="delftr<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>">

<DIV ID="cal_div<?php echo $row_rst_ftr[$ftri]['ftr_id'];?>" STYLE="position:absolute;visibility:hidden;background-color:<?php echo $rudweb_skin['BgColor'];?>;color:<?php echo $rudweb_skin['FontColor'];?>;"></DIV>
<?php echo $rudweb_skin['adm']['mod']['suf']; ?>
<?php
  } // for
?>
  <BR><BR>
  <INPUT CLASS="formsubmit" TYPE="submit" NAME="ftrmod" VALUE="<?php echo $rudweb_ln['adm']['ftrmod'];?>">
</FORM>
<?php echo $rudweb_skin['adm']['mod']['suf']; ?>
<?php
} // if total != 0
?>