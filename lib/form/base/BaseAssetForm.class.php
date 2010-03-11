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
      'id'                 => new sfWidgetFormInputHidden(),
      'uniqid'             => new sfWidgetFormInputText(),
      'status'             => new sfWidgetFormInputText(),
      'archive_id'         => new sfWidgetFormPropelChoice(array('model' => 'Archive', 'add_empty' => true)),
      'asset_type'         => new sfWidgetFormInputText(),
      'assigned_title'     => new sfWidgetFormInputText(),
      'category_id'        => new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => true)),
      'notes'              => new sfWidgetFormTextarea(),
      'event_date'         => new sfWidgetFormDate(),
      'source_filename'    => new sfWidgetFormInputText(),
      'source_file_date'   => new sfWidgetFormDate(),
      'source_size'        => new sfWidgetFormInputText(),
      'source_md5sum'      => new sfWidgetFormInputText(),
      'highquality_md5sum' => new sfWidgetFormInputText(),
      'lowquality_md5sum'  => new sfWidgetFormInputText(),
      'has_thumbnail'      => new sfWidgetFormInputCheckbox(),
      'thumbnail_width'    => new sfWidgetFormInputText(),
      'thumbnail_height'   => new sfWidgetFormInputText(),
      'thumbnail_size'     => new sfWidgetFormInputText(),
      'thumbnail_position' => new sfWidgetFormInputText(),
      'user_id'            => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => false)),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'Asset', 'column' => 'id', 'required' => false)),
      'uniqid'             => new sfValidatorString(array('max_length' => 50)),
      'status'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'archive_id'         => new sfValidatorPropelChoice(array('model' => 'Archive', 'column' => 'id', 'required' => false)),
      'asset_type'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'assigned_title'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'category_id'        => new sfValidatorPropelChoice(array('model' => 'Category', 'column' => 'id', 'required' => false)),
      'notes'              => new sfValidatorString(array('required' => false)),
      'event_date'         => new sfValidatorDate(array('required' => false)),
      'source_filename'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'source_file_date'   => new sfValidatorDate(array('required' => false)),
      'source_size'        => new sfValidatorInteger(array('min' => -9.22337203685E+18, 'max' => 9.22337203685E+18, 'required' => false)),
      'source_md5sum'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'highquality_md5sum' => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'lowquality_md5sum'  => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'has_thumbnail'      => new sfValidatorBoolean(array('required' => false)),
      'thumbnail_width'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'thumbnail_height'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'thumbnail_size'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'thumbnail_position' => new sfValidatorNumber(array('required' => false)),
      'user_id'            => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'user_id')),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'Asset', 'column' => array('uniqid'))),
        new sfValidatorPropelUnique(array('model' => 'Asset', 'column' => array('source_size', 'source_md5sum'))),
      ))
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
