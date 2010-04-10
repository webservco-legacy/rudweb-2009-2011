<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>nfo.layout.tpl.php
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-04-08 20:04:00
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
<?php echo '<?xml version="1.0" encoding="utf-8" standalone="no"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="content-language" content="en" />
		<title>Rudweb <?php echo $this->extObj->extAbout('name'); ?> <?php echo $this->extObj->extAbout('ver'); ?></title>
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<?php echo $this->_outStyles(); ?>
		
		<?php echo $this->_outScripts(); ?>
	
	</head>
	<body>
		<div id="nfo">
			<?php echo $this->_outMenu(); ?>
		
			<h2 class="rud"><a name="a_php">PHP Information</a></h2>
			
			<div class="box">
				<h3 class="rud"><a class="nfo" name="a_php_nfo"	href="JavaScript:toggle('php_nfo')">General information</a></h3>
				<div id="php_nfo">
					<table>
						<tr>
							<th class="key">name</th>
							<th class="value">value</th>
						</tr>
						<?php foreach ($this->extObj->nfoPhpNfo() as $name => $value) : ?>
						<tr>
							<td class="key"><?php echo $name; ?></td>
							<td class="value"><?php echo $value; ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
					<div class="right">
						<a href="JavaScript:toggle('php_nfo')" title="close">[close]</a>
					</div>
				</div>
			</div>
			
			<div class="box">
				<h3 class="rud"><a class="nfo" name="a_php_ext"	href="JavaScript:toggle('php_ext')">Loaded Extensions</a></h3>
				<div id="php_ext">
					<table>
						<tr>
							<th class="key">name</th>
							<th class="value">value</th>
						</tr>
						<?php foreach ($this->extObj->nfoPhpExt() as $name => $value) : ?>
						<tr>
							<td class="key"><?php echo $name; ?></td>
							<td class="value"><?php var_dump($value); ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
					<div class="right">
						<a href="JavaScript:toggle('php_ext')" title="close">[close]</a>
					</div>
				</div>
			</div>
			
			<div class="box">
				<h3 class="rud"><a class="nfo" name="a_php_ini" href="JavaScript:toggle('php_ini')">PHP Ini settings</a></h3>
				<div id="php_ini">
					<table>
						<tr>
							<th class="key">name</th>
							<th class="value">global value</th>
							<th class="value">local value</th>
							<th class="value_small">access</th>
						</tr>
						<?php foreach ($this->extObj->nfoPhpIni() as $name => $value) : ?>
						<tr>
							<td class="key"><?php echo $name; ?></td>
							<td class="value"><?php echo $value['global_value']; ?></td>
							<td class="value"><?php echo $value['local_value']; ?></td>
							<td class="value_small"><?php echo $value['access']; ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
					<div class="right">
						<a href="JavaScript:toggle('php_ini')" title="close">[close]</a>
					</div>
				</div>
			</div>
			
			<div class="box">
				<h3 class="rud"><a class="nfo" name="a_php_info" href="JavaScript:toggle('php_info')">PHPInfo()</a></h3>
				<div id="php_info">
					<?php echo $this->extObj->nfoPhpInfo(); ?>
					<div class="right">
						<a href="JavaScript:toggle('php_info')" title="close">[close]</a>
					</div>
				</div>
			</div>
			
			<h2 class="rud"><a name="a_server">Server information</a></h2>
			
			<div class="box">
				<h3 class="rud"><a class="nfo" name="a_server_nfo" href="JavaScript:toggle('server_nfo')">General information</a></h3>
				<div id="server_nfo">
					<table>
						<tr>
							<th class="key">name</th>
							<th class="value">value</th>
						</tr>
						<?php foreach ($this->extObj->nfoServerNfo() as $name => $value) : ?>
						<tr>
							<td class="key"><?php echo $name; ?></td>
							<td class="value"><?php echo $value; ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
					<div class="right">
						<a href="JavaScript:toggle('server_nfo')" title="close">[close]</a>
					</div>
				</div>
			</div>
			
			<div class="box">
				<h3 class="rud"><a class="nfo" name="a_server_modules" href="JavaScript:toggle('server_modules')">Server modules:</a></h3>
				<div id="server_modules">
					<table>
						<tr>
							<th class="key">name</th>
							<th class="value">value</th>
						</tr>
						<?php foreach ($this->extObj->nfoServerModules() as $id => $name) : ?>
						<tr>
							<td class="key"><?php echo $name; ?></td>
							<td class="value">&#160;</td>
						</tr>
						<?php endforeach; ?>
					</table>
					<div class="right">
						<a href="JavaScript:toggle('server_modules')" title="close">[close]</a>
					</div>
				</div>
			</div>
			
			<div class="box">
				<h3 class="rud"><a class="nfo" name="a_server_info"	href="JavaScript:toggle('server_info')">Server info:</a></h3>
				<div id="server_info">
					<table>
						<tr>
							<th class="key">name</th>
							<th class="value">value</th>
						</tr>
						<?php foreach ($this->extObj->nfoServerInfo() as $name => $value) : ?>
						<tr>
							<td class="key"><?php echo $name; ?></td>
							<td class="value"><?php echo $value; ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
					<div class="right">
						<a href="JavaScript:toggle('server_info')" title="close">[close]</a>
					</div>
				</div>
			</div>
			
			<h2 class="rud"><a name="a_server">OS information</a></h2>
			
			<div class="box">
				<h3 class="rud"><a class="nfo" name="a_os_nfo" href="JavaScript:toggle('os_nfo')">General information</a></h3>
				<div id="os_nfo">
					<table>
						<tr>
							<th class="key">name</th>
							<th class="value">value</th>
						</tr>
						<?php foreach ($this->extObj->nfoOsNfo() as $name => $value) : ?>
						<tr>
							<td class="key"><?php echo $name; ?></td>
							<td class="value"><?php echo $value; ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
					<div class="right">
						<a href="JavaScript:toggle('os_nfo')" title="close">[close]</a>
					</div>
				</div>
			</div>
			
			<h2 class="rud"><a name="a_fs">Filesystem information</a></h2>
			
			<div class="box">
				<h3 class="rud"><a class="nfo" name="a_fs_nfo" href="JavaScript:toggle('fs_nfo')">General information</a></h3>
				<div id="fs_nfo">
					<table>
						<tr>
							<th class="key">name</th>
							<th class="value">value</th>
						</tr>
						<?php foreach ($this->extObj->nfoFsNfo() as $name => $value) : ?>
						<tr>
							<td class="key"><?php echo $name; ?></td>
							<td class="value">
							<?php if (in_array($name, array('size', 'used', 'available'))) : ?>
							<?php echo $this->_hrSize($value); ?>B
							<?php elseif ($name == 'use') : ?>
							<?php echo $value; ?>%
							<?php else: ?>
							<?php echo $value; ?>
							<?php endif; ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</table>
					<div class="right">
						<a href="JavaScript:toggle('fs_nfo')" title="close">[close]</a>
					</div>
				</div>
			</div>
			
			<script type="text/javascript">
			//<![CDATA[
			toggle('php_info');
			toggle('php_nfo');
			toggle('php_ext');
			toggle('php_ini');
			toggle('server_nfo');
			toggle('server_modules');
			toggle('server_info');
			toggle('os_nfo');
			toggle('fs_nfo');
			//]]>
			</script>
		</div>
	</body>
</html>
