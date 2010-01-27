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
./inc/adm/lostpass.inc.php
12:50 2008-04-05
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

?>
<DIV CLASS="title">
<?php echo $rudweb_ln['usr']['lostpass'];?>
</DIV>
<?php
if($_SESSION[_RUDWEB_PRE.'usr_level'] > 0) {
  echo '<DIV CLASS="text" STYLE="text-align: center;">';
  echo '<BR>';
  echo $rudweb_ln['usr']['alreadyreg'];
  echo '</DIV>';
}
else {
  require _RUDWEB_LANG_DIR . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . '/usrmail.inc.php';
  if(isset($_GET['auth'])) {
    $ve_auth = rudweb_filter_input($_GET['auth']);
    
    $yesterday  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
    
    $query_va = "SELECT * FROM "._RUDWEB_PRE."var_pas WHERE usr_auth = '$ve_auth' AND usr_add_date >= '$yesterday' LIMIT 1";
    $result_va = rudweb_qres($rudweb_dbtype, $query_va);
    $total_results_va = rudweb_qtotal($rudweb_dbtype, $result_va);
    
    if ($total_results_va == '0') {
      echo '<DIV CLASS="text" STYLE="text-align: center;">';
      echo '<BR>';
      echo $rudweb_ln['usr']['lpaerror1'];
      echo '<BR>';
      echo $rudweb_ln['usr']['lpaerror2'];
      echo '</DIV>';
    }
    else {
      $authrow = rudweb_fetch_assoc($rudweb_dbtype, $result_va);
      if(isset($_POST['newpass']) && (strlen(rudweb_filter_input($_POST['usr_pass1'])) >= 6 && rudweb_filter_input($_POST['usr_pass1']) == rudweb_filter_input($_POST['usr_pass2']))) {
        $usr_pass1 = rudweb_filter_input($_POST['usr_pass1']);
        $usr_pass2 = rudweb_filter_input($_POST['usr_pass2']);
        $usr_pass1 = md5($usr_pass1);
        $today = date("Y-m-d");
      
        $uq1        = "UPDATE "._RUDWEB_PRE."set_usr SET usr_pass = '".$usr_pass1."' WHERE usr_mail = '".$authrow['usr_mail']."' LIMIT 1";
        $result_uq1 = rudweb_qres($rudweb_dbtype, $uq1);
        
        $uq2        = "UPDATE "._RUDWEB_PRE."var_pas SET usr_rst_date = '".$today."', usr_auth = '' WHERE usr_mail = '".$authrow['usr_mail']."' AND usr_auth = '".$ve_auth."' LIMIT 1";
        $result_uq2 = rudweb_qres($rudweb_dbtype, $uq2);
        
        echo '<DIV CLASS="text" STYLE="text-align: center;">';
        echo $rudweb_ln['usr']['lostpassoka'];
        echo $rudweb_ln['usr']['lostpassokb'];
        echo '</DIV>';
      }
      else {
          echo '<DIV CLASS="text" STYLE="text-align: center;">';
          echo '<BR>';
          echo $rudweb_ln['usr']['lostpass2'];
          echo '<BR><BR>';
          echo '<FORM ENCTYPE="multipart/form-data" CLASS="contaddform" NAME="lostpass2" ACTION="" METHOD="post">';
?>      
      <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="5" ALIGN="center">
      <TR>
        <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usrpass1'];?>:</TD>
        <TD STYLE="text-align: left;">
          <INPUT CLASS="forminput" TYPE="password" NAME="usr_pass1" SIZE="20" MAXLENGTH="30" VALUE="">
          &#160;&#42;
        </TD>
      </TR>
      <TR>
        <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usrpass2'];?>:</TD>
        <TD STYLE="text-align: left;">
          <INPUT CLASS="forminput" TYPE="password" NAME="usr_pass2" SIZE="20" MAXLENGTH="30" VALUE="">
          &#160;&#42;
        </TD>
      </TR>
      <TR>
        <TD STYLE="text-align: right;"><BR></TD>
        <TD STYLE="text-align: left;"></TD>
      </TR>
      <TR>
        <TD STYLE="text-align: right;"></TD>
        <TD STYLE="text-align: left;"><INPUT CLASS="formsubmit" TYPE="submit" NAME="newpass" VALUE="<?php echo $rudweb_ln['usr']['lostpsubmit'] ;?>"></TD>
      </TR>
      </TABLE>
<?php      
          echo '</FORM>';
          echo '</DIV>'; 
      }
    }
  }
  else {
    if (isset($_POST['lostpass_mail']) && ($_POST['lostpass_mail'] != '') && isEmail($_POST['lostpass_mail'])) {
      $ve_addr = rudweb_filter_input($_POST['lostpass_mail']);
      $query_ve = "SELECT * FROM "._RUDWEB_PRE."set_usr WHERE usr_mail = '$ve_addr' LIMIT 1";
      $result_ve = rudweb_qres($rudweb_dbtype, $query_ve);
      $total_results_ve = rudweb_qtotal($rudweb_dbtype, $result_ve);
      if ($total_results_ve != '1') {
        echo '<DIV CLASS="text" STYLE="text-align: center;">';
        echo '<BR>';
        echo $rudweb_ln['usr']['lostapsserr'];
        echo '</DIV>';
      }
      else {
        $usr_auth = md5($_SESSION[_RUDWEB_PRE.'token']);
        $usr_add_date = date("Y-m-d");
    
        $admin_query = "SELECT usr_first_name, usr_last_name, usr_mail FROM "._RUDWEB_PRE."set_usr WHERE usr_id = '1'";
        $admin_result = rudweb_qres($rudweb_dbtype, $admin_query);
        $admin_row    = rudweb_fetch_assoc($rudweb_dbtype, $admin_result);
        $admin_first_name    = $admin_row['usr_first_name'];
        $admin_last_name     = $admin_row['usr_last_name'];
        $admin_email_address = $admin_row['usr_mail'];
        
        $user_row    = rudweb_fetch_assoc($rudweb_dbtype, $result_ve);
        $usr_first_name    = $user_row['usr_first_name'];
        $usr_last_name     = $user_row['usr_last_name'];
        
        $to       = $ve_addr;
        $subject  = $rudweb_ln['usr']['lpmailsubj']  . ' ' . _RUDWEB_WSTT;
        $message  = '<HTML><BODY>';
        $message .= $rudweb_ln['usr']['lpmailtxt1a'];
        $message .= $usr_first_name . " " . $usr_last_name;
        $message .= $rudweb_ln['usr']['lpmailtxt1b'];
        $act_lnk  = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'show/lostpass/auth/' . $usr_auth;
        $message .= '<A HREF="' . $act_lnk . '">' . $act_lnk . '</A>';
        $message .= $rudweb_ln['usr']['lpmailtxt2'];
        $message .= '<B>' . $act_lnk . '</B>';
        $message .= $rudweb_ln['usr']['lpmailtxt3'];
        $message .= '</BODY></HTML>';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'To: ' . $ve_addr . "\r\n";
        $headers .= 'From: '.$admin_first_name . ' ' . $admin_last_name . ' <' . $admin_email_address . '>' . "\r\n";
        
        if (@mail($to, $subject, $message, $headers, '-r '.$admin_email_address)) {
          $lp_mail_sent = '1';
          echo '<DIV CLASS="text" STYLE="text-align: center;">';
          echo $rudweb_ln['usr']['lostpmessage'];
          echo '</DIV>';
        }
        else {
          $lp_mail_sent = '0';
          echo '<DIV CLASS="text" STYLE="text-align: center;">';
          echo $rudweb_ln['usr']['lostperror'];
          echo '</DIV>';
        }
        $next_id_query = "SELECT MAX(pas_id) FROM "._RUDWEB_PRE."var_pas";
        $next_id_result = rudweb_qres($rudweb_dbtype, $next_id_query);
        $next_id = rudweb_result($rudweb_dbtype, $next_id_result, 0) + 1;

        $insert_query = "INSERT INTO "._RUDWEB_PRE."var_pas (pas_id, usr_mail, usr_auth, usr_auth_mail, usr_add_date, usr_rst_date) VALUES ('$next_id', '$ve_addr', '$usr_auth', '$lp_mail_sent', '$usr_add_date', '0000-00-00')";
        $insert_result = rudweb_qres($rudweb_dbtype, $insert_query);
      }
    }
    else {
      echo '<DIV CLASS="text" STYLE="text-align: center;">';
      echo '<BR>';
      echo $rudweb_ln['usr']['lostpass1'];
      echo '<BR><BR>';
      echo '<FORM ENCTYPE="multipart/form-data" CLASS="contaddform" NAME="lostpass1" ACTION="" METHOD="post">';
      echo '<INPUT CLASS="forminput" TYPE="text" NAME="lostpass_mail" SIZE="20" MAXLENGTH="30" VALUE="">';
      echo '<BR><BR>';
      echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="lostpass_submit" VALUE="'.$rudweb_ln['usr']['lostpsubmit'].'">';
      echo '</FORM>';
      echo '</DIV>';
    }
  }
}
?>