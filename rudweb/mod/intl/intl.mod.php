<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Internationalization module
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-04-11 10:46:00
 * @access     public
 * @package    rwMod
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
 * rw_Mod_intl
 *
 * rw_Mod_intl module
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwMod
 */
class rw_Mod_intl extends rw_Mod_global implements rw_iMod
{
    /**
     * Constructor
     *
     * Set module information and call parent constructor
     */
    public function __construct($appCore)
    {
        /**
         * Module info
         */
        $about['name'] = 'intl';
        $about['desc'] = 'Internationalization module.';
        $about['ver']  = '$Revision$';
        $about['auth'] = 'Radu Maier';
        $about['web']  = 'http://www.rudisoft.net';
        $about['mail'] = 'rudisoft@rudisoft.net';
        $about['deps'] = array();
        $about['deps']['cfg'] = array();
        $about['deps']['cfg'][] = 'Sessions';
        $about['deps']['ext'] = array();
        $about['deps']['ext'][] = 'Sessions';
        $about['deps']['mod'] = array();
        /**
         * These must be declared
         */
        $out['skin'] = array();
        $out['skin']['meta'] = array();
        $out['cnt'] = array();
        /**
         * Module default output
         *
         * $out['type'] added by default in parent class
         * $out['skin']['dir'] added by default in parent class
         * $out['skin']['tpl'] added by default in parent class
         * $out['skin']['title'] added by default in parent class
         * $out['skin']['meta'] added by default in parent class
         * $out['skin']['lang'] added by default in parent class
         * $out['skin']['langAdm'] added by default in parent class
         */
        $out['type'] = 'Smarty';
        $out['cnt']['dir'] = 'content';
        $out['cnt']['tpl'] = 'blank';
        $out['cnt']['content'] = array();
        /**
         * Call parent constructor
         */
        parent::__construct($about, $out, $appCore);
        $intl = $this->modAppCore->rwActivateExt('Intl');
        $this->modOut['skin']['langs'] = $intl->intlMenu();
    }
    /**
     * Default module functionality
     *
     * @return mixed result
     */
    public function _default()
    {
        return $this->modOut;
    }
    /**
     * Set language for current session.
     *
     * @return mixed result
     */
    public function setSession()
    {
        $list     = $this->modAppCore->rwLsDir(_APP_DIR_LANG);
        $langList = $list['d'];
        $newLang  = (isset($_GET['ln']) && in_array($_GET['ln'], $langList)) ? $_GET['ln'] : _APP_LANG;
        $target   = (isset($_GET['red'])) ? $this->modAppCore->rwFilterRequest($_GET['red']) : NULL;
        $var      = (isset($_GET['var'])) ? $this->modAppCore->rwFilterRequest($_GET['var']) : NULL;

        return $this->_intl('usr', $newLang, $target, $var);
    }
    /**
     * Set language for current session (admin)
     *
     * @return mixed result
     */
    public function setSessionAdm()
    {
        $list     = $this->modAppCore->rwLsDir(_APP_DIR_LANG);
        $langList = $list['d'];
        $newLang  = (isset($_GET['ln']) && in_array($_GET['ln'], $langList)) ? $_GET['ln'] : _APP_LANG;
        $target   = (isset($_GET['red'])) ? $this->modAppCore->rwFilterRequest($_GET['red']) : NULL;
        $var      = (isset($_GET['var'])) ? $this->modAppCore->rwFilterRequest($_GET['var']) : NULL;

        return $this->_intl('adm', $newLang, $target, $var);
    }
    /**
     * Set language for current content (administration).
     *
     * @return mixed result
     */
    public function setContent()
    {
        $list     = $this->modAppCore->rwLsDir(_APP_DIR_LANG);
        $langList = $list['d'];
        $newLang  = (isset($_GET['ln']) && in_array($_GET['ln'], $langList)) ? $_GET['ln'] : _APP_LANG;
        $target   = (isset($_GET['red'])) ? $this->modAppCore->rwFilterRequest($_GET['red']) : NULL;
        $var      = (isset($_GET['var'])) ? $this->modAppCore->rwFilterRequest($_GET['var']) : NULL;

        return $this->_intl('cnt', $newLang, $target, $var);
    }
    /**
     * Actual functionality of the module.
     *
     * Sets the new language and
     * redirects to a new location.
     * Possible values for $target:
     * home = home page
     * pg = page
     * cnt = content
     * mod = module
     * ref = referer
     * BLANK = ref
     * Possible values for $var
     * page name
     * content id
     * module name and variables (to pass multiple arguments use "-" instead of "/")
     * //XXX still need to test this
     * blank (for "home", "ref" and BLANK)
     *
     * @param string $newLang new language
     * @param string $target where to redirect
     * @param string $var what to append to the redirection URL
     */
    private function _intl($type='usr', $newLang=NULL, $target=NULL, $var=NULL)
    {
        $ref = (array_key_exists('HTTP_REFERER', $_SERVER) && $_SERVER['HTTP_REFERER'] != '') ? $_SERVER['HTTP_REFERER'] : NULL;

        $location = $ref ? $ref : _APP_WWW;

        $typeList = array('usr', 'adm', 'cnt');
        $type = (in_array($type, $typeList)) ? $type : 'usr';

        if($newLang == $_SESSION[_APP_PRE.'_'.$type.'_lang'])
        {
            header("Location: ".$location);
            exit;
        }
        else
        {
            /**
             * Set new language
             */
            $_SESSION[_APP_PRE.'_'.$type.'_lang'] = $newLang;
            /**
             * Where to redirect
             */
            if($target)
            {
                switch($target)
                {
                    case 'home' :
                        {
                            /**
                             * Redirect to the inital page of the current language
                             */
                            $cfg = parse_ini_file(_APP_DIR.'cfg/cfg.'.$newLang.'.ini', TRUE);
                            $contentType = $cfg['Language']['ContentType'] ? $cfg['Language']['ContentType'] : NULL;
                            $contentId = $cfg['Language']['ContentId'] ? $cfg['Language']['ContentId'] : NULL;
                            if(!$contentType && !$contentId)
                            {
                                $location = _APP_WWW;
                            }
                            else
                            {
                                $location = _APP_URL.$contentType.'/'.$contentId;
                            }
                            break;
                        }
                    case 'pg' :
                        {
                            if($var)
                            {
                                $location = _APP_URL . 'page/'.$var;
                            }
                            break;
                        }
                    case 'cnt' :
                        {
                            if($var)
                            {
                                $location = _APP_URL . 'content/'.$var;
                            }
                            break;
                        }
                    case 'mod' :
                        {
                            if($var)
                            {
                                //XXX
                                $var = str_replace('-', '/', $var);
                                $location = _APP_URL . 'module/'.$var;
                            }
                            break;
                        }
                    case 'ref' :
                        {
                            break;
                        }
                    default :
                        {
                            break;
                        }
                }
            }
            header("Location: ".$location);
            exit;
        }
    }
    /**
     * Set language for user.
     * Needs user and database functionality
     * //XXX
     * public function setUser()
     *
     * Set default language.
     * public function setDefault()
     */
}
?>