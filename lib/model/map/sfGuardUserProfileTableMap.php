<?php


/**
 * This class defines the structure of the 'sf_guard_user_profile' table.
 *
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Thu Mar 11 14:48:54 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class sfGuardUserProfileTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.sfGuardUserProfileTableMap';

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
		$this->setName('sf_guard_user_profile');
		$this->setPhpName('sfGuardUserProfile');
		$this->setClassname('sfGuardUserProfile');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'sf_guard_user', 'ID', true, null, null);
		$this->addColumn('FIRST_NAME', 'FirstName', 'VARCHAR', false, 50, null);
		$this->addColumn('LAST_NAME', 'LastName', 'VARCHAR', false, 50, null);
		$this->addColumn('IMPORTED_AT', 'ImportedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('sfGuardUser', 'sfGuardUser', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Asset', 'Asset', RelationMap::ONE_TO_MANY, array('user_id' => 'user_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Archive', 'Archive', RelationMap::ONE_TO_MANY, array('user_id' => 'user_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('AccessLogEvent', 'AccessLogEvent', RelationMap::ONE_TO_MANY, array('user_id' => 'user_id', ), 'RESTRICT', 'CASCADE');
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
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // sfGuardUserProfileTableMap
