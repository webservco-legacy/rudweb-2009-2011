<?php
/**
 * $Id$
 *
 * Security library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudSecurity
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
 * Security library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudSecurity
 *
 */
class Security extends Library
{
	/**
	 * Stores total number of GET requests.
	 *
	 * @var int
	 */
	private $_mNumGet;

	/**
	 * Stores total number of POST requests.
	 *
	 * @var int
	 */
	private $_mNumPost;

	/**
	 * Sanitize input.
	 *
	 * @return bool
	 */
	public function Sanitize()
	{
		Core::Log()->Write( __( 'Security library: Initializing input sanitization.', 'RudWEb' ), 'debug' );

		/**
		 * Init GET request number.
		 *
		 * @var int
		 */
		$this->_mNumGet = 0;

		/**
		 * Filter $_GET array.
		 *
		 * @var array
		 */
		$_GET = array_map( array( $this, '_FilterRequest' ), $_GET );

		/**
		 * @var string
		 */
		$get_message = sprintf(
		___(
		'Security library: %s GET request sanitized.',
		'Security library: %s GET requests sanitized.',
		$this->_mNumGet,
		'RudWEb'
		)
		, $this->_mNumGet
		);

		Core::Log()->Write( $get_message, 'debug' );

		/**
		 * Init POST request number.
		 *
		 * @var int
		 */
		$this->_mNumPost = 0;

		/**
		 * Filter $_POST array.
		 *
		 * IMPORTANT: Tags are not disabled nor removed.
		 * Further validation is required.
		 * If database connection is not available,
		 * filtering is done as for $_GET.
		 */
		$_POST = array_map(array($this, '_FilterPost'), $_POST);


		/**
		 * @var string
		 */
		$post_message = sprintf(
		___(
		'Security library: %s POST request sanitized.',
		'Security library: %s POST requests sanitized.',
		$this->_mNumPost,
		'RudWEb'
		)
		, $this->_mNumPost
		);

		Core::Log()->Write( $post_message, 'debug' );

		Core::Log()->Write( __( 'Security library: Sanitize complete.', 'RudWEb' ), 'debug' );

		return TRUE;
	}

	/**
	 * Filter request.
	 *
	 * @param string $input request
	 * @param boolean $disableTags
	 * @return string
	 */
	private function _FilterRequest( $input, $disableTags = TRUE )
	{
		/**
		 * Filter input.
		 *
		 * @var string
		 */
		$input = $this->FilterInput( $input, $disableTags, TRUE );

		$this->_mNumGet++;

		return $input;
	}

	/**
	 * Filter post data.
	 *
	 * Please note that this method doesn't disable tags.
	 *
	 * @param array $input post array
	 *
	 * @return array
	 */
	private function _FilterPost($input)
	{
		/**
		 * Filter input.
		 *
		 * @var string
		 */
		$input =  $this->FilterInput( $input, FALSE, FALSE );

		$this->_mNumPost++;

		return $input;
	}

	/**
	 * Filter user input.
	 *
	 * @param string $input input string
	 * @param bool $disableTags should we disable tags?
	 * @param bool $filterRequest is method used to filter $_GET request?
	 *
	 * @return string
	 */
	public function FilterInput( $input, $disableTags = TRUE, $filterRequest = FALSE )
	{
		/**
		 * If magic quotes are enabled, strip slashes from input.
		 */
		if ( get_magic_quotes_gpc() ) {
			/**
			 * @var string
			 */
			$input = stripslashes( $input );
		}

		/**
		 * Some unwanted chars.
		 *
		 * @var array
		 */
		$unwanted = array( '\\' );

		/**
		 * Remove unwanted chars.
		 *
		 * We didn't put these in the RemoveBadChars() method
		 * because we also want them removed
		 * if input is used in a database query.
		 *
		 * @var string
		 */
		$input = str_replace( $unwanted, '', $input );

		/**
		 * Check if we should use database connection.
		 *
		 * @var bool
		 */
		$have_db = ('' != Core::Config()->Get( 'db.type' ) ) ? TRUE : FALSE;

		/**
		 * Check if the method is used to filter $_GET request,
		 * or if a database conection is unavailable
		 */
		if ( ( FALSE !== $filterRequest ) || ( TRUE !== $have_db ) )
		{
			/**
			 * Strip known bad characters.
			 *
			 * @var string
			 */
			$input = $this->RemoveBadChars( $input );

			/**
			 * Remove tags
			 *
			 * @var string.
			 */
			$input = $this->StripTags( $input );
		}

		/**
		 * Check if we should also block tags.
		 */
		if ( FALSE !== $disableTags )
		{
			/**
			 * Disable tags.
			 *
			 * @var string
			 */
			$input = $this->DisableTags( $input );
		}

		/**
		 * Check if we have a database connection.
		 */
		if ( FALSE !== $have_db )
		{
			/**
			 * Use database internal function to filter input.
			 */
			$input = Core::Database()->EscapeString( $input );
		}

		/**
		 * Return result.
		 */
		return trim( $input );
	}

	/**
	 * Remove known bad characters from a string.
	 *
	 * @param string $string input string
	 *
	 * @return string
	 */
	public function RemoveBadChars( $string )
	{
		/**
		 * Known bad characters.
		 *
		 * @var array
		 */
		$bad = array(
	    "`", "'", '"',
	    "\b", "\n", "\r", "\t",
	    "?", "!", "~", "@", "#", "%", "^", "&", "*",
	    "-", "_", "+", "=", "[", "]",
	    ":", ";", ",", ".", "|", "\\",
		"{", "}", "(", ")", "\$"
		);

		/**
		 * Remove bad chars.
		 */
		$string = str_replace( $bad, '', $string );

		/**
		 * Return result.
		 */
		return $string;
	}

	/**
	 * Strip tags from string.
	 *
	 * @param string $input input
	 *
	 * @return string
	 */
	public function StripTags( $input )
	{
		/**
		 * Return result.
		 */
		return preg_replace( '/<(.|\s)*?\>/', '', $input );
	}

	/**
	 * Disable tags from a string.
	 *
	 * @param string $string input string
	 *
	 * @return string
	 */
	public function DisableTags( $string )
	{
		/**
		 * Block <.
		 *
		 * @var string
		 */
		$string = str_replace( '&lt;', '&#60;', $string );

		/**
		 * Block >.
		 *
		 * @var string
		 */
		$string = str_replace( '&gt;', '&#62;', $string );

		/**
		 * Block <.
		 *
		 * @var string
		 */
		$string = str_replace( '<', '&#60;', $string );

		/**
		 * Block >.
		 *
		 * @var string
		 */
		$string = str_replace( '>', '&#62;', $string );

		/**
		 * Block <.
		 *
		 * @var string
		 */
		$string = str_replace( '%3C', '&#60;', $string );

		/**
		 * Block >.
		 *
		 * @var string
		 */
		$string = str_replace( '%3E', '&#62;', $string );

		/**
		 * Return result.
		 */
		return $string;
	}
}
?>