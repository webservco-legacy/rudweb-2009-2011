<?php
/**
 * $Id$
 *
 * Engine core library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @category   RudWEb
 * @package    RudWEb
 * @subpackage RudCore
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
 * Core
 *
 * Core library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudCore
 *
 */
class Core
{
	/**
	 * Stores configuration object.
	 *
	 * @var mixed
	 */
	protected static $_msCfgObject;

	/**
	 * Method to acces the configuration object from everywhere.
	 *
	 * @return object
	 */
	public static function Cfg()
	{
		/**
		 * Check if object is not set.
		 */
		if ( self::$_msCfgObject == NULL )
		{
			/**
			 * Get object instance and set it.
			 */
			self::$_msCfgObject = Cfg::GetInstance( 'Cfg' );
		}

		/**
		 * Return object.
		 */
		return self::$_msCfgObject;
	}
}
?>