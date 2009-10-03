<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Forms extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-23 16:01:00
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
$extAbout['Forms']['name'] = 'Forms';
/**
 * Extension description.
 */
$extAbout['Forms']['desc'] = 'Form processing methods.';
/**
 * Extension version.
 */
$extAbout['Forms']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Forms']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Forms']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Forms']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Forms']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Forms']['deps']['lib'] = array('Error', 'Database');
/**
 * Extension extension dependencies.
 */
$extAbout['Forms']['deps']['ext'] = array('Users');

/**
 * rw_Extension_Forms.
 *
 * rw_Extension_Forms extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Forms extends rw_Extension implements rw_iExtension
{
	public $formData = array();

	public $formErrors = array();

	public $postData = array();
	
	public $errMsgs = array();

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
	public function rwForms($rwSec)
	{
		$this->rwSec = $rwSec;

		if (count($this->postData) == 0)
		{
			return FALSE;
		}
		foreach ($this->postData as $field)
		{
			$formErrors[$field['name']] = NULL;
			$formData[$field['name']] = NULL;

			if (isset($_POST[_APP_PRE.'_submit']))
			{
				if (isset($_POST[$field['name']]))
				{
					$formData[$field['name']] = $this->_filterData($_POST[$field['name']], $field['filters']);
				}
				$formErrors[$field['name']] = $this->_validateData($formData[$field['name']], $field['title'], $field['validation']);
			}
			else
			{
				$formErrors['submit'] = 'no submit';
			}
		}
		$this->formData = $formData;
		$this->formErrors = $formErrors;
	}

	private function _filterData($data, $filters)
	{
		$filters = array_diff(explode('|', $filters), array(''));
		foreach ($filters as $filter)
		{
			$function = 'rw'.$filter;
			$data = $this->rwSec->$function($data);
		}
		return $data;
	}

	private function _validateData($data, $label, $validation)
	{
		$result = NULL;
		$rules = array_diff(explode('|', $validation), array(''));
		// no data but not required.
		if (!$data && (!in_array('Required', $rules)))
		{
			return $result;
		}

		foreach ($rules as $rule)
		{
			$ruleFunc = '_rw'.$rule;
			$ruleParam = FALSE;
			if (preg_match("/(.*?)\[(.*?)\]/", $rule, $match))
			{
				$ruleFunc  = '_rw' . $match[1];
				$ruleParam = $match[2];
			}
			$validation = $this->$ruleFunc($data, $ruleParam);
			if(!$validation)
			{
				return $this->_parseErrorMessage($ruleFunc, $label, $ruleParam);
			}
		}
		return $result;
	}

	private function _rwRequired($data)
	{
		return (!$data || $data == '') ? FALSE : TRUE;
	}

	private function _rwValidEmail($data)
	{
		$match = "/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i";
		return (preg_match($match, $data)) ? TRUE : FALSE;
	}

	private function _rwMin($data, $length=0)
	{
		/**
		 * Check if mbsting extension is available.
		 */
		$f = (function_exists('mb_internal_encoding')) ? 'mb_strlen' : 'strlen';
		return ($f($data) < $length) ? FALSE : TRUE;
	}

	private function _rwMax($data, $length=0)
	{
		/**
		 * Check if mbsting extension is available.
		 */
		$f = (function_exists('mb_internal_encoding')) ? 'mb_strlen' : 'strlen';
		return ($f($data) > $length) ? FALSE : TRUE;
	}

	private function _rwEquals($data, $match)
	{
		return ($data !== $match) ? FALSE : TRUE;
	}

	private function _parseErrorMessage($rule, $label, $required=0)
	{
		$errorMessage = (array_key_exists($rule, $this->errMsgs)) ? $this->errMsgs[$rule] : $this->errMsgs['default'];

		return str_replace('$required$', $required, str_replace('$label$', $label, $errorMessage));
	}

	public function setErrorMessages($errMsgs)
	{
		$this->errMsgs = $errMsgs;
	}
	
	public function setPostData($fieldName, $fieldTitle, $fieldFilters, $fieldValidation)
	{
		$this->postData[] = array(
			'name' => $fieldName,	
			'title' => $fieldTitle,
			'filters' => $fieldFilters,
			'validation' => $fieldValidation
		);
	}

	public function countFormErrors($count=0)
	{
		foreach ($this->formErrors as $error)
		{
			if ($error)
			{
				$count++;
			}
		}
		return $count;
	}
}
?>