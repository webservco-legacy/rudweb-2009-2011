<?php
/**
 * $Id$
 *
 * Router library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudRouter
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
 * Router library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudRouter
 *
 */
class Router extends Library
{
	/**
	 * Remove fake extension from request.
	 *
	 * @param string $request
	 */
	public function RemoveFakeExtension( $request )
	{
		/**
		 * @var string
		 */
		$extension = Core::Cfg()->Get( 'seo.extension' );

		/**
		 * @var bool
		 */
		$check = Core::String()->EndsWith( $extension, $request );

		/**
		 * Check if request ends with the fake extension.
		 */
		if ( ( '' != $extension ) && ( FALSE !== $check ) )
		{
			return str_replace( $extension, '', $request );
		}

		return $request;
	}
}
?>