<?php

/**
 * Source filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Loris Tissino <loris.tissino@gmail.com>
 */
abstract class BaseSourceFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'relative_path'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'basename'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'status'            => new sfWidgetFormFilterInput(),
      'inode'             => new sfWidgetFormFilterInput(),
      'task_log_event_id' => new sfWidgetFormPropelChoice(array('model' => 'TaskLogEvent', 'add_empty' => true)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'user_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUserProfile', 'column' => 'user_id')),
      'relative_path'     => new sfValidatorPass(array('required' => false)),
      'basename'          => new sfValidatorPass(array('required' => false)),
      'status'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'inode'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'task_log_event_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TaskLogEvent', 'column' => 'id')),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('source_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Source';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'user_id'           => 'ForeignKey',
      'relative_path'     => 'Text',
      'basename'          => 'Text',
      'status'            => 'Number',
      'inode'             => 'Number',
      'task_log_event_id' => 'ForeignKey',
      'created_at'        => 'Date',
    );
  }
}
