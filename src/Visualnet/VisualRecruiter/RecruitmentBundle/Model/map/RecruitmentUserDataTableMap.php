<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'visual_recruitment_user_data' table.
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
class RecruitmentUserDataTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'src.Visualnet.VisualRecruiter.RecruitmentBundle.Model.map.RecruitmentUserDataTableMap';

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
		$this->setName('visual_recruitment_user_data');
		$this->setPhpName('RecruitmentUserData');
		$this->setClassname('Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\RecruitmentUserData');
		$this->setPackage('src.Visualnet.VisualRecruiter.RecruitmentBundle.Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_RECRUITMENT_ID', 'UserRecruitmentId', 'INTEGER', 'visual_recruitment_user', 'ID', true, null, null);
		$this->addForeignKey('QUESTION_ID', 'QuestionId', 'INTEGER', 'visual_question', 'ID', true, null, null);
		$this->addColumn('VALUE', 'Value', 'LONGVARCHAR', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('RecruitmentUser', 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\RecruitmentUser', RelationMap::MANY_TO_ONE, array('user_recruitment_id' => 'id', ), 'CASCADE', 'CASCADE');
		$this->addRelation('Question', 'Visualnet\\VisualRecruiter\\QuestionBundle\\Model\\Question', RelationMap::MANY_TO_ONE, array('question_id' => 'id', ), 'CASCADE', 'CASCADE');
	} // buildRelations()

} // RecruitmentUserDataTableMap
