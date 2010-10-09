<?php
/**
 * $Id$
 *
 * Unit Tests.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudTest
 * @subpackage Controller
 * @version    $Revision$
 * @since      Version 5
 * @access     private
 * @filesource
 */

/**
 * Security token and library, config requirements
 * are already dealt with in the Core Test
 */

/**
 * ControllerTest
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudTest
 * @subpackage Controller
 *
 */
class ControllerTest extends PHPUnit_Framework_TestCase
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
		$this->_mObject = Controller::GetInstance();
	}

	/**
	 * @test
	 */
	public function GetInstanceReturnsObject()
	{
		$this->assertType( 'object', Controller::GetInstance() );
	}
}
?>