<?php
/**
 * $Id$
 *
 * Session library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudSession
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
 * Session library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudSession
 *
 */
class Session extends Library
{
	/**
	 * Session expire time (in seconds)
	 *
	 * @var int
	 */
	private $_mExpire;

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

	public function Start()
	{
		$this->_mExpire = Core::Config()->Get( 'session.expire' );

		/**
		 * Set cache limiter.
		 */
		session_cache_limiter( 'public, must-revalidate' );

		/**
		 * Set cache expire (minutes).
		 */
		session_cache_expire( $this->_mExpire / 60 );

		/**
		 * Set garbage collector timeout (seconds).
		 */
		ini_set( 'session.gc_maxlifetime', $this->_mExpire );

		/**
		 * Set custom session path to application temp directory.
		 */
		ini_set( 'session.save_path', Core::Config()->Get( 'path.app' ) . Core::Config()->Get( 'dir.app.tmp' ) . '/' );

		/**
		 * Start session.
		 */
		session_start();

		/**
		 * Header entity tag.
		 */
		header( 'ETag: PUB' . time() );

		/**
		 * Header last modified tag.
		 */
		header( 'Last-Modified: ' . gmdate( "D, d M Y H:i:s", time()-10 ) . ' GMT' );

		/**
		 * Header expires tag.
		 */
		header( 'Expires: ' . gmdate( "D, d M Y H:i:s", time() + 5 ) . ' GMT' );

		/**
		 * Header pragma tag.
		 */
		header( 'Pragma: no-cache' );

		/**
		 * Header cache control tag.
		 */
		header( 'Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate' );

		/**
		 * Return result.
		 */
		return TRUE;
	}
}
?>