<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'visual_recruitment_date' table.
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
class RecruitmentDateTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'src.Visualnet.VisualRecruiter.RecruitmentBundle.Model.map.RecruitmentDateTableMap';

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
		$this->setName('visual_recruitment_date');
		$this->setPhpName('RecruitmentDate');
		$this->setClassname('Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\RecruitmentDate');
		$this->setPackage('src.Visualnet.VisualRecruiter.RecruitmentBundle.Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('RECRUITMENT_ID', 'RecruitmentId', 'INTEGER', 'visual_recruitment', 'ID', true, null, null);
		$this->addColumn('EVENT_DATE_FROM', 'EventDateFrom', 'TIMESTAMP', true, null, null);
		$this->addColumn('EVENT_DATE_TO', 'EventDateTo', 'TIMESTAMP', true, null, null);
		$this->addColumn('NO_ACTIVE_TEXT', 'NoActiveText', 'VARCHAR', false, 255, null);
		$this->addColumn('USED_LIMIT', 'UsedLimit', 'SMALLINT', false, null, 0);
		$this->addColumn('SET_LIMIT', 'SetLimit', 'SMALLINT', false, null, 0);
		$this->addColumn('IS_VISIBLE_LIMIT', 'IsVisibleLimit', 'BOOLEAN', false, 1, false);
		$this->addColumn('IS_NOT_SET_EVENT_DATE', 'IsNotSetEventDate', 'BOOLEAN', false, 1, false);
		$this->addColumn('IS_ACTIVE', 'IsActive', 'BOOLEAN', false, 1, false);
		$this->addColumn('IS_AUTOMATIC_QUALIFY', 'IsAutomaticQualify', 'BOOLEAN', false, 1, false);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('Recruitment', 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\Recruitment', RelationMap::MANY_TO_ONE, array('recruitment_id' => 'id', ), 'CASCADE', 'CASCADE');
		$this->addRelation('RecruitmentUser', 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\RecruitmentUser', RelationMap::ONE_TO_MANY, array('id' => 'recruitment_date_id', ), 'CASCADE', 'CASCADE', 'RecruitmentUsers');
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

} // RecruitmentDateTableMap
