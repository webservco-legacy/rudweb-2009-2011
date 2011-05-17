<?php
/**
 * $Id$
 *
 * Smarty output library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
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
	exit();
}

/**
 * Output_Smarty
 * 
 * Smarty Output library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudOutput
 *
 */
class Output_Smarty extends Output implements Interface_Output
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
		$path_app = Core::Config()->Get( 'path.app' );

		/**
		 * @var string
		 */
		$this->_mSkinPath = $path_app .
		Core::Config()->Get( 'dir.app.opt' ) . '/' .
		Core::Config()->Get( 'dir.app.tpl' ) . '/';

		/**
		 * @var string
		 */
		$this->_mTemplate = Core::Config()->Get( 'output.template' );

		/**
		 * @var extension
		 */
		$this->_mExtension = Core::Config()->Get( 'output.extension' );

		/**
		 * @var object
		 */
		$this->_mEngineObject = $this->_LoadEngine( 'Smarty' );

		/**
		 * @var string
		 */
		$this->_mEngineObject->template_dir = $this->_mSkinPath . $this->_mSkinDir;

		/**
		 * @var string
		 */
		$dir_tmp = Core::Config()->Get( 'dir.app.tmp' );

		/**
		 * @var string
		 */
		$this->_mEngineObject->compile_dir = $path_app . $dir_tmp . '/';

		/**
		 * @var string
		 */
		$this->_mEngineObject->cache_dir = $path_app . $dir_tmp . '/';

		/**
		 * @var string
		 */
		$this->_mEngineObject->config_dir = $path_app . $dir_tmp . '/';

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
		$tpl_file = $outTemplate . $this->_mExtension;

		if ( FALSE !== $outDisplay )
		{
			return $this->_mEngineObject->display( $tpl_file );
		}
		else
		{
			return $this->_mEngineObject->fetch( $tpl_file );
		}
	}

	/**
	 * Set output data.
	 *
	 * @param string $outName
	 * @param mixed $outValue
	 *
	 * @return bool
	 */
	public function Set( $outName, $outValue )
	{
		Core::Log()->Write( __( 'Output library: Setting data.', 'RudWEb' ), 'debug' );

		return $this->_mEngineObject->assign( $outName, $outValue );
	}
}
?>