<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Misc information.
 * <BR>This is the first standalone extension ever!
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-04-06 16:16
 * @access     public
 * @package    rwExt
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
if (!defined('_RW_VALID'))
{
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * Extension name.
 */
$extAbout['Nfo']['name'] = 'Nfo';
/**
 * Extension description.
 */
$extAbout['Nfo']['desc'] = 'Misc information.';
/**
 * Extension version.
 */
$extAbout['Nfo']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Nfo']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Nfo']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Nfo']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Nfo']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Nfo']['deps']['lib'] = array();
/**
 * Extension extension dependencies.
 */
$extAbout['Nfo']['deps']['ext'] = array();

/**
 * rw_Extension_Nfo.
 *
 * rw_Extension_Nfo extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Nfo extends rw_Extension implements rw_iExtension
{
	/**
	 * Server info.
	 *
	 * @var array
	 */
	private $server = array();

	/**
	 * Constructor.
	 *
	 * @param array $extAbout
	 * @return mixed result
	 */
	public function __construct($extAbout)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($extAbout);
	}

	/**
	 * PHPInfo() method
	 *
	 * @return mixed result.
	 */
	public function nfoPhpInfo()
	{
		/**
		 * Check if function is available.
		 */
		if (!function_exists('phpinfo'))
		{
			/**
			 * Return result.
			 */
			return FALSE;
		}
		/**
		 * Start buffer.
		 */
		ob_start();
		/**
		 * Call function.
		 */
		phpinfo();
		/**
		 * Get function output.
		 */
		$php_info = ob_get_contents();
		/**
		 * End buffer.
		 */
		ob_end_clean();
		/**
		 * Parse function output.
		 */
		$php_info = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $php_info);
		/**
		 * Return output.
		 */
		return $php_info;
	}

	/**
	 * General PHP information method.
	 *
	 * @return mixed result.
	 */
	public function nfoPhpNfo()
	{
		/**
		 * Init.
		 */
		$php = array();
		/**
		 * PHP Version
		 */
		$php['version']          = (function_exists('phpversion')) ? phpversion() : PHP_VERSION;
		/**
		 * Short open tag.
		 */
		$php['short_open_tag']   = (function_exists('ini_get')) ? (int) ini_get('short_open_tag') : FALSE;
		/**
		 * Safe mode.
		 */
		$php['safe_mode']        = (function_exists('ini_get')) ? (int) ini_get('safe_mode') : FALSE;
		/**
		 * Register globals.
		 */
		$php['register_globals'] = (function_exists('ini_get')) ? (int) ini_get('register_globals') : FALSE;
		/**
		 * Magic quotes.
		 */
		$php['magic_quotes_gpg'] = (function_exists('ini_get')) ? (int) ini_get('magic_quotes_gpg') : FALSE;
		/**
		 * File uploads.
		 */
		$php['file_uploads']     = (function_exists('ini_get')) ? (int) ini_get('file_uploads') : FALSE;
		/**
		 * Allow URL fopen.
		 */
		$php['allow_url_fopen']  = (function_exists('ini_get')) ? (int) ini_get('allow_url_fopen') : FALSE;
		/**
		 * Return result.
		 */
		return $php;
	}

	/**
	 * Loaded PHP extensions method.
	 *
	 * @return mixed result.
	 */
	public function nfoPhpExt()
	{
		/**
		 * Check if method is available.
		 */
		if(!function_exists('get_loaded_extensions'))
		{
			/**
			 * Return result.
			 */
			return array();
		}
		/**
		 * Get loaded extensions.
		 */
		$ext = get_loaded_extensions();
		/**
		 * Sort them by name
		 */
		sort($ext);
		/**
		 * Get additional extesnsion information.
		 */
		$ext = $this->_nfoPhpExtInfo($ext);
		/**
		 * Return result.
		 */
		return $ext;
	}

	/**
	 * Get additional extension information.
	 *
	 * @param array $e extensions array.
	 */
	private function _nfoPhpExtInfo($e)
	{
		/**
		 * Init.
		 */
		$ext = array();
		/**
		 * Parse extension list.
		 */
		foreach ($e as $id => $name)
		{
			/**
			 * Check each name.
			 */
			switch($name)
			{
				/**
				 * GD.
				 */
				case 'gd' : {
					/**
					 * Set array item.
					 */
					$ext[$name] = function_exists('gd_info') ? gd_info() : TRUE;
					/**
					 * Stop execution.
					 */
					break;
				}
				/**
				 * Default.
				 */
				default : {
					/**
					 * Set array item.
					 */
					$ext[$name] = TRUE;
					/**
					 * Stop execution.
					 */
					break;
				}
			}
		}
		/**
		 * Return result.
		 */
		return $ext;
	}

	/**
	 * PHP settings method.
	 *
	 * @return mixed result.
	 */
	public function nfoPhpIni()
	{
		/**
		 * Check if method is available.
		 */
		if (!function_exists('ini_get_all'))
		{
			/**
			 * Return result.
			 */
			return array();
		}
		/**
		 * Return result.
		 */
		return ini_get_all();
	}

	/**
	 * Server information method.
	 *
	 * @return mixed result
	 */
	public function nfoServerNfo()
	{
		/**
		 * Init.
		 */
		$server = NULL;
		/**
		 * Check for apache in server info.
		 */
		if (isset($_SERVER['SERVER_SOFTWARE']) && (preg_match("/Apache\/[0-9.+]{1,10}/", $_SERVER['SERVER_SOFTWARE'], $server_raw)))
		{
			/**
			 * Split string
			 */
			$server_split = explode('/', $server_raw[0]);
			/**
			 * Server name.
			 */
			$server['name'] = $server_split[0];
			/**
			 * Server version.
			 */
			$server['version'] = $server_split[1];
		}
		/**
		 * Check for apache my function.
		 */
		else if (function_exists('apache_get_version'))
		{
			/**
			 * Server name.
			 */
			$server['name'] = 'Apache';
			/**
			 * Server version.
			 */
			$server['version'] = apache_get_version();
		}
		/**
		 * Apache not found
		 */
		else
		{
			/**
			 * Server name.
			 */
			$server['name'] = 'n/a';
			/**
			 * Server version.
			 */
			$server['version'] = 'n/a';
		}
		/**
		 * Set server.
		 */
		$this->server = $server;
		/**
		 * Return result.
		 */
		return $server;
	}

	/**
	 * Server modules information.
	 *
	 * This HAS to be called after nfoServerNfo()
	 *
	 * @return mixed result.
	 */
	public function nfoServerModules()
	{
		/**
		 * Check if method is available.
		 */
		if (!function_exists('apache_get_modules'))
		{
			/**
			 * Return result.
			 */
			return array();
		}
		/**
		 * Return result.
		 */
		return apache_get_modules();
	}

	/**
	 * Server information.
	 */
	public function nfoServerInfo()
	{
		/**
		 * Return result.
		 */
		return $_SERVER;
	}

	/**
	 * Extension output.
	 *
	 * This is a special method for standalone extensions.
	 */
	public function extOut()
	{
		/**
		 * Return result.
		 */
		return $this->_extOutLayout();
	}

	/**
	 * Header styles output method.
	 *
	 * @return mixed result
	 */
	private function _extOutStyles()
	{
		/**
		 * Turn on output buffering.
		 */
		ob_start();
		?>
<style type="text/css">
html,body,table,form {
	font-size: 11px;
	font-family: Verdana;
	background: #EEE;
	color: #333;
	margin: 0;
}

a {
	color: #333;
	text-decoration: none;
}

#nfo {
	width: 982px;
	margin: 0 auto;
	padding: 0 0 10px 0;
}

#nfo .box {
	float: left;
	display: inline;
	width: 972px;
	background: #DDD;
	border: 1px dashed #333;
	margin: 10px 0 0 0;
	padding: 10px 0 10px 10px;
}

#nfo h1.rud {
	float: left;
	display: inline;
	width: 982px;
	text-align: center;
	padding: 10px 0 10px 0;
}

#nfo h2.rud {
	float: left;
	display: inline;
	width: 982px;
	background: #CCC;
	text-align: center;
	padding: 10px 0 10px 0;
	margin: 10px 0 0 0;
}

#nfo h3.rud {
	float: left;
	display: inline;
	width: 972px;
	padding: 10px 0px 10px 0px;
	margin: 0;
}

#nfo #php_info,
#nfo #php_nfo,
#nfo #php_ext,
#nfo #php_ini,
#nfo #server_nfo,
#nfo #server_info,
#nfo #server_modules
{
	float: left;
	display: inline;
	width: 972px;
}

#nfo table {
	float: left;
	display: inline;
	width: auto;
	border-collapse: collapse;
	border-top: 1px solid #AAA;
	border-right: 1px solid #AAA;
	border-bottom: 1px solid #AAA;
}

#nfo table tr {
	float: left;
	display: inline;
	width: auto;
	clear: both;
	background: #CCC;
}

#nfo table th {
	float: left;
	display: inline;
	width: auto;
	height: 30px;
	padding: 3px;
	border-left: 1px solid #AAA;
	text-transform: uppercase;
}

#nfo table td {
	float: left;
	display: inline;
	width: auto;
	min-height: 30px;
	border-top: 1px solid #AAA;
	border-left: 1px solid #AAA;
	padding: 3px;
	text-wrap: normal;
	word-wrap: break-word;
	white-space: normal;
}

#nfo .key {
	background: #CCC;
	text-align: right;
	font-weight: bold;
	width: 250px;
}

#nfo .value {
	background: #DDD;
	width: 250px;
}

#nfo table .value_small {
	background: #DDD;
	width: 60px;
}

#nfo table th {
background: #EEE !important;
text-align: center !important;
font-size: 1.1em;
}

.nfo {
	border-bottom: 1px dotted #333;
	cursor: help;
}

#php_info {
	background: #DDD;
}

#php_info div,
#php_info table,
#php_info table tr,
#php_info table th,
#php_info table td
{
float: none;
}

.right {
	float: left;
	display: inline;
	width: 962px;
	text-align: right;
	margin: 10px 0 0;
}

#menu {
	float: left;
	display: inline;
	width: 180px;
	position: fixed;
	top: 10px;
	right: 10px;
	z-index: 1;
	font-size: 10px;
	background: #DDD;
	padding: 0;
	border: 1px dashed #333;
}

#menu .toggle {
	float: left;
	display: inline;
	width: 180px;
	font-size: 11px;
	font-weight: bold;
	margin: 0;
	padding: 5px 0 5px 0;
}

#menu .toggle span {
	float: left;
	display: inline;
	width: 170px;
	margin: 0 0 0 10px;
	padding: 0;
}

#menu div.toggle ul.l1 {
	display: none;
}

#menu div.toggle:hover ul.l1 {
	float: left;
	display: inline;
	width: 170px;
	margin: 0px 0 0 10px;
	padding: 0;
	font-size: 10px;
	font-weight: bold;
}

#menu ul.l1 li.l1 {
	float: left;
	display: inline;
	width: 170px;
	list-style: none;
	margin: 5px 0 0 0;
	margin: 10px 0 0 0;
}

#menu ul.l2 {
	float: left;
	display: inline;
	width: 160px;
	margin: 0 0 0 10px;
	padding: 0;
}

#menu ul.l1 li.l2 {
	float: left;
	display: inline;
	width: 160px;
	list-style: none;
	margin: 5px 0 0 0;
}
</style>
		<?php
		/**
		 * Get parsed output result from the output buffer.
		 */
		$out = ob_get_contents();
		/**
		 * Delete output buffer and turn off output buffering.
		 */
		ob_end_clean();
		/**
		 * Return result.
		 */
		return $out;
	}

	/**
	 * Header scripts output method.
	 *
	 * @return mixed result
	 */
	private function _extOutScripts()
	{
		/**
		 * Turn on output buffering.
		 */
		ob_start();
		?>
<script type="text/javascript">
		//<![CDATA[
		function toggle(elm) {
			if( document.getElementById(elm).style.display=='none' )
			{
				document.getElementById(elm).style.display = '';
			}
			else
			{
				document.getElementById(elm).style.display = 'none';
			}
		}
		//]]>
</script>
		<?php
		/**
		 * Get parsed output result from the output buffer.
		 */
		$out = ob_get_contents();
		/**
		 * Delete output buffer and turn off output buffering.
		 */
		ob_end_clean();
		/**
		 * Return result.
		 */
		return $out;
	}

	/**
	 * Navigation menu output method.
	 *
	 * @return mixed result
	 */
	private function _extOutMenu()
	{
		/**
		 * Turn on output buffering.
		 */
		ob_start();
		?>
<div id="menu">
<div class="toggle"><span>Rudweb <?php echo $this->extAbout('name'); ?></span>
<ul class="l1">
	<li class="l1"><a href="#a_php" title="PHP Information">PHP Information</a>
	<ul class="l2">
		<li class="l2"><a href="#a_php_info" title="PHPInfo()">PHPInfo()</a></li>
		<li class="l2"><a href="#a_php_nfo" title="General Information">General
		Information</a></li>
		<li class="l2"><a href="#a_php_ext" title="Loaded Extensions">Loaded
		Extensions</a></li>
		<li class="l2"><a href="#a_php_ini" title="Loaded Extensions">PHP Ini
		Settings</a></li>
	</ul>
	</li>
	<li class="l1"><a href="#a_server" title="Server Information">Server
	Information</a>
	<ul class="l2">
		<li class="l2"><a href="#a_server_modules" title="Server Modules">Server
		Modules</a></li>
		<li class="l2"><a href="#a_server_info" title="Server Information">Server
		Information</a></li>
	</ul>
	</li>
	<li class="l1"><a href="#a_other" title="Other Information">Other
	Information</a></li>
</ul>
</div>
</div>
		<?php
		/**
		 * Get parsed output result from the output buffer.
		 */
		$out = ob_get_contents();
		/**
		 * Delete output buffer and turn off output buffering.
		 */
		ob_end_clean();
		/**
		 * Return result.
		 */
		return $out;
	}

	/**
	 * Layout output method.
	 *
	 * @retrun mixed result
	 */
	private function _extOutLayout()
	{
		/**
		 * Turn on output buffering.
		 */
		ob_start();

		echo '<?xml version="1.0" encoding="utf-8" standalone="no"?>' . "\n";
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="en"
	lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="content-language" content="en" />
<title>Rudweb <?php echo $this->extAbout('name'); ?> <?php echo $this->extAbout('ver'); ?></title>
<meta http-equiv="Content-Style-Type" content="text/css" />
		<?php echo $this->_extOutStyles(); ?>

		<?php echo $this->_extOutScripts(); ?>

</head>
<body>
<div id="nfo"><?php echo $this->_extOutMenu(); ?>

<h2 class="rud"><a name="a_php">PHP Information</a></h2>

<div class="box">
<h3 class="rud"><a class="nfo" name="a_php_info"
	href="JavaScript:toggle('php_info')">PHPInfo()</a></h3>
<div id="php_info"><?php echo $this->nfoPhpInfo(); ?>
<div class="right"><a href="JavaScript:toggle('php_info')" title="close">[close]</a></div>
</div>
</div>

<div class="box">
<h3 class="rud"><a class="nfo" name="a_php_nfo"
	href="JavaScript:toggle('php_nfo')">General information</a></h3>
<div id="php_nfo">
<table>
	<tr>
		<th class="key">name</th>
		<th class="value">value</th>
	</tr>
	<?php foreach ($this->nfoPhpNfo() as $name => $value) : ?>
	<tr>
		<td class="key"><?php echo $name; ?></td>
		<td class="value"><?php echo $value; ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<div class="right"><a href="JavaScript:toggle('php_nfo')" title="close">[close]</a></div>
</div>
</div>

<div class="box">
<h3 class="rud"><a class="nfo" name="a_php_ext"
	href="JavaScript:toggle('php_ext')">Loaded Extensions</a></h3>
<div id="php_ext">
<table>
	<tr>
		<th class="key">name</th>
		<th class="value">value</th>
	</tr>
	<?php foreach ($this->nfoPhpExt() as $name => $value) : ?>
	<tr>
		<td class="key"><?php echo $name; ?></td>
		<td class="value"><?php var_dump($value); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<div class="right"><a href="JavaScript:toggle('php_ext')" title="close">[close]</a></div>
</div>
</div>

<div class="box">
<h3 class="rud"><a class="nfo" name="a_php_ini"
	href="JavaScript:toggle('php_ini')">PHP Ini settings</a></h3>
<div id="php_ini">
<table>
	<tr>
		<th class="key">name</th>
		<th class="value">global value</th>
		<th class="value">local value</th>
		<th class="value_small">access</th>
	</tr>
	<?php foreach ($this->nfoPhpIni() as $name => $value) : ?>
	<tr>
		<td class="key"><?php echo $name; ?></td>
		<td class="value"><?php echo $value['global_value']; ?></td>
		<td class="value"><?php echo $value['local_value']; ?></td>
		<td class="value_small"><?php echo $value['access']; ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<div class="right"><a href="JavaScript:toggle('php_ini')" title="close">[close]</a></div>
</div>
</div>

<h2 class="rud"><a name="a_server">Server information</a></h2>

<div class="box">
<h3 class="rud"><a class="nfo" name="a_server_nfo"
	href="JavaScript:toggle('server_nfo')">General information</a></h3>
<div id="server_nfo">
<table>
	<tr>
		<th class="key">name</th>
		<th class="value">value</th>
	</tr>
	<?php foreach ($this->nfoServerNfo() as $name => $value) : ?>
	<tr>
		<td class="key"><?php echo $name; ?></td>
		<td class="value"><?php echo $value; ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<div class="right"><a href="JavaScript:toggle('server_nfo')"
	title="close">[close]</a></div>
</div>
</div>

<div class="box">
<h3 class="rud"><a class="nfo" name="a_server_modules"
	href="JavaScript:toggle('server_modules')">Server modules:</a></h3>
<div id="server_modules">
<table>
	<tr>
		<th class="key">name</th>
		<th class="value">value</th>
	</tr>
	<?php foreach ($this->nfoServerModules() as $id => $name) : ?>
	<tr>
		<td class="key"><?php echo $name; ?></td>
		<td class="value">&#160;</td>
	</tr>
	<?php endforeach; ?>
</table>
<div class="right"><a href="JavaScript:toggle('server_modules')"
	title="close">[close]</a></div>
</div>
</div>

<div class="box">
<h3 class="rud"><a class="nfo" name="a_server_info"
	href="JavaScript:toggle('server_info')">Server info:</a></h3>
<div id="server_info">
<table>
	<tr>
		<th class="key">name</th>
		<th class="value">value</th>
	</tr>
	<?php foreach ($this->nfoServerInfo() as $name => $value) : ?>
	<tr>
		<td class="key"><?php echo $name; ?></td>
		<td class="value"><?php echo $value; ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<div class="right"><a href="JavaScript:toggle('server_info')"
	title="close">[close]</a></div>
</div>
</div>

<h2 class="rud"><a name="a_other">Other Information that might be useful</a></h2>

<script type="text/javascript">
		//<![CDATA[
		toggle('php_info');
		toggle('php_nfo');
		toggle('php_ext');
		toggle('php_ini');
		toggle('server_nfo');
		toggle('server_modules');
		toggle('server_info');
		//]]>
		</script></div>
</body>
</html>
	<?php
	/**
	 * Get parsed output result from the output buffer.
	 */
	$out = ob_get_contents();
	/**
	 * Delete output buffer and turn off output buffering.
	 */
	ob_end_clean();
	/**
	 * Return result.
	 */
	return $out;
	}
}
?>