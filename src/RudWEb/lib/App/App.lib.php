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
	/**
	 * Stores the final parsed request.
	 *
	 * @var array
	 */
	private $_mRequest;

	public function Boot()
	{
		/**
		 * Load main configuration settings.
		 */
		$this->_InitConfig();

		/**
		 * Initialize internationalization library.
		 */
		Core::I18n()->Init('ro_RO');

		/**
		 * Initialize application logging.
		 */
		$this->_InitLog();

		/**
		 * It was not possible to write to log until now, so we update with all the messages.
		 */

		Core::Log()->Write( __( 'Application: booting.' ), 'debug' );

		Core::Log()->Write( __( 'Core library: loading.' ), 'debug' );

		Core::Log()->Write( __( 'Cfg library: loading.' ), 'debug' );

		Core::Log()->Write( __( 'Cfg library: Configuration settings loaded.' ), 'debug' );

		Core::Log()->Write( __( 'I18n library: loading.' ), 'debug' );

		Core::Log()->Write( __( 'Log library: loading.' ), 'debug' );

		/**
		 * Initialize error handling and reporting  library.
		 */
		Core::Error()->Load();

		try
		{
			/**
			 * Sanitize requests.
			 *
			 * @var array
			 */
			Core::Sanitizer()->Sanitize();

			/**
			 * Perform routing.
			 *
			 * @var array
			 */
			$this->_mRequest = Core::Router()->Route();

			Core::Log()->Write( __( 'Application: booting complete.' ), 'debug' );

			return TRUE;
		}
		catch ( ErrorException $e )
		{
			Core::Error()->Report( $e );
		}

		Core::Log()->Write( __( 'Application: booting failed.' ), 'debug' );

		return FALSE;
	}

	/**
	 * Run application.
	 *
	 * @return bool
	 */
	public function Run()
	{
		Core::Log()->Write( __( 'Application: running dispatcher.' ), 'debug' );

		echo '<pre>';
		print_r( $this->_mRequest );
		echo '</pre>';
		echo '<hr />';

		$hello = Controller_Helloworld_Hello::GetInstance();

		$hello_world = Module_Helloworld::GetInstance();

		echo $hello->World();

		echo $hello_world->HelloWorld();

		//XXX dispatch


		Core::Log()->Write( __( 'Application: dispatcher done.' ), 'debug' );

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

		Core::Log()->Write( __( 'Error library: unloading.' ), 'debug' );

		Core::Log()->Write( __( 'Application: shutdown.' ), 'debug' );

		return TRUE;

	}

	/**
	 * Load main configuration settings.
	 *
	 * @return bool
	 */
	protected function _InitConfig()
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
	protected function _InitLog()
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
}
?>