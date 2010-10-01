<?php
/**
 * $Id$
 *
 * Logging library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudLog
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
 * XXXLog
 *
 * Logging library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudLog
 *
 */
class Log extends Library
{
	public function SetPath();
	
	public function SetLevel();
	
	public function Log( $logMessage, $logLevel = 'info', $logType = 'app', $logPath = NULL );
}
?>