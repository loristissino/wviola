<?php

/**
 * sfGuardUserProfile form base class.
 *
 * @method sfGuardUserProfile getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserProfileForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'     => new sfWidgetFormInputHidden(),
      'first_name'  => new sfWidgetFormInputText(),
      'last_name'   => new sfWidgetFormInputText(),
      'imported_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'user_id'     => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'first_name'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'last_name'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'imported_at' => new sfValidatorDateTime(array('required' => false)),
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
