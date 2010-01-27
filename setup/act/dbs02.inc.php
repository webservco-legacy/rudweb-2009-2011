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
./setup/act/dbs02.inc.php
12:50 2008-04-05
*/
echo "\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR><TD CLASS=\"ttt\" WIDTH=\"200\"><B>Create Tables</B></TD>";
echo "</TR></TABLE>";
?>
<?php
$sql_s_file = $source_root . 'setup/cfg/' . $sql_file_name;
$sql_s = file_get_contents($sql_s_file);
$sql_s = eregi_replace("rudweb_", $_SESSION['rudwebset_set_pre']."_", $sql_s);
if($_SESSION['rudwebset_set_dbmy'] <= '40') {$myisam_str = 'TYPE=MyISAM';}
else {$myisam_str = 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';}
$sql_s = eregi_replace("myisam_str", $myisam_str, $sql_s);
$sql_s = split_sql($sql_s, $sql_delimiter);
$sql_t = count($sql_s);
$tables_t = round($sql_t / 2);

$dbs_err = '0';

echo "\n\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR><TD CLASS=\"hdr\" WIDTH=\"200\"><B>$tables_t tables, $sql_t queries</B></TD><TD CLASS=\"hdr\" COLSPAN=\"3\">&#160;</TD></TR>";
rudweb_dbopen($_SESSION['rudwebset_set_dbtype'], $_SESSION['rudwebset_set_dbhost'], $_SESSION['rudwebset_set_dbport'], $_SESSION['rudwebset_set_dbuser'], $_SESSION['rudwebset_set_dbpass'], $_SESSION['rudwebset_set_dbname']);
for($di = 0; $di < $sql_t; $di++) {
  $dii = $di+1;
  echo "\n<TR CLASS=\"cnt\"><TD CLASS=\"act\">executing query</TD><TD CLASS=\"nam\">$dii</TD>";
  $query[$di]        = $sql_s[$di];
  echo "<TD CLASS=\"msg\">";
  $result[$di]       = rudweb_qres($_SESSION['rudwebset_set_dbtype'], $query[$di]);
  if($result[$di] === TRUE) {
    echo "ok</TD>";
    echo "<TD CLASS=\"rst_ok\">done</TD></TR>";
  }
  else {
    echo "$result[$di]</TD>";
    echo "<TD CLASS=\"rst_err\">error</TD></TR>";
    $dbs_err = '1';
  }
  
}
rudweb_dbclose($_SESSION['rudwebset_set_dbtype'], rudweb_dbopen($_SESSION['rudwebset_set_dbtype'], $_SESSION['rudwebset_set_dbhost'], $_SESSION['rudwebset_set_dbport'], $_SESSION['rudwebset_set_dbuser'], $_SESSION['rudwebset_set_dbpass'], $_SESSION['rudwebset_set_dbname']));
echo "\n</TABLE>";
?>
<?php
if ($dbs_err == '0') {
?>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="formnext" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=dbs&amp;step=3">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #CCCCCC" NAME="next" VALUE="next">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>
<?php } ?>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="verifformback" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=dbs&amp;step=1">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #CCCCCC" NAME="back" VALUE="back">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="verifformabort" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #BBBBBB" NAME="abort" VALUE="abort">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>