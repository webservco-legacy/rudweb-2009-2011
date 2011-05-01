<?php
/**
 * $Id$
 *
 * Mail library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudMail
 * @version    $Revision$
 * @since      Version 5
 * @access     public
 * @filesource
 */

/**
 * Security check.
 */
if ( !defined( '_RUDWEB' ) )
{
	/**
	 * Stop script execution.
	 */
	exit();
}

/**
 * Mail library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudMail
 *
 */
class Mail extends Library
{
	/**
	 * Stores recipient(s) address(es)
	 *
	 * @var array
	 */
	protected $_mTo = array();

	/**
	 * Stores sender address.
	 *
	 * @var string
	 */
	protected $_mFrom = NULL;

	/**
	 * Stores reply-to address.
	 *
	 * @var string
	 */
	protected $_mReplyTo = NULL;

	/**
	 * Stores cc address(es).
	 *
	 * @var array
	 */
	protected $_mCc = array();

	/**
	 * Stores bcc address(es).
	 *
	 * @var array
	 */
	protected $_mBcc = array();

	/**
	 * Stores attachment data.
	 *
	 * @var array
	 */
	protected  $_mAttach = array();

	/**
	 * Stores message content-type
	 *
	 * @var string
	 */
	protected $_mContentType;

	/**
	 * Stores message encoding.
	 *
	 * @var string
	 */
	protected $_mEncoding;

	/**
	 * Storesmessage charset.
	 *
	 * @var string
	 */
	protected $_mCharset;

	/**
	 * Stores messageline ending.
	 *
	 * @var string
	 */
	protected $_mEol;

	/**
	 * Sets whether to use envelope from.
	 *
	 * @var bool
	 */
	protected $_mEnvFrom = FALSE;

	/**
	 * Stores header data.
	 *
	 * @var array
	 */
	protected $_mHeaders = array();

	/**
	 * Implement GetInstance() method.
	 *
	 * This is required for PHP < 5.3 compatibility ( no late static binding )
	 *
	 * @param string $className class name to instantiate
	 *
	 * @return object
	 */
	public static function GetInstance( $className = __CLASS__ )
	{
		/**
		 * Call parent method with current class name as parameter.
		 */
		return parent::_GetInstance( $className );
	}

	/**
	 * Set default data.
	 *
	 * @return bool
	 */
	public function SetDefaults()
	{
		/**
		 * @var array
		 */
		$config = Core::Config()->Get( 'mail' );

		/**
		 * @var string
		 */
		$this->_mContentType = ( !empty( $config['content_type'] ) ) ? $config['content_type'] : 'plain';

		/**
		 * @var string
		 */
		$this->_mEncoding = ( !empty( $config['encoding'] ) ) ? $config['encoding'] : '7bit';

		/**
		 * @var string
		 */
		$this->_mCharset = ( !empty( $config['charset'] ) ) ? $config['charset'] : 'utf-8';

		/**
		 * @var string
		 */
		$this->_mEnvFrom = ( 1 == $config['env_from'] ) ? TRUE: FALSE;

		/**
		 * @var string
		 */
		$this->_mEol = PHP_EOL;

		return TRUE;
	}

	/**
	 * Add an address.
	 *
	 * @param string $addEmail
	 * @param string $addType
	 * @param string $addName
	 *
	 * @return bool
	 */
	public function AddAddress( $addEmail, $addType = 'to', $addName = NULL )
	{
		if ( empty( $this->_mEol ) )
		{
			$this->SetDefaults();
		}

		/**
		 * @var string
		 */
		$address = ( !empty( $addName ) ) ? "{$addName} <{$addEmail}>" : $addEmail;

		if ( empty( $address ) )
		{
			Core::Log()->Write( __( 'Mail Library: Error adding empty address.', 'RudWEb' ), 'error' );

			return FALSE;
		}

		switch ( $addType )
		{
			case 'cc' :

				/**
				 * @var array
				 */
				$this->_mCc[] = $address;

				break;

			case 'bcc' :

				/**
				 * @var array
				 */
				$this->_mBcc[] = $address;

				break;

			case 'from' :

				/**
				 * @var string
				 */
				$this->_mFrom = $address;

				break;

			case 'replyto' :

				/**
				 * @var string
				 */
				$this->_mReplyTo = $address;

				break;

			case 'to' :
			default :

				/**
				 * @var array
				 */
				$this->_mTo[] = $address;

				break;
		}

		return TRUE;
	}

	/**
	 * Add attachments.
	 *
	 * @param string $attachPath
	 * @param string $attachType
	 * @param string $attachName
	 *
	 * @return bool
	 */
	public function AddAttachment( $attachPath, $attachType = NULL, $attachName = NULL )
	{
		if ( empty( $this->_mEol ) )
		{
			$this->SetDefaults();
		}

		if( !is_readable( $attachPath ) )
		{
			/**
			 * @var string
			 */
			$msg = sprintf( __( 'Mail Library: Error adding attachment "%s". File not found.', 'RudWEb' ), $attachPath );

			Core::Log()->Write( $msg, 'error' );

			return FALSE;
		}

		/**
		 * @var string
		 */
		$attach_type = ( !empty( $attachType ) ) ? $attachType : 'application/octet-stream';

		/**
		 * @var string
		 */
		$attach_name = ( !empty( $attachName ) ) ? $attachName : basename( $attachPath );

		/**
		 * @var array
		 */
		$this->_mAttach[] = array( $attachPath, $attach_type, $attach_name );

		/**
		 * @var string
		 */
		$msg = sprintf( __( 'Mail Library: Added attachment "%s".', 'RudWEb' ), $attachPath );

		Core::Log()->Write( $msg, 'error' );

		return TRUE;
	}

	/**
	 * Add header data.
	 *
	 * @param string $headerName
	 * @param string $headerValue
	 *
	 * @return bool
	 */
	public function AddHeader( $headerName, $headerValue )
	{
		if ( empty( $this->_mEol ) )
		{
			$this->SetDefaults();
		}

		/**
		 * @var array
		 */
		$this->_mHeaders[$headerName] = $headerValue;

		return TRUE;
	}

	/**
	 * Send email message.
	 *
	 * @param string $msgSubject
	 * @param string $msgBody
	 *
	 * @return mixed
	 */
	public function Send( $msgSubject, $msgBody )
	{
		if ( empty( $this->_mEol ) )
		{
			$this->SetDefaults();
		}

		if ( empty( $this->_mTo ) )
		{
			/**
			 * @var array
			 */
			$default_recipient = Core::Config()->Get( 'mail.recipient' );

			if ( TRUE !== $this->AddAddress( $default_recipient['address'], 'to', $default_recipient['name'] ) )
			{
				Core::Log()->Write( __( 'Mail Library: Error sending mail. You have to set at least one recipient.', 'RudWEb' ), 'error' );

				return FALSE;
			}
		}

		if ( empty( $this->_mFrom ) )
		{
			/**
			 * @var array
			 */
			$default_sender = Core::Config()->Get( 'mail.sender' );

			if ( TRUE !== $this->AddAddress( $default_sender['address'], 'from', $default_sender['name'] ) )
			{
				Core::Log()->Write( __( 'Mail Library: Error sending mail. You have to set the sender address.', 'RudWEb' ), 'error' );

				return FALSE;
			}
		}

		/**
		 * @var string
		 */
		$msg_pre = ( 'html' == $this->_mContentType ) ? '<html><body>' : NULL;

		/**
		 * @var string
		 */
		$msg_suf = ( 'html' == $this->_mContentType ) ? '</body></html>' : NULL;

		$this->AddHeader( 'MIME-Version', '1.0' );

		if ( !empty( $this->_mAttach ) )
		{
			/**
			 * @var string
			 */
			$attach_boundary = md5( date( 'r', time() ) );

			$this->AddHeader( 'Content-type', "multipart/mixed; boundary=\"{$hash}\"" );

			/**
			 * @var string
			 */
			$msg_body =	"{$this->_mEol}This is a multi-part message in MIME format.{$this->_mEol}" .
						"--{$attach_boundary}{$this->_mEol}" .
						"Content-type:text/{$this->_mContentType}; charset={$this->_mCharset}{$this->_mEol}" .
						"Content-Transfer-Encoding: {$this->_mEncoding}{$this->_mEol}{$this->_mEol}" .
						"{$msg_pre}{$msgBody}{$msg_suf}{$this->_mEol}{$this->_mEol}";

			foreach ( $this->_mAttach as $attach_data )
			{
				/**
				 * @var string
				 */
				$data = file_get_contents( $attach_data[0] );

				/**
				 * @var string
				 */
				$attach = chunk_split( base64_encode( $data ) );

				/**
				 * @var string
				 */
				$msg_body .=	"--{$attach_boundary}{$this->_mEol}" .
								"Content-Type: {$attach_data[1]}; name=\"{$attach_data[2]}\"{$this->_mEol}" .
								"Content-Transfer-Encoding: base64{$this->_mEol}" .
								"Content-Disposition: attachment; filename=\"{$attach_data[2]}\"{$this->_mEol}{$this->_mEol}" .
								"{$attach}{$this->_mEol}{$this->_mEol}";
			}

			/**
			 * @var string
			 */
			$msg_body .= "--{$attach_boundary}--";
		}
		else
		{
			$this->AddHeader( 'Content-type', "text/{$this->_mContentType}; charset={$this->_mCharset}" );

			/**
			 * @var string
			 */
			$msg_body = $msg_pre . $msgBody . $msg_suf;
		}

		/**
		 * @var string
		 */
		$msg_to = implode( ', ', $this->_mTo );

		$this->AddHeader( 'To', $msg_to );

		/**
		 * @var string
		 */
		$msg_from = $this->_mFrom;

		$this->AddHeader( 'From', $msg_from );

		/**
		 * @var string
		 */
		$msg_replyto = ( !empty( $this->_mReplyTo ) ) ? $this->_mReplyTo : $msg_from ;

		$this->AddHeader( 'Reply-To', $msg_replyto );

		/**
		 * @var string
		 */
		$msg_cc = implode( ', ', $this->_mCc );

		if ( !empty( $msg_cc ) )
		{
			$this->AddHeader( 'Cc', $msg_cc );
		}

		/**
		 * @var string
		 */
		$msg_bcc = implode( ', ', $this->_mBcc );

		if ( !empty( $msg_bcc ) )
		{
			$this->AddHeader( 'Bcc', $msg_cc );
		}

		$msg_env_from = ( FALSE !== $this->_mEnvFrom ) ? "-r {$msg_from}" : NULL;

		/**
		 * @var string
		 */
		$headers = $this->_GetHeaders();

		/**
		 * Set sender.
		 */
		ini_set( 'sendmail_from',$msg_from );

		echo '<pre>';
		var_dump( $headers );
		echo '</pre>';

		if ( mail( $msg_to, $msgSubject, $msg_body, $headers, $msg_env_from ) )
		{
			Core::Log()->Write( __( 'Mail Library: Message sent successfully.', 'RudWEb' ), 'info' );

			return TRUE;
		}
		else
		{
			Core::Log()->Write( __( 'Mail Library: Error sending message.', 'RudWEb' ), 'error' );

			return FALSE;
		}
	}

	/**
	 * Get headers data as string.
	 *
	 * @return string
	 */
	private function _GetHeaders()
	{
		/**
		 * @var array
		 */
		$headers = array();

		foreach ( $this->_mHeaders as $header_name => $header_value )
		{
			/**
			 * @var array
			 */
			$headers[] = "{$header_name}: {$header_value}";
		}

		return implode( $this->_mEol, $headers ) . $this->_mEol;
	}
}
?>