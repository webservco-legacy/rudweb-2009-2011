<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>English language file (module)
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-12 12:01:00
 * @access     public
 * @package    rwInt
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
 * Module title
 */
$modlang['MOD']['TITLE'] = 'Content Administration';
/**
 * Administration stuff
 */
$modlang['MOD']['ADMIN']['ADD']      = 'Add';
$modlang['MOD']['ADMIN']['EDIT']     = 'Edit';
$modlang['MOD']['ADMIN']['DELETE']   = 'Delete';
$modlang['MOD']['ADMIN']['SAVE']     = 'Save';
$modlang['MOD']['ADMIN']['CANCEL']   = 'Cancel';
$modlang['MOD']['ADMIN']['CONTINUE'] = 'Continue';
/**
 * Pages administration
 */
$modlang['MOD']['PAGE']['ADMIN']            = 'Pages Administration';
$modlang['MOD']['PAGE']['ADD_FIRST']        = 'Add First Page';
$modlang['MOD']['PAGE']['ADD']              = 'Add Page';
$modlang['MOD']['PAGE']['ADD_BEFORE']       = 'Add Page Before';
$modlang['MOD']['PAGE']['ADD_AFTER']        = 'Add Page After';
$modlang['MOD']['PAGE']['ADD_INSIDE']       = 'Add Page Inside';
$modlang['MOD']['PAGE']['VIEW']             = 'View Page';
$modlang['MOD']['PAGE']['EDIT']             = 'Edit Page';
$modlang['MOD']['PAGE']['DELETE']           = 'Delete Page';
$modlang['MOD']['PAGE']['DELETE_CONFIRM_1'] = 'Are you sure you want to delete this page?';
$modlang['MOD']['PAGE']['DELETE_CONFIRM_1'] = 'Page content will also be deleted.';
$modlang['MOD']['PAGE']['DELETE_DENIED_1']  = 'Page contains extra pages.';
$modlang['MOD']['PAGE']['DELETE_DENIED_2']  = 'Page can not be deleted.';
$modlang['MOD']['PAGE']['ORDER']            = 'Change Order';
$modlang['MOD']['PAGE']['TITLE']            = 'Title';
$modlang['MOD']['PAGE']['TEMPLATE']         = 'Template';
$modlang['MOD']['PAGE']['MENU']             = 'Menu';
$modlang['MOD']['PAGE']['ACTIVE']           = 'Active';
$modlang['MOD']['PAGE']['AUTHOR']           = 'Author';
$modlang['MOD']['PAGE']['GROUP']            = 'Group';
$modlang['MOD']['PAGE']['ITEMS']            = 'Items';
$modlang['MOD']['PAGE']['ACTIONS']          = 'Actions';
$modlang['MOD']['PAGE']['PAGE_TITLE']       = 'Page Title';
$modlang['MOD']['PAGE']['PAGE_KEYWORDS']    = 'Page Keywords';
$modlang['MOD']['PAGE']['PAGE_DESCRIPTION'] = 'Page Description';
$modlang['MOD']['PAGE']['PAGE_TEMPLATE']    = 'Page Template';
$modlang['MOD']['PAGE']['TOGGLE']           = 'Show / Hide Extra Pages';
/**
 * Content administration
 */
$modlang['MOD']['CONTENT']['ADMIN']            = 'Content Administration';
$modlang['MOD']['CONTENT']['ADD']              = 'Add Content';
$modlang['MOD']['CONTENT']['ADD_TEXT']         = 'Add Text Content';
$modlang['MOD']['CONTENT']['ADD_HTML']         = 'Add HTML Content';
$modlang['MOD']['CONTENT']['EDIT']             = 'Edit Content';
$modlang['MOD']['CONTENT']['DELETE']           = 'Delete Content';
$modlang['MOD']['CONTENT']['DELETE_CONFIRM']   = 'Are you sure you want to delete this content?';
$modlang['MOD']['CONTENT']['ORDER']            = 'Change Order';
$modlang['MOD']['CONTENT']['TYPE']             = 'Type';
$modlang['MOD']['CONTENT']['TEMPLATE']         = 'Template';
$modlang['MOD']['CONTENT']['ACTIONS']          = 'Actions';
$modlang['MOD']['CONTENT']['CONTENT_BODY']     = 'Content';
$modlang['MOD']['CONTENT']['CONTENT_TEMPLATE'] = 'Content Template';
/**
 * Image administration
 */
$modlang['MOD']['IMAGE']['ADMIN']           = 'Image Administration';
$modlang['MOD']['IMAGE']['DELETE']          = 'Delete Image';
$modlang['MOD']['IMAGE']['DELETE_CONFIRM']  = 'Are you sure you want to delete this image?';
$modlang['MOD']['IMAGE']['DELETE_DENIED_1'] = 'There are content items which use this image.';
$modlang['MOD']['IMAGE']['DELETE_DENIED_2'] = 'Image can not be deleted.';
$modlang['MOD']['IMAGE']['IMAGE_LABELS']    = 'Image Labels';
$modlang['MOD']['IMAGE']['IMAGE_LABEL']     = 'Image Label';
$modlang['MOD']['IMAGE']['IMAGE_TITLE']     = 'Image Title';
$modlang['MOD']['IMAGE']['IMAGE_FILE']      = 'Image File';
$modlang['MOD']['IMAGE']['ADD_FCK']         = 'Add to FCKeditor';
$modlang['MOD']['IMAGE']['SIZE']            = 'Size';
$modlang['MOD']['IMAGE']['TYPE']            = 'Type';
/**
 * Thumbnail administration
 */
$modlang['MOD']['THUMBNAIL']['ADMIN']        = 'Thumbnail Administration';
$modlang['MOD']['THUMBNAIL']['CREATE']       = 'Create Thumbnail';
$modlang['MOD']['THUMBNAIL']['THUMB_SIZE']   = 'Thumbnail Size';
$modlang['MOD']['THUMBNAIL']['ADD_FCK']      = 'Add to FCKeditor';
$modlang['MOD']['THUMBNAIL']['THUMB_LABELS'] = 'Thumbnail Labels';
/**
 * Languages
 */
$modlang['MOD']['LANG']['LANG']  = 'Current content language';
$modlang['MOD']['LANG']['LANGS'] = 'Available content languages';
?>