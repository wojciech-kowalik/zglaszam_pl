<?php

namespace Visualnet\VisualRecruiter\FormBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'visual_form_question' table.
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
class FormQuestionTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'src.Visualnet.VisualRecruiter.FormBundle.Model.map.FormQuestionTableMap';

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
		$this->setName('visual_form_question');
		$this->setPhpName('FormQuestion');
		$this->setClassname('Visualnet\\VisualRecruiter\\FormBundle\\Model\\FormQuestion');
		$this->setPackage('src.Visualnet.VisualRecruiter.FormBundle.Model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('FORM_ID', 'FormId', 'INTEGER' , 'visual_form', 'ID', true, null, null);
		$this->addForeignPrimaryKey('QUESTION_ID', 'QuestionId', 'INTEGER' , 'visual_question', 'ID', true, null, null);
		$this->addColumn('EXPORT_NAME', 'ExportName', 'VARCHAR', false, 128, null);
		$this->addColumn('LABEL', 'Label', 'VARCHAR', false, 255, null);
		$this->addColumn('IS_REQUIRED', 'IsRequired', 'BOOLEAN', false, 1, false);
		$this->addColumn('IS_EXPORT', 'IsExport', 'BOOLEAN', false, 1, false);
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
		$this->addRelation('Form', 'Visualnet\\VisualRecruiter\\FormBundle\\Model\\Form', RelationMap::MANY_TO_ONE, array('form_id' => 'id', ), 'CASCADE', 'CASCADE');
		$this->addRelation('Question', 'Visualnet\\VisualRecruiter\\QuestionBundle\\Model\\Question', RelationMap::MANY_TO_ONE, array('question_id' => 'id', ), 'CASCADE', 'CASCADE');
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
			'sortable' => array('rank_column' => 'sortable_rank', 'use_scope' => 'true', 'scope_column' => 'form_id', ),
		);
	} // getBehaviors()

} // FormQuestionTableMap
