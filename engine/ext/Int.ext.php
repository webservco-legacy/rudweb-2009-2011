<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Internationalization extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-22 17:14:00
 * @access     public
 * @package    rwExt
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
 * Extension name.
 */
$extAbout['Int']['name'] = 'Int';
/**
 * Extension description.
 */
$extAbout['Int']['desc'] = 'Internationalization.';
/**
 * Extension version.
 */
$extAbout['Int']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Int']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Int']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Int']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Int']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Int']['deps']['lib'] = array('Error');
/**
 * Extension extension dependencies.
 */
$extAbout['Int']['deps']['ext'] = array();

/**
 * rw_Extension_Int.
 *
 * rw_Extension_Int extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Int extends rw_Extension implements rw_iExtension
{
	/**
	 * Language.
	 *
	 * @var string
	 */
	private $rwLn;

	/**
	 * Constructor.
	 *
	 * @param array $extAbout
	 * @return mixed result
	 */
	public function __construct($extAbout)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($extAbout);
	}

	/**
	 * Main extension functionality.
	 *
	 * @param string $rwLn language
	 * @return mixed result.
	 */
	public function rwInt($rwLn)
	{
		/**
		 * Set language.
		 */
		$this->rwLn = $rwLn;
		/**
		 * Init core translation list.
		 */
		$langCore = array();
		/**
		 * Set core language path.
		 */
		$langCorePath = _RW_INT_DIR.$this->rwLn.'/lang.inc.php';
		/**
		 * Check if core language file is readable.
		 */
		if (is_readable($langCorePath))
		{
			/**
			 * Load core language file.
			 */
			require($langCorePath);
		}
		/**
		 * Set core translation list.
		 */
		$rwLang['CORE'] = $langCore;
		/**
		 * Init application translation list.
		 */
		$langApp = array();
		/**
		 * Set application language path.
		 */
		$langAppPath = _APP_INT_DIR.$this->rwLn.'/lang.inc.php';
		/**
		 * Check if application language file is readable.
		 */
		if (is_readable($langAppPath))
		{
			/**
			 * Load application language file.
			 */
			require($langAppPath);
		}
		/**
		 * Set application translation list.
		 */
		$rwLang['APP'] = $langApp;
		/**
		 * Return main translation list.
		 */
		return $rwLang;
	}

	/**
	 * Set module translation list.
	 *
	 * @return mixed result
	 */
	public function rwIntMod($modPath)
	{
		/**
		 * Init module translation list.
		 */
		$langMod = array();
		/**
		 * Set module language path.
		 */
		$langModPath = $modPath.'int/'.$this->rwLn.'/lang.inc.php';
		/**
		 * Check if application language file is readable.
		 */
		if (is_readable($langModPath))
		{
			/**
			 * Load module language file.
			 */
			require($langModPath);
		}
		/**
		 * Set module translation list.
		 */
		$rwLang['MOD'] = $langMod;
		/**
		 * Return main translation list.
		 */
		return $rwLang;
	}
}
?>