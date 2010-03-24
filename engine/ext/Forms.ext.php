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
$extAbout['Forms']['deps']['lib'] = array('Error', 'Security');
/**
 * Extension extension dependencies.
 */
$extAbout['Forms']['deps']['ext'] = array('Filesystem');

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
	 * This must be set before main extension functionality is called.
	 *
	 * @var mixed
	 */
	protected $rwSec = NULL;

	/**
	 * Routing extension object.
	 *
	 * @var mixed
	 */
	protected $extFilesystem;

	/**
	 * Localized error messages.
	 *
	 * List of error messages usually from a language file.
	 *
	 * @var array
	 */
	protected $errMsgs = array();

	/**
	 * Work data.
	 *
	 * This consists of:
	 * field name,
	 * field title,
	 * filtering rules,
	 * validation rules.
	 *
	 * @var array
	 */
	private $workData = array();

	/**
	 * Parsed form data.
	 *
	 * Form data after filering and validation.
	 *
	 * @var array
	 */
	private $formData = array();

	/**
	 * Form errors.
	 *
	 * Form errors after filtering and validation.
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
	 * @return mixed result.
	 */
	public function rwForms()
	{
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
			$formData[$field['name']] = $field['defaultValue'];
			/**
			 * Check if form was submitted.
			 */
			if (isset($_POST[_APP_PRE.'_submit']))
			{
				/**
				 * Set form data for current work data.
				 *
				 * If we have post data for current work data,
				 * filter post data according to rules from work data.
				 * Otherwise set to NULL.
				 */
				$formData[$field['name']] = (isset($_POST[$field['name']])) ? $this->_filterData($_POST[$field['name']], $field['filters']) : NULL;
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
	 * Fix flash upload session bug.
	 *
	 * @return mixed result
	 */
	public function rwUploadFlashFix()
	{
		/**
		 * Get session id.
		 *
		 * Check if we got it through post, otherwise is NULL.
		 */
		$sid = (isset($_POST[_APP_PRE.'_sid'])) ? $this->rwSec->rwStripTags($_POST[_APP_PRE.'_sid']) : NULL;
		/**
		 * Check if we have a session id.
		 */
		if($sid)
		{
			/**
			 * Set session id.
			 */
			session_id($sid);
		}
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Check uploaded file for errors
	 *
	 * @param string $file name of files array
	 * @param array $types allowed file types
	 * @return mixed result
	 */
	public function rwUploadValidate($file, $types)
	{
		/**
		 * Check if we have a valid upload.
		 */
		if(!isset($_FILES[$file]))
		{
			/**
			 * Return result (no upload).
			 */
			return 10;
		}
		/**
		 * POST Content-length PHP "bug" - set error message to monitor.
		 */
		$error = function_exists('error_get_last') ? error_get_last() : NULL;
		/**
		 * POST Content-length PHP "bug" - check if we got the error message.
		 */
		if(is_array($error) && (FALSE !== strpos($error['message'], 'POST Content-Length of')))
		{
			/**
			 * Return result (file too large).
			 */
			return 13;
		}
		/**
		 * Check if file is really uploaded.
		 */
		if(!is_uploaded_file($_FILES[$file]['tmp_name']))
		{
			/**
			 * Return result (file not sent through upload form).
			 */
			return 11;
		}
		/**
		 * Get file type.
		 */
		$mime = $this->extFilesystem->getFileMime($_FILES[$file]['tmp_name']);
		/**
		 * Check if file type is forbidden.
		 */
		if(!in_array($mime, $types))
		{
			/**
			 * Return result (file type forbidden).
			 */
			return 12;
		}
		/**
		 * At this point we should only have left the standard error codes.
		 * So we just return the eror code.
		 */
		return $_FILES[$file]['error'];
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
			$ruleFunc = 'rw'.$rule;
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
				$ruleFunc  = 'rw' . $match[1];
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
	public function rwRequired($data)
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
	public function rwValidEmail($data)
	{
		/**
		 * Set valid email rule.
		 */
		$match = "/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i";
		/**
		 * Check if data is a valid email address.
		 *
		 * Return result.
		 */
		return (preg_match($match, $data)) ? TRUE : FALSE;
	}

	public function rwUniqueEmail($data)
	{

	}

	/**
	 * Valid password check.
	 *
	 * Form validation methid.
	 *
	 * @param mixed $data form data to check
	 * @return mixed result
	 */
	public function rwValidPass($data)
	{
		/**
		 * Set valid password to contain both letters and numbers.
		 */
		$match = "/^.*(?=.*\d)(?=.*[A-z]).*$/";
		/**
		 * Check if data is a valid password.
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
	public function rwMin($data, $length=0)
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
	public function rwMax($data, $length=0)
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
	public function rwEquals($data, $match)
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
	public function rwValidCaptcha($data, $captcha)
	{
		/**
		 * Check if data matches captcha.
		 *
		 * Return result.
		 */
		return ($data !== $captcha) ? FALSE : TRUE;
	}

	/**
	 * Numeric check.
	 *
	 * Form validation method.
	 *
	 * @param mixed $data form data to check
	 * @return mixed result
	 */
	public function rwNum($data)
	{
		/**
		 * Check if data is numeric.
		 *
		 * Return result.
		 */
		return (is_numeric($data)) ? TRUE : FALSE;
	}

	/**
	 * Minimum numeric check.
	 *
	 * Form validation method.
	 *
	 * @param mixed $data form data to check
	 * @param integer $min minimum value
	 * @return mixed result
	 */
	public function rwNumMin($data, $min=0)
	{
		/**
		 * Check data value.
		 *
		 * Return result.
		 */
		return ($data < $min) ? FALSE : TRUE;
	}

	/**
	 * Maximum numeric check.
	 *
	 * Form validation method.
	 *
	 * @param mixed $data form data to check
	 * @param integer $max maximum value
	 * @return mixed result
	 */
	public function rwNumMax($data, $max=0)
	{
		/**
		 * Check data value.
		 *
		 * Return result.
		 */
		return ($data > $max) ? FALSE : TRUE;
	}

	/**
	 * Parse error mesage.
	 *
	 * @param string $rule rule (method) for which to display error message.
	 * @param string $label form label
	 * @param mixed $required requiredcondition which is not met
	 * @return mixed result.
	 */
	private function _parseErrorMessage($rule, $label, $required=0)
	{
		/**
		 * Set error message.
		 *
		 * Check if the specified rule (method) exists.
		 * If not, set to default error message.
		 */
		$errorMessage = (array_key_exists($rule, $this->errMsgs)) ? $this->errMsgs[$rule] : $this->errMsgs['default'];
		/**
		 * Parse error message text.
		 *
		 * Return result.
		 */
		return str_replace('$required$', $required, str_replace('$label$', $label, $errorMessage));
	}

	/**
	 * Set work data.
	 *
	 * Add work data to work data array.
	 *
	 * @param string $fieldName form field name
	 * @param string $fieldTitle form field title
	 * @param string $fieldFilters form field filtering rules string
	 * @param string $fieldValidation form field validation rules string
	 * @return mixed result
	 */
	public function setWorkData($fieldName, $fieldTitle, $fieldFilters, $fieldValidation=NULL, $fieldDefaultValue=NULL)
	{
		/**
		 * Set work data.
		 */
		$this->workData[] = array(
			'name' => $fieldName,	
			'title' => $fieldTitle,
			'filters' => $fieldFilters,
			'validation' => $fieldValidation,
			'defaultValue' => $fieldDefaultValue
		);
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Get form data.
	 *
	 * This is usually called after filtering and validation
	 * in order to get the form data.
	 *
	 * @return array form data
	 */
	public function getFormData()
	{
		/**
		 * Return form data.
		 */
		return $this->formData;
	}

	/**
	 * Get form errors.
	 *
	 * This is usually called after filtering and validation
	 * in order to get the form errors.
	 *
	 * @return array form errors
	 */
	public function getFormErrors()
	{
		/*
		 * Return form errors.
		 */
		return $this->formErrors;
	}

	/**
	 * Count form errors.
	 *
	 * This returns the number of actual form errors.
	 * The form errors array contains keys
	 * even if there is no errror, so counting
	 * the result of the get form errors method
	 * doesn't work as expected.
	 *
	 * @param integer $count start counting from this value
	 * @return integer number of actual form errors
	 */
	public function countFormErrors($count=0)
	{
		/**
		 * Parse each form error.
		 */
		foreach ($this->formErrors as $error)
		{
			/**
			 * Check if we do actually have an error for current form error.
			 */
			if ($error)
			{
				/**
				 * Increment counter.
				 */
				$count++;
			}
		}
		/**
		 * Return number of errors.
		 */
		return $count;
	}
}
?>