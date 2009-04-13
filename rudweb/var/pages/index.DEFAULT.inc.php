<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Controller for content
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-19 09:33:00
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
$cnt['skin'] = array();
$cnt['cnt'] = array();

// START CONTENT TYPE AND SKIN DATA
// Content type and skin data are set in the main configuration file.
// You can override them here or on individual pages
/**
 * Content type
 */
//$cnt['type'] = 'text';
/**
 * Main layout template directory
 */
//$cnt['skin']['dir'] = '';
/**
 * Main layout template file
 */
//$cnt['skin']['tpl'] = 'layout';
/*
 * Main layout page title
 */
//$cnt['skin']['title'] = '';
/*
 * Main layout page meta
 */
//$cnt['skin']['meta'] = array();
//$cnt['skin']['meta']['subject'] = _APP_NAME;
//$cnt['skin']['meta']['description'] = _APP_NAME;
//$cnt['skin']['meta']['keywords'] = _APP_NAME;
//$cnt['skin']['meta']['copyright'] = _APP_AUTH;
//$cnt['skin']['meta']['designer'] = _APP_AUTH;
//$cnt['skin']['meta']['publisher'] = _APP_AUTH;
//$cnt['skin']['meta']['author'] = _APP_AUTH;
// END CONTENT TYPE AND SKIN DATA

/**
 * Current content template file
 */
$cnt['cnt']['dir'] = 'content';
/**
 * Current content template file
 */
$cnt['cnt']['tpl'] = 'blank';
/**
 * Current content
 */
$cnt['cnt']['content'] = array();
/*
 * This overrides the aditional templates in the main skin.
 * Use it in order not to display something on a certain page.
 * Please note that these will not act as sub-templates anymore,
 * but as variables to the main template.
 */
/*
 $cnt['skin']['menu'] = 'MENU_REPLACEMENT_VARS';
 $cnt['skin']['content'] = 'CONTENT_REPLACEMENT_VARS';
 $cnt['skin']['footer'] = 'FOOTER_REPLACEMENT_VARS';
 */
/*
 * If you want to override the aditional templates in the main skin
 * and still use them as subtemplates, use something like this:
 * (same sintax as in ctrl.inc)
 */
/*
 $cnt['atpl']['menu'] = array();
 $cnt['atpl']['menu']['dir'] = '';
 $cnt['atpl']['menu']['tpl'] = 'menu';
 $cnt['atpl']['menu']['vars'] = array();

 $cnt['atpl']['content'] = array();

 $cnt['atpl']['content'][0] = array();
 $cnt['atpl']['content'][0]['dir'] = $cnt['cnt'][0]['dir'];
 $cnt['atpl']['content'][0]['tpl'] = $cnt['cnt'][0]['tpl'];
 $cnt['atpl']['content'][0]['vars']['cnt'] = $cnt['cnt'][0]['content'];
 $cnt['atpl']['content'][0]['vars']['lang'] = $appCore->rwLang();
 $cnt['atpl']['content'][0]['vars']['langAdm'] = $appCore->rwLangAdm();
 $cnt['atpl']['content'][0]['vars']['usr_status'] = $appCore->rwUsrStatus();

 $cnt['atpl']['content'][1] = array();
 $cnt['atpl']['content'][1]['dir'] = $cnt['cnt'][1]['dir'];
 $cnt['atpl']['content'][1]['tpl'] = $cnt['cnt'][1]['tpl'];
 $cnt['atpl']['content'][1]['vars']['cnt'] = $cnt['cnt'][1]['content'];
 $cnt['atpl']['content'][1]['vars']['lang'] = $appCore->rwLang();
 $cnt['atpl']['content'][1]['vars']['langAdm'] = $appCore->rwLangAdm();
 $cnt['atpl']['content'][1]['vars']['usr_status'] = $appCore->rwUsrStatus();
 $cnt['atpl']['content'][1]['vars']['stuff1'] = 'stuff for the second subtemplate';

 $cnt['atpl']['footer'] = array();
 $cnt['atpl']['footer']['dir'] = '';
 $cnt['atpl']['footer']['tpl'] = 'footer';
 $cnt['atpl']['footer']['vars'] = array();
 */
?>