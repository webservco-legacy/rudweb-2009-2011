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
	 * Object tables.
	 *
	 * Use NULL for default.
	 *
	 * @var string
	 */
	protected $_mTable = array( 'list' => 'acl_users' );

	public function Login( $userLogin, $userPass, $userRemember = FALSE )
	{
		//XXX WORK
	}

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

	private function _RecordLogin()
	{
		//XXX WORK
	}
}
?>