<?php

namespace Visualnet\MenuBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'visual_menu_i18n' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Visualnet.MenuBundle.Model.map
 */
class MenuI18nTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'src.Visualnet.MenuBundle.Model.map.MenuI18nTableMap';

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
		$this->setName('visual_menu_i18n');
		$this->setPhpName('MenuI18n');
		$this->setClassname('Visualnet\\MenuBundle\\Model\\MenuI18n');
		$this->setPackage('src.Visualnet.MenuBundle.Model');
		$this->setUseIdGenerator(false);
		$this->setIsCrossRef(true);
		// columns
		$this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'visual_menu', 'ID', true, null, null);
		$this->addPrimaryKey('LOCALE', 'Locale', 'VARCHAR', true, 5, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', false, 45, null);
		$this->addColumn('SLUG', 'Slug', 'VARCHAR', false, 45, null);
		$this->addColumn('CONTENT', 'Content', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('Menu', 'Visualnet\\MenuBundle\\Model\\Menu', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
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

} // MenuI18nTableMap
