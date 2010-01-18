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
$extAbout['Geo']['deps']['ext'] = array('Int');

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
	 * Set session user data.
	 * Must be called after Session->rwSession()
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
		$r = $this->rwDb->dbSelect('country_iso, country_name', _APP_PRE.'_geo_country', NULL, 'country_name ASC');
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
		 * Set visitor IP Address. 
		 */
		$ip = $_SERVER['REMOTE_ADDR'];
		/**
		 * Get country iso from IP database.
		 */
		$r = $this->rwDb->dbSelect('country_iso', _APP_PRE.'_geo_ip', "INET_ATON('{$ip}') BETWEEN ip_start AND ip_end", NULL, 1);
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
		 * Return result.
		 */
		return $vc;
	}
}
?>