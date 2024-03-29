<?php

/**
 * TaskLogEvent form base class.
 *
 * @method TaskLogEvent getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 */
abstract class BaseTaskLogEventForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'task_name'      => new sfWidgetFormInputText(),
      'options'        => new sfWidgetFormTextarea(),
      'arguments'      => new sfWidgetFormTextarea(),
      'started_at'     => new sfWidgetFormDateTime(),
      'finished_at'    => new sfWidgetFormDateTime(),
      'task_exception' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'task_name'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'options'        => new sfValidatorString(array('required' => false)),
      'arguments'      => new sfValidatorString(array('required' => false)),
      'started_at'     => new sfValidatorDateTime(array('required' => false)),
      'finished_at'    => new sfValidatorDateTime(array('required' => false)),
      'task_exception' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('task_log_event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaskLogEvent';
  }


}
