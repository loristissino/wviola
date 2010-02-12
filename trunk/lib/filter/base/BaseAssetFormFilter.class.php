<?php

/**
 * Asset filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAssetFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'slug'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'status'             => new sfWidgetFormFilterInput(),
      'archive_id'         => new sfWidgetFormPropelChoice(array('model' => 'Archive', 'add_empty' => true)),
      'asset_type'         => new sfWidgetFormFilterInput(),
      'assigned_title'     => new sfWidgetFormFilterInput(),
      'category_id'        => new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => true)),
      'notes'              => new sfWidgetFormFilterInput(),
      'event_date'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'source_filename'    => new sfWidgetFormFilterInput(),
      'source_file_date'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'highquality_md5sum' => new sfWidgetFormFilterInput(),
      'lowquality_md5sum'  => new sfWidgetFormFilterInput(),
      'has_thumbnail'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'thumbnail_width'    => new sfWidgetFormFilterInput(),
      'thumbnail_height'   => new sfWidgetFormFilterInput(),
      'thumbnail_size'     => new sfWidgetFormFilterInput(),
      'user_id'            => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'slug'               => new sfValidatorPass(array('required' => false)),
      'status'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'archive_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Archive', 'column' => 'id')),
      'asset_type'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'assigned_title'     => new sfValidatorPass(array('required' => false)),
      'category_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Category', 'column' => 'id')),
      'notes'              => new sfValidatorPass(array('required' => false)),
      'event_date'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'source_filename'    => new sfValidatorPass(array('required' => false)),
      'source_file_date'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'highquality_md5sum' => new sfValidatorPass(array('required' => false)),
      'lowquality_md5sum'  => new sfValidatorPass(array('required' => false)),
      'has_thumbnail'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'thumbnail_width'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'thumbnail_height'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'thumbnail_size'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUserProfile', 'column' => 'user_id')),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
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
      'id'                 => 'Number',
      'slug'               => 'Text',
      'status'             => 'Number',
      'archive_id'         => 'ForeignKey',
      'asset_type'         => 'Number',
      'assigned_title'     => 'Text',
      'category_id'        => 'ForeignKey',
      'notes'              => 'Text',
      'event_date'         => 'Date',
      'source_filename'    => 'Text',
      'source_file_date'   => 'Date',
      'highquality_md5sum' => 'Text',
      'lowquality_md5sum'  => 'Text',
      'has_thumbnail'      => 'Boolean',
      'thumbnail_width'    => 'Number',
      'thumbnail_height'   => 'Number',
      'thumbnail_size'     => 'Number',
      'user_id'            => 'ForeignKey',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
