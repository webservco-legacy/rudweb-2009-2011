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
./inc/adm/catmod.inc.php
10:45 2008-05-02
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}
if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 5) {

  echo $rudweb_skin['cnt']['tt1']['pre'];
  echo $rudweb_ln['catalog']['catalog'] . ' - ' .  $rudweb_ln['adm']['settings'];
  echo $rudweb_skin['cnt']['tt1']['suf'];
  
  echo $rudweb_skin['cnt']['txt']['pre'];
  
    if(!isset($_GET['act'])) {
    if(_RUDWEB_CFG_CAT == "0") {
      echo $rudweb_skin['adm']['mod']['pre'];
      echo $rudweb_ln['adm']['modstat0'];
      echo "<BR>";
      if(_RUDWEB_DBCFG == "1") {
        echo "<FORM ENCTYPE=\"multipart/form-data\" NAME=\"catonoffform\" ACTION=\"\" METHOD=\"post\">";
        echo "<INPUT TYPE=\"hidden\" NAME=\"catonoff\" VALUE=\"1\">";
        echo "<BR>";
        echo "<INPUT CLASS=\"formsubmit\" TYPE=\"submit\" NAME=\"catmod\" VALUE=\"".$rudweb_ln['adm']['modstat01']."\">";
        echo "</FORM>";
      }
      else {
        echo $rudweb_ln['adm']['modstat00'];
      }
      echo $rudweb_skin['adm']['mod']['suf'];
    } // if disabled

    else {
      echo $rudweb_skin['adm']['mod']['pre'];
      echo $rudweb_ln['adm']['modstat1'];
      echo "<BR>";
      
      if(_RUDWEB_DBCFG == "1") {
        echo "<FORM ENCTYPE=\"multipart/form-data\" NAME=\"catonoffform\" ACTION=\"\" METHOD=\"post\">";
        echo "<INPUT TYPE=\"hidden\" NAME=\"catonoff\" VALUE=\"0\">";
        echo "<BR>";
        echo "<INPUT CLASS=\"formsubmit\" TYPE=\"submit\" NAME=\"catmod\" VALUE=\"".$rudweb_ln['adm']['modstat10']."\">";
        echo "</FORM>";
      }
      else {
        echo $rudweb_ln['adm']['modstat11'];
      }  
      echo $rudweb_skin['adm']['mod']['suf'];
    } // else if enabled
  }
  // xxx
  if(isset($_GET['act'])) {
    if(_RUDWEB_CFG_CAT == 1) {
      $act = rudweb_filter_input($_GET['act']);
      switch($act) {
        case 'ipg' : {setIpg(); break;}
        default : {break;}
      }
    }
  }
  echo $rudweb_skin['cnt']['txt']['suf'];
} // if user has the rights
else {
  echo "<DIV CLASS=\"err\">" . $rudweb_ln['err']['1'] . "</DIV>";
} // else if user has no rights
?>