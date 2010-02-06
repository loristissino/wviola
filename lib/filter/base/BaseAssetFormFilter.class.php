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
      'slug'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'asset_type_id'           => new sfWidgetFormPropelChoice(array('model' => 'AssetType', 'add_empty' => true)),
      'assigned_title'          => new sfWidgetFormFilterInput(),
      'category_id'             => new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => true)),
      'notes'                   => new sfWidgetFormFilterInput(),
      'duration'                => new sfWidgetFormFilterInput(),
      'source_filename'         => new sfWidgetFormFilterInput(),
      'source_file_date'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'highquality_width'       => new sfWidgetFormFilterInput(),
      'highquality_height'      => new sfWidgetFormFilterInput(),
      'highquality_video_codec' => new sfWidgetFormFilterInput(),
      'highquality_audio_codec' => new sfWidgetFormFilterInput(),
      'highquality_frame_rate'  => new sfWidgetFormFilterInput(),
      'highquality_md5sum'      => new sfWidgetFormFilterInput(),
      'lowquality_width'        => new sfWidgetFormFilterInput(),
      'lowquality_height'       => new sfWidgetFormFilterInput(),
      'lowquality_video_codec'  => new sfWidgetFormFilterInput(),
      'lowquality_audio_codec'  => new sfWidgetFormFilterInput(),
      'lowquality_frame_rate'   => new sfWidgetFormFilterInput(),
      'lowquality_md5sum'       => new sfWidgetFormFilterInput(),
      'user_id'                 => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'slug'                    => new sfValidatorPass(array('required' => false)),
      'asset_type_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AssetType', 'column' => 'id')),
      'assigned_title'          => new sfValidatorPass(array('required' => false)),
      'category_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Category', 'column' => 'id')),
      'notes'                   => new sfValidatorPass(array('required' => false)),
      'duration'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'source_filename'         => new sfValidatorPass(array('required' => false)),
      'source_file_date'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'highquality_width'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'highquality_height'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'highquality_video_codec' => new sfValidatorPass(array('required' => false)),
      'highquality_audio_codec' => new sfValidatorPass(array('required' => false)),
      'highquality_frame_rate'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'highquality_md5sum'      => new sfValidatorPass(array('required' => false)),
      'lowquality_width'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lowquality_height'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lowquality_video_codec'  => new sfValidatorPass(array('required' => false)),
      'lowquality_audio_codec'  => new sfValidatorPass(array('required' => false)),
      'lowquality_frame_rate'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lowquality_md5sum'       => new sfValidatorPass(array('required' => false)),
      'user_id'                 => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUserProfile', 'column' => 'user_id')),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
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
      'id'                      => 'Number',
      'slug'                    => 'Text',
      'asset_type_id'           => 'ForeignKey',
      'assigned_title'          => 'Text',
      'category_id'             => 'ForeignKey',
      'notes'                   => 'Text',
      'duration'                => 'Number',
      'source_filename'         => 'Text',
      'source_file_date'        => 'Date',
      'highquality_width'       => 'Number',
      'highquality_height'      => 'Number',
      'highquality_video_codec' => 'Text',
      'highquality_audio_codec' => 'Text',
      'highquality_frame_rate'  => 'Number',
      'highquality_md5sum'      => 'Text',
      'lowquality_width'        => 'Number',
      'lowquality_height'       => 'Number',
      'lowquality_video_codec'  => 'Text',
      'lowquality_audio_codec'  => 'Text',
      'lowquality_frame_rate'   => 'Number',
      'lowquality_md5sum'       => 'Text',
      'user_id'                 => 'ForeignKey',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
    );
  }
}
