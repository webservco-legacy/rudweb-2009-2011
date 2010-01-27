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
./inc/js/jsfunc.inc.php
14:11 2008-07-18
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}
?>
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">
window.defaultStatus = "<?php echo $rudweb_ln['WinStatDef']; ?>";
var fileLoadingImage = "<?php echo _RUDWEB_SKIN_URL . $_SESSION[_RUDWEB_PRE.'usr_skin_dir']?>/graphics/loading.gif";		
var fileBottomNavCloseImage = "<?php echo _RUDWEB_SKIN_URL . $_SESSION[_RUDWEB_PRE.'usr_skin_dir']?>/graphics/close.gif";
function toggleLayer( whichLayer ) {
  var elem, vis;
  if( document.getElementById ) // this is the way the standards work
    elem = document.getElementById( whichLayer );
  else if( document.all ) // this is the way old msie versions work
      elem = document.all[whichLayer];
  else if( document.layers ) // this is the way nn4 works
    elem = document.layers[whichLayer];
  vis = elem.style;
  // if the style.display value is blank we try to figure it out here
  if(vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined)
    vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';
  vis.display = (vis.display==''||vis.display=='block')?'none':'block';
}
function copyvalue(element_from,element_to) {
  element_to.value = element_from.value
}
/*
http://image-opacity.4wsearch.com/
the JS code
*/
function bevisible(cur,which)	{
	if(document.getElementById) {
		if (which==0) {
			if(document.all) {
				cur.filters.alpha.opacity=100
      }
			else {
				cur.style.setProperty("-moz-opacity", 1, "");
      }
		}
		else {
			if(document.all) {
				cur.filters.alpha.opacity=80
      }  
			else {
				cur.style.setProperty("-moz-opacity", .8, "");
      }
		}
	}
}
function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
function addTag(newvalue,element_to) {
  element_to.value = element_to.value + newvalue + ', ';
}
function printandclose() {
  window.print();
  window.close();
}
</SCRIPT>