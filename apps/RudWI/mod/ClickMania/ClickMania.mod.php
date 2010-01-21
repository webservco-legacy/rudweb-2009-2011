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
		/**
		 * Check if user is logged in.
		 * Otherwise redirect to login page.
		 */
		$this->_checkAuth();
		/**
		 * Default output.
		 */
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
		/**
		 * Check if user is logged in.
		 * Otherwise redirect to login page.
		 */
		$this->_checkAuth();

		$dataAddTicketOk['lang'] = $this->ticketLang;
		$addTicketOk = $this->rwParse('clickMania/addTicketOk', $dataAddTicketOk);
		return $this->_output($addTicketOk);
	}

	public function addNumbers()
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
		$this->_numAddSetWorkData();
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
			$this->_numAddForm();
		}
		/**
		 * No errors.
		 */
		else
		{
			/**
			 * Add numbers.
			 */
			for ($i=1; $i<=7; $i++)
			{
				$n            = array();
				$n['n_date'] = date('Y-m-d');
				$n['n_value'] = $this->ticketData['n_'.$i];
				$this->rwCore->rwDb->dbInsert(_APP_PRE.'_cm_tnum', NULL, $n);
			}
			/**
			 * Add lucky number.
			 *
			 */
			$l['n_date'] = date('Y-m-d');
			$l['n_value'] = $this->ticketData['l_1'];
			$l['n_lucky'] = 1;
			$this->rwCore->rwDb->dbInsert(_APP_PRE.'_cm_tnum', NULL, $l);
			/**
			 * Check numbers.
			 */
			$this->_checkNumbers($this->ticketWeek, $l['n_date']);
			/**
			 * Redirect to ok message.
			 */
			$this->rwCore->rwExts['Routing']->rwRedirect('ClickMania/addNumOk');
		}
	}

	public function addNumOk()
	{
		/**
		 * Check if user is logged in.
		 * Otherwise redirect to login page.
		 */
		$this->_checkAuth();

		//$this->rwCore->rwDb->dbDebug();

		$dataAddNumOk['lang'] = $this->ticketLang;
		$addNumOk = $this->rwParse('clickMania/addNumOk', $dataAddNumOk);
		return $this->_output($addNumOk);
	}

	public function Tickets()
	{
		/**
		 * Check if user is logged in.
		 * Otherwise redirect to login page.
		 */
		$this->_checkAuth();
		/**
		 * Set current ticket week.
		 */
		$t_week = ($this->modRequest) ? $this->modRequest : $this->ticketWeek;


		$r = $this->rwCore->rwDb->dbSelect('*', _APP_PRE.'_cm_tinfo', "t_week = '{$t_week}'", 't_sn');
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
		$data['week'] = $t_week;
		$ticketList = $this->rwParse('clickMania/ticketList', $data);

		return $this->_output($ticketList);
	}

	public function Ticket()
	{
		/**
		 * Check if user is logged in.
		 * Otherwise redirect to login page.
		 */
		$this->_checkAuth();

		$t_sn = $this->modRequest;
		if (!$t_sn)
		{
			return $this->Tickets();
			exit;
		}

		$r = $this->rwCore->rwDb->dbSelect('t_cell, t_value, t_date', _APP_PRE.'_cm_tdata', "t_sn = '{$t_sn}'");
		$t = $r->dbNumRows();
		if ($t>0)
		{
			while($d = $r->dbFetchArray())
			{
				$cell[$d['t_cell']] = $d;
			}
		}
		$this->_ticketModSetWorkData($t_sn, $cell);

		$this->_ticketParseData();

		if($this->ticketErrNr > 0)
		{
			/**
			 * Display ticket add form.
			 */
			$this->_ticketModForm($t_sn, $cell);
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
		$this->extForms->setValue('errMsgs', $this->rwCore->rwGetLang('MOD', 'TICKET_ERR'));
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
		 * Get ticket week.
		 */
		$w = $this->rwCore->rwDb->dbSelect('t_week', _APP_PRE.'_cm_tinfo', "t_sn = '".$t_sn."'");
		$t_week = $w->dbFetchResult();
		/**
		 * Week.
		 */
		$this->extForms->setWorkData('t_week', $formLang['WEEK'], 'StripTags|RemoveBadChars', 'Required|Min[1]|Max[2]', $t_week);
		/**
		 * Serial number.
		 */
		$this->extForms->setWorkData('t_sn', $formLang['SN'], 'StripTags|RemoveBadChars', 'Required|Min[9]|Max[9]', $t_sn);
		/**
		 * Ticket cells.
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

	private function _numAddForm()
	{
		$dataAddNum['formData'] = $this->ticketData;
		$dataAddNum['formErr'] = $this->ticketErr;
		$dataAddNum['lang'] = $this->ticketLang;

		$addNum = $this->rwParse('clickMania/addNum', $dataAddNum);
		return $this->_output($addNum);
	}

	private function _ticketModForm($t_sn, $data)
	{
		$dataModTicket['formData'] = $this->ticketData;
		$dataModTicket['formErr'] = $this->ticketErr;
		$dataModTicket['lang'] = $this->ticketLang;
		$dataModTicket['cells'] = $this->ticketCells;
		$dataModTicket['cellsDiag'] = $this->ticketCellsDiag;
		$dataModTicket['data'] = $data;
		$dataModTicket['stats'] = $this->_ticketStats($t_sn);

		$modTicket = $this->rwParse('clickMania/modTicket', $dataModTicket);
		return $this->_output($modTicket);
	}

	private function _ticketSetWeek()
	{
		$today = date('Y-m-d');
		$r = $this->rwCore->rwDb->dbSelect('w_id', _APP_PRE.'_cm_tweeks', "w_start <= '".$today."' AND w_end >= '".$today."'");
		$this->ticketWeek = $r->dbFetchResult();
		return TRUE;
	}

	private function _ticketStats($t_sn)
	{
		/**
		 * Init stats data.
		 */
		$data = array();
		/**
		 * Init numbers arrays.
		 */
		$c = array(
		'D1' => array(11, 22, 33, 44, 55, 66, 77),
		'D2' => array(17, 26, 35, 44, 53, 62, 71),
		'L1' => array(11, 12, 13, 14, 15, 16, 17),
		'L2' => array(21, 22, 23, 24, 25, 26, 27),
		'L3' => array(31, 32, 33, 34, 35, 36, 37),
		'L4' => array(41, 42, 43, 44, 45, 46, 47),
		'L5' => array(51, 52, 53, 54, 55, 56, 57),
		'L6' => array(61, 62, 63, 64, 65, 66, 67),
		'L7' => array(71, 72, 73, 74, 75, 76, 77),
		'C1' => array(11, 21, 31, 41, 51, 61, 71),
		'C2' => array(12, 22, 32, 42, 52, 62, 72),
		'C3' => array(13, 23, 33, 43, 53, 63, 73),
		'C4' => array(14, 24, 34, 44, 54, 64, 74),
		'C5' => array(15, 25, 35, 45, 55, 65, 75),
		'C6' => array(16, 26, 36, 46, 56, 66, 76),
		'C7' => array(17, 27, 37, 47, 57, 67, 77)
		);
		/**
		 * Check lucky number.
		 */
		$l = $this->rwCore->rwDb->dbSelect('COUNT(t_sn)', _APP_PRE.'_cm_tdata', "t_sn = '".$t_sn."' AND t_value = (SELECT n_value FROM "._APP_PRE."_cm_tnum WHERE n_date = DATE(NOW()) AND n_lucky = 1)");
		/**
		 * Set lucky number check result.
		 */
		$stats['lucky'] = $l->dbFetchResult();
		/**
		 * Take each numbers list to check.
		 */
		foreach ($c as $item => $nums)
		{
			/**
			 * Set current number list.
			 */
			$nums = implode(', ', $nums);
			/**
			 * Check number list.
			 */
			$r = $this->rwCore->rwDb->dbSelect('COUNT(c_id)', _APP_PRE.'_cm_tdata', "t_sn = '".$t_sn."' AND t_cell IN (".$nums.") AND t_date != '0000-00-00'");
			/**
			 * Set number list check result.
			 */
			$stats['items'][$item] = $r->dbFetchResult();
		}
		/**
		 * Return check results.
		 */
		return $stats;
	}

	/**
	 * Check numbers.
	 *
	 * Numbers must already be added.
	 *
	 * @param integer $week week to wich the tickets belong to
	 * @param string $day day to check
	 * @return mixed result
	 */
	private function _checkNumbers($week, $day)
	{
		/**
		 * Check numbers for selected day and week.
		 */
		$this->rwCore->rwDb->dbUpdate(_APP_PRE.'_cm_tdata', array('t_date' => $day), 't_value IN (SELECT n_value FROM '._APP_PRE.'_cm_tnum WHERE n_date = DATE(NOW()) AND n_lucky = 0) AND t_sn IN (SELECT t_sn FROM '._APP_PRE.'_cm_tinfo WHERE t_week = '.$week.')');
		/**
		 * Return result.
		 */
		return TRUE;
	}

	private function _numAddSetWorkData()
	{
		$formLang = $this->ticketLang;
		for ($i=1;$i<=7;$i++)
		{
			$this->extForms->setWorkData('n_'.$i, $formLang['NUM'].' '. $i, 'StripTags|RemoveBadChars', 'Required|Min[1]|Max[2]');
		}
		$this->extForms->setWorkData('l_1', $formLang['NUM_LUCKY'], 'StripTags|RemoveBadChars', 'Required|Min[1]|Max[2]');
		/**
		 * Return result.
		 */
		return TRUE;
	}

	private function _output($content=NULL, $header=NULL, $menu=NULL, $footer=NULL)
	{
		$dataHeader['lang'] = $this->rwCore->rwGetLang('MOD', 'HEADER');
		$dataHeader['skinURL'] = $_SESSION[_APP_PRE.'_usr']['skin_url'];

		$data['header']  = $header ? $header : $this->rwParse('headerClickMania', $dataHeader);

		$dataMenu['skinURL'] = $_SESSION[_APP_PRE.'_usr']['skin_url'];
		$data['menu']    = $menu ? $menu : $this->rwParse('menuClickMania', $dataMenu);

		$data['content'] = $content ? $content : $this->rwParse('content/default');
		$data['footer']  = $footer ? $footer: $this->rwParse('footerClickMania');

		return $this->rwOutput('layout', $data);
	}
}
?>