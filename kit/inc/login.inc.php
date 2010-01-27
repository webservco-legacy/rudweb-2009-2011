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
./inc/login.inc.php
12:50 2008-04-05
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

if (isset($_SESSION[_RUDWEB_PRE.'token']) && (isset($_POST[_RUDWEB_PRE.'token']) && ($_POST[_RUDWEB_PRE.'token'] === $_SESSION[_RUDWEB_PRE.'token'] && (isset($_POST[_RUDWEB_PRE.'usr_login']) && (isset($_POST[_RUDWEB_PRE.'usr_pass'])))))) {
//if (isset($_POST[_RUDWEB_PRE.'usr_login']) && isset($_POST[_RUDWEB_PRE.'usr_pass'])) {
  if (rudweb_filter_input($_POST[_RUDWEB_PRE.'usr_login']) != '' && rudweb_filter_input($_POST[_RUDWEB_PRE.'usr_pass']) != '') {
  $rudweb_usr_login = rudweb_filter_input($_POST[_RUDWEB_PRE.'usr_login']);
  $rudweb_usr_pass  = rudweb_filter_input($_POST[_RUDWEB_PRE.'usr_pass']);
  $rudweb_usr_verif = strtoupper(rudweb_filter_input($_POST[_RUDWEB_PRE.'usr_verif']));
  $verif2 = str_split($_SESSION[_RUDWEB_PRE.'token'], 5);
  $verif2 = strtoupper(strrev($verif2['0']));
  if($rudweb_usr_verif == $verif2) {
    $rudweb_query_verif = "SELECT * FROM `"._RUDWEB_PRE."set_usr` WHERE `usr_login` = '".$rudweb_usr_login."' AND `usr_pass` = '".md5($rudweb_usr_pass)."' LIMIT 1";
    $rst_verif   = mysql_query($rudweb_query_verif) or require _RUDWEB_LIB_DIR . 'myerr.php';
  
    if (mysql_num_rows($rst_verif) == "1") {
      $row_rst_verif = mysql_fetch_assoc($rst_verif);
    
      if ($row_rst_verif['usr_status'] == '0') {
        $rudweb_login_status = 4;
      } // suspended account
    
      else {
        // log in user
        session_regenerate_id(TRUE);
        //setcookie(session_name(), '', time() + 3600 * 24 * 30, "/", "", 0);
        $_SESSION[_RUDWEB_PRE.'usr_logged_in']  = true;
        // user data
        $_SESSION[_RUDWEB_PRE.'token'] = md5(uniqid(rand(), TRUE));
        $_SESSION[_RUDWEB_PRE.'visit_date'] = date("Y-m-d");
        $_SESSION[_RUDWEB_PRE.'visit_time'] = date("H:i:s");
      
        $_SESSION[_RUDWEB_PRE.'usr_id']    = $row_rst_verif['usr_id'];
        $_SESSION[_RUDWEB_PRE.'usr_level'] = $row_rst_verif['usr_level'];
        $_SESSION[_RUDWEB_PRE.'usr_alias'] = $row_rst_verif['usr_nick_name'];
        $_SESSION[_RUDWEB_PRE.'usr_name']  = $row_rst_verif['usr_first_name'] . '&#160;' . $row_rst_verif['usr_last_name'];
        // language
        $_SESSION[_RUDWEB_PRE.'usr_lang_index'] = $row_rst_verif['usr_lang_index'];
        // skin
        $_SESSION[_RUDWEB_PRE.'usr_skin_dir'] = $row_rst_verif['usr_skin'];
        // get data about previous logins
        $query_last_login_id = "SELECT MAX(login_id) FROM `"._RUDWEB_PRE."var_logins` WHERE `usr_id` = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' LIMIT 1";
        $rst_last_login_id   = mysql_query($query_last_login_id) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $rudweb_last_login_id  = mysql_result($rst_last_login_id, 0);
        // get previous login data
        $query_last_login = "SELECT `login_date`, `login_time` FROM `"._RUDWEB_PRE."var_logins` WHERE `login_id` = '".$rudweb_last_login_id."' LIMIT 1";
        $rst_last_login   = mysql_query($query_last_login) or require _RUDWEB_LIB_DIR . 'myerr.php';
        if (mysql_num_rows($rst_last_login) == "1") {
          $row_last_login                            = mysql_fetch_assoc($rst_last_login);
          $_SESSION[_RUDWEB_PRE.'usr_last_login_date'] = $row_last_login['login_date'];
          $_SESSION[_RUDWEB_PRE.'usr_last_login_time'] = $row_last_login['login_time'];
        } // not first login
        else {
          $_SESSION[_RUDWEB_PRE.'usr_last_login_date'] = '0000-00-00';
          $_SESSION[_RUDWEB_PRE.'usr_last_login_time'] = '00:00:00';
        } // first login
        // count logins
        $query_total_logins            = "SELECT COUNT(`login_id`) FROM `"._RUDWEB_PRE."var_logins` WHERE `usr_id` = '".$_SESSION[_RUDWEB_PRE.'usr_id']."'";
        $rst_total_logins              = mysql_query($query_total_logins) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $_SESSION[_RUDWEB_PRE.'usr_total_logins'] = (mysql_result($rst_total_logins, 0)) + 1;
        //insert new login info
        $query_lock = "LOCK TABLES `"._RUDWEB_PRE."var_logins` WRITE";
        mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
      
        $query_rstId  = "SELECT MAX(login_id) FROM `"._RUDWEB_PRE."var_logins`";
        $rstId        = mysql_query($query_rstId) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $new_login_id = (mysql_result($rstId, 0)) + 1;
      
        $query_new_login = "INSERT INTO `"._RUDWEB_PRE."var_logins` (login_id, usr_id, login_date, login_time) VALUES ('".$new_login_id."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '".$_SESSION[_RUDWEB_PRE.'visit_date']."', '".$_SESSION[_RUDWEB_PRE.'visit_time']."')";
        mysql_query($query_new_login) or require _RUDWEB_LIB_DIR . 'myerr.php';
      
        $query_unlock = "UNLOCK TABLES";
        mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
      
        //set login status
        $rudweb_login_status = 5;
        //$redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP;
        //header("Location: $redirect");
      } // legitimate user
    } // if match
    else { 
      session_regenerate_id(TRUE);
      $_SESSION[_RUDWEB_PRE.'token'] = md5(uniqid(rand(), TRUE));
      $rudweb_login_status = 3;
    } // if no match
  } // xxx
  else {
    session_regenerate_id(TRUE);
    $_SESSION[_RUDWEB_PRE.'token'] = md5(uniqid(rand(), TRUE));
    $rudweb_login_status = 7;
  }
  } // if usr & pass not empty
  else {
    session_regenerate_id(TRUE);
    $_SESSION[_RUDWEB_PRE.'token'] = md5(uniqid(rand(), TRUE));
    $rudweb_login_status = 2;
  } // usr & pass empty
} // if post login
else {
  $rudweb_login_status = 1;
} //if login NOT submitted
?>