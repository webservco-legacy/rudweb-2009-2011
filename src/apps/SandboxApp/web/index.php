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
	$path_cfg = simplexml_load_file('./etc/path.cfg.xml');

	$cfg['path_core'] = ($path_cfg->$cfg['env']->path->core) ? trim( $path_cfg->$cfg['env']->path->core ) : './RudWEb/';
}

if ( FALSE != version_compare( PHP_VERSION, '5.3.0', '<' ) )
{
	require $cfg['path_core'] . 'lib/Core/CoreUtils.lib.php';
}

require $cfg['path_core'] . 'lib/Core/Core.lib.php';
require $cfg['path_core'] . 'lib/Library/Library.lib.php';
require $cfg['path_core'] . 'lib/Cfg/Cfg.lib.php';

Core::Cfg()->SetEnv( $cfg['env'] );
Core::Cfg()->Set( $path_cfg );

/**
 * Register class autoload method.
 */
spl_autoload_register( array( 'Core', 'Load' ) );

/* FROM HERE -> APPLICATION */

Core::App()->Boot();

try
{

	echo __( 'Hello World!' );

	echo '<br />';

	$hello_world = Controller_Helloworld_Helloworld::GetInstance();

	echo $hello_world->world();

	//trigger_error( 'Helo World' );

	//Database_Mysql::GetInstance();
	//Core::Db();

	var_dump( Core::Db()->EscapeString( "h'ello world" ) );

}
catch ( ErrorException $e )
{
	Core::Error()->Report( $e );
}


Core::App()->Shutdown();
?>