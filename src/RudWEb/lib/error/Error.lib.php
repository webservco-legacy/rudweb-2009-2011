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

		return TRUE;
	}

	/**
	 * Handle errors.
	 *
	 * @param integer $errCode
	 * @param string $errMessage
	 * @param string $errFile
	 * @param string $errLine
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
		$msg  = 'Someone made a boo-boo!';
		$msg .= "\n";
		$msg .= '<!--' . "\n";
		$msg .= 'code: ' . $errObject->GetCode() . "\n";
		$msg .= 'severity: ' . $errObject->GetSeverity() . "\n";
		$msg .= 'message: ' . $errObject->GetMessage() . "\n";
		$msg .= 'file: ' . $errObject->GetFile() . "\n";
		$msg .= 'line: ' . $errObject->GetLine() . "\n";
		$msg .= 'trace: ' . "\n";
		$msg .= $errObject->GetTraceAsString() . "\n";
		$msg .= '-->';

		echo $msg;

		exit();
	}
}
?>