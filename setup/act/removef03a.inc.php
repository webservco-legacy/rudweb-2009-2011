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
./setup/act/removef03a.inc.php
12:50 2008-04-05
*/

echo "\n<TABLE BORDER=\"0\" CELLPADDING=\"3\" CELLSPACING=\"0\" BGCOLOR=\"#000000\" WIDTH=\"100%\">";
echo "\n<TR><TD CLASS=\"ttt\" WIDTH=\"200\"><B>Admin</B></TD>";
echo "</TR></TABLE>";

$dirs[3]    = "admin/";
$files[$dirs[3]][1] = array();
$files[$dirs[3]][1][] = "index.php";

$dirs[2]    = "admin/backup/";
$files[$dirs[2]][1] = array();
$files[$dirs[2]][1][] = "index.php";

$dirs[1]    = "admin/backup/db/";
$files[$dirs[1]][1] = array();
$files[$dirs[1]][1][] = "index.php";

$dirs[0]    = "catalog/";
$files[$dirs[0]][1] = array();
$files[$dirs[0]][1][] = "index.php";
?>