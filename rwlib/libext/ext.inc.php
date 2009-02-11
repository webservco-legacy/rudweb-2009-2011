<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Extension building classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-01-06 14:11:00
 * @access     public
 * @package    RudWEb
 * @subpackage Extensions
 * @todo       stuff
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
 * Prevent direct file access
 */
if(!defined('_RW_VALID')) {require_once('./index.php'); exit;}

/**
 * rw_iExt
 *
 * Methods to be implemented by all extension classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Extensions
 */
interface rw_iExt
{
	/**
	 * Method for displaying information about the extension
	 *
	 * @return mixed information about the extension
	 */
	function extAbout();
}
/**
 * rw_Ext_global
 *
 * Global values and methods for all extension classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Extensions
 */
class rw_Ext_global
{
	/**
	 * Set extension info
	 */
	public $extAbout = array();
	/**
	 * Load the extension and set it to global or local
	 *
	 * @param aray $extAbout extension information
	 * @return mixed result of loading
	 */
	function __construct($extAbout)
	{
		$this->extAbout = $extAbout;
	}
	/**
	 * Method for displaying information about the extension
	 *
	 * @return mixed information about the extension
	 */
	function extAbout()
	{
		return $this->extAbout;
	}
}
?>