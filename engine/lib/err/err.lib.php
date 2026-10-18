<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Error handling library.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-07 18:44:00
 * @access     public
 * @package    rwErr
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
 * Security check.
 */
if (!defined('_RW_VALID'))
{
    /**
     * Stop script execution.
     */
    exit;
}

/**
 * rw_Error.
 *
 * Behaves like classic php errors.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwErr
 */
class rw_Error
{
    /**
     * Class constructor.
     *
     * @return mixed result
     */
    public function __construct()
    {
        /**
         * Do nothing.
         */
    }

    /**
     * Initialize error handler.
     *
     * @return mixed result
     */
    public function init()
    {
        /**
         * Set error level.
         */
        $this->_setErrorLevel();
        /**
         * Sets itself as error handler.
         */
        set_error_handler(array(new rw_Error(),'handleError'));
        /**
         * Return result.
         */
        return TRUE;
    }

    /**
     * Restore default error handler.
     *
     * @return mixed result
     */
    public function restore()
    {
        /**
         * Restore default error handler.
         */
        restore_error_handler();
        /**
         * Return result.
         */
        return TRUE;
    }

    /**
     * Handles errors.
     *
     * @param mixed $code code
     * @param mixed $message message
     * @param mixed $file file
     * @param mixed $line line
     * @param mixed $context context
     * @return mixed
     */
    public function handleError($code, $message, $file, $line, $context)
    {
        /**
         * Check if the supression flag is used.
         */
        if (error_reporting() == 0)
        {
            /**
             * Do nothing.
             */
            return NULL;
        }
        /**
         * Supression flag is not used.
         */
        else {
            /**
             * Handle the error.
             */
            throw new rw_Exception($message, $code, $file, $line, $context);
        }
    }

    /**
     * Get error details for output.
     *
     * @param mixed $e error
     * @return array error details
     */
    public function getError($e)
    {
        /**
         * Parse message text.
         */
        $msg = $this->_parseErrorMsg($e->getMessage());
        /**
         * Count message parts.
         */
        $t = count($msg);
        /**
         * Type.
         */
        $err['type'] = $msg[0];
        /**
         * Message.
         */
        $err['msg'] = $msg[1];
        /**
         * Initialize message arguments.
         */
        $err['msga'] = array();
        /**
         * Check if we have message arguments
         */
        if($t > 2)
        {
            /**
             * Take each mesage argument.
             */
            for($i=2;$i<$t;$i++)
            {
                /**
                 * Add message argument to the list.
                 */
                $err['msga']['%'.($i-2).'%'] = $msg[$i];
            }
        }
        /**
         * Time.
         */
        $err['time'] = date("Y-m-d H:i:s");
        /**
         * Code.
         */
        $err['code'] = $e->getCode();
        /**
         * Code string.
         */
        $err['codestr'] = $this->_getErrorType($err['code']);
        /**
         * File.
         */
        $err['file'] = $e->getFile();
        /**
         * Line
         */
        $err['line'] = $e->getLine();
        /**
         * Trace.
         *
         * !WARNING!
         * This is disabled for security reasons.
         * If enabled, it displays a lot of information,
         * including, among others, database access credentials.
         *
         * $err['trace'] = $e->getTrace();
         */
        /**
         * Trace as string.
         */
        $err['tracestr'] = strip_tags($e->getTraceAsString());
        /**
         * Return error details.
         */
        return (_APP_ERR) ? $err : array('type'=>'Error');
    }

    /**
     * Set error reporting.
     *
     * @return mixed result
     */
    private function _setErrorLevel()
    {
        /**
         * Set error reporting.
         * _APP_ERR ? error_reporting(-1) : error_reporting(0);
         */
        _APP_ERR ? error_reporting(_APP_ERR) : error_reporting(0);
        /**
         * Return result
         */
        return TRUE;
    }

    /**
     * Parse error message.
     *
     * Message should be of type:
     * ErrorType:::ErrorMessage:::ErrorMessageAttribute1:::ErrorMessageAttribute1.
     *
     * @param string $msg message to be parsed.
     * @return array parsed message
     */
    private function _parseErrorMsg($msg)
    {
        /**
         * Split string into parts
         */
        $msge = explode(':::', $msg);
        /**
         * Check if we have at least two parts.
         * If so, return the parts.
         * Else return raw message.
         */
        return (count($msge) > 1) ? $msge : array('Error', $msg);
    }

    /**
     * Get error type from error code.
     *
     * @param integer $type
     * @return string error type
     */
    private function _getErrorType($type)
    {
        /**
         * Error information based on error code.
         *
         * List from http://us.php.net/manual/en/errorfunc.constants.php
         */
        $types = array(
        /**
         * E_ERROR.
         *
         * Fatal run-time errors.
         * These indicate errors that can not be recovered from, such as a memory allocation problem.
         * Execution of the script is halted.
         */
        1     => 'E_ERROR',
        /**
         * E_WARNING.
         *
         * Run-time warnings (non-fatal errors).
         * Execution of the script is not halted.
         */
        2     => 'E_WARNING',
        /**
         * E_PARSE.
         *
         * Compile-time parse errors.
         * Parse errors should only be generated by the parser.
         */
        4     => 'E_PARSE',
        /**
         * E_NOTICE.
         *
         * Run-time notices.
         * Indicate that the script encountered something that could indicate an error,
         * but could also happen in the normal course of running a script.
         */
        8     => 'E_NOTICE',
        /**
         * E_CORE_ERROR.
         *
         * Fatal errors that occur during PHP's initial startup.
         * This is like an E_ERROR, except it is generated by the core of PHP.
         */
        16    => 'E_CORE_ERROR',
        /**
         * E_CORE_WARNING.
         *
         * Warnings (non-fatal errors) that occur during PHP's initial startup.
         * This is like an E_WARNING, except it is generated by the core of PHP.
         */
        32    => 'E_CORE_WARNING',
        /**
         * E_COMPILE_ERROR.
         *
         * Fatal compile-time errors.
         * This is like an E_ERROR, except it is generated by the Zend Scripting Engine.
         */
        64    => 'E_COMPILE_ERROR',
        /**
         * E_COMPILE_WARNING.
         *
         * Compile-time warnings (non-fatal errors).
         * This is like an E_WARNING, except it is generated by the Zend Scripting Engine.
         */
        128   => 'E_COMPILE_WARNING',
        /**
         * E_USER_ERROR.
         *
         * User-generated error message.
         * This is like an E_ERROR, except it is generated in PHP code by using the PHP function trigger_error().
         */
        256   => 'E_USER_ERROR',
        /**
         * E_USER_WARNING.
         *
         * User-generated warning message.
         * This is like an E_WARNING, except it is generated in PHP code by using the PHP function trigger_error().
         */
        512   => 'E_USER_WARNING',
        /**
         * E_USER_NOTICE.
         *
         * User-generated notice message.
         * This is like an E_NOTICE, except it is generated in PHP code by using the PHP function trigger_error().
         */
        1024  => 'E_USER_NOTICE',
        /**
         * E_STRICT.
         *
         * Enable to have PHP suggest changes to your code which will ensure the best interoperability and forward compatibility of your code.
         */
        2048  => 'E_STRICT',
        /**
         * E_RECOVERABLE_ERROR.
         *
         * Catchable fatal error.
         * It indicates that a probably dangerous error occured, but did not leave the Engine in an unstable state.
         * If the error is not caught by a user defined handle (see also set_error_handler()), the application aborts as it was an E_ERROR.
         */
        4096  => 'E_RECOVERABLE_ERROR',
        /**
         * E_DEPRECATED.
         *
         * Run-time notices.
         * Enable this to receive warnings about code that will not work in future versions.
         */
        8192  => 'E_DEPRECATED',
        /**
         * E_USER_DEPRECATED.
         *
         * User-generated warning message.
         * This is like an E_DEPRECATED, except it is generated in PHP code by using the PHP function trigger_error().
         */
        16384 => 'E_USER_DEPRECATED',
        /**
         * E_ALL.
         *
         * All errors and warnings, as supported, except of level E_STRICT in PHP < 6.
         * PHP < 5.2.x.
         */
        2047  => 'E_ALL',
        /**
         * E_ALL.
         *
         * All errors and warnings, as supported, except of level E_STRICT in PHP < 6.
         * PHP 5.2.x.
         */
        6143  => 'E_ALL',
        /**
         * E_ALL.
         *
         * All errors and warnings, as supported, except of level E_STRICT in PHP < 6.
         * PHP 5.3.x.
         */
        30719 => 'E_ALL',
        /**
         * E_ALL.
         *
         * All errors and warnings, as supported, except of level E_STRICT in PHP < 6.
         * PHP 6.x.x.
         */
        32767 => 'E_ALL'
        );
        /**
         * Return result.
         */
        return (array_key_exists($type, $types)) ? $types[$type] : 'E_UNKNOWN';
    }
}

/**
 * rw_Exception.
 *
 * Behaves like classic php errors.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwErr
 */
class rw_Exception extends Exception
{
    /**
     * Error context.
     *
     * @var mixed $_context error context
     */
    private $_context;

    /**
     * Constructor.
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
        /**
         * Call parent constructor.
         */
        parent::__construct($message, $code);
        /**
         * Set file.
         */
        $this->file = $file;
        /**
         * Set line.
         */
        $this->line = $line;
        /**
         * Set context.
         */
        $this->_context = $context;
    }
}
?>