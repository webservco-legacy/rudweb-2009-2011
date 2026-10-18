<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Extension tester
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-01-23 19:48:00
 * @access     public
 * @package    rwHTD
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
 * Notes:
 *
 * This is a raw extension tester.
 * Do not delete until sucessfully implemented as a module, etc.
 *
 * Currently it works on the delFD extension.
 */

/**
 * Prevent unauthorized access to other files
 * @ignore
 */
define('_RW_VALID', TRUE);
/**
 * @ignore
 */
define('_RW_DIR', 'd:/home/devel/server/htdocs/pub/temp/mvc/work/rudweb/');
/**
 * @ignore
 */
define('_RW_DIR_LIB', _RW_DIR . 'rwlib/');
/**
 * @ignore
 */
define('_APP_EXT_GLOBAL_DIR',_RW_DIR . 'ext/');

/*
 * Set extension name here
 */
$extName = 'delFD';

$extClass = 'rw_Ext_'.$extName;
require_once(_RW_DIR_LIB.'ext.inc.php');
if(is_file(_APP_EXT_GLOBAL_DIR.$extName.'.ext.php'))
{
    require_once(_APP_EXT_GLOBAL_DIR.$extName.'.ext.php');
}
$class = 'rw_Ext_'.$extName;

/*
 * Work here
 */

$ext = new $class();

$tester_dir = 'd:/home/devel/server/htdocs/pub/temp/mvc/work/tester/var/tmp/';
$ext->delFD($tester_dir, 0, TRUE, TRUE);
$tester_result = $ext->showStats();
$ext->resetStats();
echo 'Tester: ';
echo $tester_result['dirs'] . ' subdirs, ';
echo $tester_result['files'] . ' files, ';
echo round(($tester_result['size'])/1024, 2) . ' Kb<br/>';

$dasoft_dir = 'd:/home/devel/server/htdocs/pub/temp/mvc/work/dasoft/var/tmp/';
$ext->delFD($dasoft_dir, 0, TRUE, TRUE);
$dasoft_result = $ext->showStats();
$ext->resetStats();
echo 'DaSoft: ';
echo $dasoft_result['dirs'] . ' subdirs, ';
echo $dasoft_result['files'] . ' files, ';
echo round(($dasoft_result['size'])/1024, 2) . ' Kb<br/>';

$mc_dir = 'd:/home/devel/server/htdocs/pub/temp/mvc/work/mediacontent/var/tmp/';
$ext->delFD($mc_dir, 0, TRUE, TRUE);
$mc_result = $ext->showStats();
echo 'MediaContent: ';
echo $mc_result['dirs'] . ' subdirs, ';
echo $mc_result['files'] . ' files, ';
echo round(($mc_result['size'])/1024, 2) . ' Kb<br/>';
?>