<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Extension loader tool.
 * <BR>This tool will load extensions for standalone use.
 * <BR>Loaded extensions must not have any dependencies.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-04-07 08:25:00
 * @access     public
 * @package    rwTools
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

/**
 * Security check.
 */
if (!defined('_RW_VALID'))
{
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * rw_Extension_Misc.
 *
 * rw_Extension_Misc extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Loader_Extension
{
	/**
	 * Exensions directory.
	 *
	 * @var mixed
	 */
	private $extDir;

	/**
	 * Constructor.
	 *
	 * No functionality yet.
	 */
	public function __construct()
	{

	}

	/**
	 * Set extensions directory.
	 *
	 * @param string $extDir extension directory
	 */
	public function setExtDir($extDir = './')
	{
		/**
		 * Set extension directory.
		 */
		$this->extDir = $extDir;
	}

	public function load($ext)
	{
		/**
		 * Parse extension name.
		 */
		$ext = ucfirst(strtolower($ext));
		/**
		 * Search in set extension dir.
		 */
		if (is_readable($this->extDir.$ext.'.ext.php'))
		{
			/**
			 * Load extension.
			 */
			require_once($this->extDir.$ext.'.ext.php');
		}
		/**
		 * Extension not found.
		 */
		else
		{
			/**
			 * Return result.
			 */
			return FALSE;
		}
		/**
		 * Check library dependencies.
		 */
		$libDeps = (count($extAbout[$ext]['deps']['lib']) > 0) ? TRUE : FALSE;
		/**
		 * Check extension dependencies.
		 */
		$extDeps = (count($extAbout[$ext]['deps']['ext']) > 0) ? TRUE : FALSE;
		/**
		 * Check if we have dependencies.
		 */
		if ($libDeps || $extDeps)
		{
			/**
			 * Return result.
			 */
			return FALSE;
		}
		/**
		 * Set extension class name.
		 */
		$extClass = 'rw_Extension_'.$ext;
		/**
		 * Return loaded extension.
		 */
		return new $extClass($extAbout[$ext]);
	}
}

/**
 * rw_iExtension
 *
 * Methods to be implemented by all extension classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
interface rw_iExtension
{
	/**
	 *
	 */
}

/**
 * rw_Extension.
 *
 * Global values and methods for all extension classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension
{
	/**
	 * Extension information.
	 *
	 * @var array $extAbout
	 */
	protected $extAbout = array();

	/**
	 * Constructor.
	 *
	 * Sets extension information.
	 *
	 * @param array $extAbout
	 * @return mixed result
	 */
	public function __construct($extAbout)
	{
		/**
		 * Set extension information.
		 */
		$this->extAbout = $extAbout;
	}

	/**
	 * Get extension information.
	 *
	 * Returns an information field if specified.
	 * The whole list otherwise.
	 *
	 * @param string $field field to return
	 * @return array extension information
	 */
	protected function extAbout($field=NULL)
	{
		/**
		 * Return only a field if specified and valid, or the whole list.
		 */
		return ($field && array_key_exists($field, $this->extAbout)) ? $this->extAbout[$field] : $this->extAbout;
	}

	/**
	 * Set object value.
	 *
	 * Object is passed by reference.
	 *
	 * @param string $p object name
	 * @param mixed $value object
	 * @return mixed result
	 */
	public function setObj($p, &$obj)
	{
		/**
		 * Check if the requested property exists.
		 */
		if(property_exists($this, $p))
		{
			/**
			 * Set the object.
			 */
			$this->$p = $obj;
		}
		/**
		 * Requested property doesn't exist.
		 */
		else
		{
			/**
			 * Display error message.
			 */
			trigger_error('Extension:::SET_PROPERTY', 256);
		}
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Set property value.
	 *
	 * @param string $p property name
	 * @param mixed $value property value
	 * @return mixed result
	 */
	public function setValue($p, $value)
	{
		/**
		 * Check if the requested property exists.
		 */
		if(property_exists($this, $p))
		{
			/**
			 * Set property value.
			 */
			$this->$p = $value;
		}
		/**
		 * Requested property doesn't exist.
		 */
		else
		{
			/**
			 * Display error message.
			 */
			trigger_error('Extension:::SET_PROPERTY', 256);
		}
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Set multiple property values.
	 *
	 * @param array $v property/values array
	 * @return mixd result
	 */
	public function setValues($v)
	{
		/**
		 * Parse each request.
		 */
		foreach($v as $p=>$value)
		{
			/**
			 * Set property value.
			 */
			$this->setvalue($p, $value);
		}
		/**
		 * Return result.
		 */
		return TRUE;
	}
}
?>