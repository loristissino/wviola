<?php

/**
 * PhotoalbumAsset form base class.
 *
 * @method PhotoalbumAsset getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 */
abstract class BasePhotoalbumAssetForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'asset_id'       => new sfWidgetFormInputHidden(),
      'pictures_count' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'asset_id'       => new sfValidatorPropelChoice(array('model' => 'Asset', 'column' => 'id', 'required' => false)),
      'pictures_count' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('photoalbum_asset[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PhotoalbumAsset';
  }


}
