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
 * @subpackage Router
 * @version    $Revision$
 * @since      Version 5
 * @access     private
 * @filesource
 */

/**
 * RouterTest
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudTest
 * @subpackage Router
 *
 */
class RouterTest extends PHPUnit_Framework_TestCase
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
		$this->_mObject = Router::GetInstance();
	}

	/**
	 * @test
	 */
	public function GetInstanceReturnsObject()
	{
		$this->assertInternalType( 'object', Router::GetInstance() );
	}

	/**
	 * @test
	 */
	public function RemoveFakeExtensionWorks()
	{
		$this->assertEquals( 'lorem_ipsum', $this->_mObject->RemoveFakeExtension( 'lorem_ipsum.html' ) );
	}
}
?>