<?php
/**
 * $Id$
 *
 * Error handling and reporting library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
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

		$msg = 'Boo boo detected!' . PHP_EOL;

		$msg .= "\t\t\t" . '[code ' . $err_code . '] [severity ' . $err_severity . '] ' . PHP_EOL; 
		
		$msg .= "\t\t\t" . 'Message: ' . $err_message . PHP_EOL;
		
		$msg .= "\t\t\t" . 'File: ' . $err_file . ' on line ' . $err_line . '.' . PHP_EOL;

		if ( 1 == Core::Config()->Get( 'error.trace' ) )
		{
			$msg .= "\t\t\t" . 'Trace:' . PHP_EOL ;
			$msg .= "\t\t\t" . $err_trace . PHP_EOL;
		}

		$msg .= PHP_EOL . "\t\t\t" . 'Execution stopped.';

		Core::Log()->Write( $msg , 'error' );

		echo 'Boo boo detected!';

		exit();
	}
}
?>