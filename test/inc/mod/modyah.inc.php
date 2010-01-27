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
./inc/mod/modyah.inc.php
15:05 2008-06-03
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

function youAreHere() {
  global $rudweb_cnt_type;
  global $rudweb_this_content_level;
  global $rudweb_mnu_id;
  global $rudweb_ln;
  global $rudweb_skin;
  
  if($rudweb_cnt_type === '1' || $rudweb_cnt_type === '3'){
  
    $id[$rudweb_this_content_level] = $rudweb_mnu_id;
    for($i=$rudweb_this_content_level-1; $i>=0; $i--) {$id[$i] = getCntParId($id[$i+1]);}
    $id = array_reverse($id);
    
    echo $rudweb_skin['yah']['hdr'];
    
    echo $rudweb_skin['yah']['pre'];
    restrictedLocalLink('default', 'Home', _RUDWEB_INDEX_PHP . '', $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
    echo $rudweb_skin['yah']['suf'];
    
    for($j=0; $j<count($id); $j++) {
      $query   = "SELECT mnu_tt, mnu_typ, mnu_cnt_alias, mnu_trg, mnu_lvl FROM "._RUDWEB_PRE."ws_mnu WHERE mnu_id = '".$id[$j]."'";
      $result  = mysql_query($query) or require _RUDWEB_LIB_DIR . 'myerr.php';
      $totalrs = mysql_num_rows($result);;
      if($totalrs != '1') {}
      else {
        $row = mysql_fetch_assoc($result);
        
        echo $rudweb_skin['yah']['sep'];
        echo $rudweb_skin['yah']['pre'];
        if($id[$j] == $rudweb_mnu_id) {echo $row['mnu_tt'];}
        else {
          if($row['mnu_typ'] === '1')      {restrictedLocalLink('default', $row['mnu_tt'], _RUDWEB_INDEX_PHP . 'content/'. $row['mnu_cnt_alias'], $_SESSION[_RUDWEB_PRE.'usr_level'], $row['mnu_lvl'], $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], $row['mnu_trg']);}
          else if($row['mnu_typ'] === '2') {}
          else if($row['mnu_typ'] === '3') {restrictedLocalLink('default', $row['mnu_tt'], _RUDWEB_INDEX_PHP . 'page/'. $row['mnu_cnt_alias'], $_SESSION[_RUDWEB_PRE.'usr_level'], $row['mnu_lvl'], $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], $row['mnu_trg']);}
          else if($row['mnu_typ'] === '4') {restrictedLocalLink('default', $row['mnu_tt'], _RUDWEB_INDEX_PHP . 'rsweb/'. $row['mnu_cnt_alias'], $_SESSION[_RUDWEB_PRE.'usr_level'], $row['mnu_lvl'], $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], $row['mnu_trg']);}
        }

        echo $rudweb_skin['yah']['suf'];
        
      }
    }
    echo $rudweb_skin['yah']['ftr'];
  }
}
?>