<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Module internationalization file (romanian)
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-11-04 18:08:00
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

$langMod['LOGIN_ERR']['default'] = 'Eroare.';
$langMod['LOGIN_ERR']['_rwRequired'] = 'C&#226;mpul $label$ este obligatoriu.';
$langMod['LOGIN_ERR']['_rwValidEmail'] = '$label$ nu este o adresa de email valid&#256;.';
$langMod['LOGIN_ERR']['_rwMin'] = '$label$ trebuie s&259; aib&#259; cel pu&#355;in $required$ caractere.';
$langMod['LOGIN_ERR']['_rwMax'] = '$label$ trebuie s&259; aib&#259; cel mult $required$ caractere.';
$langMod['LOGIN_ERR']['_rwEquals'] = '$label$ trebuie s&#259; fie egal cu $required$.';
$langMod['LOGIN_ERR']['_rwValidCaptcha'] = '$label$ nu este valid.';
?>