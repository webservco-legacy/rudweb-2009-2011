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

$cfg['env'] = 'dev';
$cfg['path_core'] = './RudWEb/';

if ( is_readable( './etc/path.cfg.xml' ) )
{
	$cfg_path = simplexml_load_file('./etc/path.cfg.xml');

	$cfg['path_core'] = ($cfg_path->$cfg['env']->path->core) ? trim( $cfg_path->$cfg['env']->path->core ) : './RudWEb/';
}

if ( FALSE != version_compare( PHP_VERSION, '5.3.0', '<' ) )
{
	require $cfg['path_core'] . 'lib/core/CoreCompat.lib.php';
}

require $cfg['path_core'] . 'lib/core/Core.lib.php';
require $cfg['path_core'] . 'lib/library/Library.lib.php';
require $cfg['path_core'] . 'lib/cfg/Cfg.lib.php';

Core::Cfg()->SetEnv( $cfg['env'] );
Core::Cfg()->Set( $cfg_path );

/* FROM HERE -> APPLICATION */


spl_autoload_register( array( 'Core', 'Load' ) );

// init log
$log_path = Core::Cfg()->Get( 'path.app' ) . 'var/log/';
Core::Log()->SetPath( $log_path );
Core::Log()->Reset();

Core::Log()->Write( 'Application start.', 'debug' );
Core::Log()->Write( 'Core library loaded.', 'debug' );
Core::Log()->Write( 'Configuration library loaded.', 'debug' );

Core::Error()->Load();
Core::Log()->Write( 'Error library loaded.', 'debug' );


Core::Log()->Write( 'Hello World');

try
{
	//trigger_error( 'Helo World' );
}
catch ( ErrorException $e )
{
	Core::Error()->Report( $e );
}

Core::Error()->Unload();
Core::Log()->Write( 'Error library unloaded.', 'debug' );

Core::Log()->Write( 'Application end.', 'debug' );
/* TILL HERE -> APPLICATION */

//echo '<pre>';
//var_dump( Core::Cfg()->Get( 'path.core' ) );
//echo '</pre>';
?>