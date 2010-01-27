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
./skins/rudskin/skin.inc.php
13:56 2008-05-14
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once '../../lib/404.php';}

if (_RUDWEB_DBSKIN === '1') {
  // FROM DB
}
else {
  // FROM FILE
  /* ********** ********** ********** BODY ********** ********** ********** */
  // BODY
  $rudweb_skin['BgColor']         = '#FFFFFF';
  $rudweb_skin['Color1']          = '#EEEEEE';
  $rudweb_skin['Color2']          = '#DDDDDD';
  $rudweb_skin['Color3']          = '#CCCCCC';
  $rudweb_skin['FontColor']       = '#000000';
  $rudweb_skin['FontErrColor']    = '#990000';
  $rudweb_skin['FontOkColor']     = '#009900';
  $rudweb_skin['BgReqColor']      = '#990000';
  $rudweb_skin['TextAlign']       = 'center';
  $rudweb_skin['FontFamily']      = 'verdana, arial, helvetica, sans-serif';
  $rudweb_skin['FontSize']        = '11';
  $rudweb_skin['Measure']         = 'px';
  $rudweb_skin['BorderColor']     = '#333333';
  $rudweb_skin['BorderStyle']     = 'dashed';
  /* ********** ********** ********** MAIN MENU ********** ********** ********** */
  //MENU LEVEL 0
  $rudweb_skin['mnu']['mm']['hdr']['0']               = '{';
  $rudweb_skin['mnu']['mm']['pre']['0']               = '[';
  $rudweb_skin['mnu']['mm']['suf']['0']               = ']';
  $rudweb_skin['mnu']['mm']['sep']['0']               = '&#160;|&#160;';
  $rudweb_skin['mnu']['mm']['ftr']['0']               = '}';
  //MENU LEVEL 1
  $rudweb_skin['mnu']['mm']['hdr']['1']               = '{';
  $rudweb_skin['mnu']['mm']['pre']['1']               = '[';
  $rudweb_skin['mnu']['mm']['suf']['1']               = ']';
  $rudweb_skin['mnu']['mm']['sep']['1']               = '&#160;|&#160;';
  $rudweb_skin['mnu']['mm']['ftr']['1']               = '}';
  //MENU LEVEL 2
  $rudweb_skin['mnu']['mm']['hdr']['2']               = '{';
  $rudweb_skin['mnu']['mm']['pre']['2']               = '[';
  $rudweb_skin['mnu']['mm']['suf']['2']               = ']';
  $rudweb_skin['mnu']['mm']['sep']['2']               = '&#160;|&#160;';
  $rudweb_skin['mnu']['mm']['ftr']['2']               = '}';
  //MENU LEVEL 3
  $rudweb_skin['mnu']['mm']['hdr']['3']               = '{';
  $rudweb_skin['mnu']['mm']['pre']['3']               = '[';
  $rudweb_skin['mnu']['mm']['suf']['3']               = ']';
  $rudweb_skin['mnu']['mm']['sep']['3']               = '&#160;|&#160;';
  $rudweb_skin['mnu']['mm']['ftr']['3']               = '}';
  //MENU LEVEL 4
  $rudweb_skin['mnu']['mm']['hdr']['4']               = '{';
  $rudweb_skin['mnu']['mm']['pre']['4']               = '[';
  $rudweb_skin['mnu']['mm']['suf']['4']               = ']';
  $rudweb_skin['mnu']['mm']['sep']['4']               = '&#160;|&#160;';
  $rudweb_skin['mnu']['mm']['ftr']['4']               = '}';
  /* ********** ********** ********** OTHER MENUS ********** ********** ********** */
  //MENU LEVEL 0
  $rudweb_skin['mnu']['oth']['hdr']['0']               = '{';
  $rudweb_skin['mnu']['oth']['pre']['0']               = '[';
  $rudweb_skin['mnu']['oth']['suf']['0']               = ']';
  $rudweb_skin['mnu']['oth']['sep']['0']               = '&#160;|&#160;';
  $rudweb_skin['mnu']['oth']['ftr']['0']               = '}';
  //MENU LEVEL 1
  $rudweb_skin['mnu']['oth']['hdr']['1']               = '{';
  $rudweb_skin['mnu']['oth']['pre']['1']               = '[';
  $rudweb_skin['mnu']['oth']['suf']['1']               = ']';
  $rudweb_skin['mnu']['oth']['sep']['1']               = '&#160;|&#160;';
  $rudweb_skin['mnu']['oth']['ftr']['1']               = '}';
  //MENU LEVEL 2
  $rudweb_skin['mnu']['oth']['hdr']['2']               = '{';
  $rudweb_skin['mnu']['oth']['pre']['2']               = '[';
  $rudweb_skin['mnu']['oth']['suf']['2']               = ']';
  $rudweb_skin['mnu']['oth']['sep']['2']               = '&#160;|&#160;';
  $rudweb_skin['mnu']['oth']['ftr']['2']               = '}';
  //MENU LEVEL 3
  $rudweb_skin['mnu']['oth']['hdr']['3']               = '{';
  $rudweb_skin['mnu']['oth']['pre']['3']               = '[';
  $rudweb_skin['mnu']['oth']['suf']['3']               = ']';
  $rudweb_skin['mnu']['oth']['sep']['3']               = '&#160;|&#160;';
  $rudweb_skin['mnu']['oth']['ftr']['3']               = '}';
  //MENU LEVEL 4
  $rudweb_skin['mnu']['oth']['hdr']['4']               = '{';
  $rudweb_skin['mnu']['oth']['pre']['4']               = '[';
  $rudweb_skin['mnu']['oth']['suf']['4']               = ']';
  $rudweb_skin['mnu']['oth']['sep']['4']               = '&#160;|&#160;';
  $rudweb_skin['mnu']['oth']['ftr']['4']               = '}';
  /* ********** ********** ********** PAGE CONTENT ********** ********** ********** */
  // PAGE CONTENT
  $rudweb_skin['cnt']['hdr']                = "\n";
  $rudweb_skin['cnt']['pre']                = "";
  $rudweb_skin['cnt']['suf']                = "";
  $rudweb_skin['cnt']['ftr']                = "\n";
  // CONTENT TITLE
  $rudweb_skin['cnt']['tt1']['pre']         = "\n<DIV CLASS=\"title\">&#160;&#160;";
  $rudweb_skin['cnt']['tt1']['suf']         = "</Div>";
  // CONTENT SUBTITLE
  $rudweb_skin['cnt']['tt2']['pre']         = "\n<DIV CLASS=\"subtitle\">&#160;&#160;";
  $rudweb_skin['cnt']['tt2']['suf']         = "</DIV>";
  // PAGE TEXT
  $rudweb_skin['cnt']['txt']['pre']         = "\n<DIV CLASS=\"text\">\n";
  $rudweb_skin['cnt']['txt']['suf']         = "\n</DIV>";
  /* ********** ********** ********** PAGE CONTENT PICTURES ********** ********** ********** */
  // CONTENT PICTURES - 0 - PANEL
  $rudweb_skin['cnt']['pic']['hdr']['0']            = "\n";
  $rudweb_skin['cnt']['pic']['pre']['0']            = "";
  $rudweb_skin['cnt']['pic']['sep']['0']            = "\n<BR><BR>";
  $rudweb_skin['cnt']['pic']['suf']['0']            = "";
  $rudweb_skin['cnt']['pic']['ftr']['0']            = "\n";
  $rudweb_skin['cnt']['pic']['max']['0']            = "150";
  // CONTENT PICTURES - 1 - TOP
  $rudweb_skin['cnt']['pic']['hdr']['1']            = "<BR><DIV ALIGN=\"center\">";
  $rudweb_skin['cnt']['pic']['pre']['1']            = "\n<DIV STYLE=\"float: left; clear: none; margin: 4px;\">";
  $rudweb_skin['cnt']['pic']['sep']['1']            = "";
  $rudweb_skin['cnt']['pic']['suf']['1']            = "\n</DIV>";
  $rudweb_skin['cnt']['pic']['ftr']['1']            = "</DIV><BR CLEAR=\"all\">";
  $rudweb_skin['cnt']['pic']['max']['1']            = "150";
  // CONTENT PICTURES - 2 - AFTER TITLE
  $rudweb_skin['cnt']['pic']['hdr']['2']            = "<BR><DIV ALIGN=\"center\">";
  $rudweb_skin['cnt']['pic']['pre']['2']            = "\n<DIV STYLE=\"float: left; clear: none; margin: 4px;\">";
  $rudweb_skin['cnt']['pic']['sep']['2']            = "";
  $rudweb_skin['cnt']['pic']['suf']['2']            = "\n</DIV>";
  $rudweb_skin['cnt']['pic']['ftr']['2']            = "</DIV><BR CLEAR=\"all\">";
  $rudweb_skin['cnt']['pic']['max']['2']            = "150";
  // CONTENT PICTURES - 3 - AFTER SUBTITLE
  $rudweb_skin['cnt']['pic']['hdr']['3']            = "<BR><DIV ALIGN=\"center\">";
  $rudweb_skin['cnt']['pic']['pre']['3']            = "\n<DIV STYLE=\"float: left; clear: none; margin: 4px;\">";
  $rudweb_skin['cnt']['pic']['sep']['3']            = "";
  $rudweb_skin['cnt']['pic']['suf']['3']            = "\n</DIV>";
  $rudweb_skin['cnt']['pic']['ftr']['3']            = "</DIV><BR CLEAR=\"all\">";
  $rudweb_skin['cnt']['pic']['max']['3']            = "150";
  // CONTENT PICTURES - 4 - BOTTOM
  $rudweb_skin['cnt']['pic']['hdr']['4']            = "<BR><DIV ALIGN=\"center\">";
  $rudweb_skin['cnt']['pic']['pre']['4']            = "\n<DIV STYLE=\"float: left; clear: none; margin: 4px;\">";
  $rudweb_skin['cnt']['pic']['sep']['4']            = "";
  $rudweb_skin['cnt']['pic']['suf']['4']            = "\n</DIV>";
  $rudweb_skin['cnt']['pic']['ftr']['4']            = "</DIV><BR CLEAR=\"all\">";
  $rudweb_skin['cnt']['pic']['max']['4']            = "150";
  /* ********** ********** ********** FEATURED MODULE ********** ********** ********** */
  // FEATURED MODULE
  $rudweb_skin['ftr']['hdr']                = "\n<DIV CLASS=\"title\">&#160;&#160;".$rudweb_ln['featured']['tt']."</DIV><BR>";
  $rudweb_skin['ftr']['ftr']                = "\n";
  $rudweb_skin['ftr']['sep']                = "\n<BR><BR>";
  $rudweb_skin['ftr']['limit']              = "3"; // how many modules to display
  $rudweb_skin['ftr']['chartt']             = "20"; // how many characters for title
  $rudweb_skin['ftr']['picsize']            = "100"; // max picture size
  $rudweb_skin['ftr']['chardesc']           = "20"; // how many characters for description
  $rudweb_skin['ftr']['fpre']               = "\n";
  $rudweb_skin['ftr']['fsuf']               = "\n";
  $rudweb_skin['ftr']['tt']['pre']          = "\n";
  $rudweb_skin['ftr']['tt']['suf']          = "\n";
  $rudweb_skin['ftr']['pic']['pre']         = "\n<BR>";
  $rudweb_skin['ftr']['pic']['suf']         = "\n<BR>";
  $rudweb_skin['ftr']['desc']['pre']        = "\n";
  $rudweb_skin['ftr']['desc']['suf']        = "\n";
  /* ********** ********** ********** COPYRIGHT NOTICE ********** ********** ********** */
  // COPYRIGHT NOTICE
  $rudweb_skin['cpy']['pre']            = "\n";
  $rudweb_skin['cpy']['suf']            = "\n";
  /* ********** ********** ********** VISITOR STATISTICS ********** ********** ********** */
  $rudweb_skin['sts']['hdr']        = "\n<BR>";
  $rudweb_skin['sts']['ftr']        = "\n";
  $rudweb_skin['sts']['sep']         = "\n";
  $rudweb_skin['sts']['pre']         = "\n";
  $rudweb_skin['sts']['suf']         = "\n";
  /* ********** ********** ********** USER MODULE ********** ********** ********** */
  $rudweb_skin['usr']['hdr'] = "\n<TABLE BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\">\n<TR>";
  $rudweb_skin['usr']['pre'] = "\n<TD CLASS=\"usr_td\">";
  $rudweb_skin['usr']['suf'] = "\n</TD>";
  $rudweb_skin['usr']['sep'] = "";
  $rudweb_skin['usr']['ftr'] = "\n</TR>\n</TABLE>";
  $rudweb_skin['usr']['login']['hdr'] = "\n<TABLE BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\">\n<TR>";
  $rudweb_skin['usr']['login']['pre'] = "\n<TD CLASS=\"usr_login\">";
  $rudweb_skin['usr']['login']['suf'] = "\n</TD>";
  $rudweb_skin['usr']['login']['sep'] = "";
  $rudweb_skin['usr']['login']['ftr'] = "\n</TR>\n</TABLE>";
  /* ********** ********** ********** LANGUAGE MODULE ********** ********** ********** */
  // LANGUAGE MODULE
  $rudweb_skin['lng']['hdr'] = "\n";
  $rudweb_skin['lng']['pre'] = "\n";
  $rudweb_skin['lng']['suf'] = "\n";
  $rudweb_skin['lng']['sep'] = "\n&#160;";
  $rudweb_skin['lng']['ftr'] = "\n";
  /* ********** ********** ********** BLOG MODULE ********** ********** ********** */
  $rudweb_skin['blg']['hdr'] = '';
  $rudweb_skin['blg']['ftr'] = '';
  $rudweb_skin['blg']['pre'] = '';
  $rudweb_skin['blg']['suf'] = '';
  $rudweb_skin['blg']['sep'] = '<BR>';
  $rudweb_skin['blg']['posted']['pre'] = '';
  $rudweb_skin['blg']['posted']['suf'] = '';
  /* ********** ********** ********** COMMENTS MODULE ********** ********** ********** */
  $rudweb_skin['cmnts']['hdr'] = "\n<BR>";
  $rudweb_skin['cmnts']['ftr'] = "\n";
  $rudweb_skin['cmnts']['pre'] = "\n";
  $rudweb_skin['cmnts']['suf'] = "\n";
  $rudweb_skin['cmnts']['sep'] = "\n<HR>";
  /* ********** ********** ********** SHOPPING CART MODULE ********** ********** ********** */
  $rudweb_skin['crt']['hdr'] = "\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\">\n<TR>";
  $rudweb_skin['crt']['pre'] = "\n<TD>";
  $rudweb_skin['crt']['suf'] = "\n</TD>";
  $rudweb_skin['crt']['sep'] = "";
  $rudweb_skin['crt']['ftr'] = "\n</TR>\n</TABLE>";
  /* ********** ********** ********** YAH MODULE ********** ********** ********** */
  $rudweb_skin['yah']['hdr'] = "";
  $rudweb_skin['yah']['pre'] = "";
  $rudweb_skin['yah']['suf'] = "";
  $rudweb_skin['yah']['sep'] = "&#160;/&#160;";
  $rudweb_skin['yah']['ftr'] = "";
  /* ********** ********** ********** CONTENT TAGS ********** ********** ********** */
  $rudweb_skin['tagsc']['hdr'] = "<DIV>";
  $rudweb_skin['tagsc']['pre'] = "";
  $rudweb_skin['tagsc']['suf'] = "";
  $rudweb_skin['tagsc']['sep'] = "<BR>"; // NOT ACTUAL SEPARATOR
  $rudweb_skin['tagsc']['ftr'] = "</DIV>";
  /* ********** ********** ********** CATALOG MODULE ********** ********** ********** */
  $rudweb_skin['catalog']['hdr'] = '';
  $rudweb_skin['catalog']['ftr'] = '';
  /* ********** ********** ********** CATEGORIES ********** ********** ********** */
  $rudweb_skin['cat']['hdr'] = "<DIV STYLE=\"text-align: center;\">";
  $rudweb_skin['cat']['pre'] = "\n<DIV STYLE=\"width:48%; float: left; clear: none; margin: 4px; border: 1px solid #000000;\">";
  $rudweb_skin['cat']['suf'] = "</DIV>";
  $rudweb_skin['cat']['sep'] = "";
  $rudweb_skin['cat']['ftr'] = "</DIV><BR CLEAR=\"all\">";
  $rudweb_skin['cat']['pc']['pre'] = '<DIV STYLE="height: 160px; margin: 5px;">';
  $rudweb_skin['cat']['pc']['suf'] = '</DIV>';
  $rudweb_skin['cat']['tt']['pre'] = '<DIV STYLE="margin: 5px;">';
  $rudweb_skin['cat']['tt']['suf'] = '</DIV>';
  $rudweb_skin['cat']['dsc']['pre'] = '<DIV STYLE="margin: 5px;">';
  $rudweb_skin['cat']['dsc']['suf'] = '</DIV>';
  $rudweb_skin['cat']['pic'] = "150";
  /* ********** ********** ********** CATALOG YOU ARE HERE ********** ********** ********** */
  $rudweb_skin['catyah']['hdr'] = '';
  $rudweb_skin['catyah']['pre'] = '';
  $rudweb_skin['catyah']['suf'] = '';
  $rudweb_skin['catyah']['sep'] = '&#160;/&#160;';
  $rudweb_skin['catyah']['ftr'] = '';
  /* ********** ********** ********** PAGINATION ********** ********** ********** */
  $rudweb_skin['pgnav']['hdr'] = '<BR><DIV STYLE="text-align: center;">';
  $rudweb_skin['pgnav']['pre'] = '';
  $rudweb_skin['pgnav']['suf'] = '';
  $rudweb_skin['pgnav']['sep'] = '&#160;';
  $rudweb_skin['pgnav']['ftr'] = '</DIV>';
  /* ********** ********** ********** PRODUCTS ********** ********** ********** */
  //product list filters - items.inc
  $rudweb_skin['prod']['flb']['hdr']        = '<DIV CLASS="flbox">';
  $rudweb_skin['prod']['flb']['ftr']        = '</DIV>';
  $rudweb_skin['prod']['flb']['pidpre']     = '<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="1"><TR><TD STYLE="width: 100px;">';
  $rudweb_skin['prod']['flb']['pidsuf']     = '</TD>';
  $rudweb_skin['prod']['flb']['pnamepre']     = '<TD STYLE="width: 100px;">';
  $rudweb_skin['prod']['flb']['pnamesuf']     = '</TD></TR></TABLE><TABLE BORDER="0" CELLPADDING="3" CELLSPACING="1"><TR>';
  $rudweb_skin['prod']['flb']['pdetpre']     = '<TD STYLE="width: 100px;">';
  $rudweb_skin['prod']['flb']['pdetsuf']     = '</TD>';
  //$rudweb_skin['prod']['flb']['ppricepre']     = '<TD STYLE="width: 100px;">';
  //$rudweb_skin['prod']['flb']['ppricesuf']     = '</TD>';
  
  $rudweb_skin['prod']['flb']['applypre']     = '<TD STYLE="width: 100px;">';
  $rudweb_skin['prod']['flb']['applysuf']     = '</TD></TR></TABLE>';;
  // ??
  $rudweb_skin['prod']['com']['hdr']         = '';
  // product list - items.inc
  $rudweb_skin['prod']['lst']['hdr']         = '<BR CLEAR="all"><TABLE BORDER="1" CELLPADDING="3" CELLSPACING="0">';
  $rudweb_skin['prod']['lst']['hdrhdr']      = '<TR CLASS="lst_prd_hdr">';
  $rudweb_skin['prod']['lst']['ftrhdr']      = '</TR>';
  $rudweb_skin['prod']['lst']['hdrprd']      = '<TR CLASS="lst_prd_prd">';
  $rudweb_skin['prod']['lst']['pidpre']      = '<TD>';
  $rudweb_skin['prod']['lst']['pidsuf']      = '</TD>';
  $rudweb_skin['prod']['lst']['ppicpre']     = '<TD>';
  $rudweb_skin['prod']['lst']['ppicsuf']     = '</TD>';
  $rudweb_skin['prod']['lst']['pnamepre']    = '<TD>';
  $rudweb_skin['prod']['lst']['pnamesuf']    = '</TD>';
  $rudweb_skin['prod']['lst']['prd_dscpre']  = '<TD>';
  $rudweb_skin['prod']['lst']['prd_dscsuf']  = '</TD>';
  $rudweb_skin['prod']['lst']['ppricepre']   = '<TD>';
  $rudweb_skin['prod']['lst']['ppricesuf']   = '</TD>';
  $rudweb_skin['prod']['lst']['detpre']      = '<TD>';
  $rudweb_skin['prod']['lst']['detsuf']      = '</TD>';
  $rudweb_skin['prod']['lst']['ftrprd']      = '</TR>';
  $rudweb_skin['prod']['lst']['ftr']         = '</TABLE>';
  // settings
  $rudweb_skin['prod']['picmax']              = '100';
  $rudweb_skin['prod']['chardesc']            = '30';
  // product details - item.inc
  $rudweb_skin['prod']['dt']['picmax']        = '80';
  $rudweb_skin['prod']['dt']['hdr']           = '<DIV>';
  // main picture
  $rudweb_skin['prod']['dt']['pict0']['pre']  = '<DIV>';
  $rudweb_skin['prod']['dt']['pict0']['suf']  = '</DIV>';
  // product name
  $rudweb_skin['prod']['dt']['tt_vl']['pre']  = '<DIV>';
  $rudweb_skin['prod']['dt']['tt_vl']['suf']  = '</DIV>';
  // offer id
  $rudweb_skin['prod']['dt']['pid_tt']['pre'] = '<DIV>';
  $rudweb_skin['prod']['dt']['pid_tt']['suf'] = '</DIV>';
  $rudweb_skin['prod']['dt']['pid_vl']['pre'] = '<DIV>';
  $rudweb_skin['prod']['dt']['pid_vl']['suf'] = '</DIV>';
  // product description
  $rudweb_skin['prod']['dt']['dsc_tt']['pre'] = '<DIV>';
  $rudweb_skin['prod']['dt']['dsc_tt']['suf'] = '</DIV>';
  $rudweb_skin['prod']['dt']['dsc_vl']['pre'] = '<DIV>';
  $rudweb_skin['prod']['dt']['dsc_vl']['suf'] = '</DIV>';
  // all othe rdetails
  $rudweb_skin['prod']['dt']['det']['hdr']    = '<DIV>';
  $rudweb_skin['prod']['dt']['det_tt']['pre'] = '<DIV>';
  $rudweb_skin['prod']['dt']['det_tt']['suf'] = '</DIV>';
  $rudweb_skin['prod']['dt']['det_vl']['pre'] = '<DIV>';
  $rudweb_skin['prod']['dt']['det_vl']['suf'] = '</DIV>';
  $rudweb_skin['prod']['dt']['det']['ftr']    = '</DIV>';
  // quantity
  $rudweb_skin['prod']['dt']['qty_tt']['pre'] = '<DIV>';
  $rudweb_skin['prod']['dt']['qty_tt']['suf'] = '</DIV>';
  $rudweb_skin['prod']['dt']['qty_vl']['pre'] = '<DIV>';
  $rudweb_skin['prod']['dt']['qty_vl']['suf'] = '</DIV>';
  // price
  $rudweb_skin['prod']['dt']['prc_tt']['pre'] = '<DIV>';
  $rudweb_skin['prod']['dt']['prc_tt']['suf'] = '</DIV>';
  $rudweb_skin['prod']['dt']['prc_vl']['pre'] = '<DIV>';
  $rudweb_skin['prod']['dt']['prc_vl']['suf'] = '</DIV>';
  // product pictures
  $rudweb_skin['prod']['dt']['pic0']['hdr']   = '<DIV>';
  $rudweb_skin['prod']['dt']['pic0']['pre']   = '<DIV>';
  $rudweb_skin['prod']['dt']['pic0']['suf']   = '</DIV>';
  $rudweb_skin['prod']['dt']['pic0']['sep']   = '';
  $rudweb_skin['prod']['dt']['pic0']['ftr']   = '</DIV>';
  // product form
  $rudweb_skin['prod']['dt']['form']['pre']   = '<DIV>';
  $rudweb_skin['prod']['dt']['form']['suf']   = '</DIV>';
  //details footer
  $rudweb_skin['prod']['dt']['ftr']           = '</DIV>';
  /* ********** ********** ********** ADMINISTRATION MODULE ********** ********** ********** */
  $rudweb_skin['adm']['hdr']          = '<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>';
  $rudweb_skin['adm']['pre']          = '<TD CLASS="">';
  $rudweb_skin['adm']['suf']          = '</TD>';
  $rudweb_skin['adm']['sep']          = '';
  $rudweb_skin['adm']['ftr']          = '</TR></TABLE>';
  // LOGIN
  $rudweb_skin['adm']['login']['hdr'] = '<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0"><TR>';
  $rudweb_skin['adm']['login']['pre'] = '<TD CLASS="usr_login">';
  $rudweb_skin['adm']['login']['suf'] = '</TD>';
  $rudweb_skin['adm']['login']['sep'] = '';
  $rudweb_skin['adm']['login']['ftr'] = '</TR></TABLE>';
  // MENU
  $rudweb_skin['adm']['mnu']['hdr']   = '<DIV>';
  $rudweb_skin['adm']['mnuhd']['pre'] = '<DIV>';
  $rudweb_skin['adm']['mnuhd']['suf'] = '</DIV>';
  $rudweb_skin['adm']['mnutt']['pre'] = '<DIV>';
  $rudweb_skin['adm']['mnutt']['suf'] = '</DIV>';
  $rudweb_skin['adm']['mnu']['pre']   = '<DIV>';
  $rudweb_skin['adm']['mnu']['suf']   = '</DIV>';
  $rudweb_skin['adm']['mnu']['sep']   = '';
  $rudweb_skin['adm']['mnu']['ftr']   = '</DIV>';
  // MODULES
  $rudweb_skin['adm']['mod']['pre']   = '<DIV CLASS="adm_mod">';
  $rudweb_skin['adm']['mod']['suf']   = '</DIV>';
  /* ********** ********** ********** CATALOG SPECIAL OFFERS ********** ********** ********** */
  $rudweb_skin['csp']['hdr']        = "\n<DIV CLASS=\"title\">&#160;&#160;".$rudweb_ln['catalog']['csp']."</DIV><BR>";
  $rudweb_skin['csp']['ftr']        = "\n";

  $rudweb_skin['csp']['pre']        = "\n";
  $rudweb_skin['csp']['suf']        = "\n";
  $rudweb_skin['csp']['sep']        = "\n<BR><BR>";

  $rudweb_skin['csp']['chartt']     = "30"; // how many characters for title
  $rudweb_skin['csp']['chardesc']   = "90"; // how many characters for description

  $rudweb_skin['csp']['pic']['pre'] = "\n<BR>";
  $rudweb_skin['csp']['pic']['suf'] = "\n<BR>";
  $rudweb_skin['csp']['tt']['pre']  = "\n";
  $rudweb_skin['csp']['tt']['suf']  = "\n";
  $rudweb_skin['csp']['dsc']['pre'] = "\n";
  $rudweb_skin['csp']['dsc']['suf'] = "\n";
  /* ********** ********** ********** CONTENT & CATALOG COMMENTS ********** ********** ********** */
  $rudweb_skin['cmt']['hdr'] = '<DIV>';
  $rudweb_skin['cmt']['ftr'] = '</DIV>';
  $rudweb_skin['cmt']['pre'] = '<DIV>';
  $rudweb_skin['cmt']['suf'] = '</DIV>';
  $rudweb_skin['cmt']['cmtpre'] = '<DIV>';
  $rudweb_skin['cmt']['cmtsuf'] = '</DIV>';
  $rudweb_skin['cmt']['cmtppre'] = '<DIV>';
  $rudweb_skin['cmt']['cmtpsuf'] = '</DIV>';  
  $rudweb_skin['cmt']['sep'] = '';
  /* ********** ********** ********** NEWS MODULE ********** ********** ********** */
  $rudweb_skin['nws']['lst']['hdr'] = '<DIV>';
  $rudweb_skin['nws']['lst']['ftr'] = '</DIV>';
  $rudweb_skin['nws']['lst']['pre'] = '<DIV STYLE="margin: 5px 5px 5px 5px;">';
  $rudweb_skin['nws']['lst']['suf'] = '</DIV>';
  
  $rudweb_skin['nws']['lst']['dtpre'] = '<DIV>';
  $rudweb_skin['nws']['lst']['dtsuf'] = '</DIV>';
  $rudweb_skin['nws']['lst']['ttpre'] = '<DIV>';
  $rudweb_skin['nws']['lst']['ttsuf'] = '</DIV>';
  $rudweb_skin['nws']['lst']['dscpre'] = '<DIV>';
  $rudweb_skin['nws']['lst']['dscsuf'] = '</DIV>';
  
  $rudweb_skin['nws']['itm']['hdr'] = '<DIV>';
  $rudweb_skin['nws']['itm']['ftr'] = '</DIV>';
  $rudweb_skin['nws']['itm']['dtpre'] = '<DIV>';
  $rudweb_skin['nws']['itm']['dtsuf'] = '</DIV>';
  $rudweb_skin['nws']['itm']['ttpre'] = '<DIV>';
  $rudweb_skin['nws']['itm']['ttsuf'] = '</DIV>';
  $rudweb_skin['nws']['itm']['dscpre'] = '<DIV>';
  $rudweb_skin['nws']['itm']['dscsuf'] = '</DIV>';
  $rudweb_skin['nws']['itm']['txtpre'] = '<DIV>';
  $rudweb_skin['nws']['itm']['txtsuf'] = '</DIV>';
  
  $rudweb_skin['nws']['sln']['hdr'] = '<DIV>';
  $rudweb_skin['nws']['sln']['ftr'] = '</DIV>';
  $rudweb_skin['nws']['sln']['pre'] = '<DIV STYLE="margin: 5px 0px 5px 0px;">';
  $rudweb_skin['nws']['sln']['suf'] = '</DIV>';
  $rudweb_skin['nws']['sln']['dtpre'] = '<DIV>';
  $rudweb_skin['nws']['sln']['dtsuf'] = '</DIV>';
  $rudweb_skin['nws']['sln']['ttpre'] = '<DIV>';
  $rudweb_skin['nws']['sln']['ttsuf'] = '</DIV>';
}
?>