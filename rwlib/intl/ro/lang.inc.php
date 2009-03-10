<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Romanian language file (core)
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-01-12 16:27:00
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
$lang['USR_STATUS'][1]  = 'Neautentificat';
$lang['USR_STATUS'][2]  = 'C&#226;mpuri necompletate';
$lang['USR_STATUS'][3]  = 'Date incorecte';
$lang['USR_STATUS'][4]  = 'Cont suspendat';
$lang['USR_STATUS'][5]  = 'Autentificare reu&#351;it&#259;';
$lang['USR_STATUS'][6]  = 'Autentificat';
$lang['USR_STATUS'][7]  = 'Cod de verificare incorect';
$lang['USR_STATUS'][8]  = 'Submit-uri multiple';
$lang['USR_STATUS'][9]  = 'Atack hacker';
/**
 * 404 messages
 */
$lang['e404']['TITLE']   = 'Resursa nu a fost g&#259;sit&#259;';
$lang['e404']['MESSAGE'] = 'Ne pare r&#259;u, resursa solicitat&#259; nu a fost g&#259;sit&#259; pe acest server.';
/**
 * Authorization
 */
$lang['AUTH']['USER_NAME']  = 'Nume Utilizator';
$lang['AUTH']['PASSWORD']   = 'Parola';
$lang['AUTH']['CAPTCHA']    = 'Cod de securitate';
$lang['AUTH']['LOGIN_TT']   = 'Autentificare';
$lang['AUTH']['LOGOUT']     = '&#206;nchidere sesiune';
$lang['AUTH']['LOGIN_MSG']  = 'Pentru a putea accesa aceast&#259; resurs&#259;, v&#259; rug&#259;m s&#259; v&#259; autentifica&#355;i.';
$lang['AUTH']['DENIED_TT']  = 'Accesul interzis.';
$lang['AUTH']['DENIED_MSG'] = 'Ne pare r&#259;u, nu ave&#355;i permisiunea de a accesa aceast&#259; resurs&#259;.';
/**
 * Form validation
 */
$lang['FORM']['FIELD']      = 'C&#226;mpul "';
$lang['FORM']['IS_EMPTY']   = '" este gol.';
$lang['FORM']['IS_INVALID'] = '" este invalid.';

$lang['FORM']['FILE_ERR']   = 'Eroare de upload la "';
$lang['FORM']['FILE_EMPTY'] = '". Nici un fi&#351;ier trimis.';
$lang['FORM']['FILE_8']     = '". File upload stopped by extension.';
$lang['FORM']['FILE_7']     = '". Failed to write file to disk.';
$lang['FORM']['FILE_6']     = '". Missing a temporary folder.';
$lang['FORM']['FILE_4']     = '". Nici un fi&#351;ier trimis.';
$lang['FORM']['FILE_3']     = '". Upload par&#355;ial.';
$lang['FORM']['FILE_2']     = '". Fi&#351;ierul dep&#259;&#351;e&#351;te dimensiunea maxim&#259; admis&#259;.';
$lang['FORM']['FILE_1']     = '". Fi&#351;ierul dep&#259;&#351;e&#351;te dimensiunea maxim&#259; admis&#259;.';
$lang['FORM']['FILE_TYPE']  = '". Tipul fi&#351;ierului nu este permis.';
$lang['FORM']['FILE_FORM']  = '". Fi&#351;ierul nu a fost trimis prin formular.';
$lang['FORM']['FILE_SAVE']  = '". Eroare la salvarea fi&#351;ierului.';

$lang['FORM']['ADD_OK']     = 'Ac&#355;iunea de ad&#259;ugare a fost realizat&#259; cu succes!';
$lang['FORM']['EDIT_OK']    = 'Ac&#355;iunea de editare a fost realizat&#259; cu succes!';
$lang['FORM']['REMOVE_OK']  = 'Ac&#355;iunea de &#351;tergere a fost realizat&#259; cu succes!';
?>