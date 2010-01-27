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
./inc/mod/modstats.inc.php
12:50 2008-04-05
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

function doStats() {
  global $rudweb_stats_page;
  $ips = eregi_replace(' ', '', _RUDWEB_CFG_STATS_IP);
  $ips = explode(',', $ips);
  if (_RUDWEB_CFG_STATS_ON === "1") {
    if (count($ips) == 0) {$ips = array();}
    if (isset($_SERVER['REMOTE_ADDR']))     {$stats_ip = $_SERVER['REMOTE_ADDR'];} else {$stats_ip = 'n/a';}
    if (isset($_SERVER['HTTP_USER_AGENT'])) {$stats_browser = $_SERVER['HTTP_USER_AGENT'];} else {$stats_browser = 'n/a';}
    if (isset($_SERVER['REMOTE_HOST']))     {$stats_host = $_SERVER['REMOTE_HOST'];} else {$stats_host = 'n/a';}
    if (isset($_SERVER['HTTP_REFERER']))    {$stats_referer = $_SERVER['HTTP_REFERER'];} else {$stats_referer = 'n/a';}
    if (isset($_SERVER['REQUEST_URI']))     {$stats_requesturi = $_SERVER['REQUEST_URI'];} else {$stats_requesturi = 'n/a';}
    if (!in_array($stats_ip, $ips)) {
      $query_lock = "LOCK TABLES `"._RUDWEB_PRE."var_stats` WRITE";
      mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';

      $query_rstId = "SELECT MAX(`stats_id`) FROM `"._RUDWEB_PRE."var_stats`";
      $rstId=mysql_query($query_rstId) or require _RUDWEB_LIB_DIR . 'myerr.php';
      $stats_id = (mysql_result($rstId, 0)) + 1;
      
      $stats_date = date("Y-m-d");
      $stats_time = date("H:i:s");
      $query = "INSERT INTO `"._RUDWEB_PRE."var_stats` (stats_id, usr_id, usr_lang_index, stats_page, stats_ip, stats_date, stats_time, stats_browser, stats_host, stats_referer, stats_requesturi) VALUES ('".$stats_id."', '".$_SESSION[_RUDWEB_PRE.'usr_id']."', '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."', '".$rudweb_stats_page."', '".$stats_ip."', '".$stats_date."', '".$stats_time."', '".$stats_browser."', '".$stats_host."', '".$stats_referer."', '".$stats_requesturi."')";
      mysql_query($query) or require _RUDWEB_LIB_DIR . 'myerr.php';
  
      $query_unlock = "UNLOCK TABLES";
      mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    }
  }
}
function showStats($diff, $stats) {
// WORK IN PROGRESS
  global $rudweb_ln;
  global $rudweb_skin;
  if (_RUDWEB_CFG_STATS_ON === "1") {
    $diff = $diff * 60;

    $now_date = date("Y-m-d");
    $timeHH  = date("H");
    $timeMM  = date("i");
    $timeSS  = date("s");

    $time_to_sec = (( $timeHH * 60 ) * 60 ) + ( $timeMM * 60 ) + ( $timeSS);
    $time_diff = ( $time_to_sec ) - ( $diff );
    
    echo $rudweb_skin['sts']['hdr'];
  
    switch($stats) {
      case "total": { // TOTAL VISITOS SINCE _RUDWEB_CFG_START
        $query_total  = "SELECT COUNT(`stats_ip`) FROM `"._RUDWEB_PRE."var_stats`";
        $result_total = mysql_query($query_total) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $stats_total  = mysql_result($result_total, 0);
        echo $rudweb_skin['sts']['pre'];
        echo $stats_total . " " . $rudweb_ln['visitors'] . " " . $rudweb_ln['since'] . " " . MyDate(_RUDWEB_CFG_START, 'dd/mm/yyyy');
        echo $rudweb_skin['sts']['suf'];
        echo $rudweb_skin['sts']['sep'];
        break;
      }
      case "unique": { //TOTAL UNIQUE VISITORS
        $query_unique = "SELECT COUNT(DISTINCT `stats_ip`) FROM `"._RUDWEB_PRE."var_stats`";
        $result_unique = mysql_query($query_unique) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $stats_unique = mysql_result($result_unique, 0);
        echo $rudweb_skin['sts']['pre'];
        echo $stats_unique . " " . $rudweb_ln['unique_visitors'] . " " . $rudweb_ln['since'] . " " . MyDate(_RUDWEB_CFG_START, 'dd/mm/yyyy');
        echo $rudweb_skin['sts']['suf'];
        echo $rudweb_skin['sts']['sep'];
        break;
      }
      case "online": { //ONLINE VISITORS - DIFFERENT VISITORS ONLINE IN THE LAST 5 MINUTES
        $query_online  = "SELECT COUNT(DISTINCT `stats_ip`) FROM `"._RUDWEB_PRE."var_stats` WHERE `stats_date` = '$now_date' AND TIME_TO_SEC(`stats_time`) >= '$time_diff'";
        $result_online = mysql_query($query_online) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $stats_online  = mysql_result($result_online, 0);
        echo $rudweb_skin['sts']['pre'];
        echo $stats_online . " " . $rudweb_ln['online_visitors'];
        echo $rudweb_skin['sts']['suf'];
        echo $rudweb_skin['sts']['sep'];
        break;
      }
      case "index": { // TOTAL UNIQUE VISITORS TO THE MAIN PAGE
        break;
      }
      case "today": { // TOTAL UNIQUE VISITORS TODAY
        break;
      }
      default: {break;}
    }
    
    echo $rudweb_skin['sts']['ftr'];
  }
}
?>