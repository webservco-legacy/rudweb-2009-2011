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
 * @since      2009-02-16 16:45:00
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
<a href="JavaScript:toggleTRows('title');">[toggle]</a>&#160;
<a href="JavaScript:toggleTRowGroups('title', '1');">[toggle 1]</a>&#160;
<a href="JavaScript:toggleTRowGroups('title', '2');">[toggle 2]</a>&#160;
<table class="page_list" cellspacing="0">
<tr>
  <td class="page_list_hr pages_lvl">&#160;</td>
  <td class="page_list_hr pages_tt">{$lang.MOD.PAGE.TITLE}</td>
  <td class="page_list_hr pages_auth">{$lang.MOD.PAGE.AUTHOR}</td>
  <td class="page_list_hr pages_grp">{$lang.MOD.PAGE.GROUP}</td>
  <td class="page_list_hr pages_itm">{$lang.MOD.PAGE.ITEMS}</td>
  <td class="page_list_hr pages_op">{$lang.MOD.PAGE.ACTIONS}</td>
</tr>
{$cnt.page_list}
</table>
<script type="text/javascript" language="JavaScript">toggleTRows('title');</script>

<a href="JavaScript:toggleTRows('title');">[toggle]</a>&#160;
<a href="JavaScript:toggleTRowGroups('title', '1');">[toggle 1]</a>&#160;
<a href="JavaScript:toggleTRowGroups('title', '2');">[toggle 2]</a>&#160;