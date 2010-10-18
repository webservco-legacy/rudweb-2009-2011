<?php
/**
 * $Id$
 *
 * Application index.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    SandboxApp
 * @subpackage Index
 * @version    $Revision$
 * @since      Version 5
 * @access     public
 * @filesource
 */

/**
 * Security token.
 */
define( '_RUDWEB', TRUE );

/**
 * Set environment.
 *
 * @var string
 */
$cfg['env'] = 'dev';

/**
 * Init core path.
 *
 * @var string
 */
$cfg['path_core'] = './RudWEb/';

if ( is_readable( './etc/path.cfg.xml' ) )
{
	/**
	 * @var object
	 */
	$path_cfg = simplexml_load_file('./etc/path.cfg.xml');

	/**
	 * @var string
	 */
	$cfg['path_core'] = ($path_cfg->$cfg['env']->path->core) ? trim( $path_cfg->$cfg['env']->path->core ) : './RudWEb/';
}

/**
 * Check if PHP version is less than 5.3
 */
if ( FALSE != version_compare( PHP_VERSION, '5.3.0', '<' ) )
{
	/**
	 * Load compatibility library.
	 */
	require $cfg['path_core'] . 'lib/Core/CoreUtils.lib.php';
}

/**
 * Load core and configuration libraries.
 */
require $cfg['path_core'] . 'lib/Core/Core.lib.php';
require $cfg['path_core'] . 'lib/Library/Library.lib.php';
require $cfg['path_core'] . 'lib/Cfg/Cfg.lib.php';

/**
 * Set environment.
 */
Core::Cfg()->SetEnv( $cfg['env'] );

/**
 * Set paths.
 */
Core::Cfg()->Set( $path_cfg );

/**
 * Register class autoload method.
 */
spl_autoload_register( array( 'Core', 'Load' ) );

/**
 * Boot application.
 */
Core::App()->Boot();

/**
 * Run application.
 */
Core::App()->Run();

/**
 * Shutdown application.
 */
Core::App()->Shutdown();
?>