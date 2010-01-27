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
./setup/inc/rudweb.inc.php
12:50 2008-04-05
*/
echo "\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR><TD CLASS=\"hdr\" WIDTH=\"150\" STYLE=\"font-size: 11px; font-weight: bold\"><A CLASS=\"rudweb\" HREF=\"./setup.php\">"._RUDWEB_NAME." setup</A></TD><TD CLASS=\"hdr\">&#160;</TD><TD CLASS=\"hdr\">&#160;</TD></TR>";
echo "\n<TR><TD CLASS=\"hdr\" WIDTH=\"150\"STYLE=\"font-size: 10px; font-weight: bold\">version ".$ub_version['1'].".".$ub_version['2']." build ".$ub_version['4']."</TD><TD CLASS=\"hdr\" STYLE=\"font-size: 10px\">(released ".show_version_age($version_age[0]).")</TD><TD CLASS=\"hdr\">&#160;</TD></TR>";
echo "\n</TABLE>";
?>
