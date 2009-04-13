{**
 * $Id$
 *
 * $URL$
 * <BR>Text new template
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-23 18:57:00
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
<a href="{$smarty.const._APP_URL}module/dbContentAdm/action/pageEdit/id/{$cnt.pg_id}" title="{$langAdm.MOD.ADMIN.CANCEL}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/cancel.png" title="{$langAdm.MOD.ADMIN.CANCEL}" alt="{$langAdm.MOD.ADMIN.CANCEL}" /></a></div>

<div class="content_form">

<div class="formErrors">
  {foreach from=$cnt.cnt_err item=err}
  {$err}<br />
  {/foreach}
</div>

<div class="clearthis">&#160;</div>
<form enctype="multipart/form-data" name="{$smarty.const._APP_PRE}_content_new_form" id="{$smarty.const._APP_PRE}_content_new_form" action="" method="post">
  <div class="page_input4">
  {$langAdm.MOD.CONTENT.CONTENT_BODY}:<br />
  <input type="hidden" name="pg_id" id="pg_id" value="{$cnt.pg_id}" />
  <textarea class="content_body" name="cnt_body" id="cnt_body">{$cnt.cnt_body}</textarea>
  </div>
  <div class="clearthis">&#160;</div>

  <div class="page_input1">{$langAdm.MOD.CONTENT.CONTENT_TEMPLATE}:</div>
  <div class="page_input2"><input class="content_template" type="text" name="cnt_template" id="cnt_template" maxlength="20" value="{$cnt.cnt_template}" /></div>
  <div class="clearthis">&#160;</div>

  <div class="page_input3"><input class="submit" type="submit" name="cnt_save" id="cnt_save" value="{$langAdm.MOD.ADMIN.SAVE}" /></div>
  <div class="clearthis">&#160;</div>
</form>
</div>

</div>
 
 

