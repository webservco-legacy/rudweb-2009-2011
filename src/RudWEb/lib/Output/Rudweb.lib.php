<?php
/**
 * $Id$
 *
 * RudWEb database library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudOutput
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
 * RudWEb Output library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudOutput
 *
 */
class Output_Rudweb extends Library implements Interface_Output
{
	/**
	 * Stores skin directory path.
	 *
	 * @var string
	 */
	private $_mSkinDir;

	/**
	 * Stores data to parse.
	 *
	 * @var array
	 */
	private $_mData = array();

	/**
	 * (non-PHPdoc)
	 * @see Interface_Output::SetSkinDir()
	 */
	public function SetSkinDir( $outSkinDir )
	{
		$this->_mSkinDir = $outSkinDir;

		return TRUE;
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Output::Set()
	 */
	public function Set( $outName, $outValue )
	{
		$this->_mData[$outName] = $outValue;

		return TRUE;
	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Output::Parse()
	 */
	public function Parse( $outTemplate, $outDisplay )
	{
		/**
		 * @var string
		 */
		$tpl_path = $this->_mSkinDir . $outTemplate;

		if ( !is_readable( $tpl_path ) )
		{
			trigger_error( __( 'Output library: Template file not found.' ), 256 );
		}

		/**
		 * Turn on output buffering.
		 */
		ob_start();

		/**
		 * Import output variables.
		 */
		extract( $this->_mData );

		/**
		 * Load template file.
		 */
		include( $tpl_path );

		/**
		 * Get parsed output result from the output buffer.
		 */
		$out_data = ob_get_contents();

		/**
		 * Delete output buffer and turn off output buffering.
		 */
		ob_end_clean();

		if ( FALSE !== $outDisplay )
		{
			echo $out_data;

			return TRUE;
		}
		else
		{
			return $out_data;
		}
	}
}
?>