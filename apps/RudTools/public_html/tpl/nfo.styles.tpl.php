<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>nfo.styles.tpl.php
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-04-08 20:02:00
 * @access     public
 * @package    rwOut
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
?>
<style type="text/css">
html,body,table,form {
    font-size: 11px;
    font-family: Verdana;
    background: #EEE;
    color: #333;
    margin: 0;
}

a {
    color: #333;
    text-decoration: none;
}

#nfo {
    width: 982px;
    margin: 0 auto;
    padding: 0 0 10px 0;
}

#nfo .box {
    float: left;
    display: inline;
    width: 972px;
    background: #DDD;
    border: 1px dashed #333;
    margin: 10px 0 0 0;
    padding: 10px 0 10px 10px;
}

#nfo h1.rud {
    float: left;
    display: inline;
    width: 982px;
    text-align: center;
    padding: 10px 0 10px 0;
    font-size: 1.4em;
}

#nfo h2.rud {
    float: left;
    display: inline;
    width: 982px;
    background: #CCC;
    text-align: center;
    padding: 10px 0 10px 0;
    margin: 10px 0 0 0;
    font-size: 1.3em;
}

#nfo h3.rud {
    float: left;
    display: inline;
    width: 972px;
    padding: 10px 0px 10px 0px;
    margin: 0;
    font-size: 1.2em;
}

#nfo #php_info,#nfo #php_nfo,#nfo #php_ext,#nfo #php_ini,#nfo #server_nfo,#nfo #server_info,#nfo #server_modules
    {
    float: left;
    display: inline;
    width: 972px;
}

#nfo table {
    float: left;
    display: inline;
    width: auto;
    border-collapse: collapse;
    border-top: 1px solid #AAA;
    border-right: 1px solid #AAA;
    border-bottom: 1px solid #AAA;
}

#nfo table tr {
    float: left;
    display: inline;
    width: auto;
    clear: both;
    background: #CCC;
}

#nfo table th {
    float: left;
    display: inline;
    width: auto;
    height: 30px;
    padding: 3px;
    border-left: 1px solid #AAA;
    text-transform: uppercase;
}

#nfo table td {
    float: left;
    display: inline;
    width: auto;
    min-height: 30px;
    border-top: 1px solid #AAA;
    border-left: 1px solid #AAA;
    padding: 3px;
    text-wrap: normal;
    word-wrap: break-word;
    white-space: normal;
}

#nfo .key {
    background: #CCC;
    text-align: right;
    font-weight: bold;
    width: 250px;
}

#nfo .value {
    background: #DDD;
    width: 250px;
}

#nfo table .value_small {
    background: #DDD;
    width: 60px;
}

#nfo table th {
    background: #EEE !important;
    text-align: center !important;
    font-size: 1.1em;
}

.nfo {
    border-bottom: 1px dotted #333;
    cursor: help;
}

#php_info {
    background: #DDD;
}

#php_info div,#php_info table,#php_info table tr,#php_info table th,#php_info table td
    {
    float: none;
}

.right {
    float: left;
    display: inline;
    width: 962px;
    text-align: right;
    margin: 10px 0 0;
}

#menu {
    float: left;
    display: inline;
    width: 200px;
    position: fixed;
    top: 10px;
    right: 10px;
    z-index: 1;
    font-size: 10px;
    background: #DDD;
    padding: 0;
    border: 1px dashed #333;
}

#menu .toggle {
    float: left;
    display: inline;
    width: 200px;
    font-size: 11px;
    font-weight: bold;
    margin: 0;
    padding: 5px 0 5px 0;
}

#menu .toggle span {
    float: left;
    display: inline;
    width: 190px;
    margin: 0 0 0 10px;
    padding: 0;
}

#menu div.toggle ul.l1 {
    display: none;
}

#menu div.toggle:hover ul.l1 {
    float: left;
    display: inline;
    width: 190px;
    margin: 0px 0 0 10px;
    padding: 0;
    font-size: 10px;
    font-weight: bold;
}

#menu ul.l1 li.l1 {
    float: left;
    display: inline;
    width: 190px;
    list-style: none;
    margin: 5px 0 0 0;
    margin: 10px 0 0 0;
    text-transform: uppercase;
}

#menu ul.l1 li.l1 a {
    color: #333;
}

#menu ul.l2 {
    float: left;
    display: inline;
    width: 180px;
    margin: 0 0 0 0px;
    padding: 0;
}

#menu ul.l1 li.l2 {
    float: left;
    display: inline;
    width: 180px;
    list-style: none;
    margin: 5px 0 0 0;
    text-transform: none;
}

#menu ul.l1 li.l2 a {
    color: #777;
}
</style>
