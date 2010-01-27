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
./setup/act/lngs01.inc.php
16:50 2008-04-16
*/
?>
<FORM NAME="lngform" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=lngs&amp;step=2">
<?php
$langs = lsdir($source.'inc/langs/');
$langst = count($langs);
for($lni = 1; $lni <= $langst; $lni++) {
if($set == 'upgrade') {
$_SESSION['rudwebset_cfg_ln_inst'][$langs[$lni]] = 'off';
$_SESSION['rudwebset_cfg_ln_cfg'][$langs[$lni]] = 'off';
}
?>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR>
<TD CLASS="hdr"><B><?php echo $langs[$lni];?></B></TD></TR>
</TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">install language:</TD>
<TD CLASS="cnt">
<INPUT TYPE="checkbox" CLASS="general" NAME="set_cfg_ln_inst[<?php echo $langs[$lni];?>]"<?php if($_SESSION['rudwebset_cfg_ln_inst'][$langs[$lni]] == 'on') {echo ' CHECKED';}?>>
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">install config:</TD>
<TD CLASS="cnt">
<INPUT TYPE="checkbox" CLASS="general" NAME="set_cfg_ln_cfg[<?php echo $langs[$lni];?>]"<?php if($_SESSION['rudwebset_cfg_ln_cfg'][$langs[$lni]] == 'on') {echo ' CHECKED';}?>>
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">website title:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_wstt[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_wstt'][$langs[$lni]];?>">
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">website description:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_wsds[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_wsds'][$langs[$lni]];?>">
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">website keywords:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_wskw[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_wskw'][$langs[$lni]];?>">
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">featured content title:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_ftt[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_ftt'][$langs[$lni]];?>">
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">featured content details:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_fds[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_fds'][$langs[$lni]];?>">
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">catalog title:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_catalog[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_catalog'][$langs[$lni]];?>">
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">catalog categories:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_cattt[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_cattt'][$langs[$lni]];?>">
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">catalog items:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_itemstt[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_itemstt'][$langs[$lni]];?>">
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">catalog item details:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_itemtt[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_itemtt'][$langs[$lni]];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">catalog special offers:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_csp[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_csp'][$langs[$lni]];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">catalog product id:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_cat_pid[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_cat_pid'][$langs[$lni]];?>">
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">catalog product picture:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_cat_ppic[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_cat_ppic'][$langs[$lni]];?>">
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">catalog product name:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_cat_pname[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_cat_pname'][$langs[$lni]];?>">
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">catalog product description:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_cat_prd_dsc[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_cat_prd_dsc'][$langs[$lni]];?>">
</TD></TR></TABLE>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">catalog product price:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="langs_cat_pprice[<?php echo $langs[$lni];?>]" SIZE="50" MAXLENGTH="255" VALUE="<?php echo $_SESSION['rudwebset_langs_cat_pprice'][$langs[$lni]];?>">
</TD></TR></TABLE>
<?php
}
?>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD><INPUT TYPE="submit" CLASS="button" STYLE="background-color: #DDDDDD" NAME="next" VALUE="next"></TD>
  </TR></TABLE>
</TD></TR></TABLE>
</FORM>

<!--
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="150" STYLE="text-align: right;"><B>&#160;</B></TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="verifformback" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=engn&amp;step=7">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #CCCCCC" NAME="back" VALUE="back">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>
-->

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