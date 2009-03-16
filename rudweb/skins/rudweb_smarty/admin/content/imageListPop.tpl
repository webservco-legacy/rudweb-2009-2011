{**
 * $Id$
 *
 * $URL$
 * <BR>Image browser template (popup)
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-03-16 16:17:00
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

<div class="formErrors">
  {foreach from=$cnt.form_err item=err}
  {$err}<br />
  {/foreach}
</div>
<div class="imageListLinks">
<a href="{$smarty.const._APP_URL}module/dbContentAdm/action/thumbnailListPop/label/{$cnt.pic_label}" title="{$lang.MOD.THUMBNAIL.ADMIN}">{$lang.MOD.THUMBNAIL.ADMIN}</a>
</div>
<div class="imageListLabels">
{$lang.MOD.IMAGE.IMAGE_LABELS}:<br />
{foreach from=$cnt.pic_labels item=label}
&#160;
<a href="{$smarty.const._APP_URL}module/dbContentAdm/action/imageListPop/label/{$label.pic_label}" title="{$label.pic_label}">{$label.pic_label}</a>
{/foreach}
</div>
<div class="imageListImages">
{foreach from=$cnt.pic_list item=img}
  <div class="imageListImage">
    <b>{$img.pic_title}</b>
    <div class="imageListPreview">
    <img src="{$smarty.const._APP_URL_TMP}{$img.pic_preview}" title="{$img.pic_title}" alt="{$img.pic_title}" />
    </div>
    {$lang.MOD.IMAGE.SIZE}: {$img.pic_width} x {$img.pic_height}
    <br />
    {$lang.MOD.IMAGE.TYPE}: {$img.pic_ext}
    <br />
    <form enctype="multipart/form-data" name="{$smarty.const._APP_PRE}_thumb_new_form_{$img.pic_id}" id="{$smarty.const._APP_PRE}_thumb_new_form_{$img.pic_id}" action="" method="post">
    <input type="hidden" name="pic_id" id="pic_id" value="{$img.pic_id}" />
    {$lang.MOD.THUMBNAIL.THUMB_SIZE}:
    <input class="thumb_size" type="text" name="thumb_size" id="thumb_size" maxlength="4" value="{$cnt.form.thumb_size}" />
    <br />
    <input class="submit" type="submit" name="thumb_save" id="thumb_save" value="{$lang.MOD.THUMBNAIL.CREATE}" />
    </form>
    <br />
    <a class="actionButton" href="{$smarty.const._APP_URL}module/dbContentAdm/action/imageDelete/id/{$img.pic_id}/type/image" title="{$lang.MOD.ADMIN.DELETE}">{$lang.MOD.ADMIN.DELETE}</a>
    <br />
    <a class="actionButton" href="JavaScript:addToFCK('{$smarty.const._APP_URL_IMG}{$img.pic_file}{$img.pic_ext}', '{$img.pic_width}', '{$img.pic_height}', '{$img.pic_title}')" title="{$lang.MOD.IMAGE.ADD_FCK}">{$lang.MOD.IMAGE.ADD_FCK}</a>
  </div>
{/foreach}
<div class="clearthis">&#160;</div>
</div>



<div class="imageListUpload">
<form enctype="multipart/form-data" name="{$smarty.const._APP_PRE}_image_new_form" id="{$smarty.const._APP_PRE}_image_new_form" action="" method="post">
<table class="imageUpload">
<tr>
  <td class="imageUpload_a">{$lang.MOD.IMAGE.IMAGE_LABEL}</td>
  <td class="imageUpload_a">{$lang.MOD.IMAGE.IMAGE_TITLE}</td>
  <td class="imageUpload_a">{$lang.MOD.IMAGE.IMAGE_FILE}</td>
  <td class="imageUpload_a">&#160;</td>
</tr>
<tr>
  <td class="imageUpload_b">
  <input class="image_label" type="text" name="pic_label" id="pic_label" maxlength="30" value="{$cnt.form.pic_label}" />
  </td>
  <td class="imageUpload_b">
  <input class="image_title" type="text" name="pic_title" id="pic_title" maxlength="150" value="{$cnt.form.pic_title}" />
  </td>
  <td class="imageUpload_b">
  <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
  <input class="image_file" type="file" name="pic_file" id="pic_file" size="1" />
  </td>
  <td class="imageUpload_a">&#160;</td>
  <td class="imageUpload_b">
  <input class="submit" type="submit" name="image_save" id="image_save" value="{$lang.MOD.ADMIN.SAVE}" />
  </td>  
</tr>
</table>
</form>
</div>

</div>