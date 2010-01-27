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
* Show contact form
*
* <I>./inc/adm/contact.inc.php</I>
* <BR>Shows a contact form
* 
* @author Radu Maier <rudisoft@rudisoft.net>
* @copyright Copyright (c) 2007-2008, Radu Maier
* @license http://opensource.org/licenses/gpl-2.0.php
* @version 14:28 2008-06-27
* @access public
* @package RudWEb
* @subpackage Modules
* @since 17:58 2008-05-31
* @todo Stuff
*/

/**
* Authorized access only
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

if (isset($_GET['form']) && isValidInt(rudweb_filter_input($_GET['form']))) {
  $con_cat_id = rudweb_filter_input($_GET['form']);
  
  $con_cat_tt = '';
  $query_cat  = "SELECT con_cat_tt FROM ". _RUDWEB_PRE. "con_cat WHERE con_cat_id = '".$con_cat_id."' LIMIT 1";
  $result_cat = rudweb_qres($rudweb_dbtype, $query_cat);
  $cat_row    = rudweb_fetch_assoc($rudweb_dbtype, $result_cat);
  $con_cat_tt = $cat_row['con_cat_tt'];
  
  echo $rudweb_skin['con']['pre'];
  echo $rudweb_skin['cnt']['tt1']['pre'];
  echo $rudweb_ln['con']['tt'] . ' - ' . $con_cat_tt;
  echo $rudweb_skin['cnt']['tt1']['suf'];
  
  echo $rudweb_skin['cnt']['txt']['pre'];
  showContactForm($con_cat_id);
  echo $rudweb_skin['cnt']['txt']['suf'];
  echo $rudweb_skin['con']['suf'];
}
else {
  echo $rudweb_skin['con']['pre'];
  echo $rudweb_skin['cnt']['tt1']['pre'];
  echo $rudweb_ln['con']['tt'];
  echo $rudweb_skin['cnt']['tt1']['suf'];
  
  echo $rudweb_skin['cnt']['txt']['pre'];
  showContactForm(0);
  echo $rudweb_skin['cnt']['txt']['suf'];
  echo $rudweb_skin['con']['suf'];
}
?>