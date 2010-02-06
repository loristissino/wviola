<?php

/**
 * Description filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseDescriptionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'picture_id' => new sfWidgetFormPropelChoice(array('model' => 'Picture', 'add_empty' => true)),
      'text'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'picture_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Picture', 'column' => 'id')),
      'text'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('description_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Description';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'picture_id' => 'ForeignKey',
      'text'       => 'Text',
    );
  }
}
