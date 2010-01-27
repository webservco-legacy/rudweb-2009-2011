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
./inc/mod/modlang.inc.php
14:25 2008-06-30
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

if (isset($_GET['ln']) && (!isset($_POST[_RUDWEB_PRE.'usr_login']) && _RUDWEB_CFG_LANG_ON === "1")) {
  $rudweb_new_lang = rudweb_filter_input($_GET['ln']);
  if (is_file(_RUDWEB_LANG_DIR . $rudweb_new_lang . "/" . "lang.info.php")) {
    $_SESSION[_RUDWEB_PRE.'usr_lang_index'] = $rudweb_new_lang;
    $lang_request_uri = eregi_replace("/ln/".$_GET['ln'], "", $_SERVER['REQUEST_URI']);
    $lang_redirect = "http://".$_SERVER['HTTP_HOST'] . $lang_request_uri;
    header("Location: $lang_redirect");
  }
  if (isset($_GET['setln']) && ($_GET['setln'] === "1" && _RUDWEB_CFG_USR_ON === "1")) {
    if (isset($_SESSION[_RUDWEB_PRE.'usr_id']) && $_SESSION[_RUDWEB_PRE.'usr_id'] != "0") {
      $query_ln = "UPDATE `"._RUDWEB_PRE."set_usr` SET `usr_lang_index` = '" . $rudweb_new_lang . "' WHERE `usr_id` = '" . $_SESSION[_RUDWEB_PRE.'usr_id'] . "' LIMIT 1";
      mysql_query($query_ln) or require _RUDWEB_LIB_DIR . 'myerr.php';
    }
  }
} //CHANGE LANGUAGE IS SET

function genLangMod() {
  global $rudweb_skin;
  if(_RUDWEB_CFG_LANG_ON === "1") {
    $all_langs = lsdir(_RUDWEB_LANG_DIR);
    echo $rudweb_skin['lng']['hdr'];
    for ($i=1; $i <= count($all_langs); $i++) {
      if (isset($_GET['ln'])) {$this_request_uri = eregi_replace("/ln/".$_GET['ln'], "", $_SERVER['REQUEST_URI']);}
      else {$this_request_uri = $_SERVER['REQUEST_URI'];}
      if (is_file(_RUDWEB_SKIN_DIR . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'] . "/graphics/lang/" . $all_langs[$i] . ".png")) {
        echo $rudweb_skin['lng']['pre'];
        
        if($all_langs[$i]      == 'en') {$lng_default_content = _RUDWEB_CFG_CNT_EN;}
        else if($all_langs[$i] == 'de') {$lng_default_content = _RUDWEB_CFG_CNT_DE;}
        else if($all_langs[$i] == 'es') {$lng_default_content = _RUDWEB_CFG_CNT_ES;}
        else if($all_langs[$i] == 'fr') {$lng_default_content = _RUDWEB_CFG_CNT_FR;}
        else if($all_langs[$i] == 'it') {$lng_default_content = _RUDWEB_CFG_CNT_IT;}
        else if($all_langs[$i] == 'ro') {$lng_default_content = _RUDWEB_CFG_CNT_RO;}
        
        //echo "<A HREF=\"http://".$_SERVER['HTTP_HOST'] . $this_request_uri . "/ln/" . $all_langs[$i]."\">";
        echo "<A HREF=\"". _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . "content/" . $lng_default_content . "/ln/" . $all_langs[$i]."\">";
        echo "<IMG SRC=\""._RUDWEB_SKIN_URL . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'] . "/graphics/lang/" . $all_langs[$i] . ".png" ."\" ALT=\"" . $all_langs[$i] . "\" BORDER=\"0\">";
        echo "</A>";

        echo $rudweb_skin['lng']['suf'];

        if ($i < count($all_langs)) {echo $rudweb_skin['lng']['sep'];}
      } 
    }
    echo $rudweb_skin['lng']['ftr'];
  }
}
?>