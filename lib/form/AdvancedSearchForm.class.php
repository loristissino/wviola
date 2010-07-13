<?php

/**
 * Asset form.
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 */
class AdvancedSearchForm extends BaseForm
{
  private $_queryString;
  
  public function __construct($queryString)
  {
    $this->_queryString = $queryString;
    parent::__construct();
  }
  
  public function getQueryString()
  {
    return $this->_queryString;
  }
  
  public function configure()
  {
    $this->setWidgets(array(
      'title'    => new sfWidgetFormInputText(),
      'binder'   => new sfWidgetFormInputText(),
      'notes'    => new sfWidgetFormInputText(),
      'date'     => new sfWidgetFormInputText(),
      'category_id' => new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => true)),
      'actionrequested'   => new sfWidgetFormInputHidden(array(), array('name' => 'actionrequested', 'value'=>'search'))
      ));
        
//    $this->setDefault('assigned_title', $query->getField('title'));
    $this->widgetSchema->setNameFormat('query[%s]');

    $this->setValidators(array(
      'title'    => new sfValidatorString(array('required' => false)),
      'binder'   => new sfValidatorString(array('required' => false)),
      'notes'    => new sfValidatorString(array('required' => false, 'min_length'=>4)),
      'date'    => new sfValidatorString(array('required' => false)),
      'category_id' => new sfValidatorPropelChoice(array('model' => 'Category', 'column' => 'id', 'required' => false)),
    ));




  }
  
}

