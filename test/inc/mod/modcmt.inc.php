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
* Comments Module
*
* <I>./inc/mod/modcmt.inc.php</I>
* <BR>Contains Functions to display short and extended content and catalog user comments
* 
* @author Radu Maier <rudisoft@rudisoft.net>
* @copyright Copyright (c) 2007-2008, Radu Maier
* @license http://opensource.org/licenses/gpl-2.0.php
* @version 14:41 2008-04-29
* @access public
* @package RudWEb
* @subpackage Modules
* @since 09:23 2008-04-29
*/

/**
* Authorized access only
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

/**
* Shows short style comments.
*
* Only shows number of comments and links to add or view comments.
* Uses content type and content id.
*/
function showComments($cmt_typ, $cnt_id, $cnt_alias) {
  global $rudweb_dbtype;
  global $rudweb_ln;
  global $rudweb_skin;
  
  echo $rudweb_skin['cmt']['hdr'];
  echo '<B>'.$rudweb_ln['cmt']['cmtt'].'</B>:&#160;';
  
  $qc  = "SELECT c.*, u.usr_nick_name AS user_add, m.usr_nick_name AS user_mod";
  $qc .= " FROM "._RUDWEB_PRE."ws_cmt AS c LEFT JOIN "._RUDWEB_PRE."set_usr AS u on (c.cmt_cru = u.usr_id)";
  $qc .= " LEFT JOIN "._RUDWEB_PRE."set_usr AS m on (c.cmt_mdu = m.usr_id)";
  $qc .= " WHERE cmt_typ = '".$cmt_typ."' AND cnt_id = '".$cnt_id."' AND cmt_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."'";
  $qc .= " ORDER BY cmt_crd DESC, cmt_crt DESC, cmt_mdd DESC, cmt_mdt DESC";
  $rsc = rudweb_qres($rudweb_dbtype, $qc);
  $t_c = rudweb_qtotal($rudweb_dbtype, $rsc);
  
  echo $t_c . ' ' . $rudweb_ln['cmt']['cmt'];
  echo '&#160;';
  if($cmt_typ == 0 ) { restrictedLocalLink('default', $rudweb_ln['cmt']['cmtal'], _RUDWEB_INDEX_PHP . 'content/' . $cnt_alias . '#cmtform', $_SESSION[_RUDWEB_PRE.'usr_level'], 1, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], "_self");}
  else {restrictedLocalLink('default', $rudweb_ln['cmt']['cmtal'], _RUDWEB_INDEX_PHP . "catalog/item/id/" . $cnt_id . '#cmtform', $_SESSION[_RUDWEB_PRE.'usr_level'], 1, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], "_self");}
  echo '&#160;';
  if($cmt_typ == 0 ) { restrictedLocalLink('default', $rudweb_ln['cmt']['cmtvl'], _RUDWEB_INDEX_PHP . "content/" . $cnt_alias . '#cmtview', $_SESSION[_RUDWEB_PRE.'usr_level'], 1, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], "_self");}
  else {restrictedLocalLink('default', $rudweb_ln['cmt']['cmtvl'], _RUDWEB_INDEX_PHP . "catalog/item/id/" . $cnt_id . '#cmtview', $_SESSION[_RUDWEB_PRE.'usr_level'], 1, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], "_self");}
  echo $rudweb_skin['cmt']['ftr'];
}
/**
* Shows extended comments, includung the form to add a new comment.
*
* Uses content type and content id.
*/
function showExtComments($cmt_typ, $cnt_id, $cnt_alias) {
  global $rudweb_dbtype;
  global $rudweb_ln;
  global $rudweb_skin;
  
  echo $rudweb_skin['cmt']['hdr'];
  echo '<B>'.$rudweb_ln['cmt']['cmtt'].'</B>:<A NAME="cmtview">&#160;</A>';

  $qc  = "SELECT c.*, u.usr_nick_name AS user_add, m.usr_nick_name AS user_mod";
  $qc .= " FROM "._RUDWEB_PRE."ws_cmt AS c LEFT JOIN "._RUDWEB_PRE."set_usr AS u on (c.cmt_cru = u.usr_id)";
  $qc .= " LEFT JOIN "._RUDWEB_PRE."set_usr AS m on (c.cmt_mdu = m.usr_id)";
  $qc .= " WHERE cmt_typ = '".$cmt_typ."' AND cnt_id = '".$cnt_id."' AND cmt_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."'";
  $qc .= " ORDER BY cmt_crd DESC, cmt_crt DESC, cmt_mdd DESC, cmt_mdt DESC";
  $rsc = rudweb_qres($rudweb_dbtype, $qc);
  $t_c = rudweb_qtotal($rudweb_dbtype, $rsc);
  
  echo $t_c . ' ' . $rudweb_ln['cmt']['cmt'];
  echo '&#160;';
  if($cmt_typ == 0 ) { restrictedLocalLink('default', $rudweb_ln['cmt']['cmtal'], _RUDWEB_INDEX_PHP . "content/" . $cnt_alias . '#cmtform', $_SESSION[_RUDWEB_PRE.'usr_level'], 1, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], "_self");}
  else {restrictedLocalLink('default', $rudweb_ln['cmt']['cmtal'], _RUDWEB_INDEX_PHP . "catalog/item/id/" . $cnt_id . '#cmtform', $_SESSION[_RUDWEB_PRE.'usr_level'], 1, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], "_self");}
  echo '&#160;';
  if($cmt_typ == 0 ) { restrictedLocalLink('default', $rudweb_ln['cmt']['cmtvl'], _RUDWEB_INDEX_PHP . "content/" . $cnt_alias . '#cmtview', $_SESSION[_RUDWEB_PRE.'usr_level'], 1, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], "_self");}
  else {restrictedLocalLink('default', $rudweb_ln['cmt']['cmtvl'], _RUDWEB_INDEX_PHP . "catalog/item/id/" . $cnt_id . '#cmtview', $_SESSION[_RUDWEB_PRE.'usr_level'], 1, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], "_self");}  

  if($_SESSION[_RUDWEB_PRE.'usr_level'] >= 1) {
    echo $rudweb_skin['cmt']['pre'];
    echo '<A NAME="cmtform">';
    echo $rudweb_ln['cmt']['cmtal'];
    echo '</A>';
    echo ':<BR>';
    genCmtForm(0,$cmt_typ,$cnt_id,'');
    echo $rudweb_skin['cmt']['suf'];
    echo $rudweb_skin['cmt']['sep'];
  }
  
  if($t_c != 0 ) {
    for($i=1;$i<=$t_c;$i++) {
      $rc = rudweb_fetch_assoc($rudweb_dbtype, $rsc);
      echo $rudweb_skin['cmt']['pre'];
      if($rc['cmt_cru'] == $_SESSION[_RUDWEB_PRE.'usr_id'] || $_SESSION[_RUDWEB_PRE.'usr_level'] >= 3) {
        genCmtForm($rc['cmt_id'],$rc['cmt_typ'],$rc['cnt_id'],$rc['cmt_txt']);
      }
      else {
        echo $rudweb_skin['cmt']['cmtpre'];
        echo $rc['cmt_txt'];
        echo $rudweb_skin['cmt']['cmtsuf'];
      }
      echo $rudweb_skin['cmt']['cmtppre'];
      echo $rudweb_ln['blg']['postedby'] . $rc['user_add'] . $rudweb_ln['blg']['on'] . MyDate($rc['cmt_crd'], 'dd/mm/yyyy') . ' ' . $rc['cmt_crt'];
      if($rc['user_mod'] != NULL) {
        echo '. ';
        echo $rudweb_ln['blg']['lastmod'] . $rc['user_mod'] . $rudweb_ln['blg']['on'] . MyDate($rc['cmt_mdd'], 'dd/mm/yyyy') . ' ' . $rc['cmt_mdt'];
      }
      echo $rudweb_skin['cmt']['cmtpsuf'];
      echo $rudweb_skin['cmt']['suf'];
      if($i != $t_c) {echo $rudweb_skin['cmt']['sep'];}
    }
  }
  
  echo $rudweb_skin['cmt']['ftr'];
}
/**
* Display comments form .
*
* The form used to add, modify or delete comments.
*/
function genCmtForm($cmt_id,$cmt_typ,$cnt_id,$cmt_txt) {
  global $rudweb_ln;
  global $rudweb_skin;
  
  echo '<FORM ENCTYPE="multipart/form-data" NAME="cmtform" ACTION="" METHOD="post">';
  echo $rudweb_skin['cmt']['cmtpre'];
  echo '<INPUT TYPE="hidden" NAME="cmt_id" VALUE="'.$cmt_id.'">';
  echo '<INPUT TYPE="hidden" NAME="cmt_typ" VALUE="'.$cmt_typ.'">';
  echo '<INPUT TYPE="hidden" NAME="cnt_id" VALUE="'.$cnt_id.'">';
  echo '<TEXTAREA CLASS="forminput" NAME="cmt_txt" COLS="40" ROWS="3" onKeyDown="limitText(this.form.cmt_txt,this.form.cmt_txt_cnt,255);" onKeyUp="limitText(this.form.cmt_txt,this.form.cmt_txt_cnt,255);" onChange="limitText(this.form.cmt_txt,this.form.cmt_txt_cnt,255);">';
  echo $cmt_txt;
  echo '</TEXTAREA>';
  echo '<BR>';
  echo '<INPUT CLASS="forminput" TYPE="text" NAME="cmt_txt_cnt" SIZE="3" MAXLENGTH="3" VALUE="255">';
  echo '&#160;' . $rudweb_ln['adm']['chl'];
  if($cmt_id != 0) {
    echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="cmtmod" VALUE="'.$rudweb_ln['adm']['mod'].'">';
    echo '&#160;';
    echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="cmtdel" VALUE="'.$rudweb_ln['adm']['del'].'">';
  }
  else {
    echo '<INPUT CLASS="formsubmit" TYPE="submit" NAME="cmtadd" VALUE="' .$rudweb_ln['adm']['add'].'">';
  }
  echo $rudweb_skin['cmt']['cmtsuf'];
  echo '</FORM>';
}
?>