{**
 * $Id$
 *
 * $URL$
 * <BR>Admin layout file
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-13 16:04:00
 * @access     public
 * @package    RudWEb
 * @subpackage rwSkinRwS
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
{* adm_lang, app_skin_url *}
{if $smarty.const._APP_CFG_SESSIONS}
{assign var="app_pre" value=$smarty.const._APP_PRE}
{assign var="adm_lang_suf" value="_adm_lang"}
{assign var="adm_lang" value=$app_pre$adm_lang_suf}
{assign var="adm_lang" value=$smarty.session.$adm_lang}
{assign var="app_skin_suf" value="_skin_url"}
{assign var="app_skin_ses" value=$app_pre$app_skin_suf}
{assign var="app_skin_url" value=$smarty.session.$app_skin_ses}
{else}
{assign var="app_skin_url" value=$smarty.const._APP_SKIN_URL}
{assign var="adm_lang" value=$smarty.const._APP_LANG}
{/if}
{if $dir != ''}
{assign var="dirsep" value="/"}
{assign var="app_skin_url" value=$app_skin_url$dir$dirsep}
{/if}
<?xml version="1.0" encoding="utf-8" standalone="no"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$adm_lang}" lang="{$adm_lang}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="content-language" content="{$adm_lang}" />
  <link rel="icon" type="image/ico" href="{$app_skin_url}graphics/favicon.ico" />
  <link rel="shortcut icon" type="image/ico" href="{$app_skin_url}graphics/favicon.ico" />
  <title>{$title} .:. {$smarty.const._APP_NAME}</title>
  <meta name="title" content="{$title}" />
  <meta name="subject" content="{$meta.subject}" />
  <meta name="description" content="{$meta.description}" />
  <meta name="keywords" content="{$meta.keywords}" />
  <meta name="copyright" content="{$meta.copyright}" />
  <meta name="designer" content="{$meta.designer}" />
  <meta name="publisher" content="{$meta.publisher}" />
  <meta name="author" content="{$meta.author}" />
  <meta name="rating" content="General" />
  <meta name="distribution" content="Global" />
  <meta name="robots" content="Index, Follow" />
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <link rel="stylesheet" type="text/css" charset="utf-8" href="{$app_skin_url}styles/style.css" />
  <script type="text/javascript" src="{$app_skin_url}scripts/script.js"></script>
</head>
<body>
<div id="layout">
  <div id="hdr">
    <div id="hdr1">
      &#160;
    </div>
    <div id="hdr2"><div id="header">{$langAdm.MOD.TITLE} .:. {$smarty.const._APP_NAME}</div></div>
    <div id="hdr3">&#160;</div>
  </div>
    <div id="cnt0">
      <div id="left0">
        &#160;
      </div>
      <div id="right0">
        &#160;
      </div>
      <div id="center0">
        &#160;
      </div>
  </div>
  <div id="cnt1">
    <div id="left1">
      <div id="left">
        {$header}
      </div>
    </div>
    <div id="right1">
      <div id="right">
        <div id="langMenu">
          {foreach from=$langs item=ln}
          {if $ln.link == 0}
          <img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/intl/{$ln.lang}.gif" title="{$ln.lang}" alt="{$ln.lang}" />
          {else}
          <a href="{$ln.url}" title="{$ln.lang}"><img src="{php}echo $_SESSION[_APP_PRE.'_skin_url'];{/php}admin/graphics/intl/{$ln.lang}.gif" title="{$ln.lang}" alt="{$ln.lang}" /></a>
          {/if}
          {/foreach}
        </div>
        <div id="user">
        <b>{php}echo $_SESSION[_APP_PRE.'_usr_alias'];{/php}</b>&#160;({php}echo $_SESSION[_APP_PRE.'_usr_name'];{/php})
        <br />
        {$langAdm.AUTH.ALEVEL}:&#160;{php}echo $_SESSION[_APP_PRE.'_usr_lvl'];{/php}
        <br />
        {$langAdm.AUTH.GROUP}:&#160;{php}echo $_SESSION[_APP_PRE.'_usr_grp_name'];{/php}
        {php}if($_SESSION[_APP_PRE.'_auth'] == 1) {{/php}
        <br />
        <a class="" href="{$smarty.const._APP_URL}logout/true" title="{$langAdm.AUTH.LOGOUT}">{$langAdm.AUTH.LOGOUT}</a>
        {php}}{/php}
        </div>
      </div>
    </div>
    <div id="center1">
      <div id="center_space1">&#160;</div>
      <div id="center_content">
        <div id="page_title">
          <h1>{$title}</h1>
        </div>
        <div id="page_content"><!-- max 363 lines -->
          {$content}
        </div>
        <div class="clear"></div>
      </div>
    </div>
  </div>
  <div id="cnt2">
      <div id="left2">
        &#160;
      </div>
      <div id="right2">
        &#160;
      </div>
      <div id="center2">
        &#160;
      </div>
  </div>
  <div id="ftr">
    <div id="footer">
      {$footer}
    </div>
  </div>
</div>
</body>
</html>