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
}
?>