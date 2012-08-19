<?php

/**
 * AudioAsset filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Loris Tissino <loris.tissino@gmail.com>
 */
abstract class BaseAudioAssetFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'duration'                => new sfWidgetFormFilterInput(),
      'highquality_audio_codec' => new sfWidgetFormFilterInput(),
      'lowquality_audio_codec'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'duration'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'highquality_audio_codec' => new sfValidatorPass(array('required' => false)),
      'lowquality_audio_codec'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('audio_asset_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AudioAsset';
  }

  public function getFields()
  {
    return array(
      'asset_id'                => 'ForeignKey',
      'duration'                => 'Number',
      'highquality_audio_codec' => 'Text',
      'lowquality_audio_codec'  => 'Text',
    );
  }
}
