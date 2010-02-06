<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Engine internationalization file (english)
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-22 16:50:00
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
 * Security check.
 */
if (!defined('_RW_VALID'))
{
	/**
	 * Display "Not Found" page.
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution.
	 */
	exit;
}

$langCore['ERROR']['CODESTR']['E_UNKNOWN']           = 'Unknown error code.';
$langCore['ERROR']['CODESTR']['E_ERROR']             = 'Fatal run-time error.';
$langCore['ERROR']['CODESTR']['E_WARNING']           = 'Run-time warning.';
$langCore['ERROR']['CODESTR']['E_PARSE']             = 'Compile-time parse error.';
$langCore['ERROR']['CODESTR']['E_NOTICE']            = 'Run-time notice.';
$langCore['ERROR']['CODESTR']['E_CORE_ERROR']        = 'Fatal error that occured during PHP\'s initial startup.';
$langCore['ERROR']['CODESTR']['E_CORE_WARNING']      = 'Warning that occured during PHP\'s initial startup.';
$langCore['ERROR']['CODESTR']['E_COMPILE_ERROR']     = 'Fatal compile-time error.';
$langCore['ERROR']['CODESTR']['E_COMPILE_WARNING']   = 'Compile-time warning.';
$langCore['ERROR']['CODESTR']['E_USER_ERROR']        = 'Engine-generated error message.';
$langCore['ERROR']['CODESTR']['E_USER_WARNING']      = 'Engine-generated warning message.';
$langCore['ERROR']['CODESTR']['E_USER_NOTICE']       = 'Engine-generated notice message.';
$langCore['ERROR']['CODESTR']['E_STRICT']            = 'Run-time notice.';
$langCore['ERROR']['CODESTR']['E_RECOVERABLE_ERROR'] = 'Catchable fatal error.';
$langCore['ERROR']['CODESTR']['E_DEPRECATED']        = 'Deprecated code.';
$langCore['ERROR']['CODESTR']['E_USER_DEPRECATED']   = 'Engine generated deprecated code message.';
$langCore['ERROR']['CODESTR']['E_ALL']               = 'All errors and warnings.';

$langCore['ERROR']['Database']['TYPE_NOT_SUPPORTED'] = 'Database type <b>%0%</b> not supported.';
$langCore['ERROR']['Database']['COULD_NOT_CONNECT']  = 'Could not connect to Database Server. Please check your connection settings.';
$langCore['ERROR']['Database']['COULD_NOT_OPEN']     = 'Could not open database <b>%0%</b>. Please check that the specified database exists and that you have enough privileges to access it.';
$langCore['ERROR']['Database']['DEBUG']              = 'Debug. Query: <b>%0%</b>';
$langCore['ERROR']['Database']['QUERY']              = 'Query Error: <b>%0%</b> <b>%1%</b>';

$langCore['ERROR']['Engine']['NO_LIB_1']             = 'Requested library <b>%0%</b> does not exist.';
$langCore['ERROR']['Engine']['NO_LIB_2']             = 'Requested library <b>%0%</b> does not exist or is not loadable.';
$langCore['ERROR']['Engine']['NO_EXT']               = 'Extension <b>%0%</b> not found.';
$langCore['ERROR']['Engine']['LIB_OUTPUT_DISPLAY']   = 'Can not display output. <b>Output</b> library not loaded.';
$langCore['ERROR']['Engine']['LIB_OUTPUT_PARSE']     = 'Can not parse output. <b>Output</b> library not loaded.';

$langCore['ERROR']['Extension']['NO_LIB_DEP']        = 'Extension <b>%0%</b> can not be loaded. Missing library dependencies (<b>%1%</b>).';
$langCore['ERROR']['Extension']['NO_EXT_DEP']        = 'Extension <b>%0%</b> can not be loaded. Missing extension dependencies (<b>%1%</b>).';
$langCore['ERROR']['Extension']['SET_PROPERTY']      = 'Tried to set a property that does not exist or is not accessible.';
$langCore['ERROR']['Extension']['MAIL_INFO']         = 'Could not send email. Not enough info.';

$langCore['ERROR']['Module']['NO_FILE']              = 'Module <b>%0%</b> can not be loaded. File not found.';
$langCore['ERROR']['Module']['NO_LIB_DEP']           = 'Module <b>%0%</b> can not be loaded. Missing library dependencies (<b>%1%</b>).';
$langCore['ERROR']['Module']['NO_EXT_DEP']           = 'Module <b>%0%</b> can not be loaded. Missing extension dependencies (<b>%1%</b>).';
$langCore['ERROR']['Module']['NO_MOD_DEP']           = 'Module <b>%0%</b> can not be loaded. Missing module dependencies (<b>%1%</b>).';
$langCore['ERROR']['Module']['NO_ACT']               = 'Specified action is not valid.';
$langCore['ERROR']['Module']['NO_ACT_FOUND']         = 'Specified action was not found.';

$langCore['ERROR']['Output']['NO_ENGINE']            = 'Can not load specified output engine. File not found.';
$langCore['ERROR']['Output']['NO_TEMPLATE']          = 'Template file not found.';
$langCore['ERROR']['Output']['NO_SMARTY']            = 'Library for output engine <b>Smarty</b> not found.';
?>