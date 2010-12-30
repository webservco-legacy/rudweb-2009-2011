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
 * @subpackage Library
 * @version    $Revision$
 * @since      Version 5
 * @access     private
 * @filesource
 */

/**
 * LibraryTest
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudTest
 * @subpackage Library
 *
 */
class LibraryTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function GetInstanceRetrunsFalseIfCalledDirrectly()
	{
		$this->assertFalse( Library::GetInstance() );
	}

	/**
	 * @test
	 */
	public function GetInstanceRetrunsFalseIfCalledDirrectlyWithParameter()
	{
		$this->assertFalse( Library::GetInstance( 'Config' ) );
	}
}
?>