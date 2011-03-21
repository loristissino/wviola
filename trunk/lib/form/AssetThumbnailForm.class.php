<?php

/**
 * Asset form.
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AssetThumbnailForm extends BaseAssetForm
{
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
      $this['highquality_md5sum'],
      $this['has_thumbnail'],
      $this['user_id'],
      $this['created_at'],
      $this['updated_at'],
      $this['notes'],
      $this['source_file_datetime'],
      $this['source_size'],
      $this['source_lmd5sum'],
      $this['highquality_size'],
      $this['lowquality_size'],
      $this['thumbnail_width'],
      $this['thumbnail_height'],
      $this['thumbnail_size']
      );
      
      $this->widgetSchema['thumbnail'] = new sfWidgetFormInputFile();
      $this->validatorSchema['thumbnail'] = new sfValidatorFile(array('required'=>true));
      
  }
  
  
}

