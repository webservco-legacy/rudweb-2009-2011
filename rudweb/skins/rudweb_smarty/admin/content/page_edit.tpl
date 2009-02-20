{**
 * $Id$
 *
 * $URL$
 * <BR>Pages template
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-17 20:04:00
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
<div id="page_edit">
 <div id="page_edit_page">
 <form enctype="multipart/form-data" name="{$smarty.const._APP_PRE}_page_edit_form" id="{$smarty.const._APP_PRE}_page_edit_form" action="" method="post">
 <table class="page_edit_page">
 <tr>
  <td class="page_edit_form_a">{$lang.MOD.PAGE.PAGE_TITLE}</td>
  <td class="page_edit_form_b">
  <input type="hidden" name="pg_id" id="pg_id" value="{$cnt.page_id}" />
  <input class="page_title" type="text" name="pg_title" id="pg_title" maxlength="150" value="{$cnt.page_title}" />
  </td>
 </tr>
 <tr>
  <td class="page_edit_form_a">{$lang.MOD.PAGE.PAGE_KEYWORDS}</td>
  <td class="page_edit_form_b"><input class="page_kw" type="text" name="pg_kw" id="pg_kw" maxlength="255" value="{$cnt.page_kw}" /></td>
 </tr>
 <tr>
  <td class="page_edit_form_a">{$lang.MOD.PAGE.PAGE_DESCRIPTION}</td>
  <td class="page_edit_form_b"><input class="page_dsc" type="text" name="pg_dsc" id="pg_dsc" maxlength="255" value="{$cnt.page_dsc}" /></td>
 </tr>
 <tr>
  <td class="page_edit_form_a">{$lang.MOD.PAGE.PAGE_TEMPLATE}</td>
  <td class="page_edit_form_b"><input class="page_template" type="text" name="pg_template" id="pg_template" maxlength="20" value="{$cnt.page_template}" /></td>
 </tr>
 <tr>
  <td class="page_edit_form_a">&#160;</td>
  <td class="page_edit_form_b"><input class="page_save" type="submit" name="pg_save" id="pg_save" value="{$lang.MOD.ADMIN.SAVE}" /></td>
 </tr>
 </table>
  </form>
  <div class="page_edit_errors">
  {foreach from=$cnt.page_err item=err}
  {$err}<br />
  {/foreach}
  </div>
</div>
<div id="page_edit_content">
<table class="page_edit_content">
<tr>
  <td class="page_edit_content_h1">{$lang.MOD.CONTENT.TYPE}</td>
  <td class="page_edit_content_h2">{$lang.MOD.CONTENT.TEMPLATE}</td>
  <td class="page_edit_content_h3">{$lang.MOD.CONTENT.ACTIONS}</td>
</tr>
{foreach from=$cnt.page_content item=item}
<tr>
  <td class="page_edit_content_1">&#160;</td>
  <td class="page_edit_content_1">&#160;</td>
  <td class="page_edit_content_3">
  <a href="{$smarty.const._APP_URL}module/dbConentAdm/action/content_add/id/{$cnt.page_id}/type/text/place/{$item.cnt_order}" title="{$lang.MOD.CONTENT.ADD_TEXT}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/page_white_add.png" title="{$lang.MOD.CONTENT.ADD_TEXT}" alt="{$lang.MOD.CONTENT.ADD_TEXT}"></a>
  &#160;
  <a href="{$smarty.const._APP_URL}module/dbConentAdm/action/content_add/id/{$cnt.page_id}/type/html/place/{$item.cnt_order}" title="{$lang.MOD.CONTENT.ADD_HTML}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/page_add.png" title="{$lang.MOD.CONTENT.ADD_HTML}" alt="{$lang.MOD.CONTENT.ADD_HTML}"></a>
  </td>
</tr>
<tr>
  <td class="page_edit_content_1">
  {$item.cnt_type}
  </td>
  <td class="page_edit_content_2">
  {$item.cnt_template}
  </td>
  <td class="page_edit_content_3">
  <a href="{$smarty.const._APP_URL}module/dbConentAdm/action/content_edit/id/{$item.cnt_id}" title="{$lang.MOD.CONTENT.EDIT}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/page_white_edit.png" title="{$lang.MOD.CONTENT.EDIT}" alt="{$lang.MOD.CONTENT.EDIT}"></a>
  &#160;
  <a href="{$smarty.const._APP_URL}module/dbConentAdm/action/content_delete/id/{$item.cnt_id}" title="{$lang.MOD.CONTENT.DELETE}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/page_white_delete.png" title="{$lang.MOD.CONTENT.DELETE}" alt="{$lang.MOD.CONTENT.DELETE}"></a>
  </td>
</tr>
{/foreach}
<tr>
  <td class="page_edit_content_1">&#160;</td>
  <td class="page_edit_content_2">&#160;</td>
  <td class="page_edit_content_3">
  <a href="{$smarty.const._APP_URL}module/dbConentAdm/action/content_add/id/{$cnt.page_id}/type/text/place/0" title="{$lang.MOD.CONTENT.ADD_TEXT}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/page_white_add.png" title="{$lang.MOD.CONTENT.ADD_TEXT}" alt="{$lang.MOD.CONTENT.ADD_TEXT}"></a>
  &#160;
  <a href="{$smarty.const._APP_URL}module/dbConentAdm/action/content_add/id/{$cnt.page_id}/type/html/place/0" title="{$lang.MOD.CONTENT.ADD_HTML}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/page_add.png" title="{$lang.MOD.CONTENT.ADD_HTML}" alt="{$lang.MOD.CONTENT.ADD_HTML}"></a>
  </td>
</tr>
</table>
</div>
</div>