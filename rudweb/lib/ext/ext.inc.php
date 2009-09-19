<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Extension library
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-13 18:36:00
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
	public $extAbout = array();

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
	 * @return array extension information
	 */
	public function extAbout()
	{
		/**
		 * Return result.
		 */
		return $this->extAbout;
	}
}
?>