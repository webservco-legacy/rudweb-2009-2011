<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Module internationalization file (english)
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-11-04 18:06:00
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

$langMod['LOGIN_ERR']['default'] = 'Error.';
$langMod['LOGIN_ERR']['rwRequired'] = '$label$ is required.';
$langMod['LOGIN_ERR']['rwValidEmail'] = '$label$ is not a valid email address.';
$langMod['LOGIN_ERR']['rwMin'] = '$label$ must be at least $required$ characters long.';
$langMod['LOGIN_ERR']['rwMax'] = '$label$ must not be longer than $required$ characters.';
$langMod['LOGIN_ERR']['rwEquals'] = '$label$ must be equal with $required$.';
$langMod['LOGIN_ERR']['rwValidCaptcha'] = '$label$ is not valid.';

$langMod['HEADER']['TITLE'] = 'RudiSoft Web Interface.';
?>