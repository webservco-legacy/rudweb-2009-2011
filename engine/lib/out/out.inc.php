<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Output library
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-18 12:03:00
 * @access     public
 * @package    rwOut
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
	 * Display "Not Found" page.
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * rw_iOutput.
 *
 * Methods to be implemented by all output classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwOut
 */
interface rw_iOutput
{
	/**
	 * Set application skin directory path.
	 *
	 * @param string $outSkinDir application skin directory name
	 * @return mixed result
	 */
	public function outSkinDir($outSkinDir);

	/**
	 * Set output variables.
	 *
	 * @param mixed $name variable name
	 * @param mixed $value variable value
	 * @return mixed result
	 */
	public function set($name, $value);

	/**
	 * Parse output.
	 *
	 * @param string $outTemplate template file to parse
	 * @param boolean $outDisplay send output to browser or return it?
	 * @return mixed result
	 */
	public function parse($outTemplate, $outDisplay);
}

/**
 * rw_Output.
 *
 * Global values and methods for all output classes.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwOut
 */
class rw_Output
{
	/**
	 * Default output engine.
	 *
	 * @var mixed
	 */
	private $outEngine = NULL;

	/**
	 * Default application skin.
	 *
	 * @var mixed
	 */
	private $outSkin = NULL;

	/**
	 * Default template file.
	 *
	 * @var mixed
	 */
	private $outTemplate = NULL;

	/**
	 * Default output data.
	 *
	 * @var array
	 */
	private $outData = array();

	/**
	 * Constructor.
	 *
	 * Sets default values.
	 *
	 * @return mixed result
	 */
	public function __construct()
	{
		/**
		 * Default output engine.
		 */
		$this->outEngine = 'RudWEb';
		/**
		 * Set output skin.
		 */
		$this->setOutSkin(_APP_SKIN);
		/**
		 * Default template file.
		 */
		$this->outTemplate = 'layout';
		/**
		 * Default output data.
		 */
		$this->outData = array();
	}

	/**
	 * Set output skin.
	 *
	 * @param sting $outSkin
	 * @return mixed result
	 */
	public function setOutSkin($outSkin)
	{
		/**
		 * Set output skin.
		 *
		 */
		$this->outSkin = $outSkin;
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Parse output
	 *
	 * @param mixed $outTemplate template file to parse
	 * @param mixed $outData data to include in template
	 * @param mixed $outSkin application skin to use
	 * @param mixed $outEngine output engine to use
	 * @param boolean $outDisplay send output to browser or return it?
	 * @return mixed result
	 */
	public function output($outTemplate=NULL, $outData=NULL, $outSkin=NULL, $outEngine=NULL, $outDisplay=TRUE)
	{
		/**
		 * Set output engine to be used.
		 *
		 * If no special request use default.
		 */
		$outEngine = $outEngine ? $outEngine : $this->outEngine;
		/**
		 * Set application skin to be used.
		 *
		 * If no special request use default.
		 */
		$outSkin = $outSkin ? $outSkin : $this->outSkin;
		/**
		 * Set template file to be parsed.
		 *
		 * If no special request use default.
		 */
		$outTemplate = $outTemplate ? $outTemplate : $this->outTemplate;
		/**
		 * Set data to be parsed.
		 *
		 * If no special request use default.
		 */
		$outData = $outData ? $outData : $this->outData;
		/**
		 * Load output engine.
		 */
		$outObj = $this->_load($outEngine);
		/**
		 * Set application skin directory.
		 */
		$outObj->outSkinDir(_APP_SKIN_DIR.$outSkin.'/');
		/**
		 * Parse data to include in template.
		 */
		foreach($outData as $name => $value)
		{
			/**
			 * Set data to include in template.
			 */
			$outObj->set($name, $value);
		}
		/**
		 * Return output data.
		 */
		return $outObj->parse($outTemplate.'.tpl.php', $outDisplay);
	}

	/**
	 * Load an output engine.
	 *
	 * @param string $outEngine output engine to be used
	 * @return mixed result
	 */
	private function _load($outEngine)
	{
		/**
		 * Set output engine class name.
		 */
		$outClass = 'rw_Output_' . $outEngine;
		/**
		 * Set output engine class path.
		 */
		$outPath = _RW_LIB_DIR.'out/out.'.$outEngine.'.inc.php';
		/**
		 * Check if output engine file exists.
		 */
		if (!is_readable($outPath))
		{
			/**
			 * Show error message.
			 */
			trigger_error('Output::Can not load specified output engine. File not found.', 256);
		}
		/**
		 * Load output engine file.
		 */
		require_once($outPath);
		/**
		 * Return output engine class.
		 */
		return new $outClass();
	}
}
?>