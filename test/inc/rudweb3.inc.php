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
./inc/rudweb3.inc.php
12:50 2008-04-05
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

// LOAD SKIN
require_once _RUDWEB_SKIN_DIR . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'] . '/skin.info.php';
$_SESSION[_RUDWEB_PRE.'usr_skin_name']    = $rudweb_skin_name;
$_SESSION[_RUDWEB_PRE.'usr_skin_version'] = $rudweb_skin_version;
$_SESSION[_RUDWEB_PRE.'usr_skin_author']  = $rudweb_skin_author;
$_SESSION[_RUDWEB_PRE.'usr_skin_notes']   = $rudweb_skin_notes;
require_once _RUDWEB_SKIN_DIR . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'] . '/skin.inc.php';
$_SESSION[_RUDWEB_PRE.'usr_skin_bg']   = $rudweb_skin['BgColor'];
$_SESSION[_RUDWEB_PRE.'usr_skin_fg']   = $rudweb_skin['FontColor'];

// STATS
if (_RUDWEB_CFG_STATS_ON === "1") {doStats();}
?>