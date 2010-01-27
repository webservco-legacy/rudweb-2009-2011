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
./setup/act/lngs02.inc.php
12:50 2008-04-05
*/
if(isset($_POST['set_cfg_ln_inst'])) {
  echo "\n\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
  
  foreach ($_POST['set_cfg_ln_inst'] as $ln => $value) {
    echo "\n<TR><TD CLASS=\"hdr\" WIDTH=\"200\"><B>$ln</B></TD><TD CLASS=\"hdr\" COLSPAN=\"3\">&#160;</TD></TR>";
    $cfg_ln_check_target = check_cfg_file($target.$lang_file_path, $lang_file_name);
    if($cfg_ln_check_target == '0') {
      $dirs[0] = 'inc/langs/'.$ln.'/';
      $files[$dirs[0]][0] = array();
      $files[$dirs[0]][1] = array();
      $files[$dirs[0]][1][] = 'index.php';
      $files[$dirs[0]][1][] = 'lang.inc.php';
      $files[$dirs[0]][1][] = 'lang.info.php';
      $files[$dirs[0]][1][] = 'usrmail.inc.php';
      require "./act/engnact.inc.php";
      unset($dirs);
      unset($files);
    }
    else {
      echo "\n<TR CLASS=\"hdr\"><TD CLASS=\"rst_err\" STYLE=\"border-bottom-width: 0px;\" COLSPAN=\"4\"><B>target directory doesn't exist!</B></TD></TR>";
    }
    if(isset($_POST['set_cfg_ln_cfg'][$ln])) {
      $cfg_ln_str[$ln] = generate_lncfg_str($eol, $file_time_stamp, $ln);
      $cfg_ln_check    = check_cfg_file($target.$lang_file_path.$ln.'/', $lang_file_name);
      echo "<TR CLASS=\"cnt\"><TD CLASS=\"act\">creating file</TD><TD CLASS=\"nam\">./".$lang_file_path.$ln.'/'.$lang_file_name."</TD>";
      switch($cfg_ln_check) {
        case "0" : {
          echo "<TD CLASS=\"msg\">...</TD><TD CLASS=\"";
          $write_lang_file = write_config_str($cfg_ln_str[$ln], $target.$lang_file_path.$ln.'/'.$lang_file_name);
          if($write_lang_file == '0') {
            echo "rst_ok\">done</TD></TR>";
          }
          else {
            echo "rst_err\">error</TD></TR>";
          }
          break;
        }
        case "1" : {
          echo "<TD CLASS=\"msg\">directory doesn't exist!</TD><TD CLASS=\"";
          echo "rst_err\">error</TD></TR>";
          break;
        }
        case "2" : {
          echo "<TD CLASS=\"msg\">directory isn't writble!</TD><TD CLASS=\"";
          echo "rst_err\">error</TD></TR>";
          break;
        }
        case "3" : {
          echo "<TD CLASS=\"msg\">file exists ... over-writing</TD><TD CLASS=\"";
          $write_lang_file = write_config_str($cfg_ln_str[$ln], $target.$lang_file_path.$ln.'/'.$lang_file_name);
          if($write_lang_file == '0') {
            echo "rst_ok\">done</TD></TR>";
          }
          else {
            echo "rst_err\">error</TD></TR>";
          }
          break;
        }
        case "4" : {
          echo "<TD CLASS=\"msg\">file exists ... read-only</TD><TD CLASS=\"";
          echo "rst_err\">error</TD></TR>";
          break;
        }
      }
      
    }
  }
  echo "\n</TABLE>";
}
else {
  echo "\n\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
  echo "\n<TR CLASS=\"hdr\"><TD CLASS=\"rst_err\" STYLE=\"border-bottom-width: 0px;\" WIDTH=\"200\"><B>no languages selected</B></TD></TR>";
  echo "\n</TABLE>";
}
?>
<BR>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right;"><B>&#160;</B></TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="formnext" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=skins&amp;step=1">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #DDDDDD" NAME="next" VALUE="next">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right;"><B>&#160;</B></TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="formback" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=lngs&amp;step=1">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #CCCCCC" NAME="back" VALUE="back">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="formabort" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #BBBBBB" NAME="abort" VALUE="abort">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>