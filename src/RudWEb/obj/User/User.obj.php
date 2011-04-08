<?php
/**
 * $Id$
 *
 * User object.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudObject
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
 * User
 *
 * User object.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudObject
 *
 */
class User extends Object
{
	/**
	 * Object properties.
	 *
	 * @var array
	 */
	public $mProp = array(
		'list' => array(
			'bin.user_id' => NULL,
			'user_login' => NULL,
			'user_status' => NULL,
	),
	);

	/**
	 * Object vaiable properties
	 *
	 * @var array
	 */
	public $mVars = array();

	/**
	 * Object tables.
	 *
	 * @var array
	 */
	protected $_mTable = array( 'list' => 'acl_users' );

	/**
	 * Initialize the object.
	 *
	 * @return bool
	 */
	public function Init()
	{
		/**
		 * @var array
		 */
		$this->mVars = array(
			'ip' => Core::Geo()->GetIp(),
			'agent' => ( !empty( $_SERVER['HTTP_USER_AGENT'] ) ) ? $_SERVER['HTTP_USER_AGENT'] : NULL,
			'last_visit' => NULL
		);

		return TRUE;
	}

	/**
	 * Login user.
	 *
	 * @param string $userLogin
	 * @param string $userPass
	 * @param bool $userRemember
	 *
	 * @return bool
	 */
	public function Login( $userLogin, $userPass, $userRemember = FALSE )
	{
		if ( empty( $this->mVars ) )
		{
			$this->Init();
		}

		/**
		 * @var bool
		 */
		$login = $this->_LoginUser( $userLogin, $userPass );

		$this->_RecordLogin( $this->_mId, $userLogin );

		if ( TRUE !== $login )
		{
			return FALSE;
		}

		if ( FALSE !== $userRemember )
		{
			/**
			 * Add persistent session.
			 */
			Core::Session()->AddPersistentSession( $this->_mId, $userLogin );
		}

		return TRUE;
	}

	/**
	 * Check and login user.
	 *
	 * @param string $userLogin
	 * @param string $userPass
	 *
	 * @return bool
	 */
	private function _LoginUser( $userLogin, $userPass )
	{
		/**
		 * @var string
		 */
		$user_salt = Core::Security()->GetSalt( $userLogin );

		/**
		 * @var string
		 */
		$user_auth = Core::Security()->GetToken( $user_salt, $userPass );

		/**
		 * @var array
		 */
		$options['conditions'][] = array ( 'user_login', $userLogin );

		/**
		 * @var array
		 */
		$options['conditions'][] = array ( 'user_auth', $user_auth );

		$data = Core::Database()->RetrieveOne( array( 'bin.user_id', 'user_login', 'user_status' ), $this->_mTable['list'], $options );

		if ( empty( $data ) )
		{
			return FALSE;
		}

		if ( 'active' != $data['user_status'] )
		{
			return FALSE;
		}

		/**
		 * Set object data.
		 *
		 * @var array
		 */
		$this->mProp['list'] = array_merge( $this->mProp['list'], $data );

		/**
		 * Set object Id.
		 *
		 * @var string
		 */
		$this->_mId = $data[$this->_mKey];

		return TRUE;
	}

	/**
	 * Record login stats.
	 *
	 * If login is failed, the user_id will be 00
	 *
	 * @param string $userId
	 * @param string $userLogin
	 *
	 * @return bool
	 */
	private function _RecordLogin( $userId, $userLogin )
	{
		/**
		 * @var string
		 */
		$user_id = ( !empty( $userId ) ) ? $userId : '00';

		/**
		 * @var array
		 */
		$data = array(
			'bin.user_id' => $user_id,
			'user_login' => $userLogin,
			'user_ip' => $this->mVars['ip'],
			'user_agent' => $this->mVars['agent'],
		);

		if ( FALSE !== Core::Database()->Create( $data, 'acl_logins' ) )
		{
			return TRUE;
		}

		return FALSE;
	}
}
?>