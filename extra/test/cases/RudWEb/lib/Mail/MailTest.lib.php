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
 * @subpackage Mail
 * @version    $Revision$
 * @since      Version 5
 * @access     private
 * @filesource
 */

/**
 * MailTest
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudTest
 * @subpackage Mail
 *
 */
class MailTest extends PHPUnit_Framework_TestCase
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
		$this->_mObject = Mail::GetInstance();
	}

	/**
	 * @test
	 */
	public function GetInstanceReturnsObject()
	{
		$this->assertInternalType( 'object', Mail::GetInstance() );
	}
}
?>