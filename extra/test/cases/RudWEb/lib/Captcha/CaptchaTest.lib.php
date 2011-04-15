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
 * @subpackage Captcha
 * @version    $Revision$
 * @since      Version 5
 * @access     private
 * @filesource
 */

/**
 * CaptchaTest
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudTest
 * @subpackage Captcha
 *
 */
class CaptchaTest extends PHPUnit_Framework_TestCase
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
		$this->_mObject = Captcha::GetInstance();
	}

	/**
	 * @test
	 */
	public function GetInstanceReturnsObject()
	{
		$this->assertInternalType( 'object', Captcha::GetInstance() );
	}
}
?>