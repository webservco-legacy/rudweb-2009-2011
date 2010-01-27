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
./setup/cfg/ses.inc.php
14:20 2008-06-25
*/

/* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
// START SESSION
//session_cache_limiter('public, must-revalidate');
session_cache_limiter('nocache');
session_cache_expire(600); //minutes
ini_set("session.gc_maxlifetime","36000"); //seconds
session_start();
//setcookie("PHPSESSID",$_COOKIE['PHPSESSID'],time()+1800);

// for uninstall only
if ($set=='remove' && ($act == 'index' && $step == '1')) {
  $_SESSION['rudwebset_cfg_remove_db_data']      = 'on';
  $_SESSION['rudwebset_cfg_remove_db_tables']    = 'on';
  $_SESSION['rudwebset_cfg_remove_user_files']   = 'off';
  $_SESSION['rudwebset_cfg_remove_engine_files'] = 'on';
}
if(isset($_POST['abort']) || isset($_POST['finish'])) {
  if(isset($_SESSION['rudwebset_start']) && isset($_SESSION['rudwebset_pid'])) {
    unset($_SESSION['rudwebset_start']);
    unset($_SESSION['rudwebset_pid']);
    session_regenerate_id();
    session_destroy();
  }
  else if(!isset($_SESSION['rudwebset_start'])) {
      if(isset($_SESSION['rudwebset_cfg_remove_db_data']))      {unset($_SESSION['rudwebset_cfg_remove_db_data']);}
      if(isset($_SESSION['rudwebset_cfg_remove_db_tables']))    {unset($_SESSION['rudwebset_cfg_remove_db_tables']);}
      if(isset($_SESSION['rudwebset_cfg_remove_user_files']))   {unset($_SESSION['rudwebset_cfg_remove_user_files']);}
      if(isset($_SESSION['rudwebset_cfg_remove_engine_files'])) {unset($_SESSION['rudwebset_cfg_remove_engine_files']);}
  }
  $redirect = "./setup.php";
  header("Location: $redirect");
  exit;
}
if(isset($_GET['act']) && isset($_GET['step'])) {
  if ($_GET['act']=='start' && $_GET['step']=='1') {
    if(isset($_GET['pid'])) {
      unset($_SESSION['rudwebset_pid']);
      unset($_SESSION['rudwebset_start']);
      session_regenerate_id();
      session_destroy();
      $pid = $_GET['pid'];
      $redirect = "./setup.php?pid=$pid&set=$set&act=index&step=$step";
      header("Location: $redirect");
      exit;
    }
  }
}
if (isset($_POST['proceed']) && !isset($_SESSION['rudwebset_start'])) {
  session_regenerate_id();
  $_SESSION['rudwebset_pid']                     = null;
  if(isset($_GET['pid']))                       {$_SESSION['rudwebset_pid'] = $_GET['pid'];}
  $_SESSION['rudwebset_date']                    = date("Y-m-d");
  $_SESSION['rudwebset_start']                   = true;
  
  $_SESSION['rudwebset_set_site_url1']           = null;
  $_SESSION['rudwebset_set_site_url2']           = 'http://www.example.com/';
  $_SESSION['rudwebset_set_site_root1']          = null;
  $_SESSION['rudwebset_set_site_root2']          = '/var/www/html/';

  $_SESSION['rudwebset_set_dbmy']                = null;
  $_SESSION['rudwebset_set_dbtype']              = 'na';
  $_SESSION['rudwebset_set_dbhost']              = 'localhost';
  $_SESSION['rudwebset_set_dbport']              = '3306';
  $_SESSION['rudwebset_set_dbport_my']           = '3306';
  $_SESSION['rudwebset_set_dbport_pg']           = '5432';
  $_SESSION['rudwebset_set_dbuser']              = 'user';
  $_SESSION['rudwebset_set_dbpass']              = 'password';
  $_SESSION['rudwebset_set_dbname']              = 'database';
  
  $_SESSION['rudwebset_set_rewrite']             = null;
  $_SESSION['rudwebset_set_index']               = null;
  
  $_SESSION['rudwebset_set_pre']                 = '';

  $_SESSION['rudwebset_set_dbcfg']               = '1';
  $_SESSION['rudwebset_set_dbskin']              = '0';
  
  $_SESSION['rudwebset_cfg_start']               = $_SESSION['rudwebset_date'];
  
  $_SESSION['rudwebset_cfg_clcom']               = 'Client Company';
  $_SESSION['rudwebset_cfg_clnam']               = 'Client Contact Person';
  $_SESSION['rudwebset_cfg_dvcom']               = 'Developer Company';
  $_SESSION['rudwebset_cfg_dvurl']               = 'http://www.example.com';
  $_SESSION['rudwebset_cfg_dvnam']               = 'Developer Contact Person';
  $_SESSION['rudwebset_cfg_desig']               = 'Developer Contact person';
  $_SESSION['rudwebset_cfg_publ']                = 'Developer Company';
  $_SESSION['rudwebset_cfg_ratng']               = 'General';
  $_SESSION['rudwebset_cfg_distr']               = 'Global';
  $_SESSION['rudwebset_cfg_robots']              = 'Index, Follow';
  $_SESSION['rudwebset_cfg_prag']                = 'no-cache';
  $_SESSION['rudwebset_cfg_exp']                 = '0';
  $_SESSION['rudwebset_cfg_cache']               = 'no-cache';
  
  $_SESSION['rudwebset_cfg_lang']                = 'en';
  $_SESSION['rudwebset_cfg_skin']               = 'rudskin';
  
  $_SESSION['rudwebset_cfg_cnt_en']              = 'default';
  $_SESSION['rudwebset_cfg_cnt_de']              = 'default';
  $_SESSION['rudwebset_cfg_cnt_es']              = 'default';
  $_SESSION['rudwebset_cfg_cnt_fr']              = 'default';
  $_SESSION['rudwebset_cfg_cnt_it']              = 'default';
  $_SESSION['rudwebset_cfg_cnt_ro']              = 'default';
  
  $_SESSION['rudwebset_cfg_cnt_shw']             = '0';
  $_SESSION['rudwebset_cfg_lang_on']             = '1';
  $_SESSION['rudwebset_cfg_usr_on']              = '1';
  $_SESSION['rudwebset_cfg_skin_on']             = '1';
  $_SESSION['rudwebset_cfg_cat']                 = '1';
  $_SESSION['rudwebset_cfg_cat_ipg']             = '10';
  $_SESSION['rudwebset_cfg_cat_pcs']             = '1';
  $_SESSION['rudwebset_cfg_cat_flt']             = '1';
  $_SESSION['rudwebset_cfg_cart_on']             = '0';
  $_SESSION['rudwebset_cfg_csp_on']              = '1';
  $_SESSION['rudwebset_cfg_csp_lmt']             = '3';
  $_SESSION['rudwebset_cfg_stats_on']            = '1';
  $_SESSION['rudwebset_cfg_stats_ip']            = '86.123.192.163, 80.96.77.225';
  $_SESSION['rudwebset_cfg_ftr_on']              = '1';
  $_SESSION['rudwebset_cfg_ftr_lmt']             = '3';
  $_SESSION['rudwebset_cfg_timer']               = '1';
  $_SESSION['rudwebset_cfg_debug']               = '1';
  $_SESSION['rudwebset_cfg_cpy']                 = '1';
  $_SESSION['rudwebset_cfg_cpydev']              = '1';
  $_SESSION['rudwebset_cfg_smap']                = '0';
  $_SESSION['rudwebset_cfg_yah']                 = '0';
  $_SESSION['rudwebset_cfg_nws']                 = '1';
  $_SESSION['rudwebset_cfg_nws_lmt1']            = '3';
  $_SESSION['rudwebset_cfg_nws_lmt2']            = '5';
  $_SESSION['rudwebset_cfg_src']                 = '0';
  $_SESSION['rudwebset_cfg_con']                 = '1';
  
  $_SESSION['rudwebset_cfg_pics_0']              = '0';
  $_SESSION['rudwebset_cfg_pics_1']              = '1';
  $_SESSION['rudwebset_cfg_pics_2']              = '1';
  $_SESSION['rudwebset_cfg_pics_3']              = '1';
  $_SESSION['rudwebset_cfg_pics_4']              = '1';
  
  $_SESSION['rudwebset_cfg_cnt_posted']          = '0';
  $_SESSION['rudwebset_cfg_cnt_tags']            = '0';
  $_SESSION['rudwebset_cfg_cnt_cmnts']           = '0';
  $_SESSION['rudwebset_cfg_cnt_lnks']            = '0';
  $_SESSION['rudwebset_cfg_cnt_dlds']            = '0';
  
  $_SESSION['rudwebset_cfg_adm']                 = '1';
  $_SESSION['rudwebset_cfg_adm_fname']           = '';
  $_SESSION['rudwebset_cfg_adm_mname']           = '';
  $_SESSION['rudwebset_cfg_adm_lname']           = '';
  $_SESSION['rudwebset_cfg_adm_mail']            = '';
  $_SESSION['rudwebset_cfg_adm_pass']            = '';
  
  $_SESSION['rudwebset_cfg_ln_inst']['en']       = 'on';
  $_SESSION['rudwebset_cfg_ln_inst']['de']       = 'off';
  $_SESSION['rudwebset_cfg_ln_inst']['es']       = 'off';
  $_SESSION['rudwebset_cfg_ln_inst']['fr']       = 'off';
  $_SESSION['rudwebset_cfg_ln_inst']['it']       = 'off';
  $_SESSION['rudwebset_cfg_ln_inst']['ro']       = 'off';
  
  $_SESSION['rudwebset_cfg_ln_cfg']['en']        = 'on';
  $_SESSION['rudwebset_cfg_ln_cfg']['de']        = 'off';
  $_SESSION['rudwebset_cfg_ln_cfg']['es']        = 'off';
  $_SESSION['rudwebset_cfg_ln_cfg']['fr']        = 'off';
  $_SESSION['rudwebset_cfg_ln_cfg']['it']        = 'off';
  $_SESSION['rudwebset_cfg_ln_cfg']['ro']        = 'off';
  
  $_SESSION['rudwebset_langs_wstt']['en']        = 'Website Title en';
  $_SESSION['rudwebset_langs_wstt']['de']        = 'Website Title de';
  $_SESSION['rudwebset_langs_wstt']['es']        = 'Website Title es';
  $_SESSION['rudwebset_langs_wstt']['fr']        = 'Website Title fr';
  $_SESSION['rudwebset_langs_wstt']['it']        = 'Website Title it';
  $_SESSION['rudwebset_langs_wstt']['ro']        = 'Website Title ro';
  
  $_SESSION['rudwebset_langs_wsds']['en']        = 'Website Description en';
  $_SESSION['rudwebset_langs_wsds']['de']        = 'Website Description de';
  $_SESSION['rudwebset_langs_wsds']['es']        = 'Website Description es';
  $_SESSION['rudwebset_langs_wsds']['fr']        = 'Website Description fr';
  $_SESSION['rudwebset_langs_wsds']['it']        = 'Website Description it';
  $_SESSION['rudwebset_langs_wsds']['ro']        = 'Website Description ro';
  
  $_SESSION['rudwebset_langs_wskw']['en']        = 'Website Keywords en';
  $_SESSION['rudwebset_langs_wskw']['de']        = 'Website Keywords de';
  $_SESSION['rudwebset_langs_wskw']['es']        = 'Website Keywords es';
  $_SESSION['rudwebset_langs_wskw']['fr']        = 'Website Keywords fr';
  $_SESSION['rudwebset_langs_wskw']['it']        = 'Website Keywords it';
  $_SESSION['rudwebset_langs_wskw']['ro']        = 'Website Keywords ro';
  
  $_SESSION['rudwebset_langs_ftt']['en']         = 'Featured Content en';
  $_SESSION['rudwebset_langs_ftt']['de']         = 'Featured Content de';
  $_SESSION['rudwebset_langs_ftt']['es']         = 'Featured Content es';
  $_SESSION['rudwebset_langs_ftt']['fr']         = 'Featured Content fr';
  $_SESSION['rudwebset_langs_ftt']['it']         = 'Featured Content it';
  $_SESSION['rudwebset_langs_ftt']['ro']         = 'Featured Content ro';

  $_SESSION['rudwebset_langs_fds']['en']         = 'details ... en';
  $_SESSION['rudwebset_langs_fds']['de']         = 'details ... de';
  $_SESSION['rudwebset_langs_fds']['es']         = 'details ... es';
  $_SESSION['rudwebset_langs_fds']['fr']         = 'details ... fr';
  $_SESSION['rudwebset_langs_fds']['it']         = 'details ... it';
  $_SESSION['rudwebset_langs_fds']['ro']         = 'details ... ro';
  
  $_SESSION['rudwebset_langs_catalog']['en']     = 'Catalog en';
  $_SESSION['rudwebset_langs_catalog']['de']     = 'Catalog de';
  $_SESSION['rudwebset_langs_catalog']['es']     = 'Catalog es';
  $_SESSION['rudwebset_langs_catalog']['fr']     = 'Catalog fr';
  $_SESSION['rudwebset_langs_catalog']['it']     = 'Catalog it';
  $_SESSION['rudwebset_langs_catalog']['ro']     = 'Catalog ro';
  
  $_SESSION['rudwebset_langs_cattt']['en']       = 'Categories en';
  $_SESSION['rudwebset_langs_cattt']['de']       = 'Categories de';
  $_SESSION['rudwebset_langs_cattt']['es']       = 'Categories es';
  $_SESSION['rudwebset_langs_cattt']['fr']       = 'Categories fr';
  $_SESSION['rudwebset_langs_cattt']['it']       = 'Categories it';
  $_SESSION['rudwebset_langs_cattt']['ro']       = 'Categories ro';
  
  $_SESSION['rudwebset_langs_itemstt']['en']     = 'Items en';
  $_SESSION['rudwebset_langs_itemstt']['de']     = 'Items de';
  $_SESSION['rudwebset_langs_itemstt']['es']     = 'Items es';
  $_SESSION['rudwebset_langs_itemstt']['fr']     = 'Items fr';
  $_SESSION['rudwebset_langs_itemstt']['it']     = 'Items it';
  $_SESSION['rudwebset_langs_itemstt']['ro']     = 'Items ro';
  
  $_SESSION['rudwebset_langs_itemtt']['en']     = 'Item Details en';
  $_SESSION['rudwebset_langs_itemtt']['de']     = 'Item Details de';
  $_SESSION['rudwebset_langs_itemtt']['es']     = 'Item Details es';
  $_SESSION['rudwebset_langs_itemtt']['fr']     = 'Item Details fr';
  $_SESSION['rudwebset_langs_itemtt']['it']     = 'Item Details it';
  $_SESSION['rudwebset_langs_itemtt']['ro']     = 'Item Details ro';
  
  $_SESSION['rudwebset_langs_csp']['en']        = 'Special Offers en';
  $_SESSION['rudwebset_langs_csp']['de']        = 'Special Offers de';
  $_SESSION['rudwebset_langs_csp']['es']        = 'Special Offers es';
  $_SESSION['rudwebset_langs_csp']['fr']        = 'Special Offers fr';
  $_SESSION['rudwebset_langs_csp']['it']        = 'Special Offers it';
  $_SESSION['rudwebset_langs_csp']['ro']        = 'Special Offers ro';
  
  $_SESSION['rudwebset_langs_cat_pid']['en']     = 'No. en';
  $_SESSION['rudwebset_langs_cat_pid']['de']     = 'No. de';
  $_SESSION['rudwebset_langs_cat_pid']['es']     = 'No. es';
  $_SESSION['rudwebset_langs_cat_pid']['fr']     = 'No. fr';
  $_SESSION['rudwebset_langs_cat_pid']['it']     = 'No. it';
  $_SESSION['rudwebset_langs_cat_pid']['ro']     = 'No. ro';
  
  $_SESSION['rudwebset_langs_cat_ppic']['en']    = 'Picture en';
  $_SESSION['rudwebset_langs_cat_ppic']['de']    = 'Picture de';
  $_SESSION['rudwebset_langs_cat_ppic']['es']    = 'Picture es';
  $_SESSION['rudwebset_langs_cat_ppic']['fr']    = 'Picture fr';
  $_SESSION['rudwebset_langs_cat_ppic']['it']    = 'Picture it';
  $_SESSION['rudwebset_langs_cat_ppic']['ro']    = 'Picture ro';
  
  $_SESSION['rudwebset_langs_cat_pname']['en']   = 'Name en';
  $_SESSION['rudwebset_langs_cat_pname']['de']   = 'Name de';
  $_SESSION['rudwebset_langs_cat_pname']['es']   = 'Name es';
  $_SESSION['rudwebset_langs_cat_pname']['fr']   = 'Name fr';
  $_SESSION['rudwebset_langs_cat_pname']['it']   = 'Name it';
  $_SESSION['rudwebset_langs_cat_pname']['ro']   = 'Name ro';
  
  $_SESSION['rudwebset_langs_cat_prd_dsc']['en'] = 'Description en';
  $_SESSION['rudwebset_langs_cat_prd_dsc']['de'] = 'Description de';
  $_SESSION['rudwebset_langs_cat_prd_dsc']['es'] = 'Description es';
  $_SESSION['rudwebset_langs_cat_prd_dsc']['fr'] = 'Description fr';
  $_SESSION['rudwebset_langs_cat_prd_dsc']['it'] = 'Description it';
  $_SESSION['rudwebset_langs_cat_prd_dsc']['ro'] = 'Description ro';
  
  $_SESSION['rudwebset_langs_cat_pprice']['en']  = 'Price en';
  $_SESSION['rudwebset_langs_cat_pprice']['de']  = 'Price de';
  $_SESSION['rudwebset_langs_cat_pprice']['es']  = 'Price es';
  $_SESSION['rudwebset_langs_cat_pprice']['fr']  = 'Price fr';
  $_SESSION['rudwebset_langs_cat_pprice']['it']  = 'Price it';
  $_SESSION['rudwebset_langs_cat_pprice']['ro']  = 'Price ro';
  
  $_SESSION['rudwebset_cfg_dbs_01']              = 'on';
  $_SESSION['rudwebset_cfg_dbs_02']              = 'off';
}
if(isset($_POST['set_dbmy']))                {$_SESSION['rudwebset_set_dbmy']                = $_POST['set_dbmy'];}
if(isset($_POST['set_dbtype']))              {$_SESSION['rudwebset_set_dbtype']              = $_POST['set_dbtype'];}
if(isset($_POST['set_dbhost']))              {$_SESSION['rudwebset_set_dbhost']              = $_POST['set_dbhost'];}
if(isset($_POST['set_dbport']))              {$_SESSION['rudwebset_set_dbport']              = $_POST['set_dbport'];}
if(isset($_POST['set_dbport_my']))           {$_SESSION['rudwebset_set_dbport_my']           = $_POST['set_dbport_my'];}
if(isset($_POST['set_dbport_pg']))           {$_SESSION['rudwebset_set_dbport_pg']           = $_POST['set_dbport_pg'];}
if(isset($_POST['set_dbuser']))              {$_SESSION['rudwebset_set_dbuser']              = $_POST['set_dbuser'];}
if(isset($_POST['set_dbpass']))              {$_SESSION['rudwebset_set_dbpass']              = $_POST['set_dbpass'];}
if(isset($_POST['set_dbname']))              {
                                              $_SESSION['rudwebset_set_dbname']              = $_POST['set_dbname'];
                                              $_SESSION['rudwebset_set_pre']                 = $_POST['set_dbname'];
}

if(isset($_POST['set_site_url1']))           {$_SESSION['rudwebset_set_site_url1']           = $_POST['set_site_url1'];}
if(isset($_POST['set_site_url2']))           {$_SESSION['rudwebset_set_site_url2']           = $_POST['set_site_url2'];}
if(isset($_POST['set_site_root1']))          {$_SESSION['rudwebset_set_site_root1']          = $_POST['set_site_root1'];}
if(isset($_POST['set_site_root2']))          {$_SESSION['rudwebset_set_site_root2']          = $_POST['set_site_root2'];}
if(isset($_POST['set_dbcfg']))               {$_SESSION['rudwebset_set_dbcfg']               = $_POST['set_dbcfg'];}
if(isset($_POST['set_dbskin']))              {$_SESSION['rudwebset_set_dbskin']              = $_POST['set_dbskin'];}
if(isset($_POST['set_pre']))                 {$_SESSION['rudwebset_set_pre']                 = $_POST['set_pre'];}
if(isset($_POST['set_index']))               {$_SESSION['rudwebset_set_index']               = $_POST['set_index'];}

if(isset($_POST['cfg_start']))               {$_SESSION['rudwebset_cfg_start']               = $_POST['cfg_start'];}
if(isset($_POST['cfg_clcom']))               {$_SESSION['rudwebset_cfg_clcom']               = $_POST['cfg_clcom'];}
if(isset($_POST['cfg_clnam']))               {$_SESSION['rudwebset_cfg_clnam']               = $_POST['cfg_clnam'];}
if(isset($_POST['cfg_dvcom']))               {$_SESSION['rudwebset_cfg_dvcom']               = $_POST['cfg_dvcom'];}
if(isset($_POST['cfg_dvurl']))               {$_SESSION['rudwebset_cfg_dvurl']               = $_POST['cfg_dvurl'];}
if(isset($_POST['cfg_dvnam']))               {$_SESSION['rudwebset_cfg_dvnam']               = $_POST['cfg_dvnam'];}
if(isset($_POST['cfg_desig']))               {$_SESSION['rudwebset_cfg_desig']               = $_POST['cfg_desig'];}
if(isset($_POST['cfg_publ']))                {$_SESSION['rudwebset_cfg_publ']                = $_POST['cfg_publ'];}
if(isset($_POST['cfg_ratng']))               {$_SESSION['rudwebset_cfg_ratng']               = $_POST['cfg_ratng'];}
if(isset($_POST['cfg_distr']))               {$_SESSION['rudwebset_cfg_distr']               = $_POST['cfg_distr'];}
if(isset($_POST['cfg_robots']))              {$_SESSION['rudwebset_cfg_robots']              = $_POST['cfg_robots'];}
if(isset($_POST['cfg_prag']))                {$_SESSION['rudwebset_cfg_prag']                = $_POST['cfg_prag'];}
if(isset($_POST['cfg_exp']))                 {$_SESSION['rudwebset_cfg_exp']                 = $_POST['cfg_exp'];}
if(isset($_POST['cfg_cache']))               {$_SESSION['rudwebset_cfg_cache']               = $_POST['cfg_cache'];}

if(isset($_POST['cfg_lang']))                {$_SESSION['rudwebset_cfg_lang']                = $_POST['cfg_lang'];}
if(isset($_POST['cfg_skin']))                {$_SESSION['rudwebset_cfg_skin']                = $_POST['cfg_skin'];}

if(isset($_POST['cfg_cnt_en']))              {$_SESSION['rudwebset_cfg_cnt_en']              = $_POST['cfg_cnt_en'];}
if(isset($_POST['cfg_cnt_de']))              {$_SESSION['rudwebset_cfg_cnt_de']              = $_POST['cfg_cnt_de'];}
if(isset($_POST['cfg_cnt_es']))              {$_SESSION['rudwebset_cfg_cnt_es']              = $_POST['cfg_cnt_es'];}
if(isset($_POST['cfg_cnt_fr']))              {$_SESSION['rudwebset_cfg_cnt_fr']              = $_POST['cfg_cnt_fr'];}
if(isset($_POST['cfg_cnt_it']))              {$_SESSION['rudwebset_cfg_cnt_it']              = $_POST['cfg_cnt_it'];}
if(isset($_POST['cfg_cnt_ro']))              {$_SESSION['rudwebset_cfg_cnt_ro']              = $_POST['cfg_cnt_ro'];}
if(isset($_POST['cfg_cnt_shw']))             {$_SESSION['rudwebset_cfg_cnt_shw']             = $_POST['cfg_cnt_shw'];}

if(isset($_POST['cfg_lang_on']))             {$_SESSION['rudwebset_cfg_lang_on']             = $_POST['cfg_lang_on'];}
if(isset($_POST['cfg_usr_on']))              {$_SESSION['rudwebset_cfg_usr_on']              = $_POST['cfg_usr_on'];}
if(isset($_POST['cfg_skin_on']))             {$_SESSION['rudwebset_cfg_skin_on']             = $_POST['cfg_skin_on'];}
if(isset($_POST['cfg_cat']))                 {$_SESSION['rudwebset_cfg_cat']                 = $_POST['cfg_cat'];}
if(isset($_POST['cfg_cat_ipg']))             {$_SESSION['rudwebset_cfg_cat_ipg']             = $_POST['cfg_cat_ipg'];}
if(isset($_POST['cfg_cat_pcs']))             {$_SESSION['rudwebset_cfg_cat_pcs']             = $_POST['cfg_cat_pcs'];}
if(isset($_POST['cfg_cat_flt']))             {$_SESSION['rudwebset_cfg_cat_flt']             = $_POST['cfg_cat_flt'];}
if(isset($_POST['cfg_cart_on']))             {$_SESSION['rudwebset_cfg_cart_on']             = $_POST['cfg_cart_on'];}
if(isset($_POST['cfg_csp_on']))              {$_SESSION['rudwebset_cfg_csp_on']              = $_POST['cfg_csp_on'];}
if(isset($_POST['cfg_csp_lmt']))             {$_SESSION['rudwebset_cfg_csp_lmt']             = $_POST['cfg_csp_lmt'];}
if(isset($_POST['cfg_stats_on']))            {$_SESSION['rudwebset_cfg_stats_on']            = $_POST['cfg_stats_on'];}
if(isset($_POST['cfg_stats_ip']))            {$_SESSION['rudwebset_cfg_stats_ip']            = $_POST['cfg_stats_ip'];}
if(isset($_POST['cfg_ftr_on']))              {$_SESSION['rudwebset_cfg_ftr_on']              = $_POST['cfg_ftr_on'];}
if(isset($_POST['cfg_ftr_lmt']))             {$_SESSION['rudwebset_cfg_ftr_lmt']             = $_POST['cfg_ftr_lmt'];}
if(isset($_POST['cfg_timer']))               {$_SESSION['rudwebset_cfg_timer']               = $_POST['cfg_timer'];}
if(isset($_POST['cfg_debug']))               {$_SESSION['rudwebset_cfg_debug']               = $_POST['cfg_debug'];}
if(isset($_POST['cfg_cpy']))                 {$_SESSION['rudwebset_cfg_cpy']                 = $_POST['cfg_cpy'];}
if(isset($_POST['cfg_cpydev']))              {$_SESSION['rudwebset_cfg_cpydev']              = $_POST['cfg_cpydev'];}
if(isset($_POST['cfg_smap']))                {$_SESSION['rudwebset_cfg_smap']                = $_POST['cfg_smap'];}
if(isset($_POST['cfg_yah']))                 {$_SESSION['rudwebset_cfg_yah']                 = $_POST['cfg_yah'];}
if(isset($_POST['cfg_nws']))                 {$_SESSION['rudwebset_cfg_nws']                 = $_POST['cfg_nws'];}
if(isset($_POST['cfg_nws_lmt1']))            {$_SESSION['rudwebset_cfg_nws_lmt1']            = $_POST['cfg_nws_lmt1'];}
if(isset($_POST['cfg_nws_lmt2']))            {$_SESSION['rudwebset_cfg_nws_lmt2']            = $_POST['cfg_nws_lmt2'];}
if(isset($_POST['cfg_src']))                 {$_SESSION['rudwebset_cfg_src']                 = $_POST['cfg_src'];}
if(isset($_POST['cfg_con']))                 {$_SESSION['rudwebset_cfg_con']                 = $_POST['cfg_con'];}

if(isset($_POST['cfg_ftr_pics_0']))          {$_SESSION['rudwebset_cfg_pics_0']              = $_POST['cfg_pics_0'];}
if(isset($_POST['cfg_ftr_pics_1']))          {$_SESSION['rudwebset_cfg_pics_1']              = $_POST['cfg_pics_1'];}
if(isset($_POST['cfg_ftr_pics_2']))          {$_SESSION['rudwebset_cfg_pics_2']              = $_POST['cfg_pics_2'];}
if(isset($_POST['cfg_ftr_pics_3']))          {$_SESSION['rudwebset_cfg_pics_3']              = $_POST['cfg_pics_3'];}
if(isset($_POST['cfg_ftr_pics_4']))          {$_SESSION['rudwebset_cfg_pics_4']              = $_POST['cfg_pics_4'];}

if(isset($_POST['cfg_cnt_posted']))          {$_SESSION['rudwebset_cfg_cnt_posted']          = $_POST['cfg_cnt_posted'];}
if(isset($_POST['cfg_cnt_tags']))            {$_SESSION['rudwebset_cfg_cnt_tags']            = $_POST['cfg_cnt_tags'];}
if(isset($_POST['cfg_cnt_cmnts']))           {$_SESSION['rudwebset_cfg_cnt_cmnts']           = $_POST['cfg_cnt_cmnts'];}
if(isset($_POST['cfg_cnt_lnks']))            {$_SESSION['rudwebset_cfg_cnt_lnks']            = $_POST['cfg_cnt_lnks'];}
if(isset($_POST['cfg_cnt_dlds']))            {$_SESSION['rudwebset_cfg_cnt_dlds']            = $_POST['cfg_cnt_dlds'];}
  
if(isset($_POST['cfg_adm']))                 {$_SESSION['rudwebset_cfg_adm']                 = $_POST['cfg_adm'];}
if(isset($_POST['cfg_adm_fname']))           {$_SESSION['rudwebset_cfg_adm_fname']           = $_POST['cfg_adm_fname'];}
if(isset($_POST['cfg_adm_mname']))           {$_SESSION['rudwebset_cfg_adm_mname']           = $_POST['cfg_adm_mname'];}
if(isset($_POST['cfg_adm_lname']))           {$_SESSION['rudwebset_cfg_adm_lname']           = $_POST['cfg_adm_lname'];}
if(isset($_POST['cfg_adm_mail']))            {$_SESSION['rudwebset_cfg_adm_mail']            = $_POST['cfg_adm_mail'];}
if(isset($_POST['cfg_adm_pass']))            {$_SESSION['rudwebset_cfg_adm_pass']            = $_POST['cfg_adm_pass'];}

if(isset($_POST['set_cfg_ln_inst']['en']))                                                  {$_SESSION['rudwebset_cfg_ln_inst']['en'] = $_POST['set_cfg_ln_inst']['en'];}
else if(!isset($_POST['set_cfg_ln_inst']['en']) && isset($_POST['langs_wstt']['en']))       {$_SESSION['rudwebset_cfg_ln_inst']['en'] = 'off';}
if(isset($_POST['set_cfg_ln_inst']['de']))                                                  {$_SESSION['rudwebset_cfg_ln_inst']['de'] = $_POST['set_cfg_ln_inst']['de'];}
else if(!isset($_POST['set_cfg_ln_inst']['de']) && isset($_POST['langs_wstt']['de']))       {$_SESSION['rudwebset_cfg_ln_inst']['de'] = 'off';}
if(isset($_POST['set_cfg_ln_inst']['es']))                                                  {$_SESSION['rudwebset_cfg_ln_inst']['es'] = $_POST['set_cfg_ln_inst']['es'];}
else if(!isset($_POST['set_cfg_ln_inst']['es']) && isset($_POST['langs_wstt']['es']))       {$_SESSION['rudwebset_cfg_ln_inst']['es'] = 'off';}
if(isset($_POST['set_cfg_ln_inst']['fr']))                                                  {$_SESSION['rudwebset_cfg_ln_inst']['fr'] = $_POST['set_cfg_ln_inst']['fr'];}
else if(!isset($_POST['set_cfg_ln_inst']['fr']) && isset($_POST['langs_wstt']['fr']))       {$_SESSION['rudwebset_cfg_ln_inst']['fr'] = 'off';}
if(isset($_POST['set_cfg_ln_inst']['it']))                                                  {$_SESSION['rudwebset_cfg_ln_inst']['it'] = $_POST['set_cfg_ln_inst']['it'];}
else if(!isset($_POST['set_cfg_ln_inst']['it']) && isset($_POST['langs_wstt']['it']))       {$_SESSION['rudwebset_cfg_ln_inst']['it'] = 'off';}
if(isset($_POST['set_cfg_ln_inst']['ro']))                                                  {$_SESSION['rudwebset_cfg_ln_inst']['ro'] = $_POST['set_cfg_ln_inst']['ro'];}
else if(!isset($_POST['set_cfg_ln_inst']['ro']) && isset($_POST['langs_wstt']['ro']))       {$_SESSION['rudwebset_cfg_ln_inst']['ro'] = 'off';}

if(isset($_POST['set_cfg_ln_cfg']['en']))                                                   {$_SESSION['rudwebset_cfg_ln_cfg']['en'] = $_POST['set_cfg_ln_cfg']['en'];}
else if(!isset($_POST['set_cfg_ln_cfg']['en']) && isset($_POST['langs_wstt']['en']))        {$_SESSION['rudwebset_cfg_ln_cfg']['en'] = 'off';}
if(isset($_POST['set_cfg_ln_cfg']['de']))                                                   {$_SESSION['rudwebset_cfg_ln_cfg']['de'] = $_POST['set_cfg_ln_cfg']['de'];}
else if(!isset($_POST['set_cfg_ln_cfg']['de']) && isset($_POST['langs_wstt']['de']))        {$_SESSION['rudwebset_cfg_ln_cfg']['de'] = 'off';}
if(isset($_POST['set_cfg_ln_cfg']['es']))                                                   {$_SESSION['rudwebset_cfg_ln_cfg']['es'] = $_POST['set_cfg_ln_cfg']['es'];}
else if(!isset($_POST['set_cfg_ln_cfg']['es']) && isset($_POST['langs_wstt']['es']))        {$_SESSION['rudwebset_cfg_ln_cfg']['es'] = 'off';}
if(isset($_POST['set_cfg_ln_cfg']['fr']))                                                   {$_SESSION['rudwebset_cfg_ln_cfg']['fr'] = $_POST['set_cfg_ln_cfg']['fr'];}
else if(!isset($_POST['set_cfg_ln_cfg']['fr']) && isset($_POST['langs_wstt']['fr']))        {$_SESSION['rudwebset_cfg_ln_cfg']['fr'] = 'off';}
if(isset($_POST['set_cfg_ln_cfg']['it']))                                                   {$_SESSION['rudwebset_cfg_ln_cfg']['it'] = $_POST['set_cfg_ln_cfg']['it'];}
else if(!isset($_POST['set_cfg_ln_cfg']['it']) && isset($_POST['langs_wstt']['it']))        {$_SESSION['rudwebset_cfg_ln_cfg']['it'] = 'off';}
if(isset($_POST['set_cfg_ln_cfg']['ro']))                                                   {$_SESSION['rudwebset_cfg_ln_cfg']['ro'] = $_POST['set_cfg_ln_cfg']['ro'];}
else if(!isset($_POST['set_cfg_ln_cfg']['ro']) && isset($_POST['langs_wstt']['ro']))        {$_SESSION['rudwebset_cfg_ln_cfg']['ro'] = 'off';}

if(isset($_POST['langs_wstt']['en']))        {$_SESSION['rudwebset_langs_wstt']['en']        = $_POST['langs_wstt']['en'];}
if(isset($_POST['langs_wstt']['de']))        {$_SESSION['rudwebset_langs_wstt']['de']        = $_POST['langs_wstt']['de'];}
if(isset($_POST['langs_wstt']['es']))        {$_SESSION['rudwebset_langs_wstt']['es']        = $_POST['langs_wstt']['es'];}
if(isset($_POST['langs_wstt']['fr']))        {$_SESSION['rudwebset_langs_wstt']['fr']        = $_POST['langs_wstt']['fr'];}
if(isset($_POST['langs_wstt']['it']))        {$_SESSION['rudwebset_langs_wstt']['it']        = $_POST['langs_wstt']['it'];}
if(isset($_POST['langs_wstt']['ro']))        {$_SESSION['rudwebset_langs_wstt']['ro']        = $_POST['langs_wstt']['ro'];}

if(isset($_POST['langs_wsds']['en']))        {$_SESSION['rudwebset_langs_wsds']['en']        = $_POST['langs_wsds']['en'];}
if(isset($_POST['langs_wsds']['de']))        {$_SESSION['rudwebset_langs_wsds']['de']        = $_POST['langs_wsds']['de'];}
if(isset($_POST['langs_wsds']['es']))        {$_SESSION['rudwebset_langs_wsds']['es']        = $_POST['langs_wsds']['es'];}
if(isset($_POST['langs_wsds']['fr']))        {$_SESSION['rudwebset_langs_wsds']['fr']        = $_POST['langs_wsds']['fr'];}
if(isset($_POST['langs_wsds']['it']))        {$_SESSION['rudwebset_langs_wsds']['it']        = $_POST['langs_wsds']['it'];}
if(isset($_POST['langs_wsds']['ro']))        {$_SESSION['rudwebset_langs_wsds']['ro']        = $_POST['langs_wsds']['ro'];}

if(isset($_POST['langs_wskw']['en']))        {$_SESSION['rudwebset_langs_wskw']['en']        = $_POST['langs_wskw']['en'];}
if(isset($_POST['langs_wskw']['de']))        {$_SESSION['rudwebset_langs_wskw']['de']        = $_POST['langs_wskw']['de'];}
if(isset($_POST['langs_wskw']['es']))        {$_SESSION['rudwebset_langs_wskw']['es']        = $_POST['langs_wskw']['es'];}
if(isset($_POST['langs_wskw']['fr']))        {$_SESSION['rudwebset_langs_wskw']['fr']        = $_POST['langs_wskw']['fr'];}
if(isset($_POST['langs_wskw']['it']))        {$_SESSION['rudwebset_langs_wskw']['it']        = $_POST['langs_wskw']['it'];}
if(isset($_POST['langs_wskw']['ro']))        {$_SESSION['rudwebset_langs_wskw']['ro']        = $_POST['langs_wskw']['ro'];}
  
if(isset($_POST['langs_ftt']['en']))         {$_SESSION['rudwebset_langs_ftt']['en']         = $_POST['langs_ftt']['en'];}
if(isset($_POST['langs_ftt']['de']))         {$_SESSION['rudwebset_langs_ftt']['de']         = $_POST['langs_ftt']['de'];}
if(isset($_POST['langs_ftt']['es']))         {$_SESSION['rudwebset_langs_ftt']['es']         = $_POST['langs_ftt']['es'];}
if(isset($_POST['langs_ftt']['fr']))         {$_SESSION['rudwebset_langs_ftt']['fr']         = $_POST['langs_ftt']['fr'];}
if(isset($_POST['langs_ftt']['it']))         {$_SESSION['rudwebset_langs_ftt']['it']         = $_POST['langs_ftt']['it'];}
if(isset($_POST['langs_ftt']['ro']))         {$_SESSION['rudwebset_langs_ftt']['ro']         = $_POST['langs_ftt']['ro'];}

if(isset($_POST['langs_fds']['en']))         {$_SESSION['rudwebset_langs_fds']['en']         = $_POST['langs_fds']['en'];}
if(isset($_POST['langs_fds']['de']))         {$_SESSION['rudwebset_langs_fds']['de']         = $_POST['langs_fds']['de'];}
if(isset($_POST['langs_fds']['es']))         {$_SESSION['rudwebset_langs_fds']['es']         = $_POST['langs_fds']['es'];}
if(isset($_POST['langs_fds']['fr']))         {$_SESSION['rudwebset_langs_fds']['fr']         = $_POST['langs_fds']['fr'];}
if(isset($_POST['langs_fds']['it']))         {$_SESSION['rudwebset_langs_fds']['it']         = $_POST['langs_fds']['it'];}
if(isset($_POST['langs_fds']['ro']))         {$_SESSION['rudwebset_langs_fds']['ro']         = $_POST['langs_fds']['ro'];}

if(isset($_POST['langs_catalog']['en']))     {$_SESSION['rudwebset_langs_catalog']['en']     = $_POST['langs_catalog']['en'];}
if(isset($_POST['langs_catalog']['de']))     {$_SESSION['rudwebset_langs_catalog']['de']     = $_POST['langs_catalog']['de'];}
if(isset($_POST['langs_catalog']['es']))     {$_SESSION['rudwebset_langs_catalog']['es']     = $_POST['langs_catalog']['es'];}
if(isset($_POST['langs_catalog']['fr']))     {$_SESSION['rudwebset_langs_catalog']['fr']     = $_POST['langs_catalog']['fr'];}
if(isset($_POST['langs_catalog']['it']))     {$_SESSION['rudwebset_langs_catalog']['it']     = $_POST['langs_catalog']['it'];}
if(isset($_POST['langs_catalog']['ro']))     {$_SESSION['rudwebset_langs_catalog']['ro']     = $_POST['langs_catalog']['ro'];}

if(isset($_POST['langs_cattt']['en']))       {$_SESSION['rudwebset_langs_cattt']['en']       = $_POST['langs_cattt']['en'];}
if(isset($_POST['langs_cattt']['de']))       {$_SESSION['rudwebset_langs_cattt']['de']       = $_POST['langs_cattt']['de'];}
if(isset($_POST['langs_cattt']['es']))       {$_SESSION['rudwebset_langs_cattt']['es']       = $_POST['langs_cattt']['es'];}
if(isset($_POST['langs_cattt']['fr']))       {$_SESSION['rudwebset_langs_cattt']['ft']       = $_POST['langs_cattt']['fr'];}
if(isset($_POST['langs_cattt']['it']))       {$_SESSION['rudwebset_langs_cattt']['it']       = $_POST['langs_cattt']['it'];}
if(isset($_POST['langs_cattt']['ro']))       {$_SESSION['rudwebset_langs_cattt']['ro']       = $_POST['langs_cattt']['ro'];}

if(isset($_POST['langs_itemstt']['en']))     {$_SESSION['rudwebset_langs_itemstt']['en']     = $_POST['langs_itemstt']['en'];}
if(isset($_POST['langs_itemstt']['de']))     {$_SESSION['rudwebset_langs_itemstt']['de']     = $_POST['langs_itemstt']['de'];}
if(isset($_POST['langs_itemstt']['es']))     {$_SESSION['rudwebset_langs_itemstt']['es']     = $_POST['langs_itemstt']['es'];}
if(isset($_POST['langs_itemstt']['fr']))     {$_SESSION['rudwebset_langs_itemstt']['fr']     = $_POST['langs_itemstt']['fr'];}
if(isset($_POST['langs_itemstt']['it']))     {$_SESSION['rudwebset_langs_itemstt']['it']     = $_POST['langs_itemstt']['it'];}
if(isset($_POST['langs_itemstt']['ro']))     {$_SESSION['rudwebset_langs_itemstt']['ro']     = $_POST['langs_itemstt']['ro'];}

if(isset($_POST['langs_itemtt']['en']))      {$_SESSION['rudwebset_langs_itemtt']['en']      = $_POST['langs_itemtt']['en'];}
if(isset($_POST['langs_itemtt']['de']))      {$_SESSION['rudwebset_langs_itemtt']['de']      = $_POST['langs_itemtt']['de'];}
if(isset($_POST['langs_itemtt']['es']))      {$_SESSION['rudwebset_langs_itemtt']['es']      = $_POST['langs_itemtt']['es'];}
if(isset($_POST['langs_itemtt']['fr']))      {$_SESSION['rudwebset_langs_itemtt']['fr']      = $_POST['langs_itemtt']['fr'];}
if(isset($_POST['langs_itemtt']['it']))      {$_SESSION['rudwebset_langs_itemtt']['it']      = $_POST['langs_itemtt']['it'];}
if(isset($_POST['langs_itemtt']['ro']))      {$_SESSION['rudwebset_langs_itemtt']['ro']      = $_POST['langs_itemtt']['ro'];}

if(isset($_POST['langs_csp']['en']))         {$_SESSION['rudwebset_langs_csp']['en']         = $_POST['langs_csp']['en'];}
if(isset($_POST['langs_csp']['de']))         {$_SESSION['rudwebset_langs_csp']['de']         = $_POST['langs_csp']['de'];}
if(isset($_POST['langs_csp']['es']))         {$_SESSION['rudwebset_langs_csp']['es']         = $_POST['langs_csp']['es'];}
if(isset($_POST['langs_csp']['fr']))         {$_SESSION['rudwebset_langs_csp']['fr']         = $_POST['langs_csp']['fr'];}
if(isset($_POST['langs_csp']['it']))         {$_SESSION['rudwebset_langs_csp']['it']         = $_POST['langs_csp']['it'];}
if(isset($_POST['langs_csp']['ro']))         {$_SESSION['rudwebset_langs_csp']['ro']         = $_POST['langs_csp']['ro'];}

if(isset($_POST['langs_cat_pid']['en']))     {$_SESSION['rudwebset_langs_cat_pid']['en']     = $_POST['langs_cat_pid']['en'];}
if(isset($_POST['langs_cat_pid']['de']))     {$_SESSION['rudwebset_langs_cat_pid']['de']     = $_POST['langs_cat_pid']['de'];}
if(isset($_POST['langs_cat_pid']['es']))     {$_SESSION['rudwebset_langs_cat_pid']['es']     = $_POST['langs_cat_pid']['es'];}
if(isset($_POST['langs_cat_pid']['fr']))     {$_SESSION['rudwebset_langs_cat_pid']['fr']     = $_POST['langs_cat_pid']['fr'];}
if(isset($_POST['langs_cat_pid']['it']))     {$_SESSION['rudwebset_langs_cat_pid']['it']     = $_POST['langs_cat_pid']['it'];}
if(isset($_POST['langs_cat_pid']['ro']))     {$_SESSION['rudwebset_langs_cat_pid']['ro']     = $_POST['langs_cat_pid']['ro'];}
  
if(isset($_POST['langs_cat_ppic']['en']))    {$_SESSION['rudwebset_langs_cat_ppic']['en']    = $_POST['langs_cat_ppic']['en'];}
if(isset($_POST['langs_cat_ppic']['de']))    {$_SESSION['rudwebset_langs_cat_ppic']['de']    = $_POST['langs_cat_ppic']['de'];}
if(isset($_POST['langs_cat_ppic']['es']))    {$_SESSION['rudwebset_langs_cat_ppic']['es']    = $_POST['langs_cat_ppic']['es'];}
if(isset($_POST['langs_cat_ppic']['fr']))    {$_SESSION['rudwebset_langs_cat_ppic']['fr']    = $_POST['langs_cat_ppic']['fr'];}
if(isset($_POST['langs_cat_ppic']['it']))    {$_SESSION['rudwebset_langs_cat_ppic']['it']    = $_POST['langs_cat_ppic']['it'];}
if(isset($_POST['langs_cat_ppic']['ro']))    {$_SESSION['rudwebset_langs_cat_ppic']['ro']    = $_POST['langs_cat_ppic']['ro'];}
  
if(isset($_POST['langs_cat_pname']['en']))   {$_SESSION['rudwebset_langs_cat_pname']['en']   = $_POST['langs_cat_pname']['en'];}
if(isset($_POST['langs_cat_pname']['de']))   {$_SESSION['rudwebset_langs_cat_pname']['de']   = $_POST['langs_cat_pname']['de'];}
if(isset($_POST['langs_cat_pname']['es']))   {$_SESSION['rudwebset_langs_cat_pname']['es']   = $_POST['langs_cat_pname']['es'];}
if(isset($_POST['langs_cat_pname']['fr']))   {$_SESSION['rudwebset_langs_cat_pname']['fr']   = $_POST['langs_cat_pname']['fr'];}
if(isset($_POST['langs_cat_pname']['it']))   {$_SESSION['rudwebset_langs_cat_pname']['it']   = $_POST['langs_cat_pname']['it'];}
if(isset($_POST['langs_cat_pname']['ro']))   {$_SESSION['rudwebset_langs_cat_pname']['ro']   = $_POST['langs_cat_pname']['ro'];}
  
if(isset($_POST['langs_cat_prd_dsc']['en'])) {$_SESSION['rudwebset_langs_cat_prd_dsc']['en'] = $_POST['langs_cat_prd_dsc']['en'];}
if(isset($_POST['langs_cat_prd_dsc']['de'])) {$_SESSION['rudwebset_langs_cat_prd_dsc']['de'] = $_POST['langs_cat_prd_dsc']['de'];}
if(isset($_POST['langs_cat_prd_dsc']['es'])) {$_SESSION['rudwebset_langs_cat_prd_dsc']['es'] = $_POST['langs_cat_prd_dsc']['es'];}
if(isset($_POST['langs_cat_prd_dsc']['fr'])) {$_SESSION['rudwebset_langs_cat_prd_dsc']['fr'] = $_POST['langs_cat_prd_dsc']['fr'];}
if(isset($_POST['langs_cat_prd_dsc']['it'])) {$_SESSION['rudwebset_langs_cat_prd_dsc']['it'] = $_POST['langs_cat_prd_dsc']['it'];}
if(isset($_POST['langs_cat_prd_dsc']['ro'])) {$_SESSION['rudwebset_langs_cat_prd_dsc']['ro'] = $_POST['langs_cat_prd_dsc']['ro'];}
  
if(isset($_POST['langs_cat_pprice']['en']))  {$_SESSION['rudwebset_langs_cat_pprice']['en']  = $_POST['langs_cat_pprice']['en'];}
if(isset($_POST['langs_cat_pprice']['de']))  {$_SESSION['rudwebset_langs_cat_pprice']['de']  = $_POST['langs_cat_pprice']['de'];}
if(isset($_POST['langs_cat_pprice']['es']))  {$_SESSION['rudwebset_langs_cat_pprice']['es']  = $_POST['langs_cat_pprice']['es'];}
if(isset($_POST['langs_cat_pprice']['fr']))  {$_SESSION['rudwebset_langs_cat_pprice']['fr']  = $_POST['langs_cat_pprice']['fr'];}
if(isset($_POST['langs_cat_pprice']['it']))  {$_SESSION['rudwebset_langs_cat_pprice']['it']  = $_POST['langs_cat_pprice']['it'];}
if(isset($_POST['langs_cat_pprice']['ro']))  {$_SESSION['rudwebset_langs_cat_pprice']['ro']  = $_POST['langs_cat_pprice']['ro'];}


if(isset($_POST['set_cfg_dbs_01']))                                                         {$_SESSION['rudwebset_cfg_dbs_01'] = $_POST['set_cfg_dbs_01'];}
else if(!isset($_POST['set_cfg_dbs_01']) && isset($_POST['cfg_dbs_00']))                    {$_SESSION['rudwebset_cfg_dbs_01'] = 'off';}
if(isset($_POST['set_cfg_dbs_02']))                                                         {$_SESSION['rudwebset_cfg_dbs_02'] = $_POST['set_cfg_dbs_02'];}
else if(!isset($_POST['set_cfg_dbs_02']) && isset($_POST['cfg_dbs_00']))                    {$_SESSION['rudwebset_cfg_dbs_02'] = 'off';}

if(isset($_POST['remove_db_data']))                                                         {$_SESSION['rudwebset_cfg_remove_db_data'] = $_POST['remove_db_data'];}
else if(!isset($_POST['remove_db_data']) && isset($_POST['proceed']))                       {$_SESSION['rudwebset_cfg_remove_db_data'] = 'off';}

if(isset($_POST['remove_db_tables']))                                                       {$_SESSION['rudwebset_cfg_remove_db_tables'] = $_POST['remove_db_tables'];}
else if(!isset($_POST['remove_db_tables']) && isset($_POST['proceed']))                     {$_SESSION['rudwebset_cfg_remove_db_tables'] = 'off';}

if(isset($_POST['remove_user_files']))                                                      {$_SESSION['rudwebset_cfg_remove_user_files'] = $_POST['remove_user_files'];}
else if(!isset($_POST['remove_user_files']) && isset($_POST['proceed']))                    {$_SESSION['rudwebset_cfg_remove_user_files'] = 'off';}

if(isset($_POST['remove_engine_files']))                                                    {$_SESSION['rudwebset_cfg_remove_engine_files'] = $_POST['remove_engine_files'];}
else if(!isset($_POST['remove_engine_files']) && isset($_POST['proceed']))                  {$_SESSION['rudwebset_cfg_remove_engine_files'] = 'off';}
?>