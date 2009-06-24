<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Main engine library class
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2008-12-11 10:29:00
 * @access     public
 * @package    RudWEb
 * @subpackage Core
 * @todo       stuff
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
 * rw_Core
 *
 * Basic engine functions
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    RudWEb
 * @subpackage Core
 */
class rw_Core
{
	/**
	 * Extension list
	 *
	 * @var array
	 */
	public $ext = array();
	/**
	 * User status
	 *
	 * @var integer
	 */
	public $usr_status = 1;
	/**
	 * Language translations
	 *
	 * @var array
	 */
	public $lang = array();
	/**
	 * Language translations (admin)
	 *
	 * @var array
	 */
	public $langAdm = array();
	/**
	 * Database object
	 *
	 * @var mixed
	 */
	public $db = NULL;
	/**
	 * Initialize application
	 *
	 * @param mixed $exts extension list
	 * @return mixed result
	 */
	public function rwInit($exts)
	{
		/**
		 * Error reporting
		 */
		_APP_CFG_ERRORS ? error_reporting(E_ALL | E_STRICT) : error_reporting(0);
		/**
		 * Load error handler
		 */
		require_once(_RW_DIR_LIB_ERR.'err.inc.php');
		/**
		 * Initialize custom error handler
		 */
		rw_Error_handler::init();
		/**
		 * Default timezone
		 */
		date_default_timezone_set(_APP_TIMEZONE);
		/**
		 * Extensions, session, user authentication
		 */
		try
		{
			/**
			 * Load extensions
			 */
			$this->ext = $this->rwLoadExt($exts);
			/**
			 * Load database file, if database functionality is enabled
			 */
			if(_APP_CFG_DATABASE)
			{
				require_once(_RW_DIR_LIB_DB.'db.inc.php');
			}
			/**
			 * SEO URLS
			 */
			$seoURLs = $this->rwActivateExt('SeoURLs');
			$seoURLs->seoURLs();
			/**
			 * Initialize session and user authentication
			 */
			if(_APP_CFG_SESSIONS)
			{
				$sessions = $this->rwActivateExt('Sessions');
				$usr_status = $sessions->rwSession();
			}
			else
			{
				$usr_status = 1;
			}
			$this->usr_status = $usr_status;
		}
		catch (Exception $e)
		{
			echo $this->rwErr($e);
			exit;
		}
		/**
		 * Load language file
		 */
		$lang = array();
		$ln = _APP_CFG_SESSIONS ? $_SESSION[_APP_PRE.'_usr_lang'] : _APP_LANG;
		require(_RW_DIR_LANG.$ln.'/lang.inc.php');
		require(_APP_DIR_LANG.$ln.'/lang.inc.php');
		$this->lang = $lang;
		/**
		 * Load language file (admin)
		 */
		$lang = array();
		$lnAdm = _APP_CFG_SESSIONS ? $_SESSION[_APP_PRE.'_adm_lang'] : _APP_LANG;
		require(_RW_DIR_LANG.$lnAdm.'/lang.inc.php');
		require(_APP_DIR_LANG.$lnAdm.'/lang.inc.php');
		$this->langAdm = $lang;
		/**
		 * Return ok
		 */
		return;
	}
	/**
	 * Return loaded extensions
	 *
	 * @return array $ext loaded extensions
	 */
	public function rwExt()
	{
		return $this->ext;
	}
	/**
	 * Return user status
	 *
	 * @return integer $usr_status user status
	 */
	public function rwUsrStatus()
	{
		return $this->usr_status;
	}
	/**
	 * Return language translations
	 *
	 * @return array $lang language translations
	 */
	public function rwLang()
	{
		return $this->lang;
	}
	/**
	 * Return language translations (admin)
	 *
	 * @return array $lanfAdm language translations (admin)
	 */
	public function rwLangAdm()
	{
		return $this->langAdm;
	}
	/**
	 * New database type switcher
	 *
	 * Requires: DATABASE
	 *
	 * @return mixed result
	 */
	public function rwDbConnect()
	{
		/**
		 * Allowed database types
		 */
		if(in_array(_APP_DB_TYPE, array('mysql', 'postgresql')))
		{
			/**
			 * Required database class name
			 */
			$dbClass = 'rw_DB_'._APP_DB_TYPE;
			/**
			 * Include database class
			 */
			require_once(_RW_DIR_LIB_DB.'db.'._APP_DB_TYPE.'.inc.php');
			return new $dbClass(_APP_DB_HOST, _APP_DB_PORT, _APP_DB_USER, _APP_DB_PASS, _APP_DB_NAME);
		}
	}
	/**
	 * Check database integrity
	 *
	 * @todo check more than just if tables exist
	 * @param mixed $db database object
	 * @return mixed result
	 */
	public function rwDbCheck()
	{
		/**
		 * Check if tables exist in database
		 * (don't add query to query count)
		 */
		$r = $this->db->dbQuery("SELECT COUNT(TABLE_NAME) FROM information_schema.TABLES WHERE TABLE_SCHEMA = '"._APP_DB_NAME."'", FALSE);
		$t = $r->dbFetchResult();
		if($t == 0)
		{
			trigger_error('<u>Database Error</u>: There are no tables in the database');
		}
	}
	/**
	 * Set global database object
	 *
	 * @param mixed $db database object
	 * @return null
	 */
	public function rwDbSet($db)
	{
		$this->db = $db;
	}
	/**
	 * Retrun database connection object
	 *
	 * @return mixed $db database object
	 */
	public function rwDb()
	{
		return $this->db;
	}
	/**
	 * Main error display
	 *
	 * @todo mail error info to developer
	 * @todo write error info to log
	 * @param mixed $e error object
	 * @return mixed result
	 */
	public function rwErr($e)
	{
		/**
		 * Display error message
		 */
		$skinURL = _APP_WWW.'skins/'._APP_SKIN.'/';
		$err =
'<?xml version="1.0" encoding="utf-8" standalone="no"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="en" />
	<link rel="icon" type="image/ico" href="'.$skinURL.'graphics/favicon.ico" />
	<link rel="shortcut icon" type="image/ico" href="'.$skinURL.'graphics/favicon.ico" />
	<title>ERROR - '._APP_NAME.'</title>
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" charset="utf-8" href="'.$skinURL.'styles/style.css" />
	<!--[if lte IE 6]>
	<link rel="stylesheet" type="text/css" charset="utf-8" href="'.$skinURL.'styles/styleIE.css" />
	<![endif]-->
	</head>
    <body>
    
    <div id="layout">
      <div id="hdr">
        <div id="hdr1">
          <a href="'._APP_WWW.'" title="'._APP_NAME.'"><img id="logo" src="'.$skinURL.'graphics/logo.png" alt="'._APP_NAME.' Logo" longdesc="'._APP_NAME.' Logo" /></a>
        </div>
        <div id="hdr2"><div id="header">'._APP_NAME.'</div></div>
        <div id="hdr3">&#160;</div>
      </div>
      
      <div id="cnt0">
        <div id="left0">
          &#160;
        </div>
        <div id="right0">
          &#160;
        </div>
        <div id="center0">
          &#160;
        </div>
      </div>
      
      <div id="cnt1">
        <div id="left1">
	        <div id="left">
	          &#160;
	        </div>
        </div>
        
        
        <div id="right1">
          <div id="right">
            &#160;
          </div>
        </div>
        
        <div id="center1">
		      <div id="center_space1">&#160;</div>
		      <div id="center_content">
		        <div id="page_title">
		          <h1>Oops!</h1>
		        </div>
		        <div id="page_content">
		          <p>Something went wrong :-(</p>';

		$err .= (_APP_CFG_ERRORS) ? $this->rwErrDev($e) :
		'
		<p>Don\'t worry, it\'s not your fault!</p>
		<p><u>If you are a visitor</u>: kindly try again in a few minutes.</p>
		<p><u>If you are the owner/maintainer</u>: please enable error reporting in your configuration file in order to see more information about what happened.</p>
		';

		$err .=
		        '</div>
		        <div class="clear"></div>
		      </div>
		    </div>
        
      </div>
      
      <div id="cnt2">
        <div id="left2">
          &#160;
        </div>
        <div id="right2">
          &#160;
        </div>
        <div id="center2">
          &#160;
        </div>
		  </div>
		  
		  <div id="ftr">
		    <div id="footer">
		      Copyright 2009
		    </div>
		  </div>
  
    </div>
  </body>
</html>';
		return $err;
	}
	/**
	 * Developer error display
	 *
	 * @param mixed $e error object
	 * @return mixed result
	 */
	public function rwErrDev($e)
	{
		/**
		 * Display detailed error information
		 */
		$errType = array(
		1    => 'Fatal run-time error',
		2    => 'Run-time warning',
		4    => 'Compile-time parse error',
		8    => 'Run-time notice',
		16   => 'Fatal error that occured during PHP\'s initial startup',
		32   => 'Warning that occured during PHP\'s initial startup',
		64   => 'Fatal compile-time error',
		128  => 'Compile-time warning',
		256  => 'Engine-generated error message',
		512  => 'Engine-generated warning message',
		1024 => 'Engine-generated notice message',
		2048 => 'Run-time notice',
		4096 => 'Catchable fatal error'
		);

		$err =
      '<div class="err">'.
		  '<p>' . '<div class="errtxt">'. $e->getMessage() . '</div>' .
		  '<b>Time:</b> '. date("Y-m-d H:i:s") . '<br />' .
		  '<b>Error type:</b> '. $e->getCode() . ' (' . $errType[$e->getCode()] . ')' . '<br />' .
		  '<b>File:</b> '. $e->getFile() . '<br /> ' .
		  '<b>Line:</b> '. $e->getLine() . '<br /> ' .
		  '<b>Trace:</b></p> '. '<pre>' . strip_tags($e->getTraceAsString()) . '</pre>' .
		  '</div>'
		  ;
		  return $err;
	}
	/**
	 * Load extensions.
	 *
	 * @return mixed loaded extensions
	 */
	public function rwLoadExt($exts)
	{
		require_once(_RW_DIR_LIB_EXT.'ext.inc.php');
		$texts = count($exts);
		for($i=0;$i<$texts;$i++)
		{
			$extName = trim($exts[$i]);
			$extClass = 'rw_Ext_'.$extName;
			if(is_file(_APP_EXT_LOCAL_DIR.$extName.'.ext.php'))
			{
				require_once(_APP_EXT_LOCAL_DIR.$extName.'.ext.php');
				$ext[$extName]['global'] = 0;
			}
			else if(is_file(_APP_EXT_GLOBAL_DIR.$extName.'.ext.php'))
			{
				require_once(_APP_EXT_GLOBAL_DIR.$extName.'.ext.php');
				$ext[$extName]['global'] = 1;
			}
			else
			{
				trigger_error('Extension '.$extName . ' is missing.', E_USER_ERROR);
			}
		}
		return $ext;
	}
	/**
	 * Activate extension
	 *
	 * @return mixed result
	 */
	public function rwActivateExt($extName)
	{
		if(array_key_exists($extName, $this->ext))
		{
			$class = 'rw_Ext_'.$extName;
			$extObj = new $class($this);
			$extAbout = $extObj->extAbout();
			$cfgDeps = count($extAbout['deps']['cfg']);
			$extDeps = count($extAbout['deps']['ext']);
			/**
			 * If configuration dependencies exist solve them
			 */
			if($cfgDeps > 0)
			{
				foreach($extAbout['deps']['cfg'] as $cfgDep)
				{
					if(TRUE !== constant('_APP_CFG_'.strtoupper($cfgDep)))
					{
						trigger_error('Extension <b>'. $extName .'</b> can not be loaded. Configuration dependecy <b>'.$cfgDep.'</b> is missing.', E_USER_ERROR);
					}
				}
			}
			/**
			 * If extensions dependecies exist, slove them
			 */
			if($extDeps > 0)
			{
				foreach($extAbout['deps']['ext'] as $extDep)
				{
					if(!array_key_exists($extDep, $this->ext))
					{
						trigger_error('Extension <b>'.$extName.'</b> can not be loaded. Extensions dependecy <b>'.$extDep.'</b> is missing.', E_USER_ERROR);
					}
				}
			}
			return $extObj;

		}
		else
		{
			trigger_error('Extension '.$extName.' is not loaded.', E_USER_ERROR);
		}
	}
	/**
	 * Filter user input
	 *
	 * @param string $input
	 * @param boolean $blockTags
	 * @return string filtered input
	 */
	public function rwFilterInput($input,$blockTags=TRUE)
	{
		if(get_magic_quotes_gpc()) {$input = stripslashes($input);}
		/**
		 * Unwanted chars
		 */
		$unwanted = array('\\');
		$input = str_replace($unwanted, '', $input);
		/**
		 * Block tags
		 */
		if($blockTags === TRUE)
		{
			$input = str_replace('&lt;', '&#60;', $input);
			$input = str_replace('&gt;', '&#62;', $input);
			$input = str_replace('<', '&#60;', $input);
			$input = str_replace('>', '&#62;', $input);
		}

		if($this->db)
		{
			$input = $this->db->dbEscapeString($input);
		}
		else
		{
			/**
			 * The string will not be used in a query so we just strip any nasty characters
			 */
			$input = $this->rwRemoveBadChars($input);

		}
		return trim($input);
	}
	/**
	 * Strip all tags
	 *
	 * @param string $input
	 * @return string filtered input
	 */
	public function rwStripTags($input)
	{
		return preg_replace('/<(.|\s)*?\>/', '', $input);
	}
	/**
	 * Strip php code
	 *
	 * @param string $input
	 * @return string filtered input
	 */
	public function rwStripPhp($input)
	{
		return preg_replace('/<\?(.|\s)*?>/', '', $input);
	}
	/**
	 * Strip Smarty varaibles
	 *
	 * @param string $input
	 * @return string filtered input
	 */
	public function rwStripSmartyVars($input)
	{
		return preg_replace('/{\$(.|\s)*?}/', '', $input);
	}
	/**
	 * Strip Smarty code
	 *
	 * @param string $input
	 * @return string filtered input
	 */
	public function rwStripSmartyCode($input)
	{
		return preg_replace('/{(.|\s)*?}/', '', $input);
	}
	/**
	 * Strip scripting code
	 *
	 * @param string $input
	 * @return string filtered input
	 */
	public function rwStripScript($input)
	{
		return preg_replace('/<script(.|\s)*?\/script>/', '', $input);
	}
	/**
	 * Strip HTML comments
	 *
	 * @param string $input
	 * @return string filtered input
	 */
	public function rwStripHTMLComments($input)
	{
		return preg_replace('/<!--(.|\s)*?-->/', '', $input);
	}
	/**
	 * Remove problem characters from a string
	 *
	 * @param string $string input string
	 * @return string parsed string
	 */
	public function rwRemoveBadChars($string)
	{
		$bad = array(
    '`', "'", '"',
    '\\\b', '\\\n', '\\\r', '\\\t',
    '\?', '!', '\~', '\@', '\#', '\$', '\%', '\^', '\&', '\*',
    '\(', '\)', '\-', '\+', '\=', '\{', '\[', '\}', '\]',
    '\:', '\;', '\,', '\.', '\|', '\\'
    );
    $string = str_replace($bad, '', $string);
    return $string;
	}
	/**
	 * Check for a valid email address
	 *
	 * @param string $string
	 * @return boolean result
	 */
	public function rwCheckEmail($string)
	{
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $string));
	}
	/**
	 * Check for a valid integer
	 *
	 * Zero-padding allowed
	 *
	 * @param string $string
	 * @return boolean result
	 */
	public function rwCheckInt($string)
	{
		return(preg_match("/^[0-9]*$/", $string));
	}
	/**
	 * Remove fake file extension from requests
	 *
	 * @param string $request request
	 * @return string $request processed request
	 */
	private function _rwRemoveFakeExt($request)
	{
		if(_APP_CFG_FAKEXT)
		{
			$request = substr($request, 0, strlen($request)-strlen(strstr($request,'.')));
		}
		return $request;
	}
	/**
	 * Filter request
	 *
	 * @param string $request request
	 * @param boolean $blockTags
	 * @return string $request filtered request
	 */
	public function rwFilterRequest($request,$blockTags=TRUE)
	{
		$request = $this->rwFilterInput($request,$blockTags);
		$request = $this->_rwRemoveFakeExt($request);
		return $request;
	}
	/**
	 * Convert UTF-8 characters to latin ones
	 *
	 * All credit for this function goes to
	 * http://www.phpro.org/examples/Decode-Utf8.html
	 *
	 * @param string $string
	 * @return string converted string
	 */
	public function rwUTF2Latin($string)
	{
		$utf = array(
    'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ă', 'Ą',
    'Ç', 'Ć', 'Č', 'Œ',
    'Ď', 'Đ',
    'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ă', 'ą',
    'ç', 'ć', 'č', 'œ',
    'ď', 'đ',
    'È', 'É', 'Ê', 'Ë', 'Ę', 'Ě',
    'Ğ',
    'Ì', 'Í', 'Î', 'Ï', 'İ',
    'Ĺ', 'Ľ', 'Ł',
    'è', 'é', 'ê', 'ë', 'ę', 'ě',
    'ğ',
    'ì', 'í', 'î', 'ï', 'ı',
    'ĺ', 'ľ', 'ł',
    'Ñ', 'Ń', 'Ň',
    'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ő',
    'Ŕ', 'Ř',
    'Ś', 'Ş', 'Š',
    'ñ', 'ń', 'ň',
    'ò', 'ó', 'ô', 'ö', 'ø', 'ő',
    'ŕ', 'ř',
    'ś', 'ş', 'š',
    'Ţ', 'Ť',
    'Ù', 'Ú', 'Û', 'Ų', 'Ü', 'Ů', 'Ű',
    'Ý', 'ß',
    'Ź', 'Ż', 'Ž',
    'ţ', 'ť',
    'ù', 'ú', 'û', 'ų', 'ü', 'ů', 'ű',
    'ý', 'ÿ',
    'ź', 'ż', 'ž',
    'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р',
    'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'р',
    'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
    'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
    );
    $latin = array(
    'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'A', 'A',
    'C', 'C', 'C', 'CE',
    'D', 'D',
    'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'a', 'a',
    'c', 'c', 'c', 'ce',
    'd', 'd',
    'E', 'E', 'E', 'E', 'E', 'E',
    'G',
    'I', 'I', 'I', 'I', 'I',
    'L', 'L', 'L',
    'e', 'e', 'e', 'e', 'e', 'e',
    'g',
    'i', 'i', 'i', 'i', 'i',
    'l', 'l', 'l',
    'N', 'N', 'N',
    'O', 'O', 'O', 'O', 'O', 'O', 'O',
    'R', 'R',
    'S', 'S', 'S',
    'n', 'n', 'n',
    'o', 'o', 'o', 'o', 'o', 'o',
    'r', 'r',
    's', 's', 's',
    'T', 'T',
    'U', 'U', 'U', 'U', 'U', 'U', 'U',
    'Y', 'Y',
    'Z', 'Z', 'Z',
    't', 't',
    'u', 'u', 'u', 'u', 'u', 'u', 'u',
    'y', 'y',
    'z', 'z', 'z',
    'A', 'B', 'B', 'r', 'A', 'E', 'E', 'X', '3', 'N', 'N', 'K', 'N', 'M', 'H', 'O', 'N', 'P',
    'a', 'b', 'b', 'r', 'a', 'e', 'e', 'x', '3', 'n', 'n', 'k', 'n', 'm', 'h', 'o', 'p',
    'C', 'T', 'Y', 'O', 'X', 'U', 'u', 'W', 'W', 'b', 'b', 'b', 'E', 'O', 'R',
    'c', 't', 'y', 'o', 'x', 'u', 'u', 'w', 'w', 'b', 'b', 'b', 'e', 'o', 'r'
    );
    return str_replace($utf, $latin, $string);
	}
	/**
	 * Format title alias
	 *
	 * @param string $title
	 * @return string formatted title
	 */
	public function rwFormatAlias($title)
	{
		/**
		 * Basic filtering
		 */
		$title = $this->rwFilterInput($title);
		/**
		 * Remove nasy characters
		 */
		$title = $this->rwRemoveBadChars($title);
		/**
		 * Convert UTF characters to latin ones
		 */
		$title = $this->rwUTF2Latin($title);
		/**
		 * Make lowercase string and trim it.
		 */
		$title=trim(strtolower($title));
		/**
		 * Convert spaces to _
		 */
		$title = eregi_replace(' ','_',$title);

		return $title;
	}
	/**
	 * Get page id and alias from request
	 *
	 * @param string $request
	 * @return array data
	 */
	public function rwStripAlias($request)
	{
		$data = array();
		$data[0] = NULL;
		$data[1] = NULL;
		$delimiter = '-';
		if(FALSE !== strpos($request, $delimiter))
		{
			$data = explode($delimiter, $request, 2);
		}
		else
		{
			$data[0] = $this->rwCheckInt($request) ? $request : NULL;
		}
		$data[0] = $this->rwFilterInput($data[0]);
		$data[1] = $this->rwFilterInput($data[1]);
		return $data;
	}
	/**
	 * Self redirect to avoid double submits
	 *
	 * @return null
	 */
	public function rwSelfRedirect()
	{
		if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != '')
		{
			$redirect = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		else if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != '')
		{
			$redirect = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		}
		else
		{
			$redirect = _APP_URL;
		}
		header("Location: ".$redirect);
		exit;
	}
	/**
	 * List directories and files in a directory.
	 *
	 * @param string $dir path to directory
	 * @param boolean $dirs show directories
	 * @param unknown_type $files show files
	 * @return array list of results
	 */
	public function rwLsDir($dir, $dirs=TRUE, $files=FALSE)
	{
		$slash = ($dir[strlen($dir)-1]) != '/' ? FALSE : TRUE;
		$dir = $slash ? $dir : $dir.'/';
		$list = array('d'=>array(), 'f'=>array());
		$i = 0;
		$j = 0;
		if(is_dir($dir))
		{
			if($dh = opendir($dir))
			{
				while (FALSE !== ($file = readdir($dh)))
				{
					if($file != '.' && $file != '..')
					{
						if(strpos($file, '.') !== 0)
						{
							if($dirs && is_dir($dir.$file))
							{
								$list['d'][$i] = $file;
								$i++;
							}
							if($files && is_file($dir.$file))
							{
								$list['f'][$j] = $file;
								$j++;
							}
						}
					}
				}
				closedir($dh);
			}
		}
		return $list;
	}
}
?>