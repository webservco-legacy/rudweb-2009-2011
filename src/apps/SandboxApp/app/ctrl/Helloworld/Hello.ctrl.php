<?php
/**
 * $Id$
 *
 * Hello controlller.
 *
 * Module: Hello World
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
	exit;
}

/**
 * Controller_Helloworld_Hello
 *
 * Hello Controller for Hello World module.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    SandboxApp
 * @subpackage HelloworldModule
 *
 */
class Controller_Helloworld_Hello extends Controller
{
	public function World()
	{
		/**
		 * @var array
		 */
		$data['title'] = $this->Module()->Hello() . ' ' . __( 'World!' );

		$this->Output()->Out( NULL, $data, NULL, NULL, TRUE );
	}

	public function HelloWorld()
	{
		return __( 'Hello World!' );
	}
}
?>