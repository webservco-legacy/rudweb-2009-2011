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
./inc/rudwebf.inc.php
15:43 2008-07-01
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../lib/404.php';}

/* ********** ********** ********** DATABASE CONNECTIONS ********** ********** ********** */
function dbopen() {
  global $rudweb_dbhost;
  global $rudweb_dbuser;
  global $rudweb_dbpass;
  global $rudweb_dbname;
  $rudweb_dbconn = mysql_connect($rudweb_dbhost, $rudweb_dbuser, $rudweb_dbpass) or require _RUDWEB_LIB_DIR . 'myerr.php';
  mysql_select_db($rudweb_dbname) or require _RUDWEB_LIB_DIR . 'myerr.php';
  return $rudweb_dbconn;
}
function dbclose($rudweb_dbconn) {
  mysql_close($rudweb_dbconn);
}
/* ********** ********** ********** //DATABASE CONNECTIONS ********** ********** ********** */
/* ********** ********** ********** GENERATE HTML HEADER CONTENT ********** ********** ********** */
function genHtmlHeader($rudweb_page_title, $rudweb_page_description, $rudweb_page_keywords) {
  echo "\n<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=" . $_SESSION[_RUDWEB_PRE.'usr_lang_charset'] . "\">";
  echo "\n<META HTTP-EQUIV=\"content-language\" CONTENT=\"".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."\">";
  echo "\n<LINK REL=\"icon\" TYPE=\"image/ico\" HREF=\"" . _RUDWEB_SKIN_URL . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'] . "/favicon.ico\">";
  echo "\n<LINK REL=\"shortcut icon\" TYPE=\"image/ico\" HREF=\"" . _RUDWEB_SKIN_URL . $_SESSION[_RUDWEB_PRE.'usr_skin_dir'] . "/favicon.ico\">";
  echo "\n<TITLE>" . $rudweb_page_title . "</TITLE>";
  echo "\n<META NAME=\"title\" CONTENT=\"" . $rudweb_page_title . "\">";
  echo "\n<META NAME=\"subject\" CONTENT=\"" . $rudweb_page_title . "\">";
  echo "\n<META NAME=\"description\" CONTENT=\"" . $rudweb_page_description . "\">";
  echo "\n<META NAME=\"keywords\" CONTENT=\"" . $rudweb_page_keywords . "\">";
  echo "\n<META NAME=\"copyright\" CONTENT=\"" . _RUDWEB_CFG_COPY . "\">";
  echo "\n<META NAME=\"designer\" CONTENT=\"" . _RUDWEB_CFG_DESIG . "\">";
  echo "\n<META NAME=\"publisher\" CONTENT=\"" . _RUDWEB_CFG_PUBL . "\">";
  echo "\n<META NAME=\"author\" CONTENT=\"" . _RUDWEB_SITE_AUTH . "\">";
  echo "\n<META NAME=\"rating\" CONTENT=\"" . _RUDWEB_CFG_RATNG . "\">";
  echo "\n<META NAME=\"distribution\" CONTENT=\"" . _RUDWEB_CFG_DISTR . "\">";
  echo "\n<META NAME=\"robots\" CONTENT=\"" . _RUDWEB_CFG_ROBOTS . "\">";
  // comment out following 3 lines if working with php sessions
  //echo "\n<META NAME=\"pragma\" CONTENT=\"" . _RUDWEB_CFG_PRAG . "\">";
  //echo "\n<META NAME=\"expires\" CONTENT=\"" . _RUDWEB_CFG_EXP . "\">";
  //echo "\n<META NAME=\"cache-control\" CONTENT=\"" . _RUDWEB_CFG_CACHE . "\">";
  echo "\n<META HTTP-EQUIV=\"Content-Style-Type\" CONTENT=\"text/css\">";
}
/* ********** ********** ********** //GENERATE HTML HEADER CONTENT ********** ********** ********** */
/* ********** ********** ********** FILTER INPUT ********** ********** ********** */
function isEmail($email) { 
  return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
}
function isValidInt($input) { // an integer between 1 and 999
  return(preg_match("/^[1-9]$|^[1-9][0-9]$|^[1-9][0-9][0-9]$/", $input));
}
function rudweb_filter_input($string) {
  // strip whitespaces
  $parsed_string = trim($string);
  
  $unwanted = array('\\', '');
  $parsed_string = str_replace($unwanted, ' ', $parsed_string);

  // convert special chars
  //$parsed_string = htmlentities($parsed_string, ENT_NOQUOTES, $_SESSION[_RUDWEB_PRE.'usr_lang_charset']);
  //$parsed_string = eregi_replace('&amp;','&',$parsed_string);
  //$parsed_string = eregi_replace('&copy;','&#169;',$parsed_string);
  //$parsed_string = eregi_replace('&deg;','&#176;',$parsed_string);
  //$parsed_string = ereg_replace('&acirc;','&#226;',$parsed_string);
  //$parsed_string = ereg_replace('&Acirc;','&#194;',$parsed_string);
  //$parsed_string = ereg_replace('&icirc;','&#238;',$parsed_string);
  //$parsed_string = ereg_replace('&Icirc;','&#206;',$parsed_string);
  
  $parsed_string = eregi_replace("ă", "&#259;", $parsed_string); //aa
  $parsed_string = eregi_replace("Ă", "&#258;", $parsed_string); //aa

  $parsed_string = eregi_replace("î", "&#238;", $parsed_string); //ii
  $parsed_string = eregi_replace("Î", "&#206;", $parsed_string); //II

  $parsed_string = eregi_replace("ş", "&#351;", $parsed_string); //sh
  $parsed_string = eregi_replace("Ş", "&#350;", $parsed_string); //SH

  $parsed_string = eregi_replace("ţ", "&#355;", $parsed_string); //tz
  $parsed_string = eregi_replace("Ţ", "&#354;", $parsed_string); //TZ

  $parsed_string = eregi_replace("â", "&#226;", $parsed_string); //ia
  $parsed_string = eregi_replace("Â", "&#194;", $parsed_string); //IA
  
  $parsed_string = eregi_replace("ö", "&#246;", $parsed_string); //ouml
  $parsed_string = eregi_replace("Ö", "&#214;", $parsed_string); //Ouml
  
  $parsed_string = eregi_replace("ü", "&#252;", $parsed_string); //uuml
  $parsed_string = eregi_replace("Ü", "&#220;", $parsed_string); //Uuml
  
  $parsed_string = eregi_replace("è", "&#232;", $parsed_string); //e1
  $parsed_string = eregi_replace("È", "&#200;", $parsed_string); //E1
  
  $parsed_string = eregi_replace("é", "&#233;", $parsed_string); //e2
  $parsed_string = eregi_replace("É", "&#201;", $parsed_string); //E2
  
  $parsed_string = eregi_replace("ñ", "&#233;", $parsed_string); //nSpa
  $parsed_string = eregi_replace("Ñ", "&#201;", $parsed_string); //NSpa
  
  $parsed_string = eregi_replace("ù", "&#249;", $parsed_string); //u<-
  $parsed_string = eregi_replace("Ù", "&#217;", $parsed_string); //U<-
  
  $parsed_string = eregi_replace("ú", "&#250;", $parsed_string); //u->
  $parsed_string = eregi_replace("Ú", "&#218;", $parsed_string); //U->
  
  $parsed_string = eregi_replace("à", "&#224;", $parsed_string); //a<-
  $parsed_string = eregi_replace("À", "&#192;", $parsed_string); //A<-
  
  $parsed_string = eregi_replace("á", "&#225;", $parsed_string); //a->
  $parsed_string = eregi_replace("Á", "&#193;", $parsed_string); //A->
  
  $parsed_string = eregi_replace("ò", "&#242;", $parsed_string); //o<-
  $parsed_string = eregi_replace("Ò", "&#210;", $parsed_string); //O<-
  
  $parsed_string = eregi_replace("ó", "&#243;", $parsed_string); //o->
  $parsed_string = eregi_replace("Ó", "&#211;", $parsed_string); //O->
  
  $parsed_string = eregi_replace("–", "-", $parsed_string); //-
  
  // block tags
  $parsed_string = eregi_replace('&lt;','&#60;',$parsed_string);
  $parsed_string = eregi_replace('&gt;','&#62;',$parsed_string);
  $parsed_string = eregi_replace('<','&#60;',$parsed_string);
  $parsed_string = eregi_replace('>','&#62;',$parsed_string);
  // convert problem chars
  $parsed_string = eregi_replace('`','&#96;',$parsed_string);
  $parsed_string = eregi_replace("'",'&#39;',$parsed_string);
  $parsed_string = eregi_replace('"','&#34;',$parsed_string);
  //$parsed_string = eregi_replace('/','&#47;',$parsed_string);  /* raw_date bug */
  // word boundary
  $parsed_string = eregi_replace('\\\b','&#92;b',$parsed_string);
  //newline
  $parsed_string = eregi_replace('\\\n','&#92;n',$parsed_string);
  // carriage return
  $parsed_string = eregi_replace('\\\r','&#92;r',$parsed_string);
  // tab
  $parsed_string = eregi_replace('\\\t','&#92;t',$parsed_string);
  return $parsed_string;
}
function rudweb_format_cnt_alias($string) {
  // strip whitespaces
  $parsed_string = trim($string);
  
  $unwanted = array('\\', '');
  $parsed_string = str_replace($unwanted, ' ', $parsed_string);
  //delete special chars
  //$parsed_string = htmlentities($parsed_string, ENT_NOQUOTES, $_SESSION[_RUDWEB_PRE.'usr_lang_charset']);
  //$parsed_string = eregi_replace('&amp;','',$parsed_string);
  //$parsed_string = eregi_replace('&copy;','',$parsed_string);
  //$parsed_string = eregi_replace('&deg;','',$parsed_string);
  //$parsed_string = ereg_replace('&acirc;','',$parsed_string);
  //$parsed_string = ereg_replace('&Acirc;','',$parsed_string);
  //$parsed_string = ereg_replace('&icirc;','',$parsed_string);
  //$parsed_string = ereg_replace('&Icirc;','',$parsed_string);
  
  $parsed_string = eregi_replace("&#226;", "a", $parsed_string);
  $parsed_string = eregi_replace("&#259;", "a", $parsed_string);
  $parsed_string = eregi_replace("&#224;", "a", $parsed_string);
  $parsed_string = eregi_replace("&#225;", "a", $parsed_string);
  $parsed_string = eregi_replace("&#194;", "A", $parsed_string);
  $parsed_string = eregi_replace("&#258;", "A", $parsed_string);
  $parsed_string = eregi_replace("&#192;", "A", $parsed_string);
  $parsed_string = eregi_replace("&#193;", "A", $parsed_string);
  
  $parsed_string = eregi_replace("&#238;", "i", $parsed_string);
  $parsed_string = eregi_replace("&#206;", "I", $parsed_string);
  
  $parsed_string = eregi_replace("&#351;", "s", $parsed_string);
  $parsed_string = eregi_replace("&#350;", "S", $parsed_string);
  
  $parsed_string = eregi_replace("&#355;", "t", $parsed_string);
  $parsed_string = eregi_replace("&#354;", "T", $parsed_string);
  
  $parsed_string = eregi_replace("&#232;", "e", $parsed_string);
  $parsed_string = eregi_replace("&#233;", "e", $parsed_string);
  $parsed_string = eregi_replace("&#200;", "E", $parsed_string);
  $parsed_string = eregi_replace("&#201;", "E", $parsed_string);
  
  $parsed_string = eregi_replace("&#246;", "o", $parsed_string);
  $parsed_string = eregi_replace("&#242;", "o", $parsed_string);
  $parsed_string = eregi_replace("&#243;", "o", $parsed_string);
  $parsed_string = eregi_replace("&#214;", "O", $parsed_string);
  $parsed_string = eregi_replace("&#210;", "O", $parsed_string);
  $parsed_string = eregi_replace("&#211;", "O", $parsed_string);
  
  $parsed_string = eregi_replace("&#252;", "u", $parsed_string);
  $parsed_string = eregi_replace("&#249;", "u", $parsed_string);
  $parsed_string = eregi_replace("&#250;", "u", $parsed_string);
  $parsed_string = eregi_replace("&#220;", "U", $parsed_string);
  $parsed_string = eregi_replace("&#217;", "U", $parsed_string);
  $parsed_string = eregi_replace("&#218;", "U", $parsed_string);
  
  $parsed_string = eregi_replace("ă", "a", $parsed_string); //aa
  $parsed_string = eregi_replace("Ă", "A", $parsed_string); //aa

  $parsed_string = eregi_replace("î", "i", $parsed_string); //ii
  $parsed_string = eregi_replace("Î", "I", $parsed_string); //II

  $parsed_string = eregi_replace("ş", "s", $parsed_string); //sh
  $parsed_string = eregi_replace("Ş", "S", $parsed_string); //SH

  $parsed_string = eregi_replace("ţ", "t", $parsed_string); //tz
  $parsed_string = eregi_replace("Ţ", "T", $parsed_string); //TZ

  $parsed_string = eregi_replace("â", "a", $parsed_string); //ia
  $parsed_string = eregi_replace("Â", "A", $parsed_string); //IA
  
  $parsed_string = eregi_replace("ö", "o", $parsed_string); //ouml
  $parsed_string = eregi_replace("Ö", "O", $parsed_string); //Ouml
  
  $parsed_string = eregi_replace("ü", "u", $parsed_string); //uuml
  $parsed_string = eregi_replace("Ü", "U", $parsed_string); //Uuml
  
  $parsed_string = eregi_replace("è", "e", $parsed_string); //e1
  $parsed_string = eregi_replace("È", "E", $parsed_string); //E1
  
  $parsed_string = eregi_replace("é", "e", $parsed_string); //e2
  $parsed_string = eregi_replace("É", "E", $parsed_string); //E2
  
  $parsed_string = eregi_replace("ñ", "n", $parsed_string); //nSpa
  $parsed_string = eregi_replace("Ñ", "N", $parsed_string); //NSpa
  
  $parsed_string = eregi_replace("ù", "u", $parsed_string); //u<-
  $parsed_string = eregi_replace("Ù", "U", $parsed_string); //U<-
  
  $parsed_string = eregi_replace("ú", "u", $parsed_string); //u->
  $parsed_string = eregi_replace("Ú", "U", $parsed_string); //U->
  
  $parsed_string = eregi_replace("à", "a", $parsed_string); //a<-
  $parsed_string = eregi_replace("À", "A", $parsed_string); //A<-
  
  $parsed_string = eregi_replace("á", "a", $parsed_string); //a->
  $parsed_string = eregi_replace("Á", "A", $parsed_string); //A->
  
  $parsed_string = eregi_replace("ò", "o", $parsed_string); //o<-
  $parsed_string = eregi_replace("Ò", "O", $parsed_string); //O<-
  
  $parsed_string = eregi_replace("ó", "o", $parsed_string); //o->
  $parsed_string = eregi_replace("Ó", "O", $parsed_string); //O->
  
  $parsed_string = eregi_replace("–", "", $parsed_string); //-
  
  // block tags
  $parsed_string = eregi_replace('&lt;','',$parsed_string);
  $parsed_string = eregi_replace('&gt;','',$parsed_string);
  $parsed_string = eregi_replace('<','&#60;',$parsed_string);
  $parsed_string = eregi_replace('>','&#62;',$parsed_string);
  // convert problem chars
  $parsed_string = eregi_replace('`','',$parsed_string);
  $parsed_string = eregi_replace("'",'',$parsed_string);
  $parsed_string = eregi_replace('"','',$parsed_string);
  $parsed_string = eregi_replace('/','',$parsed_string);
  // CUSTOM
  $parsed_string = eregi_replace('\?','',$parsed_string);
  $parsed_string = eregi_replace('!','',$parsed_string);
  $parsed_string = eregi_replace('\~','',$parsed_string);
  $parsed_string = eregi_replace('\@','',$parsed_string);
  $parsed_string = eregi_replace('\#','',$parsed_string);
  $parsed_string = eregi_replace('\$','',$parsed_string);
  $parsed_string = eregi_replace('\%','',$parsed_string);
  $parsed_string = eregi_replace('\^','',$parsed_string);
  $parsed_string = eregi_replace('\&','',$parsed_string);
  $parsed_string = eregi_replace('\*','',$parsed_string);
  $parsed_string = eregi_replace('\(','',$parsed_string);
  $parsed_string = eregi_replace('\)','',$parsed_string);
  $parsed_string = eregi_replace('\-','',$parsed_string);
  $parsed_string = eregi_replace('\+','',$parsed_string);
  $parsed_string = eregi_replace('\=','',$parsed_string);
  $parsed_string = eregi_replace('\{','',$parsed_string);
  $parsed_string = eregi_replace('\[','',$parsed_string);
  $parsed_string = eregi_replace('\}','',$parsed_string);
  $parsed_string = eregi_replace('\]','',$parsed_string);
  $parsed_string = eregi_replace('\:','',$parsed_string);
  $parsed_string = eregi_replace('\;','',$parsed_string);
  $parsed_string = eregi_replace('\,','',$parsed_string);
  $parsed_string = eregi_replace('\.','',$parsed_string);
  $parsed_string = eregi_replace('\|','',$parsed_string);
  //$parsed_string = eregi_replace('\\\\','',$parsed_string);
  
  // word boundary
  $parsed_string = eregi_replace('\\\b','',$parsed_string);
  //newline
  $parsed_string = eregi_replace('\\\n','',$parsed_string);
  // carriage return
  $parsed_string = eregi_replace('\\\r','',$parsed_string);
  // tab
  $parsed_string = eregi_replace('\\\t','',$parsed_string);
  $parsed_string = strtolower($parsed_string);
  $parsed_string = eregi_replace(' ','_',$parsed_string);
  return $parsed_string;
}
function rudweb_filter_content($string) {
  // strip whitespaces
  $parsed_string = trim($string);
  // convert special chars
  //$parsed_string = htmlentities($parsed_string, ENT_NOQUOTES, $_SESSION[_RUDWEB_PRE.'usr_lang_charset']);
  //$parsed_string = eregi_replace('&amp;','&',$parsed_string);
  //$parsed_string = eregi_replace('&amp;','&',$parsed_string);
  //$parsed_string = eregi_replace('&copy;','&#169;',$parsed_string);
  //$parsed_string = eregi_replace('&deg;','&#176;',$parsed_string);
  //$parsed_string = ereg_replace('&acirc;','&#226;',$parsed_string);
  //$parsed_string = ereg_replace('&Acirc;','&#194;',$parsed_string);
  //$parsed_string = ereg_replace('&icirc;','&#238;',$parsed_string);
  //$parsed_string = ereg_replace('&Icirc;','&#206;',$parsed_string);
  
  $parsed_string = eregi_replace("ă", "&#259;", $parsed_string); //aa
  $parsed_string = eregi_replace("Ă", "&#258;", $parsed_string); //aa

  $parsed_string = eregi_replace("î", "&#238;", $parsed_string); //ii
  $parsed_string = eregi_replace("Î", "&#206;", $parsed_string); //II

  $parsed_string = eregi_replace("ş", "&#351;", $parsed_string); //sh
  $parsed_string = eregi_replace("Ş", "&#350;", $parsed_string); //SH

  $parsed_string = eregi_replace("ţ", "&#355;", $parsed_string); //tz
  $parsed_string = eregi_replace("Ţ", "&#354;", $parsed_string); //TZ

  $parsed_string = eregi_replace("â", "&#226;", $parsed_string); //ia
  $parsed_string = eregi_replace("Â", "&#194;", $parsed_string); //IA
  
  $parsed_string = eregi_replace("ö", "&#246;", $parsed_string); //ouml
  $parsed_string = eregi_replace("Ö", "&#214;", $parsed_string); //Ouml
  
  $parsed_string = eregi_replace("ü", "&#252;", $parsed_string); //uuml
  $parsed_string = eregi_replace("Ü", "&#220;", $parsed_string); //Uuml
  
  $parsed_string = eregi_replace("è", "&#232;", $parsed_string); //e1
  $parsed_string = eregi_replace("È", "&#200;", $parsed_string); //E1
  
  $parsed_string = eregi_replace("é", "&#233;", $parsed_string); //e2
  $parsed_string = eregi_replace("É", "&#201;", $parsed_string); //E2
  
  $parsed_string = eregi_replace("ñ", "&#233;", $parsed_string); //nSpa
  $parsed_string = eregi_replace("Ñ", "&#201;", $parsed_string); //NSpa  
  
  $parsed_string = eregi_replace("ù", "&#249;", $parsed_string); //u<-
  $parsed_string = eregi_replace("Ù", "&#217;", $parsed_string); //U<-
  
  $parsed_string = eregi_replace("ú", "&#250;", $parsed_string); //u->
  $parsed_string = eregi_replace("Ú", "&#218;", $parsed_string); //U->
  
  $parsed_string = eregi_replace("à", "&#224;", $parsed_string); //a<-
  $parsed_string = eregi_replace("À", "&#192;", $parsed_string); //A<-
  
  $parsed_string = eregi_replace("á", "&#225;", $parsed_string); //a->
  $parsed_string = eregi_replace("Á", "&#193;", $parsed_string); //A->
  
  $parsed_string = eregi_replace("ò", "&#242;", $parsed_string); //o<-
  $parsed_string = eregi_replace("Ò", "&#210;", $parsed_string); //O<-
  
  $parsed_string = eregi_replace("ó", "&#243;", $parsed_string); //o->
  $parsed_string = eregi_replace("Ó", "&#211;", $parsed_string); //O->
  
  $parsed_string = eregi_replace("–", "", $parsed_string); //-

  // convert problem chars
  $parsed_string = eregi_replace('`','&#96;',$parsed_string);
  $parsed_string = eregi_replace("'",'&#39;',$parsed_string);
  //$parsed_string = eregi_replace('"','&#34;',$parsed_string);
  // disable php
  $parsed_string = eregi_replace('<\?','&lt;php',$parsed_string);
  $parsed_string = eregi_replace('&lt;\?','&lt;php',$parsed_string);
  $parsed_string = eregi_replace('\?>','&gt;php',$parsed_string);
  $parsed_string = eregi_replace('\?&gt;','&gt;php',$parsed_string);
  // word boundary
  $parsed_string = eregi_replace('\\\b','&#92;b',$parsed_string);
  //newline
  $parsed_string = eregi_replace('\\\n','&#92;n',$parsed_string);
  // carriage return
  $parsed_string = eregi_replace('\\\r','&#92;r',$parsed_string);
  // tab
  $parsed_string = eregi_replace('\\\t','&#92;t',$parsed_string);
  return $parsed_string;
}
function parseSearchString($str) {
  // basic filter
  $str = rudweb_filter_input($str);
  // remove common words
  $str = eregi_replace(' and ',' ',$str);
  $str = eregi_replace(' or ',' ',$str);
  $str = eregi_replace(' the ',' ',$str);
  //remove unwanted unwanted characters
  $unwanted = array('\\', '', '/' , '"', '*', '&' , '$', '#', '@', '!', '_', ')', '(', '+', '|');
  $str = str_replace($unwanted, ' ', $str);
  // put distinct words in an array
  $words = preg_split("/[\s,]+/", $str);
  // get rid of duplicates
  $words = array_unique($words);
  // get rid of short words 1, 2 chars
  $words = preg_replace("/^([a-z]{1,2})$/",'',$words);
  // remove some unwanted chars
  $words = preg_replace("/^([.']{1,})$/",'',$words);
  // get rid of empty words
  $words = array_diff($words, array(''));
  // create MySQL compatible REGEXP string
  $str = implode('|', $words);

  return $str;
}
/* ********** ********** ********** //FILTER INPUT ********** ********** ********** */
/* ********** ********** ********** SEARCH ENGINE FRIENDLY URLS ********** ********** ********** */
// SEARCH ENGINE FRIENDLY URLS
/*
inspired by code created by 
ReDuX (http://www.daniweb.com/code/snippet74.html)
and
DD32 (http://www.php.net/manual/en/language.variables.predefined.php#63312)
*/
function seo_urls() {
  if (isset($_SERVER['PATH_INFO'])) {
    $raw_data = explode('/', $_SERVER['PATH_INFO']);
    unset($raw_data[0]);
    $total_data = count($raw_data);
    if (is_int($total_data / 2)) {
      for($i=1;$i<=count($raw_data);$i+=2) {
        $_GET[$raw_data[$i]] = $raw_data[$i+1];
      }
    }
  }
}
/* ********** ********** ********** //SEARCH ENGINE FRIENDLY URLS ********** ********** ********** */
/* ********** ********** ********** //LIST SUBDIRECTORIES ********** ********** ********** */
function lsdir($dir) {
  $subdirs = NULL;
  $i = '1';
  if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {
        if ($file != "." && $file != "..") {
          if (filetype($dir . $file) == 'dir') {
            $subdirs[$i] = $file;
            $i++;
          }
        }
      }
    closedir($dh);
    }
  }
  return $subdirs;
}
function lsfiles($dir, $ext) {
  $files = NULL;
  $i = '1';
  if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {
        if ($file != "." && $file != "..") {
          if (filetype($dir . $file) !== 'dir') {
            if (preg_match("/".$ext."/i", $file)) {
              $file_name = preg_replace("/".$ext."/i", "", $file);
              $files[$i] = $file_name;
              $i++;
            }
          }
        }
      }
      closedir($dh);
    }
  }
  return $files;
}
/* ********** ********** ********** //LIST SUBDIRECTORIES ********** ********** ********** */
/* ********** ********** ********** GENERATE RESTRICTED LINKS ********** ********** ********** */
function restrictedLocalLink($link_class, $link_title, $link_url, $current_usr_level, $required_usr_level, $mouseover_status, $mouseout_status, $link_target) {
  if ($current_usr_level >= $required_usr_level) {
    echo "<A CLASS=\"" . $link_class . "\" HREF=\"" . _RUDWEB_SITE_URL . $link_url . "\" onMouseOver=\"JavaScript:window.status='" . $mouseover_status . "'; return true;\" onMouseOut=\"JavaScript:window.status='" . $mouseout_status . "'; return true;\" onClick=\"JavaScript:window.status='" . $mouseout_status . "'; return true;\" TARGET=\"" . $link_target . "\">" . $link_title . "</A>";
  }
  else {
    echo "<SPAN CLASS=\"link_default\">" . $link_title . "</SPAN>";
  }
}
function restrictedExtLink($link_class, $link_title, $link_url, $current_usr_level, $required_usr_level, $mouseover_status, $mouseout_status, $link_target) {
  if ($current_usr_level >= $required_usr_level) {
    echo "<A CLASS=\"" . $link_class . "\" HREF=\"" .  _RUDWEB_SITE_URL . "redirect.php?url=" . urlencode($link_url) . "\" onMouseOver=\"JavaScript:window.status='" . $mouseover_status . "'; return true;\" onMouseOut=\"JavaScript:window.status='" . $mouseout_status . "'; return true;\" onClick=\"JavaScript:window.status='" . $mouseout_status . "'; return true;\" TARGET=\"" . $link_target . "\">" . $link_title . "</A>";
  }
  else {
    echo "<SPAN CLASS=\"link_default\">" . $link_title . "</SPAN>";
  }
}
function restrictedJsLink($link_class, $link_title, $link_script, $current_usr_level, $required_usr_level, $mouseover_status, $mouseout_status) {
  if ($current_usr_level >= $required_usr_level) {
    echo "<A CLASS=\"" . $link_class . "\" HREF=\"JavaScript:void(0);\" onClick=\"" . $link_script . "\" onMouseOver=\"JavaScript:window.status='" . $mouseover_status . "'; return true;\" onMouseOut=\"JavaScript:window.status='" . $mouseout_status . "'; return true;\" onClick=\"JavaScript:window.status='" . $mouseout_status . "'; return true;\">" . $link_title . "</A>";
  }
  else {
    echo "<SPAN CLASS=\"link_default\">" . $link_title . "</SPAN>";
  }
}
/* ********** ********** ********** //GENERATE RESTRICTED LINKS ********** ********** ********** */
/* ********** ********** ********** CREATE MENU ********** ********** ********** */
function createMenu($mnu_cat, $mnu_lev, $showadmin = "0") {
  global $rudweb_mnu_id;
  global $rudweb_ln;
  global $rudweb_skin;
  global $rudweb_this_content_level;
  // this is where the magic gets done :-)
  if ($rudweb_this_content_level === "0") {
    if ($mnu_lev == '0')      {$this_mnu_par = '0';}
    else if ($mnu_lev == '1') {$this_mnu_par = $rudweb_mnu_id;}
    else if ($mnu_lev == '2') {$this_mnu_par = $rudweb_mnu_id;}
    else if ($mnu_lev == '3') {$this_mnu_par = $rudweb_mnu_id;}
    else if ($mnu_lev == '4') {$this_mnu_par = $rudweb_mnu_id;}
  }
  else if ($rudweb_this_content_level === "1") {
    if ($mnu_lev == '0')      {$this_mnu_par = '0';}
    else if ($mnu_lev == '1') {$this_mnu_par = getCntParId($rudweb_mnu_id);}
    else if ($mnu_lev == '2') {$this_mnu_par = $rudweb_mnu_id;}
    else if ($mnu_lev == '3') {$this_mnu_par = $rudweb_mnu_id;}
    else if ($mnu_lev == '4') {$this_mnu_par = $rudweb_mnu_id;}
  }
  else if ($rudweb_this_content_level === "2") {
    if ($mnu_lev == '0')      {$this_mnu_par = '0';}
    else if ($mnu_lev == '1') {$this_mnu_par = getCntParId(getCntParId($rudweb_mnu_id));}
    else if ($mnu_lev == '2') {$this_mnu_par = getCntParId($rudweb_mnu_id);}
    else if ($mnu_lev == '3') {$this_mnu_par = $rudweb_mnu_id;}
    else if ($mnu_lev == '4') {$this_mnu_par = $rudweb_mnu_id;}
  }
  else if ($rudweb_this_content_level === "3") {
    if ($mnu_lev == '0')      {$this_mnu_par = '0';}
    else if ($mnu_lev == '1') {$this_mnu_par = getCntParId(getCntParId(getCntParId($rudweb_mnu_id)));}
    else if ($mnu_lev == '2') {$this_mnu_par = getCntParId(getCntParId($rudweb_mnu_id));}
    else if ($mnu_lev == '3') {$this_mnu_par = getCntParId($rudweb_mnu_id);}
    else if ($mnu_lev == '4') {$this_mnu_par = $rudweb_mnu_id;}
  }
  else if ($rudweb_this_content_level === "4") {
    if ($mnu_lev == '0')      {$this_mnu_par = '0';}
    else if ($mnu_lev == '1') {$this_mnu_par = getCntParId(getCntParId(getCntParId(getCntParId($rudweb_mnu_id))));}
    else if ($mnu_lev == '2') {$this_mnu_par = getCntParId(getCntParId(getCntParId($rudweb_mnu_id)));}
    else if ($mnu_lev == '3') {$this_mnu_par = getCntParId(getCntParId($rudweb_mnu_id));}
    else if ($mnu_lev == '4') {$this_mnu_par = getCntParId($rudweb_mnu_id);}
  }
  $menu_query = "SELECT * FROM `"._RUDWEB_PRE."ws_mnu` WHERE `mnu_dis` = '0' AND (`mnu_lvl` <= '".$_SESSION[_RUDWEB_PRE.'usr_level']."' AND (`mnu_ln` = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND (`mnu_cat` = '".$mnu_cat."' AND (`mnu_par` = '".$this_mnu_par."' AND `mnu_lev` = '".$mnu_lev."')))) ORDER BY `mnu_ord` ASC";
  $rst_menu = mysql_query($menu_query) or require _RUDWEB_LIB_DIR . 'myerr.php';
  $total_menu = mysql_num_rows($rst_menu);
  $test_array = array();
  $row_rst_menu = array();
  
  for ($mnui=1; $mnui<=$total_menu; $mnui++) {$row_rst_menu[$mnui] = mysql_fetch_assoc($rst_menu); $test_array[$mnui] = $row_rst_menu[$mnui]['mnu_id'];}
  if($total_menu != "0") {echo $rudweb_skin['mnu'][$mnu_cat]['hdr'][$mnu_lev];}
  for ($cmni=1; $cmni<=count($row_rst_menu); $cmni++) {
    echo $rudweb_skin['mnu'][$mnu_cat]['pre'][$mnu_lev];
    if ($row_rst_menu[$cmni]['mnu_id'] === $rudweb_mnu_id) {
      echo "<SPAN CLASS=\"".$mnu_cat."-mnu_lnk_".$mnu_lev."\">" . $row_rst_menu[$cmni]['mnu_tt'] . "</SPAN>";
    } // current page, do not make link
    else {
      if ($row_rst_menu[$cmni]['mnu_typ'] === "1") {
        if ($row_rst_menu[$cmni]['mnu_cnt_alias'] === "index") {
          restrictedLocalLink($mnu_cat.'-mnu_'.$mnu_lev, $row_rst_menu[$cmni]['mnu_tt'], _RUDWEB_INDEX_PHP, $_SESSION[_RUDWEB_PRE.'usr_level'], $row_rst_menu[$cmni]['mnu_lvl'], $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], $row_rst_menu[$cmni]['mnu_trg']);
        }
        else {
          restrictedLocalLink($mnu_cat.'-mnu_'.$mnu_lev, $row_rst_menu[$cmni]['mnu_tt'], _RUDWEB_INDEX_PHP . 'content/'.$row_rst_menu[$cmni]['mnu_cnt_alias'], $_SESSION[_RUDWEB_PRE.'usr_level'], $row_rst_menu[$cmni]['mnu_lvl'], $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], $row_rst_menu[$cmni]['mnu_trg']);
        }
      } // 1 - content
      else if ($row_rst_menu[$cmni]['mnu_typ'] === "2") {
        $mnu_lnk_query = "SELECT * FROM "._RUDWEB_PRE."ws_lnk WHERE lnk_alias = '".$row_rst_menu[$cmni]['mnu_cnt_alias']."' AND (lnk_dis = '0' AND (lnk_ln = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND (lnk_lvl <= '".$_SESSION[_RUDWEB_PRE.'usr_level']."' AND lnk_cat = '1'))) LIMIT 1";
        $rst_mnu_lnk = mysql_query($mnu_lnk_query) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $total_mnu_lnk = mysql_num_rows($rst_mnu_lnk);
        if ($total_mnu_lnk != '1') {
          $lnk_url = '';
          echo "<SPAN CLASS=\"link_default\">" . $row_rst_menu[$cmni]['mnu_tt'] . "</SPAN>";
        }
        else {
          $row_rst_mnu_lnk = mysql_fetch_assoc($rst_mnu_lnk);
          $lnk_url = $row_rst_mnu_lnk['lnk_url'];
          restrictedExtLink($mnu_cat.'-mnu_'.$mnu_lev, $row_rst_menu[$cmni]['mnu_tt'], $lnk_url, $_SESSION[_RUDWEB_PRE.'usr_level'], $row_rst_menu[$cmni]['mnu_lvl'], $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], $row_rst_menu[$cmni]['mnu_trg']);
        }
      } // 2 - link
      else if ($row_rst_menu[$cmni]['mnu_typ'] === "3") {
        restrictedLocalLink($mnu_cat.'-mnu_'.$mnu_lev, $row_rst_menu[$cmni]['mnu_tt'], _RUDWEB_INDEX_PHP . 'page/'.$row_rst_menu[$cmni]['mnu_cnt_alias'], $_SESSION[_RUDWEB_PRE.'usr_level'], $row_rst_menu[$cmni]['mnu_lvl'], $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], $row_rst_menu[$cmni]['mnu_trg']);
      } // 3 - page
      else if ($row_rst_menu[$cmni]['mnu_typ'] === "4") {
        restrictedLocalLink($mnu_cat.'-mnu_'.$mnu_lev, $row_rst_menu[$cmni]['mnu_tt'], _RUDWEB_INDEX_PHP . 'admin/'.$row_rst_menu[$cmni]['mnu_cnt_alias'], $_SESSION[_RUDWEB_PRE.'usr_level'], $row_rst_menu[$cmni]['mnu_lvl'], $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], $row_rst_menu[$cmni]['mnu_trg']);
      } // 4 - admin
      else if ($row_rst_menu[$cmni]['mnu_typ'] === "5") {
        restrictedLocalLink($mnu_cat.'-mnu_'.$mnu_lev, $row_rst_menu[$cmni]['mnu_tt'], _RUDWEB_INDEX_PHP . 'catalog/'.$row_rst_menu[$cmni]['mnu_cnt_alias'], $_SESSION[_RUDWEB_PRE.'usr_level'], $row_rst_menu[$cmni]['mnu_lvl'], $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], $row_rst_menu[$cmni]['mnu_trg']);
      } // 5 - catalog
      else if ($row_rst_menu[$cmni]['mnu_typ'] === "6") {
        restrictedLocalLink($mnu_cat.'-mnu_'.$mnu_lev, $row_rst_menu[$cmni]['mnu_tt'], _RUDWEB_INDEX_PHP . 'show/'.$row_rst_menu[$cmni]['mnu_cnt_alias'], $_SESSION[_RUDWEB_PRE.'usr_level'], $row_rst_menu[$cmni]['mnu_lvl'], $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], $row_rst_menu[$cmni]['mnu_trg']);
      } // 6 - show
    } // not current page, make link
    echo $rudweb_skin['mnu'][$mnu_cat]['suf'][$mnu_lev];
    if ($cmni < $total_menu) {echo $rudweb_skin['mnu'][$mnu_cat]['sep'][$mnu_lev];}
  }
  if ($_SESSION[_RUDWEB_PRE.'usr_level'] >= '3' && $showadmin == "1") {
    //if ($total_menu != '0' && ($mnu_lev == $rudweb_this_content_level && in_array($rudweb_mnu_id ,$test_array))) {
    if ($total_menu != '0' && ($mnu_lev == $rudweb_this_content_level)) {
      // in continuare in nivelul curent
      echo $rudweb_skin['mnu'][$mnu_cat]['sep'][$mnu_lev];
      echo $rudweb_skin['mnu'][$mnu_cat]['pre'][$mnu_lev];
      restrictedLocalLink($mnu_cat.'-mnu_'.$mnu_lev, "[".$rudweb_ln['adm']['cnt_add']."]", _RUDWEB_INDEX_PHP . 'admin/cntadd/mc/'.$mnu_cat.'/ml/'.$mnu_lev.'/mp/'.$this_mnu_par, $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], "_self");
      echo $rudweb_skin['mnu'][$mnu_cat]['suf'][$mnu_lev];
    }
    else if ($total_menu == '0') {
      echo $rudweb_skin['mnu'][$mnu_cat]['hdr'][$mnu_lev];
      if ($mnu_lev != '0') {
        // primul din nivelul curent
        $look_for    = $mnu_lev - 1;
        $query = "SELECT `mnu_id` FROM `"._RUDWEB_PRE."ws_mnu` WHERE mnu_id = '".$rudweb_mnu_id."' AND (mnu_lev = '".$look_for."' AND mnu_cat = '".$mnu_cat."') LIMIT 1";
        $rst_query = mysql_query($query) or require _RUDWEB_LIB_DIR . 'myerr.php';
        if (mysql_num_rows($rst_query) != '0') {
          echo $rudweb_skin['mnu'][$mnu_cat]['pre'][$mnu_lev];
          restrictedLocalLink($mnu_cat.'-mnu_'.$mnu_lev, "[".$rudweb_ln['adm']['cnt_add']."]", _RUDWEB_INDEX_PHP . 'admin/cntadd/mc/'.$mnu_cat.'/ml/'.$mnu_lev.'/mp/'.$rudweb_mnu_id, $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], "_self");
          echo $rudweb_skin['mnu'][$mnu_cat]['suf'][$mnu_lev];
        }
      }
      else {
        // primul meniu!
        echo $rudweb_skin['mnu'][$mnu_cat]['pre'][$mnu_lev];
        restrictedLocalLink($mnu_cat.'-mnu_'.$mnu_lev, "[".$rudweb_ln['adm']['cnt_add']."]", _RUDWEB_INDEX_PHP . 'admin/cntadd/mc/'.$mnu_cat.'/ml/0/mp/0', $_SESSION[_RUDWEB_PRE.'usr_level'], 3, $rudweb_ln['WinStatOver'], $rudweb_ln['WinStatOut'], "_self");
        echo $rudweb_skin['mnu'][$mnu_cat]['suf'][$mnu_lev];
      }
      echo $rudweb_skin['mnu'][$mnu_cat]['ftr'][$mnu_lev];
    }
  }
  if($total_menu != "0") {echo $rudweb_skin['mnu'][$mnu_cat]['ftr'][$mnu_lev];}
}
function getCntMnuId($cnt_alias) {
  if (isset($_GET['content']))   {$rudweb_mnu_typ = '1';}
  else if (isset($_GET['page'])) {$rudweb_mnu_typ = '3';}
  else if (isset($_GET['rudweb'])) {$rudweb_mnu_typ = '4';}
  else if (isset($_GET['catalog'])) {$rudweb_mnu_typ = '5';}
  else {$rudweb_mnu_typ = '1';} // 2 is external link, no need for that
  $query = "SELECT `mnu_id` FROM `"._RUDWEB_PRE."ws_mnu` WHERE `mnu_cnt_alias` = '".$cnt_alias."' AND (`mnu_dis` = '0' AND (`mnu_ln` = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND `mnu_typ` = '".$rudweb_mnu_typ."')) ORDER BY `mnu_cat` ASC, `mnu_lev` DESC, `mnu_id` DESC LIMIT 1";
  $rst_query = mysql_query($query) or require _RUDWEB_LIB_DIR . 'myerr.php';
  if (mysql_num_rows($rst_query) != '0') {$cnt_mn_id = mysql_result($rst_query, 0);}
  else {$cnt_mn_id = '0';}
  return $cnt_mn_id;
}
function getCntParId($mnu_id) {
  $query = "SELECT `mnu_par` FROM `"._RUDWEB_PRE."ws_mnu` WHERE `mnu_id` = '".$mnu_id."' AND (`mnu_dis` = '0' AND `mnu_ln` = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."') LIMIT 1";
  $rst_query = mysql_query($query) or require _RUDWEB_LIB_DIR . 'myerr.php';
  if (mysql_num_rows($rst_query) != '0') {$cnt_mn_id = mysql_result($rst_query, 0);}
  else {$cnt_mn_id = '0';}
  return $cnt_mn_id;
}
function getCntLev($cnt_alias) {
  $query = "SELECT `mnu_lev` FROM `"._RUDWEB_PRE."ws_mnu` WHERE `mnu_cnt_alias` = '".$cnt_alias."' AND (`mnu_dis` = '0' AND `mnu_ln` = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."') ORDER BY `mnu_cat` ASC, `mnu_lev` DESC, `mnu_id` DESC LIMIT 1";
  $rst_query = mysql_query($query) or require _RUDWEB_LIB_DIR . 'myerr.php';
  if (mysql_num_rows($rst_query) != '0') {$cnt_mn_id = mysql_result($rst_query, 0);}
  else {$cnt_mn_id = '0';}
  return $cnt_mn_id;
}
/* ********** ********** ********** //CREATE MENU ********** ********** ********** */
/* ********** ********** ********** //SHOW PAGE PICTURE PLACE ********** ********** ********** */
function showContentPics() {
  global $rudweb_req_page;
  global $rudweb_skin;
  if (isset($_GET['content']) || (isset($_GET['page']) || isset($_GET['rudweb']))) {
    $query_content = "SELECT * FROM `"._RUDWEB_PRE."ws_cnt` WHERE `cnt_alias` = '".$rudweb_req_page."' AND (`cnt_dis` = '0' AND `cnt_ln` = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."') LIMIT 1";
    $rst_query_content = mysql_query($query_content) or require _RUDWEB_LIB_DIR . 'myerr.php';
    if (mysql_num_rows($rst_query_content) != '0') {
      $row_rst_content = mysql_fetch_assoc($rst_query_content);
      $this_content_id = $row_rst_content['cnt_id'];
      
      // PICTURES 0
      if (_RUDWEB_CFG_PICS_0 === "1") {
        echo $rudweb_skin['cnt']['pic']['hdr']['0'];
        $query_pic0 = "SELECT * FROM `"._RUDWEB_PRE."ws_pic` WHERE `cnt_id` = '".$this_content_id."' AND (`pic_loc` = '0' AND `pic_dis` = '0') ORDER BY `pic_ord` ASC";
        $rst_query_pic0 = mysql_query($query_pic0) or require _RUDWEB_LIB_DIR . 'myerr.php';
        $total_pic0 = mysql_num_rows($rst_query_pic0);
        if ($total_pic0 != '0') {
          for ($pic0i=1; $pic0i<=$total_pic0; $pic0i++) {
            $row_rst_pic0 = mysql_fetch_assoc($rst_query_pic0);
            $pictureFile0[$pic0i]    = _RUDWEB_PIC_DIR . $row_rst_pic0['pic_fn'];
            $pictureFile0url[$pic0i] = _RUDWEB_PIC_URL . $row_rst_pic0['pic_fn'];
            $pictureFile0TT[$pic0i] = $row_rst_pic0['pic_tt'];
            //$fileSize0[$pic0i] = round(filesize($pictureFile0[$pic0i]) / 1024,2);
            //list($pic0_width[$pic0i], $pic0_height[$pic0i], $pic0_type[$pic0i], $pic0_attr[$pic0i]) = getimagesize($pictureFile0[$pic0i]);
            $pic0_imgsrc[$pic0i] = "<IMG SRC=\""._RUDWEB_LIB_URL ."pic.php?imgfile=" . $pictureFile0[$pic0i] . "&amp;max_size=".$rudweb_skin['cnt']['pic']['max']['0']."\" ALT=\"".$pictureFile0TT[$pic0i]."\">";
            echo $rudweb_skin['cnt']['pic']['pre']['0'];
            if ($row_rst_pic0['pic_tmb'] === "1") {
              echo "<A CLASS=\"default\" rel=\"lightbox[".$row_rst_pic0['pic_loc']."]\" HREF=\"" . $pictureFile0url[$pic0i] . "\" TITLE=\"".$pictureFile0TT[$pic0i]."\">";
              echo $pic0_imgsrc[$pic0i];
              echo "</A>";
            }
            else {
              echo $pic0_imgsrc[$pic0i];
            }
            echo $rudweb_skin['cnt']['pic']['suf']['0'];
            if ($pic0i !== $total_pic0) { echo $rudweb_skin['cnt']['pic']['sep']['0'];}
          }
          
        }
        else {echo "&#160;";}
        echo $rudweb_skin['cnt']['pic']['ftr']['0'];
      }
    }
    else {
      if (_RUDWEB_CFG_PICS_0 === "1") {
        echo $rudweb_skin['cnt']['pic']['hdr']['0'];
        echo $rudweb_skin['cnt']['pic']['pre']['0'];
        echo "";
        echo $rudweb_skin['cnt']['pic']['suf']['0'];
        echo $rudweb_skin['cnt']['pic']['ftr']['0'];
      }
    }
  }    
}
/* ********** ********** ********** //SHOW PAGE PICTURE PLACE ********** ********** ********** */
/* ********** ********** ********** SHOW PAGE CONTENT ********** ********** ********** */
function showContent($rudweb_mnu_id, $rudweb_req_page, $rudweb_cnt_type, $blog_content = "0") {
  global $rudweb_ln;
  global $rudweb_skin;
  global $rudweb_dbtype;
  global $rudweb_this_content;
  switch($rudweb_cnt_type) {
      case "1": {
        $query_content = "SELECT * FROM `"._RUDWEB_PRE."ws_cnt` WHERE `cnt_alias` = '".$rudweb_req_page."' AND (`cnt_dis` = '0' AND `cnt_ln` = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."') LIMIT 1";
        $rst_query_content = mysql_query($query_content) or require _RUDWEB_LIB_DIR . 'myerr.php';
        if (mysql_num_rows($rst_query_content) != '0') {
          $row_rst_content = mysql_fetch_assoc($rst_query_content);
          $this_content_id = $row_rst_content['cnt_id'];
          
          if (_RUDWEB_CFG_CNT_TAGS === "1") {
            $q_et = "SELECT DISTINCT tag_name AS tag FROM ". _RUDWEB_PRE. "ws_rel AS r LEFT JOIN ". _RUDWEB_PRE. "ws_tags AS t ON (r.tag_id = t.tag_id) WHERE r.cnt_id = '".$row_rst_content['cnt_id']."' ORDER BY t.tag_name ASC";
            $rs_et = rudweb_qres($rudweb_dbtype, $q_et);
            $t_et  = rudweb_qtotal($rudweb_dbtype, $rs_et);
            if($t_et != 0) {
              for($i=1;$i<=$t_et;$i++) {
                $r_et = rudweb_fetch_assoc($rudweb_dbtype, $rs_et);
                $et[$i] = $r_et['tag'];
              }
              $cnt_tags = implode(', ', $et);
              $cnt_tags = $cnt_tags . ', ';
            }
            else {$cnt_tags = ''; $et = array();}
          }
          else {$et = array();}
          
          if ($_SESSION[_RUDWEB_PRE.'usr_level'] >=3 && $blog_content == 0) {
            require _RUDWEB_INC_DIR . 'contentadm.inc.php';
          }
          else {
            require _RUDWEB_INC_DIR . 'content.inc.php';
          }
          if (_RUDWEB_CFG_CNT_CMNTS === "1") {
            if ($blog_content == 0) {showExtComments(0,$this_content_id,$row_rst_content['cnt_alias']);}
            else {showComments(0,$this_content_id,$row_rst_content['cnt_alias']);}
          }

        // LINKS
        }
        else {
          echo $rudweb_skin['cnt']['hdr'];
          echo $rudweb_skin['cnt']['pre'];
          echo "<DIV CLASS=\"err\">" . $rudweb_ln['err']['0'] . "</DIV>";
          echo $rudweb_skin['cnt']['suf'];
          echo $rudweb_skin['cnt']['ftr'];
        }
        break;
      }
      case "3": {
        if (is_file(_RUDWEB_PG_DIR . $rudweb_req_page . ".inc.php")) {
          echo $rudweb_skin['cnt']['hdr'];
          echo $rudweb_skin['cnt']['pre'];
          require _RUDWEB_PG_DIR . $rudweb_req_page . ".inc.php";
          echo $rudweb_skin['cnt']['suf'];
          echo $rudweb_skin['cnt']['ftr'];
        }
        else {
          echo $rudweb_skin['cnt']['hdr'];
          echo $rudweb_skin['cnt']['pre'];
          echo "<DIV CLASS=\"err\">" . $rudweb_ln['err']['0'] . "</DIV>";
          echo $rudweb_skin['cnt']['suf'];
          echo $rudweb_skin['cnt']['ftr'];
        }
        break;
      }
      case "4": {
        if (is_file(_RUDWEB_ADMIN_DIR . $rudweb_req_page . ".inc.php")) {
          echo $rudweb_skin['cnt']['hdr'];
          echo $rudweb_skin['cnt']['pre'];
          require _RUDWEB_ADMIN_DIR . $rudweb_req_page . ".inc.php";
          echo $rudweb_skin['cnt']['suf'];
          echo $rudweb_skin['cnt']['ftr'];
        }
        else {
          echo $rudweb_skin['cnt']['hdr'];
          echo $rudweb_skin['cnt']['pre'];
          echo "<DIV CLASS=\"err\">" . $rudweb_ln['err']['0'] . "</DIV>";
          echo $rudweb_skin['cnt']['suf'];
          echo $rudweb_skin['cnt']['ftr'];
        }
        break;
      }
      case "5": {
        if (is_file(_RUDWEB_CAT_DIR . $rudweb_req_page . ".inc.php")) {
          echo $rudweb_skin['cnt']['hdr'];
          echo $rudweb_skin['cnt']['pre'];
          require _RUDWEB_CAT_DIR . $rudweb_req_page . ".inc.php";
          echo $rudweb_skin['cnt']['suf'];
          echo $rudweb_skin['cnt']['ftr'];
        }
        else {
          echo $rudweb_skin['cnt']['hdr'];
          echo $rudweb_skin['cnt']['pre'];
          echo "<DIV CLASS=\"err\">" . $rudweb_ln['err']['0'] . "</DIV>";
          echo $rudweb_skin['cnt']['suf'];
          echo $rudweb_skin['cnt']['ftr'];
        }
        break;
      }
      default : {break;}
  }    
}
/* ********** ********** ********** //SHOW PAGE CONTENT ********** ********** ********** */
/* ********** ********** ********** SHOW PAGE CONTENT BLOGSTYLE ********** ********** ********** */
function showBlogContent($parent_id) {
  global $rudweb_dbtype;
  global $rudweb_ln;
  global $rudweb_skin;
  $query_blog = "SELECT mnu_id, mnu_cnt_alias, mnu_typ FROM `"._RUDWEB_PRE."ws_mnu` WHERE `mnu_par` = '".$parent_id."' AND (`mnu_ln` = '".$_SESSION[_RUDWEB_PRE.'usr_lang_index']."' AND `mnu_dis` = '0') ORDER BY mnu_mdd DESC, mnu_mdt DESC, mnu_crd DESC, mnu_crt DESC";
  $rst_query_blog = mysql_query($query_blog) or require _RUDWEB_LIB_DIR . 'myerr.php';
  $total_blog = mysql_num_rows($rst_query_blog);
  if ($total_blog != "0") {
    echo $rudweb_skin['blg']['hdr'];
    for ($blogi=1; $blogi<=$total_blog; $blogi++) {
      $row_rst_blog = mysql_fetch_assoc($rst_query_blog);
      $blog_mnu_id[$blogi]    = $row_rst_blog['mnu_id'];
      $blog_cnt_alias[$blogi] = $row_rst_blog['mnu_cnt_alias'];
      $blog_mnu_typ[$blogi]   = $row_rst_blog['mnu_typ'];
      
      if($blog_mnu_typ[$blogi] == 1) {
        echo $rudweb_skin['blg']['pre'];
        showContent($blog_mnu_id[$blogi], $blog_cnt_alias[$blogi], $blog_mnu_typ[$blogi], 1);
        echo $rudweb_skin['blg']['suf'];
      }  

      if ($blogi !== $total_blog) {echo $rudweb_skin['blg']['sep'];}
    }
    echo $rudweb_skin['blg']['ftr'];
  }
}
/* ********** ********** ********** //SHOW PAGE CONTENT BLOGSTYLE ********** ********** ********** */
/* ********** ********** ********** CHANGE SETTINGS IN THE DATABASE ********** ********** ********** */
function changedbcfg($set, $val, $action_date, $action_time) {
  if(_RUDWEB_DBCFG === "1" && $_SESSION[_RUDWEB_PRE.'usr_level'] >=3) {
    // lock
    $query_lock = "LOCK TABLES `"._RUDWEB_PRE."set_cfg` WRITE";
    mysql_query($query_lock) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // menu
    $modquery = "UPDATE `"._RUDWEB_PRE."set_cfg` SET `set_val` = '".$val."', `set_mdd` = '".$action_date."', `set_mdt` = '".$action_time."', `set_mdu` = '".$_SESSION[_RUDWEB_PRE.'usr_id']."' WHERE `set_set` = '".$set."' LIMIT 1";
    mysql_query($modquery) or require _RUDWEB_LIB_DIR . 'myerr.php';
    // unlock
    $query_unlock = "UNLOCK TABLES";
    mysql_query($query_unlock) or require _RUDWEB_LIB_DIR . 'myerr.php';
  }
}
/* ********** ********** ********** //CHANGE SETTINGS IN THE DATABASE ********** ********** ********** */
/* ********** ********** ********** COMPATIBILITY WITH PHP < 5 ********** ********** ********** */
// STR_SPLIT REPLACEMENT FROM PHP MANUAL USER NOTES
//heavyraptor (10-Mar-2006 10:07)
//I think that the last post by carlosreche at yahoo dot com is too complicated.
//It's much easier if you do it like this:
if (!function_exists("str_split")) {
 function str_split($str,$length = 1) {
   if ($length < 1) return false;
   $strlen = strlen($str);
   $ret = array();
   for ($i = 0; $i < $strlen; $i += $length) {
    $ret[] = substr($str,$i,$length);
   }
   return $ret;
 }
}
//I hope it helps for those with PHP <5
/* ********** ********** ********** //COMPATIBILITY WITH PHP < 5 ********** ********** ********** */
/* ********** ********** ********** NEW DATABASE FUNCTIONS  ********** ********** ********** */
function rudweb_dbopen($db_type, $rudweb_dbhost, $rudweb_dbport, $rudweb_dbuser, $rudweb_dbpass, $rudweb_dbname) {
  switch($db_type) {
    case "my": {
      $rudweb_dbconn = mysql_connect($rudweb_dbhost . ":" . $rudweb_dbport , $rudweb_dbuser, $rudweb_dbpass) or die ("<B>Oups! [" . mysql_errno() . "]: " .mysql_error() . "</B>");
      mysql_select_db($rudweb_dbname) or die ("<B>Oups! [" . mysql_errno() . "]: " .mysql_error() . "</B>");
      break;
    }
    case "pg": {
      global $rudweb_dbhost, $rudweb_dbport, $rudweb_dbuser, $rudweb_dbpass, $rudweb_dbname;
      $rudweb_dbconn = pg_connect("host=" . $rudweb_dbhost . " port=".$rudweb_dbport." dbname=".$rudweb_dbname." user=".$rudweb_dbuser." password=".$rudweb_dbpass."") or die("Oops! Could not connect" . pg_connection_status($rudweb_dbconn));
      break;
    }
    default  : {$rudweb_conn = NULL; break;}
  }
  return $rudweb_dbconn;
}
function rudweb_dbclose($db_type, $rudweb_dbconn) {
  switch($db_type) {
    case "my": {mysql_close($rudweb_dbconn); break;}
    case "pg": {pg_close($rudweb_dbconn); break;}
    default  : {break;}
  }
}
function rudweb_qres($db_type, $query) {
  switch($db_type) {
    case "my": {$result = mysql_query($query) or die("Oops! Query Failed. " . mysql_errno() . " : " . mysql_error()); break;}
    case "pg": {$result = pg_query($query) or die("Oops! Query Failed. " . pg_last_error()); break;}
    default  : {$result = NULL; break;}
  }
  return $result;
}
function rudweb_qtotal($db_type, $result) {
  switch($db_type) {
    case "my": {$total = mysql_num_rows($result); break;}
    case "pg": {$total = pg_num_rows($result); break;}
    default  : {$total = NULL; break;}
  }
  return $total;
}
function rudweb_fetch_assoc($db_type, $result) {
  switch($db_type) {
    case "my": {$row = mysql_fetch_assoc($result); break;}
    case "pg": {$row = pg_fetch_assoc($result); break;}
    default  : {$row = NULL; break;}
  }
  return $row;
}
function rudweb_affected($db_type, $result) {
  switch($db_type) {
    case "my": {$affected = mysql_affected_rows(); break;}
    case "pg": {$affected = pg_affected_rows($result); break;}
    default  : {$affected = NULL; break;}
  }
  return $affected;
}
function rudweb_result($db_type, $result, $row) {
  switch($db_type) {
    case "my": {$res = mysql_result($result, $row); break;}
    case "pg": {$res = NULL; break;}
    default  : {$affected = NULL; break;}
  }
  return $res;
}
/* ********** ********** ********** //NEW DATABASE FUNCTIONS  ********** ********** ********** */
/* ********** ********** ********** FIND OUT NEXT AVAILABLE ID IN A TABLE  ********** ********** ********** */
function getNextId($table_name, $table_cell) {
  global $rudweb_dbtype;
  $next_id_query = "SELECT MAX(".$table_cell.") FROM "._RUDWEB_PRE."".$table_name."";
  $next_id_result = rudweb_qres($rudweb_dbtype, $next_id_query);
  $next_id = rudweb_result($rudweb_dbtype, $next_id_result, 0) + 1;
  return $next_id;
}
/* ********** ********** ********** //FIND OUT NEXT AVAILABLE ID IN A TABLE  ********** ********** ********** */
/* ********** ********** ********** SHOW A MESSAGE  ********** ********** ********** */
function showMsg($type, $msg) { // type= err/ok
  echo '<DIV CLASS="'.$type.'">' . $msg . '</DIV>';
}
/* ********** ********** ********** //SHOW A MESSAGE  ********** ********** ********** */
?>