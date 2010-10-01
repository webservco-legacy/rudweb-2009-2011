<?php
/**
 * $Id$
 *
 * Engine core library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
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
	 * Stores the error handling object.
	 *
	 * @var mixed
	 */
	protected static $_msErrorObject;

	/**
	 * Stores the logging object.
	 *
	 * @var mixed
	 */
	protected static $_msLogObject;

	/**
	 * Method to acces the configuration object from everywhere.
	 *
	 * @return object
	 */
	public static function Cfg()
	{
		if ( self::$_msCfgObject == NULL )
		{
			self::$_msCfgObject = Cfg::GetInstance();
		}

		return self::$_msCfgObject;
	}

	/**
	 * Method to access the error handling object from everywhere.
	 *
	 * @return object
	 */
	public static function Error()
	{
		if ( self::$_msErrorObject == NULL )
		{
			self::$_msErrorObject = Error::GetInstance();
		}

		return self::$_msErrorObject;
	}

	/**
	 * Method to access the logging object from everywhere.
	 *
	 * @return object
	 */
	public static function Log()
	{
		if ( self::$_msLogObject == NULL )
		{
			self::$_msLogObject = Log::GetInstance();
		}

		return self::$_msLogObject;
	}

	/**
	 * Load classes.
	 *
	 * @param string $ClassName full class name
	 */
	public static function Load( $ClassName )
	{
		/**
		 * Base search paths.
		 *
		 * @var array
		 */
		$base = array (
		Core::Cfg()->Get( 'path.core' ),
		);

		/**
		 * Class path.
		 *
		 * @var string
		 */
		$path = 'lib/';

		/**
		 * Class parts
		 *
		 * @var array
		 */
		$parts = explode( '_', $ClassName );

		/**
		 * Class name.
		 *
		 * @var string
		 */
		$name = $parts[0];

		/**
		 * Class  directory.
		 *
		 * @var string
		 */
		$dir  = strtolower( $name ) . '/';

		/**
		 * Class type.
		 *
		 * @var string
		 */
		$type = 'lib';

		/**
		 * Complete clas path.
		 *
		 * @var string
		 */
		$class_path = $path . $dir . $name . '.' . $type . '.php';

		/**
		 * Iterate through base search paths.
		 */
		foreach ( $base as $base_path )
		{
			/**
			 * Check if class file is readable.
			 */
			if ( is_readable( $base_path . $class_path ) )
			{
				/**
				 * Load class file.
				 */
				require_once $base_path . $class_path;

				/**
				 * Stop.
				 */
				return TRUE;
			}

			/**
			 * Can't find class file.
			 */
			return FALSE;
		}

		/**
		 * Stop.
		 */
		return FALSE;
	}
}
?>