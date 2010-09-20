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
 * @subpackage Cfg
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
 * CfgTest
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudTest
 * @subpackage Cfg
 *
 */
class CfgTest extends PHPUnit_Framework_TestCase
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
		$this->_mObject = Cfg::GetInstance('Cfg');
	}

	/**
	 * @test
	 */
	public function GetInstanceReturnsObject()
	{
		$this->assertType( 'object', Cfg::GetInstance('Cfg') );
	}

	/**
	 * @test
	 */
	public function SetEnvReturnsFalseOnEmptyString()
	{
		$this->assertFalse( $this->_mObject->SetEnv() );
	}

	/**
	 * @test
	 */
	public function SetEnvFailsOnEmptyArrayInput()
	{
		$this->assertFalse( $this->_mObject->SetEnv( array() ) );
	}

	/**
	 * @test
	 */
	public function SetEnvFailsOnAnyArrayInput()
	{
		$this->assertFalse( $this->_mObject->SetEnv( array( 'lorem'=>'ipsum' ) ) );
	}

	/**
	 * @test
	 */
	public function SetEnvReturnsTrueOnValidString()
	{
		$this->assertTrue( $this->_mObject->SetEnv('unit') );
	}

	/**
	 * @test
	 */
	public function SetEnvActuallySetsEnv()
	{
		$this->assertEquals( 'unit', $this->_mObject->GetEnv() );
	}

	/**
	 * @test
	 */
	public function GetEnvReturnsString()
	{
		$this->assertType( 'string', $this->_mObject->GetEnv() );
	}

	/**
	 * @test
	 */
	public function SetReturnsFalseWhenNoArguments()
	{
		$this->assertFalse( $this->_mObject->Set() );
	}

	/**
	 * @test
	 */
	public function SetReturnsFalseWhenDataIsStringAndSettingIsMissing()
	{
		$this->assertFalse( $this->_mObject->Set( 'dummy' ) );
	}

	/**
	 * @test
	 */
	public function SetReturnsFalseWhenDataIsInvalidPath()
	{
		$this->assertFalse( $this->_mObject->Set( '/home/rudisoft' ) );
	}

	/**
	 * @test
	 */
	public function SetReturnsFalseWhenValidFilePathButInvalidXml()
	{
		$this->assertFalse( $this->_mObject->Set( _PU_ASSETS_PATH . 'RudWEb/lib/cfg/blank.cfg.xml' ) );
	}

	/**
	 * @test
	 */
	public function SetReturnsTrueWhenValidFileAndValidXml()
	{
		$this->assertTrue( $this->_mObject->Set( _PU_ASSETS_PATH . 'RudWEb/lib/cfg/test.cfg.xml' ) );
	}

	/**
	 * @test
	 */
	public function SetReturnsTrueWhenValidDataSettingStringPairs()
	{
		$this->assertTrue( $this->_mObject->Set( 'bar', 'foo' ) );
	}

	/**
	 * @test
	 */
	public function SetReturnsTrueWhenDataIsValidArray()
	{
		$this->assertTrue( $this->_mObject->Set( array( 'key', 'value') ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidDataSettingStringPairs
	 */
	public function GetWorksOnSimpleQuery()
	{
		$this->assertEquals( 'bar', $this->_mObject->Get( 'foo' ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetWorksOnSimpleQueryWhenValueIsArray()
	{
		$values = array(
			'core' => '/home/rudisoft/www/projects/RudWEb-5.0/src/RudWEb/',
			'app' => '/home/rudisoft/www/projects/RudWEb-5.0/src/apps/SandboxApp/app/',
			'www' => '/home/rudisoft/www/projects/RudWEb-5.0/src/apps/SandboxApp/web/',
		);

		$this->assertEquals( $values, $this->_mObject->Get( 'path' ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetWorksOnSpecialQuery()
	{
		$this->assertEquals( '/home/rudisoft/www/projects/RudWEb-5.0/src/RudWEb/', $this->_mObject->Get( 'path.core' ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetWorksOnArrayInput()
	{
		$this->assertEquals( '/home/rudisoft/www/projects/RudWEb-5.0/src/RudWEb/', $this->_mObject->Get( array( 'path' , 'core' ) ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetFailsOnValidSimpleQueryButDifferentEnv()
	{
		$this->assertFalse( $this->_mObject->Get( 'foo', 'test' ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetFailsOnValidSpecialQueryButDifferentEnv()
	{
		$this->assertFalse( $this->_mObject->Get( 'path.core', 'test' ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetFailsIfQueryIsEmptyArray()
	{
		$this->assertFalse( $this->_mObject->Get( array() ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetReturnsFullArrayConfigForCurrentEnvOnNoQuery()
	{
		$this->assertType( 'array', $this->_mObject->Get() );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetWorksOnSimpleQueryFromAnotherEnv()
	{
		$this->assertEquals( 'value1', $this->_mObject->Get('setting1', 'test') );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 * @depends GetWorksOnSimpleQueryFromAnotherEnv
	 */
	public function GetWorksOnSpecialQueryFromAnotherEnv()
	{
		$this->assertEquals( 'subvalue2', $this->_mObject->Get('setting2.subsetting2', 'test') );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 * @depends GetWorksIfNoQuery
	 */
	public function GetReturnsFullConfigForAnotherEnvOnNoQuery()
	{
		$count = count( $this->_mObject->Get( NULL, 'test' ) );

		$this->assertEquals( 5, $count );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetFailsOnEmptyQueryForAnotherEnvThatHasNoData()
	{
		$this->assertFalse( $this->_mObject->Get( NULL, 'prod' ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetFailsIfValueIsEmptyArray()
	{
		$this->assertFalse( $this->_mObject->Get( NULL, 'prod' ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetFailsOnInvalidSimpleQuery()
	{
		$this->assertFalse( $this->_mObject->Get( 'noexist' ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetFailsOnInvalidSpecialQuery()
	{
		$this->assertFalse( $this->_mObject->Get( 'no.exist' ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetFailsOnInvalidArrayQuerypartOne()
	{
		$this->assertFalse( $this->_mObject->Get( array( 'no', 'exist' ) ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetFailsOnInvalidArrayQueryPartTwo()
	{
		$this->assertFalse( $this->_mObject->Get( array( 'no'=>'exist' ) ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetFailsOnInvalidSimpleQueryAnotherEnv()
	{
		$this->assertFalse( $this->_mObject->Get( 'noexist', 'test' ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetFailsOnInvalidSpecialQueryAnotherEnv()
	{
		$this->assertFalse( $this->_mObject->Get( 'no.exist', 'test' ) );
	}

	/**
	 * @test
	 *
	 * @depends SetReturnsTrueWhenValidFileAndValidXml
	 */
	public function GetFailsOnInvalidArrayQueryAnotherEnv()
	{
		$this->assertFalse( $this->_mObject->Get( array( 'no'=>'exist' ), 'test' ) );
	}

}
?>