<?php
/**
 * $Id$
 *
 * Smarty output library.
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

		Core::Log()->Write( __( 'Output library:  Initializing output engine object.', 'RudWEb' ), 'debug' );

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
		Core::Config()->Get( 'dir.app.skins' ) . '/';

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
		$this->_mEngineObject = $this->_LoadSmarty();

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
	 * Load Smarty library.
	 *
	 * @return mixed
	 */
	private function _LoadSmarty()
	{

		Core::Log()->Write( __( 'Output library: Loading Smarty template engine.', 'RudWEb' ), 'debug' );

		/**
		 * @var array
		 */
		$opt_paths = array (
		'Core' => Core::Config()->Get( 'path.core' ) . Core::Config()->Get( 'dir.core.opt' ) . '/',
		'App' => Core::Config()->Get( 'path.app' ) . Core::Config()->Get( 'dir.app.opt' ) . '/',
		);

		/**
		 * @var string
		 */
		$smarty_dir = Core::Config()->Get( 'output.smarty.dir' );

		/**
		 * @var string
		 */
		$smarty_file = Core::Config()->Get( 'output.smarty.file' );

		foreach ( $opt_paths as $opt_type => $opt_path )
		{
			/**
			 * @var string
			 */
			$smarty_path = $opt_path . $smarty_dir . '/' . $smarty_file;

			if ( is_readable( $smarty_path ) )
			{
				require_once $smarty_path;

				/**
				 * @var string
				 */
				$path_msg = sprintf(
				__( 'Output library: Smarty template engine found in "%s" path.', 'RudWEb' ),
				$opt_type
				);

				Core::Log()->Write( $path_msg, 'debug' );

				return new Smarty;
			}
		}

		trigger_error( __( 'Output Library: Smarty template engine not found: ', 'RudWEb' ) . 'Smarty', 256 );
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