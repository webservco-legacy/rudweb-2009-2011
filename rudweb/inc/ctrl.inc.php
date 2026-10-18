<?php
/**
 * $Id: ctrl.inc.php 194 2009-07-12 10:35:08Z rudisoft@rudisoft.net $
 *
 * $URL: https://rudweb.googlecode.com/svn/branches/rudweb-reloaded/rudweb/inc/ctrl.inc.php $
 * <BR>Controller
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision: 194 $
 * @since      2009-02-23 12:28:00
 * @access     public
 * @package    rwApp
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

/**
 * Prevent direct file access
 */
if(!defined('_RW_VALID')) {require_once('./index.php'); exit;}

/**
 * Set configuration options
 */
$cfg = array();
if(is_readable('./cfg/cfg.ini'))
{
    /**
     * Parse configuration file
     */
    $cfg = parse_ini_file('./cfg/cfg.ini', TRUE);
    /**
     * Report application errors
     *
     */
    define('_APP_CFG_ERRORS',$cfg['Config']['Errors'] ? TRUE : FALSE);
    /**
     * Use database
     *
     */
    define('_APP_CFG_DATABASE',$cfg['Config']['Database'] ? TRUE : FALSE);
    /**
     * Use sessions and users
     *
     */
    define('_APP_CFG_SESSIONS',$cfg['Config']['Sessions'] ? TRUE : FALSE);
    /**
     * Use user authentication
     *
     */
    define('_APP_CFG_USERS',$cfg['Config']['Users'] ? TRUE : FALSE);
    /**
     * Use fake file extension for URL's
     *
     */
    define('_APP_CFG_FAKEXT',$cfg['Config']['Fakext'] ? TRUE : FALSE);
    /**
     * Engine path
     *
     */
    define('_RW_DIR',$cfg['Paths']['Engine']);
    /**
     * Application path
     *
     */
    define('_APP_DIR',$cfg['Paths']['App']);
    /**
     * Application URL
     *
     */
    define('_APP_WWW',$cfg['Paths']['AppURL']);
    /**
     * Full SEO
     *
     */
    define('_APP_INDEX',$cfg['Defaults']['FullSEO'] ? '' : 'index.php/');
    /**
     * Database type
     *
     */
    define('_APP_DB_TYPE',$cfg['Database']['Type']);
    /**
     * Database host
     *
     */
    define('_APP_DB_HOST',$cfg['Database']['Host']);
    /**
     * Database port
     *
     */
    define('_APP_DB_PORT',$cfg['Database']['Port']);
    /**
     * Database user
     *
     */
    define('_APP_DB_USER',$cfg['Database']['User']);
    /**
     * Database password
     *
     */
    define('_APP_DB_PASS',$cfg['Database']['Pass']);
    /**
     * Database name
     *
     */
    define('_APP_DB_NAME',$cfg['Database']['Name']);
    /**
     * Application name
     *
     */
    define('_APP_NAME',$cfg['AppInfo']['Name']);
    /**
     * Application author
     *
     */
    define('_APP_AUTH',$cfg['AppInfo']['Author']);
    /**
     * Application prefix
     *
     */
    define('_APP_PRE',$cfg['AppInfo']['Prefix']);
    /**
     * Default language
     *
     */
    define('_APP_LANG',$cfg['Defaults']['Language']);
    /**
     * Default skin
     *
     */
    define('_APP_SKIN',$cfg['Defaults']['Skin']);
    /**
     * Default time zone
     *
     */
    define('_APP_TIMEZONE',$cfg['Defaults']['TimeZone']);
}
else
{
    require_once('./404.php');
    exit;
}
/**
 * Extensions
 */
$exts = array_keys($cfg['Extensions']);
/**
 * Engine configuration
 */
if(is_readable(_RW_DIR.'rwc.inc.php'))
{
    require_once(_RW_DIR.'rwc.inc.php');
}
else
{
    require_once('./404.php');
    exit;
}
/**
 * Core
 */
if(is_readable(_APP_DIR_INC.'app.inc.php'))
{
    require_once(_APP_DIR_INC.'app.inc.php');
}
else
{
    require_once('./404.php');
    exit;
}
/**
 * Initialize main application core
 */
$appCore = new app_Core;
$appCore->rwInit($exts);

try
{
    /**
     * Initialize output
     */
    $out1 = array();
    /**
     * Set localized defaults for current language
     */
    $ln = (_APP_CFG_SESSIONS && $_SESSION[_APP_PRE.'_usr_lang']) ? $_SESSION[_APP_PRE.'_usr_lang'] : _APP_LANG;
    $cfg2 = array();
    if(is_readable('./cfg/cfg.'.$ln.'.ini'))
    {
        /**
         * Parse configuration file
         */
        $cfg2 = parse_ini_file('./cfg/cfg.'.$ln.'.ini', TRUE);
    }
    /**
     * Default content type
     */
    define('_APP_CONTENT_TYPE',$cfg2['Language']['ContentType'] ? $cfg2['Language']['ContentType'] : 'page');
    /**
     * Default content id
     */
    define('_APP_CONTENT_ID', $cfg2['Language']['ContentId'] ? $cfg2['Language']['ContentId'] : 'index');
    /**
     * Default page output
     */
    $out1['type'] = $cfg['Defaults']['OutType'] ? $cfg['Defaults']['OutType'] : '';
    /**
     * Main layout template directory.
     */
    $out1['skin']['dir'] = $cfg['Defaults']['SkinDir'] ? $cfg['Defaults']['SkinDir'] : '';
    /**
     * Main layout template file
     */
    $out1['skin']['tpl'] = $cfg['Defaults']['SkinTpl'] ? $cfg['Defaults']['SkinTpl'] : 'layout';
    /**
     * Main layout page title
     */
    $out1['skin']['title'] = $cfg2['Language']['PageTitle'] ? $cfg2['Language']['PageTitle'] : '';
    /**
     * Meta Data
     */
    $out1['skin']['meta'] = array();
    /**
     * Meta Subject
     */
    $out1['skin']['meta']['subject'] = $cfg2['Language']['MetaSubject'] ? $cfg2['Language']['MetaSubject'] : _APP_NAME;
    /**
     * Meta Description
     */
    $out1['skin']['meta']['description'] = $cfg2['Language']['MetaDescription'] ? $cfg2['Language']['MetaDescription'] : _APP_NAME;
    /**
     * Meta Keywords
     */
    $out1['skin']['meta']['keywords'] = $cfg2['Language']['MetaKeywords'] ? $cfg2['Language']['MetaKeywords'] : _APP_NAME;
    /**
     * Meta Copyright
     */
    $out1['skin']['meta']['copyright'] = $cfg2['Language']['MetaCopyright'] ? $cfg2['Language']['MetaCopyright'] : _APP_AUTH;
    /**
     * Meta Designer
     */
    $out1['skin']['meta']['designer'] = $cfg2['Language']['MetaDesigner'] ? $cfg2['Language']['MetaDesigner'] : _APP_AUTH;
    /**
     * Meta Publisher
     */
    $out1['skin']['meta']['publisher'] = $cfg2['Language']['MetaPublisher'] ? $cfg2['Language']['MetaPublisher'] : _APP_AUTH;
    /**
     * Meta Author
     */
    $out1['skin']['meta']['author'] = $cfg2['Language']['MetaAuthor'] ? $cfg2['Language']['MetaAuthor'] : _APP_AUTH;
    /**
     * Initialize actual content
     */
    $out1['cnt'] = array();
    /**
     * Initialize content id
     */
    $out1['id'] = 0;
    /**
     * Page content
     */
    $out2 = $appCore->appProcess();
    /**
     * Merge content data
     */
    $out = array_merge($out1, $out2);
    $out['skin'] = array_merge($out1['skin'], $out2['skin']);
    $out['cnt'] = array_merge($out1['cnt'], $out2['cnt']);
    /**
     * Global additional templates
     */
    $atpl = array();
    /**
     * Set legal HTML template engines
     */
    $htmlTpl = array('rudweb', 'Smarty');
    /**
     * If HTML + template content is requested, set it,
     * and also set additional templates
     */

    if(in_array($out['type'], $htmlTpl))
    {
        /**
         * Header
         */
        $atpl['header'] = array();
        $atpl['header']['dir'] = '';
        $atpl['header']['tpl'] = 'header';
        $atpl['header']['vars'] = array();
        $atpl['header']['vars']['lang'] = $appCore->rwLang();
        $atpl['header']['vars']['langAdm'] = $appCore->rwLangAdm();
        /**
         * Dynamic content menu
         */
        $atpl['header']['vars']['cntMenu'] = NULL;
        if(array_key_exists('cntMenu', $appCore->ext))
        {
            /**
             * If extension is present, attempt to load dynamic menu
             */
            $cntMenuObj = $appCore->rwActivateExt('cntMenu');
            $atpl['header']['vars']['cntMenu'] = $cntMenuObj->makeCntMenu($out['id']);
        }
        /**
         * Actual content
         */
        $atpl['content'] = array();
        /**
         * Check for multiple content items
         */
        if(array_key_exists(0, $out['cnt']))
        {
            foreach($out['cnt'] as $index=>$data)
            {
                if($appCore->rwCheckInt($index))
                {
                    /**
                     * Multiple content items
                     */
                    $atpl['content'][$index] = array();
                    $atpl['content'][$index]['dir'] = $out['cnt'][$index]['dir'];
                    $atpl['content'][$index]['tpl'] = $out['cnt'][$index]['tpl'];
                    $atpl['content'][$index]['vars']['cnt'] = $out['cnt'][$index]['content'];
                    $atpl['content'][$index]['vars']['lang'] = $appCore->rwLang();
                    $atpl['content'][$index]['vars']['langAdm'] = $appCore->rwLangAdm();
                    $atpl['content'][$index]['vars']['usr_status'] = $appCore->rwUsrStatus();
                }
            }
        }
        else
        {
            /**
             * Only one content item
             */
            $atpl['content'][0] = array();
            $atpl['content'][0]['dir'] = $out['cnt']['dir'];
            $atpl['content'][0]['tpl'] = $out['cnt']['tpl'];
            $atpl['content'][0]['vars']['cnt'] = $out['cnt']['content'];
            $atpl['content'][0]['vars']['lang'] = $appCore->rwLang();
            $atpl['content'][0]['vars']['langAdm'] = $appCore->rwLangAdm();
            $atpl['content'][0]['vars']['usr_status'] = $appCore->rwUsrStatus();
        }
        /**
         * Footer
         */
        $atpl['footer'] = array();
        $atpl['footer']['dir'] = '';
        $atpl['footer']['tpl'] = 'footer';
        $atpl['footer']['vars'] = array();
        $atpl['footer']['vars']['lang'] = $appCore->rwLang();
        $atpl['footer']['vars']['langAdm'] = $appCore->rwLangAdm();
        /**
         * Load custom configuration
         */
        if(is_readable(_APP_DIR.'cfg/atpl.inc.php'))
        {
            require_once(_APP_DIR.'cfg/atpl.inc.php');
        }
        /**
         * Override additional templates
         */
        if(array_key_exists('atpl', $out))
        {
            $a_tpl = array('header', 'content', 'footer');
            foreach($a_tpl as $name=>$value)
            {
                if(array_key_exists($value, $out['atpl']))
                {
                    $atpl[$value] = array();
                    $atpl[$value] = $out['atpl'][$value];
                }
            }
        }
    }
}
catch (Exception $e)
{
    echo rw_Error_handler::displayError($e);
    exit;
}
?>