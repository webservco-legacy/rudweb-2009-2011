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
		Core::I18n()->Init( Core::Config()->Get( 'i18n.locale' ) );

		/**
		 * Initialize application logging.
		 */
		$this->_InitLog();

		/**
		 * It was not possible to write to log until now, so we update with all the messages.
		 */

		Core::Log()->Write( __( 'Application: Booting.', 'RudWEb' ), 'debug' );

		Core::Log()->Write( __( 'Core library: Loading.', 'RudWEb' ), 'debug' );

		Core::Log()->Write( __( 'Config library: Loading.', 'RudWEb' ), 'debug' );

		Core::Log()->Write( __( 'Config library: Configuration settings loaded.', 'RudWEb' ), 'debug' );

		Core::Log()->Write( __( 'I18n library: Loading.', 'RudWEb' ), 'debug' );

		Core::Log()->Write( __( 'Log library: Loading.', 'RudWEb' ), 'debug' );

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

			Core::Log()->Write( __( 'Application: Booting complete.', 'RudWEb' ), 'debug' );

			return TRUE;
		}
		catch ( ErrorException $e )
		{
			Core::Error()->Report( $e );
		}

		Core::Log()->Write( __( 'Application: Booting failed.', 'RudWEb' ), 'debug' );

		return FALSE;
	}

	/**
	 * Run application.
	 *
	 * @return bool
	 */
	public function Run()
	{
		try
		{
			Core::Log()->Write( __( 'Application: Running dispatcher.', 'RudWEb' ), 'debug' );

			/**
			 * @var string
			 */
			$module_name = $this->_mRequest['module'];

			if ( !class_exists( $module_name ) )
			{
				/**
				 * @var string
				 */
				$module_msg = sprintf(
				__( 'Application: Module "%s" not found.', 'RudWEb' ),
				$module_name
				);

				trigger_error( $module_msg, 256 );
			}

			/**
			 * @var object
			 */
			$module_object = $module_name::GetInstance();

			/**
			 * @var string
			 */
			$ctrl_name = $this->_mRequest['controller'];

			if ( !class_exists( $ctrl_name ) )
			{
				/**
				 * @var string
				 */
				$ctrl_msg = sprintf(
				__( 'Application: Controller "%s" not found.', 'RudWEb' ),
				$ctrl_name
				);

				trigger_error( $ctrl_msg, 256 );
			}

			/**
			 * @var object
			 */
			$ctrl_object = $ctrl_name::GetInstance();

			/**
			 * @var string
			 */
			$action_name = $this->_mRequest['action'];

			if (
			!method_exists( $ctrl_object, $action_name ) ||
			!is_callable( array( $ctrl_object, $action_name ) )
			)
			{
				/**
				 * @var string
				 */
				$action_msg = sprintf(
				__( 'Application: Action "%s" not found.', 'RudWEb' ),
				$action_name
				);

				trigger_error( $action_msg, 256 );
			}

			/**
			 * @var string
			 */
			$dispatch_msg = sprintf(
			__( 'Application: Calling action "%s" from "%s" ("%s").', 'RudWEb' ),
			$action_name,
			$ctrl_name,
			$module_name
			);

			Core::Log()->Write( $dispatch_msg , 'debug' );

			return $ctrl_object->$action_name();
		}
		catch ( ErrorException $e )
		{
			Core::Error()->Report( $e );
		}

		return FALSE;
	}

	/**
	 * Shutdown application.
	 *
	 * @return bool
	 */
	public function Shutdown()
	{
		Core::Log()->Write( __( 'Application: Dispatcher done.', 'RudWEb' ), 'debug' );

		/**
		 * Restore default error handler.
		 */
		Core::Error()->Unload();

		Core::Log()->Write( __( 'Application: Shutdown.', 'RudWEb', 'RudWEb' ), 'debug' );

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
		$path_core = Core::Config()->Get( 'path.core' );

		/**
		 * @var string
		 */
		$path_app = Core::Config()->Get( 'path.app' );

		/**
		 * Set core directories.
		 */
		Core::Config()->Set( $path_core . 'etc/dir.cfg.xml' );

		/**
		 * Set application directories.
		 */
		Core::Config()->Set( $path_app . 'etc/dir.cfg.xml' );

		/**
		 * Set application database settings.
		 */
		Core::Config()->Set( $path_app . 'etc/db.cfg.xml' );

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
		$log_path = Core::Config()->Get( 'path.app' ) . Core::Config()->Get( 'dir.app.var' ) . '/log/';

		/**
		 * Set log file path.
		 */
		Core::Log()->SetPath( $log_path );

		/**
		 * Set logging level.
		 */
		Core::Log()->SetLevel( Core::Config()->Get( 'log.level' ) );

		/**
		 * Truncate log file.
		 */
		Core::Log()->Reset();

		return TRUE;
	}
}
?>