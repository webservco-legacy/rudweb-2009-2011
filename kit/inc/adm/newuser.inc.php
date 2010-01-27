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
./inc/adm/newuser.inc.php
16:04 2008-04-29
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

?>
<DIV CLASS="title">
<?php echo $rudweb_ln['usr']['newuserreg'];?>
</DIV>
<?php
if($_SESSION[_RUDWEB_PRE.'usr_level'] > 0) {
  echo '<DIV CLASS="text" STYLE="text-align: center;">';
  echo '<BR>';
  echo $rudweb_ln['usr']['alreadyreg'];
  echo '</DIV>';
}
else {
  $usr_first_name  = '';
  $usr_middle_name = '';
  $usr_last_name   = '';

  $usr_phone       = '';
  $usr_address     = '';
  $usr_country     = '';

  $usr_email1      = '';
  $usr_email2      = '';

  $usr_pass1       = '';
  $usr_pass2       = '';

  $usr_lang_index  = $_SESSION[_RUDWEB_PRE.'usr_lang_index'];

  $usr_subscribe   = '1';
  $usr_agree       = '0';

  $usr_verif       = '';

  $err_msg         = '';

  if(isset($_POST['newuser'])) {
    $usr_first_name  = rudweb_filter_input($_POST['usr_first_name']);
    $usr_middle_name = rudweb_filter_input($_POST['usr_middle_name']);
    $usr_last_name   = rudweb_filter_input($_POST['usr_last_name']);

    $usr_phone       = rudweb_filter_input($_POST['usr_phone']);
    $usr_address     = rudweb_filter_input($_POST['usr_address']);
    $usr_country     = rudweb_filter_input($_POST['usr_country']);

    $usr_email1      = rudweb_filter_input($_POST['usr_email1']);
    $usr_email2      = rudweb_filter_input($_POST['usr_email2']);

    $usr_pass1       = rudweb_filter_input($_POST['usr_pass1']);
    $usr_pass2       = rudweb_filter_input($_POST['usr_pass2']);

    $usr_lang_index  = rudweb_filter_input($_POST['usr_lang_index']);

    if(isset($_POST['usr_subscribe'])) {$usr_subscribe = '1';}
    else {$usr_subscribe   = '0';}
    if(isset($_POST['usr_agree']))     {$usr_agree     = '1';}
    else {$usr_agree   = '0';}
  
    $usr_verif       = strtoupper(rudweb_filter_input($_POST['usr_verif']));
    if(isset($_SESSION[_RUDWEB_PRE.'tmpvi'])) {$usr_img_verif = $_SESSION[_RUDWEB_PRE.'tmpvi']; unset($_SESSION[_RUDWEB_PRE.'tmpvi']);}
    $err = "0";
  
    $query_verif_email = 'SELECT usr_id FROM '. _RUDWEB_PRE. 'set_usr WHERE usr_mail = \''.$usr_email1.'\' LIMIT 1';
    $result = rudweb_qres($rudweb_dbtype, $query_verif_email);
    $total_verif_email = rudweb_qtotal($rudweb_dbtype, $result);
    
    $query_verif_email2 = 'SELECT usr_mail FROM '. _RUDWEB_PRE. 'var_reg WHERE usr_mail = \''.$usr_email1.'\' AND usr_auth_mail = \'1\' LIMIT 1';
    $result2 = rudweb_qres($rudweb_dbtype, $query_verif_email2);
    $total_verif_email2 = rudweb_qtotal($rudweb_dbtype, $result2);
    
    $query_verif_email3 = 'SELECT usr_mail FROM '. _RUDWEB_PRE. 'var_reg WHERE usr_mail = \''.$usr_email1.'\' AND usr_auth_mail = \'0\' LIMIT 1';
    $result3 = rudweb_qres($rudweb_dbtype, $query_verif_email3);
    $total_verif_email3 = rudweb_qtotal($rudweb_dbtype, $result3);
    
    if ($usr_first_name == '')                       {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr1'];}
    else if ($usr_last_name == '')                   {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr2'];}
    else if ($usr_country == '')                     {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr3'];}
    else if ($usr_email1 == '' || $usr_email2 == '') {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr4'];}
    else if (!isEmail($usr_email1))                  {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr5'];}
    else if ($usr_email1 !== $usr_email2)            {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr6'];}
    else if ($total_verif_email > '0')               {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr12'];} // user already exists
    else if ($total_verif_email2 > '0')              {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr13'];} // user already applied for account
    else if ($total_verif_email3 > '0')              {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr14'];} // user already applied for account but we could not send activation email
    else if ($usr_pass1 == '' || $usr_pass2 == '')   {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr7'];}
    else if (strlen($usr_pass1) < 6)                 {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr8'];}
    else if ($usr_pass1 !== $usr_pass2)              {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr9'];}
    else if ($usr_agree !== '1')                     {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr10'];}
    else if ($usr_verif != $usr_img_verif)           {$err = '1'; $err_msg = $rudweb_ln['usr']['regerr11']; $usr_verif = '';}
  
    if($err == '0') { // do the thing
      $usr_pass1    = md5($usr_pass1);
      $usr_auth     = md5($_SESSION[_RUDWEB_PRE.'token']);
      $usr_add_date = date("Y-m-d");
    
      $admin_query = "SELECT usr_first_name, usr_last_name, usr_mail FROM "._RUDWEB_PRE."set_usr WHERE usr_id = '1'";
      $admin_result = rudweb_qres($rudweb_dbtype, $admin_query);
      $admin_row    = rudweb_fetch_assoc($rudweb_dbtype, $admin_result);
      $admin_first_name    = $admin_row['usr_first_name'];
      $admin_last_name     = $admin_row['usr_last_name'];
      $admin_email_address = $admin_row['usr_mail'];
    
      require _RUDWEB_LANG_DIR . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . '/usrmail.inc.php';
      
      $to       = $usr_email1;
      $subject  = $rudweb_ln['usr']['actmailsubj'] . ' ' . _RUDWEB_WSTT;
      $message  = '<HTML><BODY>';
      $message .= $rudweb_ln['usr']['actmailtxt1a'];
      $message .= $usr_first_name . " " . $usr_last_name;
      $message .= $rudweb_ln['usr']['actmailtxt1b'];
      $act_lnk  = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'show/actuser/auth/' . $usr_auth;
      $message .= '<A HREF="' . $act_lnk . '">' . $act_lnk . '</A>';
      $message .= $rudweb_ln['usr']['actmailtxt2'];
      $message .= '<B>' . $act_lnk . '</B>';
      $message .= $rudweb_ln['usr']['actmailtxt3'];
      $message .= '</BODY></HTML>';
    
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
      $headers .= 'To: ' . $usr_email1 . "\r\n";
      $headers .= 'From: '. _RUDWEB_WSTT . ' <' . $admin_email_address . '>' . "\r\n";
  
      if (@mail($to, $subject, $message, $headers, '-r '.$admin_email_address)) {
        $auth_mail_sent = '1';
        echo '<DIV CLASS="text" STYLE="text-align: center;">';
        echo $rudweb_ln['usr']['authmessage'];
        echo '</DIV>';
      }
      else {
        $auth_mail_sent = '0';
        echo '<DIV CLASS="text" STYLE="text-align: center;">';
        echo $rudweb_ln['usr']['autherror'];
        echo '</DIV>';
      }
      
      $next_id_query = "SELECT MAX(reg_id) FROM "._RUDWEB_PRE."var_reg";
      $next_id_result = rudweb_qres($rudweb_dbtype, $next_id_query);
      $next_id = rudweb_result($rudweb_dbtype, $next_id_result, 0) + 1;

      $insert_query = "INSERT INTO "._RUDWEB_PRE."var_reg (reg_id, usr_first_name, usr_middle_name, usr_last_name, usr_mail, usr_phone, usr_address, usr_country, usr_pass, usr_lang_index, usr_auth, usr_subscribe, usr_auth_mail, usr_add_date) VALUES ('$next_id', '$usr_first_name', '$usr_middle_name', '$usr_last_name', '$usr_email1', '$usr_phone', '$usr_address', '$usr_country', '$usr_pass1', '$usr_lang_index', '$usr_auth', '$usr_subscribe', '$auth_mail_sent', '$usr_add_date')";
      $insert_result = rudweb_qres($rudweb_dbtype, $insert_query);
      // display thanx for registering message
      //display 'check your email message'
    }
    else if ($err == '1') {
      require_once _RUDWEB_ADMIN_DIR . 'newuserform.inc.php';
    }
  }
  else {
    require_once _RUDWEB_ADMIN_DIR . 'newuserform.inc.php';
  }
} // if user not logged in
?>