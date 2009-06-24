<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Cotroller for content.
 * <BR>Displays 404 message.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-01 00:00:00
 * @access     public
 * @package    RudWEb
 * @subpackage App
 * @todo       stuff
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
 */

/**
 * Prevent direct file access
 */
if(!defined('_RW_VALID')) {require_once('./index.php'); exit;}

/**
 * These must be declared
 */
$out['skin'] = array();
$out['cnt'] = array();

// START CONTENT TYPE AND SKIN DATA
// Content type and skin data are set in the main configuration file.
// You can override them here or on individual pages
/**
 * Content type
 */
//$out['type'] = 'text';
/**
 * Main layout template directory
 */
//$out['skin']['dir'] = '';
/**
 * Main layout template file
 */
//$out['skin']['tpl'] = 'layout';
/*
 * Main layout page title
 */
$out['skin']['title'] = (_APP_CFG_SESSIONS && $_SESSION[_APP_PRE.'_usr_lvl'] >= 2) ? $this->langAdm['e404']['TITLE'] : $this->lang['e404']['TITLE'];
/*
 * Main layout page meta
 */
//$out['skin']['meta'] = array();
//$out['skin']['meta']['subject'] = _APP_NAME;
//$out['skin']['meta']['description'] = _APP_NAME;
//$out['skin']['meta']['keywords'] = _APP_NAME.', '.$out['skin']['title'];
//$out['skin']['meta']['copyright'] = _APP_AUTH;
//$out['skin']['meta']['designer'] = _APP_AUTH;
//$out['skin']['meta']['publisher'] = _APP_AUTH;
//$out['skin']['meta']['author'] = _APP_AUTH;
// END CONTENT TYPE AND SKIN DATA

/**
 * Current content template file
 */
$out['cnt']['dir'] = 'content';
/**
 * Current content template file
 */
$out['cnt']['tpl'] = '404';
/**
 * Current content
 */
$out['cnt']['content'] = array();
/*
 * This overrides the aditional templates in the main skin.
 * Use it in order not to display something on a certain page.
 * Please note that these will not act as sub-templates anymore,
 * but as variables to the main template.
 */
/*
 $out['skin']['header'] = 'HEADER_REPLACEMENT_VARS';
 $out['skin']['content'] = 'CONTENT_REPLACEMENT_VARS';
 $out['skin']['footer'] = 'FOOTER_REPLACEMENT_VARS';
 */
/*
 * If you want to override the aditional templates in the main skin
 * and still use them as subtemplates, use something like this:
 * (same sintax as in ctrl.inc)
 */
/*
 $out['atpl']['header'] = array();
 $out['atpl']['header']['dir'] = '';
 $out['atpl']['header']['tpl'] = 'header';
 $out['atpl']['header']['vars'] = array();

 $out['atpl']['content'] = array();

 $out['atpl']['content'][0] = array();
 $out['atpl']['content'][0]['dir'] = $out['cnt'][0]['dir'];
 $out['atpl']['content'][0]['tpl'] = $out['cnt'][0]['tpl'];
 $out['atpl']['content'][0]['vars']['cnt'] = $out['cnt'][0]['content'];
 $out['atpl']['content'][0]['vars']['lang'] = $appCore->rwLang();
 $out['atpl']['content'][0]['vars']['langAdm'] = $appCore->rwLangAdm();
 $out['atpl']['content'][0]['vars']['usr_status'] = $appCore->rwUsrStatus();

 $out['atpl']['content'][1] = array();
 $out['atpl']['content'][1]['dir'] = $out['cnt'][1]['dir'];
 $out['atpl']['content'][1]['tpl'] = $out['cnt'][1]['tpl'];
 $out['atpl']['content'][1]['vars']['cnt'] = $out['cnt'][1]['content'];
 $out['atpl']['content'][1]['vars']['lang'] = $appCore->rwLang();
 $out['atpl']['content'][1]['vars']['langAdm'] = $appCore->rwLangAdm();
 $out['atpl']['content'][1]['vars']['usr_status'] = $appCore->rwUsrStatus();
 $out['atpl']['content'][1]['vars']['stuff1'] = 'stuff for the second subtemplate';

 $out['atpl']['footer'] = array();
 $out['atpl']['footer']['dir'] = '';
 $out['atpl']['footer']['tpl'] = 'footer';
 $out['atpl']['footer']['vars'] = array();
 */
?>