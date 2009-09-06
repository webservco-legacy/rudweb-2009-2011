<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>RudWEb Directory Structure
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-06 19:39:00
 * @access     public
 * @package    rwWork
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


$rwDirStr = array();

$rwDirStr['core'] = 'engine directory structure';
$rwDirStr['core']['rudweb'] = 'main engine directory';

$rwDirStr['app'] = 'application directory structure';
$rwDirStr['app']['test'] = 'test application directory';

$rwDirStr['docs'] = 'documentation directory structure';
$rwDirStr['docs']['docs'] = 'main documentation directory';
?>
<pre>
<?php print_r($rwDirStr); ?>
</pre>