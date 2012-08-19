<?php

/**
 * Binder form base class.
 *
 * @method Binder getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 */
abstract class BaseBinderForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'user_id'        => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => false)),
      'tagger_user_id' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'category_id'    => new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => true)),
      'title'          => new sfWidgetFormInputText(),
      'code'           => new sfWidgetFormInputText(),
      'event_date'     => new sfWidgetFormDate(),
      'is_open'        => new sfWidgetFormInputCheckbox(),
      'archive_id'     => new sfWidgetFormPropelChoice(array('model' => 'Archive', 'add_empty' => true)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'        => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'user_id')),
      'tagger_user_id' => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'user_id', 'required' => false)),
      'category_id'    => new sfValidatorPropelChoice(array('model' => 'Category', 'column' => 'id', 'required' => false)),
      'title'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'code'           => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'event_date'     => new sfValidatorDate(array('required' => false)),
      'is_open'        => new sfValidatorBoolean(array('required' => false)),
      'archive_id'     => new sfValidatorPropelChoice(array('model' => 'Archive', 'column' => 'id', 'required' => false)),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('binder[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Binder';
  }


}
