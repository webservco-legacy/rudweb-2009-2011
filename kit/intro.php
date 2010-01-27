<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>No description
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @access     public
 * @package    RudWEb-1.0
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
 *
./intro.php
09:27 2008-04-21
*/
define("_RUDWEB_PUBFIL", TRUE);
require_once './inc/config.inc.php';
require_once './inc/rudwebc.inc.php';
require_once _RUDWEB_INC_DIR . 'rudweb1.inc.php';
//require_once _RUDWEB_INC_DIR . 'rudweb2.inc.php';

$rudweb_cnt_type           = "0";  // NOT REALLY NEEDED
$rudweb_this_content       = 'intro';  // NOT REALLY NEEDED   index
$rudweb_this_content_level = getCntLev($rudweb_this_content);  // NOT REALLY NEEDED
$rudweb_mnu_id             = getCntMnuId('index');  // NOT REALLY NEEDED
$rudweb_mnu_id             = "0";  // only for travel-agency
$rudweb_stats_page         = 'intro';
$rudweb_req_page           = 'intro'; // NOT REALLY NEEDED
$rudweb_page_title         = _RUDWEB_WSTT . " - " . "Index";
$rudweb_page_description   = _RUDWEB_WSDS;
$rudweb_page_keywords      = _RUDWEB_WSKW;

require_once _RUDWEB_INC_DIR . 'rudweb3.inc.php';
require_once _RUDWEB_INC_DIR . 'phphdi.inc.php';
?>