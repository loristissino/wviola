<?php

/**
 * Archive filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseArchiveFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'slug'         => new sfWidgetFormFilterInput(),
      'archive_type' => new sfWidgetFormFilterInput(),
      'position'     => new sfWidgetFormFilterInput(),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'burned_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'user_id'      => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'md5sum'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'slug'         => new sfValidatorPass(array('required' => false)),
      'archive_type' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'position'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'burned_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'user_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUserProfile', 'column' => 'user_id')),
      'md5sum'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('archive_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Archive';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'slug'         => 'Text',
      'archive_type' => 'Number',
      'position'     => 'Number',
      'created_at'   => 'Date',
      'burned_at'    => 'Date',
      'user_id'      => 'ForeignKey',
      'md5sum'       => 'Text',
    );
  }
}
