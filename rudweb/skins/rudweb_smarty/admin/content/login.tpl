{**
 * $Id$
 *
 * $URL$
 * <BR>Login template
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-13 09:27:00
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
  <a href="{$smarty.const._APP_WWW}" title="{$langAdm.MOD.ADMIN.CANCEL}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/icons/cancel.png" title="{$langAdm.MOD.ADMIN.CANCEL}" alt="{$langAdm.MOD.ADMIN.CANCEL}" /></a></div>
<p> 
{$langAdm.AUTH.LOGIN_MSG}
</p> 
<p> 
{$langAdm.AUTH.STATUS}:&#160;{$langAdm.USR_STATUS.$usr_status}
</p> 
<form enctype="multipart/form-data" name="{$smarty.const._APP_PRE}_login_form" id="{$smarty.const._APP_PRE}_login_form" action="" method="post">
<div class="login_form">  
  <div class="login1">
    {$langAdm.AUTH.USER_NAME}:&#160;
  </div>
  <div class="login2">
    <input type="hidden" NAME="{$smarty.const._APP_PRE}_token" VALUE="{php}echo $_SESSION[_APP_PRE.'_token'];{/php}">
    <input class="input_user" type="text" name="{$smarty.const._APP_PRE}_login" id="{$smarty.const._APP_PRE}_login" maxlength="30" value="" />
  </div>
  <div class="login0">&#160;</div>
  <div class="login1">
    {$langAdm.AUTH.PASSWORD}:&#160;
  </div>
  <div class="login2">
    <input class="input_password" type="password" name="{$smarty.const._APP_PRE}_pass" id="{$smarty.const._APP_PRE}_pass" maxlength="30" value="" />
  </div>
  <div class="login0">&#160;</div>
  <div class="login1">
    {$langAdm.AUTH.CAPTCHA}:&#160;
  </div>
  <div class="login2">
    <img class="captcha" src="{$cnt.captcha}" alt="{$langAdm.AUTH.CAPTCHA}" title="{$langAdm.AUTH.CAPTCHA}" />
    =
    <input class="input_captcha" type="text" name="{$smarty.const._APP_PRE}_captcha" id="{$smarty.const._APP_PRE}_captcha" maxlength="5" value="" />
  </div>
  <div class="login0">&#160;</div>
  <div class="login3">
    <input type="submit" class="login_submit submit" name="{$smarty.const._APP_PRE}_submit" id="{$smarty.const._APP_PRE}_submit" value="{$langAdm.AUTH.LOGIN_TT}" />
  </div>
</div>
</form>
</div>