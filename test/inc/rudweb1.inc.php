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
./inc/rudweb1.inc.php
09:49 2008-06-04
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

// ERROR REPORTING
// report all errors
error_reporting(E_ALL);
// report all errors except E_NOTICE
//error_reporting(E_ALL ^ E_NOTICE);

//REDIRECT TO INDEX.PHP
if ($_SERVER['REQUEST_URI'][strlen($_SERVER['REQUEST_URI'])-1] === "/" && count($_GET) != 0) {
    $site_root = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP;
    header("Location: $site_root");
    exit;
}

// INCLUDE RUNTIME REQUIRED PHP FUNCTIONS
require_once _RUDWEB_LIB_DIR . 'ubmydate.php';
require_once _RUDWEB_INC_DIR . 'rudwebf.inc.php';

// SEARCH ENGINE OPTIMIZATION FUNCTION
seo_urls();

// OPEN DATABASE CONNECTION
//dbopen();
rudweb_dbopen($rudweb_dbtype, $rudweb_dbhost, $rudweb_dbport, $rudweb_dbuser, $rudweb_dbpass, $rudweb_dbname);

// GET SITE SETTINGS
if(_RUDWEB_DBCFG === "1") {
  // query
  $query_cfg = "SELECT * FROM "._RUDWEB_PRE."set_cfg";
  $rst_query_cfg = mysql_query($query_cfg) or require _RUDWEB_SITE_DIR . 'lib/myerr.php';
  $total_cfg = mysql_num_rows($rst_query_cfg);
  for ($cfg=1; $cfg<=$total_cfg; $cfg++) {
    $row_rst_cfg = mysql_fetch_assoc($rst_query_cfg);
    $row_rst_cfg['set_val'] = strval($row_rst_cfg['set_val']);
    define("_RUDWEB_CFG_".$row_rst_cfg['set_set'], $row_rst_cfg['set_val']);
  }
  define("_RUDWEB_CFG_COPY", "&copy; " . substr(_RUDWEB_CFG_START, 0, 4) . " " . _RUDWEB_CFG_CLCOM);
}
else {require_once _RUDWEB_INC_DIR . 'rudwebcfg.inc.php';}

// START SESSION
/*
// try this:
header("ETag: PUB" . time());
header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()-10) . " GMT");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 5) . " GMT");
header("Pragma: no-cache");
header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
session_cache_limiter("nocache");
*/
session_cache_limiter('public, must-revalidate');
//session_cache_limiter('nocache');
session_cache_expire(600); //minutes
ini_set("session.gc_maxlifetime","36000"); //seconds
//setcookie("PHPSESSID",$_COOKIE['PHPSESSID'],time()+1800);
session_start();
header("ETag: PUB" . time());
header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()-10) . " GMT");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 5) . " GMT");
header("Pragma: no-cache");
header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
if (!isset($_SESSION[_RUDWEB_PRE.'token'])) { // if first load of the page
  //session_regenerate_id(TRUE);
  $_SESSION[_RUDWEB_PRE.'token'] = md5(uniqid(rand(), TRUE));
  $_SESSION[_RUDWEB_PRE.'visit_date'] = date("Y-m-d");
  $_SESSION[_RUDWEB_PRE.'visit_time'] = date("H:i:s");
  //default user data
  $_SESSION[_RUDWEB_PRE.'usr_id']    = '0';
  $_SESSION[_RUDWEB_PRE.'usr_level'] = '0';
  $_SESSION[_RUDWEB_PRE.'usr_alias'] = 'NO_ALIAS';
  $_SESSION[_RUDWEB_PRE.'usr_name']  = 'NO_NAME';
  // default language
  if (!isset($_SESSION[_RUDWEB_PRE.'usr_lang_index'])) {$_SESSION[_RUDWEB_PRE.'usr_lang_index'] = _RUDWEB_CFG_LANG;}
  //default charset
  if (!isset($_SESSION[_RUDWEB_PRE.'usr_lang_charset'])) {$_SESSION[_RUDWEB_PRE.'usr_lang_charset'] = "UTF-8";}
  // default skin
  if (!isset($_SESSION[_RUDWEB_PRE.'usr_skin_dir'])) {$_SESSION[_RUDWEB_PRE.'usr_skin_dir'] = _RUDWEB_CFG_SKIN;}
  //reset shopping cart
  if(_RUDWEB_CFG_CART_ON === "1") {$_SESSION[_RUDWEB_PRE.'cart'] = NULL;}
  // user login functonality
  require_once _RUDWEB_INC_DIR . 'login.inc.php';
} // if first load of the page
else {
  if (!isset($_SESSION[_RUDWEB_PRE.'usr_logged_in'])) {
    // user login functonality
    require_once _RUDWEB_INC_DIR . 'login.inc.php';
  } // if not logged in
  else if (isset($_SESSION[_RUDWEB_PRE.'usr_logged_in'])) {
    if(_RUDWEB_CFG_USR_ON === "1") {$rudweb_login_status = 6;}
  } // if logged in
}

// MODULE FUNCTIONS
require_once _RUDWEB_INC_DIR . 'rudwebm.inc.php';

// START PARSE TIME COUNT
if (_RUDWEB_CFG_TIMER === "1") {startTimer();}

// LOAD LANGUAGE
require_once _RUDWEB_LANG_DIR . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . '/lang.info.php';
$_SESSION[_RUDWEB_PRE.'usr_lang_index']      = $rudweb_lang_index;
$_SESSION[_RUDWEB_PRE.'usr_lang_name']       = $rudweb_lang_name;
$_SESSION[_RUDWEB_PRE.'usr_lang_local_name'] = $rudweb_lang_local_name;
$_SESSION[_RUDWEB_PRE.'usr_lang_translator'] = $rudweb_lang_translator;
$_SESSION[_RUDWEB_PRE.'usr_lang_charset']    = $rudweb_lang_charset;
require_once _RUDWEB_LANG_DIR . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . '/langcfg.inc.php';
require_once _RUDWEB_LANG_DIR . $_SESSION[_RUDWEB_PRE.'usr_lang_index'] . '/lang.inc.php';

// admin stuff
if ($_SESSION[_RUDWEB_PRE.'usr_level'] >=1) {
  require_once _RUDWEB_INC_DIR . 'admin.inc.php';
  require_once _RUDWEB_LIB_DIR . 'editor/fckeditor.php';
}

// lock stuff
/*
if(isset($_GET['do'])) {
  if($_GET['do'] == "lock") {
    // LOCK
    $query_lock = "UPDATE "._RUDWEB_PRE."ws_cnt SET cnt_dis = '2' WHERE cnt_dis = '0'";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  }
  else if($_GET['do'] == "unlock") {
    //UNLOCK
    $query_lock = "UPDATE "._RUDWEB_PRE."ws_cnt SET cnt_dis = '0' WHERE cnt_dis = '2'";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  }
}
*/
?>