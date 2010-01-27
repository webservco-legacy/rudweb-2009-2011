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
* News Module Administration
*
* <I>./inc/adm/nwsmod.inc.php</I>
* <BR>Contains News Administration Stuff
* 
* @author Radu Maier <rudisoft@rudisoft.net>
* @copyright Copyright (c) 2007-2008, Radu Maier
* @license http://opensource.org/licenses/gpl-2.0.php
* @version 16:42 2008-04-29
* @access public
* @package RudWEb
* @subpackage Modules
* @since 16:42 2008-04-29
*/

/**
* Authorized access only
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 3) {

  echo $rudweb_skin['cnt']['tt1']['pre'];
  echo $rudweb_ln['nws']['tt'];
  echo $rudweb_skin['cnt']['tt1']['suf'];

  echo $rudweb_skin['cnt']['txt']['pre'];

  if(!isset($_GET['act'])) {
    if(_RUDWEB_CFG_NWS == "0") {
      echo $rudweb_skin['adm']['mod']['pre'];
      echo $rudweb_ln['adm']['modstat0'];
      echo "<BR>";
      echo $rudweb_skin['adm']['mod']['suf'];
    } // if disabled
    else {
      if(_RUDWEB_DBCFG == "1") {  
        echo $rudweb_skin['adm']['mod']['pre'];
        echo "<FORM ENCTYPE=\"multipart/form-data\" NAME=\"nwslmt1form\" ACTION=\"\" METHOD=\"post\">";
        echo $rudweb_ln['adm']['lmttxt1'] . ' (' . $rudweb_ln['nws']['ltstnews'] . ') ';
        echo "<SELECT CLASS=\"forminput\" NAME=\"nws_lmt1\">";
        for ($nws_lmt1_i=1; $nws_lmt1_i<=10; $nws_lmt1_i++) {
    ?>
        <OPTION VALUE="<?php echo $nws_lmt1_i;?>"<?php if($nws_lmt1_i == _RUDWEB_CFG_NWS_LMT1) {echo " SELECTED";}?>><?php echo $nws_lmt1_i;?></OPTION>
    <?php
        }
        echo "</SELECT>";
        echo "<BR><BR>";
        echo "<INPUT CLASS=\"formsubmit\" TYPE=\"submit\" NAME=\"nwsmod\" VALUE=\"".$rudweb_ln['adm']['save']."\">";
        echo "</FORM>";
        echo $rudweb_skin['adm']['mod']['suf'];
      }
      else {
        echo $rudweb_skin['adm']['mod']['pre'];
        echo $rudweb_ln['adm']['lmttxt1'] . _RUDWEB_CFG_FTR_LMT1;
        echo "<BR>";
        echo $rudweb_ln['adm']['modstat12'];
        echo $rudweb_skin['adm']['mod']['suf'];
      }
      
      if(_RUDWEB_DBCFG == "1") {  
        echo $rudweb_skin['adm']['mod']['pre'];
        echo "<FORM ENCTYPE=\"multipart/form-data\" NAME=\"nwslmt2form\" ACTION=\"\" METHOD=\"post\">";
        echo $rudweb_ln['cat']['ipg']  . ' (' . $rudweb_ln['nws']['allnews'] . ') ';
        echo "<SELECT CLASS=\"forminput\" NAME=\"nws_lmt2\">";
        for ($nws_lmt2_i=1; $nws_lmt2_i<=10; $nws_lmt2_i++) {
    ?>
        <OPTION VALUE="<?php echo $nws_lmt2_i;?>"<?php if($nws_lmt2_i == _RUDWEB_CFG_NWS_LMT2) {echo " SELECTED";}?>><?php echo $nws_lmt2_i;?></OPTION>
    <?php
        }
        echo "</SELECT>";
        echo "<BR><BR>";
        echo "<INPUT CLASS=\"formsubmit\" TYPE=\"submit\" NAME=\"nwsmod\" VALUE=\"".$rudweb_ln['adm']['save']."\">";
        echo "</FORM>";
        echo $rudweb_skin['adm']['mod']['suf'];
      }
      else {
        echo $rudweb_skin['adm']['mod']['pre'];
        echo $rudweb_ln['adm']['lmttxt1'] . _RUDWEB_CFG_FTR_LMT2;
        echo "<BR>";
        echo $rudweb_ln['adm']['modstat12'];
        echo $rudweb_skin['adm']['mod']['suf'];
      }
      
      
    } // else if enabled
  }
  else if (isset($_GET['act'])) {
    if(_RUDWEB_CFG_NWS == 1) {
      $act = rudweb_filter_input($_GET['act']);
      $nws_id = 0;
      if(isset($_GET['nws'])) {$nws_id = rudweb_filter_input($_GET['nws']);}
      switch($act) {
        case 'add'  : {addNewsItem(); break;}
        case 'mod'  : {showNewsItem($nws_id,1); break;}
        case 'view' : {showNewsAll(1); break;}
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