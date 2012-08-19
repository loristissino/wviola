<?php

/**
 * Source form base class.
 *
 * @method Source getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 */
abstract class BaseSourceForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'user_id'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => false)),
      'relative_path'     => new sfWidgetFormInputText(),
      'basename'          => new sfWidgetFormInputText(),
      'status'            => new sfWidgetFormInputText(),
      'inode'             => new sfWidgetFormInputText(),
      'task_log_event_id' => new sfWidgetFormPropelChoice(array('model' => 'TaskLogEvent', 'add_empty' => true)),
      'created_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'           => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'user_id')),
      'relative_path'     => new sfValidatorString(array('max_length' => 255)),
      'basename'          => new sfValidatorString(array('max_length' => 255)),
      'status'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'inode'             => new sfValidatorInteger(array('min' => -9.2233720368548E+18, 'max' => 9.2233720368548E+18, 'required' => false)),
      'task_log_event_id' => new sfValidatorPropelChoice(array('model' => 'TaskLogEvent', 'column' => 'id', 'required' => false)),
      'created_at'        => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('source[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Source';
  }


}
