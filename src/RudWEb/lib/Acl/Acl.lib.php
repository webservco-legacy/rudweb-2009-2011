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

	public function Check( $aclRequest, $aclResource, $aclType = 'user', $aclAsset = NULL )
	{
		$options['conditions'][] = array ( 'rule_type', $aclType );

		$options['conditions'][] = array ( 'bin.rule_value', $aclRequest );

		$options['conditions'][] = array ( 'rule_resource', $aclResource );

		if ( !empty( $aclAsset ) )
		{
			$options['conditions'][] = array ( 'bin.rule_asset', $aclAsset );
		}

		/**
		 * @var array
		 */
		$options['limit'] = 1;

		$data = Core::Database()->RetrieveOne( 'rule_action', $this->_mTable['rules'], $options );

		//$action = $data['rule_action'];

		var_dump( $data );

		//XXX

	}
}
?>