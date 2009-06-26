{**
 * $Id$
 *
 * $URL
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
<a href="{$smarty.const._APP_URL}module/dbContentAdm/action/pageList" title="{$langAdm.MOD.ADMIN.CANCEL}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/cancel.png" title="{$langAdm.MOD.ADMIN.CANCEL}" alt="{$langAdm.MOD.ADMIN.CANCEL}" /></a></div>

<div class="page_form">

<div class="formErrors">
{foreach from=$cnt.page_err item=err}
{$err}<br />
{/foreach}
</div>

<div class="clearthis">&#160;</div>
<form enctype="multipart/form-data" name="page_new_form" id="page_new_form" action="" method="post">
  <div class="page_input1">
  {$langAdm.MOD.PAGE.PAGE_TITLE}:
  </div>
  <div class="page_input2">
  <input class="page_title" type="text" name="pg_title" id="pg_title" maxlength="150" value="{$cnt.page_title}" />
  </div>
  <div class="clearthis">&#160;</div>

  <div class="page_input1">
  {$langAdm.MOD.PAGE.PAGE_KEYWORDS}:
  </div>
  <div class="page_input2">
  <input class="page_kw" type="text" name="pg_kw" id="pg_kw" maxlength="255" value="{$cnt.page_kw}" />
  </div>
  <div class="clearthis">&#160;</div>

  <div class="page_input1">
  {$langAdm.MOD.PAGE.PAGE_DESCRIPTION}:
  </div>
  <div class="page_input2">
  <input class="page_dsc" type="text" name="pg_dsc" id="pg_dsc" maxlength="255" value="{$cnt.page_dsc}" />
  </div>
  <div class="clearthis">&#160;</div>

  <div class="page_input1">
  {$langAdm.MOD.PAGE.PAGE_TEMPLATE}:
  </div>
  <div class="page_input2">
  <input class="page_template" type="text" name="pg_template" id="pg_template" maxlength="20" value="{$cnt.page_template}" />
  </div>
  <div class="clearthis">&#160;</div>

  <div class="page_input3">
  <input class="submit" type="submit" name="pg_save" id="pg_save" value="{$langAdm.MOD.ADMIN.SAVE}" />
  </div>
  <div class="clearthis">&#160;</div>
</form>
</div>

</div>