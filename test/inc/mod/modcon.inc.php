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
./inc/mod/modcon.inc.php
13:05 2008-07-28
*/


/*
15:55 2008-06-30
dropped first_name/last_name as default required field
id: 0806301555
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

function admConCat() {
  global $rudweb_skin;
  global $rudweb_ln;
  global $rudweb_dbtype;
  
  echo $rudweb_skin['adm']['mod']['pre'];
  
  // display all
  $q = "SELECT con_cat_id, con_cat_tt, con_cat_notif3, con_cat_notif4, con_cat_notify, con_cat_send FROM "._RUDWEB_PRE."con_cat WHERE con_cat_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' ORDER BY con_cat_tt ASC";
  $r = rudweb_qres($rudweb_dbtype, $q);
  $t = rudweb_qtotal($rudweb_dbtype, $r);
  if($t != 0) {
    echo '<FORM ENCTYPE="multipart/form-data" NAME="concatform" ACTION="" METHOD="post">';
    echo '<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">';
    echo '<TR>';
    echo '<TD>'.$rudweb_ln['name'].'</TD>';
    echo '<TD>'.$rudweb_ln['con']['not3'].'</TD>';
    echo '<TD>'.$rudweb_ln['con']['not4'].'</TD>';
    echo '<TD>'.$rudweb_ln['con']['notE'].'</TD>';
    echo '<TD>'.$rudweb_ln['con']['sendE'].'</TD>';
    echo '<TD>'.$rudweb_ln['adm']['del'].'</TD>';
  
    echo '</TR>';
    for($i=1;$i<=$t;$i++) {
      $rw = rudweb_fetch_assoc($rudweb_dbtype, $r);
      conCatForm($rw['con_cat_id'], $rw['con_cat_tt'], $rw['con_cat_notif3'], $rw['con_cat_notif4'], $rw['con_cat_notify'], $rw['con_cat_send'], 'model');
    }
    echo '</TABLE>';
    echo '<DIV STYLE="padding: 10px 0px 10px 0px;">';
    echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="con_cat_mod" VALUE="'.$rudweb_ln['adm']['savemod'].'">';
    echo '</DIV>';
    echo '</FORM>';
  }
      
  echo '<FORM ENCTYPE="multipart/form-data" NAME="concatform" ACTION="" METHOD="post">';
  echo '<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">';
  echo '<TR>';
  echo '<TD>'.$rudweb_ln['name'].'</TD>';
  echo '<TD>'.$rudweb_ln['con']['not3'].'</TD>';
  echo '<TD>'.$rudweb_ln['con']['not4'].'</TD>';
  echo '<TD>'.$rudweb_ln['con']['notE'].'</TD>';
  echo '<TD>'.$rudweb_ln['con']['sendE'].'</TD>';
  echo '<TD>'.$rudweb_ln['adm']['add'].'</TD>';
  echo '</TR>';
  
  conCatForm(0, '', 0, 0, '', '', 'add');
  echo '</TABLE>';
  echo '</FORM>';
  
  echo $rudweb_skin['adm']['mod']['suf'];
}

function conCatForm($con_cat_id=0, $con_cat_tt, $con_cat_notif3, $con_cat_notif4, $con_cat_notify, $con_cat_send, $submit='model') {
  global $rudweb_ln;
  
  echo '<TR>';
  
  echo '<TD>';
  echo '<INPUT TYPE="hidden" NAME="admcon" VALUE="1">';
  if ($con_cat_id != 0) {echo '<INPUT TYPE="hidden" NAME="con_cat_id['.$con_cat_id.']" VALUE="'.$con_cat_id.'">';}
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="con_cat_tt['.$con_cat_id.']" SIZE="10" MAXLENGTH="150" VALUE="'.$con_cat_tt.'">';
  echo '</TD>';
  
  echo '<TD>';
  echo '<INPUT CLASS="forminput" TYPE="checkbox" NAME="con_cat_notif3['.$con_cat_id.']"';
  if ($con_cat_notif3 == 1) {echo ' CHECKED';}
  echo '>';
  echo '</TD>';
  
  echo '<TD>';
  echo '<INPUT CLASS="forminput" TYPE="checkbox" NAME="con_cat_notif4['.$con_cat_id.']"';
  if ($con_cat_notif4 == 1) {echo ' CHECKED';}
  echo '>';
  echo '</TD>';
  
  echo '<TD>';
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="con_cat_notify['.$con_cat_id.']" SIZE="10" MAXLENGTH="255" VALUE="'.$con_cat_notify.'">';
  echo '</TD>';
  
  echo '<TD>';
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="con_cat_send['.$con_cat_id.']" SIZE="10" MAXLENGTH="255" VALUE="'.$con_cat_send.'">';
  echo '</TD>';
  
  echo '<TD>';
  switch($submit) {
    case 'model' : {
      echo '<INPUT CLASS="forminput" TYPE="checkbox" NAME="con_cat_del['.$con_cat_id.']">';
      break;
    }
    case 'add' : {
      echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="con_cat_add" VALUE="'.$rudweb_ln['adm']['add'].'">';
      break;
    }
    default : {break;}
  }
  echo '</TD>';
  
  echo '</TR>';
}
/* **************************************************************************** DETAILS ********************************************************************** */
function adminConDet() {
  global $rudweb_skin;
  global $rudweb_ln;
  global $rudweb_dbtype;
  
  echo $rudweb_skin['cnt']['tt2']['pre'];
  echo $rudweb_ln['dets'];
  
  if(isset($_GET['cat'])) {
    $con_cat_id = rudweb_filter_input($_GET['cat']);
    $con_cat_tt = null;
    $q = "SELECT con_cat_tt FROM ". _RUDWEB_PRE. "con_cat WHERE con_cat_id = '".$con_cat_id."' LIMIT 1";
    $r = rudweb_qres($rudweb_dbtype, $q);
    $t = rudweb_qtotal($rudweb_dbtype, $r);
    if($t != 0){
      $con_cat_tt = rudweb_result($rudweb_dbtype, $r, 0);
      echo ' - ' . $con_cat_tt;
      echo $rudweb_skin['cnt']['tt2']['suf'];
      echo $rudweb_skin['cnt']['txt']['pre'];
      admConDet($con_cat_id);
    }
    else {
      echo $rudweb_skin['cnt']['tt2']['suf'];
      echo $rudweb_skin['cnt']['txt']['pre'];
      showMsg('err', $rudweb_ln['err']['3']);
    }
  }
  else {
    // show all categories
    echo $rudweb_skin['cnt']['tt2']['suf'];
    echo $rudweb_skin['cnt']['txt']['pre'];
    conCatMenu('conmod/act/det');
  }
  echo $rudweb_skin['cnt']['txt']['suf'];
}

function conCatMenu($link) {
  global $rudweb_dbtype;
  global $rudweb_ln;
  
  $q = "SELECT con_cat_id, con_cat_tt FROM ". _RUDWEB_PRE. "con_cat WHERE con_cat_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' ORDER BY con_cat_tt ASC";
  $r = rudweb_qres($rudweb_dbtype, $q);
  $t = rudweb_qtotal($rudweb_dbtype, $r);
  
  if($t != 0) {
    echo '<UL STYLE="list-style-type: none; padding-left: 1.5em; text-indent: -1.5em;">';
    for ($i=0;$i<$t;$i++) {
      $rw = rudweb_fetch_assoc($rudweb_dbtype, $r);
      echo '<LI>';
      echo '&#187;';
      echo '&#160;';
      restrictedLocalLink('default', $rw['con_cat_tt'], _RUDWEB_INDEX_PHP . 'admin/'.$link.'/cat/'.$rw['con_cat_id'], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      echo '</LI>';
    }
    echo '</UL>';
  }
  else {showMsg('err', $rudweb_ln['adm']['noitems']);}
}
function conCatMenu2($link) {
  global $rudweb_dbtype;
  global $rudweb_ln;
  
  $q = "SELECT con_cat_id, con_cat_tt FROM ". _RUDWEB_PRE. "con_cat WHERE con_cat_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' ORDER BY con_cat_tt ASC";
  $r = rudweb_qres($rudweb_dbtype, $q);
  $t = rudweb_qtotal($rudweb_dbtype, $r);
  
  $q0 = "SELECT con_id FROM ". _RUDWEB_PRE. "con_con WHERE con_cat_id = '0' AND con_rd = '0000-00-00'";
  $r0 = rudweb_qres($rudweb_dbtype, $q0);
  $t0 = rudweb_qtotal($rudweb_dbtype, $r0);
  
  $q0a = "SELECT con_id FROM ". _RUDWEB_PRE. "con_con WHERE con_cat_id = '0'";
  $r0a = rudweb_qres($rudweb_dbtype, $q0a);
  $t0a = rudweb_qtotal($rudweb_dbtype, $r0a);
  
  if ($t0a != 0 || $t != 0) {
    echo '<UL STYLE="text-align: left; list-style-type: none; padding-left: 1.5em; text-indent: -1.5em; line-height: 160%;">';
  }
  
  if($t0a != 0) {
    echo '<LI>';
    echo '&#187;';
    echo '&#160;';
    restrictedLocalLink('default', $rudweb_ln['con']['general'], _RUDWEB_INDEX_PHP . 'admin/'.$link.'/cat/'.'0', $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
    echo ':&#160;' . $t0a . '&#160' . $rudweb_ln['con']['msgs'] . ' (<B>' . $t0 . '</B>&#160;' . $rudweb_ln['new2']. ')';
    echo '</LI>';
  }
  if($t != 0) {
    for ($i=0;$i<$t;$i++) {
      $rw = rudweb_fetch_assoc($rudweb_dbtype, $r);
      $q2 = "SELECT con_id FROM ". _RUDWEB_PRE. "con_con WHERE con_cat_id = '".$rw['con_cat_id']."' AND con_rd = '0000-00-00'";
      $r2 = rudweb_qres($rudweb_dbtype, $q2);
      $t2[$i] = rudweb_qtotal($rudweb_dbtype, $r2);
      $q3 = "SELECT con_id FROM ". _RUDWEB_PRE. "con_con WHERE con_cat_id = '".$rw['con_cat_id']."'";
      $r3 = rudweb_qres($rudweb_dbtype, $q3);
      $t3[$i] = rudweb_qtotal($rudweb_dbtype, $r3);
      echo '<LI>';
      echo '&#187;';
      echo '&#160;';
      restrictedLocalLink('default', $rw['con_cat_tt'], _RUDWEB_INDEX_PHP . 'admin/'.$link.'/cat/'.$rw['con_cat_id'], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      echo ':&#160;' . $t3[$i] . '&#160' . $rudweb_ln['con']['msgs'] . ' (<B>' . $t2[$i] . '</B>&#160;' . $rudweb_ln['new2']. ')';
      echo '</LI>';
    }
  }
  if ($t0a != 0 || $t != 0) {
    echo '</UL>';
  }
  if ($t0a == 0 && $t == 0) {showMsg('err', $rudweb_ln['adm']['noitems']);}
}

function admConDet($con_cat_id) {
  global $rudweb_skin;
  global $rudweb_ln;
  global $rudweb_dbtype;
  
  echo $rudweb_skin['adm']['mod']['pre'];
  
  // display all
  $q = "SELECT con_det_id, con_det_typ, con_det_tt, con_det_ord, con_det_req FROM "._RUDWEB_PRE."con_det WHERE con_cat_id = '".$con_cat_id."' ORDER BY con_det_ord ASC";
  $r = rudweb_qres($rudweb_dbtype, $q);
  $t = rudweb_qtotal($rudweb_dbtype, $r);
  if($t != 0) {
    echo '<FORM ENCTYPE="multipart/form-data" NAME="condetform" ACTION="" METHOD="post">';
    echo '<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">';
    echo '<TR>';
    echo '<TD>'.$rudweb_ln['type'].'</TD>';
    echo '<TD>'.$rudweb_ln['name'].'</TD>';
    echo '<TD>'.$rudweb_ln['order'].'</TD>';
    echo '<TD>'.$rudweb_ln['req'].'</TD>';
    echo '<TD>'.$rudweb_ln['adm']['del'].'</TD>';
    echo '</TR>';
    for($i=1;$i<=$t;$i++) {
      $rw = rudweb_fetch_assoc($rudweb_dbtype, $r);
      conDetForm($rw['con_det_id'], $con_cat_id, $rw['con_det_typ'], $rw['con_det_tt'], $rw['con_det_ord'], $rw['con_det_req'], 'model');
    }
    echo '</TABLE>';
    echo '<DIV STYLE="padding: 10px 0px 10px 0px;">';
    echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="con_det_mod" VALUE="'.$rudweb_ln['adm']['savemod'].'">';
    echo '</DIV>';
    echo '</FORM>';
  }
      
  echo '<FORM ENCTYPE="multipart/form-data" NAME="condetform" ACTION="" METHOD="post">';
  echo '<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">';
  echo '<TR>';
  echo '<TD>'.$rudweb_ln['type'].'</TD>';
  echo '<TD>'.$rudweb_ln['name'].'</TD>';
  echo '<TD>'.$rudweb_ln['order'].'</TD>';
  echo '<TD>'.$rudweb_ln['req'].'</TD>';
  echo '<TD>'.$rudweb_ln['adm']['add'].'</TD>';
  echo '</TR>';
  
  conDetForm(0, $con_cat_id, 0, '', 0, 0, 'add');
  echo '</TABLE>';
  echo '</FORM>';
  
  echo $rudweb_skin['adm']['mod']['suf'];
}
function conDetForm($con_det_id=0, $con_cat_id, $con_det_typ, $con_det_tt, $con_det_ord, $con_det_req, $submit='model') {
  global $rudweb_ln;
  
  echo '<TR>';
  
  echo '<TD>';
  $seldis = '';
  if($submit == 'model') {$seldis = ' DISABLED';}
  echo '<SELECT CLASS="forminput" NAME="con_det_typ['.$con_det_id.']"'.$seldis.'>';
  echo '<OPTION VALUE="0"';
  if ($con_det_typ == 0) {echo ' SELECTED';}
  echo '>'.$rudweb_ln['text'].'</OPTION>';
  echo '<OPTION VALUE="1"';
  if ($con_det_typ == 1) {echo ' SELECTED';}
  echo '>'.$rudweb_ln['select'].'</OPTION>';
  echo '</SELECT>';
  echo '</TD>';
  
  echo '<TD>';
  echo '<INPUT TYPE="hidden" NAME="admcon" VALUE="1">';
  echo '<INPUT TYPE="hidden" NAME="con_cat_id['.$con_det_id.']" VALUE="'.$con_cat_id.'">';
  if ($con_det_id != 0) {echo '<INPUT TYPE="hidden" NAME="con_det_id['.$con_det_id.']" VALUE="'.$con_det_id.'">';}
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="con_det_tt['.$con_det_id.']" SIZE="10" MAXLENGTH="150" VALUE="'.$con_det_tt.'">';
  echo '</TD>';
  
  echo '<TD>';
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="con_det_ord['.$con_det_id.']" SIZE="2" MAXLENGTH="2" VALUE="'.$con_det_ord.'">';
  echo '</TD>';
  
  echo '<TD>';
  echo '<INPUT CLASS="forminput" TYPE="checkbox" NAME="con_det_req['.$con_det_id.']"';
  if ($con_det_req == 1) {echo ' CHECKED';}
  echo '>';
  echo '</TD>';
  
  echo '<TD>';
  switch($submit) {
    case 'model' : {
      echo '<INPUT CLASS="forminput" TYPE="checkbox" NAME="con_det_del['.$con_det_id.']">';
      break;
    }
    case 'add' : {
      echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="con_det_add" VALUE="'.$rudweb_ln['adm']['add'].'">';
      break;
    }
    default : {break;}
  }
  echo '</TD>';
  
  echo '</TR>';
}
/* **************************************************************************** OPTIONS ********************************************************************** */
function adminConOpt() {
  global $rudweb_skin;
  global $rudweb_ln;
  global $rudweb_dbtype;
  
  echo $rudweb_skin['cnt']['tt2']['pre'];
  echo $rudweb_ln['opts'];
  
  if(isset($_GET['det'])) {
    $con_det_id = rudweb_filter_input($_GET['det']);
    $con_det_tt = null;
    $q = "SELECT con_det_tt FROM ". _RUDWEB_PRE. "con_det WHERE con_det_id = '".$con_det_id."' LIMIT 1";
    $r = rudweb_qres($rudweb_dbtype, $q);
    $t = rudweb_qtotal($rudweb_dbtype, $r);
    if($t != 0){
      $con_det_tt = rudweb_result($rudweb_dbtype, $r, 0);
      echo ' - ' . $con_det_tt;
      echo $rudweb_skin['cnt']['tt2']['suf'];
      echo $rudweb_skin['cnt']['txt']['pre'];
      admConOpt($con_det_id);
    }
    else {
      echo $rudweb_skin['cnt']['tt2']['suf'];
      echo $rudweb_skin['cnt']['txt']['pre'];
      showMsg('err', $rudweb_ln['err']['3']);
    }
  }
  else {
    // show all categories
    echo $rudweb_skin['cnt']['tt2']['suf'];
    echo $rudweb_skin['cnt']['txt']['pre'];
    conDetMenu('conmod/act/opt');
  }
  echo $rudweb_skin['cnt']['txt']['suf'];
}
function conDetMenu($link) {
  global $rudweb_dbtype;
  global $rudweb_ln;
  
  $q = "SELECT B.con_cat_tt, A.con_det_id, A.con_det_tt FROM ". _RUDWEB_PRE. "con_det AS A left join ". _RUDWEB_PRE. "con_cat as B on (A.con_cat_id = B.con_cat_id) WHERE A.con_det_typ = '1' ORDER BY A.con_cat_id ASC, A.con_det_ord ASC";
  $r = rudweb_qres($rudweb_dbtype, $q);
  $t = rudweb_qtotal($rudweb_dbtype, $r);
  
  if($t != 0) {
    echo '<UL STYLE="list-style-type: none; padding-left: 1.5em; text-indent: -1.5em;">';
    for ($i=0;$i<$t;$i++) {
      $rw = rudweb_fetch_assoc($rudweb_dbtype, $r);
      echo '<LI>';
      echo '&#187;';
      echo '&#160;';
      echo $rw['con_cat_tt'];
      echo '&#160;';
      echo '&#187;';
      echo '&#160;';
      restrictedLocalLink('default', $rw['con_det_tt'], _RUDWEB_INDEX_PHP . 'admin/'.$link.'/det/'.$rw['con_det_id'], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      echo '</LI>';
    }
    echo '</UL>';
  }
  else {showMsg('err', $rudweb_ln['adm']['noitems']);}
}
function admConOpt($con_det_id) {
  global $rudweb_skin;
  global $rudweb_ln;
  global $rudweb_dbtype;
  
  echo $rudweb_skin['adm']['mod']['pre'];
  
  // display all
  $q = "SELECT con_opt_id, con_opt_tt, con_opt_ord FROM "._RUDWEB_PRE."con_opt WHERE con_det_id = '".$con_det_id."' ORDER BY con_opt_ord ASC";
  $r = rudweb_qres($rudweb_dbtype, $q);
  $t = rudweb_qtotal($rudweb_dbtype, $r);
  if($t != 0) {
    echo '<FORM ENCTYPE="multipart/form-data" NAME="conoptform" ACTION="" METHOD="post">';
    echo '<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">';
    echo '<TR>';
    echo '<TD>'.$rudweb_ln['name'].'</TD>';
    echo '<TD>'.$rudweb_ln['order'].'</TD>';
    echo '<TD>'.$rudweb_ln['adm']['del'].'</TD>';
    echo '</TR>';
    for($i=1;$i<=$t;$i++) {
      $rw = rudweb_fetch_assoc($rudweb_dbtype, $r);
      conOptForm($rw['con_opt_id'], $con_det_id, $rw['con_opt_tt'], $rw['con_opt_ord'], 'model');
    }
    echo '</TABLE>';
    echo '<DIV STYLE="padding: 10px 0px 10px 0px;">';
    echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="con_opt_mod" VALUE="'.$rudweb_ln['adm']['savemod'].'">';
    echo '</DIV>';
    echo '</FORM>';
  }
      
  echo '<FORM ENCTYPE="multipart/form-data" NAME="conoptform" ACTION="" METHOD="post">';
  echo '<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">';
  echo '<TR>';
  echo '<TD>'.$rudweb_ln['name'].'</TD>';
  echo '<TD>'.$rudweb_ln['order'].'</TD>';
  echo '<TD>'.$rudweb_ln['adm']['add'].'</TD>';
  echo '</TR>';
  
  conOptForm(0, $con_det_id, '', 0, 'add');
  echo '</TABLE>';
  echo '</FORM>';
  
  echo $rudweb_skin['adm']['mod']['suf'];
}
function conOptForm($con_opt_id=0, $con_det_id, $con_opt_tt, $con_opt_ord, $submit='model') {
  global $rudweb_ln;
  
  echo '<TR>';
  
  echo '<TD>';
  echo '<INPUT TYPE="hidden" NAME="admcon" VALUE="1">';
  echo '<INPUT TYPE="hidden" NAME="con_det_id['.$con_opt_id.']" VALUE="'.$con_det_id.'">';
  if ($con_opt_id != 0) {echo '<INPUT TYPE="hidden" NAME="con_opt_id['.$con_opt_id.']" VALUE="'.$con_opt_id.'">';}
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="con_opt_tt['.$con_opt_id.']" SIZE="10" MAXLENGTH="150" VALUE="'.$con_opt_tt.'">';
  echo '</TD>';
  
  echo '<TD>';
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="con_opt_ord['.$con_opt_id.']" SIZE="2" MAXLENGTH="2" VALUE="'.$con_opt_ord.'">';
  echo '</TD>';
  
  echo '<TD>';
  switch($submit) {
    case 'model' : {
      echo '<INPUT CLASS="forminput" TYPE="checkbox" NAME="con_opt_del['.$con_opt_id.']">';
      break;
    }
    case 'add' : {
      echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="con_opt_add" VALUE="'.$rudweb_ln['adm']['add'].'">';
      break;
    }
    default : {break;}
  }
  echo '</TD>';
  
  echo '</TR>';
}
function showContactForm($con_cat_id) {
  global $rudweb_skin;
  global $rudweb_ln;
  global $rudweb_dbtype;
  
  /* 0806301555
  $con_first_name    = '';
  $con_last_name    = '';
  */
  $con_email   = '';
  $con_message = '';
  
  $err = 0;
  $err_msg = null;
  if(isset($_POST['con_send'])) {
    /* 0806301555
    if(isset($_POST['con_first_name'])) {$con_first_name = rudweb_filter_input($_POST['con_first_name']);}
    if(isset($_POST['con_last_name']))  {$con_last_name  = rudweb_filter_input($_POST['con_last_name']);}
    */
    if(isset($_POST['con_email']))      {$con_email      = rudweb_filter_input($_POST['con_email']);}
    if(isset($_POST['con_message']))    {$con_message    = rudweb_filter_input($_POST['con_message']);}
  
    // validate part 1
    /* 0806301555
    if($con_first_name == '')     {$err = 1; $err_msg = $rudweb_ln['usr']['regerr1'];}
    else if($con_last_name == '') {$err = 1; $err_msg = $rudweb_ln['usr']['regerr2'];}
    */
    else if($con_email == '')     {$err = 1; $err_msg = $rudweb_ln['usr']['regerr4'];}
    else if(!isEmail($con_email)) {$err = 1; $err_msg = $rudweb_ln['usr']['regerr5'];}
  }
  $details = 0;
  if($con_cat_id != 0) {
    $q = "SELECT con_det_id, con_det_typ, con_det_tt, con_det_ord, con_det_req FROM "._RUDWEB_PRE."con_det WHERE con_cat_id = '".$con_cat_id."' ORDER BY con_det_ord ASC";
    $r = rudweb_qres($rudweb_dbtype, $q);
    $t = rudweb_qtotal($rudweb_dbtype, $r);
    if($t != 0) {
      $details = 1;
      for($i=1; $i<=$t; $i++) {
        $row1     = rudweb_fetch_assoc($rudweb_dbtype, $r);
        $di[$i]   = $row1['con_det_id']; 
        $dtyp[$i] = $row1['con_det_typ']; 
        $dtt[$i]  = $row1['con_det_tt'];
        $dtr[$i]  = $row1['con_det_req'];
        
        $con_det_val[$di[$i]] = '';
        if(isset($_POST['con_send'])) {
          if(isset($_POST['det'.$di[$i]])) {$con_det_val[$di[$i]] = rudweb_filter_input($_POST['det'.$di[$i]]);}
          // validate part 2
          if ($dtr[$i] == 1 && ($err == 0 && $con_det_val[$di[$i]] == '')) {
            $err = 1;
            if($dtyp[$i] == 0) {$err_msg = $rudweb_ln['err']['itemadd']['3'];}
            else if($dtyp[$i] == 1) {$err_msg = $rudweb_ln['err']['itemadd']['2'];}
          }
        }
      }
      $dt = count($di);
    }
    else {$dt = 0;}
  }

  if(isset($_POST['con_send']) && $err == 0) {
    $action_date  = date("Y-m-d");
    $action_time  = date("H:i:s");
    // INSERT IN DB
    $query_lock = "LOCK TABLES "._RUDWEB_PRE."con_con WRITE, "._RUDWEB_PRE."con_val WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // --- get next id + insert CON_CON
    $con_id = getNextId('con_con', 'con_id');
    /* 0806301555
    $q1 = "INSERT INTO "._RUDWEB_PRE."con_con (con_id, con_ln, con_cat_id, con_first_name, con_last_name, con_email, con_message, con_crd, con_crt, con_rd, con_rt, con_ru, con_sd, con_st, con_su) VALUES ('".$con_id."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$con_cat_id."', '".$con_first_name."', '".$con_last_name."', '".$con_email."', '".$con_message."', '".$action_date."', '".$action_time."', '0000-00-00', '00:00:00', '0', '0000-00-00', '00:00:00', '0')";
    */
    $q1 = "INSERT INTO "._RUDWEB_PRE."con_con (con_id, con_ln, con_cat_id, con_email, con_message, con_crd, con_crt, con_rd, con_rt, con_ru, con_sd, con_st, con_su) VALUES ('".$con_id."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$con_cat_id."', '".$con_email."', '".$con_message."', '".$action_date."', '".$action_time."', '0000-00-00', '00:00:00', '0', '0000-00-00', '00:00:00', '0')";
    mysql_query($q1) or require _RUDWEB_LIB_DIR . 'myerr.php';
    if($con_cat_id != 0) {
      if($t != 0) {
        for ($j=1; $j<=$t; $j++) {
          $con_opt_id = 0;
          $con_val_txt = $con_det_val[$di[$j]];
          if($dtyp[$di[$j]] == 1) {$con_opt_id = $con_det_val[$di[$j]]; $con_val_txt = '';}
          $con_val_id = getNextId('con_val', 'con_val_id');
          $q = "INSERT INTO "._RUDWEB_PRE."con_val (con_val_id, con_id, con_det_id, con_opt_id, con_val_txt) VALUES ('".$con_val_id."', '".$con_id."', '".$di[$j]."', '".$con_opt_id."', '".$con_val_txt."')";
          mysql_query($q) or require _RUDWEB_LIB_DIR . 'myerr.php';
        }
      }
    }
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    
    $qc = "SELECT con_cat_notif3, con_cat_notif4, con_cat_notify, con_cat_send FROM "._RUDWEB_PRE."con_cat WHERE con_cat_id = '".$con_cat_id."' LIMIT 1";
    $rc = rudweb_qres($rudweb_dbtype, $qc);
    $tc = rudweb_qtotal($rudweb_dbtype, $rc);
    $con_cat_notif3 = 0; $con_cat_notif4 = 0; $con_cat_notify = ''; $con_cat_send = '';
    if($tc == 1) {
      $rwc = rudweb_fetch_assoc($rudweb_dbtype, $rc);
      $con_cat_notif3 = $rwc['con_cat_notif3'];
      $con_cat_notif4 = $rwc['con_cat_notif4'];
      $con_cat_notify = $rwc['con_cat_notify'];
      $con_cat_send   = $rwc['con_cat_send'];
    }
    $rw3 = array();
    if($con_cat_notif3 == 1) {
      $q3 = "SELECT usr_mail FROM "._RUDWEB_PRE."set_usr WHERE usr_level = '3'";
      $r3 = rudweb_qres($rudweb_dbtype, $q3);
      $t3 = rudweb_qtotal($rudweb_dbtype, $r3);
      
      if($t3 != 0) {
        $rw3 = rudweb_fetch_assoc($rudweb_dbtype, $r3);
        // array cu mailurile level 3 - array1
      }
    }
    $rw4 = array();
    if($con_cat_notif4 == 1) {
      $q4 = "SELECT usr_mail FROM "._RUDWEB_PRE."set_usr WHERE usr_level = '4'";
      $r4 = rudweb_qres($rudweb_dbtype, $q4);
      $t4 = rudweb_qtotal($rudweb_dbtype, $r4);
      
      if($t4 != 0) {
        $rw4 = rudweb_fetch_assoc($rudweb_dbtype, $r4);
        // array cu mailurile level 4 - array2
      }
    }
    $rwf = array();
    if($con_cat_notify != '') {
      $con_cat_notify = trim($con_cat_notify);
      $con_cat_notify = eregi_replace(' ', '', $con_cat_notify);
      $rwf = explode(',', $con_cat_notify);
      $rwf = array_diff($rwf, array(''));
    }
    //merge notification arrays
    $notif_array = $rw3 + $rw4 + $rwf;
    $notif_array = array_unique($notif_array);
    // send array
    $send_array = array();
    if($con_cat_send != '') {
      $con_cat_send = trim($con_cat_send);
      $con_cat_send = eregi_replace(' ', '', $con_cat_send);
      $rws = explode(',', $con_cat_send);
      $rws = array_diff($rws, array(''));
      $send_array = array_unique($rws);
    }
    // get admin data
    $admin_query = "SELECT usr_first_name, usr_last_name, usr_mail FROM "._RUDWEB_PRE."set_usr WHERE usr_id = '1'";
    $admin_result = rudweb_qres($rudweb_dbtype, $admin_query);
    $admin_row    = rudweb_fetch_assoc($rudweb_dbtype, $admin_result);
    $admin_first_name    = $admin_row['usr_first_name'];
    $admin_last_name     = $admin_row['usr_last_name'];
    $admin_email_address = $admin_row['usr_mail'];
    
    require _RUDWEB_LANG_DIR . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . '/usrmail.inc.php';
    
    // --- send notification email
    $t_notif_array = count($notif_array);
    if($t_notif_array != 0) {
      $notif_subject  = $rudweb_ln['conm']['notify_subject'];
      $notif_message  = $rudweb_ln['conm']['notify_txt1'];
      $notif_message .= $rudweb_ln['conm']['notify_txt2'];
      $notif_message .= $action_date . ' ' . $action_time;
      $notif_message .= $rudweb_ln['conm']['notify_txt3'];
      $notif_message .= $rudweb_ln['conm']['notify_txt4'];
      for($tn=0; $tn<$t_notif_array; $tn++) {
        if (isEmail($notif_array[$tn])) {
          $notif_to[$tn]       = $notif_array[$tn];
          $notif_headers[$tn]  = 'MIME-Version: 1.0' . "\n";
          $notif_headers[$tn] .= 'Content-type: text/html; charset=utf-8' . "\n";
          $notif_headers[$tn] .= 'To: ' . $notif_array[$tn] . "\n";
          $notif_headers[$tn] .= 'From: ' . _RUDWEB_WSTT . ' <' . $admin_email_address . '>' . "\n";
          $notif_headers[$tn] .= 'Reply-To: ' . _RUDWEB_WSTT . ' <' . $admin_email_address . '>' . "\n";
          mail($notif_to[$tn], $notif_subject, $notif_message, $notif_headers[$tn]);
        }
      }
    }
    // --- send email
    $t_send_array = count($send_array);
    if($t_send_array != 0) {
      $send_subject  = $rudweb_ln['conm']['send_subject'];
      $send_message  = $rudweb_ln['conm']['send_txt1'];
      $send_message .= $rudweb_ln['conm']['send_txt2'];
      $send_message .= $action_date . ' ' . $action_time;
      $send_message .= $rudweb_ln['conm']['send_txt3'];
      /* 0806301555
      $send_message .= '<BR>' . $rudweb_ln['usr']['usrfirstname'];
      $send_message .= ': ' . $con_first_name;
      $send_message .= '<BR>' . $rudweb_ln['usr']['usrlastname'];
      $send_message .= ': ' . $con_last_name;
      */
      $send_message .= '<BR>' . $rudweb_ln['con']['email'] ;
      $send_message .= ': ' . $con_email;
      // custom details
      if($con_cat_id != 0) {
        if($t != 0) {
          for ($k=1; $k<=$t; $k++) {
            $con_opt_id = 0;
            $con_val_txt = $con_det_val[$di[$k]];
            if($dtyp[$di[$k]] == 1) {
              $con_opt_id = $con_det_val[$di[$k]]; ;
              $qo = "SELECT con_opt_tt FROM ". _RUDWEB_PRE. "con_opt WHERE con_opt_id = '".$con_opt_id."' LIMIT 1";
              $ro = rudweb_qres($rudweb_dbtype, $qo);
              $to = rudweb_qtotal($rudweb_dbtype, $ro);
              $rowo = rudweb_fetch_assoc($rudweb_dbtype, $ro);
              $con_val_txt = $rowo['con_opt_tt'];
            }
            $send_message .= '<BR>' . $dtt[$k];
            $send_message .= ': ' . $con_val_txt;
          }
        }
      }
      $send_message .= '<BR>' . $rudweb_ln['con']['msg'];
      $send_message .= ': ' . $con_message;
      $send_message .= $rudweb_ln['conm']['send_txt4'];
      for($ts=0; $ts<$t_send_array; $ts++) {
        if (isEmail($send_array[$ts])) {
          $send_to[$ts]       = $send_array[$ts];
          $send_headers[$ts]  = 'MIME-Version: 1.0' . "\n";
          $send_headers[$ts] .= 'Content-type: text/html; charset=utf-8' . "\n";
          $send_headers[$ts] .= 'To: ' . $send_array[$ts] . "\n";
          $send_headers[$ts] .= 'From: ' . _RUDWEB_WSTT . ' <' . $admin_email_address . '>' . "\n";
          $send_headers[$ts] .= 'Reply-To: ' . _RUDWEB_WSTT . ' <' . $admin_email_address . '>' . "\n";
          mail($send_to[$ts], $send_subject, $send_message, $send_headers[$ts]);
        }
      }
    }
    // DISPLAY OK MESSAGE
    echo '<DIV CLASS="ok">' . $rudweb_ln['conm']['ok_mesage'] . '</DIV>';
    // xxx
  }
  else if((isset($_POST['con_send']) && $err == 1) || (!isset($_POST['con_send']) && $err == 0)) {
    
    if (isset($_POST['con_send']) && $err == 1) {
      echo '<DIV CLASS="err">' . $err_msg . '</DIV>';
    }
    
    echo $rudweb_skin['con']['hdr'];
    echo '<FORM ENCTYPE="multipart/form-data" NAME="contactform" ACTION="" METHOD="post">';
    
    /* 0806301555
    // first name
    echo $rudweb_skin['con']['lpre'];
    echo $rudweb_ln['usr']['usrfirstname'];
    echo $rudweb_skin['con']['lsuf'];
    echo $rudweb_skin['con']['fpre'];
    echo '<INPUT CLASS="forminput" STYLE="background-color: '.$rudweb_skin['BgReqColor'].'" TYPE="text" NAME="con_first_name" SIZE="30" MAXLENGTH="255" VALUE="'.$con_first_name.'">';
    echo '&#160;&#42;';
    echo $rudweb_skin['con']['fsuf'];
    
    // last name
    echo $rudweb_skin['con']['lpre'];
    echo $rudweb_ln['usr']['usrlastname'];
    echo $rudweb_skin['con']['lsuf'];
    echo $rudweb_skin['con']['fpre'];
    echo '<INPUT CLASS="forminput" STYLE="background-color: '.$rudweb_skin['BgReqColor'].'" TYPE="text" NAME="con_last_name" SIZE="30" MAXLENGTH="255" VALUE="'.$con_last_name.'">';
    echo '&#160;&#42;';
    echo $rudweb_skin['con']['fsuf'];
    */
    
    // email
    echo $rudweb_skin['con']['lpre'];
    echo $rudweb_ln['con']['email'];
    echo $rudweb_skin['con']['lsuf'];
    echo $rudweb_skin['con']['fpre'];
    echo '<INPUT CLASS="forminput" STYLE="background-color: '.$rudweb_skin['BgReqColor'].'" TYPE="text" NAME="con_email" SIZE="30" MAXLENGTH="255" VALUE="'.$con_email.'">';
    echo '&#160;&#42;';
    echo $rudweb_skin['con']['fsuf'];
    
    // custom details
    if($details == 1) {
      for($j=1;$j<=$dt;$j++) {
        $con_det_id = $di[$j];
        $con_det_typ = $dtyp[$j];
        $con_det_tt = $dtt[$j];
        $con_det_req = $dtr[$j];
       
        echo $rudweb_skin['con']['lpre'];
        echo $con_det_tt;
        echo $rudweb_skin['con']['lsuf'];
        echo $rudweb_skin['con']['fpre'];
        
        //$con_det_val[$con_det_id] = '';
        //if(isset($_POST['det'.$con_det_id])) {$con_det_val[$con_det_id] = rudweb_filter_input($_POST['det'.$con_det_id]);}
        
        $det_req1 = '';$det_req2 = '';
        if($con_det_req == 1) {$det_req1 = ' STYLE="background-color: '.$rudweb_skin['BgReqColor'].'"'; $det_req2 = '&#160;&#42;';}
        if($con_det_typ == 0) {echo '<INPUT CLASS="forminput"'.$det_req1.' TYPE="text" NAME="det'.$con_det_id.'" SIZE="30" MAXLENGTH="255" VALUE="'.$con_det_val[$con_det_id].'">' . $det_req2;}
        else if ($con_det_typ == 1) {
        
          $qo = "SELECT con_opt_id, con_opt_tt FROM ". _RUDWEB_PRE. "con_opt WHERE con_det_id = '".$con_det_id."' ORDER BY con_opt_ord ASC";
          $ro = rudweb_qres($rudweb_dbtype, $qo);
          $to = rudweb_qtotal($rudweb_dbtype, $ro);
          if($to != '0') {
            echo '<SELECT CLASS="forminput"'.$det_req1.' NAME="det'.$con_det_id.'">';
            echo '<OPTION VALUE="">'.$rudweb_ln['adm']['sel'].'</OPTION>';
            for($fj=1;$fj<=$to;$fj++) {
              $rowo = rudweb_fetch_assoc($rudweb_dbtype, $ro);
              $of = '';
              if($con_det_val[$con_det_id] == $rowo['con_opt_id']) {$of = ' SELECTED';}
              echo '<OPTION VALUE="'.$rowo['con_opt_id'].'"'.$of.'>'.$rowo['con_opt_tt'].'</OPTION>';
            }
            echo '</SELECT>';
            echo $det_req2;
          }
        }
        echo $rudweb_skin['con']['fsuf'];     
      }
    }
    
    // message
    echo $rudweb_skin['con']['lpre'];
    echo $rudweb_ln['con']['msg'];
    echo $rudweb_skin['con']['lsuf'];
    echo $rudweb_skin['con']['fpre'];
    
    echo '<TEXTAREA CLASS="forminput" NAME="con_message" COLS="30" ROWS="3" onKeyDown="limitText(this.form.con_message,this.form.con_message_cnt,255);" onKeyUp="limitText(this.form.con_message,this.form.con_message_cnt,255);" onChange="limitText(this.form.con_message,this.form.con_message_cnt,255);">';
    echo $con_message;
    echo '</TEXTAREA>';
    echo '&#160;';
    echo '<INPUT CLASS="forminput" TYPE="text" NAME="con_message_cnt" SIZE="3" MAXLENGTH="3" VALUE="255">';
    echo '&#160;' . $rudweb_ln['adm']['chl'];
    
    echo $rudweb_skin['con']['fsuf'];
    
    // submit buttons
    echo $rudweb_skin['con']['bpre'];
    echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="con_send" VALUE="'.$rudweb_ln['send'].'">';
    echo '&#160;';
    echo '<INPUT CLASS="formsubmit" TYPE="reset" NAME="con_reset" VALUE="'.$rudweb_ln['reset'].'">';
    echo $rudweb_skin['con']['bsuf'];
    
    echo '</FORM>';
    echo $rudweb_skin['con']['ftr'];
  } // end else if error
}
/* **************************************************************************** SHOW MESSAGES ********************************************************************** */
function adminConMsgsMenu() {
  global $rudweb_skin;
  global $rudweb_ln;
  global $rudweb_dbtype;
  
  echo $rudweb_skin['cnt']['tt2']['pre'];
  echo $rudweb_ln['con']['msgs'];
  
  if(isset($_GET['cat'])) {
    $con_cat_id = rudweb_filter_input($_GET['cat']);
    $con_cat_tt = null;
    if($con_cat_id == 0) {
      $con_cat_tt = $rudweb_ln['con']['general'];
      echo ' - ' . $con_cat_tt;
      echo $rudweb_skin['cnt']['tt2']['suf'];
      echo $rudweb_skin['cnt']['txt']['pre'];
      adminConMsgsShow($con_cat_id);
      echo $rudweb_skin['adm']['mod']['pre'];
      echo '<A CLASS="con_msgs_lnk" HREF="' . _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmod/view/msgs' . '">' . $rudweb_ln['con']['amsg'] . '</A>';
      echo $rudweb_skin['adm']['mod']['suf'];
    }
    else {
      $q = "SELECT con_cat_tt FROM ". _RUDWEB_PRE. "con_cat WHERE con_cat_id = '".$con_cat_id."' LIMIT 1";
      $r = rudweb_qres($rudweb_dbtype, $q);
      $t = rudweb_qtotal($rudweb_dbtype, $r);
      if($t != 0){
        $con_cat_tt = rudweb_result($rudweb_dbtype, $r, 0);
        echo ' - ' . $con_cat_tt;
        echo $rudweb_skin['cnt']['tt2']['suf'];
        echo $rudweb_skin['cnt']['txt']['pre'];
        adminConMsgsShow($con_cat_id);
        echo $rudweb_skin['adm']['mod']['pre'];
        echo '<A CLASS="con_msgs_lnk" HREF="' . _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmod/view/msgs' . '">' . $rudweb_ln['con']['amsg'] . '</A>';
        echo $rudweb_skin['adm']['mod']['suf'];
      }
      else {
        echo $rudweb_skin['cnt']['tt2']['suf'];
        echo $rudweb_skin['cnt']['txt']['pre'];
        showMsg('err', $rudweb_ln['err']['3']);
      }
    }
  }
  else {
    // show all categories
    echo $rudweb_skin['cnt']['tt2']['suf'];
    echo $rudweb_skin['cnt']['txt']['pre'];
    echo $rudweb_skin['adm']['mod']['pre'];
    conCatMenu2('conmod/view/msgs');
    echo $rudweb_skin['adm']['mod']['suf'];
  }
  echo $rudweb_skin['cnt']['txt']['suf'];
}
function adminConMsgsShow($con_cat_id) {
  global $rudweb_skin;
  global $rudweb_ln;
  global $rudweb_dbtype;
  
  echo $rudweb_skin['adm']['mod']['pre'];
  
  // display all
  /* 0806301555
  $q = "SELECT con_id, con_first_name, con_last_name, con_email, con_message, con_crd, con_crt, con_rd, con_rt, con_ru, con_sd, con_st, con_su FROM "._RUDWEB_PRE."con_con WHERE con_cat_id = '".$con_cat_id."' ORDER BY con_crd DESC, con_crt DESC";
  */
  $q = "SELECT con_id, con_email, con_message, con_crd, con_crt, con_rd, con_rt, con_ru, con_sd, con_st, con_su FROM "._RUDWEB_PRE."con_con WHERE con_cat_id = '".$con_cat_id."' ORDER BY con_crd DESC, con_crt DESC";
  $r = rudweb_qres($rudweb_dbtype, $q);
  $t = rudweb_qtotal($rudweb_dbtype, $r);
  if($t != 0) {
    echo '<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">';
    echo '<TR>';
    echo '<TD CLASS="con_msgs_hdr">' . $rudweb_ln['number'] . '</TD>';
    echo '<TD CLASS="con_msgs_hdr">' . $rudweb_ln['date'] . '</TD>';
    
  /* 0806301555
    //echo '<TD CLASS="con_msgs_hdr">' . $rudweb_ln['con']['name'] . '</TD>';
    */
    echo '<TD CLASS="con_msgs_hdr">' . $rudweb_ln['email'] . '</TD>';
    echo '<TD CLASS="con_msgs_hdr">' . $rudweb_ln['read'] . '</TD>';
    echo '<TD CLASS="con_msgs_hdr">' . $rudweb_ln['solved'] . '</TD>';
    echo '</TR>';
    for($i=1;$i<=$t;$i++) {
      $rw = rudweb_fetch_assoc($rudweb_dbtype, $r);
      $con_rd[$i] = '---';
      if($rw['con_rd'] != '0000-00-00') {$con_rd[$i] = $rw['con_rd'];}
      $con_sd[$i] = '---';
      if($rw['con_sd'] != '0000-00-00') {$con_sd[$i] = $rw['con_sd'];}
      $tr_style = 'con_msgs_new';
      if($rw['con_sd'] != '0000-00-00') {$tr_style = 'con_msgs_solved';}
      else if($rw['con_rd'] != '0000-00-00') {$tr_style = 'con_msgs_read';}
      else if($rw['con_sd'] == '0000-00-00' && $rw['con_rd'] == '0000-00-00') {$tr_style = 'con_msgs_new';}
      echo '<TR>';
      echo '<TD CLASS="'.$tr_style.'">' . $i . '</TD>';
      echo '<TD CLASS="'.$tr_style.'">' . '<A CLASS="con_msgs_lnk" HREF="'. _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmod/view/msg/con/' . $rw['con_id'] .'">' . $rw['con_crd'] . ' ' .$rw['con_crt'] . '</A>' . '</TD>';
      /* 0806301555
      echo '<TD CLASS="'.$tr_style.'">' . $rw['con_first_name'] . ' ' . $rw['con_last_name'] . '</TD>';
      */
      echo '<TD CLASS="'.$tr_style.'">' . $rw['con_email'] . '</TD>';
      echo '<TD CLASS="'.$tr_style.'">' . $con_rd[$i] . '</TD>';
      echo '<TD CLASS="'.$tr_style.'">' . $con_sd[$i] . '</TD>';
      echo '</TR>';
    }
    echo '</TABLE>';
  }
  else {showMsg('err', $rudweb_ln['adm']['noitems']);}
  
  echo $rudweb_skin['adm']['mod']['suf'];

}
function adminConMsg() {
  global $rudweb_skin;
  global $rudweb_ln;
  global $rudweb_dbtype;
  
  echo $rudweb_skin['cnt']['tt2']['pre'];
  echo $rudweb_ln['con']['msg'];
  
  if(isset($_GET['con'])) {
    $con_id = rudweb_filter_input($_GET['con']);
    $con_date_time = null;
   
    $qr = "SELECT con_rd FROM "._RUDWEB_PRE."con_con WHERE con_id = '".$con_id."' LIMIT 1";
    $rr = rudweb_qres($rudweb_dbtype, $qr);
    $tr = rudweb_qtotal($rudweb_dbtype, $rr);
    if($tr != 0) {
      $con_rd = rudweb_result($rudweb_dbtype, $rr, 0);
      if($con_rd == '0000-00-00') {
        $action_date  = date("Y-m-d");
        $action_time  = date("H:i:s");
        $query_lock = "LOCK TABLES "._RUDWEB_PRE."con_con WRITE";
        mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $q1 = "UPDATE "._RUDWEB_PRE."con_con SET con_rd = '".$action_date."', con_rt = '".$action_time."', con_ru = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE con_id = '".$con_id."' LIMIT 1";
        mysql_query($q1) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $q2 = "OPTIMIZE TABLE "._RUDWEB_PRE."con_con";
        mysql_query($q2) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $query_unlock = "UNLOCK TABLES";
        mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
      }
    }
 
    $q = "SELECT * FROM ". _RUDWEB_PRE. "con_con WHERE con_id = '".$con_id."' LIMIT 1";
    $r = rudweb_qres($rudweb_dbtype, $q);
    $t = rudweb_qtotal($rudweb_dbtype, $r);
    if($t != 0) {
      $rw = rudweb_fetch_assoc($rudweb_dbtype, $r);
      
      $con_date_time = $rw['con_crd'] . ' ' . $rw['con_crt'];
      echo ' - ' . $con_date_time;
      echo $rudweb_skin['cnt']['tt2']['suf'];
      echo $rudweb_skin['cnt']['txt']['pre'];
      
      echo $rudweb_skin['adm']['mod']['pre'];
      
      echo '<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" ALIGN="center">';
      
      /* 0806301555
      echo '<TR><TD>';
      echo $rudweb_ln['con']['name'];
      echo '</TD><TD>';
      echo $rw['con_first_name'] . ' ' . $rw['con_last_name'];
      echo '</TD></TR>';
      */
      
      echo '<TR><TD>';
      echo $rudweb_ln['email'];
      echo '</TD><TD>';
      echo $rw['con_email'];
      echo '</TD></TR>';
      
      $qd = "SELECT con_det_id, con_det_typ, con_det_tt FROM "._RUDWEB_PRE."con_det WHERE con_cat_id = '".$rw['con_cat_id']."' ORDER BY con_det_ord ASC";
      $rd = rudweb_qres($rudweb_dbtype, $qd);
      $td = rudweb_qtotal($rudweb_dbtype, $rd);
      
      if($td != 0) {
        for($i=1; $i<=$td; $i++) {
          $row1 = rudweb_fetch_assoc($rudweb_dbtype, $rd);
          echo '<TR><TD>';
          echo $row1['con_det_tt'];
          echo '</TD><TD>';
          $con_val_txt = '';
          if($row1['con_det_typ'] == 1) {
            $qv = "SELECT t2.con_opt_tt AS con_val_txt FROM "._RUDWEB_PRE."con_opt AS t2 LEFT JOIN "._RUDWEB_PRE."con_val AS t1 ON (t1.con_opt_id = t2.con_opt_id) WHERE t1.con_id = '".$rw['con_id']."' AND t1.con_det_id = '".$row1['con_det_id']."'";
          }
          else {
            $qv = "SELECT con_val_txt FROM "._RUDWEB_PRE."con_val WHERE con_id = '".$rw['con_id']."' AND con_det_id = '".$row1['con_det_id']."' LIMIT 1";
          }
          $rv = rudweb_qres($rudweb_dbtype, $qv);
          $tv = rudweb_qtotal($rudweb_dbtype, $rv);
          if($tv != 0) {$con_val_txt = rudweb_result($rudweb_dbtype, $rv, 0);}
          echo $con_val_txt;
          echo '</TD></TR>';
        }
      }
      
      echo '<TR><TD>';
      echo $rudweb_ln['con']['msg'];
      echo '</TD><TD>';
      echo $rw['con_message'];
      echo '</TD></TR>';
      
      echo '<TR><TD COLSPAN="2">';
      $qp  = "SELECT usr_first_name, usr_last_name FROM "._RUDWEB_PRE."set_usr WHERE usr_id = '".$rw['con_ru']."' LIMIT 1";
      $rp  = rudweb_qres($rudweb_dbtype, $qp);
      $rwp = rudweb_fetch_assoc($rudweb_dbtype, $rp);
      $read_alias = $rwp['usr_first_name'] . ' ' . $rwp['usr_last_name'];
      echo $rudweb_ln['con']['frby'];
      echo $read_alias . $rudweb_ln['blg']['on'] . MyDate($rw['con_rd'], 'dd/mm/yyyy') . ' ' . $rw['con_rt'];
      echo '</TD></TR>';
      
      echo '<TR><TD COLSPAN="2">';
      if($rw['con_sd'] != '0000-00-00') {
        $qs  = "SELECT usr_first_name, usr_last_name FROM "._RUDWEB_PRE."set_usr WHERE usr_id = '".$rw['con_su']."' LIMIT 1";
        $rs  = rudweb_qres($rudweb_dbtype, $qs);
        $rws = rudweb_fetch_assoc($rudweb_dbtype, $rs);
        $solved_alias = $rws['usr_first_name'] . ' ' . $rws['usr_last_name'];
        echo $rudweb_ln['con']['sby'];
        echo $solved_alias . $rudweb_ln['blg']['on'] . MyDate($rw['con_sd'], 'dd/mm/yyyy') . ' ' . $rw['con_st'];
      }
      else {
      echo '<FORM ENCTYPE="multipart/form-data" NAME="conmsgform1" ACTION="" METHOD="post">';
      echo '<INPUT TYPE="hidden" NAME="admcon" VALUE="1">';
      echo '<INPUT TYPE="hidden" NAME="con_id" VALUE="'.$rw['con_id'].'">';
      echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="con_msg_solve" VALUE="'.$rudweb_ln['con']['sets'].'">';
      echo '</FORM>';
      }
      echo '</TD></TR>';
      
      echo '<TR><TD COLSPAN="2">';
      echo '<FORM ENCTYPE="multipart/form-data" NAME="conmsgform2" ACTION="" METHOD="post">';
      echo '<INPUT TYPE="hidden" NAME="admcon" VALUE="1">';
      echo '<INPUT TYPE="hidden" NAME="con_id" VALUE="'.$rw['con_id'].'">';
      echo '<INPUT TYPE="hidden" NAME="con_cat_id" VALUE="'.$rw['con_cat_id'].'">';
      echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="con_msg_del" VALUE="'.$rudweb_ln['adm']['del'].'">';
      echo '</FORM>';
      echo '</TD></TR>';
      
      echo '</TABLE>';
      echo $rudweb_skin['adm']['mod']['suf'];
      
      echo $rudweb_skin['adm']['mod']['pre'];
      echo '<A CLASS="con_msgs_lnk" HREF="' . _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/conmod/view/msgs/cat/' . $rw['con_cat_id'] . '">' . $rudweb_ln['con']['amsg'] . '</A>';
      echo $rudweb_skin['adm']['mod']['suf'];
    }
    else {
      echo $rudweb_skin['cnt']['tt2']['suf'];
      echo $rudweb_skin['cnt']['txt']['pre'];
      showMsg('err', $rudweb_ln['err']['3']);
    }
  }
  else {
    echo $rudweb_skin['cnt']['tt2']['suf'];
    echo $rudweb_skin['cnt']['txt']['pre'];
    showMsg('err', $rudweb_ln['err']['1']);
  }
  echo $rudweb_skin['cnt']['txt']['suf'];
}
?>