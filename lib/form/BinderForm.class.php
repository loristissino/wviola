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
  public function configure()
  {
    unset(
      $this['user_id'],
      $this['created_at'],
      $this['updated_at']
    );
  }
}
