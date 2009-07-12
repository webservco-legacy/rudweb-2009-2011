<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Soft-create SEO urls.
 * <BR>Mod_rewrite helps for 100% functionality but is not necessary.
 * <BR>Insired by snippets from the PHP manual.
 * <BR>before: index.php?id=2&page=3.
 * <BR>after: index.php/id/2/page/3.
 * <BR>Doesn't work with https.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-01-06 14:20:00
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
 * Prevent direct file access
 */
if(!defined('_RW_VALID')) {require_once('./index.php'); exit;}

/**
 * rw_Ext_SeoURLs
 *
 * rw_Ext_SeoURLs extension
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Ext_SeoURLs extends rw_Ext_global implements rw_iExt
{
	/**
	 * Constructor.
	 * Set extension information and call parent constructor.
	 *
	 */
	function __construct($appCore)
	{
		/**
		 * Extension info.
		 */
		$about['name'] = 'SeoURSs';
		$about['desc'] = 'Soft-create SEO urls.';
		$about['ver']  = '$Revision$';
		$about['auth'] = 'Radu Maier';
		$about['web']  = 'http://www.rudisoft.net';
		$about['mail'] = 'rudisoft@rudisoft.net';
		$about['deps'] = array();
		$about['deps']['cfg'] = array();
		$about['deps']['ext'] = array();
		parent::__construct($about, $appCore);
	}
	/**
	 * Main extension functionality.
	 *
	 * @return null
	 */
	public function seoURLs()
	{
		/**
		 * We didn't do our stuff yet, so if a request exists it means it's normal style and will be ignored.
		 */
		if(!empty($_GET)) {$_GET = array();}
		/**
		 * Initialize request.
		 */
		$request = NULL;
		/**
		 * Start checks.
		 */
		if(isset($_SERVER['PATH_INFO']))
		{
			/**
			 * Check for PATH_INFO
			 */
			$request = $_SERVER['PATH_INFO'];

		}
		else if(isset($_SERVER['ORIG_PATH_INFO']))
		{
			/**
			 * There is a bug in PHP when run in CGI,
			 * so PATH_INFO might fail.
			 * We also check for ORIG_PATH_INFO
			 */
			$request = $_SERVER['ORIG_PATH_INFO'];
		}
		else if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '')
		{
			/**
			 * The request is old style (?some=request),
			 * so we rewrite it and do a redirect
			 */
			$qs = trim($_SERVER['QUERY_STRING']);
			$qs = str_replace('&', '/', $qs);
			$qs = str_replace('=', '/', $qs);
			$req_uri = str_replace('?'.$_SERVER['QUERY_STRING'], '/'.$qs, $_SERVER['REQUEST_URI']);
			$req_uri = str_replace('//', '/', $req_uri);
			if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != '')
			{
				$server = $_SERVER['HTTP_HOST'];
			}
			else if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != '')
			{
				$server = $_SERVER['SERVER_NAME'];
			}
			$location = 'http://'.$server.$req_uri;
			header("Location: ".$location);
		}
		else
		{
			/**
			 * No request is available.
			 * We assume no request was actually made so we do nothing.
			 */
			return TRUE;
		}
		return $this->_rewriteURL($request);
	}
	/**
	 * Rewrite GET array
	 *
	 * @param string $request the actual request to be written
	 */
	private function _rewriteURL($request=NULL)
	{
		if($request)
		{
			/**
			 * Split request by "/"
			 */
			$raw_data = explode('/',$request);
			/**
			 * Get rid of empty values
			 */
			$raw_data = array_diff($raw_data, array(''));
			/**
			 * Count total values
			 */
			$total = count($raw_data);
			$test = ($total)/2;
			/**
			 * If total number of values divides by two, we have a valid request so we can do our suff
			 */
			if(is_int($test))
			{
				/**
				 * Populate the GET array
				 */
				for($i=1;$i<=$total;$i+=2)
				{
					$_GET[$raw_data[$i]] = $raw_data[$i+1];
				}
			}
			else
			{
				/**
				 * Invalid request. Redirect to index
				 */
				header("Location: "._APP_WWW);
			}
		}
	}
}
?>