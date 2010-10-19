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
 * @subpackage RudController
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
 * @subpackage RudController
 *
 */
class Controller extends Library
{
	/**
	 * Stores the module object.
	 *
	 * @var mixed
	 */
	protected $_mModuleObject;

	/**
	 * Stores the Output object.
	 *
	 * @var mixed
	 */
	protected $_mOutputObject;

	/**
	 * Method to access the module object.
	 *
	 * @return object
	 */
	final public function Module()
	{
		if ( NULL == $this->_mModuleObject )
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
			$this->_mModuleObject = $module_name::GetInstance();
		}

		return $this->_mModuleObject;
	}

	/**
	 * Method to access the Output object.
	 *
	 * @return object
	 */
	final public function Output()
	{
		if ( NULL == $this->_mOutputObject )
		{
			/**
			 * @var object
			 */
			$this->_mOutputObject = Output::GetInstance();
		}

		return $this->_mOutputObject;
	}
}