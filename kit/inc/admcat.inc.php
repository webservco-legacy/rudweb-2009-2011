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
./inc/admcat.inc.php
16:58 2008-05-27
*/
if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 5 && $new_onoff !== "") {
  changedbcfg("CAT", $new_onoff, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/catmoda';
}
if(isValidInt($new_ipg)) {
  changedbcfg("CAT_IPG", $new_ipg, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/catmod/act/set';
}
if(isValidInt($new_pcs)) {
  changedbcfg("CAT_PCS", $new_pcs, $action_date, $action_time);
  $redirect = _RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'admin/catmod/act/set';
}
?>