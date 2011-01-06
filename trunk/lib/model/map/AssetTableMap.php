<?php


/**
 * This class defines the structure of the 'asset' table.
 *
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Thu Jan  6 15:16:36 2011
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AssetTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AssetTableMap';

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
		$this->setName('asset');
		$this->setPhpName('Asset');
		$this->setClassname('Asset');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		$this->setPrimaryKeyMethodInfo('asset_id_seq');
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('UNIQID', 'Uniqid', 'VARCHAR', true, 50, null);
		$this->addForeignKey('BINDER_ID', 'BinderId', 'INTEGER', 'binder', 'ID', false, null, null);
		$this->addForeignKey('ARCHIVE_ID', 'ArchiveId', 'INTEGER', 'archive', 'ID', false, null, null);
		$this->addColumn('STATUS', 'Status', 'INTEGER', false, null, null);
		$this->addColumn('ASSET_TYPE', 'AssetType', 'INTEGER', false, null, null);
		$this->addColumn('NOTES', 'Notes', 'LONGVARCHAR', false, null, null);
		$this->addColumn('SOURCE_FILENAME', 'SourceFilename', 'VARCHAR', false, 255, null);
		$this->addColumn('SOURCE_FILE_DATETIME', 'SourceFileDatetime', 'TIMESTAMP', false, null, null);
		$this->addColumn('SOURCE_SIZE', 'SourceSize', 'BIGINT', false, null, null);
		$this->addColumn('SOURCE_LMD5SUM', 'SourceLmd5sum', 'VARCHAR', false, 34, null);
		$this->addColumn('HIGHQUALITY_MD5SUM', 'HighqualityMd5sum', 'VARCHAR', false, 32, null);
		$this->addColumn('HIGHQUALITY_SIZE', 'HighqualitySize', 'BIGINT', false, null, null);
		$this->addColumn('LOWQUALITY_MD5SUM', 'LowqualityMd5sum', 'VARCHAR', false, 32, null);
		$this->addColumn('LOWQUALITY_SIZE', 'LowqualitySize', 'BIGINT', false, null, null);
		$this->addColumn('HAS_THUMBNAIL', 'HasThumbnail', 'BOOLEAN', false, null, null);
		$this->addColumn('THUMBNAIL_WIDTH', 'ThumbnailWidth', 'INTEGER', false, null, null);
		$this->addColumn('THUMBNAIL_HEIGHT', 'ThumbnailHeight', 'INTEGER', false, null, null);
		$this->addColumn('THUMBNAIL_SIZE', 'ThumbnailSize', 'INTEGER', false, null, null);
		$this->addColumn('THUMBNAIL_POSITION', 'ThumbnailPosition', 'FLOAT', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Binder', 'Binder', RelationMap::MANY_TO_ONE, array('binder_id' => 'id', ), null, null);
    $this->addRelation('Archive', 'Archive', RelationMap::MANY_TO_ONE, array('archive_id' => 'id', ), null, null);
    $this->addRelation('VideoAsset', 'VideoAsset', RelationMap::ONE_TO_ONE, array('id' => 'asset_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('PictureAsset', 'PictureAsset', RelationMap::ONE_TO_ONE, array('id' => 'asset_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('PhotoalbumAsset', 'PhotoalbumAsset', RelationMap::ONE_TO_ONE, array('id' => 'asset_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('AudioAsset', 'AudioAsset', RelationMap::ONE_TO_ONE, array('id' => 'asset_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('AccessLogEvent', 'AccessLogEvent', RelationMap::ONE_TO_MANY, array('id' => 'asset_id', ), null, null);
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
			'symfony_timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // AssetTableMap
