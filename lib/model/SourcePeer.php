<?php

require 'lib/model/om/BaseSourcePeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'source' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Sat May  1 15:17:57 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class SourcePeer extends BaseSourcePeer {

  const
    STATUS_READY = 1,
    STATUS_EMAILSENT = 2,
    STATUS_SCHEDULED = 3,
    STATUS_DONE = 4
    ;
    
  public static function getStatusDescription($status)
  {
    $statuses=array(
      self::STATUS_READY => 'Ready',
      self::STATUS_EMAILSENT => 'Email sent',
      self::STATUS_SCHEDULED => 'Scheduled',
      );
    return $statuses[$status];
    
  }
  
  public static function retrieveByTasklogEvent($id)
  {
    $c = new Criteria();
    $c->add(SourcePeer::TASK_LOG_EVENT_ID, $id);
    $c->clearSelectColumns();
    $c->addGroupByColumn(SourcePeer::USER_ID);
    $c->addAsColumn('USER_ID', 'MIN(' . SourcePeer::USER_ID . ')');
    return SourcePeer::doSelect($c);
  }
  
  public static function retrieveByPathAndBasename($path, $basename)
  {
    $c = new Criteria();
    $c->add(SourcePeer::RELATIVE_PATH, $path);
    $c->add(SourcePeer::BASENAME, $basename);
    return SourcePeer::doSelectOne($c);
  }
  
  public static function markAsPublished($inode, PropelPDO $con=null)
  {
    
    if(!$con)
    {
      $con=Propel::getConnection(SourcePeer::DATABASE_NAME);
    }
    
    $sc = new Criteria();
    $sc->add(SourcePeer::INODE, $inode);

    $uc = new Criteria();
    $uc->add(SourcePeer::STATUS, self::STATUS_SCHEDULED);
    
    BasePeer::doUpdate($sc, $uc, $con);
  }

  private static function _retrieveUsersWithAssets($status, PropelPDO $con = null)
  {
    $c = new Criteria();
    $c->add(SourcePeer::STATUS, $status);
    $c->setDistinct();
    $c->clearSelectColumns();
    $c->addAsColumn('user_id', SourcePeer::USER_ID);
    $c->addAsColumn('assets', 'count('. SourcePeer::ID . ')');
    $c->addGroupByColumn(SourcePeer::USER_ID);
    $stmt=SourcePeer::doSelectStmt($c, $con);
    
    $users=array();

    while($row = $stmt->fetch(PDO::FETCH_OBJ))
    {
      $users[]=array(
        'profile'=> sfGuardUserProfilePeer::retrieveByPK($row->user_id),
        'number'=>   $row->assets
        );
    };
    return $users;
  }

  
  public static function retrieveUsersWithAssetsReadyForArchiviation(PropelPDO $con = null)
  {
    return self::_retrieveUsersWithAssets(SourcePeer::STATUS_READY);
  }
  
  public static function retrieveUsersWithAssetsWaitingForArchiviation(PropelPDO $con = null)
  {
    return self::_retrieveUsersWithAssets(SourcePeer::STATUS_EMAILSENT);
  }
  
  
  public static function retrieveByStatus($status, $comparison=Criteria::EQUAL)
  {
    $c=new Criteria();
    $c->add(self::STATUS, $status, $comparison);
    return self::doSelect($c);
  }

} // SourcePeer
