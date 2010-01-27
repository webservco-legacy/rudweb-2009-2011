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
./setup/cfg/inst.inc.php
12:50 2008-04-05
*/
echo "<DIV CLASS=\"hdr\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 5px; padding-right: 3px;\"><B>";
echo "<A HREF=\"./setup.php?pid=".$pid."&amp;set=".$set."&amp;act=index&amp;step=1\" TARGET=\"_self\">Start</A>";
echo "</B></DIV>";
echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
if($act == 'index' && $step == '1') {echo "#aaaaaa";} else {echo "#333333";}
echo "\">Index</SPAN>";
echo "</B></DIV>";
echo "<DIV CLASS=\"hdr\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 5px; padding-right: 3px;\"><B>";
echo "<A HREF=\"./setup.php?pid=".$pid."&amp;set=".$set."&amp;act=verif&amp;step=1\" TARGET=\"_self\">Check Requirements</A>";
echo "</B></DIV>";
echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
if($act == 'verif' && $step == '1') {echo "#aaaaaa";} else {echo "#333333";}
echo "\">Database Settings</SPAN>";
echo "</B></DIV>";
echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
if($act == 'verif' && $step == '2') {echo "#aaaaaa";} else {echo "#333333";}
echo "\">Checking Requirements</SPAN>";
echo "</B></DIV>";

if($set == 'install' || $set == 'upgrade') {
  echo "<DIV CLASS=\"hdr\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 5px; padding-right: 3px;\"><B>";
  echo "<A HREF=\"./setup.php?pid=".$pid."&amp;set=".$set."&amp;act=engn&amp;step=1\" TARGET=\"_self\">Install Engine</A>";
  echo "</B></DIV>";
  
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'engn' && $step == '1') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Root</SPAN>";
  echo "</B></DIV>";
  
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'engn' && $step == '2') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Admin</SPAN>";
  echo "</B></DIV>";
  
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'engn' && $step == '3') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Documentation</SPAN>";
  echo "</B></DIV>";
  
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'engn' && $step == '4') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Includes</SPAN>";
  echo "</B></DIV>";
  
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'engn' && $step == '5') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Libraries</SPAN>";
  echo "</B></DIV>";
  
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'engn' && $step == '6') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Languages</SPAN>";
  echo "</B></DIV>";
  
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'engn' && $step == '7') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Skin</SPAN>";
  echo "</B></DIV>";
  
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'engn' && $step == '8') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Vars</SPAN>";
  echo "</B></DIV>";

  echo "<DIV CLASS=\"hdr\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 5px; padding-right: 3px;\"><B>";
  echo "<A HREF=\"./setup.php?pid=".$pid."&amp;set=".$set."&amp;act=lngs&amp;step=1\" TARGET=\"_self\">Install Languages</A>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'lngs' && $step == '1') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Select Languages</SPAN>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'lngs' && $step == '2') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Install Languages</SPAN>";
  echo "</B></DIV>";

  echo "<DIV CLASS=\"hdr\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 5px; padding-right: 3px;\"><B>";
  echo "<A HREF=\"./setup.php?pid=".$pid."&amp;set=".$set."&amp;act=skins&amp;step=1\" TARGET=\"_self\">Install Skins</A>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'skins' && $step == '1') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Select Skins</SPAN>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'skins' && $step == '2') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Install Skins</SPAN>";
  echo "</B></DIV>";
if($set != 'upgrade') {
    echo "<DIV CLASS=\"hdr\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 5px; padding-right: 3px;\"><B>";
    echo "<A HREF=\"./setup.php?pid=".$pid."&amp;set=".$set."&amp;act=usett&amp;step=1\" TARGET=\"_self\">Gather Settings</A>";
    echo "</B></DIV>";
    echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
    echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
    if($act == 'usett' && $step == '1') {echo "#aaaaaa";} else {echo "#333333";}
    echo "\">Engine Configuration</SPAN>";
    echo "</B></DIV>";
    echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
    echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
    if($act == 'usett' && $step == '2') {echo "#aaaaaa";} else {echo "#333333";}
    echo "\">Site Configuration</SPAN>";
    echo "</B></DIV>";

    echo "<DIV CLASS=\"hdr\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 5px; padding-right: 3px;\"><B>";
    echo "<A HREF=\"./setup.php?pid=".$pid."&amp;set=".$set."&amp;act=cfgs&amp;step=1\" TARGET=\"_self\">Install Settings</A>";
    echo "</B></DIV>";
    echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
    echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
    if($act == 'cfgs' && $step == '1') {echo "#aaaaaa";} else {echo "#333333";}
    echo "\">Engine Configuration</SPAN>";
    echo "</B></DIV>";
    echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
    echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
    if($act == 'cfgs' && $step == '2') {echo "#aaaaaa";} else {echo "#333333";}
    echo "\">Site Configuration</SPAN>";
    echo "</B></DIV>";

    echo "<DIV CLASS=\"hdr\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 5px; padding-right: 3px;\"><B>";
    echo "<A HREF=\"./setup.php?pid=".$pid."&amp;set=".$set."&amp;act=dbs&amp;step=1\" TARGET=\"_self\">Setup Database</A>";
    echo "</B></DIV>";
    echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
    echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
    if($act == 'dbs' && $step == '1') {echo "#aaaaaa";} else {echo "#333333";}
    echo "\">Database Options</SPAN>";
    echo "</B></DIV>";
    echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
    echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
    if($act == 'dbs' && $step == '2') {echo "#aaaaaa";} else {echo "#333333";}
    echo "\">Create Tables</SPAN>";
    echo "</B></DIV>";
    echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
    echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
    if($act == 'dbs' && $step == '3') {echo "#aaaaaa";} else {echo "#333333";}
    echo "\">Insert Default Data</SPAN>";
    echo "</B></DIV>";
    echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
    echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
    if($act == 'dbs' && $step == '4') {echo "#aaaaaa";} else {echo "#333333";}
    echo "\">Insert Example Data</SPAN>";
    echo "</B></DIV>";
  }
}
else if ($set == 'remove') {
  echo "<DIV CLASS=\"hdr\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 5px; padding-right: 3px;\"><B>";
  echo "<A HREF=\"./setup.php?pid=".$pid."&amp;set=".$set."&amp;act=removed&amp;step=1\" TARGET=\"_self\">Remove Data</A>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'removed' && $step == '1') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Remove Database Data</SPAN>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'removed' && $step == '2') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Remove Database Tables</SPAN>";
  echo "</B></DIV>";
  
  echo "<DIV CLASS=\"hdr\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 5px; padding-right: 3px;\"><B>";
  echo "<A HREF=\"./setup.php?pid=".$pid."&amp;set=".$set."&amp;act=removefu&amp;step=1\" TARGET=\"_self\">Remove User Files</A>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'removefu' && $step == '1') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Configuration Files</SPAN>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'removefu' && $step == '2') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Languages</SPAN>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'removefu' && $step == '3') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Skins</SPAN>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'removefu' && $step == '4') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Vars</SPAN>";
  echo "</B></DIV>";
  
  echo "<DIV CLASS=\"hdr\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 5px; padding-right: 3px;\"><B>";
  echo "<A HREF=\"./setup.php?pid=".$pid."&amp;set=".$set."&amp;act=removef&amp;step=1\" TARGET=\"_self\">Remove Files</A>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'removef' && $step == '1') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Libraries</SPAN>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'removef' && $step == '2') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Includes</SPAN>";
  echo "</B></DIV>";
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'removef' && $step == '3') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Admin</SPAN>";
  echo "</B></DIV>";
  
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'removef' && $step == '4') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Documentation</SPAN>";
  echo "</B></DIV>";
  
  echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
  echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
  if($act == 'removef' && $step == '5') {echo "#aaaaaa";} else {echo "#333333";}
  echo "\">Root</SPAN>";
  echo "</B></DIV>";
}
echo "<DIV CLASS=\"hdr\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 5px; padding-right: 3px;\"><B>";
echo "<A HREF=\"./setup.php?pid=".$pid."&amp;set=".$set."&amp;act=finish&amp;step=1\" TARGET=\"_self\">Finish</A>";
echo "</B></DIV>";
echo "<DIV CLASS=\"cnt\" STYLE=\"padding-top: 3px; padding-bottom: 3px; padding-left: 15px; padding-right: 3px;\"><B>";
echo "<SPAN CLASS=\"cnt\" STYLE=\"color: ";
if($act == 'finish' && $step == '1') {echo "#aaaaaa";} else {echo "#333333";}
echo "\">Finish</SPAN>";
echo "</B></DIV>";
?>