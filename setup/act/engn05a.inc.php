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
./setup/act/engn05a.inc.php
14:49 2008-05-27
*/

echo "\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR><TD CLASS=\"ttt\" WIDTH=\"200\"><B>Libraries</B></TD>";
echo "</TR></TABLE>";

$dirs[0] = "lib/";
$files[$dirs[0]][0] = array();
$files[$dirs[0]][1] = array();
$files[$dirs[0]][1][] = "404.php";
$files[$dirs[0]][1][] = "img.php";
$files[$dirs[0]][1][] = "index.php";
$files[$dirs[0]][1][] = "myerr.php";
$files[$dirs[0]][1][] = "pic.php";
$files[$dirs[0]][1][] = "picver.php";
$files[$dirs[0]][1][] = "ubmydate.php";
$files[$dirs[0]][1][] = "ubthumb.php";

$dirs[1] = "lib/ttf/";
$files[$dirs[1]][0] = array();
$files[$dirs[1]][1] = array();
$files[$dirs[1]][1][] = "VeraMono.ttf";

$dirs[2] = "lib/editor/";
$files[$dirs[2]][0] = array();
$files[$dirs[2]][1] = array();
$files[$dirs[2]][1][] = "_documentation.html";
$files[$dirs[2]][1][] = "_upgrade.html";
$files[$dirs[2]][1][] = "_whatsnew.html";
$files[$dirs[2]][1][] = "_whatsnew_history.html";
$files[$dirs[2]][1][] = "fckconfig.js";
$files[$dirs[2]][1][] = "fckeditor.afp";
$files[$dirs[2]][1][] = "fckeditor.asp";
$files[$dirs[2]][1][] = "fckeditor.cfc";
$files[$dirs[2]][1][] = "fckeditor.cfm";
$files[$dirs[2]][1][] = "fckeditor.js";
$files[$dirs[2]][1][] = "fckeditor.lasso";
$files[$dirs[2]][1][] = "fckeditor.php";
$files[$dirs[2]][1][] = "fckeditor.pl";
$files[$dirs[2]][1][] = "fckeditor.py";
$files[$dirs[2]][1][] = "fckeditor_php4.php";
$files[$dirs[2]][1][] = "fckeditor_php5.php";
$files[$dirs[2]][1][] = "fckpackager.xml";
$files[$dirs[2]][1][] = "fckstyles.xml";
$files[$dirs[2]][1][] = "fcktemplates.xml";
$files[$dirs[2]][1][] = "fckutils.cfm";
$files[$dirs[2]][1][] = "license.txt";

$dirs[3] = "lib/editor/_samples/";
$files[$dirs[3]][0] = array();
$files[$dirs[3]][1] = array();
$files[$dirs[3]][1][] = "default.html";
$files[$dirs[3]][1][] = "sample.css";
$files[$dirs[3]][1][] = "sampleslist.html";

$dirs[4] = "lib/editor/_samples/_plugins/";
$files[$dirs[4]][0] = array();
$files[$dirs[4]][1] = array();

$dirs[5] = "lib/editor/_samples/_plugins/findreplace/";
$files[$dirs[5]][0] = array();
$files[$dirs[5]][1] = array();
$files[$dirs[5]][1][] = "fckplugin.js";
$files[$dirs[5]][1][] = "find.gif";
$files[$dirs[5]][1][] = "find.html";
$files[$dirs[5]][1][] = "replace.gif";
$files[$dirs[5]][1][] = "replace.html";

$dirs[6] = "lib/editor/_samples/_plugins/findreplace/lang/";
$files[$dirs[6]][0] = array();
$files[$dirs[6]][1] = array();
$files[$dirs[6]][1][] = "en.js";
$files[$dirs[6]][1][] = "fr.js";
$files[$dirs[6]][1][] = "it.js";

$dirs[7] = "lib/editor/_samples/_plugins/samples/";
$files[$dirs[7]][0] = array();
$files[$dirs[7]][1] = array();
$files[$dirs[7]][1][] = "fckplugin.js";

$dirs[8] = "lib/editor/_samples/adobeair/";
$files[$dirs[8]][0] = array();
$files[$dirs[8]][1] = array();
$files[$dirs[8]][1][] = "application.xml";
$files[$dirs[8]][1][] = "package.bat";
$files[$dirs[8]][1][] = "run.bat";
$files[$dirs[8]][1][] = "sample01.html";
$files[$dirs[8]][1][] = "sample01_cert.pfx";

$dirs[9] = "lib/editor/_samples/adobeair/icons/";
$files[$dirs[9]][0] = array();
$files[$dirs[9]][1] = array();
$files[$dirs[9]][1][] = "128.png";
$files[$dirs[9]][1][] = "16.png";
$files[$dirs[9]][1][] = "32.png";
$files[$dirs[9]][1][] = "48.png";

$dirs[10] = "lib/editor/_samples/afp/";
$files[$dirs[10]][0] = array();
$files[$dirs[10]][1] = array();
$files[$dirs[10]][1][] = "fck.afpa";
$files[$dirs[10]][1][] = "fck.afpa.code";
$files[$dirs[10]][1][] = "sample01.afp";
$files[$dirs[10]][1][] = "sample02.afp";
$files[$dirs[10]][1][] = "sample03.afp";
$files[$dirs[10]][1][] = "sample04.afp";
$files[$dirs[10]][1][] = "sampleposteddata.afp";

$dirs[11] = "lib/editor/_samples/asp/";
$files[$dirs[11]][0] = array();
$files[$dirs[11]][1] = array();
$files[$dirs[11]][1][] = "sample01.asp";
$files[$dirs[11]][1][] = "sample02.asp";
$files[$dirs[11]][1][] = "sample03.asp";
$files[$dirs[11]][1][] = "sample04.asp";
$files[$dirs[11]][1][] = "sampleposteddata.asp";

$dirs[12] = "lib/editor/_samples/cfm/";
$files[$dirs[12]][0] = array();
$files[$dirs[12]][1] = array();
$files[$dirs[12]][1][] = "sample01.cfm";
$files[$dirs[12]][1][] = "sample01_mx.cfm";
$files[$dirs[12]][1][] = "sample02.cfm";
$files[$dirs[12]][1][] = "sample02_mx.cfm";
$files[$dirs[12]][1][] = "sample03.cfm";
$files[$dirs[12]][1][] = "sample03_mx.cfm";
$files[$dirs[12]][1][] = "sample04.cfm";
$files[$dirs[12]][1][] = "sample04_mx.cfm";
$files[$dirs[12]][1][] = "sampleposteddata.cfm";

$dirs[13] = "lib/editor/_samples/html/";
$files[$dirs[13]][0] = array();
$files[$dirs[13]][1] = array();
$files[$dirs[13]][1][] = "sample01.html";
$files[$dirs[13]][1][] = "sample02.html";
$files[$dirs[13]][1][] = "sample03.html";
$files[$dirs[13]][1][] = "sample04.html";
$files[$dirs[13]][1][] = "sample05.html";
$files[$dirs[13]][1][] = "sample06.config.js";
$files[$dirs[13]][1][] = "sample06.html";
$files[$dirs[13]][1][] = "sample07.html";
$files[$dirs[13]][1][] = "sample08.html";
$files[$dirs[13]][1][] = "sample09.html";
$files[$dirs[13]][1][] = "sample10.html";
$files[$dirs[13]][1][] = "sample11.html";
$files[$dirs[13]][1][] = "sample11_frame.html";
$files[$dirs[13]][1][] = "sample12.html";
$files[$dirs[13]][1][] = "sample13.html";
$files[$dirs[13]][1][] = "sample14.config.js";
$files[$dirs[13]][1][] = "sample14.html";
$files[$dirs[13]][1][] = "sample14.styles.css";
$files[$dirs[13]][1][] = "sampleposteddata.asp";
$files[$dirs[13]][1][] = "sampleposteddata.html";

$dirs[14] = "lib/editor/_samples/lasso/";
$files[$dirs[14]][0] = array();
$files[$dirs[14]][1] = array();
$files[$dirs[14]][1][] = "sample01.lasso";
$files[$dirs[14]][1][] = "sample02.lasso";
$files[$dirs[14]][1][] = "sample03.lasso";
$files[$dirs[14]][1][] = "sample04.lasso";
$files[$dirs[14]][1][] = "sampleposteddata.lasso";

$dirs[15] = "lib/editor/_samples/perl/";
$files[$dirs[15]][0] = array();
$files[$dirs[15]][1] = array();
$files[$dirs[15]][1][] = "sample01.cgi";
$files[$dirs[15]][1][] = "sample02.cgi";
$files[$dirs[15]][1][] = "sample03.cgi";
$files[$dirs[15]][1][] = "sample04.cgi";
$files[$dirs[15]][1][] = "sampleposteddata.cgi";

$dirs[16] = "lib/editor/_samples/php/";
$files[$dirs[16]][0] = array();
$files[$dirs[16]][1] = array();
$files[$dirs[16]][1][] = "sample01.php";
$files[$dirs[16]][1][] = "sample02.php";
$files[$dirs[16]][1][] = "sample03.php";
$files[$dirs[16]][1][] = "sample04.php";
$files[$dirs[16]][1][] = "sampleposteddata.php";

$dirs[17] = "lib/editor/_samples/py/";
$files[$dirs[17]][0] = array();
$files[$dirs[17]][1] = array();
$files[$dirs[17]][1][] = "sample01.py";
$files[$dirs[17]][1][] = "sampleposteddata.py";

$dirs[18] = "lib/editor/editor/";
$files[$dirs[18]][0] = array();
$files[$dirs[18]][1] = array();
$files[$dirs[18]][1][] = "fckdebug.html";
$files[$dirs[18]][1][] = "fckdialog.html";
$files[$dirs[18]][1][] = "fckeditor.html";
$files[$dirs[18]][1][] = "fckeditor.original.html";

$dirs[19] = "lib/editor/editor/_source/";
$files[$dirs[19]][0] = array();
$files[$dirs[19]][1] = array();
$files[$dirs[19]][1][] = "fckconstants.js";
$files[$dirs[19]][1][] = "fckeditorapi.js";
$files[$dirs[19]][1][] = "fckjscoreextensions.js";
$files[$dirs[19]][1][] = "fckscriptloader.js";

$dirs[20] = "lib/editor/editor/_source/classes/";
$files[$dirs[20]][0] = array();
$files[$dirs[20]][1] = array();
$files[$dirs[20]][1][] = "fckcontextmenu.js";
$files[$dirs[20]][1][] = "fckdataprocessor.js";
$files[$dirs[20]][1][] = "fckdocumentfragment_gecko.js";
$files[$dirs[20]][1][] = "fckdocumentfragment_ie.js";
$files[$dirs[20]][1][] = "fckdomrange.js";
$files[$dirs[20]][1][] = "fckdomrange_gecko.js";
$files[$dirs[20]][1][] = "fckdomrange_ie.js";
$files[$dirs[20]][1][] = "fckdomrangeiterator.js";
$files[$dirs[20]][1][] = "fckeditingarea.js";
$files[$dirs[20]][1][] = "fckelementpath.js";
$files[$dirs[20]][1][] = "fckenterkey.js";
$files[$dirs[20]][1][] = "fckevents.js";
$files[$dirs[20]][1][] = "fckhtmliterator.js";
$files[$dirs[20]][1][] = "fckicon.js";
$files[$dirs[20]][1][] = "fckiecleanup.js";
$files[$dirs[20]][1][] = "fckimagepreloader.js";
$files[$dirs[20]][1][] = "fckkeystrokehandler.js";
$files[$dirs[20]][1][] = "fckmenublock.js";
$files[$dirs[20]][1][] = "fckmenublockpanel.js";
$files[$dirs[20]][1][] = "fckmenuitem.js";
$files[$dirs[20]][1][] = "fckpanel.js";
$files[$dirs[20]][1][] = "fckplugin.js";
$files[$dirs[20]][1][] = "fckspecialcombo.js";
$files[$dirs[20]][1][] = "fckstyle.js";
$files[$dirs[20]][1][] = "fcktoolbar.js";
$files[$dirs[20]][1][] = "fcktoolbarbreak_gecko.js";
$files[$dirs[20]][1][] = "fcktoolbarbreak_ie.js";
$files[$dirs[20]][1][] = "fcktoolbarbutton.js";
$files[$dirs[20]][1][] = "fcktoolbarbuttonui.js";
$files[$dirs[20]][1][] = "fcktoolbarfontformatcombo.js";
$files[$dirs[20]][1][] = "fcktoolbarfontscombo.js";
$files[$dirs[20]][1][] = "fcktoolbarfontsizecombo.js";
$files[$dirs[20]][1][] = "fcktoolbarpanelbutton.js";
$files[$dirs[20]][1][] = "fcktoolbarspecialcombo.js";
$files[$dirs[20]][1][] = "fcktoolbarstylecombo.js";
$files[$dirs[20]][1][] = "fckw3crange.js";
$files[$dirs[20]][1][] = "fckxml.js";
$files[$dirs[20]][1][] = "fckxml_gecko.js";
$files[$dirs[20]][1][] = "fckxml_ie.js";

$dirs[21] = "lib/editor/editor/_source/commandclasses/";
$files[$dirs[21]][0] = array();
$files[$dirs[21]][1] = array();
$files[$dirs[21]][1][] = "fck_othercommands.js";
$files[$dirs[21]][1][] = "fckblockquotecommand.js";
$files[$dirs[21]][1][] = "fckcorestylecommand.js";
$files[$dirs[21]][1][] = "fckfitwindow.js";
$files[$dirs[21]][1][] = "fckindentcommands.js";
$files[$dirs[21]][1][] = "fckjustifycommands.js";
$files[$dirs[21]][1][] = "fcklistcommands.js";
$files[$dirs[21]][1][] = "fcknamedcommand.js";
$files[$dirs[21]][1][] = "fckpasteplaintextcommand.js";
$files[$dirs[21]][1][] = "fckpastewordcommand.js";
$files[$dirs[21]][1][] = "fckremoveformatcommand.js";
$files[$dirs[21]][1][] = "fckshowblocks.js";
$files[$dirs[21]][1][] = "fckspellcheckcommand_gecko.js";
$files[$dirs[21]][1][] = "fckspellcheckcommand_ie.js";
$files[$dirs[21]][1][] = "fckstylecommand.js";
$files[$dirs[21]][1][] = "fcktablecommand.js";
$files[$dirs[21]][1][] = "fcktextcolorcommand.js";

$dirs[22] = "lib/editor/editor/_source/internals/";
$files[$dirs[22]][0] = array();
$files[$dirs[22]][1] = array();
$files[$dirs[22]][1][] = "fck.js";
$files[$dirs[22]][1][] = "fck_contextmenu.js";
$files[$dirs[22]][1][] = "fck_gecko.js";
$files[$dirs[22]][1][] = "fck_ie.js";
$files[$dirs[22]][1][] = "fckbrowserinfo.js";
$files[$dirs[22]][1][] = "fckcodeformatter.js";
$files[$dirs[22]][1][] = "fckcommands.js";
$files[$dirs[22]][1][] = "fckconfig.js";
$files[$dirs[22]][1][] = "fckdebug.js";
$files[$dirs[22]][1][] = "fckdialog.js";
$files[$dirs[22]][1][] = "fckdocumentprocessor.js";
$files[$dirs[22]][1][] = "fckdomtools.js";
$files[$dirs[22]][1][] = "fcklanguagemanager.js";
$files[$dirs[22]][1][] = "fcklisthandler.js";
$files[$dirs[22]][1][] = "fcklistslib.js";
$files[$dirs[22]][1][] = "fckplugins.js";
$files[$dirs[22]][1][] = "fckregexlib.js";
$files[$dirs[22]][1][] = "fckselection.js";
$files[$dirs[22]][1][] = "fckselection_gecko.js";
$files[$dirs[22]][1][] = "fckselection_ie.js";
$files[$dirs[22]][1][] = "fckstyles.js";
$files[$dirs[22]][1][] = "fcktablehandler.js";
$files[$dirs[22]][1][] = "fcktablehandler_gecko.js";
$files[$dirs[22]][1][] = "fcktablehandler_ie.js";
$files[$dirs[22]][1][] = "fcktoolbaritems.js";
$files[$dirs[22]][1][] = "fcktoolbarset.js";
$files[$dirs[22]][1][] = "fcktools.js";
$files[$dirs[22]][1][] = "fcktools_gecko.js";
$files[$dirs[22]][1][] = "fcktools_ie.js";
$files[$dirs[22]][1][] = "fckundo.js";
$files[$dirs[22]][1][] = "fckurlparams.js";
$files[$dirs[22]][1][] = "fckxhtml.js";
$files[$dirs[22]][1][] = "fckxhtml_gecko.js";
$files[$dirs[22]][1][] = "fckxhtml_ie.js";
$files[$dirs[22]][1][] = "fckxhtmlentities.js";

$dirs[23] = "lib/editor/editor/css/";
$files[$dirs[23]][0] = array();
$files[$dirs[23]][1] = array();
$files[$dirs[23]][1][] = "fck_editorarea.css";
$files[$dirs[23]][1][] = "fck_internal.css";
$files[$dirs[23]][1][] = "fck_showtableborders_gecko.css";

$dirs[24] = "lib/editor/editor/css/behaviors/";
$files[$dirs[24]][0] = array();
$files[$dirs[24]][1] = array();
$files[$dirs[24]][1][] = "disablehandles.htc";
$files[$dirs[24]][1][] = "showtableborders.htc";

$dirs[25] = "lib/editor/editor/css/images/";
$files[$dirs[25]][0] = array();
$files[$dirs[25]][1] = array();
$files[$dirs[25]][1][] = "block_address.png";
$files[$dirs[25]][1][] = "block_blockquote.png";
$files[$dirs[25]][1][] = "block_div.png";
$files[$dirs[25]][1][] = "block_h1.png";
$files[$dirs[25]][1][] = "block_h2.png";
$files[$dirs[25]][1][] = "block_h3.png";
$files[$dirs[25]][1][] = "block_h4.png";
$files[$dirs[25]][1][] = "block_h5.png";
$files[$dirs[25]][1][] = "block_h6.png";
$files[$dirs[25]][1][] = "block_p.png";
$files[$dirs[25]][1][] = "block_pre.png";
$files[$dirs[25]][1][] = "fck_anchor.gif";
$files[$dirs[25]][1][] = "fck_flashlogo.gif";
$files[$dirs[25]][1][] = "fck_hiddenfield.gif";
$files[$dirs[25]][1][] = "fck_pagebreak.gif";
$files[$dirs[25]][1][] = "fck_plugin.gif";

$dirs[26] = "lib/editor/editor/dialog/";
$files[$dirs[26]][0] = array();
$files[$dirs[26]][1] = array();
$files[$dirs[26]][1][] = "fck_about.html";
$files[$dirs[26]][1][] = "fck_anchor.html";
$files[$dirs[26]][1][] = "fck_button.html";
$files[$dirs[26]][1][] = "fck_checkbox.html";
$files[$dirs[26]][1][] = "fck_colorselector.html";
$files[$dirs[26]][1][] = "fck_docprops.html";
$files[$dirs[26]][1][] = "fck_flash.html";
$files[$dirs[26]][1][] = "fck_form.html";
$files[$dirs[26]][1][] = "fck_hiddenfield.html";
$files[$dirs[26]][1][] = "fck_image.html";
$files[$dirs[26]][1][] = "fck_link.html";
$files[$dirs[26]][1][] = "fck_listprop.html";
$files[$dirs[26]][1][] = "fck_paste.html";
$files[$dirs[26]][1][] = "fck_radiobutton.html";
$files[$dirs[26]][1][] = "fck_replace.html";
$files[$dirs[26]][1][] = "fck_select.html";
$files[$dirs[26]][1][] = "fck_smiley.html";
$files[$dirs[26]][1][] = "fck_source.html";
$files[$dirs[26]][1][] = "fck_specialchar.html";
$files[$dirs[26]][1][] = "fck_spellerpages.html";
$files[$dirs[26]][1][] = "fck_table.html";
$files[$dirs[26]][1][] = "fck_tablecell.html";
$files[$dirs[26]][1][] = "fck_template.html";
$files[$dirs[26]][1][] = "fck_textarea.html";
$files[$dirs[26]][1][] = "fck_textfield.html";

$dirs[27] = "lib/editor/editor/dialog/common/";
$files[$dirs[27]][0] = array();
$files[$dirs[27]][1] = array();
$files[$dirs[27]][1][] = "fck_dialog_common.css";
$files[$dirs[27]][1][] = "fck_dialog_common.js";

$dirs[28] = "lib/editor/editor/dialog/common/images/";
$files[$dirs[28]][0] = array();
$files[$dirs[28]][1] = array();
$files[$dirs[28]][1][] = "locked.gif";
$files[$dirs[28]][1][] = "reset.gif";
$files[$dirs[28]][1][] = "unlocked.gif";

$dirs[29] = "lib/editor/editor/dialog/fck_about/";
$files[$dirs[29]][0] = array();
$files[$dirs[29]][1] = array();
$files[$dirs[29]][1][] = "logo_fckeditor.gif";
$files[$dirs[29]][1][] = "logo_fredck.gif";

$dirs[30] = "lib/editor/editor/dialog/fck_about/sponsors/";
$files[$dirs[30]][0] = array();
$files[$dirs[30]][1] = array();
$files[$dirs[30]][1][] = "spellchecker_net.gif";

$dirs[31] = "lib/editor/editor/dialog/fck_docprops/";
$files[$dirs[31]][0] = array();
$files[$dirs[31]][1] = array();
$files[$dirs[31]][1][] = "fck_document_preview.html";

$dirs[32] = "lib/editor/editor/dialog/fck_flash/";
$files[$dirs[32]][0] = array();
$files[$dirs[32]][1] = array();
$files[$dirs[32]][1][] = "fck_flash.js";
$files[$dirs[32]][1][] = "fck_flash_preview.html";

$dirs[33] = "lib/editor/editor/dialog/fck_image/";
$files[$dirs[33]][0] = array();
$files[$dirs[33]][1] = array();
$files[$dirs[33]][1][] = "fck_image.js";
$files[$dirs[33]][1][] = "fck_image_preview.html";

$dirs[34] = "lib/editor/editor/dialog/fck_link/";
$files[$dirs[34]][0] = array();
$files[$dirs[34]][1] = array();
$files[$dirs[34]][1][] = "fck_link.js";

$dirs[35] = "lib/editor/editor/dialog/fck_select/";
$files[$dirs[35]][0] = array();
$files[$dirs[35]][1] = array();
$files[$dirs[35]][1][] = "fck_select.js";

$dirs[36] = "lib/editor/editor/dialog/fck_spellerpages/";
$files[$dirs[36]][0] = array();
$files[$dirs[36]][1] = array();

$dirs[37] = "lib/editor/editor/dialog/fck_spellerpages/spellerpages/";
$files[$dirs[37]][0] = array();
$files[$dirs[37]][1] = array();
$files[$dirs[37]][1][] = "blank.html";
$files[$dirs[37]][1][] = "controls.html";
$files[$dirs[37]][1][] = "controlWindow.js";
$files[$dirs[37]][1][] = "spellchecker.html";
$files[$dirs[37]][1][] = "spellChecker.js";
$files[$dirs[37]][1][] = "spellerStyle.css";
$files[$dirs[37]][1][] = "wordWindow.js";

$dirs[38] = "lib/editor/editor/dialog/fck_spellerpages/spellerpages/server-scripts/";
$files[$dirs[38]][0] = array();
$files[$dirs[38]][1] = array();
$files[$dirs[38]][1][] = "spellchecker.cfm";
$files[$dirs[38]][1][] = "spellchecker.php";
$files[$dirs[38]][1][] = "spellchecker.pl";

$dirs[39] = "lib/editor/editor/dialog/fck_template/";
$files[$dirs[39]][0] = array();
$files[$dirs[39]][1] = array();

$dirs[40] = "lib/editor/editor/dialog/fck_template/images/";
$files[$dirs[40]][0] = array();
$files[$dirs[40]][1] = array();
$files[$dirs[40]][1][] = "template1.gif";
$files[$dirs[40]][1][] = "template2.gif";
$files[$dirs[40]][1][] = "template3.gif";

$dirs[41] = "lib/editor/editor/dtd/";
$files[$dirs[41]][0] = array();
$files[$dirs[41]][1] = array();
$files[$dirs[41]][1][] = "fck_dtd_test.html";
$files[$dirs[41]][1][] = "fck_xhtml10strict.js";
$files[$dirs[41]][1][] = "fck_xhtml10transitional.js";

$dirs[42] = "lib/editor/editor/filemanager/";
$files[$dirs[42]][0] = array();
$files[$dirs[42]][1] = array();

$dirs[43] = "lib/editor/editor/filemanager/browser/";
$files[$dirs[43]][0] = array();
$files[$dirs[43]][1] = array();

$dirs[44] = "lib/editor/editor/filemanager/browser/default/";
$files[$dirs[44]][0] = array();
$files[$dirs[44]][1] = array();
$files[$dirs[44]][1][] = "browser.css";
$files[$dirs[44]][1][] = "browser.html";
$files[$dirs[44]][1][] = "frmactualfolder.html";
$files[$dirs[44]][1][] = "frmcreatefolder.html";
$files[$dirs[44]][1][] = "frmfolders.html";
$files[$dirs[44]][1][] = "frmresourceslist.html";
$files[$dirs[44]][1][] = "frmresourcetype.html";
$files[$dirs[44]][1][] = "frmupload.html";

$dirs[45] = "lib/editor/editor/filemanager/browser/default/images/";
$files[$dirs[45]][0] = array();
$files[$dirs[45]][1] = array();
$files[$dirs[45]][1][] = "ButtonArrow.gif";
$files[$dirs[45]][1][] = "Folder.gif";
$files[$dirs[45]][1][] = "Folder32.gif";
$files[$dirs[45]][1][] = "FolderOpened.gif";
$files[$dirs[45]][1][] = "FolderOpened32.gif";
$files[$dirs[45]][1][] = "FolderUp.gif";
$files[$dirs[45]][1][] = "spacer.gif";

$dirs[46] = "lib/editor/editor/filemanager/browser/default/images/icons/";
$files[$dirs[46]][0] = array();
$files[$dirs[46]][1] = array();
$files[$dirs[46]][1][] = "ai.gif";
$files[$dirs[46]][1][] = "avi.gif";
$files[$dirs[46]][1][] = "bmp.gif";
$files[$dirs[46]][1][] = "cs.gif";
$files[$dirs[46]][1][] = "default.icon.gif";
$files[$dirs[46]][1][] = "dll.gif";
$files[$dirs[46]][1][] = "doc.gif";
$files[$dirs[46]][1][] = "exe.gif";
$files[$dirs[46]][1][] = "fla.gif";
$files[$dirs[46]][1][] = "gif.gif";
$files[$dirs[46]][1][] = "htm.gif";
$files[$dirs[46]][1][] = "html.gif";
$files[$dirs[46]][1][] = "jpg.gif";
$files[$dirs[46]][1][] = "js.gif";
$files[$dirs[46]][1][] = "mdb.gif";
$files[$dirs[46]][1][] = "mp3.gif";
$files[$dirs[46]][1][] = "pdf.gif";
$files[$dirs[46]][1][] = "png.gif";
$files[$dirs[46]][1][] = "ppt.gif";
$files[$dirs[46]][1][] = "rdp.gif";
$files[$dirs[46]][1][] = "swf.gif";
$files[$dirs[46]][1][] = "swt.gif";
$files[$dirs[46]][1][] = "txt.gif";
$files[$dirs[46]][1][] = "vsd.gif";
$files[$dirs[46]][1][] = "xls.gif";
$files[$dirs[46]][1][] = "xml.gif";
$files[$dirs[46]][1][] = "zip.gif";

$dirs[47] = "lib/editor/editor/filemanager/browser/default/images/icons/32/";
$files[$dirs[47]][0] = array();
$files[$dirs[47]][1] = array();
$files[$dirs[47]][1][] = "ai.gif";
$files[$dirs[47]][1][] = "avi.gif";
$files[$dirs[47]][1][] = "bmp.gif";
$files[$dirs[47]][1][] = "cs.gif";
$files[$dirs[47]][1][] = "default.icon.gif";
$files[$dirs[47]][1][] = "dll.gif";
$files[$dirs[47]][1][] = "doc.gif";
$files[$dirs[47]][1][] = "exe.gif";
$files[$dirs[47]][1][] = "fla.gif";
$files[$dirs[47]][1][] = "gif.gif";
$files[$dirs[47]][1][] = "htm.gif";
$files[$dirs[47]][1][] = "html.gif";
$files[$dirs[47]][1][] = "jpg.gif";
$files[$dirs[47]][1][] = "js.gif";
$files[$dirs[47]][1][] = "mdb.gif";
$files[$dirs[47]][1][] = "mp3.gif";
$files[$dirs[47]][1][] = "pdf.gif";
$files[$dirs[47]][1][] = "png.gif";
$files[$dirs[47]][1][] = "ppt.gif";
$files[$dirs[47]][1][] = "rdp.gif";
$files[$dirs[47]][1][] = "swf.gif";
$files[$dirs[47]][1][] = "swt.gif";
$files[$dirs[47]][1][] = "txt.gif";
$files[$dirs[47]][1][] = "vsd.gif";
$files[$dirs[47]][1][] = "xls.gif";
$files[$dirs[47]][1][] = "xml.gif";
$files[$dirs[47]][1][] = "zip.gif";

$dirs[48] = "lib/editor/editor/filemanager/browser/default/js/";
$files[$dirs[48]][0] = array();
$files[$dirs[48]][1] = array();
$files[$dirs[48]][1][] = "common.js";
$files[$dirs[48]][1][] = "fckxml.js";

$dirs[49] = "lib/editor/editor/filemanager/connectors/";
$files[$dirs[49]][0] = array();
$files[$dirs[49]][1] = array();
$files[$dirs[49]][1][] = "test.html";
$files[$dirs[49]][1][] = "uploadtest.html";

$dirs[50] = "lib/editor/editor/filemanager/connectors/asp/";
$files[$dirs[50]][0] = array();
$files[$dirs[50]][1] = array();
$files[$dirs[50]][1][] = "basexml.asp";
$files[$dirs[50]][1][] = "class_upload.asp";
$files[$dirs[50]][1][] = "commands.asp";
$files[$dirs[50]][1][] = "config.asp";
$files[$dirs[50]][1][] = "connector.asp";
$files[$dirs[50]][1][] = "io.asp";
$files[$dirs[50]][1][] = "upload.asp";
$files[$dirs[50]][1][] = "util.asp";

$dirs[51] = "lib/editor/editor/filemanager/connectors/aspx/";
$files[$dirs[51]][0] = array();
$files[$dirs[51]][1] = array();
$files[$dirs[51]][1][] = "config.ascx";
$files[$dirs[51]][1][] = "connector.aspx";
$files[$dirs[51]][1][] = "upload.aspx";

$dirs[52] = "lib/editor/editor/filemanager/connectors/cfm/";
$files[$dirs[52]][0] = array();
$files[$dirs[52]][1] = array();
$files[$dirs[52]][1][] = "cf5_connector.cfm";
$files[$dirs[52]][1][] = "cf5_upload.cfm";
$files[$dirs[52]][1][] = "cf_basexml.cfm";
$files[$dirs[52]][1][] = "cf_commands.cfm";
$files[$dirs[52]][1][] = "cf_connector.cfm";
$files[$dirs[52]][1][] = "cf_io.cfm";
$files[$dirs[52]][1][] = "cf_upload.cfm";
$files[$dirs[52]][1][] = "cf_util.cfm";
$files[$dirs[52]][1][] = "config.cfm";
$files[$dirs[52]][1][] = "connector.cfm";
$files[$dirs[52]][1][] = "image.cfc";
$files[$dirs[52]][1][] = "ImageObject.cfc";
$files[$dirs[52]][1][] = "upload.cfm";

$dirs[53] = "lib/editor/editor/filemanager/connectors/lasso/";
$files[$dirs[53]][0] = array();
$files[$dirs[53]][1] = array();
$files[$dirs[53]][1][] = "config.lasso";
$files[$dirs[53]][1][] = "connector.lasso";
$files[$dirs[53]][1][] = "upload.lasso";

$dirs[54] = "lib/editor/editor/filemanager/connectors/perl/";
$files[$dirs[54]][0] = array();
$files[$dirs[54]][1] = array();
$files[$dirs[54]][1][] = "basexml.pl";
$files[$dirs[54]][1][] = "commands.pl";
$files[$dirs[54]][1][] = "connector.cgi";
$files[$dirs[54]][1][] = "io.pl";
$files[$dirs[54]][1][] = "upload.cgi";
$files[$dirs[54]][1][] = "upload_fck.pl";
$files[$dirs[54]][1][] = "util.pl";

$dirs[55] = "lib/editor/editor/filemanager/connectors/php/";
$files[$dirs[55]][0] = array();
$files[$dirs[55]][1] = array();
$files[$dirs[55]][1][] = "basexml.php";
$files[$dirs[55]][1][] = "commands.php";
$files[$dirs[55]][1][] = "config.php";
$files[$dirs[55]][1][] = "connector.php";
$files[$dirs[55]][1][] = "io.php";
$files[$dirs[55]][1][] = "phpcompat.php";
$files[$dirs[55]][1][] = "upload.php";
$files[$dirs[55]][1][] = "util.php";

$dirs[56] = "lib/editor/editor/filemanager/connectors/py/";
$files[$dirs[56]][0] = array();
$files[$dirs[56]][1] = array();
$files[$dirs[56]][1][] = "config.py";
$files[$dirs[56]][1][] = "connector.py";
$files[$dirs[56]][1][] = "fckcommands.py";
$files[$dirs[56]][1][] = "fckconnector.py";
$files[$dirs[56]][1][] = "fckoutput.py";
$files[$dirs[56]][1][] = "fckutil.py";
$files[$dirs[56]][1][] = "htaccess.txt";
$files[$dirs[56]][1][] = "upload.py";
$files[$dirs[56]][1][] = "wsgi.py";
$files[$dirs[56]][1][] = "zope.py";

$dirs[57] = "lib/editor/editor/images/";
$files[$dirs[57]][0] = array();
$files[$dirs[57]][1] = array();
$files[$dirs[57]][1][] = "anchor.gif";
$files[$dirs[57]][1][] = "arrow_ltr.gif";
$files[$dirs[57]][1][] = "arrow_rtl.gif";
$files[$dirs[57]][1][] = "spacer.gif";

$dirs[58] = "lib/editor/editor/images/smiley/";
$files[$dirs[58]][0] = array();
$files[$dirs[58]][1] = array();

$dirs[59] = "lib/editor/editor/images/smiley/msn/";
$files[$dirs[59]][0] = array();
$files[$dirs[59]][1] = array();
$files[$dirs[59]][1][] = "angel_smile.gif";
$files[$dirs[59]][1][] = "angry_smile.gif";
$files[$dirs[59]][1][] = "broken_heart.gif";
$files[$dirs[59]][1][] = "cake.gif";
$files[$dirs[59]][1][] = "confused_smile.gif";
$files[$dirs[59]][1][] = "cry_smile.gif";
$files[$dirs[59]][1][] = "devil_smile.gif";
$files[$dirs[59]][1][] = "embaressed_smile.gif";
$files[$dirs[59]][1][] = "envelope.gif";
$files[$dirs[59]][1][] = "heart.gif";
$files[$dirs[59]][1][] = "kiss.gif";
$files[$dirs[59]][1][] = "lightbulb.gif";
$files[$dirs[59]][1][] = "omg_smile.gif";
$files[$dirs[59]][1][] = "regular_smile.gif";
$files[$dirs[59]][1][] = "sad_smile.gif";
$files[$dirs[59]][1][] = "shades_smile.gif";
$files[$dirs[59]][1][] = "teeth_smile.gif";
$files[$dirs[59]][1][] = "thumbs_down.gif";
$files[$dirs[59]][1][] = "thumbs_up.gif";
$files[$dirs[59]][1][] = "tounge_smile.gif";
$files[$dirs[59]][1][] = "whatchutalkingabout_smile.gif";
$files[$dirs[59]][1][] = "wink_smile.gif";

$dirs[60] = "lib/editor/editor/js/";
$files[$dirs[60]][0] = array();
$files[$dirs[60]][1] = array();
$files[$dirs[60]][1][] = "fckadobeair.js";
$files[$dirs[60]][1][] = "fckeditorcode_gecko.js";
$files[$dirs[60]][1][] = "fckeditorcode_ie.js";

$dirs[61] = "lib/editor/editor/lang/";
$files[$dirs[61]][0] = array();
$files[$dirs[61]][1] = array();
$files[$dirs[61]][1][] = "_translationstatus.txt";
$files[$dirs[61]][1][] = "af.js";
$files[$dirs[61]][1][] = "ar.js";
$files[$dirs[61]][1][] = "bg.js";
$files[$dirs[61]][1][] = "bn.js";
$files[$dirs[61]][1][] = "bs.js";
$files[$dirs[61]][1][] = "ca.js";
$files[$dirs[61]][1][] = "cs.js";
$files[$dirs[61]][1][] = "da.js";
$files[$dirs[61]][1][] = "de.js";
$files[$dirs[61]][1][] = "el.js";
$files[$dirs[61]][1][] = "en-au.js";
$files[$dirs[61]][1][] = "en-ca.js";
$files[$dirs[61]][1][] = "en-uk.js";
$files[$dirs[61]][1][] = "en.js";
$files[$dirs[61]][1][] = "eo.js";
$files[$dirs[61]][1][] = "es.js";
$files[$dirs[61]][1][] = "et.js";
$files[$dirs[61]][1][] = "eu.js";
$files[$dirs[61]][1][] = "fa.js";
$files[$dirs[61]][1][] = "fi.js";
$files[$dirs[61]][1][] = "fo.js";
$files[$dirs[61]][1][] = "fr-ca.js";
$files[$dirs[61]][1][] = "fr.js";
$files[$dirs[61]][1][] = "gl.js";
$files[$dirs[61]][1][] = "he.js";
$files[$dirs[61]][1][] = "hi.js";
$files[$dirs[61]][1][] = "hr.js";
$files[$dirs[61]][1][] = "hu.js";
$files[$dirs[61]][1][] = "it.js";
$files[$dirs[61]][1][] = "ja.js";
$files[$dirs[61]][1][] = "km.js";
$files[$dirs[61]][1][] = "ko.js";
$files[$dirs[61]][1][] = "lt.js";
$files[$dirs[61]][1][] = "lv.js";
$files[$dirs[61]][1][] = "mn.js";
$files[$dirs[61]][1][] = "ms.js";
$files[$dirs[61]][1][] = "nb.js";
$files[$dirs[61]][1][] = "nl.js";
$files[$dirs[61]][1][] = "no.js";
$files[$dirs[61]][1][] = "pl.js";
$files[$dirs[61]][1][] = "pt-br.js";
$files[$dirs[61]][1][] = "pt.js";
$files[$dirs[61]][1][] = "ro.js";
$files[$dirs[61]][1][] = "ru.js";
$files[$dirs[61]][1][] = "sk.js";
$files[$dirs[61]][1][] = "sl.js";
$files[$dirs[61]][1][] = "sr-latn.js";
$files[$dirs[61]][1][] = "sr.js";
$files[$dirs[61]][1][] = "sv.js";
$files[$dirs[61]][1][] = "th.js";
$files[$dirs[61]][1][] = "tr.js";
$files[$dirs[61]][1][] = "uk.js";
$files[$dirs[61]][1][] = "vi.js";
$files[$dirs[61]][1][] = "zh-cn.js";
$files[$dirs[61]][1][] = "zh.js";

$dirs[62] = "lib/editor/editor/plugins/";
$files[$dirs[62]][0] = array();
$files[$dirs[62]][1] = array();

$dirs[63] = "lib/editor/editor/plugins/autogrow/";
$files[$dirs[63]][0] = array();
$files[$dirs[63]][1] = array();
$files[$dirs[63]][1][] = "fckplugin.js";

$dirs[64] = "lib/editor/editor/plugins/bbcode/";
$files[$dirs[64]][0] = array();
$files[$dirs[64]][1] = array();
$files[$dirs[64]][1][] = "fckplugin.js";

$dirs[65] = "lib/editor/editor/plugins/bbcode/_sample/";
$files[$dirs[65]][0] = array();
$files[$dirs[65]][1] = array();
$files[$dirs[65]][1][] = "sample.config.js";
$files[$dirs[65]][1][] = "sample.html";

$dirs[66] = "lib/editor/editor/plugins/dragresizetable/";
$files[$dirs[66]][0] = array();
$files[$dirs[66]][1] = array();
$files[$dirs[66]][1][] = "fckplugin.js";

$dirs[67] = "lib/editor/editor/plugins/placeholder/";
$files[$dirs[67]][0] = array();
$files[$dirs[67]][1] = array();
$files[$dirs[67]][1][] = "fck_placeholder.html";
$files[$dirs[67]][1][] = "fckplugin.js";
$files[$dirs[67]][1][] = "placeholder.gif";

$dirs[68] = "lib/editor/editor/plugins/placeholder/lang/";
$files[$dirs[68]][0] = array();
$files[$dirs[68]][1] = array();
$files[$dirs[68]][1][] = "de.js";
$files[$dirs[68]][1][] = "en.js";
$files[$dirs[68]][1][] = "es.js";
$files[$dirs[68]][1][] = "fr.js";
$files[$dirs[68]][1][] = "it.js";
$files[$dirs[68]][1][] = "pl.js";

$dirs[69] = "lib/editor/editor/plugins/simplecommands/";
$files[$dirs[69]][0] = array();
$files[$dirs[69]][1] = array();
$files[$dirs[69]][1][] = "fckplugin.js";

$dirs[70] = "lib/editor/editor/plugins/tablecommands/";
$files[$dirs[70]][0] = array();
$files[$dirs[70]][1] = array();
$files[$dirs[70]][1][] = "fckplugin.js";

$dirs[71] = "lib/editor/editor/skins/";
$files[$dirs[71]][0] = array();
$files[$dirs[71]][1] = array();
$files[$dirs[71]][1][] = "_fckviewstrips.html";

$dirs[72] = "lib/editor/editor/skins/default/";
$files[$dirs[72]][0] = array();
$files[$dirs[72]][1] = array();
$files[$dirs[72]][1][] = "fck_dialog.css";
$files[$dirs[72]][1][] = "fck_dialog_ie6.js";
$files[$dirs[72]][1][] = "fck_editor.css";
$files[$dirs[72]][1][] = "fck_strip.gif";

$dirs[73] = "lib/editor/editor/skins/default/images/";
$files[$dirs[73]][0] = array();
$files[$dirs[73]][1] = array();
$files[$dirs[73]][1][] = "dialog.sides.gif";
$files[$dirs[73]][1][] = "dialog.sides.png";
$files[$dirs[73]][1][] = "dialog.sides.rtl.png";
$files[$dirs[73]][1][] = "sprites.gif";
$files[$dirs[73]][1][] = "sprites.png";
$files[$dirs[73]][1][] = "toolbar.arrowright.gif";
$files[$dirs[73]][1][] = "toolbar.buttonarrow.gif";
$files[$dirs[73]][1][] = "toolbar.collapse.gif";
$files[$dirs[73]][1][] = "toolbar.end.gif";
$files[$dirs[73]][1][] = "toolbar.expand.gif";
$files[$dirs[73]][1][] = "toolbar.separator.gif";
$files[$dirs[73]][1][] = "toolbar.start.gif";

$dirs[74] = "lib/editor/editor/skins/office2003/";
$files[$dirs[74]][0] = array();
$files[$dirs[74]][1] = array();
$files[$dirs[74]][1][] = "fck_dialog.css";
$files[$dirs[74]][1][] = "fck_dialog_ie6.js";
$files[$dirs[74]][1][] = "fck_editor.css";
$files[$dirs[74]][1][] = "fck_strip.gif";

$dirs[75] = "lib/editor/editor/skins/office2003/images/";
$files[$dirs[75]][0] = array();
$files[$dirs[75]][1] = array();
$files[$dirs[75]][1][] = "dialog.sides.gif";
$files[$dirs[75]][1][] = "dialog.sides.png";
$files[$dirs[75]][1][] = "dialog.sides.rtl.png";
$files[$dirs[75]][1][] = "sprites.gif";
$files[$dirs[75]][1][] = "sprites.png";
$files[$dirs[75]][1][] = "toolbar.arrowright.gif";
$files[$dirs[75]][1][] = "toolbar.bg.gif";
$files[$dirs[75]][1][] = "toolbar.buttonarrow.gif";
$files[$dirs[75]][1][] = "toolbar.collapse.gif";
$files[$dirs[75]][1][] = "toolbar.end.gif";
$files[$dirs[75]][1][] = "toolbar.expand.gif";
$files[$dirs[75]][1][] = "toolbar.separator.gif";
$files[$dirs[75]][1][] = "toolbar.start.gif";

$dirs[76] = "lib/editor/editor/skins/rudweb/";
$files[$dirs[76]][0] = array();
$files[$dirs[76]][1] = array();
$files[$dirs[76]][1][] = "fck_dialog.css";
$files[$dirs[76]][1][] = "fck_dialogie.css";
$files[$dirs[76]][1][] = "fck_dialog_ie6.js";
$files[$dirs[76]][1][] = "fck_editor.css";
$files[$dirs[76]][1][] = "fck_editorie.css";
$files[$dirs[76]][1][] = "fck_strip.gif";

$dirs[77] = "lib/editor/editor/skins/rudweb/images/";
$files[$dirs[77]][0] = array();
$files[$dirs[77]][1] = array();
$files[$dirs[77]][1][] = "dialog.sides.gif";
$files[$dirs[77]][1][] = "dialog.sides.png";
$files[$dirs[77]][1][] = "dialog.sides.rtl.png";
$files[$dirs[77]][1][] = "sprites.gif";
$files[$dirs[77]][1][] = "sprites.png";
$files[$dirs[77]][1][] = "toolbar.arrowright.gif";
$files[$dirs[77]][1][] = "toolbar.buttonarrow.gif";
$files[$dirs[77]][1][] = "toolbar.collapse.gif";
$files[$dirs[77]][1][] = "toolbar.end.gif";
$files[$dirs[77]][1][] = "toolbar.expand.gif";
$files[$dirs[77]][1][] = "toolbar.separator.gif";
$files[$dirs[77]][1][] = "toolbar.start.gif";

$dirs[78] = "lib/editor/editor/skins/silver/";
$files[$dirs[78]][0] = array();
$files[$dirs[78]][1] = array();
$files[$dirs[78]][1][] = "fck_dialog.css";
$files[$dirs[78]][1][] = "fck_dialog_ie6.js";
$files[$dirs[78]][1][] = "fck_editor.css";
$files[$dirs[78]][1][] = "fck_strip.gif";

$dirs[79] = "lib/editor/editor/skins/silver/images/";
$files[$dirs[79]][0] = array();
$files[$dirs[79]][1] = array();
$files[$dirs[79]][1][] = "dialog.sides.gif";
$files[$dirs[79]][1][] = "dialog.sides.png";
$files[$dirs[79]][1][] = "dialog.sides.rtl.png";
$files[$dirs[79]][1][] = "sprites.gif";
$files[$dirs[79]][1][] = "sprites.png";
$files[$dirs[79]][1][] = "toolbar.arrowright.gif";
$files[$dirs[79]][1][] = "toolbar.buttonarrow.gif";
$files[$dirs[79]][1][] = "toolbar.buttonbg.gif";
$files[$dirs[79]][1][] = "toolbar.collapse.gif";
$files[$dirs[79]][1][] = "toolbar.end.gif";
$files[$dirs[79]][1][] = "toolbar.expand.gif";
$files[$dirs[79]][1][] = "toolbar.separator.gif";
$files[$dirs[79]][1][] = "toolbar.start.gif";
?>