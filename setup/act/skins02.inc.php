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
./setup/act/skins02.inc.php
09:35 2008-04-21
*/

if(isset($_POST['set_cfg_sk_inst'])) {
  echo "\n\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
  foreach ($_POST['set_cfg_sk_inst'] as $skin => $value) {
    echo "\n<TR><TD CLASS=\"hdr\" WIDTH=\"200\"><B>$skin</B></TD><TD CLASS=\"hdr\" COLSPAN=\"3\">&#160;</TD></TR>";
    $cfg_skin_check_target = check_cfg_file($target.$skin_file_path, $skin_file_name);
    if($cfg_skin_check_target == '0') {
      switch($skin) {
        case 'rudskin' : {
          $dirs[0] = 'skins/'.$skin.'/';
          $files[$dirs[0]][0] = array();
          $files[$dirs[0]][1] = array();
          $files[$dirs[0]][1][] = 'favicon.ico';
          $files[$dirs[0]][1][] = 'layout.inc.php';
          $files[$dirs[0]][1][] = 'layout.print.inc.php';
          //$files[$dirs[0]][1][] = 'layouta.inc.php';
          $files[$dirs[0]][1][] = 'layouti.inc.php';
          
          $files[$dirs[0]][1][] = 'index.php';
          $files[$dirs[0]][1][] = 'style.inc.php';
          $files[$dirs[0]][1][] = 'skin.inc.php';
          $files[$dirs[0]][1][] = 'skin.info.php';
          
          $dirs[1] = 'skins/'.$skin.'/graphics/';
          $files[$dirs[1]][0] = array();
          $files[$dirs[1]][1] = array();
          $files[$dirs[1]][1][] = 'blank.gif';
          $files[$dirs[1]][1][] = 'close.gif';
          $files[$dirs[1]][1][] = 'loading.gif';
          $files[$dirs[1]][1][] = 'next.gif';
          $files[$dirs[1]][1][] = 'prev.gif';
          $files[$dirs[1]][1][] = 'index.php';
          
          $dirs[2] = 'skins/'.$skin.'/graphics/lang/';
          $files[$dirs[2]][0] = array();
          $files[$dirs[2]][1] = array();
          $files[$dirs[2]][1][] = 'index.php';
          $files[$dirs[2]][1][] = 'de.png';
          $files[$dirs[2]][1][] = 'en.png';
          $files[$dirs[2]][1][] = 'es.png';
          $files[$dirs[2]][1][] = 'fr.png';
          $files[$dirs[2]][1][] = 'it.png';
          $files[$dirs[2]][1][] = 'ro.png';
          
          $dirs[3] = 'skins/'.$skin.'/scripts/';
          $files[$dirs[3]][0] = array();
          $files[$dirs[3]][1] = array();
          $files[$dirs[3]][1][] = 'index.php';
          $files[$dirs[3]][1][] = 'js.inc.php';
          
          $dirs[4] = 'skins/'.$skin.'/styles/';
          $files[$dirs[4]][0] = array();
          $files[$dirs[4]][1] = array();
          $files[$dirs[4]][1][] = 'custom.css';
          $files[$dirs[4]][1][] = 'default.css';
          $files[$dirs[4]][1][] = 'editor.css';
          $files[$dirs[4]][1][] = 'index.php';
          
          require "./act/engnact.inc.php";
          unset($dirs);
          unset($files);
          break;
        }
        default : {break;}
      }
    }
    else {
      echo "\n<TR CLASS=\"hdr\"><TD CLASS=\"rst_err\" STYLE=\"border-bottom-width: 0px;\" COLSPAN=\"4\"><B>target directory doesn't exist!</B></TD></TR>";
    }
  }
  echo "\n</TABLE>";
}
else {
  echo "\n\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
  echo "\n<TR CLASS=\"hdr\"><TD CLASS=\"rst_err\" STYLE=\"border-bottom-width: 0px;\" WIDTH=\"200\"><B>no skin selected</B></TD></TR>";
  echo "\n</TABLE>";
}
?>
<BR>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right;"><B>&#160;</B></TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <?php
  if($set == 'upgrade') { ?>
  <FORM NAME="formnext" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=finish&amp;step=1">
  <?php }
  else {
  ?>
  <FORM NAME="formnext" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=usett&amp;step=1">
  <?php } ?>
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
  <FORM NAME="formback" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=skins&amp;step=1">
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