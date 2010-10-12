<?php
/**
 * $Id$
 *
 * Application library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudApp
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
 * App
 *
 * Application library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudApp
 *
 */
class App extends Library
{

	public function Boot()
	{
		/**
		 * Load main configuration settings.
		 */
		$this->InitConfig();

		/**
		 * Initialize internationalization library.
		 */
		Core::I18n()->Init('ro_RO');

		/**
		 * Initialize application logging.
		 */
		$this->InitLog();
		
		/**
		 * It was not possible to write to log until now, so we update with all the messages.
		 */
		
		Core::Log()->Write( __( 'Application boot.' ), 'debug' );

		Core::Log()->Write( __( 'Core library loaded.' ), 'debug' );

		Core::Log()->Write( __( 'Cfg library loaded.' ), 'debug' );

		Core::Log()->Write( __( 'Configuration settings loaded.' ), 'debug' );

		Core::Log()->Write( __( 'I18n library loaded.' ), 'debug' );

		Core::Log()->Write( __( 'Log library loaded.' ), 'debug' );

		/**
		 * Initialize error handling and reporting  library.
		 */
		Core::Error()->Load();

		try
		{
			Core::Sanitizer()->Sanitize();
			
			//XXX

		}
		catch ( ErrorException $e )
		{
			Core::Error()->Report( $e );
		}

		return TRUE;
	}

	/**
	 * Load main configuration settings.
	 *
	 * @return bool
	 */
	public function InitConfig()
	{
		/**
		 * @var string
		 */
		$path_core = Core::Cfg()->Get( 'path.core' );

		/**
		 * @var string
		 */
		$path_app = Core::Cfg()->Get( 'path.app' );

		/**
		 * Set core directories.
		 */
		Core::Cfg()->Set( $path_core . 'etc/dir.cfg.xml' );

		/**
		 * Set application directories.
		 */
		Core::Cfg()->Set( $path_app . 'etc/dir.cfg.xml' );

		/**
		 * Set application log settings.
		 */
		Core::Cfg()->Set( $path_app . 'etc/log.cfg.xml' );

		/**
		 * Set application database settings.
		 */
		Core::Cfg()->Set( $path_app . 'etc/db.cfg.xml' );

		return TRUE;
	}

	/**
	 * Initialize application logging.
	 *
	 * @return bool
	 */
	public function InitLog()
	{
		/**
		 * Get log file path.
		 *
		 * @var string
		 */
		$log_path = Core::Cfg()->Get( 'path.app' ) . Core::Cfg()->Get( 'dir.app.var' ) . '/log/';

		/**
		 * Set log file path.
		 */
		Core::Log()->SetPath( $log_path );

		/**
		 * Set logging level.
		 */
		Core::Log()->SetLevel( Core::Cfg()->Get( 'log.level' ) );

		/**
		 * Truncate log file.
		 */
		Core::Log()->Reset();

		return TRUE;
	}

	/**
	 * Shutdown application.
	 *
	 * @return bool
	 */
	public function Shutdown()
	{
		/**
		 * Restore default error handler.
		 */
		Core::Error()->Unload();

		Core::Log()->Write( __( 'Error library unloaded.' ), 'debug' );

		Core::Log()->Write( __( 'Application shutdown.' ), 'debug' );

		return TRUE;

	}
}
?>