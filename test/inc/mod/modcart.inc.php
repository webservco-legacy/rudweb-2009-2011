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
./inc/mod/modcart.inc.php
09:48 2008-06-04
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

if(isset($_POST[_RUDWEB_PRE.'cart_act'])) { // needs further validation
  $rudweb_cart_act = $_POST[_RUDWEB_PRE.'cart_act'];
  switch($rudweb_cart_act) {
    case "add": {
      foreach ($_POST['qty'] as $pid => $qty) {
        if (isset($_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid])) {
          $_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid] = $_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid] + $qty;
        }
        else {$_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid] = $qty;}
      }
      foreach ($_POST['prc'] as $pid => $prc) {
        $_SESSION[_RUDWEB_PRE.'cart']['prc'][$pid] = $prc;
        $_SESSION[_RUDWEB_PRE.'cart']['stt'][$pid] = $_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid] * $_SESSION[_RUDWEB_PRE.'cart']['prc'][$pid];
      }
      break;
    }
    case "mod": {
      foreach ($_POST['qty'] as $pid => $qty) {
        if (isset($_POST['del'][$pid])) {
          if (isset($_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid])) {unset($_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid]);}
        }
        else {
          if (isset($_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid])) {
            if ($qty == '0') {
              if (isset($_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid])) {unset($_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid]);}
              if (isset($_SESSION[_RUDWEB_PRE.'cart']['prc'][$pid])) {unset($_SESSION[_RUDWEB_PRE.'cart']['prc'][$pid]);}
              if (isset($_SESSION[_RUDWEB_PRE.'cart']['stt'][$pid])) {unset($_SESSION[_RUDWEB_PRE.'cart']['stt'][$pid]);}
            }
            else {
              $_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid] = $qty;
            }
          }
        }
      }
      foreach ($_POST['prc'] as $pid => $prc) {
        if (isset($_POST['del'][$pid])) {
          if (isset($_SESSION[_RUDWEB_PRE.'cart']['prc'][$pid])) {unset($_SESSION[_RUDWEB_PRE.'cart']['prc'][$pid]);}
          if (isset($_SESSION[_RUDWEB_PRE.'cart']['stt'][$pid])) {unset($_SESSION[_RUDWEB_PRE.'cart']['stt'][$pid]);}
        }
        else {
          if (isset($_SESSION[_RUDWEB_PRE.'cart']['prc'][$pid])) {$_SESSION[_RUDWEB_PRE.'cart']['prc'][$pid] = $prc;}
          if (isset($_SESSION[_RUDWEB_PRE.'cart']['stt'][$pid])) {$_SESSION[_RUDWEB_PRE.'cart']['stt'][$pid] = $_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid] * $_SESSION[_RUDWEB_PRE.'cart']['prc'][$pid];}
        }
      }
      if (count($_SESSION[_RUDWEB_PRE.'cart']['qty']) == '0') {$_SESSION[_RUDWEB_PRE.'cart'] = NULL;}
      break;
    }
    /*
    case "del": {
      foreach ($_POST['qty'] as $pid => $qty) {
        if (isset($_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid])) {unset($_SESSION[_RUDWEB_PRE.'cart']['qty'][$pid]);}
        if (isset($_SESSION[_RUDWEB_PRE.'cart']['prc'][$pid])) {unset($_SESSION[_RUDWEB_PRE.'cart']['prc'][$pid]);}
        if (isset($_SESSION[_RUDWEB_PRE.'cart']['stt'][$pid])) {unset($_SESSION[_RUDWEB_PRE.'cart']['stt'][$pid]);}
      }
      break;
    }
    */
    case "rst": {
      $_SESSION[_RUDWEB_PRE.'cart'] = NULL;
      break;
    }
    default   : {break;}
  }
}

//$rudweb_cart = $_SESSION[_RUDWEB_PRE.'cart'];

function showProducts() { // this will become obsolete, or fully changed to take form db or something
  echo "<HR>";
  echo "our products:<BR>";
  
  echo "<FORM ENCTYPE=\"multipart/form-data\" CLASS=\"\" NAME=\"cartaddform[1]\" ACTION=\"\" METHOD=\"post\">";
  echo "CD  - $ 25&#160;";
  echo "<INPUT CLASS=\"\" TYPE=\"hidden\" NAME=\""._RUDWEB_PRE."cart_act\" VALUE=\"add\">";
  echo "<INPUT CLASS=\"\" TYPE=\"text\" NAME=\"qty[1]\" SIZE=\"1\" MAXLENGTH=\"2\" VALUE=\"1\">";
  echo "<INPUT CLASS=\"\" TYPE=\"hidden\" NAME=\"prc[1]\" VALUE=\"25\">";
  echo "&#160;";
  echo "<INPUT CLASS=\"\" TYPE=\"submit\" NAME=\"go\" VALUE=\"add\">";
  echo "</FORM>";
  
  echo "<BR>";
  
  echo "<FORM ENCTYPE=\"multipart/form-data\" CLASS=\"\" NAME=\"cartaddform[2]\" ACTION=\"\" METHOD=\"post\">";
  echo "LP  - $ 50&#160;";
  echo "<INPUT CLASS=\"\" TYPE=\"hidden\" NAME=\""._RUDWEB_PRE."cart_act\" VALUE=\"add\">";
  echo "<INPUT CLASS=\"\" TYPE=\"text\" NAME=\"qty[2]\" SIZE=\"1\" MAXLENGTH=\"2\" VALUE=\"1\">";
  echo "<INPUT CLASS=\"\" TYPE=\"hidden\" NAME=\"prc[2]\" VALUE=\"50\">";
  echo "&#160;";
  echo "<INPUT CLASS=\"\" TYPE=\"submit\" NAME=\"go\" VALUE=\"add\">";
  echo "</FORM>";
  
  echo "<BR>";
  
  echo "<FORM ENCTYPE=\"multipart/form-data\" CLASS=\"\" NAME=\"cartaddform[3]\" ACTION=\"\" METHOD=\"post\">";
  echo "MC  - $ 10&#160;";
  echo "<INPUT CLASS=\"\" TYPE=\"hidden\" NAME=\""._RUDWEB_PRE."cart_act\" VALUE=\"add\">";
  echo "<INPUT CLASS=\"\" TYPE=\"text\" NAME=\"qty[3]\" SIZE=\"1\" MAXLENGTH=\"2\" VALUE=\"1\">";
  echo "<INPUT CLASS=\"\" TYPE=\"hidden\" NAME=\"prc[3]\" VALUE=\"10\">";
  echo "&#160;";
  echo "<INPUT CLASS=\"\" TYPE=\"submit\" NAME=\"go\" VALUE=\"add\">";
  echo "</FORM>";
}
function showCart() {
  global $rudweb_skin;
  global $rudweb_cart;
  
  echo $rudweb_skin['crt']['hdr'];

  echo $rudweb_skin['crt']['pre'];
  
  echo "<HR>";
  
  echo "your cart: ";
  
  if ($rudweb_cart === NULL) {
    echo "cart is empty";
  }
  else if($rudweb_cart !== NULL) {
    echo "<BR>";
    echo "prd = ";
    if($rudweb_cart !== NULL) {echo count($rudweb_cart['qty']);} else {echo "00";}
    echo "<BR>";
    echo "qty = ";
    if($rudweb_cart !== NULL) {echo array_sum($rudweb_cart['qty']);} else {echo "00";}
    echo "<BR>";
    echo "tot = ";
    if($rudweb_cart !== NULL) {echo array_sum($rudweb_cart['stt']);} else {echo "00";}
    
    echo "<BR>";
    
    echo "<FORM ENCTYPE=\"multipart/form-data\" CLASS=\"\" NAME=\"myform\" ACTION=\"\" METHOD=\"post\">";
    echo "<INPUT CLASS=\"\" TYPE=\"hidden\" NAME=\""._RUDWEB_PRE."cart_act\" VALUE=\"mod\">";
    foreach ($rudweb_cart['prc'] as $pid => $prc) {
      echo "<INPUT CLASS=\"\" TYPE=\"hidden\" NAME=\"prc[".$pid."]\" VALUE=\"".$prc."\">";
    }
    foreach ($rudweb_cart['qty'] as $pid => $qty) {
      echo $rudweb_cart['prc'][$pid] . '$&#160;';
      echo "<INPUT CLASS=\"\" TYPE=\"text\" NAME=\"qty[".$pid."]\" SIZE=\"1\" MAXLENGTH=\"2\" VALUE=\"".$qty."\">";
      echo "&#160;";
      echo "<INPUT TYPE=\"checkbox\" NAME=\"del[".$pid."]\">";
      echo "<BR>";
      
    }
    echo "<INPUT CLASS=\"\" TYPE=\"submit\" NAME=\"go\" VALUE=\"mod\">";
    echo "</FORM>";
    
    echo "<BR>";
    
    echo "<FORM ENCTYPE=\"multipart/form-data\" CLASS=\"\" NAME=\"myform\" ACTION=\"\" METHOD=\"post\">";
    echo "<INPUT CLASS=\"\" TYPE=\"hidden\" NAME=\""._RUDWEB_PRE."cart_act\" VALUE=\"rst\">";
    echo "<INPUT CLASS=\"\" TYPE=\"submit\" NAME=\"go\" VALUE=\"empty\">";
    echo "</FORM>";
  }
  echo "<HR>";
  
  echo $rudweb_skin['crt']['suf'];
  echo $rudweb_skin['crt']['sep'];

  echo $rudweb_skin['crt']['ftr'];
}
?>