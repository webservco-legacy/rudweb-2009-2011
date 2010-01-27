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
./inc/act/usett02.inc.php
17:50 2008-05-31
*/
?>
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="total" WIDTH="200"><BR><B>Site Configuration:</B><BR></TD>
</TR></TABLE>

<FORM NAME="usettform2" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=cfgs&amp;step=1">
<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR>
<TD CLASS="hdr"><B>Website Settings:</B></TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">start date:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_start" SIZE="12" MAXLENGTH="10" VALUE="<?php echo $_SESSION['rudwebset_cfg_start'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">client company:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_clcom" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_clcom'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">client contact :</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_clnam" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_clnam'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">developer company:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_dvcom" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_dvcom'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">developer URL:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_dvurl" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_dvurl'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">developer contact person:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_dvnam" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_dvnam'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR>
<TD CLASS="hdr"><B>Website Settings (meta):</B></TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">website designer:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_desig" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_desig'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">website publisher:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_publ" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_publ'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">website rating:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_ratng">
  <OPTION VALUE="14 yrs" <?php if ($_SESSION['rudwebset_cfg_ratng'] == "14 yrs") {echo " SELECTED";}?>>14 yrs</OPTION>
  <OPTION VALUE="General" <?php if ($_SESSION['rudwebset_cfg_ratng'] == "General") {echo " SELECTED";}?>>General</OPTION>
  <OPTION VALUE="Mature" <?php if ($_SESSION['rudwebset_cfg_ratng'] == "Mature") {echo " SELECTED";}?>>Mature</OPTION>
  <OPTION VALUE="Restricted" <?php if ($_SESSION['rudwebset_cfg_ratng'] == "Restricted") {echo " SELECTED";}?>>Restricted</OPTION>
  <OPTION VALUE="Safe for kids" <?php if ($_SESSION['rudwebset_cfg_ratng'] == "Safe for kids") {echo " SELECTED";}?>>Safe for kids</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">website distribution:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_distr">
  <OPTION VALUE="Global" <?php if ($_SESSION['rudwebset_cfg_distr'] == "Global") {echo " SELECTED";}?>>Global</OPTION>
  <OPTION VALUE="Local" <?php if ($_SESSION['rudwebset_cfg_distr'] == "Local") {echo " SELECTED";}?>>Local</OPTION>
  <OPTION VALUE="Internal use" <?php if ($_SESSION['rudwebset_cfg_distr'] == "Internal use") {echo " SELECTED";}?>>Internal use</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">website robots:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_robots">
  <OPTION VALUE="Index" <?php if ($_SESSION['rudwebset_cfg_robots'] == "Index") {echo " SELECTED";}?>>Index</OPTION>
  <OPTION VALUE="Index, Follow" <?php if ($_SESSION['rudwebset_cfg_robots'] == "Index, Follow") {echo " SELECTED";}?>>Index, Follow</OPTION>
  <OPTION VALUE="Index, NoFollow" <?php if ($_SESSION['rudwebset_cfg_robots'] == "Index, NoFollow") {echo " SELECTED";}?>>Index, NoFollow</OPTION>
  <OPTION VALUE="NoIndex, Follow" <?php if ($_SESSION['rudwebset_cfg_robots'] == "NoIndex, Follow") {echo " SELECTED";}?>>NoIndex, Follow</OPTION>
  <OPTION VALUE="NoIndex, NoFollow" <?php if ($_SESSION['rudwebset_cfg_robots'] == "NoIndex, NoFollow") {echo " SELECTED";}?>>NoIndex, NoFollow</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">website pragma:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_prag" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_prag'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">website expires:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_exp" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_exp'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">website cache control:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_cache" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_cache'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR>
<TD CLASS="hdr"><B>Default language:</B></TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">default language:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_lang" SIZE="2" MAXLENGTH="2" VALUE="<?php echo $_SESSION['rudwebset_cfg_lang'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR>
<TD CLASS="hdr"><B>Default skin:</B></TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">default skin:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_skin" SIZE="10" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_skin'];?>"></TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR>
<TD CLASS="hdr"><B>Default content:</B></TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">default content [en]:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_cnt_en" SIZE="10" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_cnt_en'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">default content [de]:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_cnt_de" SIZE="10" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_cnt_de'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">default content [es]:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_cnt_es" SIZE="10" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_cnt_es'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">default content [fr]:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_cnt_fr" SIZE="10" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_cnt_fr'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">default content [it]:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_cnt_it" SIZE="10" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_cnt_it'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">default content [ro]:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_cnt_ro" SIZE="10" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_cnt_ro'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR>
<TD CLASS="hdr"><B>Site settings:</B></TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">first page:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_cnt_shw">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_cnt_shw'] == "0") {echo " SELECTED";}?>>intro</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_cnt_shw'] == "1") {echo " SELECTED";}?>>content</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR>
<TD CLASS="hdr"><B>Site modules:</B></TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">multiple languages:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_lang_on">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_lang_on'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_lang_on'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">multiple users:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_usr_on">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_usr_on'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_usr_on'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">multiple skins:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_skin_on">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_skin_on'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_skin_on'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">shop / catalog:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_cat">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_cat'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_cat'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">shop / catalog items/page:</TD>
<TD CLASS="cnt">
  <INPUT TYPE="text" CLASS="general" NAME="cfg_cat_ipg" SIZE="2" MAXLENGTH="3" VALUE="<?php echo $_SESSION['rudwebset_cfg_cat_ipg'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">shop / catalog picture uploads at once:</TD>
<TD CLASS="cnt">
  <INPUT TYPE="text" CLASS="general" NAME="cfg_cat_pcs" SIZE="2" MAXLENGTH="3" VALUE="<?php echo $_SESSION['rudwebset_cfg_cat_pcs'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">shop / catalog items filter box:</TD>
<TD CLASS="cnt">
  <INPUT TYPE="text" CLASS="general" NAME="cfg_cat_flt" SIZE="2" MAXLENGTH="3" VALUE="<?php echo $_SESSION['rudwebset_cfg_cat_flt'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">shopping cart:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_cart_on">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_cart_on'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_cart_on'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">catalog special offers:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_csp_on">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_csp_on'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_csp_on'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">special offers items:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_csp_lmt" SIZE="2" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_csp_lmt'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">visitor statistics:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_stats_on">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_stats_on'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_stats_on'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">ignore IPs:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_stats_ip" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_stats_ip'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">featured content:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_ftr_on">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_ftr_on'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_ftr_on'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">featured items:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_ftr_lmt" SIZE="2" MAXLENGTH="150" VALUE="<?php echo $_SESSION['rudwebset_cfg_ftr_lmt'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">page load timer:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_timer">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_timer'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_timer'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">debug:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_debug">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_debug'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_debug'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">copyright notice:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_cpy">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_cpy'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_cpy'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">show developer info in copyright notice:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_cpydev">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_cpydev'] == "0") {echo " SELECTED";}?>>disabled</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_cpydev'] == "1") {echo " SELECTED";}?>>enabled</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">sitemap:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_smap">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_smap'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_smap'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">youarehere:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_yah">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_yah'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_yah'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">news:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_nws">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_nws'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_nws'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">news items latest news:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_nws_lmt1" SIZE="2" MAXLENGTH="3" VALUE="<?php echo $_SESSION['rudwebset_cfg_nws_lmt1'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">news items / page:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_nws_lmt2" SIZE="2" MAXLENGTH="3" VALUE="<?php echo $_SESSION['rudwebset_cfg_nws_lmt2'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">search:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_src">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_src'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_src'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">contact:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_con">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_con'] == "0") {echo " SELECTED";}?>>off</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_con'] == "1") {echo " SELECTED";}?>>on</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR>
<TD CLASS="hdr"><B>Page Modules:</B></TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">content pictures [0]:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_pics_0">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_pics_0'] == "0") {echo " SELECTED";}?>>disabled</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_pics_0'] == "1") {echo " SELECTED";}?>>enabled</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">content pictures [1]:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_pics_1">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_pics_1'] == "0") {echo " SELECTED";}?>>disabled</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_pics_1'] == "1") {echo " SELECTED";}?>>enabled</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">content pictures [2]:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_pics_2">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_pics_2'] == "0") {echo " SELECTED";}?>>disabled</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_pics_2'] == "1") {echo " SELECTED";}?>>enabled</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">content pictures [3]:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_pics_3">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_pics_3'] == "0") {echo " SELECTED";}?>>disabled</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_pics_3'] == "1") {echo " SELECTED";}?>>enabled</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">content pictures [4]:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_pics_4">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_pics_4'] == "0") {echo " SELECTED";}?>>disabled</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_pics_4'] == "1") {echo " SELECTED";}?>>enabled</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">content "posted by":</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_cnt_posted">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_cnt_posted'] == "0") {echo " SELECTED";}?>>disabled</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_cnt_posted'] == "1") {echo " SELECTED";}?>>enabled</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">content tags:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_cnt_tags">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_cnt_tags'] == "0") {echo " SELECTED";}?>>disabled</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_cnt_tags'] == "1") {echo " SELECTED";}?>>enabled</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">content comments:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_cnt_cmnts">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_cnt_cmnts'] == "0") {echo " SELECTED";}?>>disabled</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_cnt_cmnts'] == "1") {echo " SELECTED";}?>>enabled</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">content links:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_cnt_lnks">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_cnt_lnks'] == "0") {echo " SELECTED";}?>>disabled</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_cnt_lnks'] == "1") {echo " SELECTED";}?>>enabled</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">content downloads:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_cnt_dlds">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_cnt_dlds'] == "0") {echo " SELECTED";}?>>disabled</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_cnt_dlds'] == "1") {echo " SELECTED";}?>>enabled</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR>
<TD CLASS="hdr"><B>Website Administration:</B></TD></TR>
</TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">administration module:</TD>
<TD CLASS="cnt">
<SELECT CLASS="general" NAME="cfg_adm">
  <OPTION VALUE="0" <?php if ($_SESSION['rudwebset_cfg_adm'] == "0") {echo " SELECTED";}?>>disabled</OPTION>
  <OPTION VALUE="1" <?php if ($_SESSION['rudwebset_cfg_adm'] == "1") {echo " SELECTED";}?>>enabled</OPTION>
</SELECT>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">admin first name:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_adm_fname" SIZE="30" MAXLENGTH="30" VALUE="<?php echo $_SESSION['rudwebset_cfg_adm_fname'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">admin middle name:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_adm_mname" SIZE="15" MAXLENGTH="15" VALUE="<?php echo $_SESSION['rudwebset_cfg_adm_mname'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">admin last name:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_adm_lname" SIZE="30" MAXLENGTH="30" VALUE="<?php echo $_SESSION['rudwebset_cfg_adm_lname'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">admin email:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_adm_mail" SIZE="30" MAXLENGTH="30" VALUE="<?php echo $_SESSION['rudwebset_cfg_adm_mail'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">admin password:</TD>
<TD CLASS="cnt">
<INPUT TYPE="text" CLASS="general" NAME="cfg_adm_pass" SIZE="30" MAXLENGTH="30" VALUE="<?php echo $_SESSION['rudwebset_cfg_adm_pass'];?>">
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD><INPUT TYPE="submit" CLASS="button" STYLE="background-color: #DDDDDD" NAME="next" VALUE="next"></TD>
  </TR></TABLE>
</TD></TR></TABLE>

</FORM>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="usettformback" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php?pid=<?php echo $pid;?>&amp;set=<?php echo $set;?>&amp;act=usett&amp;step=1">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #CCCCCC" NAME="back" VALUE="back">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>

<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0" BGCOLOR="#000000" WIDTH="100%">
<TR><TD CLASS="cnt" WIDTH="250" STYLE="text-align: right">&#160;</TD>
<TD CLASS="cnt">
  <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>
  <TD>
  <FORM NAME="usettformabort" METHOD="POST" STYLE="display: inline; margin: 0px; padding: 0px;" ACTION="./setup.php">
  <INPUT TYPE="submit" CLASS="button" STYLE="background-color: #BBBBBB" NAME="abort" VALUE="abort">
  </FORM>
  </TD>
  </TR></TABLE>
</TD></TR></TABLE>