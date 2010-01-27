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
./inc/adm/about.inc.php
11:23 2008-06-27
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}
if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 0) {
  echo $rudweb_skin['cnt']['tt1']['pre'];
  echo _RUDWEB_WSTT. ' - ' . $rudweb_ln['about'];
  echo $rudweb_skin['cnt']['tt1']['suf'];
  
  echo $rudweb_skin['cnt']['txt']['pre'];
?>
<A CLASS="default" REL="lightbox" HREF="<?php echo _RUDWEB_SITE_URL?>rudweb.php" TITLE="<?php echo $rudweb_ln['about']; ?>">
<IMG SRC="<?php echo _RUDWEB_SITE_URL?>rudweb.php" WIDTH="390" HEIGHT="390" TITLE="<?php echo $rudweb_ln['about']; ?>" ALT="<?php echo $rudweb_ln['about']; ?>">
</A>
<?php  
  
  echo $rudweb_skin['cnt']['txt']['suf'];
} // if user has the rights
else {
  echo "<DIV CLASS=\"err\">" . $rudweb_ln['err']['1'] . "</DIV>";
} // else if user has no rights
?>