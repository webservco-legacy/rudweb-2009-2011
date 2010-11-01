<?php
/**
 * $Id$
 *
 * RudWEb output library.
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
class Output_Rudweb extends Output implements Interface_Output
{
	/**
	 * (non-PHPdoc)
	 * @see Interface_Output::Init()
	 */
	public function Init()
	{
		/**
		 * Check if initialization is already done
		 */
		if ( NULL != $this->_mEngineObject )
		{
			return FALSE;
		}

		Core::Log()->Write( __( 'Output library: Initializing output engine object.', 'RudWEb' ), 'debug' );

		/**
		 * @var string
		 */
		$this->_mSkinDir = Core::Config()->Get( 'output.skin' );

		/**
		 * @var string
		 */
		$this->_mSkinPath = Core::Config()->Get( 'path.app' ) .
		Core::Config()->Get( 'dir.app.opt' ) . '/' .
		Core::Config()->Get( 'dir.app.skins' ) . '/';

		/**
		 * @var string
		 */
		$this->_mTemplate = Core::Config()->Get( 'output.template' );

		/**
		 * @var extension
		 */
		$this->_mExtension = Core::Config()->Get( 'output.extension' );

		$this->_mEngineObject = TRUE;

		return TRUE;

	}

	/**
	 * (non-PHPdoc)
	 * @see Interface_Output::Parse()
	 */
	public function Render( $outTemplate, $outDisplay = FALSE )
	{
		Core::Log()->Write( __( 'Output library: Rendering template.', 'RudWEb' ), 'debug' );

		/**
		 * Initialize output engine object.
		 */
		$this->Init();

		/**
		 * @var string
		 */
		$tpl_path = $this->_mSkinPath . $this->_mSkinDir . '/' . $outTemplate . $this->_mExtension;

		if ( !is_readable( $tpl_path ) )
		{
			trigger_error( __( 'Output library: Template file not found: ' , 'RudWEb' ) . $tpl_path , 256 );
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
		include $tpl_path;

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