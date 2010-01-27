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
./inc/act/usett01.inc.php
20:48 2008-05-23
*/
if($_SESSION['rudwebset_set_site_url1'] == '') {$_SESSION['rudwebset_set_site_url1'] = $target_url[$_SESSION['rudwebset_pid']];}
if($_SESSION['rudwebset_set_site_root1'] == '') {$_SESSION['rudwebset_set_site_root1'] = $target_root.$target_vars[$_SESSION['rudwebset_pid']];}
//if($_SESSION['rudwebset_set_pre'] == '') {$_SESSION['rudwebset_set_pre'] = $target_name[$_SESSION['rudwebset_pid']];}
if($_SESSION['rudwebset_set_pre'] == '') {$_SESSION['rudwebset_set_pre'] = $_SESSION['rudwebset_set_dbname'];}
?>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="total" WIDTH="200"><BR><B>Engine Configuration:</B><BR></TD>
</TR></TABLE>

<FORM NAME="usettform1" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=usett&amp;step=2">

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR>
<TD CLASS="hdr"><B>Database:</B></TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">database type:</TD>
<TD CLASS="cnt">
<INPUT TYPE="hidden" NAME="set_dtype" VALUE="<?php echo $_SESSION['rudwebset_set_dbtype'];?>">
<INPUT TYPE="hidden" NAME="set_dbmy" VALUE="<?php echo $_SESSION['rudwebset_set_dbmy'];?>">
<SELECT CLASS="general" NAME="dump" DISABLED>
  <OPTION VALUE="my" <?php if ($_SESSION['rudwebset_set_dbtype'] == "my") {echo " SELECTED";}?>>MySQL</OPTION>
  <OPTION VALUE="pg" <?php if ($_SESSION['rudwebset_set_dbtype'] == "pg") {echo " SELECTED";}?>>PostgreSQL</OPTION>
</SELECT>

</TD></TR>

<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">host:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="set_dbhost" SIZE="10" MAXLENGTH="20" VALUE="<?php echo $_SESSION['rudwebset_set_dbhost'];?>" READONLY>
</TD></TR>

<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">port:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="set_dbport" SIZE="10" MAXLENGTH="20" VALUE="<?php echo $_SESSION['rudwebset_set_dbport'];?>" READONLY>
</TD></TR>

<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">user:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="set_dbuser" SIZE="10" MAXLENGTH="20" VALUE="<?php echo $_SESSION['rudwebset_set_dbuser'];?>" READONLY>
</TD></TR>

<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">pasword:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="set_dbpass" SIZE="10" MAXLENGTH="20" VALUE="<?php echo $_SESSION['rudwebset_set_dbpass'];?>" READONLY>
</TD></TR>

<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">database name:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="set_dbname" SIZE="10" MAXLENGTH="20" VALUE="<?php echo $_SESSION['rudwebset_set_dbname'];?>" READONLY>
</TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="hdr"><B>Website:</B></TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">local URL:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="set_site_url1" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_set_site_url1'];?>" READONLY>
</TD></TR>
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">server URL:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="set_site_url2" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_set_site_url2'];?>">
</TD></TR>
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">local doc root:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="set_site_root1" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_set_site_root1'];?>" READONLY>
</TD></TR>
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">server doc root:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="set_site_root2" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_set_site_root2'];?>">
</TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="hdr"><B>Configuration:</B></TD></TR>
</TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">site settings:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="set_dbcfg">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_set_dbcfg'] == "0") {echo " SELECTED";}?>>file</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_set_dbcfg'] == "1") {echo " SELECTED";}?>>database</OPTION>
</SELECT>
</TD></TR>

<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">skin settings:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="set_dbskin">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_set_dbskin'] == "0") {echo " SELECTED";}?>>file</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_set_dbskin'] == "1") {echo " SELECTED";}?>>database</OPTION>
</SELECT>
</TD></TR>

<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">global prefix:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="set_pre" SIZE="15" MAXLENGTH="15" VALUE="<?php echo $_SESSION['rudwebset_set_pre'];?>">
&#160;(<I>"_" added automatically</I>)
</TD></TR>

<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">SEO URLS:</TD>
<TD CLASS="cnt">
<?php 
$ind_s_d = '';
$ind_s_o = '';
if($_SESSION['rudwebset_set_rewrite'] == 0) {
  $ind_s_d = ' DISABLED';
  $ind_s_o = ' SELECTED';
}
if ($_SESSION['rudwebset_set_index'] == 'index.php/') {
  $ind_s_o = ' SELECTED';
}
?>
<SELECT CLASS="general" NAME="set_index"<?php echo $ind_s_d; ?>>
  <OPTION VALUE='' <?php if ($_SESSION['rudwebset_set_index'] == '') {echo " SELECTED";}?>>enabled</OPTION>
  <OPTION VALUE='index.php/'<?php echo $ind_s_o; ?>>disabled</OPTION>
</SELECT>

</TD></TR>

</TABLE>

<?php if($usett_err == '0') { ?>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD><INPUT TYPE="submit" CLASS="button" STYLE="background-color: #DDDDDD" NAME="next" VALUE="next"></TD>
  </TR></TABLE>
</TD></TR></TABLE>
<?php } ?>

</FORM>

<!--
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="verifformback" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=skins&amp;step=2">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #CCCCCC" NAME="back" VALUE="back">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>
-->

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="200" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="verifformabort" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #BBBBBB" NAME="abort" VALUE="abort">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>