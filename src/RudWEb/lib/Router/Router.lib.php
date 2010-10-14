<?php
/**
 * $Id$
 *
 * Router library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudRouter
 * @version    $Revision$
 * @since      Version 5
 * @access     public
 * @filesource
 */

/**
 * Security check.
 */
if ( !defined( '_RUDWEB' ) )
{
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * Router library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudRouter
 *
 */
class Router extends Library
{
	/**
	 * Stores the request.
	 *
	 * @var string
	 */
	private $_mRequest;

	/**
	 * Stores the current location.
	 *
	 * Useful for redirects.
	 * This is set to url route,
	 * not necessarily module/controller/action.
	 * In this class however, it is stored as full location including request query.
	 *
	 * @var string
	 */
	private $_mLocation;

	/**
	 * Stores default route.
	 *
	 * @var string
	 */
	private $_mDefaultRoute;

	/**
	 * Stores custom routes.
	 *
	 * @var array
	 */
	private $_mCustomRoutes;

	/**
	 * Perform routing.
	 *
	 * Get, parses, and sets the request.
	 *
	 * @return array
	 */
	public function Route()
	{
		/**
		 * Set request.
		 *
		 * @var string
		 */
		$this->_mRequest = $this->_GetRequest();

		/**
		 * Set temporary location to current request.
		 *
		 * @var string
		 */
		$this->_mLocation = $this->_mRequest;

		/**
		 * Parse custom routes
		 */
		$this->_ParseCustomRoutes();

		/**
		 * XXX Set new request. (return an array instead of writing to $_GET)
		 */
		return $this->_SetRequest();
	}

	/**
	 * Get current request.
	 *
	 * @return string
	 */
	private function _GetRequest()
	{
		/**
		 * @var string
		 */
		$request = NULL;

		if ( isset( $_SERVER['PATH_INFO'] ) )
		{
			/**
			 * Set request.
			 *
			 * @var string
			 */
			$request = $this->_ProcessRequest();


		}
		else if ( isset( $_SERVER['ORIG_PATH_INFO'] ) )
		{
			/**
			 * Set request.
			 *
			 * @var string
			 */
			$request = $this->_processRequest(TRUE);
		}
		/**
		 * In this case the request is old style (?option=value)
		 * so we need to do some rewriting.
		 */
		else if ( isset( $_SERVER['QUERY_STRING'] ) && ( '' != $_SERVER['QUERY_STRING'] ) )
		{
			/**
			 * Process QUERY_STRING.
			 *
			 * This method doesn't return anything.
			 * It does a redirect.
			 */
			return $this->_ProcessQueryString();
		}

		/**
		 * @var string
		 */
		$request = ltrim($request, '/');

		/**
		 * @var string
		 */
		$request = rtrim($request, '/');

		return $request;
	}

	/**
	 * Process request.
	 *
	 * @param bool $useOrigPathInfo
	 *
	 * @return string
	 */
	private function _ProcessRequest( $useOrigPathInfo = FALSE )
	{
		/**
		 * Set first part of request to PATH_INFO or ORIG_PATH_INFO.
		 *
		 * @var string
		 */
		$req1 = $useOrigPathInfo ? $_SERVER['ORIG_PATH_INFO'] : $_SERVER['PATH_INFO'];

		/**
		 * Initialize second part of request.
		 *
		 * @var string
		 */
		$req2 = '';

		/**
		 * Check for QUERY_STRING.
		 */
		if ( isset( $_SERVER['QUERY_STRING'] ) && ( '' != $_SERVER['QUERY_STRING'] ) )
		{
			/**
			 * Process request. Replace '&' with '/'.
			 *
			 * @var string
			 */
			$req2 = str_replace( '&', '/', $_SERVER['QUERY_STRING'] );

			/**
			 * Process request. Replace '=' with '/'.
			 *
			 * @var string
			 */
			$req2 = str_replace( '=', '/', $req2 );

			/**
			 * Process request. Replace empty values with '0'.
			 *
			 * @var string
			 */
			$req2 = str_replace( '//', '/0/', $req2 );
		}

		return $req1 . $req2;
	}

	/**
	 * Process query string.
	 *
	 * Turn normal request (?option1=value1&option2=value2) into internal request (/value1/value2).
	 * Then do a redirect.
	 *
	 * @return mixed.
	 */
	private function _ProcessQueryString()
	{
		/**
		 * Init query string.
		 *
		 * It is easier to work with the $_GET so we use it instead of QUERY_STRING.
		 *
		 * @var string
		 */
		$qs = implode( '/', $_GET );

		/**
		 * Init request uri.
		 *
		 * @var string
		 */
		$req_uri = str_replace( '?' . $_SERVER['QUERY_STRING'], '/' . $qs, $_SERVER['REQUEST_URI'] );

		/**
		 * @var string
		 */
		$req_uri = str_replace( '//', '/', $req_uri );

		/**
		 * @var string
		 */
		$server = NULL;

		if ( isset( $_SERVER['HTTP_HOST'] ) && ( '' != $_SERVER['HTTP_HOST'] ) )
		{
			/**
			 * @var string
			 */
			$server = $_SERVER['HTTP_HOST'];
		}
		else if( isset( $_SERVER['SERVER_NAME'] ) && ( '' != $_SERVER['SERVER_NAME'] ) )
		{
			/**
			 * @var string
			 */
			$server = $_SERVER['SERVER_NAME'];
		}

		/**
		 * @var string
		 */
		$url = 'http://' . $server . $req_uri;

		/**
		 * Redirect to new custom URL.
		 */
		return header("Location: " . $url);
	}

	/**
	 * Parse custom routes list.
	 *
	 * This also checks for empty request and sets to default route.
	 *
	 * @return bool
	 */
	private function _ParseCustomRoutes()
	{
		/**
		 * Set costom routes, (and also default route).
		 */
		$this->_SetCustomRoutes();

		/**
		 * Check for empty request.
		 */
		if ( NULL == $this->_mRequest )
		{
			/**
			 * Set request to default request, and exit.
			 *
			 * @var string
			 */
			$this->_mRequest = $this->_mDefaultRoute;

			return TRUE;
		}

		/**
		 * Parse custom routes.
		 */
		foreach ( $this->_mCustomRoutes as $route_name => $route_value )
		{
			/**
			 * Replace {num} wildcards with regular expressions.
			 *
			 * @var string
			 */
			$route_name = str_replace('{num}', '[0-9]+', $route_name);

			/**
			 * Replace {any} wildcards with regular expressions.
			 *
			 * @var string
			 */
			$route_name = str_replace('{any}', '.+', $route_name);

			/**
			 * Check for a custom route match.
			 */
			if (
			preg_match( '#^'.$route_name.'$#', $this->_mRequest ) ||
			preg_match( '#^'.$route_name.'/$#', $this->_mRequest )
			)
			{
				/**
				 * Check for back-references.
				 */
				if (
				( strpos( $route_value, '$' ) !== FALSE ) &&
				( strpos( $route_name, '(' ) !== FALSE )
				)
				{
					/**
					 * Parse request.
					 *
					 * @var string
					 */
					$route_value = preg_replace( '#^'.$route_name.'$#', $route_value, $this->_mRequest );
				}
				/**
				 * Set new request.
				 *
				 * @var string
				 */
				$this->_mRequest = $route_value;

				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Set custom routes from config.
	 *
	 * This also sets the default route.
	 *
	 * @return bool
	 */
	private function _SetCustomRoutes()
	{
		/**
		 * @var string
		 */
		$route_cfg_file = Core::Cfg()->Get( 'path.app' ) . 'etc/route.cfg.xml';

		Core::Cfg()->Load( $route_cfg_file );

		$routes = Core::Cfg()->Get( 'route' );

		foreach ( $routes as $name => $value )
		{
			if ( 'index' == $name )
			{
				$this->_mDefaultRoute = $value;
			}
			else
			{
				$this->_mCustomRoutes[$name] = $value;
			}
		}

		return TRUE;
	}

	/**
	 * Remove fake extension from request.
	 *
	 * @param string $request
	 */
	public function RemoveFakeExtension( $request )
	{
		/**
		 * @var string
		 */
		$extension = Core::Cfg()->Get( 'seo.extension' );

		/**
		 * @var bool
		 */
		$check = Core::String()->EndsWith( $extension, $request );

		/**
		 * Check if request ends with the fake extension.
		 */
		if ( ( '' != $extension ) && ( FALSE !== $check ) )
		{
			return str_replace( $extension, '', $request );
		}

		return $request;
	}
}
?>