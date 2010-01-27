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
./inc/admnws.inc.php
10:42 2008-05-26
*/
if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 5 && $new_onoff !== "") {
  changedbcfg("NWS", $new_onoff, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/nwsmoda';
}
if(isValidInt($nws_lmt1)) {
  changedbcfg("NWS_LMT1", $nws_lmt1, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/nwsmod';
}
if(isValidInt($nws_lmt2)) {
  changedbcfg("NWS_LMT2", $nws_lmt2, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/nwsmod';
}
?>