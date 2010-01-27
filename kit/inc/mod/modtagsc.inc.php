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
* Tags Module
*
* <I>./inc/mod/modtagsc.inc.php</I>
* <BR>Contains Tag Related Functions For Content
* 
* @author Radu Maier <rudisoft@rudisoft.net>
* @copyright Copyright (c) 2007-2008, Radu Maier
* @license http://opensource.org/licenses/gpl-2.0.php
* @version 13:04 2008-04-26
* @access public
* @package RudWEb
* @subpackage Modules
* @since 15:59 2008-04-25
* @todo Also include the Blog Tags Settings
* @todo Administration
*/

/**
* Authorized access only
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

/**
* Shows all tags for a specified content
*
* Uses menu id, required page, content type, existing tags, blog content
*/
function showCntTags($rudweb_mnu_id, $rudweb_req_page, $rudweb_cnt_type, $et, $blog_content = "0") {
  global $rudweb_ln;
  global $rudweb_skin;
  $te = count($et);
  if ($te != 0) {
    echo $rudweb_skin['tagsc']['hdr'];
    echo '<B>'.$rudweb_ln['cnt']['tags'].'</B>:&#160;';
    for($i=1;$i<=$te;$i++) {
      echo $rudweb_skin['tagsc']['pre'];
      restrictedLocalLink('default', $et[$i], _RUDWEB_INDEX_PHP . 'show/tags/tag/'.$et[$i], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      echo $rudweb_skin['tagsc']['suf'];
      if ($i != $te) {echo ', ';}
    }
    echo $rudweb_skin['tagsc']['ftr'];
  }
}
/**
* Shows all content (blog style) matching a given tag
*
* Uses tag name
*/
function showTagsContent($tag_name) {
  global $rudweb_dbtype;
  global $rudweb_ln;
  global $rudweb_skin;
  
  $qc = "SELECT DISTINCT r.cnt_id as cnt_id, m.mnu_id AS mnu_id, c.cnt_alias AS cnt_alias, m.mnu_typ AS mnu_typ,";
  $qc .= " c.cnt_crd AS cnt_crd, c.cnt_crt AS cnt_crt, c.cnt_cru AS cnt_cru, c.cnt_mdd AS cnt_mdd, c.cnt_mdt AS cnt_mdt, c.cnt_mdu AS cnt_mdu";
  $qc .= " FROM "._RUDWEB_PRE."ws_rel As r ";
  $qc .= " LEFT JOIN "._RUDWEB_PRE."ws_tags as t ON (r.tag_id = t.tag_id)";
  $qc .= " LEFT JOIN "._RUDWEB_PRE."ws_cnt as c ON (r.cnt_id = c.cnt_id)";
  $qc .= " LEFT JOIN "._RUDWEB_PRE."ws_mnu as m ON (c.cnt_alias = m.mnu_cnt_alias)";
  $qc .= " WHERE t.tag_name = '".$tag_name."' AND c.cnt_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."'";
  $qc .= " ORDER BY c.cnt_mdd DESC, c.cnt_mdt DESC, c.cnt_crd DESC, c.cnt_crt DESC";
  $rsc = rudweb_qres($rudweb_dbtype, $qc);
  $t_c  = rudweb_qtotal($rudweb_dbtype, $rsc);
  
  if($t_c != 0) {
    echo $rudweb_skin['blg']['hdr'];
    for($i=1;$i<=$t_c;$i++) {
      $rc = rudweb_fetch_assoc($rudweb_dbtype, $rsc);
      echo $rudweb_skin['blg']['pre'];
      showContent($rc['mnu_id'], $rc['cnt_alias'], $rc['mnu_typ'], 1);
      echo $rudweb_skin['blg']['suf'];
      if ($i !== $t_c) {echo $rudweb_skin['blg']['sep'];}
    }
    echo $rudweb_skin['blg']['ftr'];
  }
}
/**
* Shows all used tags
*
* Also displays the number of content items using each tag
*/
function showAllTags() {
  global $rudweb_dbtype;
  global $rudweb_ln;
  global $rudweb_skin;
  
  $qt  = "SELECT DISTINCT t.tag_id AS tag_id, t.tag_name AS tag_name FROM "._RUDWEB_PRE."ws_rel AS r";
  $qt .= " LEFT JOIN "._RUDWEB_PRE."ws_tags AS t on (r.tag_id = t.tag_id) ORDER BY t.tag_name ASC";
  $rst = rudweb_qres($rudweb_dbtype, $qt);
  $t_t = rudweb_qtotal($rudweb_dbtype, $rst);
  
  if($t_t != 0) {
    echo $rudweb_skin['tagsc']['hdr'];
    echo '<B>'.$rudweb_ln['cnt']['tags'].'</B>:&#160;';
    echo $rudweb_skin['tagsc']['sep'];
    for($i=1;$i<=$t_t;$i++) {
      $rt = rudweb_fetch_assoc($rudweb_dbtype, $rst);
      $qc     = "SELECT COUNT(cnt_id) FROM "._RUDWEB_PRE."ws_rel WHERE tag_id = '".$rt['tag_id']."' LIMIT 1";
      $rc     = rudweb_qres($rudweb_dbtype, $qc);
      $tc[$i] = rudweb_result($rudweb_dbtype, $rc, 0);
      
      echo $rudweb_skin['tagsc']['pre'];
      restrictedLocalLink('default', $rt['tag_name']. ' (' . $tc[$i] . ')', _RUDWEB_INDEX_PHP . 'show/tags/tag/'.$rt['tag_name'], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
      echo $rudweb_skin['tagsc']['suf'];
      if($i != $t_t) {echo $rudweb_skin['tagsc']['sep'];}
    }
    echo $rudweb_skin['tagsc']['ftr'];
  }
}
?>