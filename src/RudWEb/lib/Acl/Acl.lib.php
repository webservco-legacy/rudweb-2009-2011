<?php
/**
 * $Id$
 *
 * ACL library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudWEb
 * @subpackage RudAcl
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
	exit;
}

/**
 * ACL library.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @package    RudWEb
 * @subpackage RudAcl
 *
 */
class Acl extends Library
{
	/**
	 * ACL tables.
	 *
	 * @var array
	 */
	protected $_mTable = array(
		'rules' => 'acl_rules',
		'groups' => 'acl_groups',
		'users' => 'acl_users',
		'relations' => 'acl_relations',
		'relations_list' => 'acl_object_relation',
	);

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

	public function GetUserGroups( $userId )
	{
		/**
		 * @var array
		 */
		$values = array( 'bin.group_id', 'group_name' , 'group_level' );

		/**
		 * @var array
		 */
		$options['conditions'][] = array ( 'bin.user_id', $userId );

		/**
		 * @var mixed
		 */
		$data = Core::Database()->Retrieve( $values, $this->_mTable['relations_list'], $options );

		return $data;

		//XXX

	}

	public function Check( $aclRequest, $aclResource, $aclType = 'user', $aclAsset = NULL )
	{
		/**
		 * @var array
		 */
		$options['conditions'][] = array ( 'rule_type', $aclType );

		/**
		 * @var array
		 */
		$options['conditions'][] = array ( 'bin.rule_value', $aclRequest );

		/**
		 * @var array
		 */
		$options['conditions'][] = array ( 'rule_resource', $aclResource );

		if ( !empty( $aclAsset ) )
		{
			/**
			 * @var array
			 */
			$options['conditions'][] = array ( 'bin.rule_asset', $aclAsset );
		}

		/**
		 * @var array
		 */
		$options['limit'] = 1;

		/**
		 * @var mixed
		 */
		$data = Core::Database()->RetrieveOne( 'rule_action', $this->_mTable['rules'], $options );

		if ( !empty( $data ) )
		{
			return $data['rule_action'];
		}

		return FALSE;

		//XXX
	}

	public function GetResourceOwner( $aclResource, $aclAsset )
	{
		/**
		 * @var array
		 */
		$asset = explode( '/', $aclResource );

		/**
		 * @var array
		 */
		$asset = array_diff( $asset, array( '' ) );

		/**
		 * @var string
		 */
		$table = $asset[0];

		/**
		 * @var string
		 */
		$primary_key = Core::Database()->GetPrimaryKey( $table );

		if ( 1 == Core::Config()->Get( 'db.binkey' ) )
		{
			/**
			 * @var string
			 */
			$primary_key = 'bin.' . $primary_key;
		}

		/**
		 * @var array
		 */
		$options['conditions'][] = array ( $primary_key, $aclAsset );

		/**
		 * @var array
		 */
		$options['limit'] = 1;


		$data = Core::Database()->RetrieveOne( 'bin.owner_id', $table, $options );

		return $data['bin.owner_id'];

		//XXX
	}
}
?>