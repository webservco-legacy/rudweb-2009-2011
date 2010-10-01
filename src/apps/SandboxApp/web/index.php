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

Core::Error()->Load();

try
{
	trigger_error( 'Helo World' );
}
catch ( ErrorException $e )
{
	Core::Error()->Report( $e );
}

Core::Error()->Unload();
/* TILL HERE -> APPLICATION */

//echo '<pre>';
//var_dump( Core::Cfg()->Get( 'path.core' ) );
//echo '</pre>';
?>