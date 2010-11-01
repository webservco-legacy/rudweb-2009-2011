<?php
/**
 * $Id$
 *
 * Misc Tests index..
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudTest
 * @subpackage Misc
 * @version    $Revision$
 * @since      Version 5
 * @access     public
 * @filesource
 */

error_reporting (E_ALL | E_STRICT);

/**
 * Settings
 */
require_once './settings.cfg.php';

/**
 * Path to library directory with trailing slash.
 *
 * eg. c:/wamp/www/test/lib/
 *
 * @var string
 */
$cfg['lib_dir'] = './lib/';

/**
 * Path to templates directory with trailing slash.
 *
 * eg. c:/wamp/www/test/tpl/
 *
 * @var string
 */
$cfg['tpl_dir'] = './tpl/';

/**
 * @var array
 */
$tests = array(
1 => 'FileTime',
2 => 'Foo',
3 => 'Bar',
);

/**
 * Set the test we are running.
 *
 * @var int
 */
$test = ( isset( $_GET['test'] ) ) ? (int) $_GET['test'] : 1;

/**
 * Set the step we're at.
 *
 * @var int
 */
$step = ( isset( $_GET['step'] ) ) ? (int) $_GET['step'] : 0;

/**
 * @var bool
 */
$continue = TRUE;

/**
 * Turn on output buffering.
 */
ob_start();

/**
 * Load misc tests library.
 */
require_once $cfg['lib_dir'] . 'MiscTests.lib.php';

/**
 * Load current test library.
 */
require_once $cfg['lib_dir'] . $tests[$test] . '.lib.php';

/**
 * Run filetime tests.
 */
require_once $cfg['lib_dir'] . $tests[$test] . '.test.php';

if ( FALSE !== $continue )
{
	/**
	 * Load template file for current test / step.
	 */
	include $cfg['tpl_dir'] . $tests[$test] . '/step' . $step . '.tpl.php';
}

/**
 * Get parsed output result from the output buffer.
 */
$message = ob_get_contents();

/**
 * Delete output buffer and turn off output buffering.
 */
ob_end_clean();

/**
 * Load layout file.
 */
include $cfg['tpl_dir'] . 'layout.tpl.php';
?>