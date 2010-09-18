<?php
/**
 * $Id$
 *
 * Engine base library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @category   RudWEb
 * @package    RudWEb
 * @subpackage RudLib
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
 * Library
 *
 * Base library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudLib
 *
 */
abstract class Library
{
	/**
	 * Stores object instances.
	 *
	 * @var array
	 */
	protected static $_msInstance = array();

	/**
	 * Get object instance
	 *
	 * @param string $className classname
	 *
	 * @return object
	 */
	public static function GetInstance( $className )
	{
		/**
		 * Check thatinstance is not already set.
		 */
		if ( !isset( self::$_msInstance[$className] ) )
		{
			/**
			 * Set object instance.
			 */
			self::$_msInstance[$className] = new $className();
		}

		/**
		 * Return object instance.
		 */
		return self::$_msInstance[$className];
	}

	/**
	 * Avoid normal class loading.
	 */
	final private function __construct()
	{

	}

	/**
	 * Avoid class cloning.
	 */
	final private function __clone()
	{

	}
}
?>