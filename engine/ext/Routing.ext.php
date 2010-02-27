<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>URL Routing extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
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
class rw_Extension_Routing extends rw_Extension implements rw_iExtension
{
	/**
	 * Default request.
	 *
	 * @var string
	 */
	private $defaultRequest = NULL;
	/**
	 * Request.
	 *
	 * @var string.
	 */
	private $request = NULL;

	/**
	 * Location.
	 *
	 * Useful for redirects.
	 * This is set to url route,
	 * not necessarily module/action.
	 * In this class however, it is stored as full location including request query.
	 * It is only filtered when passed to $_GET.
	 *
	 * @var string
	 */
	private $location = NULL;

	/**
	 * Routes.
	 *
	 * @var array
	 */
	private $customRoutes = array();

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
	 * Get, parse and set request.
	 *
	 * @return mixed result
	 */
	public function rwRouting()
	{
		/**
		 * Set current request.
		 *
		 */
		$this->request = $this->_getRequest();
		/**
		 * Set temporary location to current request.
		 */
		$this->location = $this->request;
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
			$request = $this->_processRequest();
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
			$request = $this->_processRequest(TRUE);
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
		 * Strip / from beginning.
		 */
		$request = ltrim($request, '/');
		/**
		 * Strip / from end.
		 */
		$request = rtrim($request, '/');
		/**
		 * Return result.
		 */
		return $request;
	}

	/**
	 * Process request.
	 *
	 * We need to check for both PATH_INFO and QUERY_STRING
	 *
	 * @param boolean $orig use 'ORIG_PATH_INFO' instead of 'PATH_INFO'
	 * @return mixed result
	 */
	private function _processRequest($orig=FALSE)
	{
		/**
		 * Set first part of request to PATH_INFO.
		 */
		$req1 = $orig ? $_SERVER['ORIG_PATH_INFO'] : $_SERVER['PATH_INFO'];
		/**
		 * Initialize second part of request.
		 */
		$req2 = '';
		/**
		 * Check for QUERY_STRING.
		 */
		if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '')
		{
			/**
			 * Process request. Replace '&' with '/'.
			 */
			$req2 = str_replace('&', '/', $_SERVER['QUERY_STRING']);
			/**
			 * Process request. Replace '=' with '/'.
			 */
			$req2 = str_replace('=', '/', $req2);
			/**
			 * Process request. Replace empty values with '0'.
			 */
			$req2 = str_replace('//', '/0/', $req2);
		}
		/**
		 * Return result.
		 */
		return $req1.$req2;
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
		 * Set new URL.
		 */
		$url = 'http://'.$server.$req_uri;
		/**
		 * Redirect to new URL.
		 */
		header("Location: ".$url);
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
		require_once(_APP_CFG_DIR.'routing.cfg.php');
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
			if (preg_match('#^'.$route.'$#', $this->request) || preg_match('#^'.$route.'/$#', $this->request))
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
		$k = array('section', 'module', 'action', 'query');
		/**
		 * Split request.
		 */
		$v = explode('/', $this->request, 4);
		/**
		 * Check if request has enough elements.
		 */
		if (count($v) < 4)
		{
			/**
			 * Fill with blanks.
			 */
			$v = array_pad($v, 4, NULL);
		}
		/**
		 * Create new request array.
		 */
		$r = array_combine($k, $v);
		/**
		 * Check for empty module.
		 *
		 * If empty set it to 'index'.
		 */
		$r['module'] = ($r['module']) ? $r['module'] : 'index';
		/**
		 * Check for empty action.
		 *
		 * If empty set it to 'index'.
		 */
		$r['action'] = ($r['action']) ? $r['action'] : 'index';
		/**
		 * Set final location.
		 *
		 * This contains only the url route with the request query filtered out.
		 */
		$r['location'] = rtrim(str_replace($r['query'], '', $this->location), '/');
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

	/**
	 * Redirect to specified action.
	 *
	 * Action can be:
	 * - BLANK (do a self redirect)
	 * - index (redirect to home page)
	 * - string (redirect to specified action)
	 * Specified action is actually the full request,
	 * eg. MODULE [/ACTION] [/REQUEST]
	 *
	 * @param atring $action where to redirect
	 * @return mixed result
	 */
	public function rwRedirect($action=NULL)
	{
		/**
		 * Check if action is set.
		 */
		if (!$action)
		{
			/**
			 * Do a self-redirect.
			 */
			return $this->_rwSelfRedirect();
		}
		/**
		 * Set action.
		 *
		 * Check if home page is requested,
		 * otherwise set to requested action.
		 */
		$action = ($action == 'index') ? '' : $action;
		/**
		 * Set new URL.
		 */
		$url = _APP_URL . $action;
		/**
		 * Redirect to new URL.
		 */
		header("Location: ".$url);
		/**
		 * Stop execution.
		 */
		exit;
	}

	/**
	 * Redirect to self.
	 *
	 * Usefull after posting data
	 * to avoid multiple submits.
	 *
	 * @return mixed result
	 */
	private function _rwSelfRedirect()
	{
		/**
		 * Check for HTTP_HOST.
		 */
		if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != '')
		{
			/**
			 * Set new URL.
			 */
			$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		/**
		 * Check for SERVER_NAME.
		 */
		else if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != '')
		{
			/**
			 * Set new URL.
			 */
			$url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		}
		/**
		 * Nothing found.
		 */
		else
		{
			/**
			 * Set new url to application URL.
			 */
			$url = _APP_WWW;
		}
		/**
		 * Redirect to new URL.
		 */
		header("Location: ".$url);
		/**
		 * Stop execution.
		 */
		exit;
	}

	/**
	 * Parse and check redirect action.
	 *
	 * Get base64_encoded string and return redirect action.
	 * If decoded action if not valid, the default 'index' action is returned.
	 *
	 * @param string $s encoded action string
	 * @return mixed result
	 */
	public function rwRedirectAction($s)
	{
		/**
		 * Decode action string.
		 */
		$act = base64_decode($s);
		/**
		 * Check if we have a valid action.
		 *
		 * Return decoded action, or NULL if no valid action.
		 */
		return preg_match("/^[a-zA-Z0-9\/\-\_]+$/", $act) ? $act : 'index';
	}

	/**
	 * Parse request string.
	 *
	 * Return key/value array.
	 * Request can be in the form 'page/1/country/RO/language/EN'.
	 * If parameter is not even, the last parameter
	 * is returned as ['param'] = 'param'.
	 *
	 * @param string $request request string.
	 * @return array result
	 */
	public function parseRequest($request, $num=FALSE)
	{
		/**
		 * Initialize data.
		 */
		$data = array();
		/**
		 * Get raw data.
		 */
		$raw = array_diff(explode('/', $request), array(''));
		/**
		 * Check if we should return the values as a number indexed array.
		 */
		if($num)
		{
			/**
			 * Return the raw data.
			 */
			return $raw;
		}
		/**
		 * Count raw data.
		 */
		$t = count($raw);
		/**
		 * Iterate through the raw data.
		 */
		for($i=0;$i<$t;$i+=2)
		{
			/**
			 * Set new data.
			 *
			 * If the data count is not even, set the last value the same as the key.
			 */
			$data[$raw[$i]] = ($i==($t - 1)) ? $raw[$i] : $raw[$i+1];
		}
		/**
		 * Return data.
		 */
		return $data;
	}
}
?>