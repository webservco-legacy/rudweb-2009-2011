<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Globl additional templates
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-23 14:44:00
 * @access     public
 * @package    RudWEb
 * @subpackage App
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
 * Completely override menu
 */
//$atpl['menu'] = array();
/**
 * Set directory and template
 */
//$atpl['menu']['dir'] = '';
//$atpl['menu']['tpl'] = 'menu';
/**
 * Completely override menu vars
 */
//$atpl['menu']['vars'] = array();

/**
 * Completely override actual content
 */
//$atpl['content'] = array();
//$atpl['content'][0] = array();
/**
 * Set directoy and template
 */
//$atpl['content'][0]['dir'] = $cnt['cnt']['dir'];
//$atpl['content'][0]['tpl'] = $cnt['cnt']['tpl'];
/**
 * Actual content
 */
//$atpl['content'][0]['vars']['cnt'] = $cnt['cnt']['content'];
/**
 * Language
 */
//$atpl['content'][0]['vars']['lang'] = $appCore->rwLang();
/**
 * User status
 */
//$atpl['content'][0]['vars']['usr_status'] = $appCore->rwUsrStatus();

/**
 * Completely override footer
 */
//$atpl['footer'] = array();
/**
 * Directory and template
 */
//$atpl['footer']['dir'] = '';
//$atpl['footer']['tpl'] = 'footer';
/**
 * Completely override footer vars
 */
//$atpl['footer']['vars'] = array();
?>