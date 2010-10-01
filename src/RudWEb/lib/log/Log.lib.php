<?php
/**
 * $Id$
 *
 * Logging library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudLog
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
 * Logging library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudLog
 *
 */
class Log extends Library
{
	/**
	 * Stores log files path.
	 *
	 * @var string
	 */
	private $_mLogPath;

	/**
	 * Set log files path.
	 *
	 * @param string $logPath
	 *
	 * @return bool
	 */
	public function SetPath( $logPath )
	{
		/**
		 * @var string
		 */
		$this->_mLogPath = $logPath;

		return TRUE;
	}

	/**
	 * Get full log file path.
	 *
	 * Returns NULL if log file is not writable
	 *
	 * @param string $logType
	 * @param string $logPath
	 *
	 * @return mixed
	 */
	public function GetFile( $logType = 'app', $logPath = NULL )
	{
		/**
		 * @var string
		 */
		$log_path = ( $logPath ) ? $logPath : $this->_mLogPath;

		/**
		 * @var string
		 */
		$log_file = $log_path . $logType . '.log';

		/**
		 * Check if log file is writable.
		 */
		if ( !is_writable( $log_file ) )
		{
			return NULL;
		}

		return $log_file;
	}

	/**
	 * Truncate log file.
	 *
	 * @param string $logType
	 * @param string $logPath
	 */
	public function Reset( $logType = 'app', $logPath = NULL )
	{
		/**
		 * Get full log file path.
		 *
		 * @var string
		 */
		$log_file = $this->GetFile( $logType, $logPath );

		/**
		 * Stop if log file is not writable.
		 */
		if ( !$log_file )
		{
			return FALSE;
		}

		/**
		 * @var mixed
		 */
		$log_handle = fopen( $log_file, "wb" );

		fclose( $log_handle );

		return TRUE;
	}

	/**
	 * Log.
	 *
	 * @param string $logMessage
	 * @param string $logLevel
	 * @param string $logType
	 * @param string $logPath
	 */
	public function Write( $logMessage, $logLevel = 'info', $logType = 'app', $logPath = NULL )
	{
		/**
		 * Get full log file path.
		 *
		 * @var string
		 */
		$log_file = $this->GetFile( $logType, $logPath );

		/**
		 * Stop if log file is not writable.
		 */
		if ( !$log_file )
		{
			return FALSE;
		}

		/**
		 * @var string
		 */
		$timestamp = date('Y-m-d H:i:s:u');

		/**
		 * @var string
		 */
		$log_entry = '['. $timestamp . '] [' . $_SERVER['REMOTE_ADDR'] . '] [' . $logLevel . '] ' . $logMessage . PHP_EOL;

		/**
		 * @var mixed
		 */
		$log_handle = fopen( $log_file, "ab" );

		fwrite($log_handle, $log_entry);

		fclose($log_handle);

		return TRUE;
	}
}
?>