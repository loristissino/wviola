<?php

/**
 * Asset filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAssetFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'slug'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'asset_type_id'  => new sfWidgetFormPropelChoice(array('model' => 'AssetType', 'add_empty' => true)),
      'original_name'  => new sfWidgetFormFilterInput(),
      'assigned_title' => new sfWidgetFormFilterInput(),
      'md5sum'         => new sfWidgetFormFilterInput(),
      'notes'          => new sfWidgetFormFilterInput(),
      'file_date'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'slug'           => new sfValidatorPass(array('required' => false)),
      'asset_type_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AssetType', 'column' => 'id')),
      'original_name'  => new sfValidatorPass(array('required' => false)),
      'assigned_title' => new sfValidatorPass(array('required' => false)),
      'md5sum'         => new sfValidatorPass(array('required' => false)),
      'notes'          => new sfValidatorPass(array('required' => false)),
      'file_date'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('asset_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Asset';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'slug'           => 'Text',
      'asset_type_id'  => 'ForeignKey',
      'original_name'  => 'Text',
      'assigned_title' => 'Text',
      'md5sum'         => 'Text',
      'notes'          => 'Text',
      'file_date'      => 'Date',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
