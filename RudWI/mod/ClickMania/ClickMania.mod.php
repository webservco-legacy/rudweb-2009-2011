<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>ClickMania module.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-11-16 12:03:00
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
 * Module name.
 */
$modAbout['ClickMania']['name'] = 'ClickMania';
/**
 * Module description.
 */
$modAbout['ClickMania']['desc'] = 'ClickMania module.';
/**
 * Module version.
 */
$modAbout['ClickMania']['ver']  = '$Revision$';
/**
 * Module author.
 */
$modAbout['ClickMania']['auth'] = 'Radu Maier';
/**
 * Module Website URL.
 */
$modAbout['ClickMania']['web']  = 'http://www.rudisoft.net';
/**
 * Module author email.
 */
$modAbout['ClickMania']['mail'] = 'radu@rudisoft.net';
/**
 * Module dependencies.
 */
$modAbout['ClickMania']['deps'] = array();
/**
 * Module library dependencies.
 */
$modAbout['ClickMania']['deps']['lib'] = array('Error', 'Security', 'Database');
/**
 * Module extension dependencies.
 */
$modAbout['ClickMania']['deps']['ext'] = array('Session', 'Users', 'Captcha');
/**
 * Module module dependencies.
 */
$modAbout['ClickMania']['deps']['mod'] = array();

/**
 * rw_Module_ClickMania
 *
 * rw_Module_ClickMania module.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwMod
 */
class rw_Module_ClickMania extends rw_Module implements rw_iModule
{

	/**
	 * $_POST data.
	 *
	 * @var array
	 */
	private $ticketData = array();

	/**
	 * Ticket errors.
	 *
	 * @var array
	 */
	private $ticketErr = array();

	/**
	 * Number of ticket errors
	 *
	 * @var integer
	 */
	private $ticketErrNr = 0;

	/**
	 * Forms extension object.
	 *
	 * Multiple calls to this extension
	 * made it necessary to have a separate object.
	 *
	 * @var mixed
	 */
	private $extForms;

	/**
	 * Users extension object.
	 *
	 * Multiple calls to this extension
	 * made it necessary to have a separate object.
	 *
	 * @var mixed
	 */
	private $extUsers;

	/**
	 * List of ticket cells.
	 *
	 * @var array
	 */
	private $ticketCells = array();

	/**
	 * Diagonally ticket cells.
	 *
	 * @var array
	 */
	private $ticketCellsDiag = array();

	/**
	 * Ticket internationalization list.
	 *
	 * @var array
	 */
	private $ticketLang = array();

	/**
	 * Current week.
	 *
	 * @var integer
	 */
	private $ticketWeek;

	/**
	 * Constructor.
	 *
	 * @param array $modAbout module information
	 * @param mixed $rwCore core engine object
	 * @param mixed $modLocation module location
	 * @param mixed $modRequest module request query
	 * @return mixed result
	 */
	public function __construct($modAbout, $rwCore, $modLocation, $modRequest)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($modAbout, $rwCore, $modLocation, $modRequest);
		/**
		 * Set forms extension object.
		 */
		$this->extForms = $this->rwCore->rwExts['Forms'];
		/**
		 * Set users extension object.
		 */
		$this->extUsers = $this->rwCore->rwExts['Users'];
		/**
		 * Record user activity.
		 */
		$this->extUsers->recordOnline($modLocation, $modRequest);
		/**
		 * Set ticket cells
		 */
		$this->ticketCells = array(
		11,12,13,14,15,16,17,
		21,22,23,24,25,26,27,
		31,32,33,34,35,36,37,
		41,42,43,44,45,46,47,
		51,52,53,54,55,56,57,
		61,62,63,64,65,66,67,
		71,72,73,74,75,76,77
		);
		$this->ticketCellsDiag = array(
		11,17,22,26,33,35,44,53,55,62,66,71,77
		);
		$this->ticketLang = $this->rwCore->rwGetLang('MOD', 'TICKET');
		/**
		 * Set working week.
		 */
		$this->_ticketSetWeek();
	}

	/**
	 * (non-PHPdoc)
	 * @see rudweb/lib/mod/rw_iModule#index()
	 */
	public function index()
	{
		if (!$_SESSION[_APP_PRE.'_usr']['auth'])
		{
			$this->rwCore->rwExts['Routing']->rwRedirect('RudWI');
			exit;
		}
		return $this->_output();
	}

	public function addTicket()
	{
		/**
		 * Check if user is logged in.
		 * Otherwise redirect to login page.
		 */
		$this->_checkAuth();
		/**
		 * Set work data.
		 *
		 * Form fields, Filtering rules, Validation rules).
		 */
		$this->_ticketAddSetWorkData();
		/**
		 * Parse ticket add form.
		 */
		$this->_ticketParseData();
		/**
		 * Check number of errors.
		 */
		if($this->ticketErrNr > 0)
		{
			/**
			 * Display ticket add form.
			 */
			$this->_ticketAddForm();
		}
		/**
		 * No errors.
		 */
		else
		{
			$tinfo['t_sn'] = $this->ticketData['t_sn'];


			/**
			 * Check sn to be unique.
			 */
			$r = $this->rwCore->rwDb->dbSelect('t_sn', _APP_PRE.'_cm_tinfo', 't_sn = \''.$tinfo['t_sn'].'\'');
			$t = $r->dbNumRows();
			if ($t > 0)
			{
				$this->ticketErr['t_sn'] = $this->ticketLang['SN_DUPE'];
				$this->_ticketDisplayForm();
			}

			$tinfo['t_week'] = $this->ticketData['t_week'];
			$tinfo['t_notes'] = '';

			$this->rwCore->rwDb->dbInsert(_APP_PRE.'_cm_tinfo', NULL, $tinfo);

			foreach ($this->ticketCells as $c)
			{
				$tdata            = array();
				$tdata['t_sn']    = $this->ticketData['t_sn'];
				$tdata['t_diag']  = in_array($c, $this->ticketCellsDiag) ? 1 : 0;
				$tdata['t_cell']  = $c;
				$tdata['t_value'] =  $this->ticketData['c_'.$tdata['t_cell']];
				$this->rwCore->rwDb->dbInsert(_APP_PRE.'_cm_tdata', NULL, $tdata);
			}

			$this->rwCore->rwExts['Routing']->rwRedirect('ClickMania/addTicketOk');
		}
	}

	public function addTicketOk()
	{
		$dataAddTicketOk['lang'] = $this->ticketLang;
		$addTicketOk = $this->rwParse('clickMania/addTicketOk', $dataAddTicketOk);
		return $this->_output($addTicketOk);
	}

	public function Tickets()
	{
		$r = $this->rwCore->rwDb->dbSelect('*', _APP_PRE.'_cm_tinfo', "t_week = '{$this->ticketWeek}'");
		$t = $r->dbNumRows();
		$tickets = array();
		if ($t > 0)
		{
			while ($c = $r->dbFetchArray())
			{
				$tickets[] = $this->rwParse('clickMania/ticketInfo', $c);
			}
		}

		$data['ticket'] = $tickets;
		$data['lang'] = $this->ticketLang;
		$ticketList = $this->rwParse('clickMania/ticketList', $data);

		return $this->_output($ticketList);
	}

	public function Ticket()
	{
		$t_sn = $this->modRequest;
		if (!$t_sn)
		{
			return $this->Tickets();
			exit;
		}

		//XXX				$this->rwCore->rwDb->dbDebug();
		$r = $this->rwCore->rwDb->dbSelect('t_cell, t_value, t_date', _APP_PRE.'_cm_tdata', "t_sn = '{$t_sn}'");
		$t = $r->dbNumRows();
		if ($t>0)
		{
			while($d = $r->dbFetchArray())
			{
				$cell[$d['t_cell']] = $d;
			}
		}
		//XXX
		$this->_ticketModSetWorkData($t_sn, $cell);

		$this->_ticketParseData();

		if($this->ticketErrNr > 0)
		{
			/**
			 * Display ticket add form.
			 */
			$this->_ticketModForm($cell);
		}
		else
		{
			echo $this->modLocation;
			echo '<hr>';
			echo $this->modRequest;
		}
	}


	private function _checkAuth()
	{
		if (!$_SESSION[_APP_PRE.'_usr']['auth'])
		{
			$this->rwCore->rwExts['Routing']->rwRedirect('RudWI/login/');
			exit;
		}
		return TRUE;
	}

	private function _ticketParseData()
	{
		/**
		 * Set error messages list.
		 */
		$this->extForms->setErrorMessages($this->rwCore->rwGetLang('MOD', 'TICKET_ERR'));
		/**
		 * Filter and validate form data.
		 */
		$this->extForms->rwForms();
		/**
		 * Get ticket form data.
		 */
		$this->ticketData = $this->extForms->getformData();
		/**
		 * Get ticket form errors.
		 */
		$this->ticketErr = $this->extForms->getformErrors();
		/**
		 * Get number of ticket errors.
		 */
		$this->ticketErrNr = $this->extForms->countFormErrors();
		/**
		 * Return result.
		 */
		return TRUE;
	}

	private function _ticketAddSetWorkData()
	{
		$formLang = $this->ticketLang;
		/**
		 * Week
		 */
		$this->extForms->setWorkData('t_week', $formLang['WEEK'], 'StripTags|RemoveBadChars', 'Required|Min[1]|Max[2]', $this->ticketWeek);
		/**
		 * Serial number
		 */
		$this->extForms->setWorkData('t_sn', $formLang['SN'], 'StripTags|RemoveBadChars', 'Required|Min[9]|Max[9]');
		/**
		 * Ticket cells
		 */
		foreach($this->ticketCells as $cell)
		{
			$this->extForms->setWorkData('c_'.$cell, $formLang['CELL'].' '. $cell, 'StripTags|RemoveBadChars', 'Required|Min[1]|Max[2]');
		}
		/**
		 * Return result.
		 */
		return TRUE;
	}

	private function _ticketModSetWorkData($t_sn, $data)
	{
		$formLang = $this->ticketLang;
		/**
		 * Week
		 */
		$this->extForms->setWorkData('t_week', $formLang['WEEK'], 'StripTags|RemoveBadChars', 'Required|Min[1]|Max[2]', $this->ticketWeek);
		/**
		 * Serial number
		 */
		$this->extForms->setWorkData('t_sn', $formLang['SN'], 'StripTags|RemoveBadChars', 'Required|Min[9]|Max[9]', $t_sn);
		/**
		 * Ticket cells
		 */
		foreach ($data as $c)
		{
			$this->extForms->setWorkData('c_'.$c['t_cell'], $formLang['CELL'].' '. $c['t_cell'], 'StripTags|RemoveBadChars', 'Required|Min[1]|Max[2]', $c['t_value']);
		}
		/**
		 * Return result.
		 */
		return TRUE;
	}

	private function _ticketAddForm()
	{
		$dataAddTicket['formData'] = $this->ticketData;
		$dataAddTicket['formErr'] = $this->ticketErr;
		$dataAddTicket['lang'] = $this->ticketLang;
		$dataAddTicket['cells'] = $this->ticketCells;
		$dataAddTicket['cellsDiag'] = $this->ticketCellsDiag;

		$addTicket = $this->rwParse('clickMania/addTicket', $dataAddTicket);
		return $this->_output($addTicket);
	}

	private function _ticketModForm($data)
	{
		//XXX
		$dataModTicket['formData'] = $this->ticketData;
		$dataModTicket['formErr'] = $this->ticketErr;
		$dataModTicket['lang'] = $this->ticketLang;
		$dataModTicket['cells'] = $this->ticketCells;
		$dataModTicket['cellsDiag'] = $this->ticketCellsDiag;
		$dataModTicket['data'] = $data;

		$modTicket = $this->rwParse('clickMania/modTicket', $dataModTicket);
		return $this->_output($modTicket);
	}

	private function _ticketSetWeek()
	{
		$today = date('Y-m-d');
		$r = $this->rwCore->rwDb->dbSelect('w_id', _APP_PRE.'_cm_tweeks', 'w_start < \''.$today.'\' AND w_end > \''.$today.'\'');
		$this->ticketWeek = $r->dbFetchResult();
		return TRUE;
	}


	private function _output($content=NULL, $header=NULL, $menu=NULL, $footer=NULL)
	{
		$dataHeader['lang'] = $this->rwCore->rwGetLang('MOD', 'HEADER');
		$dataHeader['skinURL'] = $_SESSION[_APP_PRE.'_usr']['skin_url'];

		$data['header']  = $header ? $header : $this->rwParse('headerClickMania', $dataHeader);

		$dataMenu['skinURL'] = $_SESSION[_APP_PRE.'_usr']['skin_url'];
		$data['menu']    = $menu ? $menu : $this->rwParse('menu', $dataMenu);

		$data['content'] = $content ? $content : $this->rwParse('content/default');
		$data['footer']  = $footer ? $footer: $this->rwParse('footer');

		return $this->rwOutput('layout', $data);
	}


}
?>