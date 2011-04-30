<?php
/**
 * $Id$
 *
 * Hello World module.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    SandboxApp
 * @subpackage HelloworldModule
 * @version    $Revision$
 * @since      Version 5
 * @access     public
 * @filesource
 */

/**
 * Security check.
 */
if ( !defined( '_RUDWEB' ) )
{
	/**
	 * Stop script execution.
	 */
	exit();
}

/**
 * Module_Helloworld
 *
 * Model class for Hello World module.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    SandboxApp
 * @subpackage HelloworldModule
 *
 */
class Module_Helloworld extends Module
{
	public function Hello()
	{
		return __( 'Hello' );
	}

}
?>