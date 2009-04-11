<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Internationalization module
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-04-11 10:46:00
 * @access     public
 * @package    RudWEb
 * @subpackage Modules
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

class rw_Mod_intl extends rw_Mod_global implements rw_iMod
{
  /**
   * Constructor
   *
   * Set module information and call parent constructor
   */
  public function __construct($appCore)
  {
    /**
     * Module info
     */
    $about['name'] = 'Internationalization';
    $about['desc'] = 'Internationalization module.';
    $about['ver']  = '$Revision$';
    $about['auth'] = 'Radu Maier';
    $about['web']  = 'http://www.rudisoft.net';
    $about['mail'] = 'rudisoft@rudisoft.net';
    $about['deps'] = array();
    $about['deps']['cfg'] = array();
    $about['deps']['ext'] = array();
    $about['deps']['mod'] = array();
    /**
     * These must be declared
     */
    $cnt['skin'] = array();
    $cnt['skin']['meta'] = array();
    $cnt['cnt'] = array();
    /**
     * Module default content
     *
     * $cnt['type'] added by default in parent class
     * $cnt['skin']['dir'] added by default in parent class
     * $cnt['skin']['tpl'] added by default in parent class
     * $cnt['skin']['title'] added by default in parent class
     * $cnt['skin']['meta'] added by default in parent class
     * $cnt['skin']['lang'] added by default in parent class
     */
    $cnt['skin']['dir'] = 'admin';
    $cnt['skin']['tpl'] = 'layout';
    $cnt['cnt']['dir'] = 'content';
    $cnt['cnt']['tpl'] = 'blank';
    $cnt['cnt']['content'] = array();
    /**
     * Call parent constructor
     */
    parent::__construct($about, $cnt, $appCore);
  }
  /**
   * Default module functionality
   *
   * @return mixed result
   */
  public function _default()
  {
    return $this->modCnt;
  }
}
?>