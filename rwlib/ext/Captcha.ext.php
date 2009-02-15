<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Captcha generation and verification.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-14 20:14:00
 * @access     public
 * @package    RudWEb
 * @subpackage Extensions
 * @todo       stuff
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

/**
 * Prevent direct file access
 */
if(!defined('_RW_VALID')) {require_once('./index.php'); exit;}

class rw_Ext_Captcha extends rw_Ext_global implements rw_iExt
{
	/**
	 * Constructor
	 * Set extension information and call parent constructor
	 *
	 */
	public function __construct()
	{
		/**
		 * Extension info
		 */
		$about['name'] = 'Captcha';
		$about['desc'] = 'Captcha generation and verification.';
		$about['ver']  = '$Revision$';
		$about['auth'] = 'Radu Maier';
		$about['web']  = 'http://www.rudisoft.net';
		$about['mail'] = 'rudisoft@rudisoft.net';
		$about['deps'] = array();
		parent::__construct($about);
	}
	/**
	 * Generate captcha image
	 */
	public function display()
	{
		//$core = new rw_Core;
    //$session = $core->rwActivateExt($ext, 'Sessions');
    //$ses = $session->rwSession($ext);
    if(isset($_SESSION[_APP_PRE.'_token']))
    {
    	ob_start();
    	$captcha = str_split(strtoupper($_SESSION[_APP_PRE.'_token']), 1);
    	
    	//header("Content-type: image/png");
      //header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
      //header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
      
      $img = imagecreatetruecolor(70, 18);
  
      $bgc = imagecolorallocate($img, 0x11, 0x11, 0x11);
      $fgc = imagecolorallocate($img, 0xff, 0xff, 0xff);
      
      $font = _RW_DIR_LIB . '3rdparty/ttf/' . 'VeraMono.ttf';
  
      imagefill($img, 0, 0, $bgc);
  
      imagettftext($img, 12, 10, 3, 16, $fgc, $font, $captcha['4']);
      imagettftext($img, 12, -30, 13, 12, $fgc, $font, $captcha['3']);
      imagettftext($img, 12, 10, 30, 16, $fgc, $font, $captcha['2']);
      imagettftext($img, 12, -10, 40, 14, $fgc, $font, $captcha['1']);
      imagettftext($img, 12, 10, 58, 16, $fgc, $font, $captcha['0']);
  
      imagepng($img);
      $image = ob_get_contents();
      imagedestroy($img);
      ob_end_clean();
  
      $im['type'] = 'png';
      $im['data'] = base64_encode($image); 
      return $im;  
    }
	}
	/**
	 * Verify captcha code
	 */
	public function verify()
	{
		//XXX
	}
}
?>