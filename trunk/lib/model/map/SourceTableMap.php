<?php


/**
 * This class defines the structure of the 'source' table.
 *
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Tue May 25 18:32:42 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class SourceTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.SourceTableMap';

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
		$this->setName('source');
		$this->setPhpName('Source');
		$this->setClassname('Source');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		$this->setPrimaryKeyMethodInfo('source_id_seq');
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'sf_guard_user_profile', 'USER_ID', true, null, null);
		$this->addColumn('RELATIVE_PATH', 'RelativePath', 'VARCHAR', true, 255, null);
		$this->addColumn('BASENAME', 'Basename', 'VARCHAR', true, 255, null);
		$this->addColumn('STATUS', 'Status', 'INTEGER', false, null, null);
		$this->addColumn('INODE', 'Inode', 'BIGINT', false, null, null);
		$this->addForeignKey('TASK_LOG_EVENT_ID', 'TaskLogEventId', 'INTEGER', 'task_log_event', 'ID', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('sfGuardUserProfile', 'sfGuardUserProfile', RelationMap::MANY_TO_ONE, array('user_id' => 'user_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('TaskLogEvent', 'TaskLogEvent', RelationMap::MANY_TO_ONE, array('task_log_event_id' => 'id', ), null, null);
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
			'symfony_timestampable' => array('create_column' => 'created_at', ),
		);
	} // getBehaviors()

} // SourceTableMap
