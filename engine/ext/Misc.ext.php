<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Misc methods that might be useful.
 * <BR>This extension must not have any dependencies.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-02-06 15:19:00
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
	 * Display "Not Found" page.
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * Extension name.
 */
$extAbout['Misc']['name'] = 'Misc';
/**
 * Extension description.
 */
$extAbout['Misc']['desc'] = 'Misc methods that might be useful.';
/**
 * Extension version.
 */
$extAbout['Misc']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Misc']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Misc']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Misc']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Misc']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Misc']['deps']['lib'] = array();
/**
 * Extension extension dependencies.
 */
$extAbout['Misc']['deps']['ext'] = array();

/**
 * rw_Extension_Misc.
 *
 * rw_Extension_Misc extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Misc extends rw_Extension implements rw_iExtension
{
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
	 * Return a string produced according to the formatting string format.
	 *
	 * This is based on sprintf, except it can work with arrays.
	 *
	 * $string must be in the form of "Hello %0%, welcome %1%", etc
	 * $var can be a string or an array in the form array('%0%'=>'world', '%1%'=>'back').
	 *
	 * @param string $str input string
	 * @param mixed $var arguments
	 * @return string result
	 */
	public function rwSprintf($str, $var)
	{
		/**
		 * Check if $var is a string or an array.
		 * Return result.
		 */
		return (is_array($var)) ? str_replace(array_keys($var), array_values($var), $str) : str_replace('%0%', $var, $str);
	}

	/**
	 * Return a short string based on a long string.
	 *
	 * If can work with character limit, word limit, or both.
	 *
	 * Eg. get max 80 characters: rwShortString($string, 80)
	 * Eg. get max 10 words: rwShortString($string, NULL, 10)
	 * Eg. get max 80 characters but no more than 10 words: rwShortString($string, 80, 10)
	 *
	 * @param string $string initial string
	 * @param mixed $chars character limit
	 * @param mixed $words word limit
	 * @param string $add what to add after the string
	 * @return mixed result
	 */
	public function rwShortString($string, $chars=NULL, $words=NULL, $add=' ...')
	{
		/**
		 * Initialize string.
		 */
		$data = $string;
		/**
		 * Check string length
		 */
		if(strlen($string) <= $chars)
		{
			/**
			 * Return unmodified string.
			 */
			return $data;
		}
		/**
		 * Check for character limit.
		 */
		if($chars)
		{
			/**
			 * Set raw string.
			 *
			 * Chop it off at chars limit.
			 */
			$raw = substr($string, 0, $chars);
			/**
			 * Set new string.
			 */
			$data = substr($raw, 0, strrpos($raw, ' ')).$add;
		}
		/**
		 * Check if we have words limit.
		 */
		if($words)
		{
			$raw = str_word_count($data, 2, ',.!');
			/**
			 * Set new string.
			 */
			$data = implode(' ', array_slice($raw, 0, $words));
		}
		/**
		 * Return result.
		 */
		return $data;
	}
}
?>