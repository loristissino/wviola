<?php

/**
 * sfGuardUserProfile form base class.
 *
 * @method sfGuardUserProfile getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserProfileForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'first_name' => new sfWidgetFormInputText(),
      'id'         => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'first_name' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'id'         => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }


}
