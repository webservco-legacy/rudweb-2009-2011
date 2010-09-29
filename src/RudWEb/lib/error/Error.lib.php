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
 * RudException
 *
 * Error object.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudError
 *
 */
class RudException extends Exception
{
	private $_mContext;

	public function __construct( $errMessage, $errCode, $errFile, $errLine, $errContext = NULL )
	{
		parent::__construct( $errMessage, $errCode );

		$this->file = $errFile;

		$this->line = $errLine;

		$this->_mContext = $errContext;
	}
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
	public function Load()
	{
		set_error_handler( array( Error::GetInstance(), 'Handle' ) );

		return TRUE;
	}

	public function Unload()
	{
		restore_error_handler();

		return TRUE;
	}

	public function Handle( $errCode, $errMessage, $errFile, $errLine, $errContext )
	{
		//throw new RudException( $errMessage, $errCode, $errFile, $errLine, $errContext );
		//XXX try with ErroException
		throw new ErrorException( $errMessage, 0, $errCode, $errFile, $errLine );
	}
}
?>