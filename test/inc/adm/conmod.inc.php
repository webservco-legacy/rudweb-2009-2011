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
* Contact Module Administration
*
* <I>./inc/adm/conmod.inc.php</I>
* <BR>Contains Contact Administration Stuff
* 
* @author Radu Maier <rudisoft@rudisoft.net>
* @copyright Copyright (c) 2007-2008, Radu Maier
* @license http://opensource.org/licenses/gpl-2.0.php
* @version 14:28 2008-06-27
* @access public
* @package RudWEb
* @subpackage Modules
* @since 19:13 2008-05-31
*/

/**
* Authorized access only
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 3) {

  echo $rudweb_skin['cnt']['tt1']['pre'];
  echo $rudweb_ln['con']['tt'];
  echo $rudweb_skin['cnt']['tt1']['suf'];

  if (isset($_GET['act']) && $_SESSION[_RUDWEB_PRE.'usr_level'] >= 5) {
    if(_RUDWEB_CFG_CON == 1) {
      $act = rudweb_filter_input($_GET['act']);
      //$con_id = 0;
      //if(isset($_GET['contact'])) {$con_id = rudweb_filter_input($_GET['contact']);}
      switch($act) {
        case 'cat'  : {
          echo $rudweb_skin['cnt']['tt2']['pre'];
          echo $rudweb_ln['categs'];
          echo $rudweb_skin['cnt']['tt2']['suf'];
          echo $rudweb_skin['cnt']['txt']['pre'];
          admConCat();
          echo $rudweb_skin['cnt']['txt']['suf'];
          break;
        }
        case 'det'  : {
          adminConDet();
          break;
        }
        case 'opt'  : {
          adminConOpt();
          break;
        }
        //case 'del'  : {delConItem(); break;}
        default : {break;}
      }
    }
  }
  else if (isset($_GET['view']) && $_SESSION[_RUDWEB_PRE.'usr_level'] >= 3) {
    if(_RUDWEB_CFG_CON == 1) {
      $con_view = rudweb_filter_input($_GET['view']);
      switch($con_view) {
        case 'msgs' : {
          adminConMsgsMenu();
          break;
        }
        case 'msg' : {
          adminConMsg();
          break;
        }
        default : {break;}
      }
    }
  }
  
} // if user has the rights
else {
  echo "<DIV CLASS=\"err\">" . $rudweb_ln['err']['1'] . "</DIV>";
} // else if user has no rights
?>