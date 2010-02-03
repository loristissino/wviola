<?php

/**
 * Asset form base class.
 *
 * @method Asset getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAssetForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'slug'           => new sfWidgetFormInputText(),
      'asset_type_id'  => new sfWidgetFormPropelChoice(array('model' => 'AssetType', 'add_empty' => true)),
      'original_name'  => new sfWidgetFormInputText(),
      'assigned_title' => new sfWidgetFormInputText(),
      'md5sum'         => new sfWidgetFormInputText(),
      'notes'          => new sfWidgetFormTextarea(),
      'file_date'      => new sfWidgetFormDate(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'Asset', 'column' => 'id', 'required' => false)),
      'slug'           => new sfValidatorString(array('max_length' => 50)),
      'asset_type_id'  => new sfValidatorPropelChoice(array('model' => 'AssetType', 'column' => 'id', 'required' => false)),
      'original_name'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'assigned_title' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'md5sum'         => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'notes'          => new sfValidatorString(array('required' => false)),
      'file_date'      => new sfValidatorDate(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
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
