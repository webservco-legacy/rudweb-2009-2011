<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>No description
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @access     public
 * @package    RudWEb-1.0
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
 *
./inc/langs/it/usrmail.inc.php
15:02 2008-06-27
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

$rudweb_ln['usr']['actmailsubj']   = "Account Activation at";

$rudweb_ln['usr']['actmailtxt1a']  = "<DIV>";
$rudweb_ln['usr']['actmailtxt1a'] .= "Dear <B>";
$rudweb_ln['usr']['actmailtxt1b']  = "</B>";
$rudweb_ln['usr']['actmailtxt1b'] .= "<BR><BR>In order to complete your account activation, please click on the following link (available 1 day):";
$rudweb_ln['usr']['actmailtxt1b'] .= "<BR><BR>";

$rudweb_ln['usr']['actmailtxt2']   = "<BR><BR>If you are having trouble with the link, please copy and paste the following url into your browser:";
$rudweb_ln['usr']['actmailtxt2']  .= "<BR><BR>";

$rudweb_ln['usr']['actmailtxt3']   = "<BR><BR>Sincerely,";
$rudweb_ln['usr']['actmailtxt3']  .= "<BR>The " . _RUDWEB_WSTT . " Team";
$rudweb_ln['usr']['actmailtxt3']  .= "</DIV>";


$rudweb_ln['usr']['authmessage']   = "<BR>Thank you for taking the time to register an account with " . _RUDWEB_WSTT . "!";
$rudweb_ln['usr']['authmessage']  .= "<BR><BR>In order to start using your account you must first activate it.";
$rudweb_ln['usr']['authmessage']  .= "<BR><BR>An email has been sent to the address you specified, containing activation instructions.";
$rudweb_ln['usr']['authmessage']  .= "<BR><BR>Please check your email and follow the instructions in order to activate and start using your account.";

$rudweb_ln['usr']['autherror']     = "<BR>Thank you for taking the time to register an account with " . _RUDWEB_WSTT . "!";
$rudweb_ln['usr']['autherror']    .= "<BR><BR>In order to start using your account you must first activate it.";
$rudweb_ln['usr']['autherror']    .= "<BR><BR>Unfortunately we weren't able to sent your activation email.";
$rudweb_ln['usr']['autherror']    .= "<BR><BR>Please contact the website administrator about this problem.";

$rudweb_ln['usr']['authoka']       = "<BR>Thank you!";
$rudweb_ln['usr']['authoka']      .= "<BR><BR>Account for ";
$rudweb_ln['usr']['authokb']       = " was succesfully activated!";
$rudweb_ln['usr']['authokb']      .= "<BR><BR>You can now login using your email address and the password you have chosen!";

$rudweb_ln['usr']['lostpass1']     = "<BR>Here at " . _RUDWEB_WSTT . " we respect your privacy, and therefore we do not know your password.";
$rudweb_ln['usr']['lostpass1']    .= "<BR><BR>So, if you can not remember your password, it is lost forever.";
$rudweb_ln['usr']['lostpass1']    .= "<BR><BR>In that case, the only solution is for you to reset your password and choose a new one.";
$rudweb_ln['usr']['lostpass1']    .= "<BR><BR>Please enter the email address used to register your account at " . _RUDWEB_WSTT . ":";

$rudweb_ln['usr']['lostapsserr']   = "Sorry, no match in our data base.";

$rudweb_ln['usr']['lpmailsubj']    = 'Password recovery at';

$rudweb_ln['usr']['lpmailtxt1a']   = "<DIV>";
$rudweb_ln['usr']['lpmailtxt1a']  .= "Dear <B>";
$rudweb_ln['usr']['lpmailtxt1b']   = "</B>";
$rudweb_ln['usr']['lpmailtxt1b']  .= "<BR><BR>In order to reset your password, please click on the following link (available 1 day):";
$rudweb_ln['usr']['lpmailtxt1b']  .= "<BR><BR>";

$rudweb_ln['usr']['lpmailtxt2']    = "<BR><BR>If you are having trouble with the link, please copy and paste the following url into your browser:";
$rudweb_ln['usr']['lpmailtxt2']   .= "<BR><BR>";

$rudweb_ln['usr']['lpmailtxt3']    = "<BR><BR>Sincerely,";
$rudweb_ln['usr']['lpmailtxt3']   .= "<BR>The " . _RUDWEB_WSTT . " Team";
$rudweb_ln['usr']['lpmailtxt3']   .= "</DIV>";

$rudweb_ln['usr']['lostpmessage']  = "<BR><BR>An email has been sent to the address you specified, containing password reset instructions.";
$rudweb_ln['usr']['lostpmessage'] .= "<BR><BR>Please check your email and follow the instructions in order to reset your password at " . _RUDWEB_WSTT . ".";

$rudweb_ln['usr']['lostperror']    = "<BR><BR>Unfortunately we weren't able to sent your password reset email.";
$rudweb_ln['usr']['lostperror']   .= "<BR><BR>Please contact the website administrator about this problem.";

$rudweb_ln['usr']['lostpass2']     = "<BR><BR>Please chose a new password:";

$rudweb_ln['usr']['lostpassoka']   = "<BR>Thank you!";
$rudweb_ln['usr']['lostpassoka']  .= "<BR><BR>Your password was ";
$rudweb_ln['usr']['lostpassokb']   = " succesfully changed!";
$rudweb_ln['usr']['lostpassokb']  .= "<BR><BR>You can now login using your email address and the password you have chosen!";

$rudweb_ln['conm']['notify_subject'] = 'New contact message on ' . _RUDWEB_WSTT;
$rudweb_ln['conm']['notify_txt1']    = 'You have a new contact message on the Website <B>' . _RUDWEB_WSTT . '</B>';
$rudweb_ln['conm']['notify_txt2']    = '<BR><BR>Date: ';
$rudweb_ln['conm']['notify_txt3']    = '<BR><BR>In order to view the message please authenticate yourself at:';
$rudweb_ln['conm']['notify_txt4']    = '<BR>' . _RUDWEB_SITE_URL . 'admin';

$rudweb_ln['conm']['send_subject'] = 'New contact message on ' . _RUDWEB_WSTT;
$rudweb_ln['conm']['send_txt1']    = 'You have a new contact message on the Website <B>' . _RUDWEB_WSTT . '</B>';
$rudweb_ln['conm']['send_txt2']    = '<BR><BR>Date: ';
$rudweb_ln['conm']['send_txt3']    = '<BR><BR>Content:';
$rudweb_ln['conm']['send_txt4']    = '<BR>';

$rudweb_ln['conm']['ok_mesage']    = '<BR>Your message has been recorded!<BR>Thank You!';
?>