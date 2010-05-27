<?php

/**
 * Asset form.
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AssetForm extends BaseAssetForm
{
  private $_userId;
  
  public function __construct($user_id)
  {
    $this->_userId = $user_id;
    parent::__construct();
  }
  
  public function configure()
  {
    unset(
      $this['uniqid'],
      $this['binder_id'],
      $this['status'],
      $this['archive_id'],
      $this['asset_type'],
      $this['source_filename'],
      $this['source_file_date'],
      $this['source_md5sum'],
      $this['lowquality_md5sum'],
      $this['has_thumbnail'],
      $this['thumbnail_width'],
      $this['thumbnail_height'],
      $this['thumbnail_size'],
      $this['user_id'],
      $this['created_at'],
      $this['updated_at']
      );
      
      unset(
        $this->validatorSchema['assigned_title'],
        $this->validatorSchema['notes']
      );
            
      $c = new Criteria();
      $c->add(BinderPeer::USER_ID, $this->_userId);
      $c->add(BinderPeer::IS_OPEN, true);
      
      $this->widgetSchema['binder_id'] = new sfWidgetFormPropelChoice(array('model' => 'Binder', 'add_empty' => true, 'criteria' => $c));
      
      $this->validatorSchema['binder_id'] = new sfValidatorPropelChoice(array('model' => 'Binder', 'column' => 'id', 'required' => true, 'criteria'=>$c));
      
      $this->validatorSchema['assigned_title'] = new sfValidatorString(array(
        'required' => true,
      ));
      
      $this->validatorSchema['notes'] = new sfValidatorString(array(
        'required' => true,
      ));
            
//    $this->setDefault('notes', 'your notes here');
    
  }
  
  public function addThumbnailWidget(SourceFile $sourceFile, sfContext $sfContext=null)
  {

    for($i=0; $i < $sourceFile->getThumbnailNb(); $i++)
    {
      $thumbnails[]=sprintf(
        '<img src="%s" alt="%s" />',
        $sfContext->getRouting()->generate(
          'sourcethumbnail',
          array(
            'path'=>Generic::b64_serialize($sourceFile->getRelativePath()),
            'basename'=>Generic::b64_serialize($sourceFile->getBasename()),
            'number'=>$i, 
            'sf_format'=>'jpeg')
          ),
        $sfContext->getI18N()->__('Thumbnail %number%', array('%number%'=>$i))
      );
    }
    
    $this->widgetSchema['thumbnail'] = new sfWidgetFormSelectRadio(
      array(
        'choices'=>$thumbnails,
        'label_separator'=>'&nbsp;' . 'CIAO'. $sourceFile->getThumbnailNb(). 'INODE'.$sourceFile->getStat('ino'),
        'separator'=>'',
        )
    );
    $this->validatorSchema['thumbnail'] = new sfValidatorInteger(array(
      'min'=>0,
      'max'=>$sourceFile->getThumbnailNb()-1,
      ));
  }
  
  
}

