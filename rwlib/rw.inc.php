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
		require_once(_RW_DIR_LANG.$ln.'/lang.inc.php');
		require_once(_APP_DIR_LANG.$ln.'/lang.inc.php');
		$this->lang = $lang;
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
	 * @param mixed $e error object
	 * @return mixed result
	 */
	public function rwErr($e)
	{
		/**
		 * Check error reporting level and return the proper error display function.
		 */
		$err = _APP_CFG_ERRORS ? $this->rwErrDev($e) : $this->rwErrUsr($e);
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
		$err  = '<b>msg:</b> ' .  $e->getMessage() . '<br />';
		$err .= '<b>code:</b> ' . $e->getCode() . '<br />';
		$err .= '<b>file:</b> ' . $e->getFile() . '<br />';
		$err .= '<b>line:</b> ' . $e->getLine() . '<br />';
		return $err;
	}
	/**
	 * User error display
	 *
	 * @param mixed $e error object
	 * @return mixed result
	 */
	public function rwErrUsr($e)
	{
		/**
		 * Diplay only little error information
		 */
		$err = 'Oops!';
		return $err;
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
	 * Check for a valid email address
	 */
	public function rwCheckEmail($email)
	{
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
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
		$unwanted = array('\\', '');
		$input = str_replace($unwanted, ' ', $input);
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
			$bad = array();
			$bad[] = '`';
			$bad[] = "'";
			$bad[] = '"';
			$bad[] = '\\\b';
			$bad[] = '\\\n';
			$bad[] = '\\\r';
			$bad[] = '\\\t';
			$bad[] = '\?';
			$bad[] = '!';
			$bad[] = '\~';
			$bad[] = '\@';
			$bad[] = '\#';
			$bad[] = '\$';
			$bad[] = '\%';
			$bad[] = '\^';
			$bad[] = '\&';
			$bad[] = '\*';
			$bad[] = '\(';
			$bad[] = '\)';
			$bad[] = '\-';
			$bad[] = '\+';
			$bad[] = '\=';
			$bad[] = '\{';
			$bad[] = '\[';
			$bad[] = '\}';
			$bad[] = '\]';
			$bad[] = '\:';
			$bad[] = '\;';
			$bad[] = '\,';
			$bad[] = '\.';
			$bad[] = '\|';
			$input = str_replace($bad, '', $input);
		}
		return trim($input);
	}
	/**
	 * Remove fake file extension from requests
	 *
	 * @param string $request request
	 * @return string $request processed request
	 */
	private function _removeFakeExt($request)
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
		$request = $this->_removeFakeExt($request);
		return $request;
	}
}
?>