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
	 * Stores the internationalization object.
	 *
	 * @var mixed
	 */
	protected static $_msI18nObject;

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
	final public static function Cfg()
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
	final public static function Error()
	{
		if ( self::$_msErrorObject == NULL )
		{
			self::$_msErrorObject = Error::GetInstance();
		}

		return self::$_msErrorObject;
	}

	/**
	 * Method to access the internationalization object from everywhere.
	 *
	 * @return object
	 */
	final public static function I18n()
	{
		if ( self::$_msI18nObject == NULL )
		{
			self::$_msI18nObject = I18n::GetInstance();
		}

		return self::$_msI18nObject;
	}

	/**
	 * Method to access the logging object from everywhere.
	 *
	 * @return object
	 */
	final public static function Log()
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
	final public static function Load( $className )
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
		$parts = explode( '_', $className );

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
		 * Complete class path.
		 *
		 * @var string
		 */
		$class_path = $path . $dir . $name . '.' . $type . '.php';

		/**
		 * Each class can have an utilities file associated with it.
		 *
		 * Utilities files should only contain procedural functions.
		 *
		 * @var string
		 */
		$class_utils_path = $path . $dir . $name . 'Utils.' . $type . '.php';

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
				require_once $base_path . $class_path;

				/**
				 * Check if we have an utilities file.
				 *
				 * We only load it if the class file was loaded successfully.
				 */
				if ( is_readable( $base_path . $class_utils_path ) )
				{
					require_once $base_path . $class_utils_path;
				}

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