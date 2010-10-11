<?php
/**
 * $Id$
 *
 * String library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudString
 * @version    $Revision$
 * @since      Version 5
 * @access     public
 * @filesource
 */

/**
 * Security check.
 */
if ( !defined( '_RUDWEB' ) )
{
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * String library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudString
 *
 */
class String extends Library
{
	/**
	 * Check if haystack ends with needle.
	 *
	 * @param string $needle
	 * @param string $haystack
	 *
	 * @return bool
	 */
	public function EndsWith( $needle, $haystack )
	{
		/**
		 * Check if multybyte function is available.
		 *
		 * @var string
		 */
		$f_substr = ( function_exists( 'mb_substr' ) ) ? 'mb_substr' : 'substr';

		/**
		 * Check if multybyte function is available.
		 *
		 * @var string
		 */
		$f_strlen = ( function_exists( 'mb_strlen' ) ) ? 'mb_strlen' : 'strlen';

		/**
		 * @var string
		 */
		$check = $f_substr($haystack, $f_strlen( $haystack ) - ( $f_strlen( $needle ) ) );

		return $check == $needle;
	}
}
?>