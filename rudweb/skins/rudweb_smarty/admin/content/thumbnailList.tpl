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
<div class="imageList">
<div class="cancel">
<a href="JavaScript:jsCancel('{$smarty.const._APP_URL}module/dbContentAdm/')" title="{$lang.MOD.ADMIN.CANCEL}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/cancel.png" title="{$lang.MOD.ADMIN.CANCEL}" alt="{$lang.MOD.ADMIN.CANCEL}" /></a></div>

<div class="imageListLinks">
<a href="{$smarty.const._APP_URL}module/dbContentAdm/action/imageList/label/{$cnt.thumb_label}" title="{$lang.MOD.IMAGE.ADMIN}">{$lang.MOD.IMAGE.ADMIN}</a>
</div>
<div class="imageListLabels">
{$lang.MOD.THUMBNAIL.THUMB_LABELS}:<br />
{foreach from=$cnt.thumb_labels item=label}
&#160;
<a href="{$smarty.const._APP_URL}module/dbContentAdm/action/thumbnailList/label/{$label.thumb_label}" title="{$label.thumb_label}">{$label.thumb_label}</a>
{/foreach}
</div>

<div class="imageListImages">
{foreach from=$cnt.thumb_list item=thumb}
  <div class="imageListImage">
    <b>{$thumb.thumb_title}</b>
    <div class="imageListPreview">
    <img src="{$smarty.const._APP_URL_TMP}{$thumb.thumb_preview}" title="{$thumb.thumb_title}" alt="{$thumb.thumb_title}" />
    </div>
    {$lang.MOD.IMAGE.SIZE}: {$thumb.thumb_width} x {$thumb.thumb_height}
    <br />
    {$lang.MOD.IMAGE.TYPE}: {$thumb.thumb_ext}
    <br />
    <a class="actionButton" href="{$smarty.const._APP_URL}module/dbContentAdm/action/imageDelete/id/{$thumb.thumb_id}/type/thumbnail" title="{$lang.MOD.ADMIN.DELETE}">{$lang.MOD.ADMIN.DELETE}</a>
    <br />
    <a class="actionButton" href="JavaScript:addToFCK('{$smarty.const._APP_URL_THUMB}{$thumb.thumb_file}{$thumb.thumb_ext}', '{$thumb.thumb_width}', '{$thumb.thumb_height}', '{$thumb.thumb_title}')" title="{$lang.MOD.THUMBNAIL.ADD_FCK}">{$lang.MOD.THUMBNAIL.ADD_FCK}</a>
  </div>
{/foreach}
<div class="clearthis">&#160;</div>
</div>
</div>