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
./setup/act/cfgs01.inc.php
12:50 2008-04-05
*/
echo "\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR><TD CLASS=\"total\" WIDTH=\"200\"><BR><B>Install Engine Configuration File:</B><BR></TD>";
echo "</TR></TABLE>";

$config_str = generate_config_str($eol, $file_time_stamp);
$config_file_check = check_cfg_file($target.$config_file_path, $config_file_name);

echo "\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR><TD CLASS=\"hdr\">".$target.$config_file_path."<B>".$config_file_name."</B></TD></TR>";
echo "\n</TABLE>";

echo "<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "<TR><TD CLASS=\"cnt\" WIDTH=\"100\" STYLE=\"text-align: right;\">status:</TD>";
echo "<TD CLASS=\"cnt\">";

switch($config_file_check) {
  case "0" : {
    echo "<SPAN CLASS=\"rst_ok\" STYLE=\"border-bottom-width: 0px;\">ok</SPAN>";
    echo "</TD></TR></TABLE>";

    echo "<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
    echo "<TR><TD CLASS=\"cnt\" WIDTH=\"100\" STYLE=\"text-align: right;\">writing file:</TD>";
    echo "<TD CLASS=\"cnt\">";
    echo "<SPAN CLASS=\"";
    $write_config_file = write_config_str($config_str, $target.$config_file_path.$config_file_name);
    if($write_config_file == '0') {
      echo "rst_ok\" STYLE=\"border-bottom-width: 0px;\">done";
    }
    else {
      echo "rst_err\" STYLE=\"border-bottom-width: 0px;\">error";
    }
    echo "</SPAN>";
    break;
  }
  case "1" : {
    echo "<SPAN CLASS=\"rst_err\" STYLE=\"border-bottom-width: 0px;\">directory doesn't exist</SPAN>";
    echo "</TD></TR></TABLE>";
    
    echo "<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
    echo "<TR><TD CLASS=\"cnt\" WIDTH=\"100\" STYLE=\"text-align: right;\">creating dir <B>".$config_file_path."</B></TD>";
    echo "<TD CLASS=\"cnt\">";
    if (!is_dir($target.$config_file_path)) {
      if(mkdir($target.$config_file_path)) {echo "<SPAN CLASS=\"rst_ok\" STYLE=\"border-bottom-width: 0px;\">done</SPAN>";}
      else {echo "<SPAN CLASS=\"rst_err\" STYLE=\"border-bottom-width: 0px;\">error creating dir!</SPAN>";}
    } 
    else {echo "<SPAN CLASS=\"rst_err\" STYLE=\"border-bottom-width: 0px;\">directory already exists!</SPAN>";}
    echo "</TD></TR></TABLE>";
    
    echo "<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
    echo "<TR><TD CLASS=\"cnt\" WIDTH=\"100\" STYLE=\"text-align: right;\">writing file:</TD>";
    echo "<TD CLASS=\"cnt\">";
    echo "<SPAN CLASS=\"";
    $write_config_file = write_config_str($config_str, $target.$config_file_path.$config_file_name);
    if($write_config_file == '0') {
      echo "rst_ok\" STYLE=\"border-bottom-width: 0px;\">done";
    }
    else {
      echo "rst_err\" STYLE=\"border-bottom-width: 0px;\">error";
    }
    echo "</SPAN>";
    break;
  }
  case "2" : {
    echo "<SPAN CLASS=\"rst_err\" STYLE=\"border-bottom-width: 0px;\">directory not writable!</SPAN>";
    echo "</TD></TR></TABLE>";

    echo "<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
    echo "<TR><TD CLASS=\"cnt\" WIDTH=\"100\" STYLE=\"text-align: right;\">writing file:</TD>";
    echo "<TD CLASS=\"cnt\">";
    echo "<SPAN CLASS=\"";
    $write_config_file = write_config_str($config_str, $target.$config_file_path.$config_file_name);
    if($write_config_file == '0') {
      echo "rst_ok\" STYLE=\"border-bottom-width: 0px;\">done";
    }
    else {
      echo "rst_err\" STYLE=\"border-bottom-width: 0px;\">error";
    }
    echo "</SPAN>";
    break;
  }
  case "3" : {
    echo "<SPAN CLASS=\"rst_err\" STYLE=\"border-bottom-width: 0px;\">file already exists!</SPAN>";
    echo "</TD></TR></TABLE>";

    echo "<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
    echo "<TR><TD CLASS=\"cnt\" WIDTH=\"100\" STYLE=\"text-align: right;\">over-writing file:</TD>";
    echo "<TD CLASS=\"cnt\">";
    echo "<SPAN CLASS=\"";
    $write_config_file = write_config_str($config_str, $target.$config_file_path.$config_file_name);
    if($write_config_file == '0') {
      echo "rst_ok\" STYLE=\"border-bottom-width: 0px;\">ok";
    }
    else {
      echo "rst_err\" STYLE=\"border-bottom-width: 0px;\">error";
    }
    echo "</SPAN>";
    break;
  }
  case "4" : {
    echo "<SPAN CLASS=\"rst_err\" STYLE=\"border-bottom-width: 0px;\">file already exists and not writable!</SPAN>";
    echo "</TD></TR></TABLE>";

    echo "<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
    echo "<TR><TD CLASS=\"cnt\" WIDTH=\"100\" STYLE=\"text-align: right;\">over-writing file:</TD>";
    echo "<TD CLASS=\"cnt\">";
    echo "<SPAN CLASS=\"";
    $write_config_file = write_config_str($config_str, $target.$config_file_path.$config_file_name);
    if($write_config_file == '0') {
      echo "rst_ok\" STYLE=\"border-bottom-width: 0px;\">ok";
    }
    else {
      echo "rst_err\" STYLE=\"border-bottom-width: 0px;\">error";
    }
    echo "</SPAN>";
    break;
  }
  default  : {
    echo "</TD></TR></TABLE>";

    echo "<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
    echo "<TR><TD CLASS=\"cnt\" WIDTH=\"100\" STYLE=\"text-align: right;\">writing file:</TD>";
    echo "<TD CLASS=\"cnt\">";
    echo "<SPAN CLASS=\"";
    echo "rst_err\" STYLE=\"border-bottom-width: 0px;\">error";
    echo "</SPAN>";
    break;
  }
}
echo "</TD></TR></TABLE>";
?>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="100" STYLE="text-align: right;"><B>&#160;</B></TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="formnext" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=cfgs&amp;step=2">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #DDDDDD" NAME="next" VALUE="next">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>

<!--
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="100" STYLE="text-align: right;"><B>&#160;</B></TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="formback" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=usett&amp;step=2">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #CCCCCC" NAME="back" VALUE="back">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>
-->

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="100" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="formabort" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #BBBBBB" NAME="abort" VALUE="abort">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>