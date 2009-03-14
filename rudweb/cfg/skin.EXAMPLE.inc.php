<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Global skin settings
 * <BR>These can be overriden in individual pages.
 * <BR>Only valid for normal pages.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      0000-00-00 00:00:00
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
 * Main layout template directory
 */
$cnt['skin']['dir'] = '';
/**
 * Main layout template file
 */
$cnt['skin']['tpl'] = 'layout';
/*
 * Main layout page title
 */
$cnt['skin']['title'] = '';
/*
 * Main layout page meta
 */
$cnt['skin']['meta'] = array();
$cnt['skin']['meta']['subject'] = _APP_NAME;
$cnt['skin']['meta']['description'] = _APP_NAME;
$cnt['skin']['meta']['keywords'] = _APP_NAME;
$cnt['skin']['meta']['copyright'] = _APP_AUTH;
$cnt['skin']['meta']['designer'] = _APP_AUTH;
$cnt['skin']['meta']['publisher'] = _APP_AUTH;
$cnt['skin']['meta']['author'] = _APP_AUTH;
?>