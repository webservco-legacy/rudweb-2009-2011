<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Simple WordPress Plugin to run PHP Code inside a page.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-07-24 20:28:00
 * @access     public
 * @package    rwPHP
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

/*
 Plugin Name: rwPHP
 Plugin URI: http://www.rudisoft.net
 Description: Simple WordPress Plugin to run PHP Code inside a page.
 Author: Radu Maier
 Version: 0.1
 Author URI: http://www.rudisoft.net/
 */

function rwPHP($content)
{
/**
 * This fixes some strange functionality when using inline php tags
 */
$content = str_replace("&#8221;", '"', $content);
/**
 * Run the php code
 */
eval("?>\n" . $content . "<?php ");
}

add_filter('the_content', 'rwPHP');
?>