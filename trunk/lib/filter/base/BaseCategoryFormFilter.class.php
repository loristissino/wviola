<?php

/**
 * Category filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCategoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'shortcut' => new sfWidgetFormFilterInput(),
      'name'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'shortcut' => new sfValidatorPass(array('required' => false)),
      'name'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Category';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'shortcut' => 'Text',
      'name'     => 'Text',
    );
  }
}
