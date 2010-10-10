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
 * @subpackage CoreCompat
 * @version    $Revision$
 * @since      Version 5
 * @access     private
 * @filesource
 */

/**
 * CoreCompatTest
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudTest
 * @subpackage Core
 *
 */
class CoreCompatTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function GetCalledClassCalledDirrectlyReturnsFalse()
	{
		$this->assertFalse( CoreCompat::GetCalledClass() );
	}
}
?>