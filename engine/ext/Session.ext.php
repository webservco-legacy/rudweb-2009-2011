<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Session handling extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-21 18:47:00
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
$extAbout['Session']['name'] = 'Session';
/**
 * Extension description.
 */
$extAbout['Session']['desc'] = 'Session handling.';
/**
 * Extension version.
 */
$extAbout['Session']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Session']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Session']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Session']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Session']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Session']['deps']['lib'] = array('Error');
/**
 * Extension extension dependencies.
 */
$extAbout['Session']['deps']['ext'] = array();

/**
 * rw_Extension_Session.
 *
 * rw_Extension_Session extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Session extends rw_Extension implements rw_iExtension
{
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
	 * Initialize session data.
	 *
	 * @return mixed result
	 */
	public function rwSession()
	{
		/**
		 * Set cache limiter.
		 */
		session_cache_limiter('public, must-revalidate');
		/**
		 * Set cache expire to 10 hours (600 minutes).
		 */
		session_cache_expire(600);
		/**
		 * Set garbage collector timeout to 10 hours (36000 seconds).
		 */
		ini_set("session.gc_maxlifetime","36000");
		/**
		 * Set custom session path to application temp directory.
		 */
		ini_set("session.save_path",_APP_TMP_DIR);
		/**
		 * Start session.
		 */
		session_start();
		/**
		 * Header entity tag.
		 */
		header("ETag: PUB" . time());
		/**
		 * Header last modified tag.
		 */
		header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()-10) . " GMT");
		/**
		 * Header expires tag.
		 */
		header("Expires: " . gmdate("D, d M Y H:i:s", time() + 5) . " GMT");
		/**
		 * Header pragma tag.
		 */
		header("Pragma: no-cache");
		/**
		 * Header cache control tag.
		 */
		header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
		/**
		 * Return result.
		 */
		return TRUE;
	}
}
?>