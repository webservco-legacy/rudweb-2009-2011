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
 * @subpackage Core
 * @version    $Revision$
 * @since      Version 5
 * @access     private
 * @filesource
 */

/**
 * CoreTest
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudTest
 * @subpackage Core
 *
 */
class CoreTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function CfgReturnsObject()
	{
		$this->assertType( 'object', Core::Cfg() );
	}

	/**
	 * @test
	 */
	public function ErrorReturnsObject()
	{
		$this->assertType( 'object', Core::Error() );
	}

	/**
	 * @test
	 */
	public function I18nReturnsObject()
	{
		$this->assertType( 'object', Core::I18n() );
	}

	/**
	 * @test
	 */
	public function LogReturnsObject()
	{
		$this->assertType( 'object', Core::Log() );
	}

	/**
	 * @test
	 */
	public function AppReturnsObject()
	{
		$this->assertType( 'object', Core::App() );
	}

	/**
	 * @test
	 */
	public function CustomCfgSetDatabaseTypeRetrunsTrue()
	{
		$this->assertTrue( Core::Cfg()->Set( 'db.type', 'MySQL' ) );
	}

	/**
	 * @test
	 *
	 * @depends CustomCfgSetDatabaseTypeRetrunsTrue
	 */
	public function DbReturnsObjectForMysql()
	{
		$this->assertType( 'object', Core::Db() );
	}

	/**
	 * @test
	 */
	public function UrlReturnsObject()
	{
		$this->assertType( 'object', Core::Url() );
	}
}
?>