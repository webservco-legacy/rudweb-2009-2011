<?php
/**
 * $Id$
 *
 * Misc Tests library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudTest
 * @subpackage Misc
 * @version    $Revision$
 * @since      Version 5
 * @access     public
 * @filesource
 */

/**
 * MiscTests
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudTest
 * @subpackage Misc
 *
 */
class MiscTests
{
	/**
	 * Working directory path.
	 *
	 * @var string
	 */
	protected static $_msWorkDir;

	/**
	 * Working file extension.
	 *
	 * @var string
	 */
	protected static $_msFileExt;

	/**
	 * Log file path.
	 *
	 * @var string
	 */
	public static $_msLogFile;

	/**
	 * Number of files to use for testing.
	 *
	 * @var int
	 */
	protected static $_msFileCount;

	/**
	 * Number of times to run each test.
	 *
	 * @var int
	 */
	protected static $_msTestCount;

	/**
	 * Name of test class.
	 *
	 * @var int
	 */
	protected static $_msTestClass;

	/**
	 * Number of decimals to round times.
	 *
	 * @var int
	 */
	protected static $_msTimeRound = 7;

	/**
	 * Init.
	 *
	 * @param string $work_dir
	 * @param string $file_count
	 * @param string $test_count
	 * @param string $test_class
	 *
	 * @return bool
	 */
	public static function Init( $workDir = NULL, $fileCount = NULL, $testCount = NULL, $testClass = NULL )
	{
		/**
		 * @var string
		 */
		self::$_msTestClass = $testClass;

		/**
		 * @var string
		 */
		self::$_msLogFile = 'log_' . $_SERVER['SERVER_NAME'] . '.log';

		/**
		 * @var string
		 */
		self::$_msWorkDir = ( !empty( $workDir ) ) ? $workDir : './tmp/';

		/**
		 * @var string
		 */
		self::$_msFileExt = '.tmp';

		/**
		 * @var int
		 */
		self::$_msFileCount = ( !empty( $fileCount ) ) ? $fileCount : 30000;

		/**
		 * @var int
		 */
		self::$_msTestCount = ( !empty( $testCount ) ) ? $testCount : 30;

		ignore_user_abort( TRUE );

		set_time_limit( 0 );

		self::_Log( '['. __FUNCTION__ .'] ' . self::$_msTestClass );

		return TRUE;
	}

	/**
	 * Creates the test files.
	 *
	 * @param int $testCases
	 *
	 * @return bool
	 */
	public static function Start( $testCases )
	{
		if ( !is_writable( self::$_msWorkDir ) )
		{
			echo 'Fatal: Working directory "' . self::$_msWorkDir . '" is not writable.';

			exit();
		}

		/**
		 * @var array
		 */
		$var = array(
			'lorem' => 'ipsum',
			'dolor' => array( 'sit' => 'amet' ),
		);

		/**
		 * Test data.
		 *
		 * @var string
		 */
		$data = serialize( $var );

		/**
		 * @var int
		 */
		$s = microtime( TRUE );

		for ( $i = 0; $i < self::$_msFileCount; $i++ )
		{
			/**
			 * @var string
			 */
			$f = self::$_msWorkDir . $i . self::$_msFileExt;

			file_put_contents( $f, time() . $data );
		}

		/**
		 * @var int
		 */
		$e = microtime( TRUE );

		/**
		 * @var float
		 */
		$t = round( $e - $s, self::$_msTimeRound );

		self::_Log( '['. __FUNCTION__ . '] ' . self::$_msTestClass );

		self::_Log( '['. __FUNCTION__ . '] Created test environment: ' . $t );

		self::_LogStats( $testCases );

		return $t;
	}

	/**
	 * Removes the test files.
	 *
	 * @param bool $deleteLog
	 *
	 * @return bool
	 */
	public static function End( $deleteLog = FALSE )
	{
		if ( !is_writable( self::$_msWorkDir ) )
		{
			echo 'Fatal: Working directory "' . self::$_msWorkDir . '" is not writable.';

			exit();
		}

		/**
		 * @var int
		 */
		$s = microtime( TRUE );

		for ( $i = 0; $i < self::$_msFileCount; $i++ )
		{
			/**
			 * @var string
			 */
			$f = self::$_msWorkDir . $i . self::$_msFileExt;

			@unlink( $f );
		}

		/**
		 * @var int
		 */
		$e = microtime( TRUE );

		/**
		 * @var float
		 */
		$t = round( $e - $s, self::$_msTimeRound );

		if ( FALSE !== $deleteLog )
		{
			/**
			 * @var string
			 */
			$log_path = self::$_msWorkDir . self::$_msLogFile;

			@unlink( $log_path );
		}
		else
		{
			self::_Log( '['. __FUNCTION__ . '] Cleanup environment: ' . $t );
		}

		return $t;
	}

	/**
	 * Get log file name.
	 *
	 * @return string
	 */
	public static function GetLogFile()
	{
		return self::$_msLogFile;
	}

	/**
	 * Runs a test.
	 *
	 * @param string $testName
	 * @param string $testCount
	 *
	 * @return bool
	 */
	public static function Run( $testName, $testCount = NULL )
	{
		/**
		 * @var var int
		 */
		$test_count = ( !empty( $testCount ) ) ? $testCount : self::$_msTestCount;

		/**
		 * @var string
		 */
		$test_class = self::$_msTestClass;

		/**
		 * @var string
		 */
		$test_method = '_Test' . ucfirst( strtolower( $testName ) );

		if ( !is_callable( array( $test_class, $test_method ) ) )
		{
			self::_Log( '['. __FUNCTION__ . '] ' . $testName . ' not found.' );

			return FALSE;
		}

		/**
		 * @var int
		 */
		$s = microtime( TRUE );

		/**
		 * @var int
		 */
		$time = 0;

		for ( $i = 0; $i < $test_count; $i++ )
		{
			/**
			 * Run test.
			 *
			 * PHP < 5.3 compatibility.
			 *
			 * $time += $test_class::$test_method( FALSE );
			 */
			$time += call_user_func( array( $test_class, $test_method ), FALSE );
		}

		/**
		 * @var int
		 */
		$e = microtime( TRUE );

		/**
		 * @var float
		 */
		$t = round( $e - $s, self::$_msTimeRound );

		/**
		 * @var float
		 */
		$avg = round( $time / $test_count, self::$_msTimeRound );

		self::_Log( '['. __FUNCTION__ . '] Test case "' . $testName . '" ' . $test_count . ' times (time: ' . $t . ', avg: ' . $avg . ') ' );

		return $t;
	}

	/**
	 * Log.
	 *
	 * @param string $message
	 *
	 * @return bool
	 */
	protected static function _Log( $message )
	{
		if ( !is_writable( self::$_msWorkDir ) )
		{
			echo 'Fatal: Working directory "' . self::$_msWorkDir . '" is not writable.';

			exit();
		}

		/**
		 * @var string
		 */
		$entry = date( 'Y-m-d H:i:s' )  . ' ' . $message . PHP_EOL;

		/**
		 * @var string
		 */
		$f = self::$_msWorkDir . self::$_msLogFile;

		/**
		 * @var resource
		 */
		$handle = fopen( $f, "ab" );

		fwrite( $handle, $entry );

		fclose( $handle );

		return TRUE;
	}

	/**
	 * Clear log file.
	 *
	 * @return bool
	 */
	public static function LogReset()
	{
		if ( !is_writable( self::$_msWorkDir ) )
		{
			echo 'Fatal: Working directory "' . self::$_msWorkDir . '" is not writable.';

			exit();
		}

		/**
		 * @var string
		 */
		$f = self::$_msWorkDir . self::$_msLogFile;

		/**
		 * @var resource
		 */
		$handle = fopen( $f, "wb" );

		fclose( $handle );

		return TRUE;
	}

	/**
	 * Write general statistics to log file.
	 *
	 * @param int $testCases
	 *
	 * @return bool
	 */
	protected static function _LogStats( $testCases = 0 )
	{
		self::_Log( '['. __FUNCTION__ . '] Test results kindly provided by ' . $_SERVER['SERVER_NAME'] );

		self::_Log( '['. __FUNCTION__ . '] Will run ' . $testCases . ' test cases, ' . self::$_msTestCount . ' times each, using ' . self::$_msFileCount . ' files.' );

		/**
		 * OS PHP was build on.
		 *
		 * @var string
		 */
		$stats['os_build'] = PHP_OS;

		/**
		 * OS Name.
		 *
		 * @var string
		 */
		$stats['os_name'] = function_exists( 'php_uname' ) ? php_uname('s') : 'n/a';

		/**
		 * Machine type.
		 *
		 * @var string
		 */
		$stats['os_arch'] = function_exists( 'php_uname' ) ? php_uname('m') : 'n/a';

		/**
		 * Setver software.
		 *
		 * @var string
		 */
		$stats['server_software'] = $_SERVER['SERVER_SOFTWARE'];

		/**
		 * PHP Version.
		 *
		 * @var string
		 */
		$stats['php_version'] = function_exists( 'phpversion' ) ? phpversion() : PHP_VERSION;

		/**
		 * Server interface.
		 *
		 * @var string
		 */
		$stats['php_sapi'] = function_exists( 'php_sapi_name' ) ? php_sapi_name() : PHP_SAPI;

		foreach( $stats as $s_name => $s_value )
		{
			self::_Log( '['. __FUNCTION__ . '] ' . $s_name  . ': ' . $s_value );
		}

		return TRUE;
	}
}
?>