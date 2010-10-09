<?php
/**
 * $Id$
 *
 * Engine base library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
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
	 * @return object
	 */
	public static function GetInstance()
	{
		/**
		 * Get name of the class to instantiate.
		 *
		 * @var string
		 */
		$class_name = get_called_class();

		/**
		 * Check if requested instance is the base library.
		 */
		if ( __CLASS__ == $class_name )
		{
			/**
			 * Stop.
			 */
			return FALSE;
		}

		/**
		 * Check that instance is not already set.
		 */
		if ( !isset( self::$_msInstance[$class_name] ) )
		{
			/**
			 * Set object instance.
			 */
			self::$_msInstance[$class_name] = new $class_name();
		}

		/**
		 * Return object instance.
		 */
		return self::$_msInstance[$class_name];
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