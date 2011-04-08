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
	 * Library properties.
	 *
	 * @var array
	 */
	private $_mProp = array();

	/**
	 * Library tables.
	 *
	 * @var array
	 */
	protected $_mTable = array( 'persistent' => 'acl_persistent' );

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
	 * Start session.
	 *
	 * @return bool
	 */
	public function Start()
	{
		$this->_mProp = array(
			'expire' => Core::Config()->Get( 'session.expire' ),
			'lifetime' => Core::Config()->Get( 'session.lifetime' ),
			'path' => Core::Config()->Get( 'session.path' ),
			'domain' => Core::Config()->Get( 'session.domain' ),
			'secure' => ( 1 == Core::Config()->Get( 'session.secure' ) ) ? TRUE : FALSE,
			'httponly' => ( 1 == Core::Config()->Get( 'session.httponly' ) ) ? TRUE : FALSE,
		);

		/**
		 * Set cache limiter.
		 */
		session_cache_limiter( 'public, must-revalidate' );

		/**
		 * Set cache expire (minutes).
		 */
		session_cache_expire( $this->_mProp['expire'] / 60 );

		/**
		 * Set garbage collector timeout (seconds).
		 */
		ini_set( 'session.gc_maxlifetime', $this->_mProp['expire'] );

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

	/**
	 * Add persistent session.
	 *
	 * @param string $userId
	 * @param string $userLogin
	 *
	 * @return bool
	 */
	public function AddPersistentSession( $userId, $userLogin )
	{
		if ( empty( $userId ) )
		{
			return FALSE;
		}

		if ( empty( $this->_mProp ) )
		{
			$this->Start();
		}

		/**
		 * @var string
		 */
		$user_salt = Core::Security()->GetSalt( $userLogin );

		/**
		 * @var string
		 */
		$persistent_token = Core::Security()->GetToken( $user_salt );

		/**
		 * @var int
		 */
		$lifetime_days = $this->_mProp['lifetime'];

		/**
		 * @var int
		 */
		$persistent_expire = time()+60*60*24*$lifetime_days;

		/**
		 * @var array
		 */
		$data = array(
			'bin.user_id' => $this->_mId,
			'persistent_token' => $persistent_token,
			'persistent_expire' => date( 'Y-m-d H:i:s', $persistent_expire ),
		);

		if ( FALSE !== Core::Database()->Create( $data, $this->_mTable['persistent'] ) )
		{
			/**
			 * @var string
			 */
			$cookie_name = Core::Security()->GetToken( $user_salt, $userLogin );

			/**
			 * @var string
			 */
			$cookie_value = $persistent_token . Core::Security()->GetToken( $user_salt, $persistent_expire );

			/**
			 * Set cookie
			 */
			setcookie( $cookie_name, $cookie_value, $persistent_expire, $this->_mProp['path'], $this->_mProp['domain'], $this->_mProp['secure'], $this->_mProp['httponly'] );

			return TRUE;
		}

		return FALSE;
	}
}
?>