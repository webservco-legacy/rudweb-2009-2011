<?php
/**
 * $Id$
 *
 * Engine core library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
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
	protected static $_msConfigObject;

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
	 * Stores the database object.
	 *
	 * @var mixed
	 */
	protected static $_msDbObject;

	/**
	 * Stores the String object.
	 *
	 * @var mixed
	 */
	protected static $_msStringObject;

	/**
	 * Stores the Security object.
	 *
	 * @var mixed
	 */
	protected static $_msSecurityObject;

	/**
	 * Stores the Router object.
	 *
	 * @var mixed
	 */
	protected static $_msRouterObject;

	/**
	 * Stores the Acl object.
	 *
	 * @var mixed
	 */
	protected static $_msAclObject;

	/**
	 * Stores the User object.
	 *
	 * @var unknown_type
	 */
	protected static $_msUserObject;

	/**
	 * Method to acces the configuration object from everywhere.
	 *
	 * @return object
	 */
	final public static function Config()
	{
		if ( NULL == self::$_msConfigObject )
		{
			/**
			 * @var object
			 */
			self::$_msConfigObject = Config::GetInstance();
		}

		return self::$_msConfigObject;
	}

	/**
	 * Method to access the error handling object from everywhere.
	 *
	 * @return object
	 */
	final public static function Error()
	{
		if ( NULL == self::$_msErrorObject )
		{
			/**
			 * @var object
			 */
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
		if ( NULL == self::$_msI18nObject )
		{
			/**
			 * @var object
			 */
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
		if ( NULL == self::$_msLogObject )
		{
			/**
			 * @var object
			 */
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
		if ( NULL == self::$_msAppObject )
		{
			/**
			 * @var object
			 */
			self::$_msAppObject = App::GetInstance();
		}

		return self::$_msAppObject;
	}

	/**
	 * Method to access the database object from everywhere.
	 *
	 * @return object
	 */
	final public static function Database()
	{
		if ( NULL == self::$_msDbObject )
		{
			/**
			 * @var string
			 */
			$db_type = self::Config()->Get( 'db.type' );

			if ( FALSE !== strpos( $db_type, '_' ) )
			{
				/**
				 * @var array
				 */
				$parts = explode( '_', $db_type );

				/**
				 * @var string
				 */
				$db_type = $parts[1];
			}

			/**
			 * @var string
			 */
			$db_class = 'Database_' . ucfirst( strtolower( $db_type ) );

			/**
			 * Load the appropriate database library.
			 *
			 * PHP < 5.3 compatibility.
			 * self::$_msDbObject = $db_class::GetInstance( $db_class );
			 *
			 * @var object
			 */
			self::$_msDbObject = call_user_func( array( $db_class, 'GetInstance' ), $db_class );
		}

		return self::$_msDbObject;
	}

	/**
	 * Method to access the String object from everywhere.
	 *
	 * @return object
	 */
	final public static function String()
	{
		if ( NULL == self::$_msStringObject )
		{
			/**
			 * @var object
			 */
			self::$_msStringObject = String::GetInstance();
		}

		return self::$_msStringObject;
	}

	/**
	 * Method to access the Security object from everywhere.
	 *
	 * @return object
	 */
	final public static function Security()
	{
		if ( NULL == self::$_msSecurityObject )
		{
			/**
			 * @var object
			 */
			self::$_msSecurityObject = Security::GetInstance();
		}

		return self::$_msSecurityObject;
	}

	/**
	 * Method to access the Router object from everywhere.
	 *
	 * @return object
	 */
	final public static function Router()
	{
		if ( NULL == self::$_msRouterObject )
		{
			/**
			 * @var object
			 */
			self::$_msRouterObject = Router::GetInstance();
		}

		return self::$_msRouterObject;
	}

	/**
	 * Method to access the Acl object from everywhere.
	 *
	 * @return object
	 */
	final public static function Acl()
	{
		if ( NULL == self::$_msAclObject )
		{
			/**
			 * @var object
			 */
			self::$_msAclObject = Router::GetInstance();
		}

		return self::$_msAclObject;
	}

	/**
	 * Method to access the User object from anywhere.
	 *
	 * @return object
	 */
	final public static function User()
	{
		if ( NULL == self::$_msUserObject )
		{
			/**
			 * @var object
			 */
			self::$_msUserObject = self::Get( 'Object_User' );
		}

		return self::$_msUserObject;
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
		$base = array ( Core::Config()->Get( 'path.core' ) );

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
					$base = array (	Core::Config()->Get( 'path.core' ) );
					/**
					 * @var string
					 */
					$path = Core::Config()->Get( 'dir.core.int' ) . '/';
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
					$base = array (	Core::Config()->Get( 'path.core' ) );
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
					$base = array (	Core::Config()->Get( 'path.app' ) );
					/**
					 * @var string
					 */
					$path = Core::Config()->Get( 'dir.app.mod' ) . '/';
					/**
					 * @var string
					 */
					$dir = $name . '/';
					/**
					 * @var string
					 */
					$type = 'mod';

					break;

				case 'Object' :
					/**
					 * @var array
					 */
					$base = array (
					Core::Config()->Get( 'path.app' ) . Core::Config()->Get( 'dir.app.obj' ),
					Core::Config()->Get( 'path.core' ) . Core::Config()->Get( 'dir.core.obj' ),
					);
					/**
					 * @var string
					 */
					$path = '/';
					/**
					 * @var string
					 */
					$dir = $name . '/';
					/**
					 * @var string
					 */
					$type = 'obj';

					break;

				case 'Controller' :
					/**
					 * We must have a third part in the raw name.
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
					$base = array (	Core::Config()->Get( 'path.app' ) );
					/**
					 * @var string
					 */
					$path = Core::Config()->Get( 'dir.app.ctrl' ) . '/';
					/**
					 * @var string
					 */
					$dir = $parts[1] . '/';
					/**
					 * @var string
					 */
					$type = 'ctrl';

					break;

				case 'Output' :
					/**
					 * @var array
					 */
					$base = array (	Core::Config()->Get( 'path.core' ) );
					/**
					 * @var string
					 */
					$path = 'lib/';
					/**
					 * @var string
					 */
					$dir = 'Output/';
					/**
					 * @var string
					 */
					$type = 'lib';

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
		}

		/**
		 * Class file not found.
		 */
		return FALSE;
	}

	/**
	 * Wrapper for loading and instantiating a library type object.
	 *
	 * @param string $libraryName
	 *
	 * @return mixed
	 */
	final public static function Get( $libraryName )
	{
		self::Load( $libraryName );

		$parts = explode( '_', $libraryName );

		$libary_name = end( $parts );

		if( !class_exists( $libary_name ) )
		{
			/**
			 * @var string
			 */
			$err_msg = sprintf( __( 'Core Library: Class "%s" not found.', 'RudWEb' ), $libary_name );

			trigger_error( $err_msg, 256 );
		}

		return call_user_func( array( $libary_name, 'GetInstance' ), $libary_name );
	}
}
?>