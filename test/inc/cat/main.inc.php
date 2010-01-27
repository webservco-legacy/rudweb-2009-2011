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
./inc/cat/main.inc.php
18:53 2008-04-07
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

$query_cat  = "SELECT cat_id, cat_tt, cat_pic, cat_dsc FROM ". _RUDWEB_PRE. "cat_cat WHERE cat_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND cat_lev = '0'";
$result_cat = rudweb_qres($rudweb_dbtype, $query_cat);
$total_cat  = rudweb_qtotal($rudweb_dbtype, $result_cat);

echo $rudweb_skin['catalog']['hdr'];

echo $rudweb_skin['cnt']['tt1']['pre'];
echo $rudweb_ln['catalog']['catalog'] . ': ' . $rudweb_ln['catalog']['cattt'];
echo $rudweb_skin['cnt']['tt1']['suf'];

catYah(0,0,0);

echo $rudweb_skin['cat']['hdr'];

if ($total_cat != '0') {
  
  for($i=1;$i<=$total_cat;$i++) {
    $cat_row = rudweb_fetch_assoc($rudweb_dbtype, $result_cat);

    echo $rudweb_skin['cat']['pre'];
    
    echo $rudweb_skin['cat']['pc']['pre'];
    echo '<A CLASS="default" HREF="'._RUDWEB_SITE_URL . _RUDWEB_INDEX_PHP . 'catalog/items/cat/'.$cat_row['cat_id'].'" TITLE="'.$cat_row['cat_tt'].'" TARGET="_self">';
    
    if(is_file(_RUDWEB_CATP_DIR.$cat_row['cat_pic'])) {
      $pic_src = _RUDWEB_LIB_URL.'pic.php?imgfile='._RUDWEB_CATP_DIR.$cat_row['cat_pic'].'&amp;max_size='.$rudweb_skin['cat']['pic'].'&amp;max_size='.$rudweb_skin['cat']['pic'];
    }
    else {
      $pic_src = _RUDWEB_LIB_URL.'pic.php?imgfile='._RUDWEB_SKIN_DIR . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'].'/graphics/nopic.png'.'&amp;max_size='.$rudweb_skin['cat']['pic'];
    }
    
    echo '<IMG CLASS="op" SRC="'.$pic_src.'" TITLE="'.$cat_row['cat_tt'].'" ALT="'.$cat_row['cat_tt'].'" onMouseOver="bevisible(this,0)" onMouseOut="bevisible(this,1)">';
    echo '</A>';
    echo $rudweb_skin['cat']['pc']['suf'];
    
    echo $rudweb_skin['cat']['tt']['pre'];
    restrictedLocalLink('categ', $cat_row['cat_tt'], _RUDWEB_INDEX_PHP . 'catalog/items/cat/'.$cat_row['cat_id'], $_SESSION[_RUDWEB_PRE.'usr_level'], 0, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], '_self');
    echo $rudweb_skin['cat']['tt']['suf'];
    
    echo $rudweb_skin['cat']['dsc']['pre'];
    echo $cat_row['cat_dsc'];
    echo $rudweb_skin['cat']['dsc']['suf'];
    
    echo $rudweb_skin['cat']['suf'];

    if($i != $total_cat) {echo $rudweb_skin['cat']['sep'];}
  }
}
else {echo '<BR>' . $rudweb_ln['cat']['noitems'];}

echo $rudweb_skin['cat']['ftr'];

echo $rudweb_skin['catalog']['ftr'];
?>