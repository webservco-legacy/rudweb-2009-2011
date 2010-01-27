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
./setup/inc/projects.inc.php
12:55 2008-05-21
*/
echo "\n\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR><TD CLASS=\"total\">";
echo "<BR><B>Projects:</B><BR>";
echo "\n</TD></TR>";
echo "</TABLE>";

echo "\n\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR>";
echo "\n<TD CLASS=\"projht\">";
echo "\nproject";
echo "\n</TD>";
echo "\n<TD CLASS=\"projht\" WIDTH=\"\">";
echo "\nengine version";
echo "\n</TD>";
echo "\n<TD CLASS=\"projht\" WIDTH=\"\">";
echo "\nurl";
echo "\n</TD>";
echo "\n<TD CLASS=\"projht\" WIDTH=\"\">";
echo "\ndir";
echo "\n</TD>";
echo "\n<TD CLASS=\"projht\" WIDTH=\"\">";
echo "\nactions";
echo "\n</TD>";
echo "\n<TD CLASS=\"projht\">";
echo "\n&#160;";
echo "\n</TD>";
echo "\n</TR>";
for($target_tt_i=1; $target_tt_i<=count($target_vars); $target_tt_i++) {
  echo "\n<TR>";
  echo "\n<TD CLASS=\"proj\">";
  echo "<B>";
  echo $target_name[$target_tt_i];
  echo "</B>";
  echo "\n</TD>";
  echo "\n<TD CLASS=\"proj\">";
  $project_version[$target_tt_i] = get_version($target_root . $target_vars[$target_tt_i]);

  if($project_version[$target_tt_i][0] == '0.0.000000') {
    echo "<SPAN STYLE=\"color: #990000\">not installed</SPAN>";
  }
  else {
    echo "<SPAN STYLE=\"color: ";
    if($project_version[$target_tt_i][0] == $ub_version[0]) {echo "#009900";}
    else if($project_version[$target_tt_i][0] != $ub_version[0]) {echo "#990000";}
    echo "\">";
    echo $project_version[$target_tt_i][1] . '.' . $project_version[$target_tt_i][2] . ' build ' . $project_version[$target_tt_i][4];
    echo "</SPAN>";
  }
  echo "\n</TD>";
  
  echo "\n<TD CLASS=\"proj\">";
  echo "\n<A CLASS=\"link\" HREF=\"".$target_url[$target_tt_i]."\" TARGET=\"_blank\">".$target_url[$target_tt_i]."</A>";
  echo "\n</TD>";
  
  echo "\n<TD CLASS=\"proj\">";
  echo "\n".$target_root . $target_vars[$target_tt_i];
  echo "\n</TD>";
  echo "\n<TD CLASS=\"proj\">";
  echo "\n<A CLASS=\"link\" HREF=\"./setup.php?pid=".$target_tt_i."&amp;set=install&amp;act=start&amp;step=1\">install</A>";
  echo "&#160;";
  echo "\n<A CLASS=\"link\" HREF=\"./setup.php?pid=".$target_tt_i."&amp;set=upgrade&amp;act=start&amp;step=1\">upgrade</A>";
  echo "&#160;";
  echo "\n<A CLASS=\"link\" HREF=\"./setup.php?pid=".$target_tt_i."&amp;set=remove&amp;act=start&amp;step=1\">remove</A>";
  echo "\n</TD>";
  echo "\n<TD CLASS=\"proj\">";
  echo "\n&#160;";
  echo "\n</TD>";
  echo "\n</TR>";
}
//echo "\n\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR>";
echo "\n<TD CLASS=\"projhb\" COLSPAN=\"6\">&#160;</TD>";
echo "</TR>";
echo "</TABLE>";
?>
