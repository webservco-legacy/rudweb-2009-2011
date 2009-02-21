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
 {$lang.AUTH.LOGIN_MSG}
 <br />
<form enctype="multipart/form-data" name="{$smarty.const._APP_PRE}_login_form" id="{$smarty.const._APP_PRE}_login_form" action="" method="post">
<table border="1">
<tr>
  <td>
    User name:
  </td>
  <td>
    <input type="hidden" NAME="{$smarty.const._APP_PRE}_token" VALUE="{php}echo $_SESSION[_APP_PRE.'_token'];{/php}">
    <input class="input_login" type="text" name="{$smarty.const._APP_PRE}_login" id="{$smarty.const._APP_PRE}_login" maxlength="30" value="" />
  </td>
</tr>
<tr>
  <td>
    Password
  </td>
  <td>
    <input class="input_login" type="password" name="{$smarty.const._APP_PRE}_pass" id="{$smarty.const._APP_PRE}_pass" maxlength="30" value="" />
  </td>
</tr>
<tr>
  <td>
    <img src="{$cnt.captcha}" alt="" title="" />
  </td>
  <td>
    <input class="input_login" type="text" name="{$smarty.const._APP_PRE}_captcha" id="{$smarty.const._APP_PRE}_captcha" maxlength="5" value="" />
  </td>
</tr>
<tr>
  <td>
    &#160;
  </td>
  <td>
    <input type="submit" class="login_submit" name="{$smarty.const._APP_PRE}_submit" id="{$smarty.const._APP_PRE}_submit" value="Submit" />
  </td>
</tr>
</table>
</form>
<pre>

{php}print_r($_SESSION){/php}
{php}print_r($_POST){/php}
{$usr_status}
</pre>