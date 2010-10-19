<?php
/**
 * $Id$
 *
 * Internationalization library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudI18n
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
 * I18n
 *
 * Internationalization library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudI18n
 *
 */
class I18n extends Library
{

	/**
	 * Stores current locale.
	 *
	 * @var string
	 */
	private $_mI18nLocale;


	/**
	 * Initialize.
	 *
	 * Sets locale data and loads the default domain message catalog.
	 *
	 * @param string $i18nLocale
	 * @param string $defaultDomain
	 */
	public function Init( $i18nLocale = NULL, $defaultDomain = NULL )
	{
		$this->_mI18nLocale = ( $i18nLocale ) ? $i18nLocale : 'en_US';

		/**
		 * Rumored to allow using a locale regardless on server locale setup.
		 */
		putenv("LANGUAGE=" . $this->_mI18nLocale );

		/**
		 * Rumored to be needed on Win.
		 */
		putenv("LANG=" . $this->_mI18nLocale );

		setlocale( LC_ALL, $this->_mI18nLocale );

		$this->Add( $defaultDomain );

		$this->Load( $defaultDomain );

		return TRUE;
	}

	/**
	 * Add a new domain message catalog.
	 *
	 * @param string $rawDomain
	 *
	 * @return bool
	 */
	public function Add( $rawDomain = NULL )
	{
		/**
		 * @var string
		 */
		$raw_domain = ( $rawDomain ) ? $rawDomain : 'RudWEb';

		/**
		 * @var array
		 */
		$parts = explode( '_', $raw_domain );

		/**
		 * Init domain base directory.
		 *
		 * @var mixed
		 */
		$base = NULL;

		/**
		 * Default domain type.
		 *
		 * @var string
		 */
		$type = 'Core';

		/**
		 * Default domain name.
		 *
		 * @var string
		 */
		$domain = $parts[0];

		/**
		 * Check if the raw domain name also contains the type.
		 */
		if ( array_key_exists( 1, $parts ) )
		{
			/**
			 * @var string
			 */
			$type	= $parts[0];

			/**
			 * @var string
			 */
			$domain	= $parts[1];
		}

		/**
		 * Check domain type.
		 */
		switch ( $type )
		{
			case 'App' :

			case 'Module' :
				/**
				 * @var string
				 */
				$base = 'path.app';

				/**
				 * @var string
				 */
				$dir = 'dir.app.i18n';

				break;
					
			case 'Core'	:

			default		:
				/**
				 * @var string
				 */
				$base = 'path.core';

				/**
				 * @var string
				 */
				$dir = 'dir.core.i18n';

				break;
		}

		/**
		 * @var string
		 */
		$path = Core::Config()->Get( $base ) . Core::Config()->Get( $dir ) . '/';

		/**
		 * Check domain path.
		 */
		if ( !is_readable( $path ) )
		{
			return FALSE;
		}

		bindtextdomain( $domain, $path );

		return TRUE;
	}

	/**
	 * Load domain message catalog.
	 *
	 * @param string $domainName
	 *
	 * @return bool
	 */
	public function Load( $domainName = NULL )
	{
		/**
		 * @var string
		 */
		$domain_name = ( $domainName ) ? $domainName : 'RudWEb';

		/**
		 * @var array
		 */
		$parts = explode( '_', $domain_name );
		
		/**
		 * @var string
		 */
		$domain_name = ( array_key_exists( 1, $parts ) ) ? $parts[1] : $parts[0];

		textdomain( $domain_name );

		/**
		 * Check if current locale contains a custom codeset.
		 */
		if ( FALSE !== strpos( $this->_mI18nLocale, '.' ) )
		{
			/**
			 * @var array
			 */
			$parts = explode( '.', $this->_mI18nLocale );

			/**
			 * @var string
			 */
			$codeset = $parts[1];

			/**
			 * Set the character encoding for the loaded domain.
			 */
			bind_textdomain_codeset( $domain_name, $codeset );
		}

		return TRUE;
	}
}
?>