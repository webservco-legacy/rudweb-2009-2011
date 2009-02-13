<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Main application controller.
 * <BR>Processes all requests
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2008-12-03 18:31:00
 * @access     public
 * @package    RudWEb
 * @subpackage App
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
 * Prevent unauthorized access to other files
 */
define('_RW_VALID', TRUE);

/**
 * Load configuration files
 */
if(is_readable('./cfg/cfg.inc.php')) {require_once('./cfg/cfg.inc.php');} else {
	$location = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/' . '404.php';
	header("Location: http://$location");
	exit;
}
/**
 * Initialize main application core
 */
$appCore = new app_Core;
$appCore->rwInit($exts);
/**
 * Controller start
 */
try
{
	if(is_readable(_APP_DIR_INC.'ctrl.inc.php')) {require_once(_APP_DIR_INC.'ctrl.inc.php');} else {trigger_error('controller missing', E_USER_ERROR);}
}
catch (Exception $e)
{
	echo $appCore->rwErr($e);
	exit;
}
/**
 * Controller end
 */

/**
 * Viewer start
 */
try
{
	if(is_readable(_RW_DIR_LIB.'view.inc.php')) {require_once(_RW_DIR_LIB.'view.inc.php');} else {trigger_error('viewer missing', E_USER_ERROR);}
	app_Viewer::_display($cnt['skin'], $atpl);
}
catch (Exception $e)
{
	echo $appCore->rwErr($e);
	exit;
}
/**
 * Viewer end
 */

rw_Error_handler::restore();
?>