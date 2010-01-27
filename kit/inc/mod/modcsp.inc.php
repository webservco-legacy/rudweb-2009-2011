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
./inc/mod/modcsp.inc.php
20:02 2008-04-16
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

function showNewCspForm() {
  global $rudweb_ln;
  global $rudweb_skin;
  global $rudweb_dbtype;
  
  $q_prd = "SELECT prd_id, prd_tt FROM "._RUDWEB_PRE."cat_prd WHERE prd_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' ORDER BY prd_tt ASC";
  $r_prd = rudweb_qres($rudweb_dbtype, $q_prd);
  $t_prd = rudweb_qtotal($rudweb_dbtype, $r_prd);

  $row_prd = NULL;
  for ($prdi=1; $prdi<=$t_prd; $prdi++) {
    $row_prd[$prdi] = mysql_fetch_assoc($r_prd);
  }
  echo $rudweb_skin['adm']['mod']['pre'];
  echo '<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">document.write(getCalendarStyles());</SCRIPT>';
  echo '<FORM ENCTYPE="multipart/form-data" NAME="cspnewform" ACTION="" METHOD="post">';
  echo '<INPUT TYPE="hidden" NAME="csp_new" VALUE="1">';
  echo '<SELECT CLASS="forminput" NAME="prd_id">';
  for ($xcntid=1; $xcntid<=count($row_prd); $xcntid++) {
    echo '<OPTION VALUE="'.$row_prd[$xcntid]['prd_id'].'">'.$row_prd[$xcntid]['prd_tt'].'</OPTION>';
  }
  echo '</SELECT>';
  echo '<BR>';
  echo $rudweb_ln['adm']['ftr_valid'];
  echo '<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">';
  echo 'var calnew = new CalendarPopup("cal_divnew");';
  echo 'calnew.setMonthNames('.$rudweb_ln['adm']['cal_months'].');';
  echo 'calnew.setDayHeaders('.$rudweb_ln['adm']['cal_days'].');';
  echo 'calnew.setWeekStartDay(1);';
  echo 'calnew.setTodayText("'.$rudweb_ln['adm']['cal_today'].'");';
  echo '</SCRIPT>';
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="csp_sdate" ID="csp_sdate" SIZE="10" MAXLENGTH="10" VALUE="" onClick="calnew.select(document.forms[\'cspnewform\'].csp_sdate,\'csp_sdate\',\'yyyy-MM-dd\'); return false;">';
  echo '&#160;-&#160;';
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="csp_edate" ID="csp_edate" SIZE="10" MAXLENGTH="10" VALUE="" onClick="calnew.select(document.forms[\'cspnewform\'].csp_edate,\'csp_edate\',\'yyyy-MM-dd\'); return false;">';
  echo '<DIV ID="cal_divnew" STYLE="position:absolute;visibility:hidden;background-color:'.$rudweb_skin['BgColor'].';color:'.$rudweb_skin['FontColor'].';"></DIV>';
  echo '<BR><BR>';
  echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="cspmod" VALUE="'.$rudweb_ln['adm']['add'].'">';
  echo '</FORM>';
  echo $rudweb_skin['adm']['mod']['suf'];
}
?>