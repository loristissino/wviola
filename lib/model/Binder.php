<?php

require 'lib/model/om/BaseBinder.php';


/**
 * Skeleton subclass for representing a row from the 'binder' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Fri Mar 12 22:47:42 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Binder extends BaseBinder {

  public function __toString()
  {
    return $this->getEventDate() . ' ' . $this->getNotes();
  }
  
  public function setFromForm($user_id, $values)
  {
    $this
    ->setUserId($user_id)
    ->setCategoryId($values['category_id'])
    ->setNotes($values['notes'])
    ->setEventDate($values['event_date'])
    ;
    
    return $this;
  }
  
  public function getAssetsCriteria()
  {
    $c = new Criteria();
    $c->add(AssetPeer::BINDER_ID, $this->getId());
    return $c;
  }
  
  public function save(PropelPDO $con = null)
  {
    if (is_null($con))
    {
    $con = Propel::getConnection(BinderPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
    }
    
    $con->beginTransaction();
    try
    {
      $ret = parent::save($con);
      $this->updateLuceneIndex();
      $con->commit();
      return $ret;
    }
    catch (Exception $e)
    {
      $con->rollBack();
      throw $e;
    }
  }
  
  public function updateLuceneIndex()
  {
    foreach ($this->getAssets() as $Asset)
    {
      $Asset->updateLuceneIndex();
    }
  }
  
  public function closeIfAgedOut($max_age)
  {
    $age = time() - $this->getCreatedAt('U');
    if ($age > $max_age*86400)
    {
      $this
      ->setIsOpen(false)
      ->save();
      return true;
    }
    return false;
  }
  
  
  public function getArchivableAssets($criteria = null, PropelPDO $con = null)
  {
    if ($criteria === null)
    {
			$criteria = new Criteria(BinderPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}
    $c = new Criteria();
    $c->add(AssetPeer::BINDER_ID, $this->getId());
    $c->add(AssetPeer::STATUS, Asset::CACHED);
    return AssetPeer::doSelect($c, $con);
  }
  
  public function getTotalSize()
  {
    // FIXME This should be done with one raw query...
    $s=0;
    foreach($this->getArchivableAssets() as $Asset)
    {
      $s+=$Asset->getHighQualitySize();
    }
    return $s;
  }
  

} // Binder
