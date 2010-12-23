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
      'id'                   => new sfWidgetFormInputHidden(),
      'uniqid'               => new sfWidgetFormInputText(),
      'binder_id'            => new sfWidgetFormPropelChoice(array('model' => 'Binder', 'add_empty' => true)),
      'archive_id'           => new sfWidgetFormPropelChoice(array('model' => 'Archive', 'add_empty' => true)),
      'status'               => new sfWidgetFormInputText(),
      'asset_type'           => new sfWidgetFormInputText(),
      'notes'                => new sfWidgetFormTextarea(),
      'source_filename'      => new sfWidgetFormInputText(),
      'source_file_datetime' => new sfWidgetFormDateTime(),
      'source_size'          => new sfWidgetFormInputText(),
      'source_lmd5sum'       => new sfWidgetFormInputText(),
      'highquality_md5sum'   => new sfWidgetFormInputText(),
      'highquality_size'     => new sfWidgetFormInputText(),
      'lowquality_md5sum'    => new sfWidgetFormInputText(),
      'has_thumbnail'        => new sfWidgetFormInputCheckbox(),
      'thumbnail_width'      => new sfWidgetFormInputText(),
      'thumbnail_height'     => new sfWidgetFormInputText(),
      'thumbnail_size'       => new sfWidgetFormInputText(),
      'thumbnail_position'   => new sfWidgetFormInputText(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorPropelChoice(array('model' => 'Asset', 'column' => 'id', 'required' => false)),
      'uniqid'               => new sfValidatorString(array('max_length' => 50)),
      'binder_id'            => new sfValidatorPropelChoice(array('model' => 'Binder', 'column' => 'id', 'required' => false)),
      'archive_id'           => new sfValidatorPropelChoice(array('model' => 'Archive', 'column' => 'id', 'required' => false)),
      'status'               => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'asset_type'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'notes'                => new sfValidatorString(array('required' => false)),
      'source_filename'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'source_file_datetime' => new sfValidatorDateTime(array('required' => false)),
      'source_size'          => new sfValidatorInteger(array('min' => -9.2233720368548E+18, 'max' => 9.2233720368548E+18, 'required' => false)),
      'source_lmd5sum'       => new sfValidatorString(array('max_length' => 34, 'required' => false)),
      'highquality_md5sum'   => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'highquality_size'     => new sfValidatorInteger(array('min' => -9.2233720368548E+18, 'max' => 9.2233720368548E+18, 'required' => false)),
      'lowquality_md5sum'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'has_thumbnail'        => new sfValidatorBoolean(array('required' => false)),
      'thumbnail_width'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'thumbnail_height'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'thumbnail_size'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'thumbnail_position'   => new sfValidatorNumber(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(array('required' => false)),
      'updated_at'           => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'Asset', 'column' => array('uniqid'))),
        new sfValidatorPropelUnique(array('model' => 'Asset', 'column' => array('source_size', 'source_lmd5sum'))),
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
