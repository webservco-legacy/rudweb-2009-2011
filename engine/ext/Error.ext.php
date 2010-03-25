<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Error handling extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-02-06 15:09:00
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
	 * Stop script execution.
	 */
	exit;
}

/**
 * Extension name.
 */
$extAbout['Error']['name'] = 'Error';
/**
 * Extension description.
 */
$extAbout['Error']['desc'] = 'Error handling methods.';
/**
 * Extension version.
 */
$extAbout['Error']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Error']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Error']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Error']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Error']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Error']['deps']['lib'] = array('Error');
/**
 * Extension extension dependencies.
 */
$extAbout['Error']['deps']['ext'] = array();

/**
 * rw_Extension_Error.
 *
 * rw_Extension_Error extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Error extends rw_Extension implements rw_iExtension
{
	/**
	 * Core library object.
	 *
	 * @var mixed
	 */
	protected $rwCore;

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
	 * Handle error logging and displaying.
	 * Try to load the output library, error module, and display nice error message.
	 *
	 * @todo log to file
	 * @todo send email
	 *
	 * @param mixed $e error object
	 * @return mixed result
	 */
	public function rwError($e)
	{
		/**
		 * Attempt to load output extension.
		 */
		$this->rwCore->rwLoadLib('Output');
		/**
		 * Get error message from error.
		 */
		$err = $this->rwCore->rwErr->getError($e);
		/**
		 * Initialize oups section and try to display message.
		 */
		$this->rwCore->rwInitModule('oups', 'core', 'index', $err);
		/**
		 * Return result.
		 */
		return TRUE;
	}
}
?>