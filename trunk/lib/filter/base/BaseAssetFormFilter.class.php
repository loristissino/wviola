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
      'uniqid'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'binder_id'            => new sfWidgetFormPropelChoice(array('model' => 'Binder', 'add_empty' => true)),
      'archive_id'           => new sfWidgetFormPropelChoice(array('model' => 'Archive', 'add_empty' => true)),
      'status'               => new sfWidgetFormFilterInput(),
      'asset_type'           => new sfWidgetFormFilterInput(),
      'notes'                => new sfWidgetFormFilterInput(),
      'source_filename'      => new sfWidgetFormFilterInput(),
      'source_file_datetime' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'source_size'          => new sfWidgetFormFilterInput(),
      'source_lmd5sum'       => new sfWidgetFormFilterInput(),
      'highquality_md5sum'   => new sfWidgetFormFilterInput(),
      'highquality_size'     => new sfWidgetFormFilterInput(),
      'lowquality_md5sum'    => new sfWidgetFormFilterInput(),
      'lowquality_size'      => new sfWidgetFormFilterInput(),
      'has_thumbnail'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'thumbnail_width'      => new sfWidgetFormFilterInput(),
      'thumbnail_height'     => new sfWidgetFormFilterInput(),
      'thumbnail_size'       => new sfWidgetFormFilterInput(),
      'thumbnail_position'   => new sfWidgetFormFilterInput(),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'uniqid'               => new sfValidatorPass(array('required' => false)),
      'binder_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Binder', 'column' => 'id')),
      'archive_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Archive', 'column' => 'id')),
      'status'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'asset_type'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'notes'                => new sfValidatorPass(array('required' => false)),
      'source_filename'      => new sfValidatorPass(array('required' => false)),
      'source_file_datetime' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'source_size'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'source_lmd5sum'       => new sfValidatorPass(array('required' => false)),
      'highquality_md5sum'   => new sfValidatorPass(array('required' => false)),
      'highquality_size'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lowquality_md5sum'    => new sfValidatorPass(array('required' => false)),
      'lowquality_size'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'has_thumbnail'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'thumbnail_width'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'thumbnail_height'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'thumbnail_size'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'thumbnail_position'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
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
      'id'                   => 'Number',
      'uniqid'               => 'Text',
      'binder_id'            => 'ForeignKey',
      'archive_id'           => 'ForeignKey',
      'status'               => 'Number',
      'asset_type'           => 'Number',
      'notes'                => 'Text',
      'source_filename'      => 'Text',
      'source_file_datetime' => 'Date',
      'source_size'          => 'Number',
      'source_lmd5sum'       => 'Text',
      'highquality_md5sum'   => 'Text',
      'highquality_size'     => 'Number',
      'lowquality_md5sum'    => 'Text',
      'lowquality_size'      => 'Number',
      'has_thumbnail'        => 'Boolean',
      'thumbnail_width'      => 'Number',
      'thumbnail_height'     => 'Number',
      'thumbnail_size'       => 'Number',
      'thumbnail_position'   => 'Number',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
    );
  }
}
