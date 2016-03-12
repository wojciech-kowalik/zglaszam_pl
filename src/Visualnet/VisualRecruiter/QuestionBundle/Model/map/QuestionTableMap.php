<?php

namespace Visualnet\VisualRecruiter\QuestionBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'visual_question' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.QuestionBundle.Model.map
 */
class QuestionTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'src.Visualnet.VisualRecruiter.QuestionBundle.Model.map.QuestionTableMap';

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
		$this->setName('visual_question');
		$this->setPhpName('Question');
		$this->setClassname('Visualnet\\VisualRecruiter\\QuestionBundle\\Model\\Question');
		$this->setPackage('src.Visualnet.VisualRecruiter.QuestionBundle.Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'visual_user', 'ID', true, null, null);
		$this->addForeignKey('GROUP_ID', 'GroupId', 'INTEGER', 'visual_group', 'ID', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', false, 255, null);
		$this->addColumn('LABEL', 'Label', 'VARCHAR', false, 255, null);
		$this->addColumn('TYPE', 'Type', 'ENUM', false, null, null);
		$this->getColumn('TYPE', false)->setValueSet(array (
  0 => 'text',
  1 => 'textarea',
  2 => 'checkbox',
  3 => 'radio',
  4 => 'header',
  5 => 'dropdown',
));
		$this->addColumn('ANSWERS', 'Answers', 'LONGVARCHAR', false, null, null);
		$this->addColumn('LIMIT', 'Limit', 'INTEGER', false, 4, null);
		$this->addColumn('VALIDATION_RULE_PREDEFINED', 'ValidationRulePredefined', 'VARCHAR', false, 80, null);
		$this->addColumn('VALIDATION_RULE_OPTIONAL', 'ValidationRuleOptional', 'VARCHAR', false, 255, null);
		$this->addColumn('IS_PREDEFINED', 'IsPredefined', 'BOOLEAN', false, 1, false);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('SORTABLE_RANK', 'SortableRank', 'INTEGER', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('User', 'Visualnet\\UserBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
		$this->addRelation('Group', 'Visualnet\\UserBundle\\Model\\Group', RelationMap::MANY_TO_ONE, array('group_id' => 'id', ), null, null);
		$this->addRelation('FormQuestion', 'Visualnet\\VisualRecruiter\\FormBundle\\Model\\FormQuestion', RelationMap::ONE_TO_MANY, array('id' => 'question_id', ), 'CASCADE', 'CASCADE', 'FormQuestions');
		$this->addRelation('RecruitmentUserData', 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\RecruitmentUserData', RelationMap::ONE_TO_MANY, array('id' => 'question_id', ), 'CASCADE', 'CASCADE', 'RecruitmentUserDatas');
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
			'sortable' => array('rank_column' => 'sortable_rank', 'use_scope' => 'false', 'scope_column' => 'sortable_scope', ),
		);
	} // getBehaviors()

} // QuestionTableMap
