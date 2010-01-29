<?php

/**
 * Description form base class.
 *
 * @method Description getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseDescriptionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'picture_id' => new sfWidgetFormPropelChoice(array('model' => 'Picture', 'add_empty' => true)),
      'text'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'Description', 'column' => 'id', 'required' => false)),
      'picture_id' => new sfValidatorPropelChoice(array('model' => 'Picture', 'column' => 'id', 'required' => false)),
      'text'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('description[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Description';
  }


}
