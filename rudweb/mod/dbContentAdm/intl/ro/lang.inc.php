<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Romanian language file (module)
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-12 12:02:00
 * @access     public
 * @package    RudWEb
 * @subpackage Internationalization
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
 * Module title
 */
$modlang['MOD']['TITLE'] = 'Administrare Con&#355;inut';
/**
 * Administration stuff
 */
$modlang['MOD']['ADMIN']['ADD']      = 'Adaug&#259;';
$modlang['MOD']['ADMIN']['EDIT']     = 'Editeaz&#259;';
$modlang['MOD']['ADMIN']['DELETE']   = '&#350;terge';
$modlang['MOD']['ADMIN']['SAVE']     = 'Salveaz&#259;';
$modlang['MOD']['ADMIN']['CANCEL']   = 'Renun&#355;&#259;';
$modlang['MOD']['ADMIN']['CONTINUE'] = 'Continuare';
/**
 * Pages administration
 */
$modlang['MOD']['PAGE']['ADMIN']            = 'Administrare Pagini';
$modlang['MOD']['PAGE']['ADD_FIRST']        = 'Adaug&#259; Prima Pagin&#259;';
$modlang['MOD']['PAGE']['ADD']              = 'Adaug&#259; Pagin&#259;';
$modlang['MOD']['PAGE']['ADD_BEFORE']       = 'Adaug&#259; Pagin&#259; &#206;nainte';
$modlang['MOD']['PAGE']['ADD_AFTER']        = 'Adaug&#259; Pagin&#259; Dup&#259;';
$modlang['MOD']['PAGE']['ADD_INSIDE']       = 'Adaug&#259; Pagin&#259; &#206;n&#259;untru';
$modlang['MOD']['PAGE']['VIEW']             = 'Vizualizare Pagin&#259;';
$modlang['MOD']['PAGE']['EDIT']             = 'Editare Pagin&#259;';
$modlang['MOD']['PAGE']['DELETE']           = '&#350;tergere Pagin&#259;';
$modlang['MOD']['PAGE']['DELETE_CONFIRM_1'] = 'Sigur &#351;terge&#355;i aceast&#259; pagin&#259;?';
$modlang['MOD']['PAGE']['DELETE_CONFIRM_2'] = 'Con&#355;inutul paginii va fi de asemenea &#351;ters.';
$modlang['MOD']['PAGE']['DELETE_DENIED_1']  = 'Pagina con&#355;ine pagini suplimentare.';
$modlang['MOD']['PAGE']['DELETE_DENIED_2']  = 'Pagina nu poate fi &#351;tears&#259;.';
$modlang['MOD']['PAGE']['ORDER']            = 'Schimb&#259; Ordinea';
$modlang['MOD']['PAGE']['TITLE']            = 'Titlu';
$modlang['MOD']['PAGE']['TEMPLATE']         = 'Template';
$modlang['MOD']['PAGE']['MENU']             = 'Meniu';
$modlang['MOD']['PAGE']['ACTIVE']           = 'Activ';
$modlang['MOD']['PAGE']['AUTHOR']           = 'Autor';
$modlang['MOD']['PAGE']['GROUP']            = 'Grup';
$modlang['MOD']['PAGE']['ITEMS']            = 'Articole';
$modlang['MOD']['PAGE']['ACTIONS']          = 'Ac&#355;iuni';
$modlang['MOD']['PAGE']['PAGE_TITLE']       = 'Titlu Pagin&#259;';
$modlang['MOD']['PAGE']['PAGE_KEYWORDS']    = 'Cuvinte Cheie Pagin&#259;';
$modlang['MOD']['PAGE']['PAGE_DESCRIPTION'] = 'Descriere Pagin&#259;';
$modlang['MOD']['PAGE']['PAGE_TEMPLATE']    = 'Template Pagin&#259;';
$modlang['MOD']['PAGE']['TOGGLE']           = 'Afi&#351;eaz&#259; / Ascunde Pagini Suplimentare';
/**
 * Content administration
 */
$modlang['MOD']['CONTENT']['ADMIN']            = 'Administrare Con&#355;inut';
$modlang['MOD']['CONTENT']['ADD']              = 'Adaug&#259; Con&#355;inut';
$modlang['MOD']['CONTENT']['ADD_TEXT']         = 'Adaug&#259; Con&#355;inut Text';
$modlang['MOD']['CONTENT']['ADD_HTML']         = 'Adaug&#259; Con&#355;inut HTML';
$modlang['MOD']['CONTENT']['EDIT']             = 'Editare Con&#355;inut';
$modlang['MOD']['CONTENT']['DELETE']           = '&#350;terge Con&#355;inut';
$modlang['MOD']['CONTENT']['DELETE_CONFIRM']   = 'Sigur &#351;terge&#355;i acest con&#355;inut?';
$modlang['MOD']['CONTENT']['ORDER']            = 'Schimb&#259; Ordinea';
$modlang['MOD']['CONTENT']['TYPE']             = 'Tip';
$modlang['MOD']['CONTENT']['TEMPLATE']         = 'Template';
$modlang['MOD']['CONTENT']['ACTIONS']          = 'Ac&#355;iuni';
$modlang['MOD']['CONTENT']['CONTENT_BODY']     = 'Con&#355;inut';
$modlang['MOD']['CONTENT']['CONTENT_TEMPLATE'] = 'Template Con&#355;inut';
/**
 * Image administration
 */
$modlang['MOD']['IMAGE']['ADMIN']           = 'Administrare Imagini';
$modlang['MOD']['IMAGE']['DELETE']          = '&#350;tergere Imagine';
$modlang['MOD']['IMAGE']['DELETE_CONFIRM']  = 'Sigur &#351;terge&#355;i aceast&#259; imagine?';
$modlang['MOD']['IMAGE']['DELETE_DENIED_1'] = 'Exist&#259; articole de con&#355;inut ce folosesc aceast&#259; imagine.';
$modlang['MOD']['IMAGE']['DELETE_DENIED_2'] = 'Imaginea nu poate fi &#351;tears&#259;.';
$modlang['MOD']['IMAGE']['IMAGE_LABELS']    = 'Etichete Imagine';
$modlang['MOD']['IMAGE']['IMAGE_LABEL']     = 'Etichet&#259; Imagine';
$modlang['MOD']['IMAGE']['IMAGE_TITLE']     = 'Titlu Imagine';
$modlang['MOD']['IMAGE']['IMAGE_FILE']      = 'Fi&#351;ier Imagine';
$modlang['MOD']['IMAGE']['ADD_FCK']         = 'Adaug&#259; la FCKeditor';
$modlang['MOD']['IMAGE']['SIZE']            = 'M&#259;rime';
$modlang['MOD']['IMAGE']['TYPE']            = 'Tip';
/**
 * Thumbnail administration
 */
$modlang['MOD']['THUMBNAIL']['ADMIN']        = 'Administrare Thumbnail';
$modlang['MOD']['THUMBNAIL']['CREATE']       = 'Creare Thumbnail';
$modlang['MOD']['THUMBNAIL']['THUMB_SIZE']   = 'M&#259;rime thumbnail';
$modlang['MOD']['THUMBNAIL']['ADD_FCK']      = 'Adaug&#259; la FCKeditor';
$modlang['MOD']['THUMBNAIL']['THUMB_LABELS'] = 'Etichete Thumbnail';
/**
 * Languages
 */
$modlang['MOD']['LANG']['LANG']  = 'Limba curent&#259; con&#355;inut';
$modlang['MOD']['LANG']['LANGS'] = 'Limbi disponibile con&#355;inut';
?>