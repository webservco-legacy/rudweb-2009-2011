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
	exit;
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
		$err_code = $errObject->GetCode();
		$err_severity = $errObject->GetSeverity();
		$err_message = $errObject->GetMessage();
		$err_file = $errObject->GetFile();
		$err_line = $errObject->GetLine();
		$err_trace = $errObject->GetTraceAsString();

		$msg = __( 'The application made a boo boo.', 'RudWEb' ) . PHP_EOL;

		$msg .= 'Message: ' . $err_message . PHP_EOL;

		$msg .= '[code ' . $err_code . '] [severity ' . $err_severity . '] ' . PHP_EOL;

		$msg .= 'File: ' . $err_file . ' on line ' . $err_line . '.' . PHP_EOL;

		if ( 1 == Core::Config()->Get( 'error.trace' ) )
		{
			$msg .= 'Trace:' . PHP_EOL ;
			$msg .= $err_trace . PHP_EOL;
		}

		$msg .= PHP_EOL . 'Execution stopped.';

		Core::Log()->Write( $msg , 'error' );

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