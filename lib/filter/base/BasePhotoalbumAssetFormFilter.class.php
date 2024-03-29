<?php

/**
 * PhotoalbumAsset filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Loris Tissino <loris.tissino@gmail.com>
 */
abstract class BasePhotoalbumAssetFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'pictures_count' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'pictures_count' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('photoalbum_asset_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PhotoalbumAsset';
  }

  public function getFields()
  {
    return array(
      'asset_id'       => 'ForeignKey',
      'pictures_count' => 'Number',
    );
  }
}
