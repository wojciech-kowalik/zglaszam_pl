<?php

namespace Visualnet\VisualRecruiter\FormBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'visual_form' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.FormBundle.Model.map
 */
class FormTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'src.Visualnet.VisualRecruiter.FormBundle.Model.map.FormTableMap';

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
		$this->setName('visual_form');
		$this->setPhpName('Form');
		$this->setClassname('Visualnet\\VisualRecruiter\\FormBundle\\Model\\Form');
		$this->setPackage('src.Visualnet.VisualRecruiter.FormBundle.Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'visual_user', 'ID', true, null, null);
		$this->addForeignPrimaryKey('GROUP_ID', 'GroupId', 'INTEGER' , 'visual_group', 'ID', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', false, 255, null);
		$this->addColumn('IS_ACTIVE', 'IsActive', 'BOOLEAN', false, 1, false);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('User', 'Visualnet\\UserBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
		$this->addRelation('Group', 'Visualnet\\UserBundle\\Model\\Group', RelationMap::MANY_TO_ONE, array('group_id' => 'id', ), null, null);
		$this->addRelation('FormQuestion', 'Visualnet\\VisualRecruiter\\FormBundle\\Model\\FormQuestion', RelationMap::ONE_TO_MANY, array('id' => 'form_id', ), 'CASCADE', 'CASCADE', 'FormQuestions');
		$this->addRelation('Recruitment', 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\Recruitment', RelationMap::ONE_TO_MANY, array('id' => 'form_id', ), null, null, 'Recruitments');
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

} // FormTableMap
