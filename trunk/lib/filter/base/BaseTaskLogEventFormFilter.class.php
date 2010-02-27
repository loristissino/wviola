<?php

/**
 * TaskLogEvent filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTaskLogEventFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'task_name'   => new sfWidgetFormFilterInput(),
      'options'     => new sfWidgetFormFilterInput(),
      'arguments'   => new sfWidgetFormFilterInput(),
      'started_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'finished_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'task_name'   => new sfValidatorPass(array('required' => false)),
      'options'     => new sfValidatorPass(array('required' => false)),
      'arguments'   => new sfValidatorPass(array('required' => false)),
      'started_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'finished_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('task_log_event_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaskLogEvent';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'task_name'   => 'Text',
      'options'     => 'Text',
      'arguments'   => 'Text',
      'started_at'  => 'Date',
      'finished_at' => 'Date',
    );
  }
}
