<?php
/**
 * $Id$
 *
 * Engine core library utilities.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudCore
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
 * CoreCompat
 *
 * Engine core compatibility library for PHP < 5.3.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudCore
 *
 */
class CoreCompat
{
	/**
	 * Holds incrementation for {@link GetCalledClass() GetCalledClass()}.
	 *
	 * @var int
	 */
	private static $_msGclIncrement = 0;

	/**
	 * Holds file/line number for {@link GetCalledClass() GetCalledClass()}.
	 *
	 * @var string
	 */
	private static $_msGclFileLine = NULL;

	/**
	 * get_called_class() alternative for PHP < 5.3
	 *
	 * All credit for this goes to {@link http://www.septuro.com/2009/07/php-5-2-late-static-binding-get_called_class-and-self-new-self/ visual77 - Septuro}
	 */
	public static function GetCalledClass()
	{
		$bt = debug_backtrace();

		/**
		 * Prevent errors if called dirrectly.
		 */
		if ( !array_key_exists( 2, $bt ) )
		{
			/**
			 * Stop.
			 */
			return FALSE;
		}

		$file = $bt[2]['file'];

		$line = $bt[2]['line'];

		$function = $bt[2]['function'];

		if( $file.$line == self::$_msGclFileLine )
		{
			self::$_msGclIncrement++;
		}
		else
		{
			self::$_msGclIncrement = 0;
			self::$_msGclFileLine = $file . $line;
		}

		$lines = file($file);

		preg_match_all( '/([a-zA-Z0-9\_]+)::' . $function.'/', $lines[$line-1], $matches );

		/**
		 * Prevent errors if called dirrectly.
		 */
		if ( !array_key_exists( self::$_msGclIncrement, $matches[1] ) )
		{
			/**
			 * Stop.
			 */
			return FALSE;
		}

		return $matches[1][self::$_msGclIncrement];
	}
}

/**
 * Check if get_called_class() is available (PHP >= 5.3).
 */
if( !function_exists( 'get_called_class' ) )
{
	/**
	 * Define alternative get_called_class() function for PHP < 5.3.
	 *
	 * @return string
	 */
	function get_called_class()
	{
		return CoreCompat::GetCalledClass();
	}
}
?>