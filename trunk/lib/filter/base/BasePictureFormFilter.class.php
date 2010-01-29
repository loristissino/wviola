<?php

/**
 * Picture filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BasePictureFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'path' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'path' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('picture_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Picture';
  }

  public function getFields()
  {
    return array(
      'id'   => 'Number',
      'path' => 'Text',
    );
  }
}
