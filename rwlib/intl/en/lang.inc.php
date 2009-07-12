<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>English language file (core)
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2008-12-12 14:27:00
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
 * Initialize
 */
$lang = array();

/**
 * User status
 */
$lang['USR_STATUS'][1]  = 'Not logged in';
$lang['USR_STATUS'][2]  = 'Empty fields';
$lang['USR_STATUS'][3]  = 'Incorrect data';
$lang['USR_STATUS'][4]  = 'Suspended account';
$lang['USR_STATUS'][5]  = 'Authentication ok';
$lang['USR_STATUS'][6]  = 'Logged in';
$lang['USR_STATUS'][7]  = 'Incorrect verification code';
$lang['USR_STATUS'][8]  = 'Multiple submits';
$lang['USR_STATUS'][9]  = 'Hacker attack';
/**
 * 404 messages
 */
$lang['e404']['TITLE']   = 'Resource not found';
$lang['e404']['MESSAGE'] = 'Sorry, the resource you requested was not found on this server.';
/**
 * Authorization
 */
$lang['AUTH']['STATUS']     = 'Status';
$lang['AUTH']['USER_NAME']  = 'User Name';
$lang['AUTH']['PASSWORD']   = 'Password';
$lang['AUTH']['CAPTCHA']    = 'Security Code';
$lang['AUTH']['LOGIN_TT']   = 'Login';
$lang['AUTH']['LOGOUT']     = 'Logout';
$lang['AUTH']['LOGIN_MSG']  = 'Please login to access this resource.';
$lang['AUTH']['DENIED_TT']  = 'Access denied..';
$lang['AUTH']['DENIED_MSG'] = 'Sorry, you do not have permission to access this resource.';
$lang['AUTH']['ALEVEL']     = 'Access level';
$lang['AUTH']['GROUP']      = 'Group';
/**
 * Form validation
 */
$lang['FORM']['FIELD']      = 'Field "';
$lang['FORM']['IS_EMPTY']   = '" is empty.';
$lang['FORM']['IS_INVALID'] = '" is invalid.';

$lang['FORM']['FILE_ERR']   = 'Upload error at "';
$lang['FORM']['FILE_EMPTY'] = '". No file uploaded.';
$lang['FORM']['FILE_8']     = '". File upload stopped by extension.';
$lang['FORM']['FILE_7']     = '". Failed to write file to disk.';
$lang['FORM']['FILE_6']     = '". Missing a temporary folder.';
$lang['FORM']['FILE_4']     = '". No file uploaded.';
$lang['FORM']['FILE_3']     = '". Partial upload.';
$lang['FORM']['FILE_2']     = '". File exceeds maximum allowed size.';
$lang['FORM']['FILE_1']     = '". File exceeds maximum allowed size.';
$lang['FORM']['FILE_TYPE']  = '". File type is not allowed.';
$lang['FORM']['FILE_FORM']  = '". File was not sent by form.';
$lang['FORM']['FILE_SAVE']  = '". Error saving file.';

$lang['FORM']['ADD_OK']     = 'Add action was successfull!';
$lang['FORM']['EDIT_OK']    = 'Edit action was successfull!';
$lang['FORM']['REMOVE_OK']  = 'Remove action was successfull!';
?>