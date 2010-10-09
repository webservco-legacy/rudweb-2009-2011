<?php
/**
 * $Id$
 *
 * Internationalization library utilities.
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
 * Gettext/dgetttext wrapper.
 *
 * @param string $mesage
 * @param string $domain
 *
 * @return string
 */
function __( $mesage, $domain = NULL )
{
	return ( $domain ) ? dgettext( $domain, $mesage ) : gettext( $mesage );
}
?>