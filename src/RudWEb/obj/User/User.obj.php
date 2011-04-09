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
	 * User stats about current session.
	 *
	 * @var array
	 */
	public $mStatsCurrent = array();

	/**
	 * User stats about previous session.
	 *
	 * @var array
	 */
	public $mStatsPrevious = array();

	/**
	 * Object tables.
	 *
	 * @var array
	 */
	protected $_mTable = array( 'list' => 'acl_users', 'logins' => 'acl_logins' );

	/**
	 * User logged in flag.
	 *
	 * @var bool
	 */
	private $_mLogged = FALSE;

	/**
	 * User persistent session flag.
	 *
	 * If this is set to true, user is not explicitly authenticated,
	 * and extra security is necessary when performing sensitive operations.
	 *
	 * @var bool
	 */
	private $_mPersistent = FALSE;

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
		$this->mStatsCurrent = array(
			'time'	=> date( 'Y-m-d H:i:s' ),
			'ip'	=> Core::Geo()->GetIp(),
			'agent'	=> ( !empty( $_SERVER['HTTP_USER_AGENT'] ) ) ? $_SERVER['HTTP_USER_AGENT'] : NULL,
			'auto'	=> FALSE,
		);

		/**
		 * Check returning user.
		 *
		 * @var mixed
		 */
		$returning_user = Core::Session()->CheckPersistentSession();

		if ( FALSE !== $returning_user )
		{
			/**
			 * Record auto login
			 */
			$this->_RecordLogin( $returning_user );

			/**
			 * Set updated stats time
			 *
			 * @var array
			 */
			$this->mStatsCurrent['time'] = date( 'Y-m-d H:i:s' );

			/**
			 * Set persistent flag.
			 *
			 * @var bool
			 */
			$this->_mPersistent = TRUE;

			/**
			 * Set persistent statistic.
			 *
			 * @var array
			 */
			$this->mStatsCurrent['auto'] = TRUE;

			/**
			 * @var array
			 */
			$options['conditions'][] = array ( 'bin.user_id', $returning_user );

			return $this->_SetUserData( $options );
		}

		return TRUE;
	}

	/**
	 * Check if user is logged in.
	 *
	 * @return bool
	 */
	public function IsLogged()
	{
		return $this->_mLogged;
	}

	/**
	 * Check if user is logged in and if the session is persistent.
	 *
	 * @return bool
	 */
	public function IsPersistent()
	{
		if ( TRUE !== $this->_mLogged )
		{
			return FALSE;
		}

		return $this->_mPersistent;
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
		if ( empty( $this->mStatsCurrent ) )
		{
			$this->Init();
		}

		//XXX SECURITY CHECKS

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
			 * @var string
			 */
			$user_salt = Core::Security()->GetSalt( $userLogin );

			/**
			 * @var string
			 */
			$persistent_token = Core::Security()->GetToken( $user_salt );

			/**
			 * Add persistent session.
			 */
			Core::Session()->AddPersistentSession( $this->_mId, $persistent_token );
		}

		return TRUE;
	}

	/**
	 * Get user login name.
	 *
	 * @param string $userId
	 *
	 * @return mixed
	 */
	public function GetLoginName( $userId )
	{
		/**
		 * @var array
		 */
		$options['conditions'][] = array ( 'bin.user_id', $userId );

		/**
		 * @var array
		 */
		$data = Core::Database()->RetrieveOne( array( 'user_login' ), $this->_mTable['list'], $options );

		if ( empty( $data ) )
		{
			return FALSE;
		}

		return  $data['user_login'];
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

		return $this->_SetUserData( $options );
	}

	/**
	 * Set user details as object properties.
	 *
	 * @param array $options
	 */
	private function _SetUserData( $options )
	{
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

		/**
		 * Set logged in flag.
		 *
		 * @var bool
		 */
		$this->_mLogged = TRUE;

		/**
		 * Set last visit stats
		 */
		$this->_SetPreviousStats();

		return TRUE;
	}

	/**
	 * Set stats about the previous visit.
	 *
	 * @return bool
	 */
	private function _SetPreviousStats()
	{
		/**
		 * @var array
		 */
		$options['conditions'][] = array ( 'bin.user_id', $this->_mId );

		/**
		 * @var array
		 */
		$options['order'][] = array( 'login_date_add', 'desc' );

		/**
		 * @var array
		 */
		$data = Core::Database()->RetrieveOne( array( 'login_auto', 'user_ip', 'user_agent', 'login_date_add' ), $this->_mTable['logins'], $options );

		if ( empty( $data ) )
		{
			return FALSE;
		}

		/**
		 * @var array
		 */
		$this->mStatsPrevious = array(
			'time' => $data['login_date_add'],	
			'ip' => $data['user_ip'],
			'agent' => $data['user_agent'],
			'auto' => ( 'true' == $data['login_auto'] ) ? TRUE : FALSE,
		);

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
	private function _RecordLogin( $userId, $userLogin = NULL )
	{
		/**
		 * @var string
		 */
		$user_id = ( !empty( $userId ) ) ? $userId : '00';

		/**
		 * @var string
		 */
		$login_auto = ( empty( $userLogin ) ) ? 'true' : 'false';

		/**
		 * @var array
		 */
		$data = array(
			'bin.user_id' => $user_id,
			'user_login' => $userLogin,
			'user_ip' => ip2long( $this->mStatsCurrent['ip'] ),
			'login_auto' => $login_auto,
			'user_agent' => $this->mStatsCurrent['agent'],
		);

		if ( FALSE !== Core::Database()->Create( $data, 'acl_logins' ) )
		{
			return TRUE;
		}

		return FALSE;
	}
}
?>