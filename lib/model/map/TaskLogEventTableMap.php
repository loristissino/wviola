<?php


/**
 * This class defines the structure of the 'task_log_event' table.
 *
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Sat May  1 19:24:06 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class TaskLogEventTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.TaskLogEventTableMap';

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
		$this->setName('task_log_event');
		$this->setPhpName('TaskLogEvent');
		$this->setClassname('TaskLogEvent');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		$this->setPrimaryKeyMethodInfo('task_log_event_id_seq');
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('TASK_NAME', 'TaskName', 'VARCHAR', false, 50, null);
		$this->addColumn('OPTIONS', 'Options', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ARGUMENTS', 'Arguments', 'LONGVARCHAR', false, null, null);
		$this->addColumn('STARTED_AT', 'StartedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('FINISHED_AT', 'FinishedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('TASK_EXCEPTION', 'TaskException', 'LONGVARCHAR', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Source', 'Source', RelationMap::ONE_TO_MANY, array('id' => 'task_log_event_id', ), null, null);
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

} // TaskLogEventTableMap
