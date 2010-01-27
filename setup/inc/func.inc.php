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
./setup/cfg/func.inc.php
15:20 2008-06-25
*/
function generate_lncfg_str($eol, $now, $ln) {
  $c  = '<?php'.$eol.'/*'.$eol.'./inc/langs/'.$ln.'/langcfg.inc.php'.$eol.$now.$eol.'*/'.$eol;
  $c .= $eol . 'if(!defined(\'_RUDWEB_PUBFIL\')) {require_once \'./../lib/404.php\';}';
  $c .= $eol . '';
  $c .= $eol . '// WEBSITE TITLE, DESCRIPTION, KEYWORDS - GLOBAL - in the default language';
  $c .= $eol . 'define(\'_RUDWEB_WSTT\', \''.$_SESSION['rudwebset_langs_wstt'][$ln].'\');';
  $c .= $eol . 'define(\'_RUDWEB_WSDS\', \''.$_SESSION['rudwebset_langs_wsds'][$ln].'\');';
  $c .= $eol . 'define(\'_RUDWEB_WSKW\', \''.$_SESSION['rudwebset_langs_wskw'][$ln].'\');';
  $c .= $eol . '// FEATURED CONTENT';
  $c .= $eol . '$rudweb_ln[\'featured\'][\'tt\']   = \''.$_SESSION['rudwebset_langs_ftt'][$ln].'\';';
  $c .= $eol . '$rudweb_ln[\'featured\'][\'desc\'] = \''.$_SESSION['rudwebset_langs_fds'][$ln].'\';';
  $c .= $eol . '// CATALOG';
  $c .= $eol . '$rudweb_ln[\'catalog\'][\'catalog\'] = \''.$_SESSION['rudwebset_langs_catalog'][$ln].'\';';
  $c .= $eol . '$rudweb_ln[\'catalog\'][\'cattt\']   = \''.$_SESSION['rudwebset_langs_cattt'][$ln].'\';';
  $c .= $eol . '$rudweb_ln[\'catalog\'][\'itemstt\'] = \''.$_SESSION['rudwebset_langs_itemstt'][$ln].'\';';
  $c .= $eol . '$rudweb_ln[\'catalog\'][\'itemtt\']  = \''.$_SESSION['rudwebset_langs_itemtt'][$ln].'\';';
  $c .= $eol . '$rudweb_ln[\'catalog\'][\'csp\']     = \''.$_SESSION['rudwebset_langs_csp'][$ln].'\';';
  $c .= $eol . '// PRODUCTS';
  $c .= $eol . '$rudweb_ln[\'prod\'][\'pid\']        = \''.$_SESSION['rudwebset_langs_cat_pid'][$ln].'\';';
  $c .= $eol . '$rudweb_ln[\'prod\'][\'ppic\']       = \''.$_SESSION['rudwebset_langs_cat_ppic'][$ln].'\';';
  $c .= $eol . '$rudweb_ln[\'prod\'][\'pname\']      = \''.$_SESSION['rudwebset_langs_cat_pname'][$ln].'\';';
  $c .= $eol . '$rudweb_ln[\'prod\'][\'prd_dsc\']    = \''.$_SESSION['rudwebset_langs_cat_prd_dsc'][$ln].'\';';
  $c .= $eol . '$rudweb_ln[\'prod\'][\'pprice\']     = \''.$_SESSION['rudwebset_langs_cat_pprice'][$ln].'\';';
  $c .= $eol . '?>';
  return $c;
}
function generate_config_str($eol, $now) {
  $c  = '<?php'.$eol.'/*'.$eol.'./inc/config.inc.php'.$eol.$now.$eol.'*/'.$eol;
  $c .= $eol . 'if(!defined(\'_RUDWEB_PUBFIL\')) {require_once \'./../lib/404.php\';}';
  $c .= $eol . '';
  $c .= $eol . '// DATABASE CONNECTION SETTINGS';
  $c .= $eol . '$rudweb_dbtype = \''.$_SESSION['rudwebset_set_dbtype'].'\';';
  $c .= $eol . '$rudweb_dbport = \''.$_SESSION['rudwebset_set_dbport'].'\';';
  $c .= $eol . '$rudweb_dbhost = \''.$_SESSION['rudwebset_set_dbhost'].'\';';
  $c .= $eol . '$rudweb_dbuser = \''.$_SESSION['rudwebset_set_dbuser'].'\';';
  $c .= $eol . '$rudweb_dbpass = \''.$_SESSION['rudwebset_set_dbpass'].'\';';
  $c .= $eol . '$rudweb_dbname = \''.$_SESSION['rudwebset_set_dbname'].'\';';
  $c .= $eol . '// WEBSITE URL';
  $c .= $eol . 'define(\'_RUDWEB_SITE_URL\',\''.$_SESSION['rudwebset_set_site_url1'].'/\');';
  $c .= $eol . '//define(\'_RUDWEB_SITE_URL\',\''.$_SESSION['rudwebset_set_site_url2'].'\');';
  $c .= $eol . '// WEBSITE DIRECTORY';
  $c .= $eol . 'define(\'_RUDWEB_SITE_DIR\',\''.$_SESSION['rudwebset_set_site_root1'].'\');';
  $c .= $eol . '//define(\'_RUDWEB_SITE_DIR\',\''.$_SESSION['rudwebset_set_site_root2'].'\');';
  $c .= $eol . '// TAKE SITE SETTINGS FROM DB (1) OR FROM FILE (0)';
  $c .= $eol . 'define(\'_RUDWEB_DBCFG\', \''.$_SESSION['rudwebset_set_dbcfg'].'\');';
  $c .= $eol . '// TAKE SKIN SETTINGS FROM DB(1) OR FROM FILE (0)';
  $c .= $eol . 'define(\'_RUDWEB_DBSKIN\', \''.$_SESSION['rudwebset_set_dbskin'].'\');';
  $c .= $eol . '// GLOBAL PREFIX, INCLUDING DATABASE TABLES PREFIX';
  $c .= $eol . 'define(\'_RUDWEB_PRE\', \''.$_SESSION['rudwebset_set_pre'].'_\');';
  $c .= $eol . '// REMOVE \'index.php\' FROM URLS = \'\'. DON\'T REMOVE = \'index.php/\'';
  $c .= $eol . 'define(\'_RUDWEB_INDEX_PHP\', \''.$_SESSION['rudwebset_set_index'].'\');';
  $c .= $eol . '?>';
  return $c;
}
function generate_rudwebcfg_str($eol, $now) {
  $c  = '<?php'.$eol.'/*'.$eol.'./inc/rudwebcfg.inc.php'.$eol.$now.$eol.'*/'.$eol;
  $c .= $eol . 'if(!defined(\'_RUDWEB_PUBFIL\')) {require_once \'./../lib/404.php\';}';
  $c .= $eol . '';
  $c .= $eol . '// WEBSITE START DATE';
  $c .= $eol . 'define(\'_RUDWEB_CFG_START\', \''.$_SESSION['rudwebset_cfg_start'].'\');';
  $c .= $eol . '// WEBSITE OWNER/CLIENT DATA';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CLCOM\', \''.$_SESSION['rudwebset_cfg_clcom'].'\'); // company name';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CLNAM\', \''.$_SESSION['rudwebset_cfg_clnam'].'\'); // contact person';
  $c .= $eol . '// WEBSITE DEVELOPER DATA';
  $c .= $eol . 'define(\'_RUDWEB_CFG_DVCOM\', \''.$_SESSION['rudwebset_cfg_dvcom'].'\'); // company name';
  $c .= $eol . 'define(\'_RUDWEB_CFG_DVURL\', \''.$_SESSION['rudwebset_cfg_dvurl'].'\'); // company url';
  $c .= $eol . 'define(\'_RUDWEB_CFG_DVNAM\', \''.$_SESSION['rudwebset_cfg_dvnam'].'\'); // contact person';
  $c .= $eol . '// HTML HEADER META';
  $c .= $eol . 'define(\'_RUDWEB_CFG_DESIG\', _RUDWEB_CFG_DVNAM); // company';
  $c .= $eol . 'define(\'_RUDWEB_CFG_PUBL\', _RUDWEB_CFG_DVCOM); // company';
  $c .= $eol . 'define(\'_RUDWEB_CFG_COPY\', \'&copy; \' . substr(_RUDWEB_CFG_START, 0, 4) . \' \' . _RUDWEB_CFG_CLCOM);';
  $c .= $eol . 'define(\'_RUDWEB_CFG_RATNG\', \''.$_SESSION['rudwebset_cfg_ratng'].'\');';
  $c .= $eol . 'define(\'_RUDWEB_CFG_DISTR\', \''.$_SESSION['rudwebset_cfg_distr'].'\'); /* Global / Local */';
  $c .= $eol . 'define(\'_RUDWEB_CFG_ROBOTS\', \''.$_SESSION['rudwebset_cfg_robots'].'\'); /* INDEX, FOLLOW / NOINDEX, NOFOLLOW */';
  $c .= $eol . 'define(\'_RUDWEB_CFG_PRAG\', \''.$_SESSION['rudwebset_cfg_prag'].'\');';
  $c .= $eol . 'define(\'_RUDWEB_CFG_EXP\', \''.$_SESSION['rudwebset_cfg_exp'].'\');';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CACHE\', \''.$_SESSION['rudwebset_cfg_cache'].'\');';
  $c .= $eol . '// DEFAULT LANGUAGE';
  $c .= $eol . 'define(\'_RUDWEB_CFG_LANG\',\''.$_SESSION['rudwebset_cfg_lang'].'\');';
  $c .= $eol . '// DEFAULT SKIN';
  $c .= $eol . 'define(\'_RUDWEB_CFG_SKIN\',\''.$_SESSION['rudwebset_cfg_skin'].'\');';
  $c .= $eol . '// DEFAULT PAGE TO DISPLAY AT FIRST (IF ENABLED)';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CNT_EN\',\''.$_SESSION['rudwebset_cfg_cnt_en'].'\');';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CNT_DE\',\''.$_SESSION['rudwebset_cfg_cnt_de'].'\');';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CNT_ES\',\''.$_SESSION['rudwebset_cfg_cnt_es'].'\');';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CNT_FR\',\''.$_SESSION['rudwebset_cfg_cnt_fr'].'\');';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CNT_IT\',\''.$_SESSION['rudwebset_cfg_cnt_it'].'\');';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CNT_RO\',\''.$_SESSION['rudwebset_cfg_cnt_ro'].'\');';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CNT_SHW\', \''.$_SESSION['rudwebset_cfg_cnt_shw'].'\'); // enable display of content at start';
  $c .= $eol . '//OPTIONAL SITE MODULES';
  $c .= $eol . 'define(\'_RUDWEB_CFG_LANG_ON\', \''.$_SESSION['rudwebset_cfg_lang_on'].'\'); // enable multiple languages';
  $c .= $eol . 'define(\'_RUDWEB_CFG_USR_ON\', \''.$_SESSION['rudwebset_cfg_usr_on'].'\'); // enable user authentification';
  $c .= $eol . 'define(\'_RUDWEB_CFG_SKIN_ON\', \''.$_SESSION['rudwebset_cfg_skin_on'].'\'); // enable multiple skins';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CAT\', \''.$_SESSION['rudwebset_cfg_cat'].'\'); // enable catalog';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CAT_IPG\', \''.$_SESSION['rudwebset_cfg_cat_ipg'].'\'); // catalog items/page';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CAT_FLT\', \''.$_SESSION['rudwebset_cfg_cat_flt'].'\'); // catalog filter box';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CART_ON\', \''.$_SESSION['rudwebset_cfg_cart_on'].'\'); // enable shopping cart';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CSP_ON\', \''.$_SESSION['rudwebset_cfg_csp_on'].'\'); // enable catalog special offers';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CSP_LMT\', \''.$_SESSION['rudwebset_cfg_csp_lmt'].'\'); // number of special offers';
  $c .= $eol . 'define(\'_RUDWEB_CFG_STATS_ON\', \''.$_SESSION['rudwebset_cfg_stats_on'].'\'); // enable visitor statistics';
  $c .= $eol . 'define(\'_RUDWEB_CFG_STATS_IP\', \''.$_SESSION['rudwebset_cfg_stats_ip'].'\'); // visitor ip to ignore in statistics';
  $c .= $eol . 'define(\'_RUDWEB_CFG_FTR_ON\', \''.$_SESSION['rudwebset_cfg_ftr_on'].'\'); // enable featured content';
  $c .= $eol . 'define(\'_RUDWEB_CFG_FTR_LMT\', \''.$_SESSION['rudwebset_cfg_ftr_lmt'].'\'); // number of featured items';
  $c .= $eol . 'define(\'_RUDWEB_CFG_TIMER\', \''.$_SESSION['rudwebset_cfg_timer'].'\'); // enable page load time';
  $c .= $eol . 'define(\'_RUDWEB_CFG_DEBUG\', \''.$_SESSION['rudwebset_cfg_debug'].'\'); // enable debug info';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CPY\', \''.$_SESSION['rudwebset_cfg_cpy'].'\'); // enable copyright notice';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CPYDEV\', \''.$_SESSION['rudwebset_cfg_cpydev'].'\'); // show developer info in copyright notice';
  $c .= $eol . 'define(\'_RUDWEB_CFG_SMAP\', \''.$_SESSION['rudwebset_cfg_smap'].'\'); // enable sitemap';
  $c .= $eol . 'define(\'_RUDWEB_CFG_YAH\', \''.$_SESSION['rudwebset_cfg_yah'].'\'); // enable youarehere';
  $c .= $eol . 'define(\'_RUDWEB_CFG_NWS\', \''.$_SESSION['rudwebset_cfg_nws'].'\'); // enable news';
  $c .= $eol . 'define(\'_RUDWEB_CFG_NWS_LMT1\', \''.$_SESSION['rudwebset_cfg_nws_lmt1'].'\'); // news items limit latest';
  $c .= $eol . 'define(\'_RUDWEB_CFG_NWS_LMT2\', \''.$_SESSION['rudwebset_cfg_nws_lmt2'].'\'); // news items per page';
  $c .= $eol . 'define(\'_RUDWEB_CFG_SRC\', \''.$_SESSION['rudwebset_cfg_src'].'\'); // enable search';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CON\', \''.$_SESSION['rudwebset_cfg_con'].'\'); // enable contact module';
  $c .= $eol . '// OPTIONAL CONTENT MODULES';
  $c .= $eol . 'define(\'_RUDWEB_CFG_PICS_0\', \''.$_SESSION['rudwebset_cfg_pics_0'].'\'); // enable content pictures 0';
  $c .= $eol . 'define(\'_RUDWEB_CFG_PICS_1\', \''.$_SESSION['rudwebset_cfg_pics_1'].'\'); // enable content pictures 1';
  $c .= $eol . 'define(\'_RUDWEB_CFG_PICS_2\', \''.$_SESSION['rudwebset_cfg_pics_2'].'\'); // enable content pictures 2';
  $c .= $eol . 'define(\'_RUDWEB_CFG_PICS_3\', \''.$_SESSION['rudwebset_cfg_pics_3'].'\'); // enable content pictures 3';
  $c .= $eol . 'define(\'_RUDWEB_CFG_PICS_4\', \''.$_SESSION['rudwebset_cfg_pics_4'].'\'); // enable content pictures 4';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CNT_POSTED\', \''.$_SESSION['rudwebset_cfg_cnt_posted'].'\'); // enable content posted by';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CNT_TAGS\', \''.$_SESSION['rudwebset_cfg_cnt_tags'].'\'); // enable content tags';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CNT_CMNTS\', \''.$_SESSION['rudwebset_cfg_cnt_cmnts'].'\'); // enable content comments';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CNT_LNKS\', \''.$_SESSION['rudwebset_cfg_cnt_lnks'].'\'); // enable content links';
  $c .= $eol . 'define(\'_RUDWEB_CFG_CNT_DLDS\', \''.$_SESSION['rudwebset_cfg_cnt_dlds'].'\'); // enable content downloads';
  $c .= $eol . '// OPTIONAL CONTENT MODULES';
  $c .= $eol . 'define(\'_RUDWEB_CFG_ADM\', \''.$_SESSION['rudwebset_cfg_adm'].'\'); // 1 = enable admin module';
  $c .= $eol . '?>';
  return $c;
}
function generate_dbd_str($eol) {
  $c  = $eol . 'TRUNCATE TABLE rudweb_set_cfg;';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(1, \'START\', \''.$_SESSION['rudwebset_cfg_start'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(2, \'CLCOM\', \''.$_SESSION['rudwebset_cfg_clcom'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(3, \'CLNAM\', \''.$_SESSION['rudwebset_cfg_clnam'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(4, \'DVCOM\', \''.$_SESSION['rudwebset_cfg_dvcom'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(5, \'DVURL\', \''.$_SESSION['rudwebset_cfg_dvurl'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(6, \'DVNAM\', \''.$_SESSION['rudwebset_cfg_dvnam'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(7, \'DESIG\', \''.$_SESSION['rudwebset_cfg_dvnam'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(8, \'PUBL\', \''.$_SESSION['rudwebset_cfg_dvcom'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(9, \'RATNG\', \''.$_SESSION['rudwebset_cfg_ratng'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(10, \'DISTR\', \''.$_SESSION['rudwebset_cfg_distr'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(11, \'ROBOTS\', \''.$_SESSION['rudwebset_cfg_robots'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(12, \'PRAG\', \''.$_SESSION['rudwebset_cfg_prag'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(13, \'EXP\', \''.$_SESSION['rudwebset_cfg_exp'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(14, \'CACHE\', \''.$_SESSION['rudwebset_cfg_cache'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(15, \'LANG\', \''.$_SESSION['rudwebset_cfg_lang'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(16, \'SKIN\', \''.$_SESSION['rudwebset_cfg_skin'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(17, \'CNT_EN\', \''.$_SESSION['rudwebset_cfg_cnt_en'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(18, \'CNT_DE\', \''.$_SESSION['rudwebset_cfg_cnt_de'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(19, \'CNT_ES\', \''.$_SESSION['rudwebset_cfg_cnt_es'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(20, \'CNT_FR\', \''.$_SESSION['rudwebset_cfg_cnt_fr'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(21, \'CNT_IT\', \''.$_SESSION['rudwebset_cfg_cnt_it'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(22, \'CNT_RO\', \''.$_SESSION['rudwebset_cfg_cnt_ro'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(23, \'CNT_SHW\', \''.$_SESSION['rudwebset_cfg_cnt_shw'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(24, \'LANG_ON\', \''.$_SESSION['rudwebset_cfg_lang_on'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(25, \'USR_ON\', \''.$_SESSION['rudwebset_cfg_usr_on'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(26, \'SKIN_ON\', \''.$_SESSION['rudwebset_cfg_skin_on'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(27, \'CAT\', \''.$_SESSION['rudwebset_cfg_cat'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(28, \'CAT_IPG\', \''.$_SESSION['rudwebset_cfg_cat_ipg'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(29, \'CAT_PCS\', \''.$_SESSION['rudwebset_cfg_cat_pcs'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(30, \'CAT_FLT\', \''.$_SESSION['rudwebset_cfg_cat_flt'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(31, \'CART_ON\', \''.$_SESSION['rudwebset_cfg_cart_on'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(32, \'CSP_ON\', \''.$_SESSION['rudwebset_cfg_csp_on'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(33, \'CSP_LMT\', \''.$_SESSION['rudwebset_cfg_csp_lmt'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(34, \'STATS_ON\', \''.$_SESSION['rudwebset_cfg_stats_on'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(35, \'STATS_IP\', \''.$_SESSION['rudwebset_cfg_stats_ip'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(36, \'FTR_ON\', \''.$_SESSION['rudwebset_cfg_ftr_on'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(37, \'FTR_LMT\', \''.$_SESSION['rudwebset_cfg_ftr_lmt'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(38, \'TIMER\', \''.$_SESSION['rudwebset_cfg_timer'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(39, \'DEBUG\', \''.$_SESSION['rudwebset_cfg_debug'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(40, \'CPY\', \''.$_SESSION['rudwebset_cfg_cpy'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(41, \'CPYDEV\', \''.$_SESSION['rudwebset_cfg_cpydev'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(42, \'SMAP\', \''.$_SESSION['rudwebset_cfg_smap'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(43, \'YAH\', \''.$_SESSION['rudwebset_cfg_yah'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(44, \'NWS\', \''.$_SESSION['rudwebset_cfg_nws'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(45, \'NWS_LMT1\', \''.$_SESSION['rudwebset_cfg_nws_lmt1'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(46, \'NWS_LMT2\', \''.$_SESSION['rudwebset_cfg_nws_lmt2'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(47, \'SRC\', \''.$_SESSION['rudwebset_cfg_src'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(48, \'CON\', \''.$_SESSION['rudwebset_cfg_con'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(49, \'PICS_0\', \''.$_SESSION['rudwebset_cfg_pics_0'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(50, \'PICS_1\', \''.$_SESSION['rudwebset_cfg_pics_1'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(51, \'PICS_2\', \''.$_SESSION['rudwebset_cfg_pics_2'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(52, \'PICS_3\', \''.$_SESSION['rudwebset_cfg_pics_3'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(53, \'PICS_4\', \''.$_SESSION['rudwebset_cfg_pics_4'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(54, \'CNT_POSTED\', \''.$_SESSION['rudwebset_cfg_cnt_posted'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(55, \'CNT_TAGS\', \''.$_SESSION['rudwebset_cfg_cnt_tags'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(56, \'CNT_CMNTS\', \''.$_SESSION['rudwebset_cfg_cnt_cmnts'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(57, \'CNT_LNKS\', \''.$_SESSION['rudwebset_cfg_cnt_lnks'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(58, \'CNT_DLDS\', \''.$_SESSION['rudwebset_cfg_cnt_dlds'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $c .= $eol . 'INSERT INTO rudweb_set_cfg VALUES(59, \'ADM\', \''.$_SESSION['rudwebset_cfg_adm'].'\', \'VAL_CRD\', \'VAL_CRT\', 1, \'0000-00-00\', \'00:00:00\', 0);';
  $newuserpass = md5($_SESSION['rudwebset_cfg_adm_pass']);
  $c .= $eol . 'TRUNCATE TABLE rudweb_set_usr;';
  $c .= $eol . 'INSERT INTO rudweb_set_usr VALUES (1, \''.$_SESSION['rudwebset_cfg_adm_fname'].'\', \''.$_SESSION['rudwebset_cfg_adm_mname'].'\', \''.$_SESSION['rudwebset_cfg_adm_lname'].'\', \''.$_SESSION['rudwebset_cfg_adm_mail'].'\', \'\', \'\', \'\', \'Root\', \''.$_SESSION['rudwebset_cfg_adm_mail'].'\', \''.$newuserpass.'\', \''.$_SESSION['rudwebset_cfg_skin'].'\', \''.$_SESSION['rudwebset_cfg_lang'].'\', 5, 1, 0, \'default admin\', \'VAL_CRD\');';
  return $c;
}
function generate_removed01($eol) {
  $c   = $eol . 'TRUNCATE TABLE rudweb_cat_cat;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_cat_crt;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_cat_crv;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_cat_csp;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_cat_det;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_cat_opt;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_cat_pic;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_cat_prd;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_cat_val;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_set_cfg;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_set_usr;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_var_logins;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_var_pas;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_var_reg;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_var_stats;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_ws_cmt;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_ws_cnt;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_ws_ftr;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_ws_lnk;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_ws_mnu;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_ws_nws;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_ws_pic;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_ws_rel;';
  $c  .= $eol . 'TRUNCATE TABLE rudweb_ws_tags;';

  $c  .= $eol . 'OPTIMIZE TABLE rudweb_cat_cat;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_cat_crt;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_cat_crv;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_cat_csp;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_cat_det;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_cat_opt;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_cat_pic;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_cat_prd;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_cat_val;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_set_cfg;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_set_usr;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_var_logins;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_var_pas;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_var_reg;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_var_stats;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_ws_cmt;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_ws_cnt;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_ws_ftr;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_ws_lnk;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_ws_mnu;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_ws_nws;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_ws_pic;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_ws_rel;';
  $c  .= $eol . 'OPTIMIZE TABLE rudweb_ws_tags;';
  return $c;
}
function generate_removed02($eol) {
  $c   = $eol . 'DROP TABLE IF EXISTS rudweb_cat_cat;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_cat_crt;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_cat_crv;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_cat_csp;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_cat_det;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_cat_opt;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_cat_pic;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_cat_prd;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_cat_val;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_set_cfg;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_set_usr;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_var_logins;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_var_pas;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_var_reg;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_var_stats;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_ws_cmt;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_ws_cnt;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_ws_ftr;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_ws_lnk;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_ws_mnu;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_ws_nws;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_ws_pic;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_ws_rel;';
  $c  .= $eol . 'DROP TABLE IF EXISTS rudweb_ws_tags;';
  return $c;
}
function check_cfg_file($path, $file) {
  $err = 0;
  if(!is_dir($path)) {$err = 1;} /* directory doesn't exist */
  else if(!is_writable($path)) {$err = 2;} /* directory isn't writable */
  else if(file_exists($path.$file)) {$err = 3;} /* file already exists */
  else if(file_exists($path.$file) && !is_writable($path.$file)) {$err = 4;} /* file exists but writing is not possible */
  return $err;
}
function write_config_str($str, $file) {
  $err = 0;
  $f = fopen($file, 'wb');
  if($f !== false) {
    $w = fwrite($f, $str);
    if ($w === false) {$err = 1;} // could not write
    else {$err = 0;} // write ok
    fclose($f);
  }
  else {$err = 2;} // could not open file for writing
  return $err;
}
function get_version($location) {
  if(is_readable($location.'inc/rudwebc.inc.php')) {
    $version_raw = file($location.'inc/rudwebc.inc.php');
    $version_full = eregi_replace('define\("_RUDWEB_SITE_VERSION", "', '', $version_raw['25']);
    $version['0']  = eregi_replace('"\);', '', $version_full);
  }
  else {
    $version['0'] = '0.0.000000';
  }
  $version_temp = explode(".", $version['0']);
  //$version['1'] = substr($version['0'], 0, 3);
  $version['1'] = $version_temp['0'];
  $version['2'] = $version_temp['1'];
  //$version['2'] = '20' . substr($version['0'], 4, 2) . '-' .substr($version['0'], 6, 2) . '-' . substr($version['0'], 8, 2);
  $version['3'] = '20' . substr($version_temp['2'], 0, 2) . '-' .substr($version_temp['2'], 2, 2) . '-' . substr($version_temp['2'], 4, 2);
  //$version['3'] = substr($version['0'], 4, 6);
  $version['4'] = $version_temp['2'];
  return $version;
}
function compare_version($version_ub, $version_cl) {
  $compare = null;
  if($version_cl['0'] == '0.0.000000') {$compare = 0;} // TARGET DOESN'T EXIST
  else if($version_ub['0'] == $version_cl['0']) {$compare = 1;} // IDENTICAL
  else if($version_ub['0'] != $version_cl['0']) {
    $compare = 2; // DIFFERENT
    if($version_ub['1'] == $version_cl['1']) {
      $compare = 3;
      if($version_ub['2'] == $version_cl['2']) {
        $compare = 4;
        if($version_ub['3'] == $version_cl['3']) {$compare = 5;}
        else if($version_ub['3'] > $version_cl['3']) {$compare = 6;}
        else if($version_ub['3'] < $version_cl['3']) {$compare = 7;}
      }
      else if($version_ub['2'] > $version_cl['2']) {$compare = 8;}
      else if($version_ub['2'] < $version_cl['2']) {$compare = 9;}
    }
    else if($version_ub['1'] > $version_cl['1']) {$compare = 10;}
    else if($version_ub['1'] < $version_cl['1']) {$compare = 11;}
  }
  return $compare;
}
function version_age($version_ub, $version_cl) {
  //date_default_timezone_set('Europe/Helsinki');
  $today = mktime(0,0,0,date("m"),date("d"),date("Y"));
  
  $version_ub_a = explode('-',$version_ub[3]);
  $version_ub_sec = mktime(0,0,0,$version_ub_a[1],$version_ub_a[2],$version_ub_a[0]);
  $diff[0] = round((($today - $version_ub_sec) / 3600) / 24);
  if($version_cl[4] == '000000') {$version_cl_sec = '0';$diff[1] = 'n/a';$diff[2] = 'n/a';}
  else {
    $version_cl_a = explode('-',$version_cl[3]);
    $version_cl_sec = mktime(0,0,0,$version_cl_a[1],$version_cl_a[2],$version_cl_a[0]);
    $diff[1] = round((($today - $version_cl_sec) / 3600) / 24);
    $diff[2] = round((($version_ub_sec - $version_cl_sec) / 3600) / 24);
  }
  return $diff;
}
function show_version_age($version_age) {
  $version_msg = 'n/a';
  if($version_age === 'n/a') {$version_msg = 'n/a';}
  else if($version_age < '0') {$version_msg = 'n/a';}
  else if ($version_age == '0') {$version_msg = 'today';}
  else if($version_age > '0') {
    if($version_age == '1') {$version_msg = 'yesterday';}
    else                         {$version_msg = $version_age . ' days ago';}
  }
  return $version_msg;
}
function show_compare_version($compare_version) {
  switch($compare_version){
    case '0'  : {$compare_msg = 'File not found.'; break;}
    case '1'  : {$compare_msg = 'You have the latest version!'; break;}
    case '2'  : {$compare_msg = 'You have a different version!'; break;}
    case '3'  : {$compare_msg = 'Same version'; break;}
    case '4'  : {$compare_msg = 'Same version and subversion'; break;}
    case '5'  : {$compare_msg = 'You have a different version!'; break;}
    case '6'  : {$compare_msg = 'You have the latest version, but a new build is available!'; break;}
    case '7'  : {$compare_msg = 'You have the latest version and your build is newer!?!'; break;}
    case '8'  : {$compare_msg = 'A new version is available!'; break;}
    case '9'  : {$compare_msg = 'Your version is newer!?!'; break;}
    case '10' : {$compare_msg = 'A new version is available!'; break;}
    case '11' : {$compare_msg = 'Your version is newer!?!'; break;}
    default   : {break;}
  }
  return $compare_msg;
}
function check_gd() {
  if(function_exists('gd_info')) {
    $raw_gd_info = gd_info();
    $gd_check[0] = ereg_replace('[[:alpha:][:space:]()]+', '', $raw_gd_info['GD Version']);
    $gd_check[1] = $raw_gd_info['FreeType Support'];
  }
  else {
    $gd_check[0] = '0';
    $gd_check[1] = '0';
  }
  return $gd_check;
}
function get_dbsettings($location) {
  if(is_readable($location.'inc/config.inc.php')) {
    $lines = file($location.'inc/config.inc.php');
    $dbconfig['dbtype'] = eregi_replace('\$rudweb_dbtype = \'', '', $lines['9']);
    $dbconfig['dbtype'] = eregi_replace('\';', '', $dbconfig['dbtype']);
    $dbconfig['dbtype'] = trim($dbconfig['dbtype']);
    
    $dbconfig['dbport'] = eregi_replace('\$rudweb_dbport = \'', '', $lines['10']);
    $dbconfig['dbport'] = eregi_replace('\';', '', $dbconfig['dbport']);
    $dbconfig['dbport'] = trim($dbconfig['dbport']);
    
    $dbconfig['dbhost'] = eregi_replace('\$rudweb_dbhost = \'', '', $lines['11']);
    $dbconfig['dbhost'] = eregi_replace('\';', '', $dbconfig['dbhost']);
    $dbconfig['dbhost'] = trim($dbconfig['dbhost']);
    
    $dbconfig['dbuser'] = eregi_replace('\$rudweb_dbuser = \'', '', $lines['12']);
    $dbconfig['dbuser'] = eregi_replace('\';', '', $dbconfig['dbuser']);
    $dbconfig['dbuser'] = trim($dbconfig['dbuser']);
    
    $dbconfig['dbpass'] = eregi_replace('\$rudweb_dbpass = \'', '', $lines['13']);
    $dbconfig['dbpass'] = eregi_replace('\';', '', $dbconfig['dbpass']);
    $dbconfig['dbpass'] = trim($dbconfig['dbpass']);
    
    $dbconfig['dbname'] = eregi_replace('\$rudweb_dbname = \'', '', $lines['14']);
    $dbconfig['dbname'] = eregi_replace('\';', '', $dbconfig['dbname']);
    $dbconfig['dbname'] = trim($dbconfig['dbname']);
    
    $dbconfig['rudwebpre'] = eregi_replace('define\(\'_RUDWEB_PRE\', \'', '', $lines['26']);
    $dbconfig['rudwebpre'] = eregi_replace('_\'\);', '', $dbconfig['rudwebpre']);
    $dbconfig['rudwebpre'] = trim($dbconfig['rudwebpre']);
  }
  else {
    $dbconfig = null;
  }
  return $dbconfig;
}
/* ********** ********** ********** ********** ********** ********** ********** ********** ********** ********** */
// DATABASE FUNCTIONS
function rudweb_dbopen($db_type, $rudweb_dbhost, $rudweb_dbport, $rudweb_dbuser, $rudweb_dbpass, $rudweb_dbname) {
  switch($db_type) {
    case "my": {
      $rudweb_dbconn = mysql_connect($rudweb_dbhost . ":" . $rudweb_dbport , $rudweb_dbuser, $rudweb_dbpass) or die ("<B>Oups! [" . mysql_errno() . "]: " .mysql_error() . "</B>");
      mysql_select_db($rudweb_dbname) or die ("<B>Oups! [" . mysql_errno() . "]: " .mysql_error() . "</B>");
      break;
    }
    case "pg": {
      $rudweb_dbconn = pg_connect("host=" . $rudweb_dbhost . " port=".$rudweb_dbport." dbname=".$rudweb_dbname." user=".$rudweb_dbuser." password=".$rudweb_dbpass."") or die("Oops! Could not connect" . pg_connection_status($rudweb_dbconn));
      break;
    }
    default  : {$rudweb_conn = NULL; break;}
  }
  return $rudweb_dbconn;
}
function rudweb_dbclose($db_type, $rudweb_dbconn) {
  switch($db_type) {
    case "my": {mysql_close($rudweb_dbconn); break;}
    case "pg": {pg_close($rudweb_dbconn); break;}
    default  : {break;}
  }
}
function rudweb_qres($db_type, $query) {
  switch($db_type) {
    //case "my": {$result = mysql_query($query) or die("Oops! Query Failed. " . mysql_errno() . " : " . mysql_error()); break;}
    case "my": {$result = mysql_query($query);
    if($result == FALSE) {
      $result = "Oops! Query Failed. " . mysql_errno() . " : " . mysql_error();
    }
    break;
    }
    case "pg": {$result = pg_query($query) or die("Oops! Query Failed. " . pg_last_error()); break;}
    default  : {$result = NULL; break;}
  }
  return $result;
}
function rudweb_qtotal($db_type, $result) {
  switch($db_type) {
    case "my": {$total = mysql_num_rows($result); break;}
    case "pg": {$total = pg_num_rows($result); break;}
    default  : {$total = NULL; break;}
  }
  return $total;
}
function rudweb_fetch_assoc($db_type, $result) {
  switch($db_type) {
    case "my": {$row = mysql_fetch_assoc($result); break;}
    case "pg": {$row = pg_fetch_assoc($result); break;}
    default  : {$row = NULL; break;}
  }
  return $row;
}
function rudweb_affected($db_type, $result) {
  switch($db_type) {
    case "my": {$affected = mysql_affected_rows(); break;}
    case "pg": {$affected = pg_affected_rows($result); break;}
    default  : {$affected = NULL; break;}
  }
  return $affected;
}
function lsdir($dir) {
  $subdirs = NULL;
  $i = '1';
  if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {
        if ($file != "." && $file != "..") {
          if (filetype($dir . $file) == 'dir') {
            $subdirs[$i] = $file;
            $i++;
          }
        }
      }
    closedir($dh);
    }
  }
  return $subdirs;
}
/*
inspired by the phpbb code
start: 16:01 at 2008-01-07
10:44 - 2008-01-21
*/
function split_sql($sql, $delimiter) {
  // trim
  $sql = trim($sql);
	// remove # comments
  $sql = preg_replace('/\n{2,}/', "\n", preg_replace('/^#.*$/m', "\n", $sql));
  // remove -- comments
	$sql = preg_replace('/\n{2,}/', "\n", preg_replace('/^--.*$/m', "\n", $sql));
  // remove \r
  $sql = eregi_replace("\r", "", $sql);
  // split
  $sql = preg_split('/' . preg_quote($delimiter, '/') . '$/m', $sql);
  // trim pieces
  $sql = array_map('trim', $sql);
  // delete last one if empty
  $last_one = end($sql);
  if(empty($last_one)) {unset($sql[key($sql)]);}
  // return
  return $sql;
}
/* ********** ********** ********** ********** ********** ********** ********** ********** ********** ********** */
//rchillet at hotmail dot com (28-Apr-2006 09:45)

//improvement the function of heavyraptor with int offset parametre. 
if (!function_exists("stripos")) {
 function stripos($str,$needle,$offset=0)
 {
  return strpos(strtolower($str),strtolower($needle),$offset);
 }
}
/* ********** ********** ********** ********** ********** ********** ********** ********** ********** ********** */
// from php manual
//ggarciaa's post above has one small error, it will ignore file and directory strings that are evaluated as false (ie. "0")
//Fixed code is below (false !==)

// ggarciaa at gmail dot com (04-July-2007 01:57)
// I needed to empty a directory, but keeping it
// so I slightly modified the contribution from
// stefano at takys dot it (28-Dec-2005 11:57)
// A short but powerfull recursive function
// that works also if the dirs contain hidden files
//
// $dir = the target directory
// $DeleteMe = if true delete also $dir, if false leave it alone
function SureRemoveDir($dir, $DeleteMe) {
   $err = '1';
   if(!$dh = @opendir($dir)) return;
   while (false !== ($obj = readdir($dh))) {
       if($obj=='.' || $obj=='..') continue;
       if (!@unlink($dir.'/'.$obj)) {SureRemoveDir($dir.'/'.$obj, true); $err = '0';}
       else {$err = '1';}
   }
   if ($DeleteMe){
       closedir($dh);
       //@rmdir($dir);
       if(@rmdir($dir)) {$err = '0';}
   }
   if($err == '0') {return true;}
   else {return false;}
}
//SureRemoveDir('EmptyMe', false);
//SureRemoveDir('RemoveMe', true);
/* ********** ********** ********** ********** ********** ********** ********** ********** ********** ********** */
?>