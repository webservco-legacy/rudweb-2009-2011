<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>header.tpl.php
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-11-09 15:53:00
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
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="content-language" content="<?php echo $_SESSION[_APP_PRE.'_usr']['ln']?>" />
    <link rel="icon" type="image/ico" href="<?php echo $skinURL; ?>images/favicon.ico" />
    <link rel="shortcut icon" type="image/ico" href="<?php echo $skinURL; ?>images/favicon.ico" />
    <title><?php echo $lang['TITLE']; ?></title>
    <meta name="title" content="RudiSoft Web Interface (RudWI)" />
    <meta name="subject" content="RudiSoft Web Interface (RudWI)" />
    <meta name="description" content="RudiSoft Web Interface (RudWI)" />
    <meta name="keywords" content="RudiSoft, RudWEb, RudWI" />
    <meta name="copyright" content="2009 RudiSoft.Net" />
    <meta name="designer" content="Radu Maier" />
    <meta name="publisher" content="Rudisoft.Net" />
    <meta name="author" content="RudiSoft.Net" />
    <meta name="rating" content="General" />
    <meta name="distribution" content="Global" />
    <meta name="robots" content="Index, Follow" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="<?php echo $skinURL; ?>styles/layout.css" />
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="<?php echo $skinURL; ?>styles/menu.css" />
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="<?php echo $skinURL; ?>styles/windows.css" />
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="<?php echo $skinURL; ?>styles/icons.css" />
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="<?php echo $skinURL; ?>styles/intro.css" />
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="<?php echo $skinURL; ?>styles/clickMania.css" />
    <!--[if lte IE 6]>
    <link rel="stylesheet" type="text/css" charset="utf-8" media="screen" href="<?php echo $skinURL; ?>styles/layoutIE.css" />
    <script type="text/javascript" language="JavaScript" src="<?php echo _APP_USR_WWW; ?>scripts/DD_belatedPNG/DD_belatedPNG_0.0.8a-min.js"></script>
    <script type="text/javascript" language="JavaScript">
        DD_belatedPNG.fix('#taskbar, #start, .menu_t, .menu_c, .menu_b, .menu_icon_t, .menu_icon, .menu_arr, .win, .win_top, .win_tt, .win_mid, .win_ct_pre, .win_ct, .win_bot, .win_st_pre, .win_st, .btn_cls, .btn_max, .btn_min, .btn_mov');
    </script>
    <![endif]-->