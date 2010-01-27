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
./lib/img.php
12:50 2008-04-05
*/
error_reporting(E_ALL);
define("_RUDWEB_PUBFIL", TRUE);
require_once './../inc/config.inc.php';
require_once './../inc/rudwebc.inc.php';
require_once './../inc/rudwebf.inc.php';

// START SESSION
//session_cache_limiter ('public, must-revalidate');
session_cache_limiter('nocache');
session_cache_expire(600); //minutes
ini_set("session.gc_maxlifetime","36000"); //seconds
session_start();

$pw = "100";
if(isset($_GET['pw'])) {$pw = $_GET['pw'];}
$ph = "100";
if(isset($_GET['ph'])) {$ph = $_GET['ph'];}
$ts = "13";
if(isset($_GET['ts'])) {$ts = $_GET['ts'];}
$ta = "0";
if(isset($_GET['ta'])) {$ta = $_GET['ta'];}
$tx = "5";
if(isset($_GET['tx'])) {$tx = $_GET['tx'];}
$ty = "20";
if(isset($_GET['ty'])) {$ty = $_GET['ty'];}
$txt= "NO PICTURE";
if(isset($_GET['txt'])) {$txt = $_GET['txt'];}

if(isset($_SESSION[_RUDWEB_PRE.'token'])) {
  $br  = hexdec('0x' . substr($_SESSION[_RUDWEB_PRE.'usr_skin_bg'], 1, 2));
  $bg  = hexdec('0x' . substr($_SESSION[_RUDWEB_PRE.'usr_skin_bg'], 3, 2));
  $bb  = hexdec('0x' . substr($_SESSION[_RUDWEB_PRE.'usr_skin_bg'], 5, 2));

  $fr  = hexdec("0x" . substr($_SESSION[_RUDWEB_PRE.'usr_skin_fg'], 1, 2));
  $fg  = hexdec("0x" . substr($_SESSION[_RUDWEB_PRE.'usr_skin_fg'], 3, 2));
  $fb  = hexdec("0x" . substr($_SESSION[_RUDWEB_PRE.'usr_skin_fg'], 5, 2));
  
  header("Content-type: image/png");
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
  $img = imagecreatetruecolor($pw, $ph);
  
  $bgc = imagecolorallocate($img, $br, $bg, $bb);
  $fgc = imagecolorallocate($img, $fr, $fg, $fb);

  $font = _RUDWEB_TTF_DIR . "01_Digit.ttf";

  imagefill($img, 0, 0, $bgc);
  
  //                                img         sz       ang  x       y      color           font                 text
  imagettftext($img, $ts, $ta, $tx, $ty, $fgc, $font, $txt);
  
  imagepng($img); 
  imagedestroy($img);
}
else {
  require_once _RUDWEB_LIB_DIR . '404.php';
}
?>