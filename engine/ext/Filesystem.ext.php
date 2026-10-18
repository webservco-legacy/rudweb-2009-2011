<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Filesystem methods.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-02-16 12:37:00
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
$extAbout['Filesystem']['name'] = 'Filesystem';
/**
 * Extension description.
 */
$extAbout['Filesystem']['desc'] = 'Filesystem methods.';
/**
 * Extension version.
 */
$extAbout['Filesystem']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Filesystem']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Filesystem']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Filesystem']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Filesystem']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Filesystem']['deps']['lib'] = array('Error');
/**
 * Extension extension dependencies.
 */
$extAbout['Filesystem']['deps']['ext'] = array();

/**
 * rw_Extension_Filesystem.
 *
 * rw_Extension_Filesystem extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Filesystem extends rw_Extension implements rw_iExtension
{
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
    }

    /**
     * Get file mime.
     *
     * Try to get the mime of the file using various methods.
     * I feverything failes, the default "application/octet-stream" is returned.
     *
     * @param $file file path to check
     * @return mixed result
     */
    public function getFileMime($file)
    {
        /**
         * Set default mime.
         */
        $mime = 'application/octet-stream';
        /**
         * Check for mime_content_type.
         */
        if(function_exists('mime_content_type'))
        {
            /**
             * Return result.
             */
            return mime_content_type($file);
        }
        /**
         * Check for Fileinfo extension.
         */
        if(function_exists('finfo_open'))
        {
            /**
             * Init fileinfo.
             */
            $finfo = new finfo(FILEINFO_MIME);
            /**
             * Check if action was sucessfull.
             */
            if($finfo)
            {
                /**
                 * Get information.
                 */
                $nfo = explode(';', $finfo->file($file));
                /**
                 * Return result.
                 */
                return trim($nfo[0]);
            }
        }
        /**
         * Check for exif_imagetype.
         */
        if(function_exists('exif_imagetype'))
        {
            /**
             * Return result.
             */
            return image_type_to_mime_type(exif_imagetype($file));
        }
        /**
         * Check for getimagesize.
         */
        if(function_exists('getimagesize'))
        {
            /**
             * Get information.
             */
            $nfo = getimagesize($file);
            /**
             * Return result.
             */
            return $nfo['mime'];
        }
        /**
         * If we got here, everything failed.
         * Return default mime.
         */
        return $mime;
    }
}
?>