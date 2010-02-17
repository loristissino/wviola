<?php

/**
 * VideoAsset form base class.
 *
 * @method VideoAsset getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseVideoAssetForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'asset_id'                      => new sfWidgetFormInputHidden(),
      'duration'                      => new sfWidgetFormInputText(),
      'highquality_width'             => new sfWidgetFormInputText(),
      'highquality_height'            => new sfWidgetFormInputText(),
      'highquality_video_codec'       => new sfWidgetFormInputText(),
      'highquality_video_pixelformat' => new sfWidgetFormInputText(),
      'highquality_audio_codec'       => new sfWidgetFormInputText(),
      'highquality_frame_rate'        => new sfWidgetFormInputText(),
      'highquality_aspect_ratio'      => new sfWidgetFormInputText(),
      'lowquality_width'              => new sfWidgetFormInputText(),
      'lowquality_height'             => new sfWidgetFormInputText(),
      'lowquality_video_codec'        => new sfWidgetFormInputText(),
      'lowquality_video_pixelformat'  => new sfWidgetFormInputText(),
      'lowquality_audio_codec'        => new sfWidgetFormInputText(),
      'lowquality_frame_rate'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'asset_id'                      => new sfValidatorPropelChoice(array('model' => 'Asset', 'column' => 'id', 'required' => false)),
      'duration'                      => new sfValidatorNumber(array('required' => false)),
      'highquality_width'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'highquality_height'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'highquality_video_codec'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'highquality_video_pixelformat' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'highquality_audio_codec'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'highquality_frame_rate'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'highquality_aspect_ratio'      => new sfValidatorNumber(array('required' => false)),
      'lowquality_width'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'lowquality_height'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'lowquality_video_codec'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'lowquality_video_pixelformat'  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'lowquality_audio_codec'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'lowquality_frame_rate'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('video_asset[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VideoAsset';
  }


}
