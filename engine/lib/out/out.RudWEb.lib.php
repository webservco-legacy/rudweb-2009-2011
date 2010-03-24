<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>RudWEb Output Class
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-18 17:44:00
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
	 * Stop script execution.
	 */
	exit;
}

/**
 * rw_Output_RudWEb
 *
 * RudWEb output class.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwOut
 */
class rw_Output_RudWEb implements rw_iOutput
{
	/**
	 * Application skin directory path.
	 *
	 * @var string
	 */
	private $outSkinDir;

	/**
	 * Output data to be parsed.
	 *
	 * @var mixed
	 */
	private $outData = array();

	/**
	 * Constructor.
	 *
	 * @return mixed result
	 */
	public function __construct()
	{
		/**
		 *
		 */
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/out/rw_iOutput#outSkinDir($outSkinDir)
	 */
	public function outSkinDir($outSkinDir)
	{
		/**
		 * Set application skin directory path.
		 */
		$this->outSkinDir = $outSkinDir;
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/out/rw_iOutput#set($name, $value)
	 */
	public function set($name, $value)
	{
		/**
		 * Set output variables.
		 */
		$this->outData[$name] = $value;
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/out/rw_iOutput#parse($outTemplate, $outDisplay)
	 */
	public function parse($outTemplate, $outDisplay)
	{
		/**
		 * Check if template file exists.
		 */
		if (!is_readable($this->outSkinDir.$outTemplate))
		{
			/**
			 * Show error message.
			 */
			trigger_error('Output:::NO_TEMPLATE:::'.$outTemplate, 256);
		}
		/**
		 * Turn on output buffering.
		 */
		ob_start();
		/**
		 * Import output variables.
		 */
		extract($this->outData);
		/**
		 * Load template file.
		 */
		include($this->outSkinDir.$outTemplate);
		/**
		 * Get parsed output result from the output buffer.
		 */
		$outData = ob_get_contents();
		/**
		 * Delete output buffer and turn off output buffering.
		 */
		ob_end_clean();
		/**
		 * Check if we should send output to browser.
		 */
		if ($outDisplay)
		{
			/**
			 * Display output data.
			 */
			echo $outData;
			/**
			 * Return result.
			 */
			return TRUE;
		}
		/**
		 * Return output, don't send it to browser.
		 */
		else
		{
			/**
			 * Return output data, don't display it.
			 */
			return $outData;
		}
	}
}
?>