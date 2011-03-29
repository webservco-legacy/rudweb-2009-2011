<?php
/**
 * $Id$
 *
 * Object library.
 *
 * All objects extend this library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudObject
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
 * Object library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudObject
 *
 */
class Object extends Library
{
	/**
	 * Object properties.
	 *
	 * @var array
	 */
	public $mProps;

	/**
	 * Internationalization properties.
	 *
	 * @var array
	 */
	public $mI18nProps;

	/**
	 * Object table.
	 *
	 * Child object can override individual options,
	 * except for list.
	 *
	 * @var string
	 */
	protected $_mTable = array( 'list' => NULL, 'store' => NULL, 'i18n' => NULL );

	/**
	 * Primary key
	 *
	 * @var string
	 */
	protected $_mKey;

	/**
	 * Implement GetInstance() method.
	 *
	 * This is required for PHP < 5.3 compatibility ( no late static binding )
	 *
	 * @param string $className class name to instantiate
	 *
	 * @return object
	 */
	public static function GetInstance( $className = __CLASS__ )
	{
		/**
		 * Call parent method with current class name as parameter.
		 */
		return parent::_GetInstance( $className );
	}

	/**
	 * Load configuration file for current library.
	 *
	 * Needs to override the Library method.
	 * This also loads the i18n files.
	 *
	 * @param string $className name of the class to load configuration for
	 *
	 * @return bool
	 */
	protected  function _LoadConfig( $className )
	{
		/**
		 * @var array
		 */
		$this->_mTable['list'] = Core::Config()->Get( 'app.prefix' ) . 'object_' . strtolower( $className );

		if ( !isset( $this->_mTable['i18n'] ) )
		{
			/**
			 * @var array
			 */
			$this->_mTable['i18n'] = Core::Config()->Get( 'app.prefix' ) . 'i18n';
		}

		/**
		 * @var string
		 */
		$this->_mKey = strtolower( $className ) . '_id';

		if ( 1 == Core::Config()->Get( 'db.binkey' ) )
		{
			$this->_mKey = 'bin.' . $this->_mKey;
		}

		/**
		 * Handle module i18n
		 */
		Core::I18n()->Add( $className );
		Core::I18n()->Load( $className );

		/**
		 * @var array
		 */
		$parts = explode( '_', $className );

		/**
		 * @var string
		 */
		$module_name = array_key_exists( 1, $parts ) ? $parts[1] : $parts[0];

		/**
		 * @var string
		 */
		$path_app = Core::Config()->Get( 'path.app' );

		/**
		 * @var string
		 */
		$cfg_file =  $path_app . 'etc/obj.' . strtolower( $module_name ) . '.cfg.xml';

		if ( !is_readable( $cfg_file ) )
		{
			return FALSE;
		}

		return Core::Config()->Set( $cfg_file );
	}

	public function Add() //XXX add i18n support
	{
		/**
		 * @var array
		 */
		$data = array_diff_key( $this->mProps, array( $this->_mKey => NULL ) );

		$this->mProps[$this->_mKey] = Core::Database()->Add( $data, $this->_mTable );

		return TRUE;
	}

	public function Get( $id, $i18nLocale = NULL )
	{
		/**
		 * Check locale
		 */
		if ( empty( $i18nLocale ) )
		{
			/**
			 * @var string
			 */
			$i18nLocale = Core::Config()->Get( 'i18n.locale' );
		}

		/**
		 * @var array
		 */
		$options['conditions'][] = array ( $this->_mKey, $id );

		/**
		 * @var array
		 */
		$options['conditions'][] = array ( 'i18n_locale', $i18nLocale );

		/**
		 * @var array
		 */
		$this->mProps = Core::Database()->RetrieveOne( array_keys( $this->mProps ), $this->_mTable['list'], $options );

		return TRUE;
	}

	public function Save() //XXX add i18n support
	{
		/**
		 * @var array
		 */
		$data = array_diff_key( $this->mProps, array( $this->_mKey => NULL ) );

		/**
		 * @var array
		 */
		$options = array( 'conditions' => array ( $this->_mKey, $this->mProps[$this->_mKey] ), 'limit' => 1 );

		Core::Database()->Update( $data, $this->_mTable, $options );

		return TRUE;
	}

	public function Remove() //XXX add i18n support
	{
		/**
		 * @var array
		 */
		$options = array( 'conditions' => array ( $this->_mKey, $this->mProps[$this->_mKey] ), 'limit' => 1 );

		Core::Database()->Delete( $this->_mTable, $options );

		return TRUE;
	}
}
?>