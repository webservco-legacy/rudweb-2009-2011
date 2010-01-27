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
./setup/setup.php
12:50 2008-04-05
*/
error_reporting(E_ALL);

/* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

// load  rudweb configuration
if(is_file("./cfg/cfg_rudweb.inc.php")) {require_once "./cfg/cfg_rudweb.inc.php";}
else {die("could not load rudweb config!");}

// load user configuration
if(is_file("./cfg/cfg_user.inc.php")) {require_once "./cfg/cfg_user.inc.php";}
else {die("could not load user config!");}

// load functions
if(is_file("./inc/func.inc.php")) {require_once "./inc/func.inc.php";}
else {die("could not load functions!");}

// init
if(is_file("./inc/init.inc.php")) {require_once "./inc/init.inc.php";}
else {die("could not initialize setup!");}

// session
if(is_file("./inc/ses.inc.php")) {require_once "./inc/ses.inc.php";}
else {die("could not initialize session!");}

/* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

// HEADER
require_once './htm/hdr.inc.php';

require_once './inc/rudweb.inc.php';
require_once './inc/ds.inc.php';

if(!isset($_SESSION['rudwebset_pid']) && ($act == null && $set == null)) {
  require_once './inc/projects.inc.php';
}
else {
  echo "\n<TABLE BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"1\" BGCOLOR=\"#EEEEEE\" WIDTH=\"100%\">";
  echo "\n<TR><TD CLASS=\"cnt\" STYLE=\"width: 200px; height: 500px; vertical-align: top;\">";
  require_once './inc/info.inc.php';
  echo "<BR><BR>";
  require_once './inc/' . 'inst.inc.php';
  echo "\n</TD><TD CLASS=\"cnt\"  STYLE=\"vertical-align: top;\">";
  require_once './act/' . $act . '.inc.php';
  echo "\n</TD></TR></TABLE>";
}

// FOOTER
require_once './htm/ftr.inc.php';
?>