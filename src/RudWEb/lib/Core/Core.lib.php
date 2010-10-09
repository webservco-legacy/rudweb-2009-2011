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
	 * Stores the application object.
	 *
	 * @var mixed
	 */
	protected static $_msAppObject;

	/**
	 * Stores the URL object.
	 *
	 * @var mixed
	 */
	protected static $_msUrlObject;

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
	 * Method to access the application object from everywhere.
	 *
	 * @return object
	 */
	final public static function App()
	{
		if ( self::$_msAppObject == NULL )
		{
			self::$_msAppObject = App::GetInstance();
		}

		return self::$_msAppObject;
	}

	/**
	 * Method to access the URL object from everywhere.
	 *
	 * @return object
	 */
	final public static function Url()
	{
		if ( self::$_msUrlObject == NULL )
		{
			self::$_msUrlObject = Url::GetInstance();
		}

		return self::$_msUrlObject;
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
		$base = array ( Core::Cfg()->Get( 'path.core' ) );

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
		$dir  = $name . '/';

		/**
		 * Class type.
		 *
		 * @var string
		 */
		$type = 'lib';

		/**
		 * Check if we have at leat 2 parts.
		 */
		if ( array_key_exists( 1, $parts ) )
		{
			/**
			 * @var string
			 */
			$name = $parts[1];

			/**
			 * First part must contain class type.
			 */
			switch ( $parts[0] )
			{
				case 'Interface' :
					/**
					 * @var array
					 */
					$base = array (	Core::Cfg()->Get( 'path.core' ) );
					/**
					 * @var string
					 */
					$path = Core::Cfg()->Get( 'dir.core.int' ) . '/';
					/**
					 * @var string
					 */
					$dir = $name . '/';
					/**
					 * @var string
					 */
					$type = 'int';

					break;

				case 'Database' :

					/**
					 * @var array
					 */
					$base = array (	Core::Cfg()->Get( 'path.core' ) );
					/**
					 * @var string
					 */
					$path = 'lib/';
					/**
					 * @var string
					 */
					$dir = 'Database/';
					/**
					 * @var string
					 */
					$type = 'lib';

					break;

				case 'Module' :
					/**
					 * @var array
					 */
					$base = array (	Core::Cfg()->Get( 'path.app' ) );
					/**
					 * @var string
					 */
					$path = Core::Cfg()->Get( 'dir.app.mod' ) . '/';
					/**
					 * @var string
					 */
					$dir = $name . '/';
					/**
					 * @var string
					 */
					$type = 'mod';

					break;

				case 'Controller' :
					/**
					 * We must have a thrird part in the raw name.
					 */
					if ( !array_key_exists( 1, $parts ) )
					{
						break;
					}
					/**
					 * @var string
					 */
					$name = $parts[2];
					/**
					 * @var array
					 */
					$base = array (	Core::Cfg()->Get( 'path.app' ) );
					/**
					 * @var string
					 */
					$path = Core::Cfg()->Get( 'dir.app.ctrl' ) . '/';
					/**
					 * @var string
					 */
					$dir = $parts[1] . '/';
					/**
					 * @var string
					 */
					$type = 'ctrl';

					break;

				default :

					$dir = $name . '/';

					break;
			}
		}

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