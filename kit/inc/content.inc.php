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
./inc/content.inc.php
11:09 2008-07-01
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}
      // CONTENT
      echo $rudweb_skin['cnt']['hdr'];
      echo $rudweb_skin['cnt']['pre'];
      
      // PICTURES 1
      if (_RUDWEB_CFG_PICS_1 === "1") {
        echo $rudweb_skin['cnt']['pic']['hdr']['1'];
        $query_pic1 = "SELECT * FROM `"._RUDWEB_PRE."ws_pic` WHERE `cnt_id` = '".$this_content_id."' AND (`pic_loc` = '1' AND `pic_dis` = '0') ORDER BY `pic_ord` ASC";
        $rst_query_pic1 = mysql_query($query_pic1) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $total_pic1 = mysql_num_rows($rst_query_pic1);
        if ($total_pic1 != '0') {
          for ($pic1i=1; $pic1i<=$total_pic1; $pic1i++) {
            $row_rst_pic1 = mysql_fetch_assoc($rst_query_pic1);
            $pictureFile1[$pic1i]    = _RUDWEB_PIC_DIR . $row_rst_pic1['pic_fn'];
            $pictureFile1url[$pic1i] = _RUDWEB_PIC_URL . $row_rst_pic1['pic_fn'];
            $pictureFile1TT[$pic1i] = $row_rst_pic1['pic_tt'];
            //$fileSize1[$pic1i] = round(filesize($pictureFile1[$pic1i]) / 1024,2);
            //list($pic1_width[$pic1i], $pic1_height[$pic1i], $pic1_type[$pic1i], $pic1_attr[$pic1i]) = getimagesize($pictureFile1[$pic1i]);
            $pic1_imgsrcT[$pic1i] = "<IMG CLASS=\"op\" SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile1[$pic1i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['1']."\" TITLE=\"".$pictureFile1TT[$pic1i]."\" ALT=\"".$pictureFile1TT[$pic1i]."\" onMouseOver=\"bevisible(this,0)\" onMouseOut=\"bevisible(this,1)\">";
            $pic1_imgsrc[$pic1i] = "<IMG SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile1[$pic1i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['1']."\" TITLE=\"".$pictureFile1TT[$pic1i]."\" ALT=\"".$pictureFile1TT[$pic1i]."\">";
            echo $rudweb_skin['cnt']['pic']['pre']['1'];
            if ($row_rst_pic1['pic_tmb'] === '1') {
              echo "<A CLASS=\"default\" rel=\"lightbox[".$row_rst_pic1['pic_loc']."]\" HREF=\"" . $pictureFile1url[$pic1i] . "\" TITLE=\"".$pictureFile1TT[$pic1i]."\">";
              echo $pic1_imgsrcT[$pic1i];
              echo "</A>";
            }
            else {
              echo $pic1_imgsrc[$pic1i];
            }
            echo $rudweb_skin['cnt']['pic']['suf']['1'];
            if ($pic1i !== $total_pic1) { echo $rudweb_skin['cnt']['pic']['sep']['1'];}
          }
        }
        echo $rudweb_skin['cnt']['pic']['ftr']['1'];
      }
      
      // TITLE
      
      if($blog_content == "1") {
        restrictedLocalLink("title", $row_rst_content['cnt_tt'], _RUDWEB_INDEX_PHP . "content/" . $row_rst_content['cnt_alias'], $_SESSION[_RUDWEB_PRE.'usr_level'], $row_rst_content['cnt_lvl'], $row_rst_content['cnt_tt'], $rudweb_ln['WinStatOut'], "_self");
      }
      else {
        echo $rudweb_skin['cnt']['tt1']['pre'];
        echo $row_rst_content['cnt_tt'];
        echo $rudweb_skin['cnt']['tt1']['suf'];
      }
      
      
      // PICTURES 2
      if (_RUDWEB_CFG_PICS_2 === "1") {
        echo $rudweb_skin['cnt']['pic']['hdr']['2'];
        $query_pic2 = "SELECT * FROM `"._RUDWEB_PRE."ws_pic` WHERE `cnt_id` = '".$this_content_id."' AND (`pic_loc` = '2' AND `pic_dis` = '0') ORDER BY `pic_ord` ASC";
        $rst_query_pic2 = mysql_query($query_pic2) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $total_pic2 = mysql_num_rows($rst_query_pic2);
        if ($total_pic2 != '0') {
          for ($pic2i=1; $pic2i<=$total_pic2; $pic2i++) {
            $row_rst_pic2 = mysql_fetch_assoc($rst_query_pic2);
            $pictureFile2[$pic2i]    = _RUDWEB_PIC_DIR . $row_rst_pic2['pic_fn'];
            $pictureFile2url[$pic2i] = _RUDWEB_PIC_URL . $row_rst_pic2['pic_fn'];
            $pictureFile2TT[$pic2i] = $row_rst_pic2['pic_tt'];
            //$fileSize2[$pic2i] = round(filesize($pictureFile2[$pic2i]) / 1024,2);
            //list($pic2_width[$pic2i], $pic2_height[$pic2i], $pic2_type[$pic2i], $pic2_attr[$pic2i]) = getimagesize($pictureFile2[$pic2i]);
            $pic2_imgsrcT[$pic2i] = "<IMG CLASS=\"op\" SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile2[$pic2i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['2']."\" TITLE=\"".$pictureFile2TT[$pic2i]."\" ALT=\"".$pictureFile2TT[$pic2i]."\" onMouseOver=\"bevisible(this,0)\" onMouseOut=\"bevisible(this,1)\">";
            $pic2_imgsrc[$pic2i] = "<IMG SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile2[$pic2i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['2']."\" TITLE=\"".$pictureFile2TT[$pic2i]."\" ALT=\"".$pictureFile2TT[$pic2i]."\">";
            echo $rudweb_skin['cnt']['pic']['pre']['2'];
            if ($row_rst_pic2['pic_tmb'] === '1') {
              echo "<A CLASS=\"default\" rel=\"lightbox[".$row_rst_pic2['pic_loc']."]\" HREF=\"" . $pictureFile2url[$pic2i] . "\" TITLE=\"".$pictureFile2TT[$pic2i]."\">";
              echo $pic2_imgsrcT[$pic2i];
              echo "</A>";
            }
            else {
              echo $pic2_imgsrc[$pic2i];
            }
            echo $rudweb_skin['cnt']['pic']['suf']['2'];
            if ($pic2i !== $total_pic2) { echo $rudweb_skin['cnt']['pic']['sep']['2'];}
          }
        }
        echo $rudweb_skin['cnt']['pic']['ftr']['2'];
      }
      
      // SUBTITLE
      if (trim($row_rst_content['cnt_stt']) !== '') {
        echo $rudweb_skin['cnt']['tt2']['pre'];
        echo $row_rst_content['cnt_stt'];
        echo $rudweb_skin['cnt']['tt2']['suf'];
      }
      
      // PICTURES 3
      if (_RUDWEB_CFG_PICS_3 === "1") {
        echo $rudweb_skin['cnt']['pic']['hdr']['3'];
        $query_pic3 = "SELECT * FROM `"._RUDWEB_PRE."ws_pic` WHERE `cnt_id` = '".$this_content_id."' AND (`pic_loc` = '3' AND `pic_dis` = '0') ORDER BY `pic_ord` ASC";
        $rst_query_pic3 = mysql_query($query_pic3) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $total_pic3 = mysql_num_rows($rst_query_pic3);
        if ($total_pic3 != '0') {
          for ($pic3i=1; $pic3i<=$total_pic3; $pic3i++) {
            $row_rst_pic3 = mysql_fetch_assoc($rst_query_pic3);
            $pictureFile3[$pic3i]    = _RUDWEB_PIC_DIR . $row_rst_pic3['pic_fn'];
            $pictureFile3url[$pic3i] = _RUDWEB_PIC_URL . $row_rst_pic3['pic_fn'];
            $pictureFile3TT[$pic3i] = $row_rst_pic3['pic_tt'];
            //$fileSize3[$pic3i] = round(filesize($pictureFile3[$pic3i]) / 1024,2);
            //list($pic3_width[$pic3i], $pic3_height[$pic3i], $pic3_type[$pic3i], $pic3_attr[$pic3i]) = getimagesize($pictureFile3[$pic3i]);
            $pic3_imgsrcT[$pic3i] = "<IMG CLASS=\"op\" SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile3[$pic3i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['3']."\" TITLE=\"".$pictureFile3TT[$pic3i]."\" ALT=\"".$pictureFile3TT[$pic3i]."\" onMouseOver=\"bevisible(this,0)\" onMouseOut=\"bevisible(this,1)\">";
            $pic3_imgsrc[$pic3i] = "<IMG SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile3[$pic3i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['3']."\" TITLE=\"".$pictureFile3TT[$pic3i]."\" ALT=\"".$pictureFile3TT[$pic3i]."\">";
            echo $rudweb_skin['cnt']['pic']['pre']['3'];
            if ($row_rst_pic3['pic_tmb'] === '1') {
              echo "<A CLASS=\"default\" rel=\"lightbox[".$row_rst_pic3['pic_loc']."]\" HREF=\"" . $pictureFile3url[$pic3i] . "\" TITLE=\"".$pictureFile3TT[$pic3i]."\">";
              echo $pic3_imgsrcT[$pic3i];
              echo "</A>";
            }
            else {
              echo $pic3_imgsrc[$pic3i];
            }
            echo $rudweb_skin['cnt']['pic']['suf']['3'];
            if ($pic3i !== $total_pic3) { echo $rudweb_skin['cnt']['pic']['sep']['3'];}
          }
        }
        echo $rudweb_skin['cnt']['pic']['ftr']['3'];
      }

      // CONTENT TEXT
      echo $rudweb_skin['cnt']['txt']['pre'];
      // solution from http://www.zimmertech.com/tutorials/php/51/evaluate-php-code-from-mysql.php
      // not very safe, though
      /* eval("?>\n" . $row_rst_content['cnt_txt'] . "<?php "); */
      echo $row_rst_content['cnt_txt'];
      echo $rudweb_skin['cnt']['txt']['suf'];
      
      // PICTURES 4
      if (_RUDWEB_CFG_PICS_4 === "1") {
        echo $rudweb_skin['cnt']['pic']['hdr']['4'];
        $query_pic4 = "SELECT * FROM `"._RUDWEB_PRE."ws_pic` WHERE `cnt_id` = '".$this_content_id."' AND (`pic_loc` = '4' AND `pic_dis` = '0') ORDER BY `pic_ord` ASC";
        $rst_query_pic4 = mysql_query($query_pic4) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $total_pic4 = mysql_num_rows($rst_query_pic4);
        if ($total_pic4 != '0') {
          for ($pic4i=1; $pic4i<=$total_pic4; $pic4i++) {
            $row_rst_pic4 = mysql_fetch_assoc($rst_query_pic4);
            $pictureFile4[$pic4i]    = _RUDWEB_PIC_DIR . $row_rst_pic4['pic_fn'];
            $pictureFile4url[$pic4i] = _RUDWEB_PIC_URL . $row_rst_pic4['pic_fn'];
            $pictureFile4TT[$pic4i] = $row_rst_pic4['pic_tt'];
            //$fileSize4[$pic4i] = round(filesize($pictureFile4[$pic4i]) / 1024,2);
            //list($pic4_width[$pic4i], $pic4_height[$pic4i], $pic4_type[$pic4i], $pic4_attr[$pic4i]) = getimagesize($pictureFile4[$pic4i]);
            $pic4_imgsrcT[$pic4i] = "<IMG CLASS=\"op\" SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile4[$pic4i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['4']."\" TITLE=\"".$pictureFile4TT[$pic4i]."\" ALT=\"".$pictureFile4TT[$pic4i]."\" onMouseOver=\"bevisible(this,0)\" onMouseOut=\"bevisible(this,1)\">";
            $pic4_imgsrc[$pic4i] = "<IMG SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile4[$pic4i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['4']."\" TITLE=\"".$pictureFile4TT[$pic4i]."\" ALT=\"".$pictureFile4TT[$pic4i]."\">";
            echo $rudweb_skin['cnt']['pic']['pre']['4'];
            if ($row_rst_pic4['pic_tmb'] === '1') {
              //echo "<A CLASS=\"default\" HREF=\"" . $pictureFile4url[$pic4i] . "\" TARGET=\"_blank\">";
              echo "<A CLASS=\"default\" rel=\"lightbox[".$row_rst_pic4['pic_loc']."]\" HREF=\"" . $pictureFile4url[$pic4i] . "\" TITLE=\"".$pictureFile4TT[$pic4i]."\">";
              echo $pic4_imgsrcT[$pic4i];
              echo "</A>";
            }
            else {
              echo $pic4_imgsrc[$pic4i];
            }
            echo $rudweb_skin['cnt']['pic']['suf']['4'];
            if ($pic4i !== $total_pic4) { echo $rudweb_skin['cnt']['pic']['sep']['4'];}
          }
        }
        echo $rudweb_skin['cnt']['pic']['ftr']['4'];
      }
      
      //POSTED BY
            if (_RUDWEB_CFG_CNT_POSTED == 1) {
              $query_cnt = "SELECT cnt_crd, cnt_crt, cnt_cru, cnt_mdd, cnt_mdt, cnt_mdu FROM `"._RUDWEB_PRE."ws_cnt` WHERE `cnt_alias` = '".$rudweb_req_page."' AND (`cnt_ln` = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND `cnt_dis` = '0') LIMIT 1";
              $rst_query_cnt = rudweb_qres($rudweb_dbtype, $query_cnt);
              $total_cnt = rudweb_qtotal($rudweb_dbtype, $rst_query_cnt);
              if ($total_cnt != 0) {
                $row_rst_cnt = rudweb_fetch_assoc($rudweb_dbtype, $rst_query_cnt);
                $qp = "SELECT usr_nick_name FROM "._RUDWEB_PRE."set_usr WHERE usr_id = '".$row_rst_cnt['cnt_cru']."' LIMIT 1";
                $rp = rudweb_qres($rudweb_dbtype, $qp);
                $poster_alias = rudweb_result($rudweb_dbtype, $rp, 0);
                echo $rudweb_skin['blg']['posted']['pre'];
                echo $rudweb_ln['blg']['postedby'] . $poster_alias . $rudweb_ln['blg']['on'] . MyDate($row_rst_cnt['cnt_crd'], 'dd/mm/yyyy') . " " . $row_rst_cnt['cnt_crt'];
                if ($row_rst_cnt['cnt_mdd'] != '0000-00-00') {
                  $qm = "SELECT usr_nick_name FROM "._RUDWEB_PRE."set_usr WHERE usr_id = '".$row_rst_cnt['cnt_mdu']."' LIMIT 1";
                  $rm = rudweb_qres($rudweb_dbtype, $qm);
                  $mod_alias  = rudweb_result($rudweb_dbtype, $rm, 0);
                  echo '. ';
                  echo $rudweb_ln['blg']['lastmod'] . $mod_alias . $rudweb_ln['blg']['on'] . MyDate($row_rst_cnt['cnt_mdd'], 'dd/mm/yyyy') . " " . $row_rst_cnt['cnt_mdt'];
                }
                echo $rudweb_skin['blg']['posted']['suf'];
              }
            }
            
      // TAGS
      showCntTags($rudweb_mnu_id, $rudweb_req_page, $rudweb_cnt_type, $et);
      
      // FILES
      // XXX
      
      // LINKS
      // XXX
      
      echo $rudweb_skin['cnt']['suf'];
      echo $rudweb_skin['cnt']['ftr'];

      // COMMENTS
      // XXX
?>