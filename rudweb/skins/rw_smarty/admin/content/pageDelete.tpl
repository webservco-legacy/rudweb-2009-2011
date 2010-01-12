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
 * @since      2009-02-20 20:10:00
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
<h3>{$cnt.page_title}</h3>
{$langAdm.MOD.PAGE.DELETE_CONFIRM_1}
<br />
{$langAdm.MOD.PAGE.DELETE_CONFIRM_2}
<br />
<a class="actionButton" href="{$smarty.const._APP_URL}module/dbContentAdm/action/pageDelete/id/{$cnt.page_id}/delete/true" title="{$langAdm.MOD.ADMIN.DELETE}">{$langAdm.MOD.ADMIN.DELETE}</a>
</div>