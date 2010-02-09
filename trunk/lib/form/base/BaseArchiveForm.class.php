<?php

/**
 * Archive form base class.
 *
 * @method Archive getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseArchiveForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'slug'       => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'burned_at'  => new sfWidgetFormDateTime(),
      'user_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUserProfile', 'add_empty' => true)),
      'md5sum'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'Archive', 'column' => 'id', 'required' => false)),
      'slug'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'burned_at'  => new sfValidatorDateTime(array('required' => false)),
      'user_id'    => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'user_id', 'required' => false)),
      'md5sum'     => new sfValidatorString(array('max_length' => 32, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('archive[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Archive';
  }


}
