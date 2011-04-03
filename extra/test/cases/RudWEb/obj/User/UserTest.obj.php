<?php
/**
 * $Id$
 *
 * Unit Tests.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudTest
 * @subpackage ObjectUser
 * @version    $Revision$
 * @since      Version 5
 * @access     private
 * @filesource
 */

/**
 * UserTest
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudTest
 * @subpackage ObjectUser
 *
 */
class UserTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Stores class object.
	 *
	 * @var mixed
	 */
	private $_mObject;

	/**
	 * Construct
	 */
	public function setUp()
	{
		$this->_mObject = Core::Get( 'Object_User' );
	}

	/**
	 * @test
	 */
	public function GetReturnsObject()
	{
		$this->assertInternalType( 'object', Core::Get( 'Object_User' ) );
	}
}
?>