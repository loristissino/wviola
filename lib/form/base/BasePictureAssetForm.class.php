<?php

/**
 * PictureAsset form base class.
 *
 * @method PictureAsset getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePictureAssetForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'asset_id'                   => new sfWidgetFormInputHidden(),
      'highquality_width'          => new sfWidgetFormInputText(),
      'highquality_height'         => new sfWidgetFormInputText(),
      'highquality_picture_format' => new sfWidgetFormInputText(),
      'lowquality_width'           => new sfWidgetFormInputText(),
      'lowquality_height'          => new sfWidgetFormInputText(),
      'lowquality_picture_format'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'asset_id'                   => new sfValidatorPropelChoice(array('model' => 'Asset', 'column' => 'id', 'required' => false)),
      'highquality_width'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'highquality_height'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'highquality_picture_format' => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'lowquality_width'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'lowquality_height'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'lowquality_picture_format'  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('picture_asset[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PictureAsset';
  }


}
