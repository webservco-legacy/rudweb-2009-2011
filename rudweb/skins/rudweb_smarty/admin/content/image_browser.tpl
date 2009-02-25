{**
 * $Id$
 *
 * $URL$
 * <BR>Image browser template
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-25 12:21:00
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
<div id="image_admin_labels">
</div>
<div id="image_admin_list">
{foreach from=$cnt.pic_list item=img}
<div class="image_admin_list_pic">
<img src="{$smarty.const._APP_URL_TMP}{$img.pic_preview}" title="{$img.pic_title}" alt="{$img.pic_title}">
<br />
{$img.pic_title}
<br />
{$img.pic_width} x {$img.pic_height}
<br />
<form enctype="multipart/form-data" name="{$smarty.const._APP_PRE}_thumb_new_form" id="{$smarty.const._APP_PRE}_thumb_new_form" action="" method="post">
<input class="thumb_size" type="text" name="thumb_size" id="thumb_size" maxlength="4" value="" />
&#160;
<input class="thumb_save" type="submit" name="thumb_save" id="thumb_save" value="{$lang.MOD.THUMB.CREATE}" />
</form>
{*$img.pic_id*}
{*$img.pic_file*}

</div>
{/foreach}
<div class="image_admin_list_clear">
</div>
<div id="image_admin_upload">
<form enctype="multipart/form-data" name="{$smarty.const._APP_PRE}_image_new_form" id="{$smarty.const._APP_PRE}_image_new_form" action="" method="post">
<table class="image_form">
<tr>
  <td class="image_form_a">{$lang.MOD.IMAGE.IMAGE_LABEL}</td>
  <td class="image_form_a">{$lang.MOD.IMAGE.IMAGE_TITLE}</td>
  <td class="image_form_a">{$lang.MOD.IMAGE.IMAGE_FILE}</td>
  <td class="image_form_a">&#160;</td>
</tr>
<tr>
  <td class="image_form_b">
  <input class="image_label" type="text" name="pic_label" id="pic_label" maxlength="30" value="{$cnt.form.pic_label}" />
  </td>
  <td class="image_form_b">
  <input class="image_title" type="text" name="pic_title" id="pic_title" maxlength="150" value="{$cnt.form.pic_title}" />
  </td>
  <td class="image_form_b">
  <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
  <input class="image_file" type="file" name="pic_file" id="pic_file" size="1" />
  </td>
  <td class="image_form_a">&#160;</td>
  <td class="image_form_b">
  <input class="image_save" type="submit" name="image_save" id="image_save" value="{$lang.MOD.ADMIN.SAVE}" />
  </td>  
</tr>
</table>
</form>
<div class="image_form_errors">
  {foreach from=$cnt.form_err item=err}
  {$err}<br />
  {/foreach}
</div>
</div>