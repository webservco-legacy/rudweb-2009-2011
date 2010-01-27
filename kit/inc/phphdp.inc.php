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
./inc/phphdp.inc.php
14:11 2008-07-18
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">";
echo "\n<HTML>\n<HEAD>";
genHtmlHeader($rudweb_page_title, $rudweb_page_description, $rudweb_page_keywords);
echo "\n<!--[if IE]>";
echo "\n<STYLE type=\"text/css\">";
echo "\nIMG.op { filter:alpha(opacity=80); }";
echo "\n</STYLE>";
echo "\n<![endif]-->";
echo "\n<STYLE type=\"text/css\">";
echo "\n<!--";
echo "\nIMG.op { -moz-opacity: .8;}";
echo "\n-->";
echo "\n</STYLE>";
require_once _RUDWEB_SKIN_DIR . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'] . '/style.inc.php';
echo "\n<SCRIPT TYPE=\"text/javascript\" LANGUAGE=\"JavaScript\" SRC=\""._RUDWEB_JS_URL."CalendarPopup.js\"></SCRIPT>";
// de aici
echo "\n<SCRIPT TYPE=\"text/javascript\" LANGUAGE=\"JavaScript\" SRC=\""._RUDWEB_JS_URL ."prototype.js\"></SCRIPT>";
// lightbox
echo "\n<SCRIPT TYPE=\"text/javascript\" LANGUAGE=\"JavaScript\" SRC=\""._RUDWEB_JS_URL ."scriptaculous.js?load=effects\"></SCRIPT>";
echo "\n<SCRIPT TYPE=\"text/javascript\" LANGUAGE=\"JavaScript\" SRC=\""._RUDWEB_JS_URL ."lightbox.js\"></SCRIPT>";
// moo.fx
//echo "\n<SCRIPT TYPE=\"text/javascript\" LANGUAGE=\"JavaScript\" SRC=\""._RUDWEB_JS_URL ."moo.fx.js\"></SCRIPT>";
//echo "\n<SCRIPT TYPE=\"text/javascript\" LANGUAGE=\"JavaScript\" SRC=\""._RUDWEB_JS_URL ."moo.fx.pack.js\"></SCRIPT>"; // OPT
//echo "\n<SCRIPT TYPE=\"text/javascript\" LANGUAGE=\"JavaScript\" SRC=\""._RUDWEB_JS_URL ."moo.fx.utils.js\"></SCRIPT>"; // OPT
//echo "\n<SCRIPT TYPE=\"text/javascript\" LANGUAGE=\"JavaScript\" SRC=\""._RUDWEB_JS_URL ."accordion.js\"></SCRIPT>"; // OPT
//echo "\n<SCRIPT TYPE=\"text/javascript\" LANGUAGE=\"JavaScript\" SRC=\""._RUDWEB_JS_URL ."moo.fx.transitions.js\"></SCRIPT>"; // OPT
// default scripts
echo "\n";
require_once _RUDWEB_JS_DIR . 'jsfunc.inc.php';
// user's scripts
echo "\n";
require_once _RUDWEB_SKIN_DIR . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'] . '/scripts/js.inc.php';
echo "\n";
// DIRTY SOLUTION FOR DEZY DESIGN
//echo "\n</HEAD>\n<BODY onload=\"StartClock()\" onunload=\"KillClock()\">\n\n";
echo "\n</HEAD>\n<BODY onLoad=\"JavaScript:printandclose();\">\n\n";
require_once _RUDWEB_SKIN_DIR . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'] . '/layout.print.inc.php';
rudweb_dbclose($rudweb_dbtype, rudweb_dbopen($rudweb_dbtype, $rudweb_dbhost, $rudweb_dbport, $rudweb_dbuser, $rudweb_dbpass, $rudweb_dbname));
echo "\n\n</BODY>\n</HTML>";
?>