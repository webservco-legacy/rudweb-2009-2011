<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Thumbnail extension.
 * <BR>Create image thumbnails.
 * <BR>Reads an image and creates a thumbnail
 * <BR>in the specified directory.
 * <BR>If the thumbnail already exists,
 * <BR>it doesn't create it again.
 * <BR>Returns thumbnail name.
 * <BR>Input formats: png, jpeg, gif.
 * <BR>Output formats: png, jpeg, gif.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-02-17 13:09:00
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
     * Stop script execution.
     */
    exit;
}

/**
 * Extension name.
 */
$extAbout['Captcha']['name'] = 'Thumb';
/**
 * Extension description.
 */
$extAbout['Thumb']['desc'] = 'Thumb Extension.';
/**
 * Extension version.
 */
$extAbout['Thumb']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Thumb']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Thumb']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Thumb']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Thumb']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Thumb']['deps']['lib'] = array('Error');
/**
 * Extension extension dependencies.
 */
$extAbout['Thumb']['deps']['ext'] = array();

/**
 * rw_Extension_Thumb.
 *
 * rw_Extension_Thumb extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Thumb extends rw_Extension implements rw_iExtension
{
    /**
     * Image source.
     *
     * @var string
     */
    protected $imgSrc = NULL;

    /**
     * Directory to use for thumbnails.
     *
     * @var string
     */
    protected $imgDir = NULL;

    /**
     * Thumbnail image type to output.
     *
     * 1 - gif
     * 2 - jpg
     * 3 - png
     *
     * @var integer
     */
    protected $imgType = NULL;

    /**
     * Maximum thumbnail size (width or height).
     *
     * @var integer;
     */
    protected $imgSize = 0;

    /**
     * Thumbnail image width.
     *
     * @var imteger
     */
    protected $imgWidth = 0;
    /**
     * Thumbnail image height.
     *
     * @var integer
     */
    protected $imgHeight = 0;

    /**
     * Thumbnail image file name.
     *
     * @var string
     */
    protected $imgFile = NULL;

    /**
     * Thumbnail iImage file name suffix.
     *
     * @var string
     */
    protected $imgSuf = NULL;

    /**
     * Use file extension for thumbnail image file.
     *
     * @var boolean
     */
    protected $imgHasExt = TRUE;

    /**
     * Thumbnail image file extension.
     *
     * @var boolean
     */
    protected $imgExt = NULL;

    /**
     * Full path to thumbnail image.
     *
     * @var string
     */
    protected $imgPath = NULL;

    /**
     * Thumbnail output type.
     *
     * values: output, file
     *
     * @var string
     */
    protected $imgOut = NULL;

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
         * Set default image type.
         */
        $this->imgDir = _APP_TMP_DIR;
        /**
         * Set default image type to png.
         */
        $this->imgType = 3;
        /**
         * Set default image size.
         */
        $this->imgSize = 100;
        /**
         * Set default image file suffix.
         */
        $this->imgSuf = '_thumb';
        /**
         * Set default output type.
         */
        $this->imgOut = 'file';
    }

    /**
     * Main extension functionality.
     *
     * Create image thumbnail (if it doeasn't exist).
     * Return thumbnail file name.
     *
     * @param string $img original image path.
     * @return mixed result
     */
    public function rwThumb($img=NULL)
    {
        /**
         * Set image source.
         */
        $this->imgSrc = $img;
        /**
         * Check if we really have a source.
         */
        if(!$this->imgSrc || !is_readable($this->imgSrc) || !is_file($this->imgSrc))
        {
            /**
             * Display error message.
             */
            trigger_error('Extension:::THUMB_NOFILE', 256);
        }
        /**
         * Check if working directory exists.
         */
        if(!is_dir($this->imgDir))
        {
            /**
             * Attempt to create it.
             */
            if(!@mkdir($this->imgDir))
            {
                /**
                 * Display error message.
                 */
                trigger_error('Extension:::THUMB_NODIR', 256);
            }
        }
        /**
         * Set thumbnail extension.
         */
        $this->imgExt = ($this->imgHasExt) ? image_type_to_extension($this->imgType, TRUE) : NULL;
        /**
         * Set thumbnail file name.
         */
        $this->imgFile = md5_file($this->imgSrc).$this->imgSuf.$this->imgExt;
        /**
         * Set thumbnail file path.
         */
        $this->imgPath = $this->imgDir.$this->imgFile;
        /**
         * Check if thumbnail doeasn't already exist.
         */
        if(!is_readable($this->imgPath))
        {
            /**
             * Create thumbnail image.
             */
            $this->_createThumb();
        }
        /**
         * Return thumbnail file name.
         */
        return $this->imgFile;
    }

    /**
     * Set thumbnail image dimensions.
     * Based on source image diemsnions
     * and maximum thumbnail dimensions.
     *
     * @param integer $srcWidth source image width
     * @param integer $srcHeight source image height
     * @return mixed result
     */
    private function _setDimensions($srcWidth, $srcHeight)
    {
        /**
         * Check source dimensions - is landscape?
         */
        if ($srcWidth > $srcHeight)
        {
            /**
             * Set thumbnail width.
             */
            $this->imgWidth  = $this->imgSize;
            /**
             * Set thumbnail height.
             */
            $this->imgHeight = ($srcHeight * $this->imgSize) / $srcWidth;
        }
        /**
         * Check source dimensions - is portrait?
         */
        else if ($srcWidth < $srcHeight)
        {
            /**
             * Set thumbnail width.
             */
            $this->imgWidth  = ($srcWidth * $this->imgSize) / $srcHeight;
            /**
             * Set thumbnail height.
             */
            $this->imgHeight = $this->imgSize;
        }
        /**
         * Check source dimensions - is square?
         */
        else if ($srcWidth == $srcHeight)
        {
            /**
             * Set thumbnail width.
             */
            $this->imgWidth  = $this->imgSize;
            /**
             * Set thumbnail height.
             */
            $this->imgHeight = $this->imgSize;
        }
    }

    /**
     * Create thumbnail image.
     *
     * @return mixed result
     */
    private function _createThumb()
    {
        /**
         * Start output buffering
         */
        ob_start();
        /**
         * Get source info.
         */
        list($srcWidth, $srcHeight, $srcType) = getimagesize($this->imgSrc);
        /**
         * Check source type.
         */
        switch ($srcType) {
            /**
             * Gif.
             */
            case 1 : {
                /**
                 * Create raw image from original source.
                 */
                $raw = imagecreatefromgif($this->imgSrc);
                /**
                 * Stop execution.
                 */
                break;
            }
            /**
             * Jpeg
             */
            case 2 : {
                /**
                 * Create raw image from original source.
                 */
                $raw = imagecreatefromjpeg($this->imgSrc);
                /**
                 * Stop execution.
                 */
                break;
            }
            /**
             * Png.
             */
            case 3 : {
                /**
                 * Create raw image from original source.
                 */
                $raw = imagecreatefrompng($this->imgSrc);
                /**
                 * Stop execution.
                 */
                break;
            }
            /**
             * Source image type not supported.
             */
            default : {
                /**
                 * Display error message.
                 */
                trigger_error('Extension:::THUMB_SOURCE_NS', 256);
                /**
                 * Stop execution.
                 */
                break;
            }
        }
        /**
         * Set thumbnail dimensions.
         */
        $this->_setDimensions($srcWidth, $srcHeight);
        /**
         * Create a new blank image with the new dimensions
         */
        $new = imagecreatetruecolor($this->imgWidth, $this->imgHeight);
        /**
         * Copy raw image to new resized one
         */
        imagecopyresampled($new, $raw, 0, 0, 0, 0, $this->imgWidth, $this->imgHeight, $srcWidth, $srcHeight);
        /**
         * Check thumbnail output format.
         */
        switch($this->imgType)
        {
            /**
             * Gif.
             */
            case 1 : {
                /**
                 * Create Gif image.
                 */
                imagegif($new);
                /**
                 * Check if image will be outputted directly.
                 */
                if($this->imgOut == 'output')
                {
                    /**
                     * Set image header.
                     */
                    header("Content-type: image/gif");
                }
                /**
                 * Stop execution.
                 */
                break;
            }
            /**
             * Jpeg.
             */
            case 2 : {
                /**
                 * Create Jpeg image with maximum quality.
                 */
                imagejpeg($new, NULL, 100);
                /**
                 * Check if image will be outputted directly.
                 */
                if($this->imgOut == 'output')
                {
                    /**
                     * Set image header.
                     */
                    header("Content-type: image/jpeg");
                }
                /**
                 * Stop execution.
                 */
                break;
            }
            /**
             * Png.
             */
            case 3 : {
                /**
                 * Create Png image with maximum quality.
                 */
                imagepng($new, NULL, 9);
                /**
                 * Check if image will be outputted directly.
                 */
                if($this->imgOut == 'output')
                {
                    /**
                     * Set image header.
                     */
                    header("Content-type: image/png");
                }
                /**
                 * Stop execution.
                 */
                break;
            }
            /**
             * Png by default.
             */
            default : {
                /**
                 * Create Png image with maximum quality.
                 */
                imagepng($new, NULL, 9);
                /**
                 * Stop execution.
                 */
                break;
            }
        }
        /**
         * Capture output to string.
         */
        $image = ob_get_contents();
        /**
         * End capture
         */
        ob_end_clean();
        /**
         * Remove created image from memory (we still have it in the $image string)
         */
        imagedestroy($new);
        /**
         * Check how we should return image data.
         */
        switch($this->imgOut)
        {
            /**
             * Output image directly.
             */
            case 'output' : {
                /**
                 * Just output the image.
                 */
                return $image;
                /**
                 * Stop execution.
                 */
                break;
            }
            /**
             * Write to file.
             */
            case 'file' : {
                /**
                 * Create new thumbnail image file.
                 *
                 * "w" = open for writing only,
                 * place the file pointer at the beginning of the file,
                 * truncate the file to zero length,
                 * try to create the file if not exist.
                 * "b" = force binary mode.
                 */
                $thumb = fopen($this->imgPath, "wb");
                /**
                 * Write the image from the string to the file.
                 */
                fwrite($thumb, $image);
                /**
                 * Close thumbnail image file.
                 */
                fclose($thumb);
                /**
                 * Stop execution.
                 */
                break;
            }
            /**
             * Default is to write to file.
             */
            default : {
                /**
                 * Create new thumbnail image file.
                 *
                 * "w" = open for writing only,
                 * place the file pointer at the beginning of the file,
                 * truncate the file to zero length,
                 * try to create the file if not exist.
                 * "b" = force binary mode.
                 */
                $thumb = fopen($this->imgPath, "wb");
                /**
                 * Write the image from the string to the file.
                 */
                fwrite($thumb, $image);
                /**
                 * Close thumbnail image file.
                 */
                fclose($thumb);

                /**
                 * Stop execution.
                 */
                break;
            }
        }
        /**
         * Return result.
         */
        return TRUE;
    }
}
?>