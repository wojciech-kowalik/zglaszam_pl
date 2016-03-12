<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'visual_recruitment' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.RecruitmentBundle.Model.map
 */
class RecruitmentTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'src.Visualnet.VisualRecruiter.RecruitmentBundle.Model.map.RecruitmentTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
		// attributes
		$this->setName('visual_recruitment');
		$this->setPhpName('Recruitment');
		$this->setClassname('Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\Recruitment');
		$this->setPackage('src.Visualnet.VisualRecruiter.RecruitmentBundle.Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('FORM_ID', 'FormId', 'INTEGER', 'visual_form', 'ID', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'visual_user', 'ID', true, null, null);
		$this->addForeignKey('GROUP_ID', 'GroupId', 'INTEGER', 'visual_group', 'ID', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 100, null);
		$this->addColumn('ALIAS_NAME', 'AliasName', 'VARCHAR', true, 30, null);
		$this->addColumn('PLACE', 'Place', 'VARCHAR', false, 255, null);
		$this->addColumn('IS_ACTIVE', 'IsActive', 'BOOLEAN', false, 1, false);
		$this->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('Form', 'Visualnet\\VisualRecruiter\\FormBundle\\Model\\Form', RelationMap::MANY_TO_ONE, array('form_id' => 'id', ), null, null);
		$this->addRelation('User', 'Visualnet\\UserBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
		$this->addRelation('Group', 'Visualnet\\UserBundle\\Model\\Group', RelationMap::MANY_TO_ONE, array('group_id' => 'id', ), null, null);
		$this->addRelation('RecruitmentDate', 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\RecruitmentDate', RelationMap::ONE_TO_MANY, array('id' => 'recruitment_id', ), 'CASCADE', 'CASCADE', 'RecruitmentDates');
		$this->addRelation('RecruitmentUser', 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\RecruitmentUser', RelationMap::ONE_TO_MANY, array('id' => 'recruitment_id', ), 'CASCADE', 'CASCADE', 'RecruitmentUsers');
	} // buildRelations()

	/**
	 *
	 * Gets the list of behaviors registered for this table
	 *
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // RecruitmentTableMap
