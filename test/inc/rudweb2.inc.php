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
./inc/rudweb2.inc.php
14:24 2008-06-30
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

// MENU & PAGE STUFF
$rudweb_cnt_type           = "0";
$rudweb_this_content       = 'index';
$rudweb_this_content_level = getCntLev($rudweb_this_content);
$rudweb_mnu_id             = getCntMnuId('index');
$rudweb_stats_page         = 'index';
$rudweb_req_page           = 'index';
$rudweb_page_title         = _RUDWEB_WSTT . " - " . "Index";
$rudweb_page_description   = _RUDWEB_WSDS;
$rudweb_page_keywords      = _RUDWEB_WSKW;


// content
if (isset($_GET['content'])) {
  if(rudweb_filter_input($_GET['content']) == 'default') {  
    $rudweb_cnt_type = "4";
    $rudweb_this_content       = rudweb_filter_input($_GET['content']);
    $rudweb_this_content_level = getCntLev('index');
    $rudweb_mnu_id             = getCntMnuId('index');
    $rudweb_stats_page         = 'index';
    $rudweb_req_page           = 'index';
    if (is_file(_RUDWEB_ADMIN_DIR . $rudweb_this_content . ".inc.php")) {
      $rudweb_this_content_level = getCntLev($rudweb_this_content);
      $rudweb_mnu_id             = getCntMnuId($rudweb_this_content);
      $rudweb_stats_page         = "pg-" . $rudweb_this_content;
      $rudweb_req_page           = $rudweb_this_content;
      $rudweb_page_title         = _RUDWEB_WSTT . " - " . $rudweb_this_content;
      $rudweb_page_description   = _RUDWEB_WSDS;
      $rudweb_page_keywords      = _RUDWEB_WSKW;
    }
  }
  else {
    $rudweb_cnt_type = "1";
    $rudweb_this_content       = rudweb_filter_input($_GET['content']);
    $rudweb_this_content_level = getCntLev('index');
    $rudweb_mnu_id             = getCntMnuId('index');
    $rudweb_stats_page         = 'index';
    $rudweb_req_page           = 'index';
    $cnt_cnt_query = "SELECT * FROM `"._RUDWEB_PRE."ws_cnt` WHERE `cnt_alias` = '".$rudweb_this_content."' AND (`cnt_ln` = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND `cnt_lvl` <= '".$_SESSION[_RUDWEB_PRE.'usr_level']."') LIMIT 1";
    $rst_cnt_cnt   = mysql_query($cnt_cnt_query) or require _RUDWEB_LIB_DIR . 'myerr.php';
    $total_cnt_cnt = mysql_num_rows($rst_cnt_cnt);
    if ($total_cnt_cnt == "1") {
      $rudweb_this_content_level = getCntLev($rudweb_this_content);
      $rudweb_mnu_id             = getCntMnuId($rudweb_this_content);
      $rudweb_stats_page         = "ct-" . $rudweb_this_content;
      $rudweb_req_page           = $rudweb_this_content;
      $row_rst_cnt_cnt         = mysql_fetch_assoc($rst_cnt_cnt);
      $rudweb_page_title         = _RUDWEB_WSTT . " - " . $row_rst_cnt_cnt['cnt_tt'];
      if (trim($row_rst_cnt_cnt['cnt_dsc']) === "") {$rudweb_page_description   = _RUDWEB_WSDS;} else {$rudweb_page_description   = $row_rst_cnt_cnt['cnt_dsc'];}
      if (trim($row_rst_cnt_cnt['cnt_kw']) === "") {$rudweb_page_keywords      = _RUDWEB_WSKW;} else {$rudweb_page_keywords      = $row_rst_cnt_cnt['cnt_kw'];}
    }
  }
}
// page
else if (isset($_GET['page'])) {
  $rudweb_cnt_type = "3";
  $rudweb_this_content       = rudweb_filter_input($_GET['page']);
  $rudweb_this_content_level = getCntLev('index');
  $rudweb_mnu_id             = getCntMnuId('index');
  $rudweb_stats_page         = 'index';
  $rudweb_req_page           = 'index';
  if (is_file(_RUDWEB_PG_DIR . $rudweb_this_content . ".inc.php")) {
    $rudweb_this_content_level = getCntLev($rudweb_this_content);
    $rudweb_mnu_id             = getCntMnuId($rudweb_this_content);
    $rudweb_stats_page         = "pg-" . $rudweb_this_content;
    $rudweb_req_page           = $rudweb_this_content;
    //$rudweb_page_title         = _RUDWEB_WSTT . " - " . $rudweb_this_content;
    $rudweb_page_title         = _RUDWEB_WSTT;
    $rudweb_page_description   = _RUDWEB_WSDS;
    $rudweb_page_keywords      = _RUDWEB_WSKW;
  }
}
// other stuff ie blog, news, etc
else if (isset($_GET['show'])) {
  $rudweb_cnt_type = "4";
  $rudweb_this_content       = rudweb_filter_input($_GET['show']);
  $rudweb_this_content_level = getCntLev('index');
  $rudweb_mnu_id             = getCntMnuId('index');
  $rudweb_stats_page         = 'index';
  $rudweb_req_page           = 'index';
  $show_allowed = array('about', 'actuser', 'contact', 'lostpass', 'news', 'newuser', 'tags');
  if (is_file(_RUDWEB_ADMIN_DIR . $rudweb_this_content . ".inc.php") && in_array($rudweb_this_content, $show_allowed)) {
    //$rudweb_this_content_level = getCntLev($rudweb_this_content);
    //$rudweb_mnu_id             = getCntMnuId($rudweb_this_content);
    $rudweb_stats_page         = "pg-etc-" . $rudweb_this_content;
    $rudweb_req_page           = $rudweb_this_content;
    $rudweb_page_title         = _RUDWEB_WSTT;
    $rudweb_page_description   = _RUDWEB_WSDS;
    $rudweb_page_keywords      = _RUDWEB_WSKW;
  }
}
// admin
else if (isset($_GET['admin'])) {
  $rudweb_cnt_type = "4";
  $rudweb_this_content       = rudweb_filter_input($_GET['admin']);
  $rudweb_this_content_level = getCntLev('index');
  $rudweb_mnu_id             = getCntMnuId('index');
  $rudweb_stats_page         = 'index';
  $rudweb_req_page           = 'index';
  $admin_allowed = array('admin', 'catmod', 'catmoda', 'cmtmod', 'cmtmoda', 'cntadd', 'conmod', 'conmoda', 'cspmod', 'cspmoda', 'ftrmod', 'ftrmoda', 'itemadd', 'nwsmod', 'nwsmoda', 'tagmod', 'tagmoda');
  if (is_file(_RUDWEB_ADMIN_DIR . $rudweb_this_content . ".inc.php") && in_array($rudweb_this_content, $admin_allowed)) {
    $rudweb_this_content_level = getCntLev($rudweb_this_content);
    $rudweb_mnu_id             = getCntMnuId($rudweb_this_content);
    $rudweb_stats_page         = "adm-" . $rudweb_this_content;
    $rudweb_req_page           = $rudweb_this_content;
    //$rudweb_page_title         = _RUDWEB_WSTT . " - " . $rudweb_this_content;
    $rudweb_page_title         = _RUDWEB_WSTT . ' - ' . $rudweb_ln['adm']['adm'];
    $rudweb_page_description   = _RUDWEB_WSDS;
    $rudweb_page_keywords      = _RUDWEB_WSKW;
  }
}
// catalog
else if (isset($_GET['catalog']) && _RUDWEB_CFG_CAT == '1') {
  $rudweb_cnt_type = "5";
  $rudweb_this_content       = rudweb_filter_input($_GET['catalog']);
  $rudweb_this_content_level = getCntLev('index');
  $rudweb_mnu_id             = getCntMnuId('index');
  $rudweb_stats_page         = 'index';
  $rudweb_req_page           = 'index';
  //if($rudweb_this_content == 'main') {$rudweb_this_content = 'categories';}
  if (is_file(_RUDWEB_CAT_DIR . $rudweb_this_content . ".inc.php")) {
    $rudweb_this_content_level = getCntLev($rudweb_this_content);
    $rudweb_mnu_id             = getCntMnuId($rudweb_this_content);
    $rudweb_stats_page         = "cat-" . $rudweb_this_content;
    $rudweb_req_page           = $rudweb_this_content;
    $rudweb_page_title         = _RUDWEB_WSTT . ' - ' . $rudweb_ln['catalog']['catalog'];
    $rudweb_page_description   = _RUDWEB_WSDS;
    $rudweb_page_keywords      = _RUDWEB_WSKW;
  }
}
/*
else if (substr($_SERVER['REQUEST_URI'], -9) == 'admin.php' && _RUDWEB_CFG_ADM === "1") {
  if ($_SESSION[_RUDWEB_PRE.'usr_level'] > 2 && $_SESSION[_RUDWEB_PRE.'usr_level'] <= 5) { //3,4,5
  $rudweb_cnt_type           = "0";  // NOT REALLY NEEDED
  $rudweb_this_content       = 'admin';  // NOT REALLY NEEDED   index
  $rudweb_this_content_level = getCntLev($rudweb_this_content);  // NOT REALLY NEEDED
  $rudweb_mnu_id             = getCntMnuId('index');  // NOT REALLY NEEDED
  $rudweb_mnu_id             = "0";  // only for travel-agency
  $rudweb_stats_page         = 'admin';
  $rudweb_req_page           = 'admin'; // NOT REALLY NEEDED
  $rudweb_page_title         = _RUDWEB_WSTT . " - " . "Admin";
  $rudweb_page_description   = _RUDWEB_WSDS;
  $rudweb_page_keywords      = _RUDWEB_WSKW;
  }
  else if ($_SESSION[_RUDWEB_PRE.'usr_level'] == 0) { // 0
    $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/admin';
    header("Location: $redirect");
  }
  else if ($_SESSION[_RUDWEB_PRE.'usr_level'] >= 1 && $_SESSION[_RUDWEB_PRE.'usr_level'] < 3) { // 1,2
    $redirect = _RUDWEB_SITE_URL;
    header("Location: $redirect");
  }
}
*/
else { // SHOW DEFAULT PAGE _RUDWEB_CFG_CNT
  if (_RUDWEB_CFG_CNT_SHW === "1") {
    if($_SESSION[_RUDWEB_PRE.'usr_lang_index']      == 'en') {$default_content = _RUDWEB_CFG_CNT_EN;}
    else if($_SESSION[_RUDWEB_PRE.'usr_lang_index'] == 'de') {$default_content = _RUDWEB_CFG_CNT_DE;}
    else if($_SESSION[_RUDWEB_PRE.'usr_lang_index'] == 'es') {$default_content = _RUDWEB_CFG_CNT_ES;}
    else if($_SESSION[_RUDWEB_PRE.'usr_lang_index'] == 'fr') {$default_content = _RUDWEB_CFG_CNT_FR;}
    else if($_SESSION[_RUDWEB_PRE.'usr_lang_index'] == 'it') {$default_content = _RUDWEB_CFG_CNT_IT;}
    else if($_SESSION[_RUDWEB_PRE.'usr_lang_index'] == 'ro') {$default_content = _RUDWEB_CFG_CNT_RO;}
    $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'content/' . $default_content;
    header("Location: $redirect");
  }
  else { // SHOW INTRO
    $redirect = _RUDWEB_SITE_URL . 'intro.php';
    header("Location: $redirect");
  }
}
?>