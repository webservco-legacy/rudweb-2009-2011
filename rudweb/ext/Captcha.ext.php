<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Captcha extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-22 18:28:00
 * @access     public
 * @package    rwExt
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
 * Security check.
 */
if (!defined('_RW_VALID'))
{
	/**
	 * Display "Not Found" page.
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * Extension name.
 */
$extAbout['Captcha']['name'] = 'Captcha';
/**
 * Extension description.
 */
$extAbout['Captcha']['desc'] = 'Captcha Extension.';
/**
 * Extension version.
 */
$extAbout['Captcha']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Captcha']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Captcha']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Captcha']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Captcha']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Captcha']['deps']['lib'] = array('Error');
/**
 * Extension extension dependencies.
 */
$extAbout['Captcha']['deps']['ext'] = array();

/**
 * rw_Extension_Captcha.
 *
 * rw_Extension_Captcha extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Captcha extends rw_Extension implements rw_iExtension
{
	/**
	 * Image type to output.
	 *
	 * values: png
	 *
	 * @var string
	 */
	private $imgType = NULL;

	/**
	 * Image output type.
	 *
	 * values: image, string
	 *
	 * @var string
	 */
	private $imgOut = NULL;

	/**
	 * Image width.
	 *
	 * @var integer
	 */
	private $imgWidth = 0;

	/**
	 * Image height.
	 *
	 * @var integer
	 */
	private $imgHeight = 0;

	/**
	 * Image background color.
	 *
	 * @var array
	 */
	private $imgBg = array();

	/**
	 * Image foreground color.
	 *
	 * @var array
	 */
	private $imgFg = array();

	/**
	 * Full font file path.
	 *
	 * @var string
	 */
	private $fontPath = NULL;

	/**
	 * Font size.
	 *
	 * @var integer
	 */
	private $fontSize = 0;

	/**
	 * Constructor.
	 *
	 * @param array $extAbout
	 * @return mixed result
	 */
	public function __construct($extAbout)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($extAbout);
		/**
		 * Set image type.
		 */
		$this->imgType = 'png';
		/**
		 * Set output type.
		 */
		$this->imgOut = 'image';
		/**
		 * Set image width.
		 */
		$this->imgWidth = 70;
		/**
		 * Set image height.
		 */
		$this->imgHeight = 18;
		/**
		 * Set background color.
		 */
		$this->imgBg = array(0xff, 0xff, 0xff);
		/**
		 * Setforeground color.
		 */
		$this->imgFg = array(0x99, 0x99, 0x99);
		/**
		 * Set font file path.
		 */
		$this->fontPath = _RW_TTF_DIR.'VeraMono.ttf';
		/**
		 * Set font size.
		 */
		$this->fontSize = 12;
	}

	/**
	 * Display captcha image.
	 *
	 * @return mixed result.
	 */
	public function displayCaptcha()
	{
		/**
		 * Turn on output buffering.
		 */
		ob_start();
		/**
		 * Set text.
		 */
		$txt = $this->_generateCaptcha();
		/**
		 * Initialize image.
		 */
		$img = imagecreatetruecolor($this->imgWidth, $this->imgHeight);
		/**
		 * Set background color.
		 */
		$bgc = imagecolorallocate($img, $this->imgBg[0], $this->imgBg[1], $this->imgBg[2]);
		/**
		 * Set foreground color.
		 */
		$fgc = imagecolorallocate($img, $this->imgFg[0], $this->imgFg[0], $this->imgFg[0]);
		/**
		 * Fill image with background color.
		 */
		imagefill($img, 0, 0, $bgc);
		/**
		 * Write to image (1).
		 */
		imagettftext($img, $this->fontSize, 10, 3, 16, $fgc, $this->fontPath, $txt['4']);
		/**
		 * Write to image (2).
		 */
		imagettftext($img, $this->fontSize, -30, 13, 12, $fgc, $this->fontPath, $txt['3']);
		/**
		 * Write to image (3).
		 */
		imagettftext($img, $this->fontSize, 10, 30, 16, $fgc, $this->fontPath, $txt['2']);
		/**
		 * Write to image (4).
		 */
		imagettftext($img, $this->fontSize, -10, 40, 14, $fgc, $this->fontPath, $txt['1']);
		/**
		 * Write to image (5).
		 */
		imagettftext($img, $this->fontSize, 10, 58, 16, $fgc, $this->fontPath, $txt['0']);
		/**
		 * Check what image type we should output.
		 */
		switch($this->imgType)
		{
			/**
			 * PNG Selected.
			 */
			case 'png' : {
				/**
				 * Output png image.
				 */
				imagepng($img);
				/**
				 * Set png image header.
				 */
				header("Content-type: image/png");
				/**
				 * Stop execution.
				 */
				break;
			}
			/**
			 * Default image type is png.
			 */
			default : {
				/**
				 * Output png image.
				 */
				imagepng($img);
				/**
				 * Set png image header.
				 */
				header("Content-type: image/png");
				/**
				 * Stop execution.
				 */
				break;
			}
		}
		/**
		 * Set cache control header (HTTP/1.1).
		 */
		header("Cache-Control: no-cache, must-revalidate");
		/**
		 * Set expire header to a date in the past.
		 */
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		/**
		 * Get image data.
		 */
		$image = ob_get_contents();
		/**
		 * Destroy image.
		 */
		imagedestroy($img);
		/**
		 * Erase the output buffer and turn off output buffering.
		 */
		ob_end_clean();
		/**
		 * Check how we should return image data.
		 */
		switch($this->imgOut)
		{
			/**
			 * Image selected.
			 */
			case 'image' : {
				/**
				 * Return image data.
				 */
				return $image;
				/**
				 * Stop execution.
				 */
				break;
			}
			/**
			 * String selected.
			 */
			case 'string' : {
				/**
				 * Return base64 encoded image data.
				 */
				return base64_encode($image);
				/**
				 * Stop execution.
				 */
				break;
			}
			/**
			 * Dafault output is image data.
			 */
			default : {
				/**
				 * Return image data.
				 */
				return $image;
				/**
				 * Stop execution.
				 */
				break;
			}
		}
	}

	/**
	 * Generate captcha.
	 *
	 * @return mixed content
	 */
	private function _generateCaptcha()
	{
		/**
		 * Return captcha array if we have a valid session, or a blank array otherwise.
		 */
		return (isset($_SESSION[_APP_PRE.'_usr']['token'])) ? str_split(strtoupper($_SESSION[_APP_PRE.'_usr']['token']), 1) : array('', '', '', '', '');
	}
}
?>