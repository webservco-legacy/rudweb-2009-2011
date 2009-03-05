{**
 * $Id$
 *
 * $URL$
 * <BR>Image delete template
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-03-05 13:18:00
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
 *}
{$cnt.image_title}
<br />
{$lang.MOD.IMAGE.DELETE_CONFIRM}
<br />
<a href="{$smarty.const._APP_URL}module/dbContentAdm/action/imageDelete/id/{$cnt.image_id}/type/{$cnt.image_type}/delete/true" title="{$lang.MOD.ADMIN.DELETE}">{$lang.MOD.ADMIN.DELETE}</a>
&#160;
<a href="{$smarty.const._APP_URL}module/dbContentAdm/action/{$cnt.image_type}List" title="{$lang.MOD.ADMIN.CANCEL}">{$lang.MOD.ADMIN.CANCEL}</a>