<?php

/**
 * PictureAsset filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePictureAssetFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'highquality_width'          => new sfWidgetFormFilterInput(),
      'highquality_height'         => new sfWidgetFormFilterInput(),
      'highquality_picture_format' => new sfWidgetFormFilterInput(),
      'lowquality_width'           => new sfWidgetFormFilterInput(),
      'lowquality_height'          => new sfWidgetFormFilterInput(),
      'lowquality_picture_format'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'highquality_width'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'highquality_height'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'highquality_picture_format' => new sfValidatorPass(array('required' => false)),
      'lowquality_width'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lowquality_height'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lowquality_picture_format'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('picture_asset_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PictureAsset';
  }

  public function getFields()
  {
    return array(
      'asset_id'                   => 'ForeignKey',
      'highquality_width'          => 'Number',
      'highquality_height'         => 'Number',
      'highquality_picture_format' => 'Text',
      'lowquality_width'           => 'Number',
      'lowquality_height'          => 'Number',
      'lowquality_picture_format'  => 'Text',
    );
  }
}
