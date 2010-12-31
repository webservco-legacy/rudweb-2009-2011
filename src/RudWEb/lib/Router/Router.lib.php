<?php
/**
 * $Id$
 *
 * Router library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
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
		Core::Log()->Write( __( 'Router library: Initializing routing.', 'RudWEb' ), 'debug' );

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
		 * Empty get array for security.
		 */
		$this->_EmptyGet();

		/**
		 * Get parsed request.
		 *
		 * @var array
		 */
		$request = $this->_GetParsedRequest();

		/**
		 * Format final request.
		 */
		return $this->_FormatFinalRequest( $request );
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
			Core::Log()->Write( __( 'Router library: Performing PATH_INFO routing.', 'RudWEb' ), 'debug' );

			/**
			 * Set request.
			 *
			 * @var string
			 */
			$request = $this->_ProcessRequest( $_SERVER['PATH_INFO'] );
		}
		else if ( isset( $_SERVER['ORIG_PATH_INFO'] ) )
		{
			Core::Log()->Write( __( 'Router library: Performing ORIG_PATH_INFO routing.', 'RudWEb' ), 'debug' );

			/**
			 * Set request.
			 *
			 * @var string
			 */
			$request = $this->_processRequest( $_SERVER['ORIG_PATH_INFO'] );
		}
		else if ( isset( $_SERVER['REQUEST_URI'] ) )
		{
			Core::Log()->Write( __( 'Router library: Performing REQUEST_URI routing.', 'RudWEb' ), 'debug' );

			/**
			 * Set request.
			 *
			 * @var string
			 */
			$request = $this->_processRequest( $_SERVER['REQUEST_URI'] );
		}
		/**
		 * In this case the request is old style (?option=value)
		 * so we need to do some rewriting.
		 */
		else if ( isset( $_SERVER['QUERY_STRING'] ) && ( '' != $_SERVER['QUERY_STRING'] ) )
		{
			Core::Log()->Write( __( 'Router library: Performing QUERY_STRING routing.', 'RudWEb' ), 'debug' );

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
	 * @param string $firstPart
	 *
	 * @return string
	 */
	private function _ProcessRequest( $firstPart = NULL )
	{
		if ( FALSE !== strpos( $firstPart, 'index.php?' ) )
		{
			return $this->_ProcessQueryString();
		}

		/**
		 * Initialize first  part of request.
		 *
		 * @var string
		 */
		$req1 = $this->_FormatRequest( $firstPart );

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
			$req2 = $this->_FormatRequest( $_SERVER['QUERY_STRING'] );
		}

		return $this->RemoveFakeExtension( $req1 . $req2 );
	}

	/**
	 * Transform normal request string into custom one.
	 *
	 * @param string $requestString
	 *
	 * @return string
	 */
	private function _FormatRequest( $requestString )
	{
		/**
		 * @var string
		 */
		$request_string = str_replace( '&', '/', $requestString );

		/**
		 * @var string
		 */
		$request_string = str_replace( '=', '/', $request_string );

		/**
		 * @var string
		 */
		$request_string = str_replace( '//', '/0/', $request_string );

		return $request_string;
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
		Core::Log()->Write( __( 'Router library: Parsing custom routes.', 'RudWEb' ), 'debug' );

		/**
		 * Set costom routes, (and also default route).
		 */
		$this->_SetCustomRoutes();

		/**
		 * Check for empty request.
		 */
		if ( NULL == $this->_mRequest )
		{
			Core::Log()->Write( __( 'Router library: Empty request. Setting to default.', 'RudWEb' ), 'debug' );

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

				Core::Log()->Write( __( 'Router library: Found matching custom route.', 'RudWEb' ), 'debug' );

				return TRUE;
			}
		}

		Core::Log()->Write( __( 'Router library: No matching custom route found.', 'RudWEb' ), 'debug' );

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
		$routes = Core::Config()->Get( 'route' );

		if ( empty( $routes ) )
		{
			$this->_mCustomRoutes = array();

			return FALSE;
		}

		foreach ( $routes as $route )
		{
			if ( 'index' == $route['name'] )
			{
				Core::Log()->Write( __( 'Router library: Setting default route.', 'RudWEb' ), 'debug' );

				/**
				 * @var string
				 */
				$this->_mDefaultRoute = $route['value'];
			}
			else
			{
				Core::Log()->Write( __( 'Router library: Setting custom route.', 'RudWEb' ), 'debug' );

				/**
				 * @var array
				 */
				$this->_mCustomRoutes[$route['name']] = $route['value'];
			}
		}

		return TRUE;
	}

	/**
	 * Empty get array.
	 *
	 * @return bool
	 */
	private function _EmptyGet()
	{
		/**
		 * Check if a request exists.
		 */
		if( !empty( $_GET ) )
		{
			/**
			 * Ignore existing request.
			 */
			$_GET = array();

			Core::Log()->Write( __( 'Router library: Emptying $_GET array.', 'RudWEb' ), 'debug' );

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Parse request for returning to application library.
	 *
	 * @return array
	 */
	private function _GetParsedRequest()
	{
		/**
		 * Create list of keys.
		 *
		 * @var_array
		 */
		$request_keys = array( 'module', 'controller', 'action', 'query' );

		/**
		 * Split request in four parts.
		 *
		 * @var array
		 */
		$request_values = explode( '/', $this->_mRequest, 4 );

		/**
		 * @var int
		 */
		$total_values = count( $request_values );

		/**
		 * Check if we have enough values.
		 */
		if ( 4 > $total_values )
		{
			/**
			 * Fill with blanks.
			 */
			$request_values = array_pad( $request_values, 4, NULL );
		}

		/**
		 * Create new request array.
		 *
		 * @var array
		 */
		$request = array_combine( $request_keys, $request_values );

		/**
		 * If module is empty, set it to default.
		 *
		 * @var string
		 */
		$request['module'] = ( !empty( $request['module'] ) ) ?
		Core::Security()->FilterInput( $request['module'], TRUE, TRUE ) :
		Core::Config()->Get( 'router.default.module' );

		/**
		 * If controller is empty, set it to default.
		 *
		 * @var string
		 */
		$request['controller'] = ( !empty( $request['controller'] ) ) ?
		Core::Security()->FilterInput( $request['controller'], TRUE, TRUE ) :
		Core::Config()->Get( 'router.default.controller' );

		/**
		 * If action is empty, set it to default.
		 *
		 * @var string
		 */
		$request['action'] = ( !empty( $request['action'] ) ) ?
		Core::Security()->FilterInput( $request['action'], TRUE, TRUE ) :
		Core::Config()->Get( 'router.default.action' );

		/**
		 * If query is not empty, filter it.
		 *
		 * @var string
		 */
		$request['query'] = ( !empty( $request['query'] ) ) ?
		Core::Security()->FilterInput( $request['query'], TRUE, TRUE ) :
		'';

		/**
		 * Set final location.
		 *
		 * This contains only the url route with the request query filtered out.
		 *
		 * @var string
		 */
		$request['location'] = rtrim( str_replace( $request['query'], '', $this->_mLocation ), '/' );

		Core::Log()->Write( __( 'Router library: Request parsing done.', 'RudWEb' ), 'debug' );

		return $request;
	}

	private function _FormatFinalRequest( $request )
	{
		/**
		 * @var string
		 */
		$module = ucfirst( strtolower( $request['module'] ) );

		/**
		 * @var string
		 */
		$request['module'] = 'Module_' . $module;

		/**
		 * @var string
		 */
		$controller = ucfirst( strtolower( $request['controller'] ) );

		/**
		 * @var string
		 */
		$request['controller'] = 'Controller_' . $module . '_' . $controller;

		/**
		 * @var string
		 */
		$request['action'] = ucfirst( strtolower( $request['action'] ) );

		/**
		 * @var array
		 */
		$request['query'] = ( !empty( $request['query'] ) ) ? $this->ParseRequestQuery( $request['query'] ) : array();

		Core::Log()->Write( __( 'Router library: Request formatting done.', 'RudWEb' ), 'debug' );

		Core::Log()->Write( __( 'Router library: Routing complete.', 'RudWEb' ), 'debug' );

		return $request;
	}

	/**
	 * Format request query.
	 *
	 * Returns key/value or numeric indexed array.
	 * Request can be in the form 'lorem/ipsum/dolor/sic'.
	 * If parameter count is not even, the last parameter
	 * is returned as ['param'] = 'param'.
	 *
	 * @param string $requestQuery
	 * @param bool $returnNumeric return numeric indexed array instead of key/value?
	 *
	 * @return array
	 */
	public function ParseRequestQuery( $requestQuery, $returnNumeric = FALSE )
	{
		/**
		 * @var array
		 */
		$query = array();

		/**
		 * @var array
		 */
		$raw_query = explode( '/', $requestQuery );

		/**
		 * @var array
		 */
		$raw_query = array_diff( $raw_query, array('') );

		if ( FALSE !== $returnNumeric )
		{
			return $raw_query;
		}

		$params = count( $raw_query );

		for( $position = 0; $position < $params; $position += 2 )
		{
			/**
			 * If the data count is not even, set the last value the same as the key.
			 *
			 * @var array
			 */
			$query[$raw_query[$position]] = ( $position == ( $params - 1 ) ) ?
			$raw_query[$position] :
			$raw_query[$position+1];
		}

		Core::Log()->Write( __( 'Router library: Parsed request query.', 'RudWEb' ), 'debug' );

		return $query;
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
		$extension = Core::Config()->Get( 'seo.extension' );

		/**
		 * @var bool
		 */
		$check = Core::String()->EndsWith( $extension, $request );

		/**
		 * Check if request ends with the fake extension.
		 */
		if ( ( '' != $extension ) && ( FALSE !== $check ) )
		{
			Core::Log()->Write( __( 'Router library: Removing fake extension.', 'RudWEb' ), 'debug' );

			return str_replace( $extension, '', $request );
		}

		return $request;
	}
}
?>