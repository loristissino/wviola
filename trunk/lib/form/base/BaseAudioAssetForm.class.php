<?php

/**
 * AudioAsset form base class.
 *
 * @method AudioAsset getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAudioAssetForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'asset_id'                => new sfWidgetFormInputHidden(),
      'duration'                => new sfWidgetFormInputText(),
      'highquality_audio_codec' => new sfWidgetFormInputText(),
      'lowquality_audio_codec'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'asset_id'                => new sfValidatorPropelChoice(array('model' => 'Asset', 'column' => 'id', 'required' => false)),
      'duration'                => new sfValidatorNumber(array('required' => false)),
      'highquality_audio_codec' => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'lowquality_audio_codec'  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('audio_asset[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AudioAsset';
  }


}
