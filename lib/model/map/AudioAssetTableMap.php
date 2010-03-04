<?php


/**
 * This class defines the structure of the 'audio_asset' table.
 *
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Thu Mar  4 16:44:50 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AudioAssetTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AudioAssetTableMap';

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
		$this->setName('audio_asset');
		$this->setPhpName('AudioAsset');
		$this->setClassname('AudioAsset');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('ASSET_ID', 'AssetId', 'INTEGER' , 'asset', 'ID', true, null, null);
		$this->addColumn('DURATION', 'Duration', 'FLOAT', false, null, null);
		$this->addColumn('HIGHQUALITY_AUDIO_CODEC', 'HighqualityAudioCodec', 'VARCHAR', false, 10, null);
		$this->addColumn('LOWQUALITY_AUDIO_CODEC', 'LowqualityAudioCodec', 'VARCHAR', false, 10, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Asset', 'Asset', RelationMap::MANY_TO_ONE, array('asset_id' => 'id', ), 'CASCADE', 'CASCADE');
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

} // AudioAssetTableMap
