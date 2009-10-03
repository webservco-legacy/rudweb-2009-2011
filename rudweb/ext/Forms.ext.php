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
	/**
	 * Security library object.
	 *
	 * @var mixed
	 */
	private $rwSec = NULL;

	/**
	 * Localized error messages.
	 *
	 * @var array
	 */
	private $errMsgs = array();

	/**
	 * Work data.
	 *
	 * @var array
	 */
	private $workData = array();

	/**
	 * Parsed form data.
	 *
	 * @var array
	 */
	private $formData = array();

	/**
	 * Form errors.
	 *
	 * @var array
	 */
	private $formErrors = array();

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
	 * @param $rwSec security elibrary object
	 *
	 * @return mixed result.
	 */
	public function rwForms($rwSec)
	{
		/**
		 * Set security library object.
		 *
		 */
		$this->rwSec = $rwSec;
		/**
		 * Check if we have data to work with.
		 */
		if (count($this->workData) == 0)
		{
			/**
			 * No data to parse, nothing to do.
			 * Stop execution.
			 */
			return FALSE;
		}
		/**
		 * Parse each work data.
		 */
		foreach ($this->workData as $field)
		{
			/**
			 * Init form error for current work data.
			 */
			$formErrors[$field['name']] = NULL;
			/**
			 * Init form data for current work data.
			 */
			$formData[$field['name']] = NULL;
			/**
			 * Check if form was submitted.
			 */
			if (isset($_POST[_APP_PRE.'_submit']))
			{
				/**
				 * Check if we have post data for current work data.
				 */
				if (isset($_POST[$field['name']]))
				{
					/**
					 * Set form data for current work data.
					 *
					 * Filter post data according to rules from work data.
					 */
					$formData[$field['name']] = $this->_filterData($_POST[$field['name']], $field['filters']);
				}
				/**
				 * Set form error for current work data.
				 *
				 * Validate form data according to rules from work data.
				 */
				$formErrors[$field['name']] = $this->_validateData($formData[$field['name']], $field['title'], $field['validation']);
			}
			/**
			 * Form was not submitted.
			 */
			else
			{
				/**
				 * This is not an error,
				 * but we set one so we can know where we stand.
				 */
				$formErrors['submit'] = 'no submit';
			}
		}
		/**
		 * Set class level form data.
		 */
		$this->formData = $formData;
		/**
		 * Set class level form errors.
		 *
		 */
		$this->formErrors = $formErrors;
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Filter form data.
	 *
	 * Uses the security library object
	 * to filter data according to rules.
	 *
	 * @param mixed $data data to filter
	 * @param mixed $filters filter rule(s) to apply
	 * @return mixed result
	 */
	private function _filterData($data, $filters)
	{
		/**
		 * Get filters.
		 */
		$filters = array_diff(explode('|', $filters), array(''));
		/**
		 * Parse each filter.
		 */
		foreach ($filters as $filter)
		{
			/**
			 * Set function name.
			 */
			$function = 'rw'.$filter;
			/**
			 * Do actual filtering.
			 */
			$data = $this->rwSec->$function($data);
		}
		/**
		 * Return filtered data.
		 */
		return $data;
	}

	/**
	 * Validate form data.
	 *
	 * @param mixed $data data o validate
	 * @param mixed $label form label
	 * @param mixed $validation validation rule(s) to apply
	 * @return mixed result
	 */
	private function _validateData($data, $label, $validation)
	{
		/**
		 * Init validation result.
		 */
		$result = NULL;
		/**
		 * Get validation rules.
		 */
		$rules = array_diff(explode('|', $validation), array(''));
		/**
		 * Check if data is missing,
		 * and if the data is required.
		 */
		if (!$data && (!in_array('Required', $rules)))
		{
			/**
			 * No data present, but it is not required.
			 */
			return $result;
		}
		/**
		 * Parse each validation rule.
		 */
		foreach ($rules as $rule)
		{
			/**
			 * Set function name.
			 */
			$ruleFunc = '_rw'.$rule;
			/**
			 * Set function parameter.
			 */
			$ruleParam = FALSE;
			/**
			 * Check if we have parameters.
			 */
			if (preg_match("/(.*?)\[(.*?)\]/", $rule, $match))
			{
				/**
				 * Set function name.
				 */
				$ruleFunc  = '_rw' . $match[1];
				/**
				 * Set function parameter.
				 */
				$ruleParam = $match[2];
			}
			/**
			 * Do actual validation.
			 */
			$validation = $this->$ruleFunc($data, $ruleParam);
			/**
			 * Check if validation failed.
			 */
			if(!$validation)
			{
				/**
				 * Parse error mesage for current validation.
				 *
				 * Return form error.
				 */
				return $this->_parseErrorMessage($ruleFunc, $label, $ruleParam);
			}
		}
		/**
		 * Return result.
		 */
		return $result;
	}

	/**
	 * Required field check.
	 *
	 * Form validation method.
	 *
	 * @param mixed $data form data to check
	 * @return mixed result
	 */
	private function _rwRequired($data)
	{
		/**
		 * Check if data is not set or blank.
		 *
		 * Return result.
		 */
		return (!$data || $data == '') ? FALSE : TRUE;
	}

	/**
	 * Valid email check.
	 *
	 * Form validation method.
	 *
	 * @param mixed $data form data to check
	 * @return mixed result
	 */
	private function _rwValidEmail($data)
	{
		/**
		 * Set valid email rule
		 */
		$match = "/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i";
		/**
		 * Check if data is a valid email address.
		 *
		 * Return result.
		 */
		return (preg_match($match, $data)) ? TRUE : FALSE;
	}

	/**
	 * Minimum length check.
	 *
	 * Form validation method.
	 *
	 * @param mixed $data form data to check
	 * @param integer $length minimum data length
	 * @return mixed result
	 */
	private function _rwMin($data, $length=0)
	{
		/**
		 * Set function name.
		 *
		 * Check if mbsting extension is available.
		 */
		$f = (function_exists('mb_internal_encoding')) ? 'mb_strlen' : 'strlen';
		/**
		 * Check data length.
		 *
		 * Return result.
		 */
		return ($f($data) < $length) ? FALSE : TRUE;
	}

	/**
	 * Maximum length check.
	 *
	 * Form validation method.
	 *
	 * @param mixed $data form data to check
	 * @param integer $length maximum data length
	 * @return mixed result
	 */
	private function _rwMax($data, $length=0)
	{
		/**
		 * Set function name.
		 *
		 * Check if mbsting extension is available.
		 */
		$f = (function_exists('mb_internal_encoding')) ? 'mb_strlen' : 'strlen';
		/**
		 * Check data length.
		 *
		 * Return result.
		 */
		return ($f($data) > $length) ? FALSE : TRUE;
	}

	/**
	 * Equal value check.
	 *
	 * Form validation method.
	 *
	 * @param mixed $data form data to check
	 * @param mixed $match match to check against
	 * @return mixed result
	 */
	private function _rwEquals($data, $match)
	{
		/**
		 * Check if data is the same as the match.
		 *
		 * Return result.
		 */
		return ($data !== $match) ? FALSE : TRUE;
	}

	/**
	 * Captcha validation.
	 *
	 * Form validation method.
	 * This is similar to equal value check method,
	 * but the error message differs, hence the separate method.
	 *
	 * @param mixed $data form data to check
	 * @param mixed $captcha session captcha
	 * @return mixed result
	 */
	private function _rwValidCaptcha($data, $captcha)
	{
		/**
		 * Check if data matches captcha.
		 *
		 * Return result.
		 */
		return ($data !== $captcha) ? FALSE : TRUE;
	}

	//XXX parse error message.
	private function _parseErrorMessage($rule, $label, $required=0)
	{
		$errorMessage = (array_key_exists($rule, $this->errMsgs)) ? $this->errMsgs[$rule] : $this->errMsgs['default'];

		return str_replace('$required$', $required, str_replace('$label$', $label, $errorMessage));
	}

	public function setErrorMessages($errMsgs)
	{
		$this->errMsgs = $errMsgs;
	}

	public function setWorkData($fieldName, $fieldTitle, $fieldFilters, $fieldValidation)
	{
		$this->workData[] = array(
			'name' => $fieldName,	
			'title' => $fieldTitle,
			'filters' => $fieldFilters,
			'validation' => $fieldValidation
		);
	}

	public function getFormData()
	{
		return $this->formData;
	}

	public function getFormErrors()
	{
		return $this->formErrors;
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