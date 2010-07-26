<?php

/*
 * This file is part of the wviola package.
 * (c) Loris Tissino <loris.tissino@gmail.com>
 *
 */

/**
 * sfValidatorBinderCode validates a binder code against an external source. It also converts the input value to a string.
 *
 * @package    wviola
 * @subpackage validator
 * @author     Loris Tissino <loris.tissino@gmail.com>
 */
class sfValidatorBinderCode extends sfValidatorBase
{
  /**
   * Configures the current validator.
   *
   * Available options:
   *
   * Available error codes:
   *
   *  * invalid
   *
   * @param array $options   An array of options
   * @param array $messages  An array of error messages
   *
   * @see sfValidatorBase
   */
  protected function configure($options = array(), $messages = array())
  {
    $this->addMessage('not_found', 'Code "%value%" was not found in the external database.');

    $this->setOption('empty_value', '');
  }

  /**
   * @see sfValidatorBase
   */
  protected function doClean($value)
  {
    $clean = (string) $value;

    $length = function_exists('mb_strlen') ? mb_strlen($clean, $this->getCharset()) : strlen($clean);

    if (!BinderPeer::getCodeIsValid($clean))
    {
      throw new sfValidatorError($this, 'not_found', array('value' => $value));
    }

    return $clean;
  }
}
