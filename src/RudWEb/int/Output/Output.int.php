<?php
/**
 * $Id$
 *
 * Output interface.
 *
 * All output libraries will implement it
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
	 * Set application skin directory path.
	 *
	 * @param string $outSkinDir
	 *
	 * @return mixed
	 */
	public function SetSkinDir( $outSkinDir );

	/**
	 * Set output variables.
	 *
	 * @param mixed $outName
	 * @param mixed $outValue
	 *
	 * @return mixed
	 */
	public function Set( $outName, $outValue );

	/**
	 * Parse output.
	 *
	 * @param string $outTemplate
	 * @param boolean $outDisplay
	 *
	 * @return mixed
	 */
	public function Parse( $outTemplate, $outDisplay );
}
?>