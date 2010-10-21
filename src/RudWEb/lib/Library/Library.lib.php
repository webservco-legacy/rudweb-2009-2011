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
 * @subpackage RudLibrary
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
 * @subpackage RudLibrary
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

			if ( function_exists( '__' ) )
			{
				/**
				 * @var string
				 */
				$inst_msg = sprintf(
				__( '%s library: Loading.', 'RudWEb' ),
				$class_name
				);

				Core::Log()->Write( $inst_msg, 'debug' );
			}

			/**
			 * Load object configuration.
			 */
			self::$_msInstance[$class_name]->LoadConfig();
		}

		/**
		 * Return object instance.
		 */
		return self::$_msInstance[$class_name];
	}

	/**
	 * Load configuration file for current library.
	 *
	 * @return bool
	 */
	public function LoadConfig()
	{
		/**
		 * @var string
		 */
		$class_name = get_called_class();

		/**
		 * @var string
		 */
		$config_name = 'lib.' . strtolower( str_replace( '_', '.', $class_name )) . '.cfg';

		/**
		 * @var string
		 */
		$path_app = Core::Config()->Get( 'path.app' );

		/**
		 * @var string
		 */
		$config_file =  $path_app . 'etc/' . $config_name . '.xml';

		if ( !is_readable( $config_file ) )
		{
			if ( function_exists( '__' ) )
			{
				/**
				 * @var string
				 */
				$config_msg = sprintf(
				__( '%s library: Skipping configuration file "%s" (not found).', 'RudWEb' ),
				$class_name,
				$config_name
				);

				Core::Log()->Write( $config_msg, 'debug' );
			}


			return FALSE;
		}

		if ( function_exists( '__' ) )
		{
			/**
			 * @var string
			 */
			$config_msg = sprintf(
			__( '%s library: Loading configuration file "%s".', 'RudWEb' ),
			$class_name,
			$config_name
			);

			Core::Log()->Write( $config_msg, 'debug' );
		}

		return Core::Config()->Set( $config_file );
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