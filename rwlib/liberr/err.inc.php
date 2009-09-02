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
 * Prevent direct file access
 */
if(!defined('_RW_VALID')) {require_once('./index.php'); exit;}

/**
 * rw_Error
 *
 * Behaves like classic php errors.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwErr
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
 * @package    rwErr
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
	/**
	 * Main error display
	 *
	 * @todo mail error info to developer
	 * @todo write error info to log
	 * @param mixed $e error object
	 * @return mixed result
	 */
	public static function displayError($e)
	{
		/**
		 * Display error message
		 */
		$skinURL = _APP_WWW.'skins/'._APP_SKIN.'/';
		$err =
'<?xml version="1.0" encoding="utf-8" standalone="no"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="content-language" content="en" />
  <link rel="icon" type="image/ico" href="'.$skinURL.'graphics/favicon.ico" />
  <link rel="shortcut icon" type="image/ico" href="'.$skinURL.'graphics/favicon.ico" />
  <title>ERROR - '._APP_NAME.'</title>
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <link rel="stylesheet" type="text/css" charset="utf-8" href="'.$skinURL.'styles/style.css" />
  <!--[if lte IE 6]>
  <link rel="stylesheet" type="text/css" charset="utf-8" href="'.$skinURL.'styles/styleIE.css" />
  <![endif]-->
  </head>
    <body>
    
    <div id="layout">
      <div id="hdr">
        <div id="hdr1">
          <a href="'._APP_WWW.'" title="'._APP_NAME.'"><img id="logo" src="'.$skinURL.'graphics/logo.png" alt="'._APP_NAME.' Logo" longdesc="'._APP_NAME.' Logo" /></a>
        </div>
        <div id="hdr2"><div id="header">'._APP_NAME.'</div></div>
        <div id="hdr3">&#160;</div>
      </div>
      
      <div id="cnt0">
        <div id="left0">
          &#160;
        </div>
        <div id="right0">
          &#160;
        </div>
        <div id="center0">
          &#160;
        </div>
      </div>
      
      <div id="cnt1">
        <div id="left1">
          <div id="left">
            &#160;
          </div>
        </div>
        
        
        <div id="right1">
          <div id="right">
            &#160;
          </div>
        </div>
        
        <div id="center1">
          <div id="center_space1">&#160;</div>
          <div id="center_content">
            <div id="page_title">
              <h1>Oops!</h1>
            </div>
            <div id="page_content">
              <p>Something went wrong :-(</p>';

		$err .= (_APP_CFG_ERRORS) ? rw_Error_handler::displayErrorDev($e) :
    '
    <p>Don\'t worry, it\'s not your fault!</p>
    <p><u>If you are a visitor</u>: kindly try again in a few minutes.</p>
    <p><u>If you are the owner/maintainer</u>: please enable error reporting in your configuration file in order to see more information about what happened.</p>
    ';

		$err .=
            '</div>
            <div class="clear"></div>
          </div>
        </div>
        
      </div>
      
      <div id="cnt2">
        <div id="left2">
          &#160;
        </div>
        <div id="right2">
          &#160;
        </div>
        <div id="center2">
          &#160;
        </div>
      </div>
      
      <div id="ftr">
        <div id="footer">
          Copyright 2009
        </div>
      </div>
  
    </div>
  </body>
</html>';
		return $err;
	}
	/**
	 * Developer error display
	 *
	 * @param mixed $e error object
	 * @return mixed result
	 */
	public static function displayErrorDev($e)
	{
		/**
		 * Display detailed error information
		 * List from http://us.php.net/manual/en/errorfunc.constants.php
		 */
		$errType = array(
		1    => 'Fatal run-time error',
		2    => 'Run-time warning',
		4    => 'Compile-time parse error',
		8    => 'Run-time notice',
		16   => 'Fatal error that occured during PHP\'s initial startup',
		32   => 'Warning that occured during PHP\'s initial startup',
		64   => 'Fatal compile-time error',
		128  => 'Compile-time warning',
		256  => 'Engine-generated error message',
		512  => 'Engine-generated warning message',
		1024 => 'Engine-generated notice message',
		2048 => 'Run-time notice',
		4096 => 'Catchable fatal error',
		8192 => 'Deprecated code',
		16384 => 'Engine generated deprecated code message',
		2047 => 'All errors and warnings except E_STRICT PHP<52',
		6143 => 'All errors and warnings except E_STRICT PHP52',
		30719 => 'All errors and warnings except E_STRICT PHP53',
		32767 => 'All errors and warnings PHP6'
		);

		$err =
      '<div class="err">'.
      '<p>' . '<div class="errtxt">'. $e->getMessage() . '</div>' .
      '<b>Time:</b> '. date("Y-m-d H:i:s") . '<br />' .
      '<b>Error type:</b> '. $e->getCode() . ' (' . $errType[$e->getCode()] . ')' . '<br />' .
      '<b>File:</b> '. $e->getFile() . '<br /> ' .
      '<b>Line:</b> '. $e->getLine() . '<br /> ' .
      '<b>Trace:</b></p> '. '<pre>' . strip_tags($e->getTraceAsString()) . '</pre>' .
      '</div>'
      ;
      return $err;
	}
}
?>