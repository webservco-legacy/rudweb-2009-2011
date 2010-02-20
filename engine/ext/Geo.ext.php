<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Geo location and internationalization extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-01-17 18:40:00
 * @access     public
 * @package    rwExt
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
 * Security check.
 */
if (!defined('_RW_VALID'))
{
	/**
	 * Display "Not Found" page.
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution.
	 */
	exit;
}

/**
 * Extension name.
 */
$extAbout['Geo']['name'] = 'Geo';
/**
 * Extension description.
 */
$extAbout['Geo']['desc'] = 'Geo location and internationalization methods.';
/**
 * Extension version.
 */
$extAbout['Geo']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Geo']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Geo']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Geo']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Geo']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Geo']['deps']['lib'] = array('Error', 'Database');
/**
 * Extension extension dependencies.
 */
$extAbout['Geo']['deps']['ext'] = array();

/**
 * rw_Extension_Geo.
 *
 * rw_Extension_Geo extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Geo extends rw_Extension implements rw_iExtension
{
	/**
	 * Database library object.
	 *
	 * @var mixed
	 */
	protected $rwDb;

	/**
	 * Current language iso.
	 *
	 * @var string
	 */
	protected $ln;

	/**
	 * Constructor.
	 *
	 * @param array $extAbout
	 * @return mixed result
	 */
	public function __construct($extAbout)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($extAbout);
	}

	/**
	 * Main extension functionality.
	 *
	 * @return mixed result
	 */
	public function rwGeo()
	{
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Get country list.
	 *
	 * The list will be in the form country[iso] = name
	 *
	 * @return array country list
	 */
	public function getCountries()
	{
		/**
		 * Initialize the countries list.
		 */
		$countries = array();
		/**
		 * Get the countries list from database.
		 */
		$r = $this->rwDb->dbSelect('country_iso, country_name', _APP_PRE.'_geo_country', NULL, NULL, NULL, 'country_name ASC');
		/**
		 * Count the number of countries.
		 */
		$t = $r->dbNumRows();
		/**
		 * Check if we have any countries to list.
		 */
		if($t > 0)
		{
			/**
			 * Iterate through the database results.
			 */
			while($c=$r->dbFetchArray())
			{
				/**
				 * Format the list.
				 */
				$countries[$c['country_iso']] = $c['country_name'];
			}
		}
		/**
		 * Return result.
		 */
		return $countries;
	}

	/**
	 * Get languages list.
	 *
	 * The list will contain the available languages for the application.
	 * Default is in the form language[iso] = local_name.
	 * If $general is set to TRUE the list will have a different format:
	 * language[iso] = array(local_name, name);
	 *
	 * @param boolean $general whether to include the english language name.
	 *
	 * @return array language list
	 */
	public function getLangs($general=FALSE)
	{
		/**
		 * Initialize the languages list.
		 */
		$langs = array();
		/**
		 * Get the languages list from database.
		 */
		$r = $this->rwDb->dbSelect('lang_iso, lang_local_name, lang_name', _APP_PRE.'_geo_lang', NULL, NULL, NULL, 'lang_name ASC');
		/**
		 * Count the number of languages.
		 */
		$t = $r->dbNumRows();
		/**
		 * Check if we have any languages to list.
		 */
		if($t > 0)
		{
			/**
			 * Iterate through the database results.
			 */
			while($l=$r->dbFetchArray())
			{
				/**
				 * Check if we should also include the general name and format the list accordingly.
				 */
				$langs[$l['lang_iso']] = $general ?  array($l['lang_local_name'], $l['lang_name']) : $l['lang_local_name'];
			}
		}
		/**
		 * Return result.
		 */
		return $langs;
	}

	/**
	 * Get visitor country.
	 *
	 * Try to match visitor's ip address in internal database.
	 *
	 * @return mixed result
	 */
	public function getVisitorCountry()
	{
		/**
		 * Set default visitor country to "Reserved".
		 */
		$vc = 'ZZ';
		/**
		 * Set visitor IP Address to it's numeric value.
		 */
		$ip = ip2long($_SERVER['REMOTE_ADDR']);
		/**
		 * Get country iso from IP database.
		 */
		$r = $this->rwDb->dbSelect('country_iso', _APP_PRE.'_geo_ip', "{$ip} BETWEEN ip_start AND ip_end", NULL, NULL, NULL, 1);
		/**
		 * Count results.
		 */
		$t = $r->dbNumRows();
		/**
		 * Check if we have any countries to list.
		 */
		if($t > 0)
		{
			/**
			 * Set visitor country.
			 */
			$vc = $r->dbFetchResult();
		}
		/**
		 * Check if we have a valid country iso. Otherwise set it to application default.
		 * Return result.
		 *
		 */
		return ($vc != 'ZZ') ? $vc : _APP_VC;;
	}

	/**
	 * Get the country name from country iso.
	 *
	 * @param string $country_iso country iso
	 * @return mixed result
	 */
	public function getCountryName($country_iso)
	{
		/**
		 * Get country name from database.
		 */
		$r = $this->rwDb->dbSelect('country_name', _APP_PRE.'_geo_country', "country_iso = '{$country_iso}'", NULL, NULL, NULL, 1);
		/**
		 * Count results.
		 */
		$t = $r->dbNumRows();
		/**
		 * Check if we have a result.
		 */
		if($t == 1)
		{
			/**
			 * Return country name.
			 */
			return $r->dbFetchResult();
		}
		/**
		 * Country name not found.
		 * Return null.
		 */
		return NULL;
	}

	/**
	 * Get zone name from zone id.
	 *
	 * @param string $zone_id zone id
	 * @return mixed result
	 */
	public function getZoneName($zone_id)
	{
		/**
		 * Get zone name from database.
		 */
		$r = $this->rwDb->dbSelect('zone_name', _APP_PRE.'_geo_zone', "zone_id = '{$zone_id}'", NULL, NULL, NULL, 1);
		/**
		 * Count results.
		 */
		$t = $r->dbNumRows();
		/**
		 * Check if we have a result.
		 */
		if($t == 1)
		{
			/**
			 * Return country name.
			 */
			return $r->dbFetchResult();
		}
		/**
		 * Country name not found.
		 * Return null.
		 */
		return NULL;
	}

	/**
	 * Get language based on country.
	 *
	 * Try to return the primary language for that country.
	 * If no match is found, the default application language is returned
	 *
	 * @param string $country_iso two letter country iso
	 * @return string language iso
	 */
	public function getLangByCountry($country_iso)
	{
		/**
		 * Get languages for the specified country.
		 *
		 * The called method takes care to return the default application language if no match is found.
		 */
		$ln = $this->getLangsByCountry($country_iso);
		/**
		 * Return the primary language.
		 */
		return $ln[0];
	}

	/**
	 * Get languages based on country.
	 *
	 * Try to return a list of starting with the main language.
	 * If no match is found, the default aplication language is returned.
	 *
	 * @param string $country_iso two letter country iso
	 * @return array language list
	 */
	public function getLangsByCountry($country_iso)
	{
		/**
		 * Initialize languages list.
		 */
		$ln = array();
		/**
		 * Get matching languages from database.
		 */
		$r = $this->rwDb->dbSelect('lang_iso', _APP_PRE.'_geo_country_lang', "country_iso = '{$country_iso}'", NULL, NULL, 'country_lang_primary DESC');
		/**
		 * Count results.
		 */
		$t = $r->dbNumRows();
		/**
		 * Check if we have any results.
		 */
		if($t > 0)
		{
			/**
			 * Iterate through the results.
			 */
			while($l = $r->dbFetchArray())
			{
				/**
				 * Add language to list.
				 */
				$ln[]=$l['lang_iso'];
			}
		}
		/**
		 * No result.
		 */
		else
		{
			/**
			 * Set to default application language.
			 */
			$ln[] = _APP_LN;
		}
		/**
		 * Return result.
		 */
		return $ln;
	}

	/**
	 * Get zone list based on country.
	 *
	 * @param string $country_iso two letter country iso
	 * @return array zone list
	 */
	public function getZonesByCountry($country_iso)
	{
		/**
		 * Initialize zones list.
		 */
		$zones = array();
		/**
		 * Get matching zones from database.
		 */
		$r = $this->rwDb->dbSelect('zone_id, zone_name', _APP_PRE.'_geo_zone', "country_iso = '{$country_iso}'", NULL, NULL, 'zone_name');
		/**
		 * Count results.
		 */
		$t = $r->dbNumRows();
		/**
		 * Check if we have any results.
		 */
		if($t > 0)
		{
			/**
			 * Iterate through the results.
			 */
			while($z = $r->dbFetchArray())
			{
				/**
				 * Add zone to list.
				 */
				$zones[$z['zone_id']] = $z['zone_name'];
			}
		}
		/**
		 * Return result.
		 */
		return $zones;
	}

	/**
	 * Set core and application translation list.
	 *
	 * @return mixed result
	 */
	public function setLang()
	{
		/**
		 * Init core translation list.
		 */
		$langCore = array();
		/**
		 * Set core language path.
		 */
		$langCorePath = _RW_INT_DIR.$this->ln.'/core.lng.php';
		/**
		 * Check if core language file is readable.
		 */
		if (is_readable($langCorePath))
		{
			/**
			 * Load core language file.
			 */
			require($langCorePath);
		}
		/**
		 * Set core translation list.
		 */
		$lang['CORE'] = $langCore;
		/**
		 * Init application translation list.
		 */
		$langApp = array();
		/**
		 * Set application language path.
		 */
		$langAppPath = _APP_INT_DIR.$this->ln.'/app.lng.php';
		/**
		 * Check if application language file is readable.
		 */
		if (is_readable($langAppPath))
		{
			/**
			 * Load application language file.
			 */
			require($langAppPath);
		}
		/**
		 * Set application translation list.
		 */
		$lang['APP'] = $langApp;
		/**
		 * Return main translation list.
		 */
		return $lang;
	}

	/**
	 * Set module translation list.
	 *
	 * @param string $sct section name
	 * @param string $mod module name
	 * @return mixed result
	 */
	public function setLangMod($sct, $mod)
	{
		/**
		 * Init module translation list.
		 */
		$langMod = array();
		/**
		 * Set module language path.
		 */
		$langModPath = _APP_MOD_DIR.$sct.'/int/'.$this->ln.'/'.$mod.'.lng.php';
		/**
		 * Check if application language file is readable.
		 */
		if (is_readable($langModPath))
		{
			/**
			 * Load module language file.
			 */
			require($langModPath);
		}
		/**
		 * Set module translation list.
		 */
		$lang['MOD'] = $langMod;
		/**
		 * Return main translation list.
		 */
		return $lang;
	}
}
?>