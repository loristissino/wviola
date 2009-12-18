<?php

/**
 * sfGuardUserProfile filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserProfileFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'first_name' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'first_name' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }

  public function getFields()
  {
    return array(
      'first_name' => 'Text',
      'id'         => 'Number',
    );
  }
}
