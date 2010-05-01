<?php


/**
 * This class defines the structure of the 'video_asset' table.
 *
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Sat May  1 19:24:03 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class VideoAssetTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.VideoAssetTableMap';

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
		$this->setName('video_asset');
		$this->setPhpName('VideoAsset');
		$this->setClassname('VideoAsset');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('ASSET_ID', 'AssetId', 'INTEGER' , 'asset', 'ID', true, null, null);
		$this->addColumn('DURATION', 'Duration', 'FLOAT', false, null, null);
		$this->addColumn('HIGHQUALITY_WIDTH', 'HighqualityWidth', 'INTEGER', false, null, null);
		$this->addColumn('HIGHQUALITY_HEIGHT', 'HighqualityHeight', 'INTEGER', false, null, null);
		$this->addColumn('HIGHQUALITY_VIDEO_CODEC', 'HighqualityVideoCodec', 'VARCHAR', false, 20, null);
		$this->addColumn('HIGHQUALITY_AUDIO_CODEC', 'HighqualityAudioCodec', 'VARCHAR', false, 20, null);
		$this->addColumn('HIGHQUALITY_FRAME_RATE', 'HighqualityFrameRate', 'INTEGER', false, null, null);
		$this->addColumn('HIGHQUALITY_ASPECT_RATIO', 'HighqualityAspectRatio', 'FLOAT', false, null, null);
		$this->addColumn('LOWQUALITY_WIDTH', 'LowqualityWidth', 'INTEGER', false, null, null);
		$this->addColumn('LOWQUALITY_HEIGHT', 'LowqualityHeight', 'INTEGER', false, null, null);
		$this->addColumn('LOWQUALITY_VIDEO_CODEC', 'LowqualityVideoCodec', 'VARCHAR', false, 20, null);
		$this->addColumn('LOWQUALITY_AUDIO_CODEC', 'LowqualityAudioCodec', 'VARCHAR', false, 20, null);
		$this->addColumn('LOWQUALITY_FRAME_RATE', 'LowqualityFrameRate', 'INTEGER', false, null, null);
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

} // VideoAssetTableMap
