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
./inc/langs/en/usrmail.inc.php
15:14 2008-06-26
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

$rudweb_ln['usr']['actmailsubj']   = "Activare cont la";

$rudweb_ln['usr']['actmailtxt1a']  = "<DIV>";
$rudweb_ln['usr']['actmailtxt1a'] .= "Drag&#259; <B>";
$rudweb_ln['usr']['actmailtxt1b']  = "</B>";
$rudweb_ln['usr']['actmailtxt1b'] .= "<BR><BR>Pentru a incheia activarea contului, click pe urmatorul link (valabil o zi):";
$rudweb_ln['usr']['actmailtxt1b'] .= "<BR><BR>";

$rudweb_ln['usr']['actmailtxt2']   = "<BR><BR>Daca aveti probleme cu afisarea link-ului, va rugam copiati urmatoarea adresa in browserul dvs:";
$rudweb_ln['usr']['actmailtxt2']  .= "<BR><BR>";

$rudweb_ln['usr']['actmailtxt3']   = "<BR><BR>Cu stima,";
$rudweb_ln['usr']['actmailtxt3']  .= "<BR>Echipa " . _RUDWEB_WSTT . " ";
$rudweb_ln['usr']['actmailtxt3']  .= "</DIV>";


$rudweb_ln['usr']['authmessage']   = "<BR>Va multumim pentru ca ati ales sa creati un cont la " . _RUDWEB_WSTT . "!";
$rudweb_ln['usr']['authmessage']  .= "<BR><BR>Pentru a putea folosi contul trebuie mai intai sa il activati.";
$rudweb_ln['usr']['authmessage']  .= "<BR><BR>Un email a fost trimis la adresa specificata, continand instructiuni pentru activarea contului.";
$rudweb_ln['usr']['authmessage']  .= "<BR><BR>Va rugam sa va verificati email-ul si sa urmati incstructiunile incluse in mesaj.";

$rudweb_ln['usr']['autherror']     = "<BR>Va multumim pentru ca ati ales sa creati un cont la " . _RUDWEB_WSTT . "!";
$rudweb_ln['usr']['autherror']    .= "<BR><BR>Pentru a putea folosi contul trebuie mai intai sa il activati.";
$rudweb_ln['usr']['autherror']    .= "<BR><BR>Din pacate nu am putut trimite email-ul de activare.";
$rudweb_ln['usr']['autherror']    .= "<BR><BR>Va rugam contactati administratorul site-ului in legatura cu aceasta problema.";

$rudweb_ln['usr']['authoka']       = "<BR>Va multumim!";
$rudweb_ln['usr']['authoka']      .= "<BR><BR>Contul pentru ";
$rudweb_ln['usr']['authokb']       = " a fost activat cu succes!";
$rudweb_ln['usr']['authokb']      .= "<BR><BR>De acum va pueti loga folosind adresa de email si parola aleasa!";

$rudweb_ln['usr']['lostpass1']     = "<BR>Echipa " . _RUDWEB_WSTT . " va respecta intimitatea, de aceea nu cunoastem parola dvs.";
$rudweb_ln['usr']['lostpass1']    .= "<BR><BR>Asadar, daca nu mai tineti minte parola aleasa, aceasta este pierduta pentru totdeauna.";
$rudweb_ln['usr']['lostpass1']    .= "<BR><BR>In acest caz, singura solutie este resetarea parolei de catre dvs. si alegerea unei alte parole.";
$rudweb_ln['usr']['lostpass1']    .= "<BR><BR>Va rugam introduceti adresa de email folosita pentru a inregistra contul dvs. la " . _RUDWEB_WSTT . ":";

$rudweb_ln['usr']['lostapsserr']   = "Ne pare rau, nu am gasit nimic in baza noastra de date.";

$rudweb_ln['usr']['lpmailsubj']    = 'Recuperare parola la';

$rudweb_ln['usr']['lpmailtxt1a']   = "<DIV>";
$rudweb_ln['usr']['lpmailtxt1a']  .= "Drag&#259; <B>";
$rudweb_ln['usr']['lpmailtxt1b']   = "</B>";
$rudweb_ln['usr']['lpmailtxt1b']  .= "<BR><BR>Pentru resetarea parolei va rugam dati click pe urmatorul link (valabil o zi):";
$rudweb_ln['usr']['lpmailtxt1b']  .= "<BR><BR>";

$rudweb_ln['usr']['lpmailtxt2']    = "<BR><BR>Daca aveti probleme cu afisarea link-ului, va rugam copiati urmatoarea adresa in browserul dvs:";
$rudweb_ln['usr']['lpmailtxt2']   .= "<BR><BR>";

$rudweb_ln['usr']['lpmailtxt3']    = "<BR><BR>Cu stim&#259;,";
$rudweb_ln['usr']['lpmailtxt3']   .= "<BR>Echipa " . _RUDWEB_WSTT . " ";
$rudweb_ln['usr']['lpmailtxt3']   .= "</DIV>";

$rudweb_ln['usr']['lostpmessage']  = "<BR><BR>La adresa specificata a fost trimis un email continand instructiuni pentru resetarea parolei.";
$rudweb_ln['usr']['lostpmessage'] .= "<BR><BR>Va rugam sa va verificati email-ul si sa urmati instructiunile pentru resetarea parolei dvs. la " . _RUDWEB_WSTT . ".";

$rudweb_ln['usr']['lostperror']    = "<BR><BR>Din pacate nu am reusit sa trimitem emailul de resetare a parolei.";
$rudweb_ln['usr']['lostperror']   .= "<BR><BR>Va rugam contactati administratorul site-ului in legatura cu aceasta problema.";

$rudweb_ln['usr']['lostpass2']     = "<BR><BR>Va rugam alegeti o noua parola:";

$rudweb_ln['usr']['lostpassoka']   = "<BR>Va multumim!";
$rudweb_ln['usr']['lostpassoka']  .= "<BR><BR>Parola dvs. ";
$rudweb_ln['usr']['lostpassokb']   = " a fost schimbata cu succes!";
$rudweb_ln['usr']['lostpassokb']  .= "<BR><BR>De acum va puteti loga folosind adresa de email si parola aleasa!";

$rudweb_ln['conm']['notify_subject'] = 'Mesaj contact nou pe site-ul ' . _RUDWEB_WSTT;
$rudweb_ln['conm']['notify_txt1']    = 'Aveti un mesaj de contact nou pe site-ul <B>' . _RUDWEB_WSTT . '</B>';
$rudweb_ln['conm']['notify_txt2']    = '<BR><BR>Data: ';
$rudweb_ln['conm']['notify_txt3']    = '<BR><BR>Pentru a putea vizualiza mesajul v&#259; rug&#259;m s&#259; v&#259; autentifica&#355;i la adresa:';
$rudweb_ln['conm']['notify_txt4']    = '<BR>' . _RUDWEB_SITE_URL . 'admin';

$rudweb_ln['conm']['send_subject'] = 'Mesaj contact nou pe site-ul ' . _RUDWEB_WSTT;
$rudweb_ln['conm']['send_txt1']    = 'Aveti un mesaj de contact nou pe site-ul <B>' . _RUDWEB_WSTT . '</B>';
$rudweb_ln['conm']['send_txt2']    = '<BR><BR>Data: ';
$rudweb_ln['conm']['send_txt3']    = '<BR><BR>Con&#355;inut:';
$rudweb_ln['conm']['send_txt4']    = '<BR>';

$rudweb_ln['conm']['ok_mesage']    = '<BR>Mesajul Dumneavoastr&#259; a fost &#238;nregistrat!<BR>V&#259; mul&#355;umim!';
?>