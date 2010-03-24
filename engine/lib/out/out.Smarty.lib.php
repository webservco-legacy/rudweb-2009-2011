<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Smarty Output Class
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-18 18:18:00
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
 * Set main output engine class file path.
 *
 * @var string
 */
$smartyPath = 'Smarty/2.6.26/Smarty.class.php';


/**
 * Check for main output engine class file in local 3rdparty dir.
 */
if (is_readable(_APP_OPT_DIR.$smartyPath))
{
	/**
	 * Load main output engine class file.
	 */
	require_once(_APP_OPT_DIR.$smartyPath);
}
/**
 * Check for main output engine class file in global 3rdparty dir.
 */
else if (is_readable(_CORE_OPT_DIR.$smartyPath))
{
	/**
	 * Load main output engine class file.
	 */
	require_once(_CORE_OPT_DIR.$smartyPath);
}
/**
 * Main output engine class file not found.
 */
else
{
	/**
	 * Show error message.
	 */
	trigger_error('Output:::NO_SMARTY', 256);
}

/**
 * rw_Output_Smarty
 *
 * Smarty output class.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwOut
 */
class rw_Output_Smarty extends Smarty implements rw_iOutput
{
	/**
	 * Constructor.
	 *
	 * @return mixed result
	 */
	public function __construct()
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct();
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
		$this->template_dir = $outSkinDir;
		/**
		 * Set compile directory to application tmp directory.
		 */
		$this->compile_dir = _APP_TMP_DIR;
		/**
		 * Set cache directory to application tmp directory.
		 */
		$this->cache_dir = _APP_TMP_DIR;
		/**
		 * Set config directory to application tmp directory.
		 */
		$this->config_dir = _APP_TMP_DIR;
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/out/rw_iOutput#set($name, $value)
	 */
	public function set($name, $value)
	{
		/**
		 * Call Smarty function that handles var setting.
		 */
		return $this->assign($name, $value);
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/out/rw_iOutput#parse($outTemplate, $outDisplay)
	 */
	public function parse($outTemplate, $outDisplay)
	{
		/**
		 * Check if we should send output to browser.
		 */
		if ($outDisplay)
		{
			/**
			 * Call Smarty function for parsing and displaying.
			 */
			return $this->display($outTemplate);
		}
		/**
		 * Return output, don't send it to browser.
		 */
		else
		{
			/**
			 * Call Smarty function for parsing.
			 */
			return $this->fetch($outTemplate);
		}

	}
}