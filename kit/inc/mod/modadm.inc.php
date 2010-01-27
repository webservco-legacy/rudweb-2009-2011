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
./inc/mod/modadm.inc.php
13:19 2008-07-23
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

function genAdminMod() {
  global $rudweb_skin;
  global $rudweb_ln;
  global $rudweb_login_status;
  
  if(_RUDWEB_CFG_ADM === "1") {
    echo $rudweb_skin['usr']['hdr'];
    
    if (isset($_SESSION[_RUDWEB_PRE.'usr_logged_in'])) {
      echo $rudweb_skin['usr']['pre'];
      echo '<B>'. $_SESSION[_RUDWEB_PRE.'usr_alias'] . '</B>';
      echo ' [' . $_SESSION[_RUDWEB_PRE.'usr_name'] . ']';
      echo $rudweb_skin['usr']['suf'];
      
      echo $rudweb_skin['usr']['sep'];
      
      echo $rudweb_skin['usr']['pre'];
      echo $rudweb_ln['level'] . $_SESSION[_RUDWEB_PRE.'usr_level'];
      echo $rudweb_skin['usr']['suf'];
      
      echo $rudweb_skin['usr']['sep'];
    }
    else {
      echo $rudweb_skin['usr']['pre'];
      echo $rudweb_ln['lgnst'][$rudweb_login_status];
      echo $rudweb_skin['usr']['suf'];
      
      echo $rudweb_skin['usr']['sep'];
    }
    
    echo $rudweb_skin['usr']['pre'];
    if (!isset($_SESSION[_RUDWEB_PRE.'usr_logged_in'])) {
      // FORM
      echo "\n<FORM ENCTYPE=\"multipart/form-data\" NAME=\"" . _RUDWEB_PRE . "login_form\" ACTION=\"\" METHOD=\"post\" STYLE=\"display: inline; margin: 0px; padding: 0px;\">";
      echo $rudweb_skin['usr']['login']['hdr'];

      echo $rudweb_skin['usr']['login']['pre'];
      echo "\n<INPUT TYPE=\"hidden\" NAME=\"" . _RUDWEB_PRE . "token\" VALUE=\"" . $_SESSION[_RUDWEB_PRE.'token'] . "\">";
      echo "\n<INPUT TYPE=\"text\" CLASS=\"logininput\" NAME=\"" . _RUDWEB_PRE . "usr_login\" SIZE=\"15\" MAXLENGTH=\"30\" VALUE=\"email\" onFocus=\"if(this.value=='email')this.value='';\" onBlur=\"if(this.value=='')this.value='email';\">";
      echo $rudweb_skin['usr']['login']['suf'];
      
      echo $rudweb_skin['usr']['login']['sep'];
      
      echo $rudweb_skin['usr']['login']['pre'];
      echo "\n<INPUT TYPE=\"password\" CLASS=\"logininput\" NAME=\"" . _RUDWEB_PRE . "usr_pass\" SIZE=\"15\" MAXLENGTH=\"30\" VALUE=\"pass\" onFocus=\"if(this.value=='pass')this.value='';\" onBlur=\"if(this.value=='')this.value='pass';\">";
      echo $rudweb_skin['usr']['login']['suf'];

      echo $rudweb_skin['usr']['login']['sep'];
      
      echo $rudweb_skin['usr']['login']['pre'];
      echo "<IMG SRC=\""._RUDWEB_LIB_URL."picver.php\" WIDTH=\"70\" HEIGHT=\"20\" ALT=\"verif\" TITLE=\"verif\" ALIGN=\"middle\">";
      echo "=";
      echo "\n<INPUT TYPE=\"text\" CLASS=\"logininput\" NAME=\"" . _RUDWEB_PRE . "usr_verif\" SIZE=\"5\" MAXLENGTH=\"5\" VALUE=\"\">";
      echo $rudweb_skin['usr']['login']['suf'];
      
      echo $rudweb_skin['usr']['login']['sep'];
      
      echo $rudweb_skin['usr']['login']['pre'];
      echo "\n<INPUT TYPE=\"submit\" CLASS=\"loginsubmit\" NAME=\"" . _RUDWEB_PRE . "login\" VALUE=\"Login\">";
      echo $rudweb_skin['usr']['login']['suf'];
      
      echo $rudweb_skin['usr']['login']['ftr'];
      echo "\n</FORM>";
    }
    else {
      // logout link
      echo $rudweb_skin['usr']['login']['hdr'];

      echo $rudweb_skin['usr']['login']['pre'];
      restrictedLocalLink('logout', $rudweb_ln['logout'], 'logout.php', $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      echo $rudweb_skin['usr']['login']['suf'];
      
      echo $rudweb_skin['usr']['login']['ftr'];
    }
    echo $rudweb_skin['usr']['suf'];
    
    echo $rudweb_skin['usr']['ftr'];
  }
}
function adminMenu() {
  global $rudweb_skin;
  global $rudweb_ln;
  global $rudweb_this_content;
  //global $rudweb_login_status;
  
  if ($_SESSION[_RUDWEB_PRE.'usr_level'] >= 3) {
    echo $rudweb_skin['adm']['mnu']['hdr'];

    echo $rudweb_skin['adm']['mnuhd']['pre'];
    restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['adm'], _RUDWEB_INDEX_PHP . 'admin/admin', $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
    echo $rudweb_skin['adm']['mnuhd']['suf'];

    // SEPARATOR
    if ($_SESSION[_RUDWEB_PRE.'usr_level'] >= 5) {
      echo $rudweb_skin['adm']['mnuhd']['pre'];
      echo '<A onClick="JavaScript: toggleLayer(\'l1adm\')">';
      echo $rudweb_ln['adm']['adm'];
      echo '</A>';
      echo $rudweb_skin['adm']['mnuhd']['suf'];
      
      echo '<DIV ID="l1adm">';
        // CONTENT MODULES ADMIN
        echo $rudweb_skin['adm']['mnutt']['pre'];
        echo '<A onClick="JavaScript: toggleLayer(\'l2modcsa\')">';
        echo $rudweb_ln['adm']['modules'] . ' - ' . $rudweb_ln['cnt']['cnt'];
        echo '</A>';
        echo $rudweb_skin['adm']['mnutt']['suf'];
      
        echo '<DIV ID="l2modcsa"';
        $l2modcsa = array('nwsmoda', 'tagmoda', 'cmtmoda', 'conmoda', 'ftrmoda');
        if (!in_array($rudweb_this_content, $l2modcsa)) {echo' CLASS="hidden"';} 
        echo '>';
        
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['nws']['tt'], _RUDWEB_INDEX_PHP . 'admin/nwsmoda', $_SESSION[_RUDWEB_PRE.'usr_level'], 5, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['cnt']['tags'], _RUDWEB_INDEX_PHP . 'admin/tagmoda', $_SESSION[_RUDWEB_PRE.'usr_level'], 5, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['cmt']['cmtt'], _RUDWEB_INDEX_PHP . 'admin/cmtmoda', $_SESSION[_RUDWEB_PRE.'usr_level'], 5, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['featured']['tt'], _RUDWEB_INDEX_PHP . 'admin/ftrmoda', $_SESSION[_RUDWEB_PRE.'usr_level'], 5, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['con']['tt'], _RUDWEB_INDEX_PHP . 'admin/conmoda', $_SESSION[_RUDWEB_PRE.'usr_level'], 5, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];

        echo '</DIV>';
        
        //xxx
        
        // CATALOG MODULES ADMIN
        echo $rudweb_skin['adm']['mnutt']['pre'];
        echo '<A onClick="JavaScript: toggleLayer(\'l2modssa\')">';
        echo $rudweb_ln['adm']['modules'] . ' - ' . $rudweb_ln['catalog']['catalog'];
        echo '</A>';
        echo $rudweb_skin['adm']['mnutt']['suf'];
      
        echo '<DIV ID="l2modssa"';
        $l2modssa = array('catmoda', 'cspmoda');
        if (!in_array($rudweb_this_content, $l2modssa)) {echo' CLASS="hidden"';} 
        echo '>';
        
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['catalog']['catalog'], _RUDWEB_INDEX_PHP . 'admin/catmoda', $_SESSION[_RUDWEB_PRE.'usr_level'], 5, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['catalog']['csp'], _RUDWEB_INDEX_PHP . 'admin/cspmoda', $_SESSION[_RUDWEB_PRE.'usr_level'], 5, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];

        echo '</DIV>';
        
      echo '</DIV>';
    }
    // SEPARATOR
    
    echo $rudweb_skin['adm']['mnuhd']['pre'];
    echo '<A onClick="JavaScript: toggleLayer(\'l1cnt\')">';
    echo $rudweb_ln['cnt']['cnt'];
    echo '</A>';
    echo $rudweb_skin['adm']['mnuhd']['suf'];
    
    echo '<DIV ID="l1cnt">';
      // NEWS SETTINGS
      if(_RUDWEB_CFG_NWS == 1) {
        echo $rudweb_skin['adm']['mnutt']['pre'];
        echo '<A onClick="JavaScript: toggleLayer(\'l2nws\')">';
        echo $rudweb_ln['nws']['tt'];
        echo '</A>';
        echo $rudweb_skin['adm']['mnutt']['suf'];
      
        echo '<DIV ID="l2nws"';
        if ($rudweb_this_content != 'nwsmod') {echo' CLASS="hidden"';} 
        echo '>';
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['settings'], _RUDWEB_INDEX_PHP . 'admin/nwsmod', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['add'], _RUDWEB_INDEX_PHP . 'admin/nwsmod/act/add', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['adm'], _RUDWEB_INDEX_PHP . 'admin/nwsmod/act/view', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        echo '</DIV>';
      }
      // TAGS SETTINGS
      if(_RUDWEB_CFG_CNT_TAGS == 1) {
        echo $rudweb_skin['adm']['mnutt']['pre'];
        echo '<A onClick="JavaScript: toggleLayer(\'l2tag\')">';
        echo $rudweb_ln['cnt']['tags'];
        echo '</A>';
        echo $rudweb_skin['adm']['mnutt']['suf'];
      
        echo '<DIV ID="l2tag"';
        if ($rudweb_this_content != 'tagmod') {echo' CLASS="hidden"';} 
        echo '>';
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['adm'], _RUDWEB_INDEX_PHP . 'admin/tagmod/act/adm', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        echo '</DIV>';
      }
      // COMMENTS SETTINGS
      if(_RUDWEB_CFG_CNT_CMNTS == 1) {
        echo $rudweb_skin['adm']['mnutt']['pre'];
        echo '<A onClick="JavaScript: toggleLayer(\'l2cmt\')">';
        echo $rudweb_ln['cmt']['cmtt'];
        echo '</A>';
        echo $rudweb_skin['adm']['mnutt']['suf'];
      
        echo '<DIV ID="l2cmt"';
        if ($rudweb_this_content != 'cmtmod') {echo' CLASS="hidden"';} 
        echo '>';
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['settings'], _RUDWEB_INDEX_PHP . 'admin/cmtmod', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        echo '</DIV>';
      }
      // FEATURED MODULE SETTINGS
      if(_RUDWEB_CFG_FTR_ON == 1) {
        echo $rudweb_skin['adm']['mnutt']['pre'];
        echo '<A onClick="JavaScript: toggleLayer(\'l2ftr\')">';
        echo $rudweb_ln['featured']['tt'];
        echo '</A>';
        echo $rudweb_skin['adm']['mnutt']['suf'];
      
        echo '<DIV ID="l2ftr"';
        if ($rudweb_this_content != 'ftrmod') {echo' CLASS="hidden"';} 
        echo '>';
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['settings'], _RUDWEB_INDEX_PHP . 'admin/ftrmod', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['add'], _RUDWEB_INDEX_PHP . 'admin/ftrmod/act/add', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['adm'], _RUDWEB_INDEX_PHP . 'admin/ftrmod/act/adm', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        echo '</DIV>';
      }
      // CONTACT SETTINGS
      if(_RUDWEB_CFG_CON == 1) {
        echo $rudweb_skin['adm']['mnutt']['pre'];
        echo '<A onClick="JavaScript: toggleLayer(\'l2con\')">';
        echo $rudweb_ln['con']['tt'];
        echo '</A>';
        echo $rudweb_skin['adm']['mnutt']['suf'];
      
        echo '<DIV ID="l2con"';
        if ($rudweb_this_content != 'conmod') {echo' CLASS="hidden"';} 
        echo '>';
        
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['con']['msgs'], _RUDWEB_INDEX_PHP . 'admin/conmod/view/msgs', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        
        /*
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['settings'], _RUDWEB_INDEX_PHP . 'admin/conmod', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        */
        
        if ($_SESSION[_RUDWEB_PRE.'usr_level'] >= 5) {
          echo $rudweb_skin['adm']['mnu']['pre'];
          echo '&#187;&#160;';
          restrictedLocalLink('adm-mnu', $rudweb_ln['categs'], _RUDWEB_INDEX_PHP . 'admin/conmod/act/cat', $_SESSION[_RUDWEB_PRE.'usr_level'], 5, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
          echo $rudweb_skin['adm']['mnu']['suf'];
          echo $rudweb_skin['adm']['mnu']['sep'];
          
          echo $rudweb_skin['adm']['mnu']['pre'];
          echo '&#187;&#160;';
          restrictedLocalLink('adm-mnu', $rudweb_ln['dets'], _RUDWEB_INDEX_PHP . 'admin/conmod/act/det', $_SESSION[_RUDWEB_PRE.'usr_level'], 5, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
          echo $rudweb_skin['adm']['mnu']['suf'];
          echo $rudweb_skin['adm']['mnu']['sep'];
          
          echo $rudweb_skin['adm']['mnu']['pre'];
          echo '&#187;&#160;';
          restrictedLocalLink('adm-mnu', $rudweb_ln['opts'], _RUDWEB_INDEX_PHP . 'admin/conmod/act/opt', $_SESSION[_RUDWEB_PRE.'usr_level'], 5, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
          echo $rudweb_skin['adm']['mnu']['suf'];
          echo $rudweb_skin['adm']['mnu']['sep'];
        }
        
        echo '</DIV>';
      }
    echo '</DIV>';
    // SEPARATOR
    
    
    if(_RUDWEB_CFG_CAT == 1) {
      echo $rudweb_skin['adm']['mnuhd']['pre'];
      echo '<A onClick="JavaScript: toggleLayer(\'l1ctl\')">';
      echo $rudweb_ln['catalog']['catalog'];
      echo '</A>';
      echo $rudweb_skin['adm']['mnuhd']['suf'];
      
      echo '<DIV ID="l1ctl">';
      
      echo $rudweb_skin['adm']['mnutt']['pre'];
      echo '<A onClick="JavaScript: toggleLayer(\'l2cat\')">';
      echo $rudweb_ln['adm']['settings'];
      echo '</A>';
      echo $rudweb_skin['adm']['mnutt']['suf'];
      
      echo '<DIV ID="l2cat"';
        if ($rudweb_this_content != 'catmod') {
          echo' CLASS="hidden"';
        } 
        echo '>';
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['settings'], _RUDWEB_INDEX_PHP . 'admin/catmod/act/set', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];

      echo '</DIV>';
      echo $rudweb_skin['adm']['mnutt']['pre'];
      echo '<A onClick="JavaScript: toggleLayer(\'l2itm\')">';
      echo $rudweb_ln['catalog']['itemstt'];
      echo '</A>';
      echo $rudweb_skin['adm']['mnutt']['suf'];
        
      echo '<DIV ID="l2itm"';
      if ($rudweb_this_content != 'itemadd') {
          echo' CLASS="hidden"';
        } 
        echo '>';
      echo $rudweb_skin['adm']['mnu']['pre'];
      echo '&#187;&#160;';
      restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['add'], _RUDWEB_INDEX_PHP . 'admin/itemadd', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      echo $rudweb_skin['adm']['mnu']['suf'];
      echo $rudweb_skin['adm']['mnu']['sep'];
        
      echo '</DIV>';
      
      if(_RUDWEB_CFG_CSP_ON == "1") {
        echo $rudweb_skin['adm']['mnutt']['pre'];
        echo '<A onClick="JavaScript: toggleLayer(\'l2csp\')">';
        echo $rudweb_ln['catalog']['csp'];
        echo '</A>';
        echo $rudweb_skin['adm']['mnutt']['suf'];
        
        echo '<DIV ID="l2csp"';
        if ($rudweb_this_content != 'cspmod') {echo' CLASS="hidden"';} 
        echo '>';
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['settings'], _RUDWEB_INDEX_PHP . 'admin/cspmod', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['add'], _RUDWEB_INDEX_PHP . 'admin/cspmod/act/add', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
        echo $rudweb_skin['adm']['mnu']['pre'];
        echo '&#187;&#160;';
        restrictedLocalLink('adm-mnu', $rudweb_ln['adm']['adm'], _RUDWEB_INDEX_PHP . 'admin/cspmod/act/adm', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
        echo $rudweb_skin['adm']['mnu']['suf'];
        echo $rudweb_skin['adm']['mnu']['sep'];
       
        echo '</DIV>';
      }
      echo '</DIV>';
    }
  
    // SEPARATOR
    
    echo $rudweb_skin['adm']['mnu']['ftr'];
  }
}
?>