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
	public function ConfigReturnsObject()
	{
		$this->assertInternalType( 'object', Core::Config() );
	}

	/**
	 * @test
	 */
	public function ErrorReturnsObject()
	{
		$this->assertInternalType( 'object', Core::Error() );
	}

	/**
	 * @test
	 */
	public function I18nReturnsObject()
	{
		$this->assertInternalType( 'object', Core::I18n() );
	}

	/**
	 * @test
	 */
	public function LogReturnsObject()
	{
		$this->assertInternalType( 'object', Core::Log() );
	}

	/**
	 * @test
	 */
	public function AppReturnsObject()
	{
		$this->assertInternalType( 'object', Core::App() );
	}

	/**
	 * @test
	 */
	public function CustomConfigSetDatabaseTypeRetrunsTrue()
	{
		$this->assertTrue( Core::Config()->Set( 'db.type', 'MySQL' ) );
	}

	/**
	 * @test
	 *
	 * @depends CustomConfigSetDatabaseTypeRetrunsTrue
	 */
	public function DbReturnsObjectForMysql()
	{
		$this->assertInternalType( 'object', Core::Database() );
	}

	/**
	 * @test
	 */
	public function StringReturnsObject()
	{
		$this->assertInternalType( 'object', Core::String() );
	}

	/**
	 * @test
	 */
	public function SecurityReturnsObject()
	{
		$this->assertInternalType( 'object', Core::Security() );
	}

	/**
	 * @test
	 */
	public function RouterReturnsObject()
	{
		$this->assertInternalType( 'object', Core::Router() );
	}

	/**
	 * @test
	 */
	public function AclReturnsObject()
	{
		$this->assertInternalType( 'object', Core::Acl() );
	}

	/**
	 * @test
	 */
	public function UserReturnsObject()
	{
		$this->assertInternalType( 'object', Core::User() );
	}

	/**
	 * @test
	 */
	public function SessionReturnsObject()
	{
		$this->assertInternalType( 'object', Core::Session() );
	}

	/**
	 * @test
	 */
	public function GeoReturnsObject()
	{
		$this->assertInternalType( 'object', Core::Geo() );
	}
}
?>