<?php

/**
 * Binder form.
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class BinderForm extends BaseBinderForm
{

  private
    $_embedded;

  public function __construct($object=null, $options=array())
  {
    
    if(@$options['embedded']==true)
    {
      $this->_embedded = true;
    }
    parent::__construct($object, $options);
  }
  
  public function configure()
  {
    unset(
      $this['user_id'],
      $this['created_at'],
      $this['updated_at'],
      $this['is_open'],
      $this['archive_id']
    );
    
    $this->widgetSchema['event_date'] = new sfWidgetFormI18nDate(array('culture'=>sfConfig::get('sf_default_culture'), 'month_format' => 'name'));

    
    $this->widgetSchema['embedded'] = new sfWidgetFormInputHidden(array(), array('name' => 'embedded'));

    $this->setDefault('embedded', $this->_embedded);
    
    $this->validatorSchema['embedded'] = new sfValidatorPass();

    $this->validatorSchema['notes'] = new sfValidatorString(array(
      'required' => true,
    ));

    $this->validatorSchema['category_id'] = new sfValidatorPropelChoice(array('model' => 'Category', 'column' => 'id', 'required' => true));
    
    $this->validatorSchema['event_date'] = new sfValidatorDate(array('required' => true));

  }
}
