<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Nfo Extension loader.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-04-07 09:25:00
 * @access     public
 * @package    rwTools
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
 * Check if loader is readable.
 */
if(!is_readable($path['app_dir'].'ext.loader.php'))
{
    /**
     * Stop execution.
     */
    exit;
}
/**
 * Load loader file.
 */
require_once($path['app_dir'].'ext.loader.php');

/**
 * rw_Loader_Extension_Nfo.
 *
 * rw_Loader_Extension_Nfo loader.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwTools
 */
class rw_Loader_Extension_Nfo extends rw_Loader_Extension
{
    /**
     * Constructor.
     *
     * @return mixed result
     */
    public function __construct()
    {
        /**
         * Call parent constructor.
         */
        parent::__construct();
    }

    /**
     * Main functionality.
     *
     * @return mixed result
     */
    public function nfo($paths)
    {
        /**
         * Set extension directory.
         */
        $this->_setPaths($paths);
        /**
         * Load extension.
         */
        $this->extObj = $this->_load('nfo');
        /**
         * Output result.
         */
        return $this->_out();
    }

    /**
     * Output method.
     *
     * This is a special method for standalone extensions.
     *
     * @return mixed result
     */
    private function _out()
    {
        /**
         * Return result.
         */
        return $this->_outLayout();
    }

    /**
     * Main layout output method.
     *
     * @return mixed result
     */
    private function _outLayout()
    {
        /**
         * Turn on output buffering.
         */
        ob_start();
        /**
         * Include template.
         */
        include $this->paths['www_dir'].'tpl/nfo.layout.tpl.php';
        /**
         * Get parsed output result from the output buffer.
         */
        $out = ob_get_contents();
        /**
         * Delete output buffer and turn off output buffering.
         */
        ob_end_clean();
        /**
         * Return result.
         */
        return $out;
    }

    /**
     * Header styles output method.
     *
     * @return mixed result
     */
    private function _outStyles()
    {
        /**
         * Turn on output buffering.
         */
        ob_start();
        /**
         * Include template.
         */
        include $this->paths['www_dir'].'tpl/nfo.styles.tpl.php';
        /**
         * Get parsed output result from the output buffer.
         */
        $out = ob_get_contents();
        /**
         * Delete output buffer and turn off output buffering.
         */
        ob_end_clean();
        /**
         * Return result.
         */
        return $out;
    }

    /**
     * Header scripts output method.
     *
     * @return mixed result
     */
    private function _outScripts()
    {
        /**
         * Turn on output buffering.
         */
        ob_start();
        /**
         * Include template.
         */
        include $this->paths['www_dir'].'tpl/nfo.scripts.tpl.php';
        /**
         * Get parsed output result from the output buffer.
         */
        $out = ob_get_contents();
        /**
         * Delete output buffer and turn off output buffering.
         */
        ob_end_clean();
        /**
         * Return result.
         */
        return $out;
    }

    /**
     * Navigation menu output method.
     *
     * @return mixed result
     */
    private function _outMenu()
    {
        /**
         * Turn on output buffering.
         */
        ob_start();
        /**
         * Include template.
         */
        include $this->paths['www_dir'].'tpl/nfo.menu.tpl.php';
        /**
         * Get parsed output result from the output buffer.
         */
        $out = ob_get_contents();
        /**
         * Delete output buffer and turn off output buffering.
         */
        ob_end_clean();
        /**
         * Return result.
         */
        return $out;
    }

    /**
     * Human readable filesize converter.
     *
     * @author rostvertol.mil@gmail.com
     *
     * @param integer $bytes size in bytes
     * @return mixed result
     */
    private function _hrSize($bytes)
    {
        /**
         * Set binary prefix types.
         */
        $types = array('', 'Ki', 'Mi', 'Gi', 'Ti');
        /**
         * Do the magic.
         */
        for ($i = 0;$bytes >= 1024 && $i <( count($types) - 1); $bytes /= 1024, $i++);
        /**
         * Return result.
         */
        return(round($bytes, 2)." ".$types[$i]);
    }
}
?>