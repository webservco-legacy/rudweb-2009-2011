<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Routing configuration file.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-16 12:02:00
 * @access     public
 * @package    rwApp
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
 * Security check.
 */
if(!defined('_RW_VALID'))
{
    /**
     * Display "Not Found" page.
     */
    require_once('./var/err/404.php');
    /**
     * Stop script execution.
     */
    exit;
}

/**
 * Default route.
 *
 * This must be present, and always first.
 */
$routing['index'] = 'stContent';
/**
 * Custom route.
 */
$routing['content'] = 'stContent';
/**
 * Custom route.
 */
$routing['content/({any})'] = 'stContent/$1';
/**
 * Custom route.
 */
$routing['users'] = 'modUsers';
/**
 * Custom route.
 */
$routing['users/({any})'] = 'modUsers/$1';
/**
 * Custom route.
 */
$routing['about'] = 'dbContent/view/2/about';
/**
 * Custom route.
 */
$routing['myModule/({num})'] = 'dbContent/index/$1';
/**
 * Custom route.
 */
$routing['some/({any})/({any})/({num})'] = 'dbTestContent/$2/$1/$3';
/**
 * Custom route.
 */
$routing['content/index/({any})'] = 'dbContent/indexul/$1';
?>