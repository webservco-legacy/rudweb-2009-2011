<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>nfo.menu.tpl.php
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-04-08 19:56:00
 * @access     public
 * @package    rwOut
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
?>
<div id="menu">
	<div class="toggle">
		<span>Rudweb <?php echo $this->extObj->extAbout('name'); ?></span>
		<ul class="l1">
			<li class="l1">
				<a href="#a_php" title="PHP Information">PHP Information</a>
				<ul class="l2">
					<li class="l2">
						<a href="#a_php_info" title="PHPInfo()">PHPInfo()</a>
					</li>
					<li class="l2">
						<a href="#a_php_nfo" title="General Information">General	Information</a>
					</li>
					<li class="l2">
						<a href="#a_php_ext" title="Loaded Extensions">Loaded Extensions</a>
					</li>
					<li class="l2">
						<a href="#a_php_ini" title="Loaded Extensions">PHP Ini Settings</a>
					</li>
				</ul>
			</li>
			<li class="l1">
				<a href="#a_server" title="Server Information">Server Information</a>
				<ul class="l2">
					<li class="l2">
						<a href="#a_server_modules" title="Server Modules">Server Modules</a>
					</li>
					<li class="l2">
						<a href="#a_server_info" title="Server Information">Server Information</a>
					</li>
				</ul>
			</li>
			<li class="l1">
			<a href="#a_other" title="Other Information">Other Information</a>
			</li>
		</ul>
	</div>
</div>