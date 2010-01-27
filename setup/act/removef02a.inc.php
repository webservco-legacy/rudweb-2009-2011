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
./setup/act/removef02a.inc.php
14:28 2008-06-27
*/

echo "\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR><TD CLASS=\"ttt\" WIDTH=\"200\"><B>Includes</B></TD>";
echo "</TR></TABLE>";

$dirs[4]    = "inc/";
$files[$dirs[4]][0] = array();
$files[$dirs[4]][1] = array();
$files[$dirs[4]][1][] = "admcat.inc.php";
$files[$dirs[4]][1][] = "admcmt.inc.php";
$files[$dirs[4]][1][] = "admcnt.inc.php";
$files[$dirs[4]][1][] = "admcon.inc.php";
$files[$dirs[4]][1][] = "admcsp.inc.php";
$files[$dirs[4]][1][] = "admftr.inc.php";
$files[$dirs[4]][1][] = "admin.inc.php";
$files[$dirs[4]][1][] = "admnws.inc.php";
$files[$dirs[4]][1][] = "admtag.inc.php";
$files[$dirs[4]][1][] = "content.inc.php";
$files[$dirs[4]][1][] = "contentadm.inc.php";
$files[$dirs[4]][1][] = "index.php";
$files[$dirs[4]][1][] = "login.inc.php";
$files[$dirs[4]][1][] = "phphd.inc.php";
//$files[$dirs[4]][1][] = "phphda.inc.php";
$files[$dirs[4]][1][] = "phphdi.inc.php";
$files[$dirs[4]][1][] = "phphdp.inc.php";
$files[$dirs[4]][1][] = "rudweb1.inc.php";
$files[$dirs[4]][1][] = "rudweb2.inc.php";
$files[$dirs[4]][1][] = "rudweb3.inc.php";
$files[$dirs[4]][1][] = "rudwebc.inc.php";
$files[$dirs[4]][1][] = "rudwebf.inc.php";
$files[$dirs[4]][1][] = "rudwebm.inc.php";

$dirs[3] = "inc/adm/";
$files[$dirs[3]][0] = array();
$files[$dirs[3]][1] = array();
$files[$dirs[3]][1][] = "about.inc.php";
$files[$dirs[3]][1][] = "actuser.inc.php";
$files[$dirs[3]][1][] = "admin.inc.php";
$files[$dirs[3]][1][] = "catmod.inc.php";
$files[$dirs[3]][1][] = "catmoda.inc.php";
$files[$dirs[3]][1][] = "cmtmod.inc.php";
$files[$dirs[3]][1][] = "cmtmoda.inc.php";
$files[$dirs[3]][1][] = "cntadd.inc.php";
$files[$dirs[3]][1][] = "conmod.inc.php";
$files[$dirs[3]][1][] = "conmoda.inc.php";
$files[$dirs[3]][1][] = "contact.inc.php";
$files[$dirs[3]][1][] = "cspmod.inc.php";
$files[$dirs[3]][1][] = "cspmoda.inc.php";
$files[$dirs[3]][1][] = "cspmodforms.inc.php";
$files[$dirs[3]][1][] = "default.inc.php";
$files[$dirs[3]][1][] = "ftrmod.inc.php";
$files[$dirs[3]][1][] = "ftrmoda.inc.php";
$files[$dirs[3]][1][] = "ftrmodforms.inc.php";
$files[$dirs[3]][1][] = "index.php";
$files[$dirs[3]][1][] = "itemadd.inc.php";
$files[$dirs[3]][1][] = "itemform.inc.php";
$files[$dirs[3]][1][] = "lostpass.inc.php";
$files[$dirs[3]][1][] = "news.inc.php";
$files[$dirs[3]][1][] = "newuser.inc.php";
$files[$dirs[3]][1][] = "newuserform.inc.php";
$files[$dirs[3]][1][] = "nwsmod.inc.php";
$files[$dirs[3]][1][] = "nwsmoda.inc.php";
$files[$dirs[3]][1][] = "tagmod.inc.php";
$files[$dirs[3]][1][] = "tagmoda.inc.php";
$files[$dirs[3]][1][] = "tagmodforms.inc.php";
$files[$dirs[3]][1][] = "tags.inc.php";

$dirs[2] = "inc/cat/";
$files[$dirs[2]][0] = array();
$files[$dirs[2]][1] = array();
$files[$dirs[2]][1][] = "index.php";
$files[$dirs[2]][1][] = "item.inc.php";
$files[$dirs[2]][1][] = "items.inc.php";
$files[$dirs[2]][1][] = "main.inc.php";

$dirs[1] = "inc/js/";
$files[$dirs[1]][0] = array();
$files[$dirs[1]][1] = array();
$files[$dirs[1]][1][] = "accordion.js";
$files[$dirs[1]][1][] = "CalendarPopup.js";
$files[$dirs[1]][1][] = "editor.js";
$files[$dirs[1]][1][] = "effects.js";
$files[$dirs[1]][1][] = "lightbox.js";
$files[$dirs[1]][1][] = "moo.fx.js";
$files[$dirs[1]][1][] = "moo.fx.pack.js";
$files[$dirs[1]][1][] = "moo.fx.transitions.js";
$files[$dirs[1]][1][] = "moo.fx.utils.js";
$files[$dirs[1]][1][] = "prototype.js";
$files[$dirs[1]][1][] = "scriptaculous.js";
$files[$dirs[1]][1][] = "index.php";
$files[$dirs[1]][1][] = "jsfunc.inc.php";

$dirs[0] = "inc/mod/";
$files[$dirs[0]][0] = array();
$files[$dirs[0]][1] = array();
$files[$dirs[0]][1][] = "index.php";
$files[$dirs[0]][1][] = "modadm.inc.php";
$files[$dirs[0]][1][] = "modcart.inc.php";
$files[$dirs[0]][1][] = "modcat.inc.php";
$files[$dirs[0]][1][] = "modcmt.inc.php";
$files[$dirs[0]][1][] = "modcon.inc.php";
$files[$dirs[0]][1][] = "modcpy.inc.php";
$files[$dirs[0]][1][] = "modcsp.inc.php";
$files[$dirs[0]][1][] = "moddebug.inc.php";
$files[$dirs[0]][1][] = "modftr.inc.php";
$files[$dirs[0]][1][] = "modlang.inc.php";
$files[$dirs[0]][1][] = "modnws.inc.php";
$files[$dirs[0]][1][] = "modsmap.inc.php";
$files[$dirs[0]][1][] = "modsrc.inc.php";
$files[$dirs[0]][1][] = "modstats.inc.php";
$files[$dirs[0]][1][] = "modtagsc.inc.php";
$files[$dirs[0]][1][] = "modskin.inc.php";
$files[$dirs[0]][1][] = "modtimer.inc.php";
$files[$dirs[0]][1][] = "moduser.inc.php";
$files[$dirs[0]][1][] = "modyah.inc.php";
?>