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
	 * Can also be used to store initialization status (bool)
	 *
	 * @var mixed
	 */
	protected $_mEngineObject;

	/**
	 * Stores skin name.
	 *
	 * @var string
	 */
	protected $_mSkinDir;

	/**
	 * Stores skin directory path.
	 *
	 * @var string
	 */
	protected $_mSkinPath;

	/**
	 * Stores template file name.
	 *
	 * @var string
	 */
	protected $_mTemplate;

	/**
	 * Stores template file extension.
	 *
	 * @var string
	 */
	protected $_mExtension;

	/**
	 * Stores output data.
	 *
	 * @var array
	 */
	protected $_mData = array();

	/**
	 * Set skin.
	 *
	 * @param string $skinName
	 *
	 * @return bool
	 */
	final public function SetSkin( $skinName )
	{
		/**
		 * @var string
		 */
		$this->_mSkinDir = $skinName;

		/**
		 * @var string
		 */
		$msg_skin = sprintf( __( 'Output library: Skin directory set to "%s"', 'RudWEb' ), $skinName );

		Core::Log()->Write( $msg_skin, 'debug' );

		return TRUE;
	}

	/**
	 * All in one output method.
	 *
	 * Sets data and calls the output engine render method.
	 *
	 * @param bool $outDisplay
	 * @param string $outTemplate
	 * @param array $outData
	 *
	 * @return mixed
	 */
	final public function Out( $outTemplate = NULL, $outData = array(), $outDisplay = FALSE )
	{
		/**
		 * Initialize output engine object.
		 */
		$this->Init();

		/**
		 * @var string
		 */
		$out_template = $outTemplate ? $outTemplate : $this->_mTemplate;


		Core::Log()->Write( __( 'Output library: Calling Set() method.', 'RudWEb' ), 'debug' );

		foreach ( $outData as $out_name => $out_value )
		{
			/**
			 * Set output data.
			 */
			$this->Set( $out_name, $out_value );
		}

		Core::Log()->Write( __( 'Output library: Calling output engine Render() method.', 'RudWEb' ), 'debug' );

		return $this->Render( $out_template, $outDisplay );
	}

	/**
	 * Set output data.
	 *
	 * Can be overridden in extending class.
	 *
	 * @param string $outName
	 * @param mixed $outValue
	 *
	 * @return bool
	 */
	public function Set( $outName, $outValue )
	{
		/**
		 * @var array
		 */
		$this->_mData[$outName] = $outValue;

		Core::Log()->Write( __( 'Output library: Setting data.', 'RudWEb' ), 'debug' );

		return TRUE;
	}
}
?>