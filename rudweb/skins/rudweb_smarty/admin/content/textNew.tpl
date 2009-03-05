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
{*debug*}
<div id="text_edit">
<form enctype="multipart/form-data" name="{$smarty.const._APP_PRE}_content_new_form" id="{$smarty.const._APP_PRE}_content_new_form" action="" method="post">
<table class="content_edit_text">
 <tr>
  <td class="content_edit_form_a">{$lang.MOD.CONTENT.CONTENT_BODY}</td>
  <td class="content_edit_form_b">
  <input type="hidden" name="pg_id" id="pg_id" value="{$cnt.pg_id}" />
  <textarea class="content_body" name="cnt_body" id="cnt_body">{$cnt.cnt_body}</textarea>
  </td>
 </tr>
 <tr>
  <td class="content_edit_form_a">{$lang.MOD.CONTENT.CONTENT_TEMPLATE}</td>
  <td class="content_edit_form_b"><input class="content_template" type="text" name="cnt_template" id="cnt_template" maxlength="20" value="{$cnt.cnt_template}" /></td>
 </tr>
 <tr>
  <td class="content_edit_form_a">&#160;</td>
  <td class="content_edit_form_b"><input class="content_save" type="submit" name="cnt_save" id="cnt_save" value="{$lang.MOD.ADMIN.SAVE}" /></td>
 </tr>
 </table>
</form>

 <div class="content_edit_errors">
  {foreach from=$cnt.cnt_err item=err}
  {$err}<br />
  {/foreach}
  </div>
</div>