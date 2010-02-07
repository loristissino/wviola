<?php

/**
 * Asset form base class.
 *
 * @method Asset getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAssetForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'slug'                       => new sfWidgetFormInputText(),
      'asset_type_id'              => new sfWidgetFormPropelChoice(array('model' => 'AssetType', 'add_empty' => true)),
      'assigned_title'             => new sfWidgetFormInputText(),
      'category_id'                => new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => true)),
      'notes'                      => new sfWidgetFormTextarea(),
      'duration'                   => new sfWidgetFormInputText(),
      'source_filename'            => new sfWidgetFormInputText(),
      'source_file_date'           => new sfWidgetFormDate(),
      'highquality_width'          => new sfWidgetFormInputText(),
      'highquality_height'         => new sfWidgetFormInputText(),
      'highquality_video_codec'    => new sfWidgetFormInputText(),
      'highquality_audio_codec'    => new sfWidgetFormInputText(),
      'highquality_picture_format' => new sfWidgetFormInputText(),
      'highquality_frame_rate'     => new sfWidgetFormInputText(),
      'highquality_aspect_ratio'   => new sfWidgetFormInputText(),
      'highquality_md5sum'         => new sfWidgetFormInputText(),
      'archive_id'                 => new sfWidgetFormPropelChoice(array('model' => 'Archive', 'add_empty' => true)),
      'lowquality_width'           => new sfWidgetFormInputText(),
      'lowquality_height'          => new sfWidgetFormInputText(),
      'lowquality_video_codec'     => new sfWidgetFormInputText(),
      'lowquality_audio_codec'     => new sfWidgetFormInputText(),
      'lowquality_picture_format'  => new sfWidgetFormInputText(),
      'lowquality_frame_rate'      => new sfWidgetFormInputText(),
      'lowquality_md5sum'          => new sfWidgetFormInputText(),
      'thumbnail'                  => new sfWidgetFormInputText(),
      'thumbnail_width'            => new sfWidgetFormInputText(),
      'thumbnail_height'           => new sfWidgetFormInputText(),
      'thumbnail_size'             => new sfWidgetFormInputText(),
      'user_id'                    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => false)),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorPropelChoice(array('model' => 'Asset', 'column' => 'id', 'required' => false)),
      'slug'                       => new sfValidatorString(array('max_length' => 50)),
      'asset_type_id'              => new sfValidatorPropelChoice(array('model' => 'AssetType', 'column' => 'id', 'required' => false)),
      'assigned_title'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'category_id'                => new sfValidatorPropelChoice(array('model' => 'Category', 'column' => 'id', 'required' => false)),
      'notes'                      => new sfValidatorString(array('required' => false)),
      'duration'                   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'source_filename'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'source_file_date'           => new sfValidatorDate(array('required' => false)),
      'highquality_width'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'highquality_height'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'highquality_video_codec'    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'highquality_audio_codec'    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'highquality_picture_format' => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'highquality_frame_rate'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'highquality_aspect_ratio'   => new sfValidatorNumber(array('required' => false)),
      'highquality_md5sum'         => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'archive_id'                 => new sfValidatorPropelChoice(array('model' => 'Archive', 'column' => 'id', 'required' => false)),
      'lowquality_width'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'lowquality_height'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'lowquality_video_codec'     => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'lowquality_audio_codec'     => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'lowquality_picture_format'  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'lowquality_frame_rate'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'lowquality_md5sum'          => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'thumbnail'                  => new sfValidatorPass(array('required' => false)),
      'thumbnail_width'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'thumbnail_height'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'thumbnail_size'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'user_id'                    => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'user_id')),
      'created_at'                 => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                 => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Asset', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('asset[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Asset';
  }


}
