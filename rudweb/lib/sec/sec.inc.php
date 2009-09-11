<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Security library.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-08 17:35:00
 * @access     public
 * @package    rwLibSec
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
if(!defined('_RW_VALID'))
{
	/**
	 * Display "Not Found" page.
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * rw_Security.
 *
 * Engine security functions.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwLibSec
 */
class rw_Security
{
	/**
	 * Database object.
	 *
	 * One of the available libraries.
	 *
	 * @var mixed
	 */
	public $rwDb = NULL;

	/**
	 * Class constructor.
	 *
	 * @param mixed $rwDb database object
	 * @return mixed result
	 */
	public function __construct($rwDb)
	{
		/**
		 * Set database object.
		 */
		$this->rwDb = $rwDb;
	}

	/**
	 * Filter user input.
	 *
	 * @param string $input
	 * @param boolean $blockTags
	 * @return string filtered input
	 */
	public function rwFilterInput($input,$blockTags=TRUE)
	{
		/**
		 * If magic quotes are enabled, strip slashes from input.
		 */
		if (get_magic_quotes_gpc()) {$input = stripslashes($input);}
		/**
		 * Some unwanted chars.
		 */
		$unwanted = array('\\');
		/**
		 * Remove unwanted chars.
		 *
		 * We did'nt put these in the _rwRemoveBadChars() method
		 * because we also want them removed
		 * if input is used in a database query.
		 */
		$input = str_replace($unwanted, '', $input);
		/**
		 * Check if we should also block tags
		 */
		if ($blockTags === TRUE)
		{
			/**
			 * Disable tags.
			 */
			$input = $this->_rwDisableTags($input);
		}
		/**
		 * Check if we have an open database connection.
		 */
		if ($this->db)
		{
			/**
			 * Use database internal function to filter input.
			 */
			$input = $this->db->dbEscapeString($input);
		}
		/**
		 * The string will not be used in a query.
		 */
		else
		{
			/**
			 * Strip known bad characters.
			 */
			$input = $this->_rwRemoveBadChars($input);
		}
		/**
		 * Return result.
		 */
		return trim($input);
	}

	/**
	 * Filter request.
	 *
	 * @param string $request request
	 * @param boolean $blockTags
	 * @return string $request filtered request
	 */
	public function rwFilterRequest($request,$blockTags=TRUE)
	{
		/**
		 * Filter input.
		 */
		$request = $this->rwFilterInput($request,$blockTags);
		/*
		 * Remove fake file extension.
		 */
		$request = $this->_rwRemoveFakeExt($request);
		/**
		 * Return result.
		 */
		return $request;
	}

	/**
	 * Remove fake file extension from requests
	 *
	 * @param string $request request
	 * @return string $request processed request
	 */
	private function _rwRemoveFakeExt($request)
	{
		/**
		 * Check if fake extension is enabled.
		 */
		if (_APP_FAKEXT)
		{
			/**
			 * Remove fake extension from request.
			 */
			$request = substr($request, 0, strlen($request)-strlen(strstr($request,'.')));
		}
		/**
		 * Return result.
		 */
		return $request;
	}

	/**
	 * Remove known bad characters from a string.
	 *
	 * @param string $string input string
	 * @return string parsed string
	 */
	private function _rwRemoveBadChars($string)
	{
		/**
		 * Known bad characters.
		 */
		$bad = array(
	    '`', "'", '"',
	    '\\\b', '\\\n', '\\\r', '\\\t',
	    '\?', '!', '\~', '\@', '\#', '\$', '\%', '\^', '\&', '\*',
	    '\(', '\)', '\-', '\+', '\=', '\{', '\[', '\}', '\]',
	    '\:', '\;', '\,', '\.', '\|', '\\'
	    );
	    /**
	     * Remove bad chars.
	     */
	    $string = str_replace($bad, '', $string);
	    /**
	     * Return result.
	     */
	    return $string;
	}

	/**
	 * Disable tags from a string.
	 *
	 * @param string $string input string
	 * @return string $string output string.
	 */
	private function _rwDisableTags($string)
	{
		/**
		 * Block <.
		 */
		$string = str_replace('&lt;', '&#60;', $string);
		/**
		 * Block >.
		 */
		$string = str_replace('&gt;', '&#62;', $string);
		/**
		 * Block <.
		 */
		$string = str_replace('<', '&#60;', $string);
		/**
		 * Block >.
		 */
		$string = str_replace('>', '&#62;', $string);
		/**
		 * Return result.
		 */
		return $string;
	}

	/**
	 * Strip all tags.
	 *
	 * @param string $input
	 * @return string filtered input
	 */
	private function _rwStripTags($input)
	{
		/**
		 * Return result.
		 */
		return preg_replace('/<(.|\s)*?\>/', '', $input);
	}

	/**
	 * Strip php code.
	 *
	 * @param string $input
	 * @return string filtered input
	 */
	private function _rwStripPhp($input)
	{
		/**
		 * Return result.
		 */
		return preg_replace('/<\?(.|\s)*?>/', '', $input);
	}

	/**
	 * Strip Smarty varaibles.
	 *
	 * @param string $input
	 * @return string filtered input
	 */
	private function _rwStripSmartyVars($input)
	{
		/**
		 * Return result.
		 */
		return preg_replace('/{\$(.|\s)*?}/', '', $input);
	}

	/**
	 * Strip Smarty code.
	 *
	 * @param string $input
	 * @return string filtered input
	 */
	private function _rwStripSmartyCode($input)
	{
		/**
		 * Return result.
		 */
		return preg_replace('/{(.|\s)*?}/', '', $input);
	}

	/**
	 * Strip scripting code.
	 *
	 * @param string $input
	 * @return string filtered input
	 */
	private function _rwStripScript($input)
	{
		/**
		 * Return result.
		 */
		return preg_replace('/<script(.|\s)*?\/script>/', '', $input);
	}

	/**
	 * Strip HTML comments.
	 *
	 * @param string $input
	 * @return string filtered input
	 */
	private function _rwStripHTMLComments($input)
	{
		/**
		 * Return result.
		 */
		return preg_replace('/<!--(.|\s)*?-->/', '', $input);
	}
}
?>