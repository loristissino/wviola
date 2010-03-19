<?php

/**
 * sfGuardUserProfile form base class.
 *
 * @method sfGuardUserProfile getObject() Returns the current form's model object
 *
 * @package    wviola
 * @subpackage form
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserProfileForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'          => new sfWidgetFormInputHidden(),
      'first_name'       => new sfWidgetFormInputText(),
      'last_name'        => new sfWidgetFormInputText(),
      'imported_at'      => new sfWidgetFormDateTime(),
      'binder_user_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Binder')),
    ));

    $this->setValidators(array(
      'user_id'          => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'first_name'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'last_name'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'imported_at'      => new sfValidatorDateTime(array('required' => false)),
      'binder_user_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Binder', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['binder_user_list']))
    {
      $values = array();
      foreach ($this->object->getBinderUsers() as $obj)
      {
        $values[] = $obj->getBinderId();
      }

      $this->setDefault('binder_user_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveBinderUserList($con);
  }

  public function saveBinderUserList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['binder_user_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(BinderUserPeer::USER_ID, $this->object->getPrimaryKey());
    BinderUserPeer::doDelete($c, $con);

    $values = $this->getValue('binder_user_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new BinderUser();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setBinderId($value);
        $obj->save();
      }
    }
  }

}
