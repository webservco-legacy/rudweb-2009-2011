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
 * Security token.
 */
define( '_RUDWEB', TRUE );

/**
 * Load required files.
 */
require 'RudWEb/lib/core/Core.lib.php';
require 'RudWEb/lib/core/CoreCompat.lib.php';
require 'RudWEb/lib/library/Library.lib.php';
require 'RudWEb/lib/cfg/Cfg.lib.php';
require 'RudWEb/lib/error/Error.lib.php';
require 'phpunit.cfg.php';

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
}
?>