{**
 * $Id$
 *
 * $URL$
 * <BR>HTML edit template
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-03-03 20:57:00
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
<div id="html_edit">
<form enctype="multipart/form-data" name="{$smarty.const._APP_PRE}_content_edit_form" id="{$smarty.const._APP_PRE}_content_edit_form" action="" method="post">
<table class="content_edit_html">
 <tr>
  <td class="content_edit_form_a">&#160;</td>
  <td class="content_edit_form_b">
  {$lang.MOD.CONTENT.CONTENT_BODY}
  <br />
  <input type="hidden" name="cnt_id" id="cnt_id" value="{$cnt.cnt_id}" />
  <textarea class="content_body" name="cnt_body" id="cnt_body">{$cnt.cnt_body}</textarea>
    {if $cnt.rte eq "FCKeditor"}
  <script type="text/javascript" src="{$smarty.const._APP_WWW}3rdparty/fckeditor/fckeditor.js"></script>
  <script type="text/javascript">
    var oFCKeditor = new FCKeditor( 'cnt_body' ) ;
    oFCKeditor.BasePath = "{$smarty.const._APP_WWW}3rdparty/fckeditor/" ;
    oFCKeditor.Config['CustomConfigurationsPath'] = "{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}/admin/scripts/fckconfig.js";
    oFCKeditor.Config['EditorAreaCSS'] = "{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}/admin/styles/fckeditor.css";
    oFCKeditor.Width = "460";
    oFCKeditor.Height = "300";
    oFCKeditor.ToolbarSet = "rudweb";
    oFCKeditor.Config['SkinPath'] = "{$smarty.const._APP_WWW}3rdparty/fckskins/famfamfamAluminum/";
    oFCKeditor.Config['AutoDetectLanguage']  = false ;
    oFCKeditor.Config['DefaultLanguage']   = '{php}echo $_SESSION[_APP_PRE.'_usr_lang'];{/php}' ;
    oFCKeditor.Config['ImageBrowserURL']   = "{$smarty.const._APP_URL}module/dbContentAdm/action/imageAdmin" ;
    
    oFCKeditor.ReplaceTextarea() ;
  </script>
  {elseif $cnt.rte eq "TinyMCE"}
  <script type="text/javascript" src="{$smarty.const._APP_WWW}3rdparty/tiny_mce/tiny_mce.js"></script>
  {literal}
  <script type="text/javascript">
    tinyMCE.init({
    mode : "textareas"
    });
  </script>
  {/literal}
  {else}
  {/if}
  </td>
 </tr>
 <tr>
  <td class="content_edit_form_a">&#160;</td>
  <td class="content_edit_form_b">
  {$lang.MOD.CONTENT.CONTENT_TEMPLATE}
  <br />
  <input class="content_template" type="text" name="cnt_template" id="cnt_template" maxlength="20" value="{$cnt.cnt_template}" /></td>
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