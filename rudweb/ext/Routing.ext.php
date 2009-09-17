<?php

/**
 * $Id$
 *
 * $URL$
 * <BR>URL Routing extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-13 18:59:00
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
$extAbout['Routing']['name'] = 'Routing';
/**
 * Extension description.
 */
$extAbout['Routing']['desc'] = 'URL Routing.';
/**
 * Extension version.
 */
$extAbout['Routing']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Routing']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Routing']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Routing']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Routing']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Routing']['deps']['lib'] = array('Error');
/**
 * Extension extension dependencies.
 */
$extAbout['Routing']['deps']['ext'] = array();

/**
 * rw_Extension_Routing.
 *
 * rw_Extension_Routing extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Routing extends rw_Extension_global implements rw_iExtension
{
	/**
	 * Default request.
	 *
	 * @var string
	 */
	public $defaultRequest = NULL;
	/**
	 * Request.
	 *
	 * @var string.
	 */
	public $request = NULL;

	/**
	 * Routes.
	 *
	 * @var array
	 */
	public $customRoutes = array();

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

	public function doRouting()
	{
		/**
		 * Get current request.
		 *
		 * Prevent empty value at the beginning.
		 */
		$this->request = ltrim($this->_getRequest(), '/');
		/**
		 * Parse custom routes.
		 */
		$this->_parseCustomRoutes();
		/**
		 * Set new request.
		 */
		$this->_setRequest();
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Get current request.
	 *
	 * @return mixed result
	 */
	private function _getRequest()
	{
		/**
		 * Init request
		 */
		$request = NULL;
		/**
		 * Check for PATH_INFO.
		 */
		if(isset($_SERVER['PATH_INFO']))
		{
			/**
			 * Set request.
			 */
			$request = $_SERVER['PATH_INFO'];
		}
		/**
		 * Check for ORIG_PATH_INFO.
		 *
		 * There is a bug in PHP.
		 * When run in CGI mode, PATH_INFO might fail.
		 * So we also check for ORIG_PATH_INFO.
		 */
		else if(isset($_SERVER['ORIG_PATH_INFO']))
		{
			/**
			 * Set request.
			 */
			$request = $_SERVER['ORIG_PATH_INFO'];
		}
		/**
		 * Check for QUERY_STRING.
		 *
		 * In this case the request is old style (?option=value)
		 * so we need to do some rewriting.
		 */
		else if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '')
		{
			/**
			 * Process QUERY_STRING.
			 *
			 * This method doesn't return anything.
			 * It does a redirect.
			 */
			$this->_processQueryString();
			/**
			 * Return result.
			 */
			return NULL;
		}
		/**
		 * Return result.
		 */
		return $request;
	}

	/**
	 * Process query string.
	 *
	 * Turn normal request (?option1=value1&option2=value2) into internal request (/value1/value2).
	 * Then do a redirect.
	 *
	 * @return mixed result.
	 */
	private function _processQueryString()
	{
		/**
		 * Init query string.
		 *
		 * It is easier to work with the $_GET so we use it instead of QUERY_STRING.
		 */
		$qs = implode('/', $_GET);
		/**
		 * Init request uri.
		 */
		$req_uri = str_replace('?'.$_SERVER['QUERY_STRING'], '/'.$qs, $_SERVER['REQUEST_URI']);
		/**
		 * Replace // with /.
		 */
		$req_uri = str_replace('//', '/', $req_uri);
		/**
		 * Check for HTTP_HOST.
		 */
		if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != '')
		{
			/**
			 * Set server name.
			 */
			$server = $_SERVER['HTTP_HOST'];
		}
		/**
		 * Check for SERVER_NAME.
		 */
		else if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != '')
		{
			/**
			 * Set server name.
			 * @var unknown_type
			 */
			$server = $_SERVER['SERVER_NAME'];
		}
		/**
		 * Set new location.
		 */
		$location = 'http://'.$server.$req_uri;
		/**
		 * Redirect to new location.
		 */
		header("Location: ".$location);
		/**
		 * Stop execution.
		 */
		exit;
	}

	/**
	 * Set custom routes from config file.
	 *
	 * This also sets the default route.
	 *
	 * @return mixed result.
	 */
	private function _setCustomRoutes()
	{
		/**
		 * Open routing config file.
		 */
		require_once(_APP_DIR.'etc/routing.cfg.php');
		/**
		 * Set default route.
		 */
		$this->defaultRequest = $routing['index'];
		/**
		 * Set custom routes.
		 */
		$this->customRoutes = array_diff_key($routing, array('index' => ''));
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Parse custom routes list.
	 *
	 * This also checks for empty request and sets to default route.
	 *
	 * @return mixed result
	 */
	private function _parseCustomRoutes()
	{
		/**
		 * Set custom routes.
		 */
		$this->_setCustomRoutes();
		/**
		 * Check for empty request.
		 */
		if (!$this->request)
		{
			/**
			 * Set request to default route.
			 */
			$this->request = $this->defaultRequest;
			/**
			 * Return result.
			 */
			return TRUE;
		}
		/**
		 * Parse custom routes.
		 */
		foreach ($this->customRoutes as $route => $newRequest)
		{
			/**
			 * Replace {num} wildcards with regular expressions.
			 */
			$route = str_replace('{num}', '[0-9]+', $route);
			/**
			 * Replace {any} wildcards with regular expressions.
			 */
			$route = str_replace('{any}', '.+', $route);
			/**
			 * Check for a custom route match.
			 */
			if (preg_match('#^'.$route.'$#', $this->request))
			{
				/**
				 * Check for back-references.
				 */
				if (strpos($newRequest, '$') !== FALSE AND strpos($route, '(') !== FALSE)
				{
					/**
					 * Parse request.
					 */
					$newRequest = preg_replace('#^'.$route.'$#', $newRequest, $this->request);
				}
				/**
				 * Set new request.
				 */
				$this->request = $newRequest;
				/**
				 * Return result.
				 */
				return TRUE;
			}
		}
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Initialize new request.
	 *
	 * Empties existing $_GET array.
	 *
	 * @return mixed result
	 */
	private function _initRequest()
	{
		/**
		 * Check if a request exists.
		 */
		if(!empty($_GET))
		{
			/**
			 * Ignore existing request.
			 */
			$_GET = array();
		}
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Set $_GET array based on request.
	 *
	 * @return mixed result
	 */
	private function _setRequest()
	{
		/**
		 * Create list of keys.
		 */
		$k = array('module', 'action', 'query');
		/**
		 * Split request.
		 */
		$v = explode('/', $this->request, 3);
		/**
		 * Check if request has enought elements.
		 */
		if (count($v) < 3)
		{
			/**
			 * Fill with blanks.
			 */
			$v = array_pad($v, 3, NULL);
		}
		/**
		 * Create new request array.
		 */
		$r = array_combine($k, $v);
		/**
		 * Check for empty action.
		 *
		 * If empty set it to 'index'.
		 */
		$r['action'] = ($r['action']) ? $r['action'] : 'index';
		/**
		 * Split the query.
		 */
		$q = ($r['query']) ? explode('/',$r['query']) : array(NULL);
		/**
		 * Split the query and add it to the array.
		 *
		 * XXX Not sure wether to use this.
		 */
		//$r = array_merge($r, $q);
		/**
		* Remove the query from the array.
		*
		* XXX Not sure wether to use this.
		*/
		//$r = array_diff_key($r, array('query' => ''));
		/**
		* Re-initialize $_GET array.
		*/
		$this->_initRequest();
		/**
		 * Create new $_GET array.
		 */
		$_GET = $r;
		/**
		 * Return result.
		 */
		return TRUE;
	}
}
?>