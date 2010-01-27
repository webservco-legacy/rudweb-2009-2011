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
./inc/rudwebm.inc.php
15:58 2008-09-27
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

/* ********** ********** ********** MULTIPLE LANGUAGES ********** ********** ********** */
if (_RUDWEB_CFG_LANG_ON === "1") {require _RUDWEB_MOD_DIR . 'modlang.inc.php';}
else {function genLangMod() {}}
/* ********** ********** ********** //MULTIPLE LANGUAGES ********** ********** ********** */
/* ********** ********** ********** MULTIPLE SKINS ********** ********** ********** */
if (_RUDWEB_CFG_SKIN_ON === "1") {require _RUDWEB_MOD_DIR . 'modskin.inc.php';}
/* ********** ********** ********** //MULTIPLE SKINS ********** ********** ********** */
/* ********** ********** ********** MULTIPLE USERS ********** ********** ********** */
if (_RUDWEB_CFG_USR_ON === "1") {require _RUDWEB_MOD_DIR . 'moduser.inc.php';}
else {function genUserMod() {}}
/* ********** ********** ********** //MULTIPLE USERS ********** ********** ********** */
/* ********** ********** ********** VISITOR STATISTICS ********** ********** ********** */
if (_RUDWEB_CFG_STATS_ON === "1") {require _RUDWEB_MOD_DIR . 'modstats.inc.php';}
else {
  function doStats() {}
  function showStats() {}
}
/* ********** ********** ********** //VISITOR STATISTICS ********** ********** ********** */
/* ********** ********** ********** PAGE PARSE TIME ********** ********** ********** */
if (_RUDWEB_CFG_TIMER === "1") {require _RUDWEB_MOD_DIR . 'modtimer.inc.php';}
else {function pageLoadTime() {}}
/* ********** ********** ********** //PAGE PARSE TIME ********** ********** ********** */
/* ********** ********** ********** FEATURED CONTENT ********** ********** ********** */
if (_RUDWEB_CFG_FTR_ON === "1") {require _RUDWEB_MOD_DIR . 'modftr.inc.php';}
else {function showFeatured() {}}
/* ********** ********** ********** //FEATURED CONTENT ********** ********** ********** */
/* ********** ********** ********** FEATURED CONTENT ********** ********** ********** */
if (_RUDWEB_CFG_DEBUG === "1") {require _RUDWEB_MOD_DIR . 'moddebug.inc.php';}
else {function debugOutput() {}}
/* ********** ********** ********** //FEATURED CONTENT ********** ********** ********** */
/* ********** ********** ********** COPYRIGHT ********** ********** ********** */
if (_RUDWEB_CFG_CPY === "1") {require _RUDWEB_MOD_DIR . 'modcpy.inc.php';}
else {function genCopyright() {}}
/* ********** ********** ********** //COPYRIGHT ********** ********** ********** */
/* ********** ********** ********** SITEMAP ********** ********** ********** */
if (_RUDWEB_CFG_SMAP === "1") {require _RUDWEB_MOD_DIR . 'modsmap.inc.php';}
/* ********** ********** ********** //SITEMAP ********** ********** ********** */
/* ********** ********** ********** YOUAREHERE ********** ********** ********** */
if (_RUDWEB_CFG_YAH === "1") {require _RUDWEB_MOD_DIR . 'modyah.inc.php';}
else {function youAreHere() {}}
/* ********** ********** ********** //YOUAREHERE ********** ********** ********** */
/* ********** ********** ********** NEWS ********** ********** ********** */
if (_RUDWEB_CFG_NWS === "1") {require _RUDWEB_MOD_DIR . 'modnws.inc.php';}
else {
  function showLatestNews() {}
  function showNewsAll() {}
  function showNewsItem() {}
  function addNewsItem() {}
  function showNewsItemForm() {}
  function newsPageNavigation() {}
}
/* ********** ********** ********** //NEWS ********** ********** ********** */
/* ********** ********** ********** SEARCH ********** ********** ********** */
if (_RUDWEB_CFG_SRC === "1") {require _RUDWEB_MOD_DIR . 'modsrc.inc.php';}
/* ********** ********** ********** //SEARCH ********** ********** ********** */
/* ********** ********** ********** CONTENT TAGS ********** ********** ********** */
if (_RUDWEB_CFG_CNT_TAGS === "1") {require _RUDWEB_MOD_DIR . 'modtagsc.inc.php';}
else {
  function showCntTags() {}
  function showTagsContent() {}
  function showAllTags() {}
}
/* ********** ********** ********** //CONTENT TAGS ********** ********** ********** */
/* ********** ********** ********** CATALOG MODULE ********** ********** ********** */
if (_RUDWEB_CFG_CAT === "1") {require _RUDWEB_MOD_DIR . 'modcat.inc.php';}
else {
  function catYah() {}
  function catalogPageNavigation() {}
  function catalogSubcatsMenu() {}
  function catalogCategoriesMenu() {}
  function showCso() {}
  function setIpg(){}
  function catSortLink() {}
}
/* ********** ********** ********** //CATALOG MODULE ********** ********** ********** */
/* ********** ********** ********** CATALOG SPECIAL OFFERS ********** ********** ********** */
/* ********** ********** ********** CATALOG //SPECIAL OFFERS ********** ********** ********** */
if (_RUDWEB_CFG_CSP_ON == 1) {require _RUDWEB_MOD_DIR . 'modcsp.inc.php';}
else {
  function showNewCspForm() {}
}
/* ********** ********** ********** SHOPPING CART ********** ********** ********** */
if (_RUDWEB_CFG_CART_ON === "1") {require _RUDWEB_MOD_DIR . 'modcart.inc.php';}
else {
  function showProducts() {}
  function showCart() {}
}
/* ********** ********** ********** //SHOPPING CART ********** ********** ********** */
/* ********** ********** ********** ADMINISTRATION MODULE ********** ********** ********** */
if (_RUDWEB_CFG_ADM === "1") {require _RUDWEB_MOD_DIR . 'modadm.inc.php';}
else {
  function genAdminMod() {}
  function adminMenu() {}
}
/* ********** ********** ********** //ADMINISTRATION MODULE ********** ********** ********** */
/* ********** ********** ********** CONTENT & CATALOG COMMENTS ********** ********** ********** */
if (_RUDWEB_CFG_CNT_CMNTS === "1") {require _RUDWEB_MOD_DIR . 'modcmt.inc.php';}
else {
  function showComments() {}
  function showExtComments() {}
  function genCmtForm() {}
}
/* ********** ********** ********** //CONTENT & CATALOG COMMENTS ********** ********** ********** */
/* ********** ********** ********** CONTACT ********** ********** ********** */
if (_RUDWEB_CFG_CON === "1") {require _RUDWEB_MOD_DIR . 'modcon.inc.php';}
else {
  function showContactForm() {}
}
/* ********** ********** ********** //CONTACT ********** ********** ********** */
?>