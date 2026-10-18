<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Skin classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2008-12-09 16:08:00
 * @access     public
 * @package    rwOut
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

/**
 * rw_iSkin
 *
 * Methods to be implemented by all skin classes
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwOut
 */
interface rw_iSkin
{
    /**
     * Constructor interface
     */
    function __construct();
    /**
     * Sets skin variables
     *
     * @param mixed $name Variable name
     * @param mixed $value Variable value
     * @return mixed Result
     */
    function set($name, $value);
    /**
     * Parses template file
     *
     * @param mixed $template Template file to be parsed
     * @return mixed Result
     */
    function parse($template);
    /**
     * Displays template file
     *
     * @param mixed $template Template file to be displayed
     * @return mixed Result
     */
    function view($template);
}
/**
 * rw_Skin
 *
 * Template engine switcher
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwOut
 */
class rw_Skin
{
    /**
     * Load template engine
     *
     * @param string $tplEngine
     * @return mixed template engine object
     */
    static function _load($tplEngine = null)
    {
        /**
         * Allowed skin engines
         */
        $tplEngines = array();
        $tplEngines['Smarty']['path'] = 'Smarty.class.php';

        if(array_key_exists($tplEngine, $tplEngines))
        {
            /**
             * Internal skin engine class name
             */
            $skinClass = 'rw_Skin_'.$tplEngine;
            /**
             * External skin engine path
             */
            $tplEnginePath = $tplEngines[$tplEngine]['path'];
            /**
             * Include external skin engine file
             */
            if(is_file(_APP_DIR.'3rdparty/'.$tplEngine.'/'.$tplEnginePath))
            {
                require_once(_APP_DIR.'3rdparty/'.$tplEngine.'/'.$tplEnginePath);
            }
            else if(is_file(_RW_DIR.'3rdparty/'.$tplEngine.'/'.$tplEnginePath))
            {
                require_once(_RW_DIR.'3rdparty/'.$tplEngine.'/'.$tplEnginePath);
            }
            else
            {
                trigger_error('<u>Template Engine Error</u>: Template engine '.$tplEngine . ' is missing.');
            }

            require_once(_RW_DIR_LIB_SKIN.'skin.'.$tplEngine.'.inc.php');
        }
        else {
            /**
             * Default skin engine
             */
            $skinClass = 'rw_Skin_rudweb';
            /**
             * Include internal skin engine class
             */
            require_once(_RW_DIR_LIB_SKIN.'skin.rudweb.inc.php');
        }
        /**
         * Return skin engine class
         */
        return new $skinClass();
    }
}
?>