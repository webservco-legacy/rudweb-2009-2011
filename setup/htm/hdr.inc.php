<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>No description
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @access     public
 * @package    RudWEb-1.0
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
 *
./setup/htm/hdr.inc.php
12:50 2008-04-05
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<META HTTP-EQUIV="content-language" CONTENT="en">
<LINK REL="icon" TYPE="image/ico" HREF="./favicon.ico">
<LINK REL="shortcut icon" TYPE="image/ico" HREF="./favicon.ico">
<TITLE><?php echo _RUDWEB_NAME;?></TITLE>
<META NAME="distribution" CONTENT="Local">
<META NAME="robots" CONTENT="NOINDEX, NOFOLLOW">
<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
<STYLE type="text/css">
A:link        {text-decoration: none;color: #333333;}
A:visited     {text-decoration: none;color: #333333;}
A:hover       {text-decoration: none;color: #333333;}
.hdr          {background-color: #BBBBBB;}
.ttt          {background-color: #CCCCCC;}
.cnt          {background-color: #DDDDDD;}
.total        {background-color: #EEEEEE;}
.proj         {background-color: #EEEEEE; border-style: dotted; border-color: #000000; border-top-width: 1px; border-bottom-width: 0px; border-left-width: 0px; border-right-width: 0px;}
.projht       {background-color: #DDDDDD; border-style: dotted; border-color: #000000; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-width: 0px;}
.projhb       {background-color: #DDDDDD; border-style: dotted; border-color: #000000; border-top-width: 1px; border-bottom-width: 0px; border-left-width: 0px; border-right-width: 0px;}
.general      {background-color: #EEEEEE; color: #333333; text-align: left; text-decoration: none; font-family: verdana, arial, helvetica, sans-serif; font-weight: normal; font-size: 10px; border-style: dotted; border-color: #000000; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-width: 0px;}
.rudweb         {color: #333333; text-align: left; text-decoration: none; font-family: verdana, arial, helvetica, sans-serif; font-weight: bold; font-size: 11px;}
.link:link    {color: #777777; text-align: left; text-decoration: none; font-family: verdana, arial, helvetica, sans-serif; font-weight: bold; font-size: 10px;}
.link:visited {color: #777777; text-align: left; text-decoration: none; font-family: verdana, arial, helvetica, sans-serif; font-weight: bold; font-size: 10px;}
.link:hover   {color: #BBBBBB; text-align: left; text-decoration: none; font-family: verdana, arial, helvetica, sans-serif; font-weight: bold; font-size: 10px;}
.act          {color: #000000; text-align: right; text-decoration: none; font-family: verdana, arial, helvetica, sans-serif; font-weight: normal; font-size: 10px; border-style: dotted; border-color: #000000; border-top-width: 0px; border-bottom-width: 1px; border-left-width: 0px; border-right-width: 0px;}
.nam          {color: #000000; text-align: left; text-decoration: none; font-family: verdana, arial, helvetica, sans-serif; font-weight: bold; font-size: 10px; border-style: dotted; border-color: #000000; border-top-width: 0px; border-bottom-width: 1px; border-left-width: 0px; border-right-width: 0px;}
.msg          {color: #000000; text-align: center; text-decoration: none; font-family: verdana, arial, helvetica, sans-serif; font-style: italic; font-size: 10px; border-style: dotted; border-color: #000000; border-top-width: 0px; border-bottom-width: 1px; border-left-width: 0px; border-right-width: 0px;}
.rst          {color: #AAAAAA; text-align: left; text-decoration: none; font-family: verdana, arial, helvetica, sans-serif; font-weight: bold; font-size: 10px; border-style: dotted; border-color: #000000; border-top-width: 0px; border-bottom-width: 1px; border-left-width: 0px; border-right-width: 0px;}
.rst_ok       {color: #009900; text-align: left; text-decoration: none; font-family: verdana, arial, helvetica, sans-serif; font-weight: bold; font-size: 10px; border-style: dotted; border-color: #000000; border-top-width: 0px; border-bottom-width: 1px; border-left-width: 0px; border-right-width: 0px;}
.rst_err      {color: #990000; text-align: left; text-decoration: none; font-family: verdana, arial, helvetica, sans-serif; font-weight: bold; font-size: 10px; border-style: dotted; border-color: #000000; border-top-width: 0px; border-bottom-width: 1px; border-left-width: 0px; border-right-width: 0px;}

.button {
  width: 70px;
  height: 16px;
  color: #333333;
  margin-top: 0px; margin-bottom: 0px; margin-left: 0px; margin-right: 0px;
  text-align: center; vertical-align: middle; text-decoration: none;
  font-family: verdana; font-weight: normal; font-size: 10px;
  border-color: #333333; border-style: solid; border-top-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-right-width: 1px; 
  padding-top: 0px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; cursor: pointer;
}

</STYLE>
</HEAD>
<BODY CLASS="general">