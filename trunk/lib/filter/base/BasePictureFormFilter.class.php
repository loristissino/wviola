<?php

/**
 * Picture filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
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
