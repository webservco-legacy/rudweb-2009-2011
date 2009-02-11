<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Error handling classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2008-12-08 10:58:00
 * @access     public
 * @package    RudWEb
 * @subpackage Errors
 * @todo       stuff
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
 * Prevent direct file access
 */
if(!defined('_RW_VALID')) {require_once('./index.php'); exit;}

/**
 * rw_Error
 *
 * Behaves like classic php errors.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Core
 */
class rw_Error extends Exception
{
	/**
	 * Error context
	 *
	 * @var mixed $_context error context
	 */
	private $_context;
	/**
	 * Constructor
	 *
	 * @param mixed $message message
	 * @param mixed $code code
	 * @param mixed $file file
	 * @param mixed $line line
	 * @param mixed $context context
	 * @return mixed
	 */
	public function __construct($message, $code, $file, $line, $context = null)
	{
		parent::__construct($message, $code);
		$this->file = $file;
		$this->line = $line;
		$this->_context = $context;
	}
}
/**
 * rw_Error_handler
 *
 * Custom error handling class.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Core
 */
abstract class rw_Error_handler
{
	/**
	 * Sets itself as error handler
	 */
	public static function init()
	{
		set_error_handler(array('rw_Error_handler','handleError'));
		//set_exception_handler(array('rw_Error_handler','handleError'));
	}
	/**
	 * Restores error handler
	 */
	public static function restore()
	{
		restore_error_handler();
		//restore_exception_handler();
	}
	/**
	 * Handles errors
	 *
	 * @param mixed $code code
	 * @param mixed $message message
	 * @param mixed $file file
	 * @param mixed $line line
	 * @param mixed $context context
	 * @return mixed
	 */
	public static function handleError($code, $message, $file, $line, $context)
	{
		if(error_reporting() == 0)
		{
			/**
			 * 16:57 2009-01-05 If the suppression flag is used do nothing
			 */
			return NULL;
		}
		else {
			/**
			 * Handle the error
			 */
			throw new rw_Error($message, $code, $file, $line, $context);
		}
	}
}
?>