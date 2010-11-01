<?php
/**
 * $Id$
 *
 * FileTime test library.
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
 * Test_FileTime
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudTest
 * @subpackage Misc
 *
 */
class Test_FileTime extends MiscTests
{
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
		return parent::Init( $workDir, $fileCount, $testCount, __CLASS__ );
	}

	/**
	 * Test filemtime().
	 *
	 * @param bool $logResults
	 *
	 * @return bool
	 */
	protected static function _TestMtime( $logResults = TRUE )
	{
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

			/**
			 * Only load test data, we do nothing with it.
			 *
			 * @var int
			 */
			$data = filemtime( $f );
		}

		clearstatcache();

		/**
		 * @var int
		 */
		$e = microtime(  TRUE  );

		/**
		 * @var float
		 */
		$t = round( $e - $s, self::$_msTimeRound );

		if ( FALSE !== $logResults )
		{
			self::_Log( '['. __FUNCTION__ . '] ' . $t );
		}

		return $t;
	}

	/**
	 * Test filectime().
	 *
	 * @param bool $logResults
	 *
	 * @return bool
	 */
	protected static function _TestCtime( $logResults = TRUE )
	{
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

			/**
			 * Only load test data, we do nothing with it.
			 *
			 * @var int
			 */
			$data = filectime( $f );
		}

		clearstatcache();

		/**
		 * @var int
		 */
		$e = microtime( TRUE );

		/**
		 * @var float
		 */
		$t = round( $e - $s, self::$_msTimeRound );

		if ( FALSE !== $logResults )
		{
			self::_Log( '['. __FUNCTION__ . '] ' . $t );
		}

		return $t;
	}

	/**
	 * Test file_get_contents().
	 *
	 * @param bool $logResults
	 *
	 * @return bool
	 */
	protected static function _TestFileGetContents( $logResults = TRUE )
	{
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

			/**
			 * Only load test data, we do nothing with it.
			 *
			 * @var int
			 */
			$data = file_get_contents( $f, null, null, null, 10 );
		}

		/**
		 * @var int
		 */
		$e = microtime( TRUE );

		/**
		 * @var float
		 */
		$t = round( $e - $s, self::$_msTimeRound );

		if ( FALSE !== $logResults )
		{
			self::_Log( '['. __FUNCTION__ . '] ' . $t );
		}

		return $t;
	}
}
?>