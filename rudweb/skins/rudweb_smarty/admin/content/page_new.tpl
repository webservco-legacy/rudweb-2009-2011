{**
 * $Id$
 *
 * $URL$
 * <BR>Page new template
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-21 13:57:00
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
<form enctype="multipart/form-data" name="{$smarty.const._APP_PRE}_page_new_form" id="{$smarty.const._APP_PRE}_page_new_form" action="" method="post">
 <table class="page_new">
 <tr>
  <td class="page_new_form_a">{$lang.MOD.PAGE.PAGE_TITLE}</td>
  <td class="page_new_form_b">
  <input type="hidden" name="" id="" value="" />
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