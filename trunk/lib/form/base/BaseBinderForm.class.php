<?php

/**
 * Binder form base class.
 *
 * @method Binder getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseBinderForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => false)),
      'category_id' => new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => true)),
      'notes'       => new sfWidgetFormTextarea(),
      'event_date'  => new sfWidgetFormDate(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Binder', 'column' => 'id', 'required' => false)),
      'user_id'     => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'user_id')),
      'category_id' => new sfValidatorPropelChoice(array('model' => 'Category', 'column' => 'id', 'required' => false)),
      'notes'       => new sfValidatorString(array('required' => false)),
      'event_date'  => new sfValidatorDate(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
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
