<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Misc stuff
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      0000-00-00 00:00:00
 * @access     public
 * @package    RudWEb
 * @subpackage Temp
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
 */


/**
 * Data types:
 * 
 * $cnt['type'] = 'text';
 * $cnt['skin'] ...
 * $cnt['cnt'] ...
 * 
 * $cnt['type'] = 'image';
 * $cnt['image'] ...
 * $cnt['image]['type']
 * $cnt['image]['data']
 * 
 */

/**
 * Dependencies
 * [] ERRORS   - NULL
 * [] DATABASE - NULL
 * [] SESSIONS - NULL
 * [] USERS    - SESSIONS, DATABASE
 */

/**
 * Layout javascript arrows
 * [] content div must have overflow: auto; if javascript is disabled it will scroll normally, else it will not show the scroller
 * [] use javascript to show the arrows only if JS is enabled
 * [] arrows must be before script
 */

/**
 * remember
 * [] default template names: inc/viewer.inc.php L79-84
 * [] set default page: in inc/cnt/index.inc.php $cnt['tpl'], $cnt['tt'] = $lang['TEST'], $cnt['content'] => set to default template/title/content
 * [] /var/tmp must be writable by the web user or group
 * [] template files including smarty will have to have .tpl.php extension
 * [] content:
 * from file: get page
 * from db: get content
 * from module (catalog/news/etc): module/name/action/add
 * [] modules:
 * app_admin ?
 * page_admin ?
 * content_admin
 * catalog_admin
 */

/**
 * STUFF
 * plugin/extension/module:
 *a simple class
 *plugin: add_action(where, what)
 *core: must have add_stuff()
 *
 *[][] in /cnt/{MODULE}.inc.php: appLoadModule({SUB_MODULE_NAME})
 *{ex: one page has menu, other does not}
 *
 *database:
 *http://www.rubyrobot.org/article/mysql-abstraction-class-for-php
 *
 *error handler:
 *http://snippets.dzone.com/posts/show/1617
 *
 *$rs = $db->dbQuery("SELECT cod, descriere FROM tmp_asesoft_prod WHERE producator = 'TOSHIBA'");
 *list($cod, $descriere) = $rs->dbFetchRow();
 */

/**
 * TO DO
 * [] fix _APP_CFG_* dependencies
 */

/**
 * ROAD
 * - documentable
 *- modular (must be able to add/remove/upgrade everything including the core)
 *- keep in mind free servers with many restrictions
 *- focus on security but also on speed and simplicty
 *- use classes
 *- output must be xhtml/css3
 *- easy to install/configure/use
 *- users can create their own skins
 *- users can create their own modules
 *- different versions (lite, blog, shop, gallery, etc)
 *- build on linux, use bash if possible
 *- separate install/upgrade system
 *- parsable config files, must be able to write them from php
 *- user groups - customizable by the client (aer - add/edit/remove)
 *- user levels - standard
 *- separate programming from design
 *- user can add content: html only or html + php
 *- classes: db, file uploads, authentication, templates
 *- rss news
 *- skins: previewable, separate logo
 *- robots.txt
 *- sitemap
 *- faq
 *- skin: page layout includes complete html(<html>...</html>) not only <body> content
 *- content: type: page: standard,backend user section / link: shortcut,mountpoint,external url
 * / special: sysfolder,recycler,visual menu separator
 *- help tips all over the place: little icons -> small divs -> link to full help
 *- page: could be text, table, etc only one, or combined
 */
?>