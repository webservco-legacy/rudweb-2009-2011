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
./inc/mod/modftr.inc.php
20:02 2008-04-16
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

function showFeatured() {
  global $rudweb_ln;
  global $rudweb_skin;
  // FEATURED MODULE
  if (_RUDWEB_CFG_FTR_ON === "1") {
    echo $rudweb_skin['ftr']['hdr'];
    $ftr_today = date("Y-m-d");
    $query_ftr = "SELECT * FROM "._RUDWEB_PRE."ws_ftr WHERE ftr_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND (ftr_dis = '0' AND ('".$ftr_today."' BETWEEN ftr_sdate AND ftr_edate)) ORDER BY ftr_ord ASC LIMIT "._RUDWEB_CFG_FTR_LMT."";
    $rst_query_ftr = mysql_query($query_ftr) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $total_ftr = mysql_num_rows($rst_query_ftr);
    if ($total_ftr != '0') {
      for ($ftri=1; $ftri<=$total_ftr; $ftri++) {
      $row_rst_ftr[$ftri] = mysql_fetch_assoc($rst_query_ftr);
      
      echo $rudweb_skin['ftr']['fpre'];

      $query_ftr_cnt[$ftri] = "SELECT * FROM `"._RUDWEB_PRE."ws_cnt` WHERE `cnt_id` = '".$row_rst_ftr[$ftri]['cnt_id']."' AND (`cnt_dis` = '0' AND `cnt_ln` = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."') LIMIT 1";
      $rst_query_ftr_cnt[$ftri] = mysql_query($query_ftr_cnt[$ftri]) or require _RUDWEB_LIB_DIR . 'myerr.php';
      if (mysql_num_rows($rst_query_ftr_cnt[$ftri]) != '0') {
        $row_rst_ftr_cnt[$ftri] = mysql_fetch_assoc($rst_query_ftr_cnt[$ftri]);
        
        if (strlen($row_rst_ftr_cnt[$ftri]['cnt_tt']) <= $rudweb_skin['ftr']['chartt']) {$short_title = $row_rst_ftr_cnt[$ftri]['cnt_tt'];}
        else {$short_title = str_split($row_rst_ftr_cnt[$ftri]['cnt_tt'], $rudweb_skin['ftr']['chartt']); $short_title = $short_title['0'] . ' ...';}
      
        echo $rudweb_skin['ftr']['tt']['pre'];
        restrictedLocalLink("ftrlink", $short_title, _RUDWEB_INDEX_PHP . "content/" . $row_rst_ftr_cnt[$ftri]['cnt_alias'], $_SESSION[_RUDWEB_PRE.'usr_level'], $row_rst_ftr[$ftri]['ftr_lvl'], $short_title, $rudweb_ln['WinStatOut'], "_self");
        echo $rudweb_skin['ftr']['tt']['suf'];
        
        echo $rudweb_skin['ftr']['pic']['pre'];
        $query_ftr_pic[$ftri] = "SELECT * FROM `"._RUDWEB_PRE."ws_pic` WHERE `pic_id` = '".$row_rst_ftr[$ftri]['pic_id']."' AND `pic_dis` = '0' LIMIT 1";
        $rst_query_ftr_pic[$ftri] = mysql_query($query_ftr_pic[$ftri]) or require _RUDWEB_LIB_DIR . 'myerr.php';
        if (mysql_num_rows($rst_query_ftr_pic[$ftri]) != '0') {
          $row_rst_ftr_pic[$ftri] = mysql_fetch_assoc($rst_query_ftr_pic[$ftri]);
          $ftr_pic_file[$ftri]   = _RUDWEB_PIC_DIR . $row_rst_ftr_pic[$ftri]['pic_fn'];
          $ftr_pic_url[$ftri]    = _RUDWEB_PIC_URL . $row_rst_ftr_pic[$ftri]['pic_fn'];
          $ftr_pic_tt[$ftri]     = $row_rst_ftr_pic[$ftri]['pic_tt'];
          $ftr_pic_imgsrc[$ftri] = "<IMG SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $ftr_pic_file[$ftri] . "&amp;max_size=".$rudweb_skin['ftr']['picsize']."\" ALT=\"".$ftr_pic_tt[$ftri]."\">";
          restrictedLocalLink("ftrlink", $ftr_pic_imgsrc[$ftri], _RUDWEB_INDEX_PHP . "content/" . $row_rst_ftr_cnt[$ftri]['cnt_alias'], $_SESSION[_RUDWEB_PRE.'usr_level'], $row_rst_ftr[$ftri]['ftr_lvl'], $short_title, $rudweb_ln['WinStatOut'], "_self");
        }
        echo $rudweb_skin['ftr']['pic']['suf'];
        
        if (trim($row_rst_ftr[$ftri]['ftr_sup']) == "") {$short_desc = $rudweb_ln['featured']['desc'];}
        else {
          if (strlen($row_rst_ftr[$ftri]['ftr_sup']) <= $rudweb_skin['ftr']['chardesc']) {$short_desc = $row_rst_ftr[$ftri]['ftr_sup'];}
          else {$short_desc = str_split($row_rst_ftr[$ftri]['ftr_sup'], $rudweb_skin['ftr']['chardesc']); $short_desc = $short_desc['0'] . ' ...';}
        }

        echo $rudweb_skin['ftr']['desc']['pre'];
        restrictedLocalLink("ftrlink", $short_desc, _RUDWEB_INDEX_PHP . "content/" . $row_rst_ftr_cnt[$ftri]['cnt_alias'], $_SESSION[_RUDWEB_PRE.'usr_level'], $row_rst_ftr[$ftri]['ftr_lvl'], $short_title, $rudweb_ln['WinStatOut'], "_self");
        echo $rudweb_skin['ftr']['desc']['suf'];
      }
  
      echo $rudweb_skin['ftr']['fsuf'];

      if ($ftri < $total_ftr) {echo $rudweb_skin['ftr']['sep'];}
      }
    }        
    echo $rudweb_skin['ftr']['ftr'];
  }
}
function showNewFtrForm() {
  global $rudweb_ln;
  global $rudweb_skin;
  global $rudweb_dbtype;
  
  $qc = "SELECT cnt_id, cnt_alias, cnt_tt FROM "._RUDWEB_PRE."ws_cnt WHERE cnt_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND cnt_dis = '0' ORDER BY cnt_alias ASC";
  $rc = rudweb_qres($rudweb_dbtype, $qc);
  $t_c = rudweb_qtotal($rudweb_dbtype, $rc);
  $row_rst_cnt = NULL;
  for ($cnti=1; $cnti<=$t_c; $cnti++) {
    $row_rst_cnt[$cnti] = rudweb_fetch_assoc($rudweb_dbtype, $rc);
  }
  echo $rudweb_skin['adm']['mod']['pre'];
  echo '<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">document.write(getCalendarStyles());</SCRIPT>';
  echo '<FORM ENCTYPE="multipart/form-data" CLASS="ftrnewform" NAME="ftrnewform" ACTION="" METHOD="post">';
  echo '<INPUT TYPE="hidden" NAME="ftr_new" VALUE="1">';
  echo '<SELECT CLASS="forminput" NAME="cnt_id">';
  for ($xcntid=1; $xcntid<=count($row_rst_cnt); $xcntid++) {
    echo '<OPTION VALUE="'.$row_rst_cnt[$xcntid]['cnt_id'].'">'.$row_rst_cnt[$xcntid]['cnt_alias'].'</OPTION>';
  }
  echo '</SELECT>';
  echo '<BR>';
  echo $rudweb_ln['adm']['new_pic'];
  echo "<INPUT CLASS=\"imgupload\" TYPE=\"file\" NAME=\"pcsftrnew\" SIZE=\"1\">";
  echo $rudweb_ln['adm']['ftr_sup'] . "<INPUT CLASS=\"forminput\" TYPE=\"text\" NAME=\"ftr_sup\" MAXLENGTH=\"255\" VALUE=\"\">";
  echo "<BR><BR>";
  echo $rudweb_ln['adm']['ftr_valid'];
  echo '<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">';
  echo 'var calnew = new CalendarPopup("cal_divnew");';
  echo 'calnew.setMonthNames('.$rudweb_ln['adm']['cal_months'].');';
  echo 'calnew.setDayHeaders('.$rudweb_ln['adm']['cal_days'].');';
  echo 'calnew.setWeekStartDay(1);';
  echo 'calnew.setTodayText("'.$rudweb_ln['adm']['cal_today'].'");';
  echo '</SCRIPT>';
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="ftr_sdate" ID="ftr_sdate" SIZE="10" MAXLENGTH="10" VALUE="" onClick="calnew.select(document.forms[\'ftrnewform\'].ftr_sdate,\'ftr_sdate\',\'yyyy-MM-dd\'); return false;">';
  echo '&#160;-&#160;';
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="ftr_edate" ID="ftr_edate" SIZE="10" MAXLENGTH="10" VALUE="" onClick="calnew.select(document.forms[\'ftrnewform\'].ftr_edate,\'ftr_edate\',\'yyyy-MM-dd\'); return false;">';
  echo '<DIV ID="cal_divnew" STYLE="position:absolute;visibility:hidden;background-color:'.$rudweb_skin['BgColor'].';color:'.$rudweb_skin['FontColor'].';"></DIV>';
  echo '<BR><BR>';
  echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="ftrmod" VALUE="'.$rudweb_ln['adm']['add'].'">';
  echo '</FORM>';
  echo $rudweb_skin['adm']['mod']['suf'];
}
?>