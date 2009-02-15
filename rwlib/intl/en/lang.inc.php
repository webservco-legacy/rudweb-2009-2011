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
?>