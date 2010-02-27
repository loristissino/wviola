<?php


/**
 * This class defines the structure of the 'asset' table.
 *
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Sat Feb 27 09:27:30 2010
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
		$this->addColumn('SLUG', 'Slug', 'VARCHAR', true, 50, null);
		$this->addColumn('STATUS', 'Status', 'INTEGER', false, null, null);
		$this->addForeignKey('ARCHIVE_ID', 'ArchiveId', 'INTEGER', 'archive', 'ID', false, null, null);
		$this->addColumn('ASSET_TYPE', 'AssetType', 'INTEGER', false, null, null);
		$this->addColumn('ASSIGNED_TITLE', 'AssignedTitle', 'VARCHAR', false, 255, null);
		$this->addForeignKey('CATEGORY_ID', 'CategoryId', 'INTEGER', 'category', 'ID', false, null, null);
		$this->addColumn('NOTES', 'Notes', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EVENT_DATE', 'EventDate', 'DATE', false, null, null);
		$this->addColumn('SOURCE_FILENAME', 'SourceFilename', 'VARCHAR', false, 255, null);
		$this->addColumn('SOURCE_FILE_DATE', 'SourceFileDate', 'DATE', false, null, null);
		$this->addColumn('HIGHQUALITY_MD5SUM', 'HighqualityMd5sum', 'VARCHAR', false, 32, null);
		$this->addColumn('LOWQUALITY_MD5SUM', 'LowqualityMd5sum', 'VARCHAR', false, 32, null);
		$this->addColumn('HAS_THUMBNAIL', 'HasThumbnail', 'BOOLEAN', false, null, null);
		$this->addColumn('THUMBNAIL_WIDTH', 'ThumbnailWidth', 'INTEGER', false, null, null);
		$this->addColumn('THUMBNAIL_HEIGHT', 'ThumbnailHeight', 'INTEGER', false, null, null);
		$this->addColumn('THUMBNAIL_SIZE', 'ThumbnailSize', 'INTEGER', false, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'sf_guard_user_profile', 'USER_ID', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Archive', 'Archive', RelationMap::MANY_TO_ONE, array('archive_id' => 'id', ), null, null);
    $this->addRelation('Category', 'Category', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), null, null);
    $this->addRelation('sfGuardUserProfile', 'sfGuardUserProfile', RelationMap::MANY_TO_ONE, array('user_id' => 'user_id', ), 'CASCADE', 'CASCADE');
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
