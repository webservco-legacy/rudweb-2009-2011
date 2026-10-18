<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>RudWEb Skin Class
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2008-12-09 19:28:00
 * @access     public
 * @package    RudWEb
 * @subpackage Skins
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

/**
 * rw_Skin_rudweb
 *
 * Skin Class for Rudweb
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Core
 */
class rw_Skin_rudweb implements rw_iSkin
{
    /**
     * Skin directory
     *
     * @var string $skindir Skin directory
     */
    public $skindir;
    /**
     * Skin variables
     *
     * @var mixed $skinvars Skin variables
     */
    public $skinvars;
    /**
     * Constructor
     *
     * @param string $skindir Skin directory
     * @return mixed
     */
    public function __construct($skindir = null)
    {
        $this->skindir = $skindir;
        $this->skinvars = array();
    }
    /**
     * Sets the skin dir
     */
    public function skindir($skindir)
    {
        $this->skindir = $skindir;
    }
    /**
     * Sets a skin variable
     *
     * @param sting $name Variable name
     * @param mixed $value Variable value
     * @return mixed
     */
    public function set($name, $value)
    {
        $this->skinvars[$name] = $value;
    }
    /**
     * Parses the skin file
     *
     * @param string $skinfile Skin file
     * @return mixed
     */
    public function parse($skinfile, $display=FALSE)
    {
        extract($this->skinvars);
        ob_start();
        include ($this->skindir . '/' . $skinfile);
        $out = ob_get_contents();
        ob_end_clean();

        if($display)
        {
            echo $out;
            return true;
        }
        else
        {
            return $out;
        }
    }
    /**
     * Displays results
     */
    public function view($skinfile)
    {
        $this->parse($skinfile, TRUE);
    }
}
?>