<?php

/**
 * AccessLog filter form base class.
 *
 * @package    wviola
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAccessLogFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'asset_slug' => new sfWidgetFormPropelChoice(array('model' => 'Asset', 'add_empty' => true, 'key_method' => 'getSlug')),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'asset_slug' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Asset', 'column' => 'slug')),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('access_log_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AccessLog';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'asset_slug' => 'ForeignKey',
      'user_id'    => 'ForeignKey',
      'created_at' => 'Date',
    );
  }
}
