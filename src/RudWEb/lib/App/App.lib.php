<?php
/**
 * $Id$
 *
 * Application library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
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
	 * Stores the request array.
	 *
	 * @var array
	 */
	private $_mRequest;

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
	 * Boot application.
	 *
	 * @return bool
	 */
	public function Boot()
	{
		/**
		 * Load main configuration settings.
		 */
		$this->_InitConfig();

		/**
		 * Set timezone.
		 */
		date_default_timezone_set( Core::Config()->Get( 'date.timezone' ) );

		/**
		 * Initialize internationalization library.
		 * XXX ADD LOCALE SWITCHING
		 */
		Core::I18n()->Init();

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
			 * Set i18n keywords.
			 */
			Core::Config()->SetI18nKeys();

			Core::Log()->Write( __( 'Config library: Setting i18n keys.', 'RudWEb' ), 'debug' );

			/**
			 * Add application i18n.
			 */
			Core::I18n()->Add( 'App' );

			Core::Log()->Write( sprintf( __( 'I18n library: Added domain "%s".', 'RudWEb' ), 'App' ), 'debug' );

			/**
			 * Load application i18n.
			 */
			Core::I18n()->Load( 'App' );

			Core::Log()->Write( sprintf( __( 'I18n library: Loaded domain "%s".', 'RudWEb' ), 'App' ), 'debug' );

			/**
			 * Sanitize requests.
			 *
			 * @var array
			 */
			Core::Security()->Sanitize();

			/**
			 * Perform routing.
			 *
			 * @var array
			 */
			$this->_mRequest = Core::Router()->Route();

			/**
			 * Check if we have sessions enabled.
			 */
			if ( 1 == Core::Config()->Get( 'app.sessions' ) )
			{
				/**
				 * Start session.
				 */
				Core::Session()->Start();

				/**
				 * User object initialization.
				 */
				Core::User()->Init();

				Core::Log()->Write( __( 'User object: Initialization complete.', 'RudWEb' ), 'debug' );
			}

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

				/**
				 * Show 404 message
				 */
				return $this->_Stop( $module_msg );
			}

			/**
			 * PHP < 5.3 compatibility.
			 * $module_object = $module_name::GetInstance( $module_name );
			 *
			 * @var object
			 */
			$module_object = call_user_func( array( $module_name, 'GetInstance' ), $module_name );

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

				/**
				 * Show 404 message
				 */
				return $this->_Stop( $ctrl_msg );
			}

			/**
			 * PHP < 5.3 compatibility.
			 * $ctrl_object = $ctrl_name::GetInstance( $ctrl_name );
			 *
			 * @var object
			 */
			$ctrl_object = call_user_func( array( $ctrl_name, 'GetInstance' ), $ctrl_name );

			/**
			 * Set request array to controller object.
			 */
			$ctrl_object->SetRequest( $this->_mRequest );

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

				/**
				 * Show 404 message
				 */
				return $this->_Stop( $action_msg );
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

			return call_user_func( array( $ctrl_object, $action_name ) );
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

		if ( 1 == Core::Config()->Get( 'log.reset' ) )
		{
			/**
			 * Truncate log file.
			 */
			Core::Log()->Reset();
		}

		return TRUE;
	}

	/**
	 * Stop application and display error message.
	 *
	 * @param string $errorMessage error message
	 * @param string $errorController error controller
	 * @param string $errorType error type
	 */
	protected function _Stop( $errorMessage, $errorController = 'Core', $errorType = '404' )
	{
		Core::Log()->Write( $errorMessage, 'warning' );

		Core::Log()->Write( __( 'Application: Loading error message.', 'RudWEb' ), 'notice' );

		$ctrl_name = 'Controller_Oups_' . $errorController;

		/**
		 * PHP < 5.3 compatibility.
		 * $ctrl_object = $ctrl_name::GetInstance( $ctrl_name );
		 *
		 * @var object
		 */
		$ctrl_object = call_user_func( array( $ctrl_name, 'GetInstance' ), $ctrl_name );

		$action_name = 'Oups' . $errorType;

		return call_user_func( array( $ctrl_object, $action_name ) );
	}
}
?>