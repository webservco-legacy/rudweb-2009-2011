<?php
/**
 * $Id$
 *
 * Main output library.
 *
 * All custom output libraries will extend this library.
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
 * Output library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudOutput
 *
 */
class Output extends Library
{
	/**
	 * Stores the output engine object.
	 *
	 * @var object
	 */
	private $_mOutputEngineObject;

	/**
	 * Output method.
	 *
	 * @param string $outTemplate
	 * @param mixed $outData
	 * @param string $outSkin
	 * @param string $outEngine
	 * @param bool $outDisplay
	 *
	 * @return mixed
	 */
	public function Out( $outTemplate = NULL, $outData = NULL, $outSkin = NULL, $outEngine = NULL, $outDisplay = FALSE )
	{
		/**
		 * @var string
		 */
		$out_engine = $outEngine ? $outEngine : Core::Config()->Get( 'output.engine' );

		/**
		 * @var string
		 */
		$out_skin = $outSkin ? $outSkin : Core::Config()->Get( 'output.skin' );

		/**
		 * @var string
		 */
		$out_template = $outTemplate ? $outTemplate : Core::Config()->Get( 'output.template' );

		/**
		 * @var string
		 */
		$out_extension = Core::Config()->Get( 'output.extension' );

		/**
		 * @var string
		 */
		$out_data = $outData ? $outData : array();

		/**
		 * Load output engine.
		 */
		$this->_LoadOutputEngine( $out_engine );

		/**
		 * @var string
		 */
		$skin_dir = Core::Config()->Get( 'path.app' ) .
		Core::Config()->Get( 'dir.app.opt' ) . '/' .
		Core::Config()->Get( 'dir.app.skins' ) . '/' .
		$out_skin . '/'
		;

		/**
		 * Set skin directory.
		 */
		$this->_mOutputEngineObject->SetSkinDir( $skin_dir );

		foreach ( $out_data as $out_name => $out_value )
		{
			/**
			 * Set output data.
			 */
			$this->_mOutputEngineObject->Set( $out_name, $out_value );
		}

		return $this->_mOutputEngineObject->Parse( $out_template . $out_extension, $outDisplay  );
	}

	/**
	 * Load output engine.
	 *
	 * @param string $outEngine
	 *
	 * @return bool
	 */
	private function _LoadOutputEngine( $outEngine )
	{
		/**
		 * @var string
		 */
		$out_engine = 'Output_' . ucfirst( strtolower( $outEngine ) );

		/**
		 * @var object
		 */
		$this->_mOutputEngineObject = $out_engine::GetInstance();

		return TRUE;
	}
}
?>