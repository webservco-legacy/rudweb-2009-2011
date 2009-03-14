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
<div class="pageAction">
  <div class="cancel">
  <a href="{$smarty.const._APP_URL}module/dbContentAdm/action/pageList" title="{$lang.MOD.ADMIN.CANCEL}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/cancel.png" title="{$lang.MOD.ADMIN.CANCEL}" alt="{$lang.MOD.ADMIN.CANCEL}" /></a></div>
 
 
 <div class="page_form">
 <div class="hdtxt">{$lang.MOD.PAGE.EDIT}</div> 
 
 <div class="formErrors">
 {foreach from=$cnt.page_err item=err}
 {$err}<br />
 {/foreach}
 </div>
 
 <div class="clearthis">&#160;</div>
 <form enctype="multipart/form-data" name="{$smarty.const._APP_PRE}_page_edit_form" id="{$smarty.const._APP_PRE}_page_edit_form" action="" method="post">
  <div class="page_input1">{$lang.MOD.PAGE.PAGE_TITLE}:</div>
  <div class="page_input2">
    <input type="hidden" name="pg_id" id="pg_id" value="{$cnt.page_id}" />
    <input class="page_title" type="text" name="pg_title" id="pg_title" maxlength="150" value="{$cnt.page_title}" />
  </div>
  <div class="clearthis">&#160;</div>
 
  <div class="page_input1">{$lang.MOD.PAGE.PAGE_KEYWORDS}:</div>
  <div class="page_input2"><input class="page_kw" type="text" name="pg_kw" id="pg_kw" maxlength="255" value="{$cnt.page_kw}" /></div>
  <div class="clearthis">&#160;</div>
 
  <div class="page_input1">{$lang.MOD.PAGE.PAGE_DESCRIPTION}:</div>
  <div class="page_input2"><input class="page_dsc" type="text" name="pg_dsc" id="pg_dsc" maxlength="255" value="{$cnt.page_dsc}" /></div>
  <div class="clearthis">&#160;</div>
 
  <div class="page_input1">{$lang.MOD.PAGE.PAGE_TEMPLATE}:</div>
  <div class="page_input2"><input class="page_template" type="text" name="pg_template" id="pg_template" maxlength="20" value="{$cnt.page_template}" /></div>
  <div class="clearthis">&#160;</div>
 
  <div class="page_input3"><input class="submit" type="submit" name="pg_save" id="pg_save" value="{$lang.MOD.ADMIN.SAVE}" /></div>
  <div class="clearthis">&#160;</div>
 </form>
 
 <div class="page_form2">
    
 <div class="hdtxt">{$lang.MOD.CONTENT.EDIT}</div>
 
 
 <table class="content_list" cellspacing="0">
<tr>
  <td class="content_list_hdr">{$lang.MOD.CONTENT.TYPE}</td>
  <td class="content_list_hdr">{$lang.MOD.CONTENT.TEMPLATE}</td>
  <td class="content_list_hdr">{$lang.MOD.CONTENT.ACTIONS}</td>
</tr>
{if !empty($cnt.page_content)}
{foreach from=$cnt.page_content item=item}
<tr>
  <td class="content_list_cnt">&#160;</td>
  <td class="content_list_cnt">&#160;</td>
  <td class="content_list_cnt">
  <a href="{$smarty.const._APP_URL}module/dbContentAdm/action/contentAdd/id/{$cnt.page_id}/type/text/order/{$item.cnt_order}" title="{$lang.MOD.CONTENT.ADD_TEXT}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/text_add.png" title="{$lang.MOD.CONTENT.ADD_TEXT}" alt="{$lang.MOD.CONTENT.ADD_TEXT}" /></a>
  &#160;
  <a href="{$smarty.const._APP_URL}module/dbContentAdm/action/contentAdd/id/{$cnt.page_id}/type/html/order/{$item.cnt_order}" title="{$lang.MOD.CONTENT.ADD_HTML}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/html_add.png" title="{$lang.MOD.CONTENT.ADD_HTML}" alt="{$lang.MOD.CONTENT.ADD_HTML}" /></a>
  </td>
</tr>
<tr>
  <td class="content_list_cnt">
  {$item.cnt_type}
  </td>
  <td class="content_list_cnt">
  {$item.cnt_template}
  </td>
  <td class="content_list_cnt">
  <a href="{$smarty.const._APP_URL}module/dbContentAdm/action/contentEdit/id/{$item.cnt_id}" title="{$lang.MOD.CONTENT.EDIT}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/text_edit.png" title="{$lang.MOD.CONTENT.EDIT}" alt="{$lang.MOD.CONTENT.EDIT}" /></a>
  &#160;
  <a href="{$smarty.const._APP_URL}module/dbContentAdm/action/contentDelete/id/{$item.cnt_id}" title="{$lang.MOD.CONTENT.DELETE}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/text_delete.png" title="{$lang.MOD.CONTENT.DELETE}" alt="{$lang.MOD.CONTENT.DELETE}" /></a>
  </td>
</tr>
{/foreach}
{/if}
<tr>
  <td class="content_list_cnt">&#160;</td>
  <td class="content_list_cnt">&#160;</td>
  <td class="content_list_cnt">
  <a href="{$smarty.const._APP_URL}module/dbContentAdm/action/contentAdd/id/{$cnt.page_id}/type/text/order/0" title="{$lang.MOD.CONTENT.ADD_TEXT}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/text_add.png" title="{$lang.MOD.CONTENT.ADD_TEXT}" alt="{$lang.MOD.CONTENT.ADD_TEXT}" /></a>
  &#160;
  <a href="{$smarty.const._APP_URL}module/dbContentAdm/action/contentAdd/id/{$cnt.page_id}/type/html/order/0" title="{$lang.MOD.CONTENT.ADD_HTML}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/html_add.png" title="{$lang.MOD.CONTENT.ADD_HTML}" alt="{$lang.MOD.CONTENT.ADD_HTML}" /></a>
  </td>
</tr>
</table>

 </div>
  
 </div>

 
</div>
