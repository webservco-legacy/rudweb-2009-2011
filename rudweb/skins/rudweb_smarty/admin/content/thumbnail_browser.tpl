{**
 * $Id$
 *
 * $URL$
 * <BR>Thumbnail browser template
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-27 15:32:00
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
{*debug*}
<div id="thumb_admin_images">
<a href="{$smarty.const._APP_URL}module/dbContentAdm/action/imageAdmin/label/{$cnt.thumb_label}" title="{$lang.MOD.IMAGE.ADMIN}">{$lang.MOD.IMAGE.ADMIN}</a>
</div>
<div id="thumb_admin_labels">
{$lang.MOD.THUMB.THUMB_LABELS}:
{foreach from=$cnt.thumb_labels item=label}
&#160;
<a href="{$smarty.const._APP_URL}module/dbContentAdm/action/thumbnailAdmin/label/{$label.thumb_label}" title="{$label.thumb_label}">{$label.thumb_label}</a>
{/foreach}
</div>
<div id="thumb_admin_list">
{foreach from=$cnt.thumb_list item=thumb}
<div class="thumb_admin_list_pic">
<img src="{$smarty.const._APP_URL_TMP}{$thumb.thumb_preview}" title="{$thumb.thumb_title}" alt="{$thumb.thumb_title}">
<br />
{$thumb.thumb_title}
<br />
{$lang.MOD.IMAGE.SIZE}: {$thumb.thumb_width} x {$thumb.thumb_height}
<br />
{$lang.MOD.IMAGE.TYPE}: {$thumb.thumb_ext}
<br />
<a href="JavaScript:addToFCK('{$smarty.const._APP_URL_THUMB}{$thumb.thumb_file}{$thumb.thumb_ext}', '{$thumb.thumb_width}', '{$thumb.thumb_height}', '{$thumb.thumb_title}')" title="{$lang.MOD.THUMB.ADD_FCK}">{$lang.MOD.THUMB.ADD_FCK}</a>
</div>
{/foreach}
<div class="thumb_admin_list_clear">
</div>
</div>