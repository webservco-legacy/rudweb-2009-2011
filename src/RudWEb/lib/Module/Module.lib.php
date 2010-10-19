<?php
/**
 * $Id$
 *
 * Module library.
 *
 * All modules extend this library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudMod
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
 * @subpackage RudMod
 *
 */
class Module extends Library
{

	/**
	 * Load configuration file for current library.
	 *
	 * This also loads the i18n files.
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
		 * Handle module i18n
		 */
		Core::I18n()->Add( $class_name );
		Core::I18n()->Load( $class_name );

		/**
		 * @var array
		 */
		$parts = explode( '_', $class_name );

		/**
		 * @var string
		 */
		$module_name = array_key_exists( 1, $parts ) ? $parts[1] : $parts[0];

		/**
		 * @var string
		 */
		$path_app = Core::Cfg()->Get( 'path.app' );

		/**
		 * @var string
		 */
		$cfg_file =  $path_app . 'etc/mod.' . strtolower( $module_name ) . '.cfg.xml';

		if ( !is_readable( $cfg_file ) )
		{
			return FALSE;
		}

		return Core::Cfg()->Set( $cfg_file );
	}
}
?>