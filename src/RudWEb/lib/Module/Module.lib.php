<?php
/**
 * $Id$
 *
 * Module library.
 *
 * All modules extend this library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudModule
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
 * Module library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudModule
 *
 */
class Module extends Library
{
	/**
	 * Implement GetInstance() method.
	 *
	 * This is required for PHP < 5.3 compatibility ( no late static binding )
	 *
	 * @param string $className class name to instantiate
	 *
	 * @return object
	 */
	public static function GetInstance( $className = __CLASS__ )
	{
		/**
		 * Call parent method with current class name as parameter.
		 */
		return parent::_GetInstance( $className );
	}

	/**
	 * Load configuration file for current library.
	 *
	 * Needs to override the Library method.
	 * This also loads the i18n files.
	 *
	 * @param string $className name of the class to load configuration for
	 *
	 * @return bool
	 */
	protected  function _LoadConfig( $className )
	{
		/**
		 * Handle module i18n
		 */
		Core::I18n()->Add( $className );
		Core::I18n()->Load( $className );

		/**
		 * @var array
		 */
		$parts = explode( '_', $className );

		/**
		 * @var string
		 */
		$module_name = array_key_exists( 1, $parts ) ? $parts[1] : $parts[0];

		/**
		 * @var string
		 */
		$path_app = Core::Config()->Get( 'path.app' );

		/**
		 * @var string
		 */
		$cfg_file =  $path_app . 'etc/mod.' . strtolower( $module_name ) . '.cfg.xml';

		if ( !is_readable( $cfg_file ) )
		{
			return FALSE;
		}

		return Core::Config()->Set( $cfg_file );
	}
}
?>