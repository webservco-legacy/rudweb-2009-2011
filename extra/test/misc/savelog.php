<?php
/**
 * $Id$
 *
 * Download log file.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudTest
 * @subpackage Misc
 * @version    $Revision$
 * @since      Version 5
 * @access     public
 * @filesource
 */

if ( !isset( $_GET['log'] ) )
{
	exit();
}

/**
 * Settings
 */
require_once './settings.cfg.php';

/**
 * @var string
 */
$log_file = strip_tags( $_GET['log'] );

/**
 * @var string
 */
$log_path =  $cfg['work_dir'] . $log_file;

header("Content-type: text/plain");
header("Content-Disposition: attachment;filename=$log_file");
header("Content-Transfer-Encoding: binary");
header('Pragma: no-cache');
header('Expires: 0');
readfile( $log_path );
?>