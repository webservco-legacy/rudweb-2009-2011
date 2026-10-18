<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Deprecated functions
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-20 10:21:00
 * @access     public
 * @package    RudWEb
 * @subpackage Core
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
 * Prevent direct file access
 */
if(!defined('_RW_VALID')) {require_once('./index.php'); exit;}

/**
 * Self redirect to prevent double posting
 * 
 * Also remove request from request tail
 * and add custom request
 *
 * @param string $add params to add
 * @param string $remove param to remove (only param title needed)
 */
function _selfRedirect($add=NULL, $remove=NULL)
{
    $add = ($add != NULL) ? '/'.$add : '';
    if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != '')
    {
        $redirect = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$add;
    }
    else if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != '')
    {
        $redirect = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].$add;
    }
    else
    {
        $redirect = _APP_URL;
    }
    $redirect = ($remove != NULL) ? substr($redirect, 0, strlen($redirect)-(strlen(strstr($redirect,$remove))+1)) : $redirect;
    $redirect .= $add;
    header("Location: ".$redirect);
    exit;
}
?>