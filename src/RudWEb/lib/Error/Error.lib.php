<?php
/**
 * $Id$
 *
 * Error handling and reporting library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudError
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
	exit();
}

/**
 * Error
 *
 * Error handling library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudError
 *
 */
class Error extends Library
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
	 * Register as the error handler.
	 *
	 * @return boolean
	 */
	public function Load()
	{
		set_error_handler( array( Error::GetInstance(), 'Handle' ) );

		Core::Log()->Write( __( 'Error library: Registering as error handler.', 'RudWEb' ), 'debug' );

		return TRUE;
	}

	/**
	 * Restore error handler.
	 *
	 * @return boolean
	 */
	public function Unload()
	{
		restore_error_handler();

		Core::Log()->Write( __( 'Error library: Restoring default error handler.', 'RudWEb' ), 'debug' );

		return TRUE;
	}

	/**
	 * Handle errors.
	 *
	 * @param int $errCode
	 * @param string $errMessage
	 * @param string $errFile
	 * @param int $errLine
	 * @throws ErrorException
	 */
	public function Handle( $errCode, $errMessage, $errFile, $errLine )
	{
		throw new ErrorException( $errMessage, 0, $errCode, $errFile, $errLine );
	}

	/**
	 * Report errors.
	 *
	 * @param mixed $errObject
	 */
	public function Report( $errObject )
	{
		/**
		 * @var array
		 */
		$err = array(
			'code'		=> $errObject->GetCode(),
			'severity'	=> $errObject->GetSeverity(),
			'message'	=> $errObject->GetMessage(),
			'file'		=> $errObject->GetFile(),
			'line'		=> $errObject->GetLine(),
			'trace'		=> $errObject->GetTraceAsString(),
		);

		/**
		 * @var array
		 */
		$msg = array();

		/**
		 * @var array
		 */
		$msg[] = array( __( 'The application made a boo boo:', 'RudWEb' ), 'info' );

		/**
		 * @var array
		 */
		$msg[] =  array( $err['message'], 'error' );

		/**
		 * Severity 512 is reserved for sensitive operations,
		 * so we show no information apartform the actual message.
		 */
		if ( 512 != $err['severity'] )
		{
			/**
			 * @var array
			 */
			$msg[] = array( sprintf( __( 'Code: %s', 'RudWEb' ) , $err['code'] ), 'debug' );

			/**
			 * @var array
			 */
			$msg[] = array( sprintf( __( 'Severity: %s', 'RudWEb' ) , $err['severity'] ), 'debug' );

			/**
			 * @var array
			 */
			$msg[] = array( sprintf( __( 'File: %s', 'RudWEb' ) , $err['file'] ), 'debug' );

			/**
			 * @var array
			 */
			$msg[] = array( sprintf( __( 'Line: %s', 'RudWEb' ) , $err['line'] ), 'debug' );

			/**
			 * Check if trace is enabled.
			 */
			if ( 1 == Core::Config()->Get( 'error.trace' ) )
			{
				/**
				 * @var array
				 */
				$msg[] = array( __( 'Trace:', 'RudWEb' ) . PHP_EOL . $err['trace'], 'debug' );
			}
		}

		/**
		 * @var array
		 */
		$msg[] = array( 'Execution stopped.', 'info' );

		/**
		 * Iterate messages
		 */
		foreach ( $msg as $msg_data )
		{
			/**
			 * Write messages to log.
			 */
			Core::Log()->Write( $msg_data[0] , $msg_data[1] );
		}

		/**
		 * Display friendly error message in browser.
		 */
		return $this->_ShowErrorMessage();
	}

	/**
	 * Show error message in browser.
	 */
	private function _ShowErrorMessage()
	{
		header('HTTP/1.1 500 Internal Server Error');

		echo '<!doctype html><html><head><meta http-equiv="content-type" content="text/html; charset=UTF-8"><title>' .
		__( 'Error', 'RudWEb' ) . '</title></head><body><h1>' .
		__( 'The application made a boo boo.', 'RudWEb' ) . '</h1><p>' .
		__( 'But there is no reason to panic.', 'RudWEb' ) . ' ' .
		__( 'The person responsible has been notified.', 'RudWEb' ) . '</p><p>' .
		__( 'Please come back later.', 'RudWEb' ) . '</p><hr><address>' .
		sprintf( __( 'The friendly server at %s.', 'RudWEb' ), $_SERVER['SERVER_NAME'] ) . '</address></body></html>';

		exit();
	}
}
?>