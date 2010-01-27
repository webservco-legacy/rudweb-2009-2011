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
./rudweb.php
11:26 2008-06-27
*/
error_reporting(E_ALL);
define("_RUDWEB_PUBFIL", TRUE);

require_once './inc/config.inc.php';
require_once './inc/rudwebc.inc.php';
require_once './inc/rudwebf.inc.php';

rudweb_dbopen($rudweb_dbtype, $rudweb_dbhost, $rudweb_dbport, $rudweb_dbuser, $rudweb_dbpass, $rudweb_dbname);

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

//require_once './../inc/rudweb1.inc.php';
//require_once './../inc/rudweb2.inc.php';


require_once _RUDWEB_LANG_DIR . _RUDWEB_CFG_LANG .'/langcfg.inc.php';
require_once _RUDWEB_LANG_DIR . _RUDWEB_CFG_LANG .'/lang.info.php';
require_once  _RUDWEB_SKIN_DIR . _RUDWEB_CFG_SKIN .'/skin.info.php';



if(!isset($_GET['version'])) {
  header("Content-type: image/png");
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
  $img = imagecreatetruecolor(390, 390);

  $bgc = imagecolorallocate($img, hexdec('0xDD'), hexdec('0xDD'), hexdec('0xDD'));
  $fgc = imagecolorallocate($img, hexdec('0x00'), hexdec('0x00'), hexdec('0x00'));
  $fgc2 = imagecolorallocate($img, hexdec('0xFF'), hexdec('0xFF'), hexdec('0xFF'));

  $font = _RUDWEB_TTF_DIR . "VeraMono.ttf";


  imagefill($img, 0, 0, $bgc);

  //imagefilledrectangle ( resource image, int x1, int y1, int x2, int y2, int color )
  imagefilledrectangle($img, 170, 0, 450, 390, hexdec('0xCCCCCC'));
  
  //                                img        sz               ang       x          y      color           font                 text
  imagettftext($img, 108, -42, -18, 66, hexdec('0xEEEEEE'), $font, 'RudWEb');

  imagettftext($img, 9, 0, 76,  18, $fgc, $font, 'Website Title');
  imagettftext($img, 9, 0, 173,  18, $fgc, $font, _RUDWEB_WSTT);
  imagettftext($img, 9, 0, 41,  36, $fgc, $font, 'Website Start Date');
  imagettftext($img, 9, 0, 173,  36, $fgc, $font, _RUDWEB_CFG_START);
  imagettftext($img, 9, 0, 92,  54, $fgc, $font, 'Website URL');
  imagettftext($img, 9, 0, 173,  54, $fgc, $font, _RUDWEB_SITE_URL);
  
  imagettftext($img, 9, 0, 70,  80, $fgc, $font, 'Client Company');
  imagettftext($img, 9, 0, 173,  80, $fgc, $font, _RUDWEB_CFG_CLCOM);
  imagettftext($img, 9, 0, 21,  98, $fgc, $font, 'Client Contact Person');
  imagettftext($img, 9, 0, 173,  98, $fgc, $font, _RUDWEB_CFG_CLNAM);
  
  imagettftext($img, 9, 0, 49, 124, $fgc, $font, 'Developer Company');
  imagettftext($img, 9, 0, 173, 124, $fgc, $font, _RUDWEB_CFG_DVCOM);
  imagettftext($img, 9, 0, 1, 142, $fgc, $font, 'Developer Contact Person');
  imagettftext($img, 9, 0, 173, 142, $fgc, $font, _RUDWEB_CFG_DVNAM);
  imagettftext($img, 9, 0, 49, 160, $fgc, $font, 'Developer Website');
  imagettftext($img, 9, 0, 173, 160, $fgc, $font, _RUDWEB_CFG_DVURL);
  
  imagettftext($img, 9, 0, 98, 186, $fgc, $font, 'Powered By');
  imagettftext($img, 9, 0, 173, 186, $fgc, $font, 'RudWEb');
  imagettftext($img, 9, 0, 70, 204, $fgc, $font, 'Engine Version');
  imagettftext($img, 9, 0, 173, 204, $fgc, $font, _RUDWEB_SITE_VERSION);
  imagettftext($img, 9, 0, 78, 222, $fgc, $font, 'Engine Author');
  imagettftext($img, 9, 0, 173, 222, $fgc, $font, _RUDWEB_SITE_AUTH);
  imagettftext($img, 9, 0, 70, 240, $fgc, $font, 'Engine Website');
  imagettftext($img, 9, 0, 173, 240, $fgc, $font, 'http://www.rudisoft.net');
  
  imagettftext($img, 9, 0, 104, 266, $fgc, $font, 'Skin Name');
  imagettftext($img, 9, 0, 173, 266, $fgc, $font, $rudweb_skin_name);
  imagettftext($img, 9, 0, 84, 284, $fgc, $font, 'Skin Version');
  imagettftext($img, 9, 0, 173, 284, $fgc, $font, $rudweb_skin_version);
  imagettftext($img, 9, 0, 91, 302, $fgc, $font, 'Skin Author');
  imagettftext($img, 9, 0, 173, 302, $fgc, $font, $rudweb_skin_author);
  imagettftext($img, 9, 0, 84, 320, $fgc, $font, 'Skin Website');
  imagettftext($img, 9, 0, 173, 320, $fgc, $font, $rudweb_skin_website);
  
  imagettftext($img, 9, 0, 34, 346, $fgc, $font, 'Language Local Name');
  imagettftext($img, 9, 0, 173, 346, $fgc, $font, $rudweb_lang_local_name);
  imagettftext($img, 9, 0, 35, 364, $fgc, $font, 'Language Translator');
  imagettftext($img, 9, 0, 173, 364, $fgc, $font, $rudweb_lang_translator);
  imagettftext($img, 9, 0, 56, 382, $fgc, $font, 'Language Charset');
  imagettftext($img, 9, 0, 173, 382, $fgc, $font, $rudweb_lang_charset);

  imagepng($img); 
  imagedestroy($img);
}
else {
  require_once _RUDWEB_LIB_DIR . '404.php';
}
?>