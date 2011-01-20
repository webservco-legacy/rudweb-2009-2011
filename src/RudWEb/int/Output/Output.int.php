<?php
/**
 * $Id$
 *
 * Output interface.
 *
 * All output libraries will implement it
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
	exit;
}

/**
 * Interface_Output
 *
 * Output interface.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudOutput
 *
 */
interface Interface_Output
{
	/**
	 * Load output engine object.
	 *
	 * @return bool
	 */
	public function Init();

	/**
	 * Output method.
	 *
	 * @param string $outTemplate
	 * @param bool $outDisplay
	 *
	 * @return mixed
	 */
	public function Render( $outTemplate, $outDisplay = FALSE );
}
?>