<?php

/**
 * TaskLog form base class.
 *
 * @method TaskLog getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTaskLogForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'task_name'        => new sfWidgetFormInputText(),
      'options'          => new sfWidgetFormTextarea(),
      'arguments'        => new sfWidgetFormTextarea(),
      'created_at'       => new sfWidgetFormDateTime(),
      'task_finished_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'TaskLog', 'column' => 'id', 'required' => false)),
      'task_name'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'options'          => new sfValidatorString(array('required' => false)),
      'arguments'        => new sfValidatorString(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'task_finished_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('task_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaskLog';
  }


}
