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
./setup/cfg/init.inc.php
12:50 2008-04-05
*/

/* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

$step = null;
if(isset($_GET['step'])) {$step = $_GET['step'];}
$target_var = null;
$act = null;
if(isset($_GET['act']) && in_array($_GET['act'], $acts)) {$act = $_GET['act'];}
$set = null;
if(isset($_GET['set']) && in_array($_GET['set'], $sets)) {$set = $_GET['set'];}

$source = $source_root . 'kit/';
if(isset($_SESSION['rudwebset_pid'])) {$pid = $_SESSION['rudwebset_pid']; $target = $target_root . $target_vars[$pid];}
else if (isset($_GET['pid'])) {$pid = $_GET['pid']; $target = $target_root . $target_vars[$pid];}
else {$pid = '0'; $target = $target_root . $target_vars[1];}


$dfs = "0";
$dts = "0";
if(is_readable($target)) {
  $dfs = round((disk_free_space($target) / 1024) / 1024, 2);
  $dts = round((disk_total_space($target) / 1024) / 1024, 2);
}

/* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

// version stuff
$ub_version = get_version($source);
$cl_version = get_version($target);
$compare_version = compare_version($ub_version, $cl_version);
$version_age = version_age($ub_version, $cl_version);
/* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
?>