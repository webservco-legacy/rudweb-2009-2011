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
./setup/act/startr.inc.php
12:50 2008-04-05
*/
echo "\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR><TD CLASS=\"ttt\" WIDTH=\"200\"><B>Index</B></TD>";
echo "</TR></TABLE>";

$version_check_error = '0';
$version_compare_error = '0';
$target_dir_error = '0';

echo "\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR><TD CLASS=\"cnt\" WIDTH=\"110\" STYLE=\"text-align: right\"><B>engine:</B></TD>";
echo "\n<TD CLASS=\"cnt\">";
if($cl_version['0'] == '0.0.000000') {
  echo " not installed";
  $version_check_error = '1';
}
else {
  echo $cl_version['1'] . '.' .$cl_version['2'] . " build ".$cl_version[4]." (".$version_age[2]." days old, released " . show_version_age($version_age[1]) . ")";
}
echo "</TD></TR>";

echo "\n<TR><TD CLASS=\"cnt\" STYLE=\"text-align: right\"><B>status:</B></TD>";
echo "\n<TD CLASS=\"cnt\">";
echo "<I>".show_compare_version($compare_version)."</I>";
echo "</TD></TR>";
if($compare_version == '0') {$version_compare_error = '1';}

echo "\n<TR><TD CLASS=\"cnt\" STYLE=\"text-align: right\"><B>setup:</B></TD>";
echo "\n<TD CLASS=\"cnt\">";
echo $set;
echo "</TD></TR>";

echo "\n<TR><TD CLASS=\"cnt\" STYLE=\"text-align: right\"><B>target:</B></TD>";
echo "\n<TD CLASS=\"cnt\">";
if (!is_dir($target)) {
  echo "<SPAN CLASS=\"rst_err\" STYLE=\"border-bottom-width: 0px;\">not found</SPAN>";
  $target_dir_error = '1';
} 
else {echo "<SPAN CLASS=\"rst_ok\" STYLE=\"border-bottom-width: 0px;\">exists</SPAN>";}
echo "</TD></TR>";

echo "</TABLE>";
?>
<?php 
$db_settings = get_dbsettings($target_root . $target_vars[$pid]);
?>
<FORM NAME="removeformproceed" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=verif&amp;step=1">

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<?php if($set == 'remove' && ($version_check_error == '0' && ($version_compare_error == '0' && ($target_dir_error == '0' && is_array($db_settings))))) { ?>
<TR><TD CLASS="cnt" WIDTH="110" STYLE="text-align: right;"><B>&#160;</B></TD>
<TD CLASS="cnt">
<INPUT TYPE="hidden" NAME="set_dbtype" VALUE="<?php echo $db_settings['dbtype'];?>">
<INPUT TYPE="hidden" NAME="set_dbport" VALUE="<?php echo $db_settings['dbport'];?>">
<INPUT TYPE="hidden" NAME="set_dbhost" VALUE="<?php echo $db_settings['dbhost'];?>">
<INPUT TYPE="hidden" NAME="set_dbuser" VALUE="<?php echo $db_settings['dbuser'];?>">
<INPUT TYPE="hidden" NAME="set_dbpass" VALUE="<?php echo $db_settings['dbpass'];?>">
<INPUT TYPE="hidden" NAME="set_dbname" VALUE="<?php echo $db_settings['dbname'];?>">
<INPUT TYPE="hidden" NAME="set_pre" VALUE="<?php echo $db_settings['rudwebpre'];?>">
</TD></TR>

<TR><TD CLASS="cnt" WIDTH="110" STYLE="text-align: right;">
<INPUT CLASS="general" TYPE="checkbox" NAME="remove_db_data"<?php if(isset($_SESSION['rudwebset_cfg_remove_db_data']) && $_SESSION['rudwebset_cfg_remove_db_data'] == 'on') {echo ' CHECKED';}?>>
</TD>
<TD CLASS="cnt">
Remove Database Data
</TD></TR>

<TR><TD CLASS="cnt" WIDTH="110" STYLE="text-align: right;">
<INPUT CLASS="general" TYPE="checkbox" NAME="remove_db_tables"<?php if(isset($_SESSION['rudwebset_cfg_remove_db_tables']) && $_SESSION['rudwebset_cfg_remove_db_tables'] == 'on') {echo ' CHECKED';}?>>
</TD>
<TD CLASS="cnt">
Remove Database Tables
</TD></TR>

<TR><TD CLASS="cnt" WIDTH="110" STYLE="text-align: right;">
<INPUT CLASS="general" TYPE="checkbox" NAME="remove_user_files"<?php if(isset($_SESSION['rudwebset_cfg_remove_user_files']) && $_SESSION['rudwebset_cfg_remove_user_files'] == 'on') {echo ' CHECKED';}?>>
</TD>
<TD CLASS="cnt">
Remove User Files
</TD></TR>

<TR><TD CLASS="cnt" WIDTH="110" STYLE="text-align: right;">
<INPUT CLASS="general" TYPE="checkbox" NAME="remove_engine_files"<?php if(isset($_SESSION['rudwebset_cfg_remove_engine_files']) && $_SESSION['rudwebset_cfg_remove_engine_files'] == 'on') {echo ' CHECKED';}?>>
</TD>
<TD CLASS="cnt">
Remove Engine Files
</TD></TR>

<TR><TD CLASS="cnt" WIDTH="110" STYLE="text-align: right;"><B>&#160;</B></TD>
<TD CLASS="cnt">
  <BR>
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #CCCCCC" NAME="proceed" VALUE="proceed">
  </TD>
  </TR></TABLE>
</TD></TR>
<?php } ?>
</TABLE>
</FORM>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="110" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="verifformabort" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #BBBBBB" NAME="abort" VALUE="abort">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>