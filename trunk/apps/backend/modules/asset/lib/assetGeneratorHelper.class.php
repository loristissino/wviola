<?php

/**
 * asset module helper.
 *
 * @package    wviola
 * @subpackage asset
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: helper.php 12474 2008-10-31 10:41:27Z fabien $
 */
class assetGeneratorHelper extends BaseAssetGeneratorHelper
{
  public function linkToChangeThumbnail($object, $params)
  {
    /*
    return '<li class="sf_admin_action_changethumbnail">'.link_to(__($params['changethumbnail'], array(), 'sf_admin'), $this->getUrlForAction('edit'), $object).'</li>';
    */
    
    return '<li class="sf_admin_action_changethumbnail">'.link_to(__('Change thumbnail'), 'asset/changethumbnail?id=' . $object->getId()).'</li>';
    
  }
  
}
