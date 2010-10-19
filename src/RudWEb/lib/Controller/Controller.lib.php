<?php
/**
 * $Id$
 *
 * Controller library.
 *
 * All controllers extend this library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudCtrl
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
 * Module library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudCtrl
 *
 */
class Controller extends Library
{
	/**
	 * Stores the module object.
	 *
	 * @var mixed
	 */
	protected $_msModuleObject;

	/**
	 * Method to access the module object.
	 *
	 * @return object
	 */
	final public function Module()
	{
		if ( NULL == $this->_msModuleObject )
		{
			/**
			 * @var string
			 */
			$ctrl_name = get_called_class();

			/**
			 * @var array
			 */
			$ctrl_parts = explode( '_', $ctrl_name );

			/**
			 * @var string
			 */
			$module_name = 'Module_' . $ctrl_parts[1];

			/**
			 * @var object
			 */
			$this->_msModuleObject = $module_name::GetInstance();
		}

		return $this->_msModuleObject;
	}
}