<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Simple email sending extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2010-01-21 17:32:00
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
$extAbout['Mail']['name'] = 'Mail';
/**
 * Extension description.
 */
$extAbout['Mail']['desc'] = 'Email sending methods.';
/**
 * Extension version.
 */
$extAbout['Mail']['ver']  = '$Revision$';
/**
 * Extension author.
 */
$extAbout['Mail']['auth'] = 'Radu Maier';
/**
 * Extension Website URL.
 */
$extAbout['Mail']['web']  = 'http://www.rudisoft.net';
/**
 * Extension author email.
 */
$extAbout['Mail']['mail'] = 'radu@rudisoft.net';
/**
 * Extension dependencies.
 */
$extAbout['Mail']['deps'] = array();
/**
 * Extension library dependencies.
 */
$extAbout['Mail']['deps']['lib'] = array('Error');
/**
 * Extension extension dependencies.
 */
$extAbout['Mail']['deps']['ext'] = array();

/**
 * rw_Extension_Mail.
 *
 * rw_Extension_Mail extension.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @package    rwExt
 */
class rw_Extension_Mail extends rw_Extension implements rw_iExtension
{
	/**
	 * Sender name.
	 *
	 * @var string
	 */
	protected $fromName = NULL;

	/**
	 * Sender email address.
	 *
	 * @var string
	 */
	protected $fromMail = NULL;

	/**
	 * Receiver data.
	 *
	 * array(mail1=>name1, mail2=>name2)
	 *
	 * @var array
	 */
	protected $toData = array();

	/**
	 * Message headers.
	 *
	 * @var string
	 */
	private $headers;

	/**
	 * Message subject.
	 *
	 * @var string.
	 */
	protected $subject;

	/**
	 * Message body.
	 *
	 * @var string
	 */
	protected $message;

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
	 * Send email using already set values.
	 *
	 * @param boolean $html whether to use html in mail.
	 * @return mixed result
	 */
	public function rwMail($html=TRUE)
	{
		/**
		 * Check if required data is set.
		 */
		$this->_checkForData();
		/**
		 * Set message headers.
		 */
		$this->_setHeaders($html);
		/**
		 * Format message to html if required.
		 */
		$this->message = ($html) ? '<html><body>'.$this->message.'</body></html>' : $this->message;
		/**
		 * Try to send email and return result.
		 */
		return (@mail($this->_getRecipient(), $this->subject, $this->message, $this->headers, '-r '.$this->_getSender())) ? TRUE : FALSE;
	}

	/**
	 * Set message headers.
	 *
	 * @param boolean $html whether to use html in mail.
	 * @return mixed result
	 */
	private function _setHeaders($html)
	{
		/**
		 * Initialize headers. MIME and content-type.
		 */
		$h  = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/';
		/**
		 * Check is we shoud set output as html and set it.
		 */
		$h .= ($html) ? 'html' : 'plain';
		/**
		 * Set charset and add a new line.
		 */
		$h .= '; charset=utf-8' . "\r\n";
		/**
		 * Initialize recipinet data.
		 */
		$h .= 'To: ';
		/**
		 * Set recipient data.
		 */
		$h .= $this->_getRecipient();
		/**
		 * Add a new line.
		 */
		$h .= "\r\n";
		/**
		 * Initialize sender data.
		 */
		$h .= 'From: ';
		/**
		 * Set sender data.
		 */
		$h .= $this->_getSender();
		/**
		 * Add a new line.
		 */
		$h .= "\r\n";
		/**
		 * Initilize reply data.
		 */
		$h .= 'Reply-To: ';
		/**
		 * Set reply data.
		 */
		$h .= $this->_getSender();
		/**
		 * Add a new line.
		 */
		$h .= "\r\n";
		/**
		 * Set the headers.
		 */
		$this->headers = $h;
		/**
		 * Return result.
		 */
		return TRUE;
	}

	/**
	 * Get message recipient(s).
	 *
	 * Format data as a string.
	 *
	 * @return string message recipients
	 */
	private function _getRecipient()
	{
		/**
		 * Count recipients.
		 */
		$toData = count($this->toData);
		/**
		 * Start counter.
		 */
		$to = 1;
		/**
		 * Initialize string.
		 */
		$r = '';
		/**
		 * Process each recipient.
		 */
		foreach($this->toData as $toMail => $toName)
		{
			/**
			 * Check if we have recipient name and set string accordingly.
			 */
			$r .= ($toName) ? $toName .' <'.$toMail.'>' : $toMail;
			/**
			 * If this is not the last recipient, add acomma and space.
			 */
			$r .= ($to != $toData) ? ', ' : '';
			/**
			 * Increment counter.
			 */
			$to++;
		}
		/**
		 * Return formatted recipients string.
		 */
		return $r;
	}

	/**
	 * Get message sender.
	 *
	 * Format data as a string.
	 *
	 * @return string message sender
	 */
	private function _getSender()
	{
		/**
		 * Return formatted sender string.
		 */
		return ($this->fromName)? $this->fromName.' <'.$this->fromMail.'>' : $this->fromMail;
	}

	/**
	 * Check if required data is set.
	 *
	 * @return mixed result
	 */
	private function _checkForData()
	{
		/**
		 * Check if sender mail is set.
		 */
		if((!$this->fromMail)
		/**
		 * Check if we have any recipients.
		 */
		|| (!is_array($this->toData))
		/*
		 * Check if subject is set.
		 */
		|| (!$this->subject)
		/**
		 * Check if message is set.
		 */
		|| (!$this->message))
		{
			/**
			 * Display error message.
			 */
			trigger_error('Extension::Mail Can not send email. Not enough info.', 256);
		}
		/**
		 * Return result.
		 */
		return TRUE;
	}
}
?>