<?php

/**
 * VideoAsset filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseVideoAssetFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'duration'                 => new sfWidgetFormFilterInput(),
      'highquality_width'        => new sfWidgetFormFilterInput(),
      'highquality_height'       => new sfWidgetFormFilterInput(),
      'highquality_video_codec'  => new sfWidgetFormFilterInput(),
      'highquality_audio_codec'  => new sfWidgetFormFilterInput(),
      'highquality_frame_rate'   => new sfWidgetFormFilterInput(),
      'highquality_aspect_ratio' => new sfWidgetFormFilterInput(),
      'lowquality_width'         => new sfWidgetFormFilterInput(),
      'lowquality_height'        => new sfWidgetFormFilterInput(),
      'lowquality_video_codec'   => new sfWidgetFormFilterInput(),
      'lowquality_audio_codec'   => new sfWidgetFormFilterInput(),
      'lowquality_frame_rate'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'duration'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'highquality_width'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'highquality_height'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'highquality_video_codec'  => new sfValidatorPass(array('required' => false)),
      'highquality_audio_codec'  => new sfValidatorPass(array('required' => false)),
      'highquality_frame_rate'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'highquality_aspect_ratio' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'lowquality_width'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lowquality_height'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lowquality_video_codec'   => new sfValidatorPass(array('required' => false)),
      'lowquality_audio_codec'   => new sfValidatorPass(array('required' => false)),
      'lowquality_frame_rate'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('video_asset_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VideoAsset';
  }

  public function getFields()
  {
    return array(
      'asset_id'                 => 'ForeignKey',
      'duration'                 => 'Number',
      'highquality_width'        => 'Number',
      'highquality_height'       => 'Number',
      'highquality_video_codec'  => 'Text',
      'highquality_audio_codec'  => 'Text',
      'highquality_frame_rate'   => 'Number',
      'highquality_aspect_ratio' => 'Number',
      'lowquality_width'         => 'Number',
      'lowquality_height'        => 'Number',
      'lowquality_video_codec'   => 'Text',
      'lowquality_audio_codec'   => 'Text',
      'lowquality_frame_rate'    => 'Number',
    );
  }
}
