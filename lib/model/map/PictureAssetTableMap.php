<?php


/**
 * This class defines the structure of the 'picture_asset' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Sat Aug 18 09:27:46 2012
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PictureAssetTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PictureAssetTableMap';

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
		$this->setName('picture_asset');
		$this->setPhpName('PictureAsset');
		$this->setClassname('PictureAsset');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('ASSET_ID', 'AssetId', 'INTEGER' , 'asset', 'ID', true, null, null);
		$this->addColumn('HIGHQUALITY_WIDTH', 'HighqualityWidth', 'INTEGER', false, null, null);
		$this->addColumn('HIGHQUALITY_HEIGHT', 'HighqualityHeight', 'INTEGER', false, null, null);
		$this->addColumn('HIGHQUALITY_PICTURE_FORMAT', 'HighqualityPictureFormat', 'VARCHAR', false, 10, null);
		$this->addColumn('LOWQUALITY_WIDTH', 'LowqualityWidth', 'INTEGER', false, null, null);
		$this->addColumn('LOWQUALITY_HEIGHT', 'LowqualityHeight', 'INTEGER', false, null, null);
		$this->addColumn('LOWQUALITY_PICTURE_FORMAT', 'LowqualityPictureFormat', 'VARCHAR', false, 10, null);
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

} // PictureAssetTableMap
