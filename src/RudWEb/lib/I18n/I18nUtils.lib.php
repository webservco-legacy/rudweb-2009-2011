<?php
/**
 * $Id$
 *
 * Internationalization library utilities.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
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
	exit();
}

/**
 * Gettext / dgetttext wrapper.
 *
 * @param string $msg
 * @param string $domain
 *
 * @return string
 */
function __( $msg, $domain = NULL )
{
	return ( $domain ) ? dgettext( $domain, $msg ) : gettext( $msg );
}

/**
 * Ngettext / dngettext wrapper.
 *
 * @param string $msgSingular
 * @param string $msgPlural
 * @param string $msgNumber
 * @param string $domain
 */
function ___( $msgSingular, $msgPlural, $msgNumber, $domain )
{
	return ( $domain ) ?
	dngettext( $domain, $msgSingular, $msgPlural, $msgNumber ) :
	ngettext( $msgSingular, $msgPlural, $msgNumber );
}
?>